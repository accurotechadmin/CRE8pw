<?php

declare(strict_types=1);

namespace Cre8\Application\Auth;

use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenSigner;
use PDO;
use PDOException;

final class AuthService
{
    public function __construct(
        private readonly TokenSigner $tokenSigner,
        private readonly RuntimeConfig $config,
        private readonly AuditEmitter $auditEmitter,
        private readonly PDO $pdo,
    ) {
        $this->ensureStorageReady();
        $this->ensureDefaultOwnerSeed();
    }

    /** @return array{owner_id:string,email:string,created_at_utc:string} */
    public function registerOwner(string $email, string $password, string $requestId): array
    {
        $normalizedEmail = strtolower(trim($email));
        if ($normalizedEmail === '' || filter_var($normalizedEmail, FILTER_VALIDATE_EMAIL) === false) {
            throw new AuthException('validation_failed', [['path' => 'email', 'code' => 'invalid_format', 'message' => 'must be a valid email']]);
        }

        if (mb_strlen($password) < 12) {
            throw new AuthException('validation_failed', [['path' => 'password', 'code' => 'too_short', 'message' => 'must be at least 12 characters']]);
        }

        if ($this->ownerByEmail($normalizedEmail) !== null) {
            throw new AuthException('owner_conflict', ['reason' => 'owner_email_exists']);
        }

        $ownerId = bin2hex(random_bytes(16));
        $credentialId = bin2hex(random_bytes(16));
        $emailId = bin2hex(random_bytes(16));
        $passwordHash = password_hash($password, defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT);

        $this->pdo->beginTransaction();
        try {
            $this->insertPrincipal($ownerId, 'owner', $ownerId);
            $this->insertOwnerEmail($emailId, $ownerId, $normalizedEmail);
            $this->insertCredential($credentialId, $ownerId, 'password', $passwordHash);
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            if ($this->isUniqueViolation($e)) {
                throw new AuthException('owner_conflict', ['reason' => 'owner_email_exists']);
            }

            throw $e;
        }

        $createdAt = gmdate('c');
        $this->auditEmitter->emit('auth.owner_registered', [
            'request_id' => $requestId,
            'principal_id' => $ownerId,
            'principal_type' => 'owner',
            'outcome' => 'allow',
            'reason_code' => 'owner_created',
            'email' => $normalizedEmail,
        ]);

        return [
            'owner_id' => $ownerId,
            'email' => $normalizedEmail,
            'created_at_utc' => $createdAt,
        ];
    }

    /** @return array{access_token:string,refresh_token:string,expires_in:int} */
    public function login(string $email, string $password, string $requestId): array
    {
        $owner = $this->authenticateOwner($email, $password);
        if ($owner === null) {
            $this->auditEmitter->emit('auth.login_failed', [
                'request_id' => $requestId,
                'principal_id' => 'unknown',
                'outcome' => 'deny',
                'reason_code' => 'invalid_credentials',
            ]);

            throw new AuthException('auth_invalid');
        }

        $refresh = $this->mintRefreshToken($owner->ownerId, 'console');
        $this->auditEmitter->emit('auth.login_success', [
            'request_id' => $requestId,
            'principal_id' => $owner->ownerId,
            'outcome' => 'allow',
            'reason_code' => 'password_verified',
        ]);

        return $this->issueTokenPair($owner->ownerId, $refresh);
    }

    /** @return array{access_token:string,refresh_token:string,expires_in:int} */
    public function refresh(string $refreshToken, string $requestId): array
    {
        $rotation = $this->rotateRefreshToken($refreshToken, 'console', $requestId);
        if (!$rotation['ok']) {
            throw new AuthException('auth_invalid', ['reason' => $rotation['reason']]);
        }

        return $this->issueTokenPair($rotation['principal_id'], $rotation['refresh_token']);
    }

    /** @return array{access_token:string,refresh_token:string,expires_in:int} */
    private function issueTokenPair(string $principalId, string $refreshToken): array
    {
        return [
            'access_token' => $this->tokenSigner->sign([
                'sub' => $principalId,
                'typ' => 'owner',
                'aud' => $this->config->jwtAudienceConsole,
            ], 'access', [
                'surface' => 'console',
                'principal_type' => 'owner',
            ], 900),
            'refresh_token' => $refreshToken,
            'expires_in' => 900,
        ];
    }

    private function authenticateOwner(string $email, string $password): ?AuthOwnerRecord
    {
        $candidate = $this->ownerByEmail(strtolower(trim($email)));
        if ($candidate === null) {
            return null;
        }

        return password_verify($password, $candidate->passwordHash) ? $candidate : null;
    }

    private function ownerByEmail(string $email): ?AuthOwnerRecord
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.id AS owner_id, e.email, c.credential_hash
             FROM principal_emails e
             JOIN principals p ON p.id = e.principal_id
             JOIN credentials c ON c.principal_id = p.id AND c.credential_type = :credential_type AND c.revoked_at IS NULL
             WHERE e.email = :email AND p.principal_type = :principal_type AND p.disabled_at IS NULL'
        );
        $stmt->execute([
            'email' => $email,
            'principal_type' => 'owner',
            'credential_type' => 'password',
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!is_array($row)) {
            return null;
        }

        return new AuthOwnerRecord((string) $row['owner_id'], (string) $row['email'], (string) $row['credential_hash']);
    }

    /** @return array{refresh_token:string,family_id:string} */
    private function mintRefreshToken(string $principalId, string $surface, ?RefreshFamilyRecord $family = null): array
    {
        if ($family === null) {
            $family = new RefreshFamilyRecord(
                familyId: bin2hex(random_bytes(16)),
                principalId: $principalId,
                surface: $surface,
                state: 'active',
                currentTokenHash: '',
                previousTokenHash: null,
                consumedHashes: [],
                issuedAt: $this->dbTimestamp(),
                rotatedAt: null,
                expiresAt: $this->dbTimestamp(time() + $this->refreshTtlSeconds($surface)),
            );
        }

        $token = 'rft_' . $family->familyId . '_' . bin2hex(random_bytes(24));
        $family->currentTokenHash = $this->refreshTokenHash($token);
        $family->state = 'active';

        $stmt = $this->pdo->prepare($this->tokenFamilyUpsertSql());
        $stmt->execute([
            'id' => $family->familyId,
            'principal_id' => $family->principalId,
            'surface' => $family->surface,
            'state' => $family->state,
            'nonce' => $family->currentTokenHash,
            'previous_nonce' => $family->previousTokenHash,
            'issued_at' => $family->issuedAt,
            'rotated_at' => $family->rotatedAt,
            'expires_at' => $family->expiresAt,
        ]);

        return ['refresh_token' => $token, 'family_id' => $family->familyId];
    }

    /** @return array{ok:true,principal_id:string,refresh_token:string}|array{ok:false,reason:string,principal_id:string} */
    private function rotateRefreshToken(string $refreshToken, string $surface, string $requestId): array
    {
        $parts = explode('_', $refreshToken);
        $familyId = $parts[1] ?? '';
        $family = $this->loadRefreshFamily($familyId);

        if (!$family instanceof RefreshFamilyRecord) {
            $this->auditEmitter->emit('auth.refresh_failed', [
                'request_id' => $requestId,
                'principal_id' => 'unknown',
                'outcome' => 'deny',
                'reason_code' => 'refresh_family_not_found',
            ]);

            return ['ok' => false, 'reason' => 'refresh_invalid', 'principal_id' => 'unknown'];
        }

        if ($family->surface !== $surface) {
            return ['ok' => false, 'reason' => 'refresh_surface_mismatch', 'principal_id' => $family->principalId];
        }

        if (strtotime($family->expiresAt) <= time()) {
            $family->state = 'revoked';
            $this->saveRefreshFamily($family);

            return ['ok' => false, 'reason' => 'refresh_expired', 'principal_id' => $family->principalId];
        }

        $tokenHash = $this->refreshTokenHash($refreshToken);
        if ($family->previousTokenHash !== null && hash_equals($family->previousTokenHash, $tokenHash)) {
            $family->state = 'revoked';
            $this->saveRefreshFamily($family);
            $this->auditEmitter->emit('auth.refresh_replay_detected', [
                'request_id' => $requestId,
                'principal_id' => $family->principalId,
                'outcome' => 'deny',
                'reason_code' => 'refresh_replayed',
            ]);

            return ['ok' => false, 'reason' => 'refresh_replayed', 'principal_id' => $family->principalId];
        }

        if ($family->currentTokenHash !== $tokenHash || $family->state === 'revoked') {
            $this->auditEmitter->emit('auth.refresh_failed', [
                'request_id' => $requestId,
                'principal_id' => $family->principalId,
                'outcome' => 'deny',
                'reason_code' => 'refresh_invalid',
            ]);

            return ['ok' => false, 'reason' => 'refresh_invalid', 'principal_id' => $family->principalId];
        }

        $family->previousTokenHash = $tokenHash;
        $family->state = 'rotated';
        $family->rotatedAt = $this->dbTimestamp();
        $this->saveRefreshFamily($family);
        $rotated = $this->mintRefreshToken($family->principalId, $surface, $family);

        $this->auditEmitter->emit('auth.refresh_rotated', [
            'request_id' => $requestId,
            'principal_id' => $family->principalId,
            'outcome' => 'allow',
            'reason_code' => 'refresh_rotated',
        ]);

        return ['ok' => true, 'principal_id' => $family->principalId, 'refresh_token' => $rotated['refresh_token']];
    }

    private function refreshTokenHash(string $token): string
    {
        return hash('sha256', $token);
    }

    private function ensureStorageReady(): void
    {
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS principals (
            id CHAR(32) PRIMARY KEY,
            principal_type TEXT NOT NULL,
            owner_id CHAR(32) NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            disabled_at TEXT NULL
        )');
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS principal_emails (
            id CHAR(32) PRIMARY KEY,
            principal_id CHAR(32) NOT NULL,
            email TEXT NOT NULL UNIQUE
        )');
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS credentials (
            id CHAR(32) PRIMARY KEY,
            principal_id CHAR(32) NOT NULL,
            credential_type TEXT NOT NULL,
            credential_hash TEXT NOT NULL,
            created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
            revoked_at TEXT NULL
        )');
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
    }

    private function ensureDefaultOwnerSeed(): void
    {
        if ($this->config->appEnv !== 'local') {
            return;
        }

        $seedPassword = getenv('DEFAULT_OWNER_PASSWORD');
        if (!is_string($seedPassword) || mb_strlen(trim($seedPassword)) < 12) {
            return;
        }

        if ($this->ownerByEmail('owner@cre8.local') !== null) {
            return;
        }

        $ownerId = bin2hex(random_bytes(16));
        $this->insertPrincipal($ownerId, 'owner', $ownerId);
        $this->insertOwnerEmail(bin2hex(random_bytes(16)), $ownerId, 'owner@cre8.local');
        $this->insertCredential(
            bin2hex(random_bytes(16)),
            $ownerId,
            'password',
            password_hash($seedPassword, defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT)
        );
    }

    private function insertPrincipal(string $id, string $type, ?string $ownerId): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO principals (id, principal_type, owner_id) VALUES (:id, :principal_type, :owner_id)');
        $stmt->execute(['id' => $id, 'principal_type' => $type, 'owner_id' => $ownerId]);
    }

    private function insertOwnerEmail(string $id, string $principalId, string $email): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO principal_emails (id, principal_id, email) VALUES (:id, :principal_id, :email)');
        $stmt->execute(['id' => $id, 'principal_id' => $principalId, 'email' => $email]);
    }

    private function insertCredential(string $id, string $principalId, string $type, string $hash): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO credentials (id, principal_id, credential_type, credential_hash) VALUES (:id, :principal_id, :credential_type, :credential_hash)');
        $stmt->execute([
            'id' => $id,
            'principal_id' => $principalId,
            'credential_type' => $type,
            'credential_hash' => $hash,
        ]);
    }

    private function loadRefreshFamily(string $familyId): ?RefreshFamilyRecord
    {
        if ($familyId === '') {
            return null;
        }

        $stmt = $this->pdo->prepare('SELECT id, principal_id, surface, state, nonce, previous_nonce, issued_at, rotated_at, expires_at FROM token_families WHERE id = :id');
        $stmt->execute(['id' => $familyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!is_array($row)) {
            return null;
        }

        return new RefreshFamilyRecord(
            familyId: (string) $row['id'],
            principalId: (string) $row['principal_id'],
            surface: (string) $row['surface'],
            state: (string) $row['state'],
            currentTokenHash: (string) $row['nonce'],
            previousTokenHash: is_string($row['previous_nonce']) ? $row['previous_nonce'] : null,
            consumedHashes: [],
            issuedAt: (string) $row['issued_at'],
            rotatedAt: is_string($row['rotated_at']) ? $row['rotated_at'] : null,
            expiresAt: (string) $row['expires_at'],
        );
    }

    private function saveRefreshFamily(RefreshFamilyRecord $family): void
    {
        $stmt = $this->pdo->prepare('UPDATE token_families SET state = :state, nonce = :nonce, previous_nonce = :previous_nonce, rotated_at = :rotated_at, expires_at = :expires_at WHERE id = :id');
        $stmt->execute([
            'id' => $family->familyId,
            'state' => $family->state,
            'nonce' => $family->currentTokenHash,
            'previous_nonce' => $family->previousTokenHash,
            'rotated_at' => $family->rotatedAt,
            'expires_at' => $family->expiresAt,
        ]);
    }

    private function refreshTtlSeconds(string $surface): int
    {
        return $surface === 'gateway' ? 7 * 24 * 3600 : 30 * 24 * 3600;
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
                ON DUPLICATE KEY UPDATE state = VALUES(state), previous_nonce = VALUES(previous_nonce), nonce = VALUES(nonce), rotated_at = VALUES(rotated_at), expires_at = VALUES(expires_at)';
        }

        return 'INSERT INTO token_families (id, principal_id, surface, state, nonce, previous_nonce, issued_at, rotated_at, expires_at) VALUES (:id, :principal_id, :surface, :state, :nonce, :previous_nonce, :issued_at, :rotated_at, :expires_at)
            ON CONFLICT (id) DO UPDATE SET state = EXCLUDED.state, previous_nonce = EXCLUDED.previous_nonce, nonce = EXCLUDED.nonce, rotated_at = EXCLUDED.rotated_at, expires_at = EXCLUDED.expires_at';
    }

    private function isUniqueViolation(PDOException $e): bool
    {
        return str_contains(strtolower((string) $e->getMessage()), 'unique');
    }
}

final class AuthOwnerRecord
{
    public function __construct(
        public string $ownerId,
        public string $email,
        public string $passwordHash,
    ) {
    }
}

final class RefreshFamilyRecord
{
    /** @param array<string, bool> $consumedHashes */
    public function __construct(
        public string $familyId,
        public string $principalId,
        public string $surface,
        public string $state,
        public string $currentTokenHash,
        public ?string $previousTokenHash,
        public array $consumedHashes,
        public string $issuedAt,
        public ?string $rotatedAt,
        public string $expiresAt,
    ) {
    }
}

final class AuthException extends \RuntimeException
{
    /** @param array<string,mixed> $details */
    public function __construct(string $code, private readonly array $details = [])
    {
        parent::__construct($code);
    }

    /** @return array<string,mixed> */
    public function details(): array
    {
        return $this->details;
    }
}
