<?php

declare(strict_types=1);

namespace Cre8\Application\Auth;

use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\ApiKeyHasher;
use PDO;

final class KeyLifecycleService
{
    private const MAX_DEPTH = 3;

    public function __construct(
        private readonly PDO $pdo,
        private readonly ApiKeyHasher $apiKeyHasher,
        private readonly RuntimeConfig $config,
        private readonly AuditEmitter $auditEmitter,
    ) {
        $this->ensureStorageReady();
    }

    /** @param array{key_class?:string,parent_envelope_id?:string,permissions?:list<string>,scope?:list<string>,ttl_seconds?:int,comments_enabled?:bool} $input
     *  @return array<string,mixed>
     */
    public function issue(string $ownerId, array $input, string $requestId): array
    {
        $keyClass = (string) ($input['key_class'] ?? 'secondary_author');
        if (!in_array($keyClass, ['primary_author', 'secondary_author', 'use'], true)) {
            throw new AuthException('validation_failed', [['path' => 'key_class', 'code' => 'unknown_value', 'message' => 'unsupported key class']]);
        }

        $permissions = array_values(array_unique(array_map('strval', $input['permissions'] ?? ['posts:read'])));
        $scope = array_values(array_unique(array_map('strval', $input['scope'] ?? ['posts:all'])));
        $ttlSeconds = (int) ($input['ttl_seconds'] ?? 900);
        $commentsEnabled = (bool) ($input['comments_enabled'] ?? false);
        $parentEnvelopeId = trim((string) ($input['parent_envelope_id'] ?? ''));

        if ($keyClass === 'use' && $parentEnvelopeId === '') {
            throw new AuthException('validation_failed', [['path' => 'parent_envelope_id', 'code' => 'required', 'message' => 'use keys require an author-key parent envelope']]);
        }

        $maxTtl = $this->ttlLimitForPermissions($permissions);
        if ($ttlSeconds < 60 || $ttlSeconds > $maxTtl) {
            throw new AuthException('validation_failed', [['path' => 'ttl_seconds', 'code' => 'ttl_out_of_range', 'message' => 'ttl exceeds policy constraints']]);
        }

        if ($keyClass === 'use' && (in_array('posts:create', $permissions, true) || in_array('keys:issue', $permissions, true))) {
            throw new AuthException('validation_failed', [['path' => 'permissions', 'code' => 'use_key_permission_forbidden', 'message' => 'use key cannot include posts:create or keys:issue']]);
        }

        $depth = 0;
        $initialAuthorKeyId = '';
        if ($parentEnvelopeId !== '') {
            $parent = $this->loadEnvelope($parentEnvelopeId);
            if ($parent === null) {
                throw new AuthException('validation_failed', [['code' => 'delegation_parent_inactive', 'message' => 'parent envelope not found']]);
            }

            if ((string) ($parent['owner_id'] ?? '') !== $ownerId) {
                throw new AuthException('forbidden', [['code' => 'delegation_owner_mismatch', 'message' => 'parent envelope owner mismatch']]);
            }

            if ((int) $parent['expires_epoch'] <= time()) {
                throw new AuthException('validation_failed', [['code' => 'delegation_expiry_violation', 'message' => 'parent envelope expired']]);
            }

            $depth = (int) $parent['depth'] + 1;
            if ($depth > self::MAX_DEPTH) {
                throw new AuthException('validation_failed', [['code' => 'delegation_depth_exceeded', 'message' => 'delegation depth exceeded']]);
            }

            $parentPermissions = (array) json_decode((string) $parent['permissions_json'], true);
            $parentScope = (array) json_decode((string) $parent['scope_json'], true);
            $parentKeyClass = $this->extractScopedValue($parentScope, 'key_class', 'secondary_author');
            if ($parentKeyClass === 'use') {
                throw new AuthException('forbidden', [['code' => 'delegation_issue_forbidden', 'message' => 'use keys cannot issue child keys']]);
            }

            if ($keyClass === 'primary_author') {
                throw new AuthException('validation_failed', [['path' => 'key_class', 'code' => 'hierarchy_violation', 'message' => 'primary author keys cannot be delegated from a parent key']]);
            }

            if (!$this->isSubset($permissions, $parentPermissions)) {
                throw new AuthException('validation_failed', [['code' => 'delegation_subset_violation', 'message' => 'child permissions must be subset of parent']]);
            }

            if (!$this->isSubset($scope, $parentScope)) {
                throw new AuthException('validation_failed', [['code' => 'delegation_scope_violation', 'message' => 'child scope must be subset of parent']]);
            }

            if (in_array('keys:issue', $permissions, true) && !in_array('keys:issue', $parentPermissions, true)) {
                throw new AuthException('forbidden', [['code' => 'delegation_issue_forbidden', 'message' => 'parent cannot issue child keys']]);
            }

            $parentExpEpoch = (int) $parent['expires_epoch'];
            if (time() + $ttlSeconds > $parentExpEpoch) {
                throw new AuthException('validation_failed', [['code' => 'delegation_expiry_violation', 'message' => 'child expiry exceeds parent expiry']]);
            }

            $initialAuthorKeyId = (string) ($parent['initial_author_key_id'] ?: $parent['principal_id']);
        }

        $keyId = bin2hex(random_bytes(16));
        $credentialId = bin2hex(random_bytes(16));
        $envelopeId = bin2hex(random_bytes(16));
        $rawApiKey = 'cre8k_' . bin2hex(random_bytes(24));
        $apiHash = $this->apiKeyHasher->hash($rawApiKey);
        $expiresAtUtc = gmdate('c', time() + $ttlSeconds);
        $expiresAtDb = $this->dbTimestamp(time() + $ttlSeconds);

        if ($initialAuthorKeyId === '') {
            $initialAuthorKeyId = in_array($keyClass, ['primary_author', 'secondary_author'], true) ? $keyId : $ownerId;
        }

        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('INSERT INTO principals (id, principal_type, owner_id) VALUES (:id, :type, :owner_id)')
                ->execute(['id' => $keyId, 'type' => 'key', 'owner_id' => $ownerId]);

            $this->pdo->prepare('INSERT INTO credentials (id, principal_id, credential_type, credential_hash) VALUES (:id, :principal_id, :credential_type, :hash)')
                ->execute([
                    'id' => $credentialId,
                    'principal_id' => $keyId,
                    'credential_type' => 'api_key',
                    'hash' => $apiHash,
                ]);

            $this->pdo->prepare('INSERT INTO delegation_envelopes (id, parent_envelope_id, principal_id, scope_json, permissions_json, depth, expires_at, created_at) VALUES (:id, :parent, :principal_id, :scope_json, :permissions_json, :depth, :expires_at, :created_at)')
                ->execute([
                    'id' => $envelopeId,
                    'parent' => $parentEnvelopeId !== '' ? $parentEnvelopeId : null,
                    'principal_id' => $keyId,
                    'scope_json' => (string) json_encode(array_merge($scope, ['key_class:' . $keyClass, 'comments_enabled:' . ($commentsEnabled ? 'true' : 'false'), 'initial_author_key_id:' . $initialAuthorKeyId]), JSON_THROW_ON_ERROR),
                    'permissions_json' => (string) json_encode($permissions, JSON_THROW_ON_ERROR),
                    'depth' => $depth,
                    'expires_at' => $expiresAtDb,
                    'created_at' => $this->dbTimestamp(),
                ]);
            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        $this->auditEmitter->emit('keys.issued', [
            'request_id' => $requestId,
            'principal_id' => $ownerId,
            'issued_key_id' => $keyId,
            'key_class' => $keyClass,
            'decision' => 'allow',
            'decision_reason_code' => 'key_issued',
        ]);

        return [
            'id' => $keyId,
            'key_class' => $keyClass,
            'api_key' => $rawApiKey,
            'delegation_envelope_id' => $envelopeId,
            'parent_envelope_id' => $parentEnvelopeId !== '' ? $parentEnvelopeId : null,
            'permissions' => $permissions,
            'scope' => $scope,
            'depth' => $depth,
            'comments_enabled' => $commentsEnabled,
            'initial_author_key_id' => $initialAuthorKeyId,
            'expires_at_utc' => $expiresAtUtc,
        ];
    }

    /** @return array{access_token:string,refresh_token:string,expires_in:int,key_id:string,key_class:string,permissions:list<string>,scope:list<string>,comments_enabled:bool}|null */
    public function keyLogin(string $keyId, string $apiKey, string $requestId, callable $signer): ?array
    {
        $stmt = $this->pdo->prepare('SELECT p.id, p.disabled_at, c.credential_hash FROM principals p JOIN credentials c ON c.principal_id = p.id AND c.credential_type = :type AND c.revoked_at IS NULL WHERE p.id = :id AND p.principal_type = :principal_type LIMIT 1');
        $stmt->execute(['id' => $keyId, 'type' => 'api_key', 'principal_type' => 'key']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!is_array($row) || $row['disabled_at'] !== null) {
            return null;
        }

        if (!$this->apiKeyHasher->verify($apiKey, (string) $row['credential_hash'])) {
            return null;
        }

        $envelope = $this->loadEnvelopeForPrincipal($keyId);
        if ($envelope === null) {
            return null;
        }

        $permissions = (array) json_decode((string) $envelope['permissions_json'], true);
        $scopeRaw = (array) json_decode((string) $envelope['scope_json'], true);
        $keyClass = $this->extractScopedValue($scopeRaw, 'key_class', 'secondary_author');
        $commentsEnabled = $this->extractScopedValue($scopeRaw, 'comments_enabled', 'false') === 'true';
        $scope = array_values(array_filter($scopeRaw, static fn (string $entry): bool => !str_starts_with($entry, 'key_class:') && !str_starts_with($entry, 'comments_enabled:') && !str_starts_with($entry, 'initial_author_key_id:')));

        $refreshToken = $this->mintRefreshToken($keyId, 'gateway');
        $this->auditEmitter->emit('keys.login_success', [
            'request_id' => $requestId,
            'principal_id' => $keyId,
            'decision' => 'allow',
            'decision_reason_code' => 'api_key_verified',
        ]);

        return [
            'access_token' => $signer([
                'sub' => $keyId,
                'typ' => 'key',
                'aud' => $this->config->jwtAudienceGateway,
                'key_class' => $keyClass,
                'permissions' => $permissions,
                'scope' => $scope,
                'comments_enabled' => $commentsEnabled,
                'delegation_envelope_id' => (string) $envelope['id'],
                'initial_author_key_id' => $this->extractScopedValue($scopeRaw, 'initial_author_key_id', $keyId),
            ], 'access', ['surface' => 'gateway', 'principal_type' => 'key'], 600),
            'refresh_token' => $refreshToken,
            'expires_in' => 600,
            'key_id' => $keyId,
            'key_class' => $keyClass,
            'permissions' => $permissions,
            'scope' => $scope,
            'comments_enabled' => $commentsEnabled,
        ];
    }

    /** @return array{access_token:string,refresh_token:string,expires_in:int,key_id:string,key_class:string,permissions:list<string>,scope:list<string>,comments_enabled:bool} */
    public function refresh(string $refreshToken, string $requestId, callable $signer): array
    {
        $family = $this->loadRefreshFamily($refreshToken);
        if ($family === null || (string) $family['surface'] !== 'gateway') {
            throw new AuthException('auth_invalid', ['reason' => 'refresh_invalid']);
        }

        if (strtotime((string) $family['expires_at']) <= time()) {
            $this->saveRefreshFamily((string) $family['id'], 'revoked', (string) $family['nonce'], (string) ($family['previous_nonce'] ?? null), (string) $family['expires_at'], (string) ($family['rotated_at'] ?? null));
            throw new AuthException('auth_invalid', ['reason' => 'refresh_expired']);
        }

        $tokenHash = hash('sha256', $refreshToken);
        if (is_string($family['previous_nonce'] ?? null) && hash_equals((string) $family['previous_nonce'], $tokenHash)) {
            $this->saveRefreshFamily((string) $family['id'], 'revoked', (string) $family['nonce'], (string) ($family['previous_nonce'] ?? null), (string) $family['expires_at'], $this->dbTimestamp());
            $this->auditEmitter->emit('auth.refresh_replay_detected', [
                'request_id' => $requestId,
                'principal_id' => (string) $family['principal_id'],
                'outcome' => 'deny',
                'reason_code' => 'refresh_replayed',
            ]);
            throw new AuthException('auth_invalid', ['reason' => 'refresh_replayed']);
        }

        if (!hash_equals((string) $family['nonce'], $tokenHash) || (string) $family['state'] === 'revoked') {
            throw new AuthException('auth_invalid', ['reason' => 'refresh_invalid']);
        }

        $keyId = (string) $family['principal_id'];
        $envelope = $this->loadEnvelopeForPrincipal($keyId);
        if ($envelope === null) {
            throw new AuthException('auth_invalid', ['reason' => 'refresh_invalid']);
        }

        $scopeRaw = (array) json_decode((string) $envelope['scope_json'], true);
        $permissions = (array) json_decode((string) $envelope['permissions_json'], true);
        $keyClass = $this->extractScopedValue($scopeRaw, 'key_class', 'secondary_author');
        $commentsEnabled = $this->extractScopedValue($scopeRaw, 'comments_enabled', 'false') === 'true';
        $scope = array_values(array_filter($scopeRaw, static fn (string $entry): bool => !str_starts_with($entry, 'key_class:') && !str_starts_with($entry, 'comments_enabled:') && !str_starts_with($entry, 'initial_author_key_id:')));

        $newRefreshToken = $this->mintRefreshToken($keyId, 'gateway', (string) $family['id'], (string) $family['nonce']);
        $this->saveRefreshFamily((string) $family['id'], 'rotated', hash('sha256', $newRefreshToken), (string) $family['nonce'], $this->dbTimestamp(time() + (7 * 24 * 3600)), $this->dbTimestamp());

        $this->auditEmitter->emit('auth.refresh_rotated', [
            'request_id' => $requestId,
            'principal_id' => $keyId,
            'outcome' => 'allow',
            'reason_code' => 'refresh_rotated',
        ]);

        return [
            'access_token' => $signer([
                'sub' => $keyId,
                'typ' => 'key',
                'aud' => $this->config->jwtAudienceGateway,
                'key_class' => $keyClass,
                'permissions' => $permissions,
                'scope' => $scope,
                'comments_enabled' => $commentsEnabled,
                'delegation_envelope_id' => (string) $envelope['id'],
                'initial_author_key_id' => $this->extractScopedValue($scopeRaw, 'initial_author_key_id', $keyId),
            ], 'access', ['surface' => 'gateway', 'principal_type' => 'key'], 600),
            'refresh_token' => $newRefreshToken,
            'expires_in' => 600,
            'key_id' => $keyId,
            'key_class' => $keyClass,
            'permissions' => $permissions,
            'scope' => $scope,
            'comments_enabled' => $commentsEnabled,
        ];
    }

    public function transition(string $keyId, string $state, string $requestId): bool
    {
        if (!in_array($state, ['suspend', 'cancel', 'revoke'], true)) {
            throw new AuthException('validation_failed', [['path' => 'state', 'code' => 'unknown_value', 'message' => 'unsupported lifecycle state']]);
        }

        $stmt = $this->pdo->prepare('UPDATE principals SET disabled_at = :disabled_at WHERE id = :id AND principal_type = :type');
        $stmt->execute(['disabled_at' => $this->dbTimestamp(), 'id' => $keyId, 'type' => 'key']);
        if ($stmt->rowCount() < 1) {
            return false;
        }

        if ($state === 'revoke') {
            $this->pdo->prepare('UPDATE credentials SET revoked_at = :revoked_at WHERE principal_id = :id AND credential_type = :type')
                ->execute(['revoked_at' => $this->dbTimestamp(), 'id' => $keyId, 'type' => 'api_key']);
        }

        $this->auditEmitter->emit('keys.lifecycle_' . $state, [
            'request_id' => $requestId,
            'principal_id' => $keyId,
            'decision' => 'allow',
            'decision_reason_code' => 'key_' . $state,
        ]);

        return true;
    }

    /** @return list<array<string,mixed>> */
    public function listKeychains(string $ownerId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.id AS key_id,
                    p.disabled_at,
                    c.revoked_at,
                    d.id AS delegation_envelope_id,
                    d.parent_envelope_id,
                    d.scope_json,
                    d.permissions_json,
                    d.depth,
                    d.expires_at
             FROM principals p
             LEFT JOIN credentials c ON c.principal_id = p.id AND c.credential_type = :credential_type
             LEFT JOIN delegation_envelopes d ON d.id = (
                 SELECT d2.id FROM delegation_envelopes d2 WHERE d2.principal_id = p.id ORDER BY d2.created_at DESC LIMIT 1
             )
             WHERE p.owner_id = :owner_id AND p.principal_type = :principal_type
             ORDER BY p.created_at DESC, p.id DESC'
        );
        $stmt->execute([
            'owner_id' => $ownerId,
            'principal_type' => 'key',
            'credential_type' => 'api_key',
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return array_map(function (array $row): array {
            $scopeRaw = (array) json_decode((string) ($row['scope_json'] ?? '[]'), true);
            $permissions = (array) json_decode((string) ($row['permissions_json'] ?? '[]'), true);
            $keyClass = $this->extractScopedValue($scopeRaw, 'key_class', 'secondary_author');
            $commentsEnabled = $this->extractScopedValue($scopeRaw, 'comments_enabled', 'false') === 'true';
            $scope = array_values(array_filter($scopeRaw, static fn (string $entry): bool => !str_starts_with($entry, 'key_class:') && !str_starts_with($entry, 'comments_enabled:') && !str_starts_with($entry, 'initial_author_key_id:')));

            return [
                'key_id' => (string) $row['key_id'],
                'status' => $row['disabled_at'] === null && $row['revoked_at'] === null ? 'active' : 'inactive',
                'key_class' => $keyClass,
                'permissions' => array_values(array_map('strval', $permissions)),
                'scope' => array_values(array_map('strval', $scope)),
                'comments_enabled' => $commentsEnabled,
                'delegation_envelope_id' => isset($row['delegation_envelope_id']) ? (string) $row['delegation_envelope_id'] : null,
                'parent_envelope_id' => isset($row['parent_envelope_id']) ? (string) $row['parent_envelope_id'] : null,
                'depth' => isset($row['depth']) ? (int) $row['depth'] : 0,
                'expires_at_utc' => isset($row['expires_at']) ? gmdate('c', strtotime((string) $row['expires_at']) ?: time()) : null,
            ];
        }, $rows);
    }

    /** @param array<string,mixed> $input
     *  @return array<string,mixed>
     */
    public function createInvite(string $ownerId, array $input, string $requestId): array
    {
        $email = strtolower(trim((string) ($input['email'] ?? '')));
        if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new AuthException('validation_failed', [['path' => 'email', 'code' => 'invalid_format', 'message' => 'must be a valid email']]);
        }

        $ttlSeconds = isset($input['ttl_seconds']) ? (int) $input['ttl_seconds'] : 86400;
        if ($ttlSeconds < 300 || $ttlSeconds > 7 * 24 * 3600) {
            throw new AuthException('validation_failed', [['path' => 'ttl_seconds', 'code' => 'ttl_out_of_range', 'message' => 'must be between 300 and 604800 seconds']]);
        }

        $inviteId = bin2hex(random_bytes(16));
        $inviteCode = 'inv_' . bin2hex(random_bytes(24));
        $createdAt = $this->dbTimestamp();
        $expiresAt = $this->dbTimestamp(time() + $ttlSeconds);

        $this->pdo->prepare('INSERT INTO invite_receipts (id, owner_id, invitee_email, invite_code_hash, created_at, expires_at, consumed_at) VALUES (:id, :owner_id, :invitee_email, :invite_code_hash, :created_at, :expires_at, :consumed_at)')
            ->execute([
                'id' => $inviteId,
                'owner_id' => $ownerId,
                'invitee_email' => $email,
                'invite_code_hash' => hash('sha256', $inviteCode),
                'created_at' => $createdAt,
                'expires_at' => $expiresAt,
                'consumed_at' => null,
            ]);

        $this->auditEmitter->emit('invites.created', [
            'request_id' => $requestId,
            'principal_id' => $ownerId,
            'invite_id' => $inviteId,
            'invitee_email' => $email,
            'decision' => 'allow',
            'decision_reason_code' => 'invite_created',
        ]);

        return [
            'invite_id' => $inviteId,
            'invitee_email' => $email,
            'invite_code' => $inviteCode,
            'status' => 'created',
            'created_at_utc' => gmdate('c', strtotime($createdAt) ?: time()),
            'expires_at_utc' => gmdate('c', strtotime($expiresAt) ?: time()),
        ];
    }

    /** @return array<string,mixed>|null */
    private function loadEnvelope(string $envelopeId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT d.id, d.parent_envelope_id, d.principal_id, d.scope_json, d.permissions_json, d.depth, d.expires_at, p.owner_id FROM delegation_envelopes d JOIN principals p ON p.id = d.principal_id WHERE d.id = :id LIMIT 1');
        $stmt->execute(['id' => $envelopeId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            return null;
        }

        $row['expires_epoch'] = (string) max(0, strtotime((string) $row['expires_at']));

        return $row;
    }

    /** @return array<string,mixed>|null */
    private function loadEnvelopeForPrincipal(string $principalId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, scope_json, permissions_json FROM delegation_envelopes WHERE principal_id = :id ORDER BY created_at DESC LIMIT 1');
        $stmt->execute(['id' => $principalId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return is_array($row) ? $row : null;
    }

    private function ttlLimitForPermissions(array $permissions): int
    {
        if (array_intersect($permissions, ['keys:issue', 'keys:revoke']) !== []) {
            return 900;
        }

        if (array_intersect($permissions, ['posts:create', 'comments:create']) !== []) {
            return 3600;
        }

        return 86400;
    }

    private function isSubset(array $child, array $parent): bool
    {
        return array_values(array_diff($child, $parent)) === [];
    }

    private function extractScopedValue(array $scope, string $prefix, string $default): string
    {
        foreach ($scope as $entry) {
            if (str_starts_with((string) $entry, $prefix . ':')) {
                return substr((string) $entry, strlen($prefix) + 1);
            }
        }

        return $default;
    }

    private function ensureStorageReady(): void
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS token_families (
            id CHAR(32) PRIMARY KEY,
            principal_id CHAR(32) NOT NULL,
            surface TEXT NOT NULL,
            state TEXT NOT NULL,
            nonce TEXT NOT NULL,
            previous_nonce TEXT NULL,
            issued_at TEXT NOT NULL,
            rotated_at TEXT NULL,
            expires_at TEXT NOT NULL
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS delegation_envelopes (
            id CHAR(32) PRIMARY KEY,
            parent_envelope_id CHAR(32) NULL,
            principal_id CHAR(32) NOT NULL,
            scope_json TEXT NOT NULL,
            permissions_json TEXT NOT NULL,
            depth INTEGER NOT NULL,
            expires_at TEXT NOT NULL,
            created_at TEXT NOT NULL
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS invite_receipts (
            id CHAR(32) PRIMARY KEY,
            owner_id CHAR(32) NOT NULL,
            invitee_email TEXT NOT NULL,
            invite_code_hash TEXT NOT NULL,
            created_at TEXT NOT NULL,
            expires_at TEXT NOT NULL,
            consumed_at TEXT NULL
        )');
    }

    private function mintRefreshToken(string $principalId, string $surface, ?string $familyId = null, ?string $previousNonce = null): string
    {
        $familyId ??= bin2hex(random_bytes(16));
        $token = 'rft_' . $familyId . '_' . bin2hex(random_bytes(24));
        $hash = hash('sha256', $token);
        $expiresAt = $this->dbTimestamp(time() + (7 * 24 * 3600));

        $this->pdo->prepare($this->tokenFamilyUpsertSql())
            ->execute([
                'id' => $familyId,
                'principal_id' => $principalId,
                'surface' => $surface,
                'state' => 'active',
                'nonce' => $hash,
                'previous_nonce' => $previousNonce,
                'issued_at' => $this->dbTimestamp(),
                'rotated_at' => null,
                'expires_at' => $expiresAt,
            ]);

        return $token;
    }

    /** @return array<string,mixed>|null */
    private function loadRefreshFamily(string $refreshToken): ?array
    {
        $parts = explode('_', $refreshToken);
        $familyId = $parts[1] ?? '';
        if ($familyId === '') {
            return null;
        }

        $stmt = $this->pdo->prepare('SELECT id, principal_id, surface, state, nonce, previous_nonce, issued_at, rotated_at, expires_at FROM token_families WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $familyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return is_array($row) ? $row : null;
    }

    private function saveRefreshFamily(string $familyId, string $state, string $nonce, ?string $previousNonce, string $expiresAt, ?string $rotatedAt): void
    {
        $this->pdo->prepare('UPDATE token_families SET state = :state, nonce = :nonce, previous_nonce = :previous_nonce, rotated_at = :rotated_at, expires_at = :expires_at WHERE id = :id')
            ->execute([
                'id' => $familyId,
                'state' => $state,
                'nonce' => $nonce,
                'previous_nonce' => $previousNonce,
                'rotated_at' => $rotatedAt,
                'expires_at' => $expiresAt,
            ]);
    }

    private function dbTimestamp(?int $unixTime = null): string
    {
        return gmdate('Y-m-d H:i:s', $unixTime ?? time());
    }

    private function tokenFamilyUpsertSql(): string
    {
        $driver = (string) $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            return 'INSERT INTO token_families (id, principal_id, surface, state, nonce, previous_nonce, issued_at, rotated_at, expires_at) VALUES (:id, :principal_id, :surface, :state, :nonce, :previous_nonce, :issued_at, :rotated_at, :expires_at)
                ON DUPLICATE KEY UPDATE principal_id = VALUES(principal_id), surface = VALUES(surface), state = VALUES(state), previous_nonce = VALUES(previous_nonce), nonce = VALUES(nonce), rotated_at = VALUES(rotated_at), expires_at = VALUES(expires_at)';
        }

        return 'INSERT INTO token_families (id, principal_id, surface, state, nonce, previous_nonce, issued_at, rotated_at, expires_at) VALUES (:id, :principal_id, :surface, :state, :nonce, :previous_nonce, :issued_at, :rotated_at, :expires_at)
            ON CONFLICT (id) DO UPDATE SET principal_id = EXCLUDED.principal_id, surface = EXCLUDED.surface, state = EXCLUDED.state, previous_nonce = EXCLUDED.previous_nonce, nonce = EXCLUDED.nonce, rotated_at = EXCLUDED.rotated_at, expires_at = EXCLUDED.expires_at';
    }
}
