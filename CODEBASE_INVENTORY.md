# Codebase Inventory

Total files inventoried: **66**.

This document lists every file in the repository and includes its full current contents.

## `composer.json`
- **Line count:** 55

```json
{
  "name": "cre8/platform",
  "description": "CRE8 PHP runtime",
  "type": "project",
  "license": "proprietary",
  "require": {
    "php": "^8.2",
    "slim/slim": "^4.14",
    "slim/psr7": "^1.7",
    "php-di/php-di": "^7.0",
    "firebase/php-jwt": "^6.11",
    "ext-pdo": "*",
    "ext-sodium": "*",
    "respect/validation": "^2.4",
    "vlucas/phpdotenv": "^5.6",
    "guzzlehttp/guzzle": "^7.10",
    "neomerx/cors-psr7": "^3.0",
    "monolog/monolog": "^3.9",
    "symfony/rate-limiter": "^7.3",
    "symfony/cache": "^7.3"
  },
  "require-dev": {
    "phpunit/phpunit": "^11.5"
  },
  "autoload": {
    "psr-4": {
      "Cre8\\": "src/"
    }
  },
  "autoload-dev": {
    "psr-4": {
      "Cre8\\Tests\\": "tests/"
    }
  },
  "config": {
    "sort-packages": true,
    "platform": {
      "php": "8.2.0"
    }
  },
  "scripts": {
    "test": "phpunit",
    "test:contract": "phpunit tests/Contract",
    "test:security": "phpunit tests/Security",
    "qa": [
      "@php -v",
      "@composer validate --strict",
      "@composer check-platform-reqs",
      "@composer test"
    ],
    "ops:health-smoke": "@php scripts/health_smoke.php",
    "ops:migrate-smoke": "@php scripts/migrate_smoke.php"
  }
}
```

## `dot.env`
- **Line count:** 34

```dotenv
# CRE8 scaffold local-development environment example.
# Copy to `.env.local` (or equivalent) and replace all placeholder values before use.

APP_ENV=local

# Database DSN must use sqlite:, mysql:, or pgsql: scheme.
DB_DSN=mysql:host=127.0.0.1;port=3306;dbname=sitkaotw_xtra_beta001
DB_USER=sitkaotw_xtra_beta_user
DB_PASS=K$WdQAw9YABu

# Stage/prod JWT issuer must be HTTPS.
JWT_ISSUER=https://cre8.pw
JWT_AUDIENCE_CONSOLE=console
JWT_AUDIENCE_GATEWAY=gateway

# Use file-based key paths for local development to avoid committing inline secrets.
# Allowed format: filesystem-safe path characters [a-zA-Z0-9._/-].
JWT_PRIVATE_KEY=/home/sitkaotw/cre8.pw/php/secrets/jwt/private.pem
JWT_PUBLIC_KEY=/home/sitkaotw/cre8.pw/php/secrets/jwt/public.pem

# Local profile examples:
# local: CORS_ALLOWED_ORIGINS=* OR explicit origin list.
# stage/prod: wildcard (*) is disallowed.
CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:4173

# At least 32 characters.
CSRF_SECRET=12312312312312312312312312312312

# Optional runtime policy overrides (positive integers only when set).
RATE_LIMIT_GLOBAL_LIMIT=120
JWT_OWNER_TTL_SECONDS=900
JWT_KEY_TTL_SECONDS=900
JWT_DELEGATION_TTL_SECONDS=300
```

## `public/index.php`
- **Line count:** 97

```php
<?php

declare(strict_types=1);

use Cre8\Bootstrap\AppFactory;
use Cre8\Bootstrap\BootChecks;
use Cre8\Bootstrap\ContainerFactory;
use Cre8\Config\RuntimeConfig;
use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

/**
 * @return array<string, string|false>
 */
function loadRuntimeEnv(): array
{
    $env = $_ENV + $_SERVER;

    $requiredKeys = [
        'APP_ENV',
        'DB_DSN',
        'DB_USER',
        'DB_PASS',
        'JWT_ISSUER',
        'JWT_AUDIENCE_CONSOLE',
        'JWT_AUDIENCE_GATEWAY',
        'JWT_PRIVATE_KEY',
        'JWT_PUBLIC_KEY',
        'CORS_ALLOWED_ORIGINS',
        'CSRF_SECRET',
        'RATE_LIMIT_GLOBAL_ID',
        'RATE_LIMIT_GLOBAL_POLICY',
        'RATE_LIMIT_GLOBAL_INTERVAL',
        'RATE_LIMIT_GLOBAL_LIMIT',
        'JWT_OWNER_TTL_SECONDS',
        'JWT_KEY_TTL_SECONDS',
        'JWT_DELEGATION_TTL_SECONDS',
    ];

    foreach ($requiredKeys as $key) {
        if (($env[$key] ?? false) !== false) {
            continue;
        }

        $value = getenv($key);
        if ($value !== false) {
            $env[$key] = $value;
        }
    }

    return $env;
}

try {
    Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

    $config = RuntimeConfig::fromEnv(loadRuntimeEnv());
    $container = ContainerFactory::build($config);
    BootChecks::assert($container, $config);

    error_log((string) json_encode([
        'event' => 'boot.startup_ready',
        'timestamp_utc' => gmdate('c'),
        'app_env' => $config->appEnv,
        'outcome' => 'ok',
    ], JSON_THROW_ON_ERROR));

    $app = AppFactory::create($container);
    $app->run();
} catch (\Throwable $e) {
    $requestId = bin2hex(random_bytes(8));
    error_log((string) json_encode([
        'event' => 'boot.startup_failed',
        'timestamp_utc' => gmdate('c'),
        'outcome' => 'error',
        'request_id' => $requestId,
        'error_class' => $e::class,
        'error_message' => $e->getMessage(),
    ], JSON_THROW_ON_ERROR));

    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    header('X-Request-Id: ' . $requestId);
    echo (string) json_encode([
        'error' => [
            'code' => 'boot_failed',
            'message' => 'application startup failed',
            'details' => [],
            'request_id' => $requestId,
        ],
        'meta' => [
            'timestamp_utc' => gmdate('c'),
            'request_id' => $requestId,
        ],
    ], JSON_THROW_ON_ERROR);
}
```

## `scripts/health_smoke.php`
- **Line count:** 61

```php
<?php

declare(strict_types=1);

$baseUrl = (string) ($_ENV['CRE8_HEALTHCHECK_URL'] ?? $_SERVER['CRE8_HEALTHCHECK_URL'] ?? 'http://127.0.0.1:8080');
$baseUrl = rtrim($baseUrl, '/');
$url = $baseUrl . '/health';

if (!function_exists('curl_init')) {
    fwrite(STDERR, "health_smoke_failed:curl_extension_missing\n");
    exit(2);
}

$ch = curl_init($url);
if ($ch === false) {
    fwrite(STDERR, "health_smoke_failed:curl_init\n");
    exit(2);
}

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTPHEADER => ['Accept: application/json'],
]);

$body = curl_exec($ch);
$error = curl_error($ch);
$statusCode = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

if (!is_string($body)) {
    fwrite(STDERR, "health_smoke_failed:http_error:" . $error . "\n");
    exit(3);
}

if ($statusCode !== 200) {
    fwrite(STDERR, "health_smoke_failed:unexpected_status:$statusCode\n");
    exit(4);
}

$decoded = json_decode($body, true);
if (!is_array($decoded)) {
    fwrite(STDERR, "health_smoke_failed:invalid_json\n");
    exit(5);
}

$data = $decoded['data'] ?? null;
if (!is_array($data)) {
    fwrite(STDERR, "health_smoke_failed:missing_data_envelope\n");
    exit(6);
}

$status = (string) ($data['status'] ?? '');
if (!in_array($status, ['ok', 'degraded'], true)) {
    fwrite(STDERR, "health_smoke_failed:invalid_status:$status\n");
    exit(7);
}

echo "health_smoke_ok:$status\n";
```

## `scripts/migrate_smoke.php`
- **Line count:** 44

```php
<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$migration = $root . '/db/migrations/0001_init.sql';
if (!is_file($migration)) {
    fwrite(STDERR, "migration_missing\n");
    exit(1);
}

$pdo = new PDO('sqlite::memory:');
$sql = (string) file_get_contents($migration);
$sql = (string) preg_replace('/^--.*$/m', '', $sql);
$normalized = str_replace(['TIMESTAMPTZ', 'JSONB', 'NOW()'], ['TEXT', 'TEXT', "CURRENT_TIMESTAMP"], $sql);
$normalized = preg_replace('/ON UPDATE CASCADE/', '', (string) $normalized);
$normalized = preg_replace('/\bUUID\b/', 'TEXT', (string) $normalized);

$statements = array_filter(array_map('trim', explode(';', (string) $normalized)));
foreach ($statements as $statement) {
    if (str_starts_with($statement, '--')) {
        continue;
    }

    if (str_starts_with(strtoupper($statement), 'ALTER TABLE')) {
        continue;
    }

    if ($statement !== '') {
        $pdo->exec($statement);
    }
}

$requiredTables = ['principals', 'principal_emails', 'credentials', 'token_families', 'delegation_envelopes', 'posts', 'comments', 'audit_events'];
foreach ($requiredTables as $table) {
    $q = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='" . $table . "'");
    if ($q === false || $q->fetchColumn() === false) {
        fwrite(STDERR, "missing_table:$table\n");
        exit(2);
    }
}

echo "migration_smoke_ok\n";
```

## `secrets/jwt/private.pem`
- **Line count:** 28

```pem
-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEA4g8FKP2ALOjVgeM03fW3u83DnriyF+mP8POSJnOeVsCMLXSf
16Ls3Mz8PDEgDuDFfFICYWYX9m1Ek9UwOTrFZPfOVFZMg6hcB23+YNSgGAK4gSEf
y7LvaGAqKYJVQ2k/ud32Mfj6dfxq9bnCGRZcxsXeKi0HeXp1A428zHBG5BZNeIV+
iJ5LwJg7yB5LROK8otxzrv1OkIDYqZCo/acZEmMkJ2b13J7nsUyd3iwXsJOdgxiN
MoCY17RqCzK2D9xoO0GQCumKxcPC+9Jd4oG6iBYeGBZkTVNiEIrtnrsDFVYty5jV
/4RTpCJk0Uqz6st/37SsvhjSQuFrmPOSjJMOeQIDAQABAoIBAGc96uJknGRmVhSD
GwMAFNCt0disi5HGNtoZs7bh+P+v4pVj/RhzrW/OIqiu2vBQkYEMx0+KXAlMsBRA
Okz43WwWjOIRo9JBUv6Fqra4hQFSRMecxDO43gQyXy8j+iLWb6dIiwcZqfG2vXbK
Rq5Ee0zA0405kX9WgRiFZCOOZ6IE/ZI6RQFPrNvOQrFZD4D3jYkhGMnuP/l1hp7p
kBfg+ZHSnu49pLjeMP/mEK7JRw5E2GubDCDHXBaKIeBV21xCpgQnA20E6+oimEMF
M72rSL1AxzzBRnNGnd+vZw4+DrYXZVqX6GWBTiu3X3NvrYVOeoeax36veyvjN2Oj
sNj/3QECgYEA/FEteOvmvPLeMGGAr9VBeChaVyVYzN3QfBPSs+1NOpIY0tv6mNjO
4O8+nOPAfCXTeW1esDSoNXaFBfNXFLMujWCVkxAp07rijPJVzabWeMQ9f+4ZlgQc
UA88CTbo63f9y+Dd0vX24rrSN7pcc6rOb7NtDR67WddzaSkNiY3u6NkCgYEA5Vu5
SxMgp9wco6ovvr4cobnjn/9DYSgDx0eo+gm2nTWPohrHBof1D+Igvz23Od7clRVU
HnUwkiGXddzCSlWN7JYVxE6XTXjmt0AnRl7UhYsBy93g5UWSKsfUYZTyAzBT5ZuN
mHI8O6kBzbMU78Qs29hP8dsOhwIHGO7IHwEUzqECgYBHz2K9s4Xr6MNLybQyVuNX
K0Tq4HoxdD/N0GZ7RuJf9QyTln/v2GSop+6OAFPcAXf6ayIzzAjDjoO1edgi0AxD
uGVZgZQl6l5n9uBsszr/C/rk2gL2Kx1Tu8I+bR5FRdU5nToEvHQTe1AxBB0j3kz6
hXpX7ZMssqDqIQD1USvZoQKBgQDCXlgJ4lzTRDrVDB3IJK548+KOLbH5PQLut7Dg
rKigU8q0UsMFquQoILclunRzS4VdpiSSZzfRLzx++qWAfz52F768jOm2EtZax7hA
745k2aedEBxN0AaN0KkQRTxPLX5737ZAUdbvrEtF+hStGG/3ozokuUJ3cWV4YKsh
czYh4QKBgD4BR1G2sNqfq6onlUa4jkw3UsFjcEyJ7zsmUo6ZtRbJSxCSVyYFmHJh
lp7/MCdgUD16W6VlSdpPU8qltfHFz1vZ0DKZlKpBCtiYzEUsYYQbsHpHDdJfrEDg
1JNPo6aq1CgQ2IrMCaM4gRumYbvkSYZWHp1UGFf41jrnuqHHb1Bd
-----END RSA PRIVATE KEY-----
```

## `secrets/jwt/public.pem`
- **Line count:** 10

```pem
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4g8FKP2ALOjVgeM03fW3
u83DnriyF+mP8POSJnOeVsCMLXSf16Ls3Mz8PDEgDuDFfFICYWYX9m1Ek9UwOTrF
ZPfOVFZMg6hcB23+YNSgGAK4gSEfy7LvaGAqKYJVQ2k/ud32Mfj6dfxq9bnCGRZc
xsXeKi0HeXp1A428zHBG5BZNeIV+iJ5LwJg7yB5LROK8otxzrv1OkIDYqZCo/acZ
EmMkJ2b13J7nsUyd3iwXsJOdgxiNMoCY17RqCzK2D9xoO0GQCumKxcPC+9Jd4oG6
iBYeGBZkTVNiEIrtnrsDFVYty5jV/4RTpCJk0Uqz6st/37SsvhjSQuFrmPOSjJMO
eQIDAQAB
-----END PUBLIC KEY-----
```

## `src/Application/Auth/AuthService.php`
- **Line count:** 468

```php
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
            password_hash('owner-pass', defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT)
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
```

## `src/Application/Auth/KeyLifecycleService.php`
- **Line count:** 482

```php
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
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

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
```

## `src/Application/Feed/FeedService.php`
- **Line count:** 82

```php
<?php

declare(strict_types=1);

namespace Cre8\Application\Feed;

use Cre8\Application\Posts\PostsService;

final class FeedService
{
    public function __construct(private readonly PostsService $postsService)
    {
    }

    /** @return array{items:list<array<string,string>>,next_cursor:?string,limit:int} */
    public function list(string $scope, int $limit, ?string $cursor): array
    {
        $items = $this->postsService->listVisible($scope);
        $sliceStart = $this->resolveStartIndex($items, $cursor);
        $seen = [];
        $slice = [];
        for ($i = $sliceStart; $i < count($items) && count($slice) < $limit; $i++) {
            $id = (string) ($items[$i]['id'] ?? '');
            if ($id === '' || isset($seen[$id])) {
                continue;
            }
            $seen[$id] = true;
            $slice[] = $items[$i];
        }

        $last = $slice[count($slice) - 1] ?? null;
        $nextCursor = null;
        if ($last !== null && ($sliceStart + count($slice)) < count($items)) {
            $nextCursor = $this->encodeCursor((string) $last['created_at_utc'], (string) $last['id']);
        }

        return [
            'items' => $slice,
            'next_cursor' => $nextCursor,
            'limit' => $limit,
        ];
    }

    /** @param list<array<string,string>> $items */
    private function resolveStartIndex(array $items, ?string $cursor): int
    {
        if ($cursor === null || $cursor === '') {
            return 0;
        }

        $decoded = base64_decode(strtr($cursor, '-_', '+/'), true);
        if ($decoded === false) {
            return 0;
        }

        $parts = json_decode($decoded, true);
        if (!is_array($parts) || !is_string($parts['created_at_utc'] ?? null) || !is_string($parts['id'] ?? null)) {
            return 0;
        }

        foreach ($items as $index => $item) {
            $createdAt = (string) ($item['created_at_utc'] ?? '');
            $id = (string) ($item['id'] ?? '');
            if ($createdAt === (string) $parts['created_at_utc'] && $id === (string) $parts['id']) {
                return $index + 1;
            }
        }

        return 0;
    }

    private function encodeCursor(string $createdAtUtc, string $id): string
    {
        $payload = json_encode([
            'created_at_utc' => $createdAtUtc,
            'id' => $id,
        ], JSON_THROW_ON_ERROR);

        return rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
    }
}
```

## `src/Application/Health/HealthService.php`
- **Line count:** 78

```php
<?php

declare(strict_types=1);

namespace Cre8\Application\Health;

use Cre8\Config\RuntimeConfig;
use Cre8\Security\KeyMaterial;
use GuzzleHttp\ClientInterface;
use PDO;
use Symfony\Component\RateLimiter\RateLimiterFactory;

final class HealthService
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly ClientInterface $httpClient,
        private readonly RateLimiterFactory $rateLimiterFactory,
        private readonly RuntimeConfig $config,
    ) {
    }

    /** @return array<string,mixed> */
    public function check(): array
    {
        $started = microtime(true);
        $failures = [];
        $db = ['status' => 'down'];
        try {
            $dbOk = (bool) $this->pdo->query('SELECT 1')->fetchColumn();
            $db = ['status' => $dbOk ? 'ok' : 'down'];
            if (!$dbOk) {
                $failures[] = 'db_probe_false';
            }
        } catch (\Throwable $e) {
            $db = ['status' => 'down', 'error' => $e::class];
            $failures[] = 'db_probe_exception';
        }

        $limiter = ['status' => 'down'];
        try {
            $accepted = $this->rateLimiterFactory->create('healthcheck')->consume(1)->isAccepted();
            $limiter = ['status' => $accepted ? 'ok' : 'degraded'];
            if (!$accepted) {
                $failures[] = 'rate_limiter_rejected';
            }
        } catch (\Throwable $e) {
            $limiter = ['status' => 'down', 'error' => $e::class];
            $failures[] = 'rate_limiter_exception';
        }

        $keyMaterial = ['status' => 'down'];
        try {
            KeyMaterial::resolve($this->config->jwtPrivateKey);
            KeyMaterial::resolve($this->config->jwtPublicKey);
            $keyMaterial = ['status' => 'ok'];
        } catch (\Throwable $e) {
            $keyMaterial = ['status' => 'down', 'error' => $e::class];
            $failures[] = 'key_material_unavailable';
        }

        $status = $failures === [] ? 'ok' : 'degraded';

        return [
            'status' => $status,
            'checked_at_utc' => gmdate('c'),
            'latency_ms' => (int) round((microtime(true) - $started) * 1000),
            'failures' => $failures,
            'services' => [
                'db' => $db,
                'rate_limiter' => $limiter,
                'key_material' => $keyMaterial,
                'http_client' => $this->httpClient::class,
            ],
        ];
    }
}
```

## `src/Application/Posts/CommentsService.php`
- **Line count:** 100

```php
<?php

declare(strict_types=1);

namespace Cre8\Application\Posts;

use Cre8\Observability\AuditEmitter;
use PDO;

final class CommentsService
{
    public function __construct(private readonly PDO $pdo, private readonly AuditEmitter $auditEmitter)
    {
        $this->ensureStorageReady();
    }

    /** @return list<array{id:string,post_id:string,author_id:string,body:string,state:string,created_at_utc:string}> */
    public function listForPost(string $postId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, post_id, author_principal_id, body_text, state, created_at FROM comments WHERE post_id = :post AND state != :deleted ORDER BY created_at ASC, id ASC');
        $stmt->execute(['post' => $postId, 'deleted' => 'deleted']);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return array_map(static function (array $row): array {
            $createdAtRaw = (string) $row['created_at'];
            $createdAt = strtotime($createdAtRaw);

            return [
                'id' => (string) $row['id'],
                'post_id' => (string) $row['post_id'],
                'author_id' => (string) $row['author_principal_id'],
                'body' => (string) $row['body_text'],
                'state' => (string) $row['state'],
                'created_at_utc' => $createdAt === false ? $createdAtRaw : gmdate('c', $createdAt),
            ];
        }, $rows);
    }

    /** @return array{id:string,post_id:string,author_id:string,body:string,state:string,created_at_utc:string} */
    public function create(string $postId, string $authorId, string $body, string $requestId): array
    {
        $id = bin2hex(random_bytes(16));
        $createdAt = $this->dbTimestamp();
        $normalizedBody = trim($body);

        $stmt = $this->pdo->prepare('INSERT INTO comments (id, post_id, author_principal_id, body_text, state, created_at) VALUES (:id, :post_id, :author_id, :body_text, :state, :created_at)');
        $stmt->execute([
            'id' => $id,
            'post_id' => $postId,
            'author_id' => $authorId,
            'body_text' => $normalizedBody,
            'state' => 'active',
            'created_at' => $createdAt,
        ]);

        $this->auditEmitter->emit('comments.created', [
            'request_id' => $requestId,
            'principal_id' => $authorId,
            'post_id' => $postId,
            'comment_id' => $id,
            'decision' => 'allow',
            'decision_reason_code' => 'comment_created',
        ]);

        return [
            'id' => $id,
            'post_id' => $postId,
            'author_id' => $authorId,
            'body' => $normalizedBody,
            'state' => 'active',
            'created_at_utc' => gmdate('c', strtotime($createdAt) ?: time()),
        ];
    }

    private function ensureStorageReady(): void
    {
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS comments (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NOT NULL,
            author_principal_id CHAR(32) NOT NULL,
            body_text TEXT NOT NULL,
            state TEXT NOT NULL,
            created_at TEXT NOT NULL,
            deleted_at TEXT NULL,
            deleted_by CHAR(32) NULL,
            delete_reason_code TEXT NULL
        )');
    }

    private function dbTimestamp(?int $unixTime = null): string
    {
        return gmdate('Y-m-d H:i:s', $unixTime ?? time());
    }
}
```

## `src/Application/Posts/ModerationService.php`
- **Line count:** 171

```php
<?php

declare(strict_types=1);

namespace Cre8\Application\Posts;

use Cre8\Observability\AuditEmitter;
use PDO;

final class ModerationService
{
    public function __construct(private readonly PDO $pdo, private readonly AuditEmitter $auditEmitter)
    {
        $this->ensureStorageReady();
    }

    /** @return array{id:string,state:string,action:string,reason_code:?string,moderated_at_utc:string}|null */
    public function moderatePost(string $postId, string $actorId, string $action, ?string $reasonCode, string $requestId): ?array
    {
        $nextState = match ($action) {
            'hide' => 'hidden',
            'lock' => 'locked',
            'archive' => 'archived',
            'delete' => 'deleted',
            default => null,
        };

        if ($nextState === null) {
            return null;
        }

        $now = $this->dbTimestamp();
        $stmt = $this->pdo->prepare('SELECT id FROM posts WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $postId]);
        if (!is_array($stmt->fetch(PDO::FETCH_ASSOC))) {
            return null;
        }

        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('UPDATE posts SET state = :state, deleted_at = :deleted_at, deleted_by = :deleted_by, delete_reason_code = :reason WHERE id = :id')
                ->execute([
                    'state' => $nextState,
                    'deleted_at' => $nextState === 'deleted' ? $now : null,
                    'deleted_by' => $nextState === 'deleted' ? $actorId : null,
                    'reason' => $nextState === 'deleted' ? $reasonCode : null,
                    'id' => $postId,
                ]);

            $this->recordModerationAction($actorId, $action, $reasonCode, $now, $postId, null);
            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        $this->auditEmitter->emit('moderation.post_' . $action, [
            'request_id' => $requestId,
            'principal_id' => $actorId,
            'resource_type' => 'post',
            'resource_id' => $postId,
            'action' => 'moderate:' . $action,
            'decision' => 'allow',
            'decision_reason_code' => 'post_' . $action,
        ]);

        return [
            'id' => $postId,
            'state' => $nextState,
            'action' => $action,
            'reason_code' => $reasonCode,
            'moderated_at_utc' => gmdate('c', strtotime($now) ?: time()),
        ];
    }

    /** @return array{id:string,state:string,action:string,reason_code:?string,moderated_at_utc:string}|null */
    public function moderateComment(string $commentId, string $actorId, string $action, ?string $reasonCode, string $requestId): ?array
    {
        $nextState = match ($action) {
            'hide' => 'hidden',
            'lock' => 'locked',
            'delete' => 'deleted',
            default => null,
        };

        if ($nextState === null) {
            return null;
        }

        $now = $this->dbTimestamp();
        $stmt = $this->pdo->prepare('SELECT id, post_id FROM comments WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $commentId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!is_array($row)) {
            return null;
        }

        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('UPDATE comments SET state = :state, deleted_at = :deleted_at, deleted_by = :deleted_by, delete_reason_code = :reason WHERE id = :id')
                ->execute([
                    'state' => $nextState,
                    'deleted_at' => $nextState === 'deleted' ? $now : null,
                    'deleted_by' => $nextState === 'deleted' ? $actorId : null,
                    'reason' => $nextState === 'deleted' ? $reasonCode : null,
                    'id' => $commentId,
                ]);

            $this->recordModerationAction($actorId, $action, $reasonCode, $now, null, (string) $row['id']);
            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        $this->auditEmitter->emit('moderation.comment_' . $action, [
            'request_id' => $requestId,
            'principal_id' => $actorId,
            'resource_type' => 'comment',
            'resource_id' => $commentId,
            'action' => 'moderate:' . $action,
            'decision' => 'allow',
            'decision_reason_code' => 'comment_' . $action,
        ]);

        return [
            'id' => $commentId,
            'state' => $nextState,
            'action' => $action,
            'reason_code' => $reasonCode,
            'moderated_at_utc' => gmdate('c', strtotime($now) ?: time()),
        ];
    }

    private function recordModerationAction(string $actorId, string $action, ?string $reasonCode, string $createdAt, ?string $postId, ?string $commentId): void
    {
        $this->pdo->prepare('INSERT INTO moderation_actions (id, post_id, comment_id, actor_principal_id, action, reason_code, created_at) VALUES (:id, :post_id, :comment_id, :actor, :action, :reason, :created_at)')
            ->execute([
                'id' => bin2hex(random_bytes(16)),
                'post_id' => $postId,
                'comment_id' => $commentId,
                'actor' => $actorId,
                'action' => $action,
                'reason' => $reasonCode,
                'created_at' => $createdAt,
            ]);
    }

    private function ensureStorageReady(): void
    {
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS moderation_actions (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NULL,
            comment_id CHAR(32) NULL,
            actor_principal_id CHAR(32) NOT NULL,
            action TEXT NOT NULL,
            reason_code TEXT NULL,
            created_at TEXT NOT NULL
        )');
    }

    private function dbTimestamp(?int $unixTime = null): string
    {
        return gmdate('Y-m-d H:i:s', $unixTime ?? time());
    }
}
```

## `src/Application/Posts/PostsService.php`
- **Line count:** 223

```php
<?php

declare(strict_types=1);

namespace Cre8\Application\Posts;

use PDO;

final class PostsService
{
    public function __construct(private readonly PDO $pdo)
    {
        $this->ensureStorageReady();
    }

    /**
     * @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}>
     */
    public function listForAuthor(string $authorId): array
    {
        $stmt = $this->pdo->prepare('SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE author_principal_id = :author ORDER BY created_at DESC, id DESC');
        $stmt->execute(['author' => $authorId]);

        return $this->mapRows($stmt->fetchAll(PDO::FETCH_ASSOC) ?: []);
    }

    /**
     * @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}>
     */
    public function listVisible(string $scope): array
    {
        return match ($scope) {
            'public' => $this->fetchByVisibility(['public']),
            'delegated' => $this->fetchByVisibility(['public', 'delegated']),
            default => $this->fetchAll(),
        };
    }

    /** @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string} */
    public function create(string $authorId, string $visibilityScope, string $title, string $body, string $state = 'published'): array
    {
        $id = bin2hex(random_bytes(16));
        $createdAt = $this->dbTimestamp();
        $normalizedState = in_array($state, ['draft', 'published'], true) ? $state : 'published';

        $stmt = $this->pdo->prepare('INSERT INTO posts (id, author_principal_id, visibility_scope, state, title_text, body_text, created_at) VALUES (:id, :author, :scope, :state, :title, :body, :created_at)');
        $stmt->execute([
            'id' => $id,
            'author' => $authorId,
            'scope' => $visibilityScope,
            'state' => $normalizedState,
            'title' => trim($title),
            'body' => trim($body),
            'created_at' => $createdAt,
        ]);

        return [
            'id' => $id,
            'author_id' => $authorId,
            'visibility_scope' => $visibilityScope,
            'state' => $normalizedState,
            'title' => trim($title),
            'body' => trim($body),
            'created_at_utc' => gmdate('c', strtotime($createdAt) ?: time()),
        ];
    }

    /** @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}|null */
    public function find(string $postId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $postId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            return null;
        }

        return $this->mapRow($row);
    }

    /** @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}> */
    private function fetchByVisibility(array $scopes): array
    {
        $placeholders = implode(',', array_fill(0, count($scopes), '?'));
        $stmt = $this->pdo->prepare("SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE state != 'deleted' AND visibility_scope IN ($placeholders) ORDER BY created_at DESC, id DESC");
        $stmt->execute($scopes);

        return $this->mapRows($stmt->fetchAll(PDO::FETCH_ASSOC) ?: []);
    }

    /** @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}> */
    private function fetchAll(): array
    {
        $stmt = $this->pdo->query("SELECT id, author_principal_id, visibility_scope, state, title_text, body_text, created_at FROM posts WHERE state != 'deleted' ORDER BY created_at DESC, id DESC");

        return $this->mapRows($stmt->fetchAll(PDO::FETCH_ASSOC) ?: []);
    }

    /** @param list<array<string,mixed>> $rows
     *  @return list<array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}>
     */
    private function mapRows(array $rows): array
    {
        return array_map(fn (array $row): array => $this->mapRow($row), $rows);
    }

    /** @param array<string,mixed> $row
     * @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}
     */
    private function mapRow(array $row): array
    {
        $createdAtRaw = (string) $row['created_at'];
        $createdAt = strtotime($createdAtRaw);

        return [
            'id' => (string) $row['id'],
            'author_id' => (string) $row['author_principal_id'],
            'visibility_scope' => (string) $row['visibility_scope'],
            'state' => (string) $row['state'],
            'title' => (string) ($row['title_text'] ?? ''),
            'body' => (string) ($row['body_text'] ?? ''),
            'created_at_utc' => $createdAt === false ? $createdAtRaw : gmdate('c', $createdAt),
        ];
    }

    /** @return array{id:string,author_id:string,visibility_scope:string,state:string,title:string,body:string,created_at_utc:string}|null */
    public function revise(string $postId, string $editorId, string $title, string $body, string $reasonCode): ?array
    {
        $existing = $this->find($postId);
        if ($existing === null) {
            return null;
        }

        $editedAt = $this->dbTimestamp();
        $revisionId = bin2hex(random_bytes(16));
        $this->pdo->beginTransaction();
        try {
            $this->pdo->prepare('UPDATE posts SET title_text = :title, body_text = :body WHERE id = :id')
                ->execute(['title' => trim($title), 'body' => trim($body), 'id' => $postId]);

            $this->pdo->prepare('INSERT INTO post_revisions (id, post_id, editor_principal_id, title_text, body_text, change_reason_code, edited_at) VALUES (:id, :post_id, :editor, :title, :body, :reason, :edited_at)')
                ->execute([
                    'id' => $revisionId,
                    'post_id' => $postId,
                    'editor' => $editorId,
                    'title' => trim($title),
                    'body' => trim($body),
                    'reason' => $reasonCode,
                    'edited_at' => $editedAt,
                ]);
            $this->pdo->commit();
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        return $this->find($postId);
    }

    public function flag(string $postId, string $actorId, string $reasonCode): bool
    {
        $existing = $this->find($postId);
        if ($existing === null) {
            return false;
        }

        $this->pdo->prepare('INSERT INTO post_flags (id, post_id, actor_principal_id, reason_code, created_at) VALUES (:id, :post_id, :actor, :reason, :created_at)')
            ->execute([
                'id' => bin2hex(random_bytes(16)),
                'post_id' => $postId,
                'actor' => $actorId,
                'reason' => $reasonCode,
                'created_at' => $this->dbTimestamp(),
            ]);

        return true;
    }

    private function ensureStorageReady(): void
    {
        if ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME) !== 'sqlite') {
            return;
        }

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS posts (
            id CHAR(32) PRIMARY KEY,
            author_principal_id CHAR(32) NOT NULL,
            visibility_scope TEXT NOT NULL,
            state TEXT NOT NULL,
            title_text TEXT NOT NULL DEFAULT \'\',
            body_text TEXT NOT NULL DEFAULT \'\',
            created_at TEXT NOT NULL,
            deleted_at TEXT NULL,
            deleted_by CHAR(32) NULL,
            delete_reason_code TEXT NULL
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS post_revisions (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NOT NULL,
            editor_principal_id CHAR(32) NOT NULL,
            title_text TEXT NOT NULL,
            body_text TEXT NOT NULL,
            change_reason_code TEXT NOT NULL,
            edited_at TEXT NOT NULL
        )');

        $this->pdo->exec('CREATE TABLE IF NOT EXISTS post_flags (
            id CHAR(32) PRIMARY KEY,
            post_id CHAR(32) NOT NULL,
            actor_principal_id CHAR(32) NOT NULL,
            reason_code TEXT NOT NULL,
            created_at TEXT NOT NULL
        )');
    }

    private function dbTimestamp(?int $unixTime = null): string
    {
        return gmdate('Y-m-d H:i:s', $unixTime ?? time());
    }
}
```

## `src/Bootstrap/AppFactory.php`
- **Line count:** 30

```php
<?php

declare(strict_types=1);

namespace Cre8\Bootstrap;

use Cre8\Http\Middleware\MiddlewareRegistry;
use Cre8\Http\Routes\RouteRegistrar;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory as SlimAppFactory;

final class AppFactory
{
    public static function create(ContainerInterface $container): App
    {
        SlimAppFactory::setContainer($container);
        $app = SlimAppFactory::create();

        $middleware = new MiddlewareRegistry($container);
        foreach ($middleware->global() as $mw) {
            $app->add($mw);
        }

        (new RouteRegistrar())->register($app, $middleware->perSurface());

        return $app;
    }
}
```

## `src/Bootstrap/BootChecks.php`
- **Line count:** 119

```php
<?php

declare(strict_types=1);

namespace Cre8\Bootstrap;

use Cre8\Config\RuntimeConfig;
use Cre8\Http\Middleware\MiddlewareOrder;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\KeyMaterial;
use Cre8\Security\TokenSigner;
use Cre8\Security\TokenVerifier;
use DI\Container;
use PDO;

final class BootChecks
{
    public static function assert(Container $container, RuntimeConfig $config): void
    {
        $started = microtime(true);
        $container->get(TokenVerifier::class);
        $container->get(TokenSigner::class);
        $container->get(AuditEmitter::class);
        $container->get(PDO::class);

        $requiredClasses = [
            \Slim\App::class,
            \Slim\Psr7\Factory\ResponseFactory::class,
            \DI\Container::class,
            \Firebase\JWT\JWT::class,
            \Respect\Validation\Validator::class,
            \Dotenv\Dotenv::class,
            \GuzzleHttp\Client::class,
            'Neomerx\\Cors\\Strategies\\Settings',
            \Monolog\Logger::class,
            \Symfony\Component\RateLimiter\RateLimiterFactory::class,
            \Symfony\Component\Cache\Adapter\ArrayAdapter::class,
        ];

        foreach ($requiredClasses as $className) {
            if (!class_exists($className)) {
                throw new \RuntimeException(sprintf('Required dependency class missing: %s', $className));
            }
        }

        KeyMaterial::resolve($config->jwtPrivateKey);
        KeyMaterial::resolve($config->jwtPublicKey);
        self::assertProfileSafety($config);
        self::assertKeyPathSafety($config->jwtPrivateKey, true);
        self::assertKeyPathSafety($config->jwtPublicKey, false);

        if (array_keys(MiddlewareOrder::GLOBAL_CLASS_MAP) !== MiddlewareOrder::GLOBAL) {
            throw new \RuntimeException('Global middleware order does not match contract.');
        }

        self::writeEvidence($config, $started);
    }

    private static function assertProfileSafety(RuntimeConfig $config): void
    {
        if ($config->appEnv === 'prod' && in_array('*', $config->corsAllowedOrigins, true)) {
            throw new \RuntimeException('config_disallowed_profile: wildcard CORS not allowed in prod');
        }

        if (in_array($config->appEnv, ['stage', 'prod'], true) && !str_starts_with(strtolower($config->jwtIssuer), 'https://')) {
            throw new \RuntimeException('config_disallowed_profile: stage/prod JWT_ISSUER must be https');
        }
    }

    private static function assertKeyPathSafety(string $keySource, bool $private): void
    {
        if (str_starts_with($keySource, '-----BEGIN')) {
            return;
        }

        if (!is_file($keySource) || !is_readable($keySource)) {
            throw new \RuntimeException('config_invalid_format: key path is not readable');
        }

        if (!$private) {
            return;
        }

        $perms = @fileperms($keySource);
        if ($perms === false) {
            throw new \RuntimeException('config_invalid_format: key path permissions are unreadable');
        }

        if (($perms & 0o077) !== 0) {
            throw new \RuntimeException('config_disallowed_profile: private key permissions must be 600/400');
        }
    }

    private static function writeEvidence(RuntimeConfig $config, float $started): void
    {
        $path = getenv('BOOT_EVIDENCE_PATH');
        if (!is_string($path) || trim($path) === '') {
            return;
        }

        $payload = [
            'status' => 'ok',
            'timestamp_utc' => gmdate('c'),
            'app_env' => $config->appEnv,
            'middleware_order' => MiddlewareOrder::GLOBAL,
            'latency_ms' => (int) round((microtime(true) - $started) * 1000),
            'key_sources' => [
                'private' => str_starts_with($config->jwtPrivateKey, '-----BEGIN') ? 'inline_pem' : 'path',
                'public' => str_starts_with($config->jwtPublicKey, '-----BEGIN') ? 'inline_pem' : 'path',
            ],
        ];

        $encoded = json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        if (@file_put_contents($path, $encoded) === false) {
            throw new \RuntimeException('boot_evidence_write_failed');
        }
    }
}
```

## `src/Bootstrap/ContainerFactory.php`
- **Line count:** 134

```php
<?php

declare(strict_types=1);

namespace Cre8\Bootstrap;

use Cre8\Application\Auth\AuthService;
use Cre8\Application\Auth\KeyLifecycleService;
use Cre8\Application\Feed\FeedService;
use Cre8\Application\Health\HealthService;
use Cre8\Application\Posts\CommentsService;
use Cre8\Application\Posts\ModerationService;
use Cre8\Application\Posts\PostsService;
use Cre8\Config\RuntimeConfig;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Http\Middleware\CorsMiddleware;
use Cre8\Http\Middleware\CsrfMiddleware;
use Cre8\Http\Middleware\DeviceLimitMiddleware;
use Cre8\Http\Middleware\ErrorHandlerMiddleware;
use Cre8\Http\Middleware\JsonBodyMiddleware;
use Cre8\Http\Middleware\KeyJwtMiddleware;
use Cre8\Http\Middleware\OwnerJwtMiddleware;
use Cre8\Http\Middleware\RateLimitMiddleware;
use Cre8\Http\Middleware\RequestIdMiddleware;
use Cre8\Http\Middleware\RoutingMarkerMiddleware;
use Cre8\Http\Middleware\SecurityHeadersMiddleware;
use Cre8\Http\Middleware\UseKeyLimitMiddleware;
use Cre8\Http\Middleware\ValidationMiddleware;
use Cre8\Observability\AuditEmitter;
use Cre8\Observability\MonologAuditEmitter;
use Cre8\Security\ApiKeyHasher;
use Cre8\Security\JwtTokenSigner;
use Cre8\Security\JwtTokenVerifier;
use Cre8\Security\JwksService;
use Cre8\Security\TokenSigner;
use Cre8\Security\TokenVerifier;
use DI\Container;
use DI\ContainerBuilder;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PDO;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

final class ContainerFactory
{
    public static function build(RuntimeConfig $config): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(self::coreDefinitions($config));
        $builder->addDefinitions(self::securityDefinitions());
        $builder->addDefinitions(self::httpDefinitions());
        $builder->addDefinitions(self::appDefinitions());

        return $builder->build();
    }

    /** @return array<string, mixed> */
    private static function coreDefinitions(RuntimeConfig $config): array
    {
        return [
            RuntimeConfig::class => $config,
            LoggerInterface::class => static function (): LoggerInterface {
                $logger = new Logger('cre8');
                $logger->pushHandler(new StreamHandler('php://stdout'));

                return $logger;
            },
            ClientInterface::class => static fn (): ClientInterface => new Client(['timeout' => 5.0, 'http_errors' => false]),
            PDO::class => static fn () => new PDO($config->dbDsn, $config->dbUser, $config->dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]),
            ResponseFactoryInterface::class => static fn (): ResponseFactoryInterface => new ResponseFactory(),
            EnvelopeResponder::class => \DI\autowire(EnvelopeResponder::class),
            RateLimiterFactory::class => static fn (): RateLimiterFactory => new RateLimiterFactory([
                'id' => $config->rateLimitPolicy?->id ?? 'global',
                'policy' => $config->rateLimitPolicy?->policy ?? 'fixed_window',
                'interval' => $config->rateLimitPolicy?->interval ?? '1 minute',
                'limit' => $config->rateLimitPolicy?->limit ?? 180,
            ], new CacheStorage(new ArrayAdapter())),
        ];
    }

    /** @return array<string, mixed> */
    private static function securityDefinitions(): array
    {
        return [
            TokenVerifier::class => \DI\autowire(JwtTokenVerifier::class),
            TokenSigner::class => \DI\autowire(JwtTokenSigner::class),
            ApiKeyHasher::class => \DI\autowire(ApiKeyHasher::class),
            JwksService::class => \DI\autowire(JwksService::class),
            AuditEmitter::class => \DI\autowire(MonologAuditEmitter::class),
        ];
    }

    /** @return array<string, mixed> */
    private static function httpDefinitions(): array
    {
        return [
            ErrorHandlerMiddleware::class => \DI\autowire(ErrorHandlerMiddleware::class),
            RequestIdMiddleware::class => \DI\autowire(RequestIdMiddleware::class),
            SecurityHeadersMiddleware::class => \DI\autowire(SecurityHeadersMiddleware::class),
            CorsMiddleware::class => \DI\autowire(CorsMiddleware::class),
            RateLimitMiddleware::class => \DI\autowire(RateLimitMiddleware::class),
            JsonBodyMiddleware::class => \DI\autowire(JsonBodyMiddleware::class),
            RoutingMarkerMiddleware::class => \DI\autowire(RoutingMarkerMiddleware::class),
            ValidationMiddleware::class => \DI\autowire(ValidationMiddleware::class),
            CsrfMiddleware::class => \DI\autowire(CsrfMiddleware::class),
            OwnerJwtMiddleware::class => \DI\autowire(OwnerJwtMiddleware::class),
            KeyJwtMiddleware::class => \DI\autowire(KeyJwtMiddleware::class),
            DeviceLimitMiddleware::class => \DI\autowire(DeviceLimitMiddleware::class),
            UseKeyLimitMiddleware::class => \DI\autowire(UseKeyLimitMiddleware::class),
        ];
    }

    /** @return array<string, mixed> */
    private static function appDefinitions(): array
    {
        return [
            HealthService::class => \DI\autowire(HealthService::class),
            AuthService::class => \DI\autowire(AuthService::class),
            KeyLifecycleService::class => \DI\autowire(KeyLifecycleService::class),
            PostsService::class => \DI\autowire(PostsService::class),
            CommentsService::class => \DI\autowire(CommentsService::class),
            ModerationService::class => \DI\autowire(ModerationService::class),
            FeedService::class => \DI\autowire(FeedService::class),
        ];
    }
}
```

## `src/Config/CorsPolicy.php`
- **Line count:** 16

```php
<?php

declare(strict_types=1);

namespace Cre8\Config;

final class CorsPolicy
{
    /** @param list<string> $allowedOrigins */
    public function __construct(
        public readonly array $allowedOrigins,
        public readonly bool $allowWildcard = false,
    ) {
    }
}
```

## `src/Config/EnvValidator.php`
- **Line count:** 115

```php
<?php

declare(strict_types=1);

namespace Cre8\Config;

final class EnvValidator
{
    /** @param array<string, string|false> $env */
    public static function validateRequired(array $env): void
    {
        $required = [
            'APP_ENV',
            'DB_DSN',
            'DB_USER',
            'DB_PASS',
            'JWT_ISSUER',
            'JWT_AUDIENCE_CONSOLE',
            'JWT_AUDIENCE_GATEWAY',
            'JWT_PRIVATE_KEY',
            'JWT_PUBLIC_KEY',
            'CORS_ALLOWED_ORIGINS',
            'CSRF_SECRET',
        ];

        $missing = [];
        foreach ($required as $name) {
            $value = $env[$name] ?? false;
            if ($value === false || trim((string) $value) === '') {
                $missing[] = $name;
            }
        }

        if ($missing !== []) {
            throw new \RuntimeException('config_missing_required: '.implode(', ', $missing));
        }

        $appEnv = (string) ($env['APP_ENV'] ?? '');
        if (!in_array($appEnv, ['local', 'stage', 'prod'], true)) {
            throw new \RuntimeException('config_disallowed_profile: APP_ENV must be local|stage|prod');
        }

        if (strlen((string) $env['CSRF_SECRET']) < 32) {
            throw new \RuntimeException('config_invalid_format: CSRF_SECRET must be >= 32 chars');
        }

        $origins = array_filter(array_map('trim', explode(',', (string) $env['CORS_ALLOWED_ORIGINS'])));
        if ($origins === []) {
            throw new \RuntimeException('config_invalid_format: CORS_ALLOWED_ORIGINS must include at least one origin');
        }

        if (in_array('*', $origins, true) && $appEnv !== 'local') {
            throw new \RuntimeException('config_disallowed_profile: wildcard CORS only allowed in local');
        }

        $dsn = (string) $env['DB_DSN'];
        if (!preg_match('/^(sqlite:|mysql:|pgsql:)/', $dsn)) {
            throw new \RuntimeException('config_invalid_format: DB_DSN must use sqlite|mysql|pgsql driver prefix');
        }

        if ($appEnv === 'prod' && str_starts_with($dsn, 'sqlite:')) {
            throw new \RuntimeException('config_disallowed_profile: prod cannot use sqlite DSN');
        }

        $issuer = (string) $env['JWT_ISSUER'];
        if ($issuer === '' || filter_var($issuer, FILTER_VALIDATE_URL) === false) {
            throw new \RuntimeException('config_invalid_format: JWT_ISSUER must be a valid URL');
        }

        if (in_array($appEnv, ['stage', 'prod'], true) && !str_starts_with(strtolower($issuer), 'https://')) {
            throw new \RuntimeException('config_disallowed_profile: stage/prod JWT_ISSUER must be https');
        }

        self::validateKeySource((string) $env['JWT_PRIVATE_KEY'], 'JWT_PRIVATE_KEY');
        self::validateKeySource((string) $env['JWT_PUBLIC_KEY'], 'JWT_PUBLIC_KEY');
        self::validateOptionalPositiveInt($env, 'RATE_LIMIT_GLOBAL_LIMIT');
        self::validateOptionalPositiveInt($env, 'JWT_OWNER_TTL_SECONDS');
        self::validateOptionalPositiveInt($env, 'JWT_KEY_TTL_SECONDS');
        self::validateOptionalPositiveInt($env, 'JWT_DELEGATION_TTL_SECONDS');
    }

    private static function validateKeySource(string $value, string $name): void
    {
        $trimmed = trim($value);
        if ($trimmed === '') {
            throw new \RuntimeException("config_missing_required: {$name}");
        }

        if (str_starts_with($trimmed, '-----BEGIN')) {
            if (!str_contains($trimmed, '-----END')) {
                throw new \RuntimeException("config_invalid_format: {$name} PEM must include END marker");
            }

            return;
        }

        if (!preg_match('/^[\\w\\.\\/-]+$/', $trimmed)) {
            throw new \RuntimeException("config_invalid_format: {$name} path contains unsupported characters");
        }
    }

    /** @param array<string, string|false> $env */
    private static function validateOptionalPositiveInt(array $env, string $key): void
    {
        $value = $env[$key] ?? false;
        if ($value === false || trim((string) $value) === '') {
            return;
        }

        if (!ctype_digit((string) $value) || (int) $value <= 0) {
            throw new \RuntimeException("config_invalid_format: {$key} must be a positive integer");
        }
    }
}
```

## `src/Config/JwtPolicy.php`
- **Line count:** 16

```php
<?php

declare(strict_types=1);

namespace Cre8\Config;

final class JwtPolicy
{
    public function __construct(
        public readonly int $ownerTtlSeconds = 900,
        public readonly int $keyTtlSeconds = 600,
        public readonly int $delegationTtlSeconds = 300,
    ) {
    }
}
```

## `src/Config/RateLimitPolicy.php`
- **Line count:** 17

```php
<?php

declare(strict_types=1);

namespace Cre8\Config;

final class RateLimitPolicy
{
    public function __construct(
        public readonly string $id = 'global',
        public readonly string $policy = 'fixed_window',
        public readonly string $interval = '1 minute',
        public readonly int $limit = 180,
    ) {
    }
}
```

## `src/Config/RuntimeConfig.php`
- **Line count:** 68

```php
<?php

declare(strict_types=1);

namespace Cre8\Config;

final class RuntimeConfig
{
    /** @param list<string> $corsAllowedOrigins */
    public function __construct(
        public readonly string $appEnv,
        public readonly string $dbDsn,
        public readonly string $dbUser,
        public readonly string $dbPass,
        public readonly string $jwtIssuer,
        public readonly string $jwtAudienceConsole,
        public readonly string $jwtAudienceGateway,
        public readonly string $jwtPrivateKey,
        public readonly string $jwtPublicKey,
        public readonly array $corsAllowedOrigins,
        public readonly string $csrfSecret,
        public readonly ?RateLimitPolicy $rateLimitPolicy = null,
        public readonly ?CorsPolicy $corsPolicy = null,
        public readonly ?JwtPolicy $jwtPolicy = null,
    ) {
        $this->rateLimitPolicy ??= new RateLimitPolicy();
        $this->corsPolicy ??= new CorsPolicy($this->corsAllowedOrigins, !in_array('*', $this->corsAllowedOrigins, true));
        $this->jwtPolicy ??= new JwtPolicy();
    }

    /** @param array<string, string|false> $env */
    public static function fromEnv(array $env): self
    {
        EnvValidator::validateRequired($env);

        $origins = array_values(array_filter(array_map('trim', explode(',', (string) $env['CORS_ALLOWED_ORIGINS']))));

        return new self(
            appEnv: (string) $env['APP_ENV'],
            dbDsn: (string) $env['DB_DSN'],
            dbUser: (string) $env['DB_USER'],
            dbPass: (string) $env['DB_PASS'],
            jwtIssuer: (string) $env['JWT_ISSUER'],
            jwtAudienceConsole: (string) $env['JWT_AUDIENCE_CONSOLE'],
            jwtAudienceGateway: (string) $env['JWT_AUDIENCE_GATEWAY'],
            jwtPrivateKey: (string) $env['JWT_PRIVATE_KEY'],
            jwtPublicKey: (string) $env['JWT_PUBLIC_KEY'],
            corsAllowedOrigins: $origins,
            csrfSecret: (string) $env['CSRF_SECRET'],
            rateLimitPolicy: new RateLimitPolicy(
                id: (string) ($env['RATE_LIMIT_GLOBAL_ID'] ?: 'global'),
                policy: (string) ($env['RATE_LIMIT_GLOBAL_POLICY'] ?: 'fixed_window'),
                interval: (string) ($env['RATE_LIMIT_GLOBAL_INTERVAL'] ?: '1 minute'),
                limit: max(1, (int) ($env['RATE_LIMIT_GLOBAL_LIMIT'] ?: 180)),
            ),
            corsPolicy: new CorsPolicy(
                allowedOrigins: $origins,
                allowWildcard: in_array('*', $origins, true) && ((string) $env['APP_ENV']) === 'local',
            ),
            jwtPolicy: new JwtPolicy(
                ownerTtlSeconds: max(1, (int) ($env['JWT_OWNER_TTL_SECONDS'] ?: 900)),
                keyTtlSeconds: max(1, (int) ($env['JWT_KEY_TTL_SECONDS'] ?: 600)),
                delegationTtlSeconds: max(1, (int) ($env['JWT_DELEGATION_TTL_SECONDS'] ?: 300)),
            ),
        );
    }
}
```

## `src/Core/Http/EnvelopeResponder.php`
- **Line count:** 77

```php
<?php

declare(strict_types=1);

namespace Cre8\Core\Http;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class EnvelopeResponder
{
    private const ENVELOPE_VERSION = '2026-04-03';

    public function __construct(private readonly ResponseFactoryInterface $responseFactory)
    {
    }

    /** @param array<string,mixed> $data @param array<string,mixed> $meta */
    public function success(array $data, int $status = 200, array $meta = []): ResponseInterface
    {
        return $this->json($status, ['data' => $data, 'meta' => $this->meta($meta)]);
    }

    /** @param list<array<string,mixed>> $data @param array<string,mixed> $meta */
    public function list(array $data, ?string $cursor, int $limit = 50, array $meta = []): ResponseInterface
    {
        return $this->json(200, [
            'data' => $data,
            'paging' => [
                'limit' => $limit,
                'cursor' => $cursor,
                'has_more' => $cursor !== null && $cursor !== '',
            ],
            'meta' => $this->meta($meta),
        ]);
    }

    /** @param array<string,mixed>|list<array<string,mixed>> $details */
    public function error(string $code, string $message, string $requestId, int $status, array $details = []): ResponseInterface
    {
        return $this->json($status, [
            'error' => [
                'code' => $code,
                'message' => $message,
                'details' => $details,
                'request_id' => $requestId,
            ],
            'meta' => $this->meta(['request_id' => $requestId]),
        ], ['X-Request-Id' => $requestId, 'X-Envelope-Version' => self::ENVELOPE_VERSION]);
    }

    /** @param array<string,mixed> $payload @param array<string,string> $headers */
    public function json(int $status, array $payload, array $headers = []): ResponseInterface
    {
        $response = $this->responseFactory
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withHeader('X-Envelope-Version', self::ENVELOPE_VERSION);
        foreach ($headers as $name => $value) {
            $response = $response->withHeader($name, $value);
        }

        $response->getBody()->write((string) json_encode($payload, JSON_THROW_ON_ERROR));

        return $response;
    }

    /** @param array<string,mixed> $meta @return array<string,mixed> */
    private function meta(array $meta): array
    {
        return array_merge([
            'envelope_version' => self::ENVELOPE_VERSION,
            'timestamp_utc' => gmdate('c'),
        ], $meta);
    }
}
```

## `src/Core/Request/RequestId.php`
- **Line count:** 25

```php
<?php

declare(strict_types=1);

namespace Cre8\Core\Request;

final class RequestId
{
    private const UUID_V4_REGEX = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';

    public static function generate(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function isUuidV4(string $value): bool
    {
        return preg_match(self::UUID_V4_REGEX, trim($value)) === 1;
    }
}
```

## `src/Http/Middleware/CorsMiddleware.php`
- **Line count:** 80

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CorsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly RuntimeConfig $config,
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $origin = $request->getHeaderLine('Origin');
        $isPreflight = strtoupper($request->getMethod()) === 'OPTIONS';
        $wildcardAllowed = in_array('*', $this->config->corsAllowedOrigins, true);
        $allowed = $origin !== '' && ($wildcardAllowed || in_array($origin, $this->config->corsAllowedOrigins, true));

        if ($isPreflight) {
            if ($origin === '') {
                $this->auditEmitter?->emit('cors.preflight_rejected', [
                    'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                    'path' => $request->getUri()->getPath(),
                    'detail_code' => 'cors_origin_missing',
                ]);

                return $this->responseFactory->createResponse(400)
                    ->withHeader('X-Cors-Error-Code', 'cors_origin_missing')
                    ->withHeader('Content-Type', 'application/json; charset=utf-8');
            }

            if (!$allowed) {
                $this->auditEmitter?->emit('cors.preflight_rejected', [
                    'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                    'path' => $request->getUri()->getPath(),
                    'origin' => $origin,
                    'detail_code' => 'cors_origin_disallowed',
                ]);

                return $this->responseFactory->createResponse(403)
                    ->withHeader('X-Cors-Error-Code', 'cors_origin_disallowed')
                    ->withHeader('Content-Type', 'application/json; charset=utf-8');
            }

            $response = $this->responseFactory->createResponse(204);
        } else {
            $response = $handler->handle($request);
        }

        if (!$allowed) {
            return $response;
        }

        $this->auditEmitter?->emit('cors.applied', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
            'origin' => $origin,
            'preflight' => $isPreflight,
        ]);

        return $response
            ->withHeader('Access-Control-Allow-Origin', $wildcardAllowed ? '*' : $origin)
            ->withHeader('Vary', 'Origin')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, X-CSRF-Token, X-Request-Id')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS');
    }
}
```

## `src/Http/Middleware/CsrfMiddleware.php`
- **Line count:** 83

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Config\RuntimeConfig;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CsrfMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly RuntimeConfig $config,
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $method = strtoupper($request->getMethod());
        if (!str_starts_with($path, '/console/') || str_starts_with($path, '/console/api/') || !in_array($method, ['POST', 'PATCH', 'DELETE'], true)) {
            return $handler->handle($request);
        }

        $token = $request->getHeaderLine('X-CSRF-Token');
        $expected = hash_hmac('sha256', (string) $request->getAttribute('request_id', 'unknown'), $this->config->csrfSecret);

        if ($token === '') {
            $this->auditEmitter?->emit('csrf.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $path,
                'method' => $method,
                'detail_code' => 'csrf_token_missing',
            ]);

            return $this->responder->error('forbidden', 'csrf validation failed', (string) $request->getAttribute('request_id', 'unknown'), 403, [
                'detail_code' => 'csrf_token_missing',
            ]);
        }

        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            $this->auditEmitter?->emit('csrf.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $path,
                'method' => $method,
                'detail_code' => 'csrf_token_malformed',
            ]);

            return $this->responder->error('forbidden', 'csrf validation failed', (string) $request->getAttribute('request_id', 'unknown'), 403, [
                'detail_code' => 'csrf_token_malformed',
            ]);
        }

        if (sodium_memcmp($expected, $token) !== 0) {
            $this->auditEmitter?->emit('csrf.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $path,
                'method' => $method,
                'detail_code' => 'csrf_token_mismatch',
            ]);

            return $this->responder->error('forbidden', 'csrf validation failed', (string) $request->getAttribute('request_id', 'unknown'), 403, [
                'detail_code' => 'csrf_token_mismatch',
            ]);
        }

        $this->auditEmitter?->emit('csrf.validated', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $path,
            'method' => $method,
        ]);

        return $handler->handle($request);
    }
}
```

## `src/Http/Middleware/DeviceLimitMiddleware.php`
- **Line count:** 62

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DeviceLimitMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!str_starts_with($request->getUri()->getPath(), '/api/')) {
            return $handler->handle($request);
        }

        $deviceId = trim($request->getHeaderLine('X-Device-Id'));
        if ($deviceId === '') {
            $this->auditEmitter?->emit('device_limit.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'device_id_missing',
            ]);

            return $this->responder->error('validation_failed', 'missing device id', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                ['path' => 'X-Device-Id', 'code' => 'required', 'detail_code' => 'device_id_missing', 'message' => 'device id header required'],
            ]);
        }

        if (preg_match('/^[a-zA-Z0-9_.:-]{8,128}$/', $deviceId) !== 1) {
            $this->auditEmitter?->emit('device_limit.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'device_id_invalid_format',
            ]);

            return $this->responder->error('validation_failed', 'invalid device id format', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                ['path' => 'X-Device-Id', 'code' => 'invalid', 'detail_code' => 'device_id_invalid_format', 'message' => 'device id header must match expected format'],
            ]);
        }

        $this->auditEmitter?->emit('device_limit.validated', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
        ]);

        return $handler->handle($request);
    }
}
```

## `src/Http/Middleware/ErrorHandlerMiddleware.php`
- **Line count:** 61

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use DomainException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ErrorHandlerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            [$code, $message, $status, $detailCode] = $this->mapException($exception);
            $requestId = (string) $request->getAttribute('request_id', 'unknown');

            $this->auditEmitter?->emit('http.error_handled', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'status' => $status,
                'code' => $code,
                'detail_code' => $detailCode,
                'exception_class' => $exception::class,
            ]);

            return $this->responder->error($code, $message, $requestId, $status, [
                'detail_code' => $detailCode,
            ]);
        }
    }

    /** @return array{0:string,1:string,2:int,3:string} */
    private function mapException(\Throwable $exception): array
    {
        if ($exception instanceof InvalidArgumentException) {
            return ['bad_request', 'invalid request payload', 400, 'invalid_argument'];
        }

        if ($exception instanceof DomainException) {
            return ['validation_failed', 'domain policy validation failed', 422, 'domain_validation'];
        }

        return ['internal_error', 'unexpected server failure', 500, 'unhandled_exception'];
    }
}
```

## `src/Http/Middleware/JsonBodyMiddleware.php`
- **Line count:** 82

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class JsonBodyMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = strtoupper($request->getMethod());
        if (!in_array($method, ['POST', 'PATCH', 'PUT', 'DELETE'], true)) {
            return $handler->handle($request);
        }

        $contentType = strtolower($request->getHeaderLine('Content-Type'));
        if ($contentType !== '' && !str_contains($contentType, 'application/json')) {
            $this->auditEmitter?->emit('json_body.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'content_type_unsupported',
            ]);

            return $this->responder->error('unsupported_media_type', 'content type must be application/json', (string) $request->getAttribute('request_id', 'unknown'), 415, [
                'detail_code' => 'content_type_unsupported',
            ]);
        }

        $raw = (string) $request->getBody();
        if ($raw === '') {
            return $handler->handle($request->withParsedBody([]));
        }

        try {
            $parsed = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            $this->auditEmitter?->emit('json_body.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'json_malformed',
            ]);

            return $this->responder->error('bad_request', 'malformed json payload', (string) $request->getAttribute('request_id', 'unknown'), 400, [
                'detail_code' => 'json_malformed',
            ]);
        }

        if (!is_array($parsed)) {
            $this->auditEmitter?->emit('json_body.rejected', [
                'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'json_root_not_object',
            ]);

            return $this->responder->error('bad_request', 'json payload must decode to an object', (string) $request->getAttribute('request_id', 'unknown'), 400, [
                'detail_code' => 'json_root_not_object',
            ]);
        }

        $this->auditEmitter?->emit('json_body.parsed', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
        ]);

        return $handler->handle($request->withParsedBody($parsed));
    }
}
```

## `src/Http/Middleware/KeyJwtMiddleware.php`
- **Line count:** 124

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Config\RuntimeConfig;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenValidationException;
use Cre8\Security\TokenVerifier;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class KeyJwtMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly TokenVerifier $tokenVerifier,
        private readonly RuntimeConfig $config,
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $header = $request->getHeaderLine('Authorization');
        if (!str_starts_with($header, 'Bearer ')) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.key_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'bearer_missing',
            ]);

            return $this->responder->error('auth_required', 'authentication required', $requestId, 401, [
                'detail_code' => 'bearer_missing',
            ]);
        }

        $token = trim(substr($header, 7));
        if ($token === '') {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.key_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'bearer_token_empty',
            ]);

            return $this->responder->error('auth_required', 'authentication required', $requestId, 401, [
                'detail_code' => 'bearer_token_empty',
            ]);
        }

        try {
            $verification = $this->tokenVerifier->verify($token);
        } catch (TokenValidationException) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.key_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_verification_failed',
            ]);
        } catch (\Throwable) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.key_jwt.unavailable', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_dependency_unavailable',
            ]);

            return $this->responder->error('service_unavailable', 'authentication subsystem unavailable', $requestId, 503, [
                'detail_code' => 'token_dependency_unavailable',
            ]);
        }

        $tokenType = $verification->principal->type;
        $audience = $verification->principal->audience;
        if ($tokenType !== 'key') {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.key_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_type_invalid',
            ]);

            return $this->responder->error('auth_invalid', 'invalid token type', $requestId, 401, [
                'detail_code' => 'token_type_invalid',
            ]);
        }

        if ($audience !== $this->config->jwtAudienceGateway) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.key_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_audience_invalid',
            ]);

            return $this->responder->error('auth_invalid', 'invalid token audience', $requestId, 401, [
                'detail_code' => 'token_audience_invalid',
            ]);
        }

        $requestId = (string) $request->getAttribute('request_id', 'unknown');
        $this->auditEmitter?->emit('auth.key_jwt.validated', [
            'request_id' => $requestId,
            'path' => $request->getUri()->getPath(),
            'principal_id' => $verification->principal->id,
        ]);

        if ($verification->policyViolations !== []) {
            return $this->responder->error('auth_invalid', 'token policy violation', $requestId, 401, [
                'detail_code' => 'token_policy_violation',
                'violations' => $verification->policyViolations,
            ]);
        }

        return $handler->handle($request->withAttribute('principal', $verification->claims));
    }
}
```

## `src/Http/Middleware/MiddlewareOrder.php`
- **Line count:** 47

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

final class MiddlewareOrder
{
    /** @var list<string> */
    public const GLOBAL = [
        'ErrorHandler',
        'RequestId',
        'SecurityHeaders',
        'CORS',
        'RateLimit',
        'JsonBodyParsing',
        'Routing',
        'Validation',
        'CSRF',
    ];

    /** @var array<string, class-string> */
    public const GLOBAL_CLASS_MAP = [
        'ErrorHandler' => ErrorHandlerMiddleware::class,
        'RequestId' => RequestIdMiddleware::class,
        'SecurityHeaders' => SecurityHeadersMiddleware::class,
        'CORS' => CorsMiddleware::class,
        'RateLimit' => RateLimitMiddleware::class,
        'JsonBodyParsing' => JsonBodyMiddleware::class,
        'Routing' => RoutingMarkerMiddleware::class,
        'Validation' => ValidationMiddleware::class,
        'CSRF' => CsrfMiddleware::class,
    ];

    /** @var array<string, list<class-string>> */
    public const PER_SURFACE_CLASS_MAP = [
        'console' => [OwnerJwtMiddleware::class],
        'gateway' => [
            KeyJwtMiddleware::class,
            DeviceLimitMiddleware::class,
            UseKeyLimitMiddleware::class,
        ],
        'auth' => [],
        'public' => [],
    ];
}
```

## `src/Http/Middleware/MiddlewareRegistry.php`
- **Line count:** 46

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Psr\Container\ContainerInterface;

final class MiddlewareRegistry
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /** @return list<object> */
    public function global(): array
    {
        return array_map(
            fn (string $class): object => $this->container->get($class),
            array_values(MiddlewareOrder::GLOBAL_CLASS_MAP),
        );
    }

    /** @return array<string, list<object>> */
    public function perSurface(): array
    {
        $resolved = [];
        foreach (MiddlewareOrder::PER_SURFACE_CLASS_MAP as $surface => $classes) {
            $resolved[$surface] = array_map(
                fn (string $class): object => $this->container->get($class),
                $classes,
            );
        }

        return $resolved;
    }

    /** @return list<object> */
    public function forSurface(string $surface): array
    {
        $map = $this->perSurface();

        return $map[$surface] ?? [];
    }
}
```

## `src/Http/Middleware/OwnerJwtMiddleware.php`
- **Line count:** 125

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Config\RuntimeConfig;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenValidationException;
use Cre8\Security\TokenVerifier;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class OwnerJwtMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly TokenVerifier $tokenVerifier,
        private readonly RuntimeConfig $config,
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $this->extractBearer($request);
        if ($token === null) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'bearer_missing',
            ]);

            return $this->responder->error('auth_required', 'authentication required', $requestId, 401, [
                'detail_code' => 'bearer_missing',
            ]);
        }

        try {
            $verification = $this->tokenVerifier->verify($token);
        } catch (TokenValidationException) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_verification_failed',
            ]);
        } catch (\Throwable) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.unavailable', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_dependency_unavailable',
            ]);

            return $this->responder->error('service_unavailable', 'authentication subsystem unavailable', $requestId, 503, [
                'detail_code' => 'token_dependency_unavailable',
            ]);
        }

        $tokenType = $verification->principal->type;
        $audience = $verification->principal->audience;
        if ($tokenType !== 'owner') {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_type_invalid',
            ]);

            return $this->responder->error('auth_invalid', 'invalid token type', $requestId, 401, [
                'detail_code' => 'token_type_invalid',
            ]);
        }

        if ($audience !== $this->config->jwtAudienceConsole) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.owner_jwt.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'detail_code' => 'token_audience_invalid',
            ]);

            return $this->responder->error('auth_invalid', 'invalid token audience', $requestId, 401, [
                'detail_code' => 'token_audience_invalid',
            ]);
        }

        $requestId = (string) $request->getAttribute('request_id', 'unknown');
        $this->auditEmitter?->emit('auth.owner_jwt.validated', [
            'request_id' => $requestId,
            'path' => $request->getUri()->getPath(),
            'principal_id' => $verification->principal->id,
        ]);

        if ($verification->policyViolations !== []) {
            return $this->responder->error('auth_invalid', 'token policy violation', $requestId, 401, [
                'detail_code' => 'token_policy_violation',
                'violations' => $verification->policyViolations,
            ]);
        }

        return $handler->handle($request->withAttribute('principal', $verification->claims));
    }

    private function extractBearer(ServerRequestInterface $request): ?string
    {
        $header = $request->getHeaderLine('Authorization');
        if (!str_starts_with($header, 'Bearer ')) {
            return null;
        }

        $token = trim(substr($header, 7));
        if ($token === '') {
            return null;
        }

        return $token;
    }
}
```

## `src/Http/Middleware/RateLimitMiddleware.php`
- **Line count:** 59

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;

final class RateLimitMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly RateLimiterFactory $rateLimiter,
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $key = trim((string) ($request->getServerParams()['REMOTE_ADDR'] ?? ''));
        if ($key === '') {
            $key = 'ip:unknown';
        }

        $limit = $this->rateLimiter->create((string) $key)->consume(1);

        if (!$limit->isAccepted()) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $retryAfter = $limit->getRetryAfter()?->getTimestamp();
            $this->auditEmitter?->emit('rate_limit.rejected', [
                'request_id' => $requestId,
                'path' => $request->getUri()->getPath(),
                'client_key' => $key,
                'detail_code' => 'rate_limit_exceeded',
                'retry_after' => $retryAfter,
            ]);

            return $this->responder->error('rate_limited', 'rate limit exceeded', $requestId, 429, [
                'detail_code' => 'rate_limit_exceeded',
                'retry_after' => $retryAfter,
            ]);
        }

        $this->auditEmitter?->emit('rate_limit.accepted', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
            'client_key' => $key,
        ]);

        return $handler->handle($request);
    }
}
```

## `src/Http/Middleware/RequestIdMiddleware.php`
- **Line count:** 42

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Request\RequestId;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestIdMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly ?AuditEmitter $auditEmitter = null)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $incomingRequestId = trim($request->getHeaderLine('X-Request-Id'));
        $acceptedIncoming = $incomingRequestId !== '' && RequestId::isUuidV4($incomingRequestId);

        $requestId = $acceptedIncoming ? $incomingRequestId : RequestId::generate();

        if (! $acceptedIncoming && $incomingRequestId !== '') {
            $this->auditEmitter?->emit('request_id.invalid_replaced', [
                'incoming_request_id' => $incomingRequestId,
                'request_id' => $requestId,
            ]);
        }

        $response = $handler->handle($request
            ->withAttribute('request_id', $requestId)
            ->withAttribute('request_id_source', $acceptedIncoming ? 'incoming' : 'generated'));

        return $response->withHeader('X-Request-Id', $requestId);
    }

}
```

## `src/Http/Middleware/RoutingMarkerMiddleware.php`
- **Line count:** 69

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RoutingMarkerMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly ?AuditEmitter $auditEmitter = null)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $surface = $this->detectSurface($path);
        $routeFamily = $this->routeFamily($path);

        $this->auditEmitter?->emit('routing.marker.applied', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'surface' => $surface,
            'route_family' => $routeFamily,
            'path' => $path,
        ]);

        return $handler->handle($request
            ->withAttribute('route_surface', $surface)
            ->withAttribute('route_family', $routeFamily));
    }

    private function detectSurface(string $path): string
    {
        if (str_starts_with($path, '/console/api')) {
            return 'console';
        }

        if (str_starts_with($path, '/api')) {
            return 'gateway';
        }

        return 'public';
    }

    private function routeFamily(string $path): string
    {
        $segments = array_values(array_filter(explode('/', trim($path, '/'))));

        if ($segments === []) {
            return 'root';
        }

        if (($segments[0] ?? '') === 'console' && ($segments[1] ?? '') === 'api') {
            return $segments[2] ?? 'console_root';
        }

        if (($segments[0] ?? '') === 'api') {
            return $segments[1] ?? 'api_root';
        }

        return $segments[0];
    }
}
```

## `src/Http/Middleware/SecurityHeadersMiddleware.php`
- **Line count:** 49

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class SecurityHeadersMiddleware implements MiddlewareInterface
{
    /** @var array<string,string> */
    private const DEFAULT_HEADERS = [
        'X-Frame-Options' => 'DENY',
        'X-Content-Type-Options' => 'nosniff',
        'Referrer-Policy' => 'no-referrer',
        'Content-Security-Policy' => "default-src 'none'; frame-ancestors 'none'",
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        'Cross-Origin-Opener-Policy' => 'same-origin',
        'Cross-Origin-Resource-Policy' => 'same-origin',
        'Permissions-Policy' => 'accelerometer=(), camera=(), geolocation=(), microphone=()'
    ];

    public function __construct(private readonly ?AuditEmitter $auditEmitter = null)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        foreach (self::DEFAULT_HEADERS as $name => $value) {
            if (! $response->hasHeader($name)) {
                $response = $response->withHeader($name, $value);
            }
        }

        $this->auditEmitter?->emit('security_headers.applied', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $request->getUri()->getPath(),
        ]);

        return $response;
    }
}
```

## `src/Http/Middleware/UseKeyLimitMiddleware.php`
- **Line count:** 71

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class UseKeyLimitMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $principal = $request->getAttribute('principal');
        $keyClass = is_array($principal) ? (string) ($principal['key_class'] ?? '') : '';
        if ($keyClass !== 'use') {
            return $handler->handle($request);
        }

        $path = $request->getUri()->getPath();
        $method = strtoupper($request->getMethod());
        if ($path === '/api/posts' && $method === 'POST') {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.use_key_limit.rejected', [
                'request_id' => $requestId,
                'path' => $path,
                'method' => $method,
                'detail_code' => 'use_key_post_create_forbidden',
            ]);

            return $this->responder->error('forbidden', 'use key cannot create posts', $requestId, 403, [
                'detail_code' => 'use_key_post_create_forbidden',
            ]);
        }

        if (str_starts_with($path, '/api/keys') && in_array($method, ['POST', 'PATCH', 'DELETE'], true)) {
            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            $this->auditEmitter?->emit('auth.use_key_limit.rejected', [
                'request_id' => $requestId,
                'path' => $path,
                'method' => $method,
                'detail_code' => 'use_key_key_mutation_forbidden',
            ]);

            return $this->responder->error('forbidden', 'use key cannot mutate keys', $requestId, 403, [
                'detail_code' => 'use_key_key_mutation_forbidden',
            ]);
        }

        $this->auditEmitter?->emit('auth.use_key_limit.allowed', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'path' => $path,
            'method' => $method,
            'key_class' => $keyClass,
        ]);

        return $handler->handle($request);
    }
}
```

## `src/Http/Middleware/ValidationMiddleware.php`
- **Line count:** 132

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Middleware;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Observability\AuditEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Respect\Validation\Validator as v;

final class ValidationMiddleware implements MiddlewareInterface
{
    /** @var array<string, array{required:list<string>, allowed:list<string>}> */
    private array $schemas = [
        'POST /api/auth/login' => ['required' => ['email', 'password'], 'allowed' => ['email', 'password']],
        'POST /api/auth/refresh' => ['required' => ['refresh_token'], 'allowed' => ['refresh_token']],
        'POST /api/posts' => ['required' => ['title', 'body', 'visibility_scope'], 'allowed' => ['title', 'body', 'visibility_scope', 'state']],
        'PATCH /api/posts/{postId}' => ['required' => ['title', 'body'], 'allowed' => ['title', 'body', 'change_reason_code']],
        'POST /api/posts/{postId}/flags' => ['required' => ['reason_code'], 'allowed' => ['reason_code']],
        'POST /console/api/posts' => ['required' => ['title', 'body', 'visibility_scope'], 'allowed' => ['title', 'body', 'visibility_scope', 'state']],
        'POST /console/api/keys' => ['required' => ['key_class', 'permissions', 'scope'], 'allowed' => ['key_class', 'parent_envelope_id', 'permissions', 'scope', 'ttl_seconds', 'comments_enabled']],
    ];

    public function __construct(
        private readonly EnvelopeResponder $responder,
        private readonly ?AuditEmitter $auditEmitter = null,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $normalizedPath = preg_replace('#/[a-f0-9]{32}(?=/|$)#', '/{postId}', $path);
        $key = sprintf('%s %s', strtoupper($request->getMethod()), $normalizedPath);
        $schema = $this->schemas[$key] ?? null;
        if ($schema === null) {
            return $handler->handle($request);
        }

        $body = $request->getParsedBody();
        if (!is_array($body)) {
            return $this->validationError($request, $key, [[
                'path' => 'body',
                'code' => 'invalid_type',
                'message' => 'must be an object',
                'detail_code' => 'validation_body_not_object',
            ]]);
        }

        $details = [];
        foreach (array_keys($body) as $field) {
            if (!in_array((string) $field, $schema['allowed'], true)) {
                $details[] = ['path' => (string) $field, 'code' => 'unknown_field', 'message' => 'field is not allowed'];
            }
        }

        foreach ($schema['required'] as $required) {
            if (!array_key_exists($required, $body) || $body[$required] === '' || $body[$required] === null) {
                $details[] = ['path' => $required, 'code' => 'required', 'message' => 'field is required'];
            }
        }

        if (isset($body['email']) && !is_string($body['email'])) {
            $details[] = ['path' => 'email', 'code' => 'invalid_type', 'message' => 'must be a string'];
        }

        if (isset($body['email']) && !v::email()->validate((string) $body['email'])) {
            $details[] = ['path' => 'email', 'code' => 'invalid_format', 'message' => 'must be a valid email'];
        }

        if (isset($body['visibility_scope']) && !v::in(['public', 'private', 'delegated'])->validate($body['visibility_scope'])) {
            $details[] = ['path' => 'visibility_scope', 'code' => 'unknown_value', 'message' => 'unsupported visibility scope'];
        }

        if (isset($body['state']) && !v::in(['draft', 'published'])->validate($body['state'])) {
            $details[] = ['path' => 'state', 'code' => 'unknown_value', 'message' => 'unsupported post state'];
        }

        if (isset($body['key_class']) && !v::in(['primary_author', 'secondary_author', 'use'])->validate($body['key_class'])) {
            $details[] = ['path' => 'key_class', 'code' => 'unknown_value', 'message' => 'unsupported key class'];
        }

        if (isset($body['permissions']) && !is_array($body['permissions'])) {
            $details[] = ['path' => 'permissions', 'code' => 'invalid_type', 'message' => 'must be an array'];
        }

        if (isset($body['scope']) && !is_array($body['scope'])) {
            $details[] = ['path' => 'scope', 'code' => 'invalid_type', 'message' => 'must be an array'];
        }

        if (isset($body['owner_id']) && !v::regex('/^[a-f0-9]{32}$/')->validate((string) $body['owner_id'])) {
            $details[] = ['path' => 'owner_id', 'code' => 'invalid_id_format', 'message' => 'must be lowercase hex32'];
        }

        foreach ($details as $index => $detail) {
            if (!isset($detail['detail_code'])) {
                $details[$index]['detail_code'] = 'validation_' . $detail['code'];
            }
        }

        if ($details !== []) {
            return $this->validationError($request, $key, $details);
        }

        $this->auditEmitter?->emit('validation.accepted', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'route_key' => $key,
            'outcome' => 'allow',
        ]);

        return $handler->handle($request);
    }

    /** @param list<array{path:string,code:string,message:string,detail_code:string}> $details */
    private function validationError(ServerRequestInterface $request, string $routeKey, array $details): ResponseInterface
    {
        $this->auditEmitter?->emit('validation.rejected', [
            'request_id' => (string) $request->getAttribute('request_id', 'unknown'),
            'route_key' => $routeKey,
            'outcome' => 'deny',
            'reason_code' => 'validation_failed',
            'violation_count' => count($details),
        ]);

        return $this->responder->error('validation_failed', 'input validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, $details);
    }
}
```

## `src/Http/Routes/RouteRegistrar.php`
- **Line count:** 500

```php
<?php

declare(strict_types=1);

namespace Cre8\Http\Routes;

use Cre8\Application\Auth\AuthException;
use Cre8\Application\Auth\AuthService;
use Cre8\Application\Auth\KeyLifecycleService;
use Cre8\Application\Feed\FeedService;
use Cre8\Application\Health\HealthService;
use Cre8\Application\Posts\CommentsService;
use Cre8\Application\Posts\ModerationService;
use Cre8\Application\Posts\PostsService;
use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Security\JwksService;
use Psr\Container\ContainerInterface;
use Slim\App;

final class RouteRegistrar
{
    /** @param array<string, list<object>> $perSurfaceMiddleware */
    public function register(App $app, array $perSurfaceMiddleware = []): void
    {
        $container = $app->getContainer();
        if ($container === null) {
            throw new \RuntimeException('Container is required for route registration.');
        }

        $responder = $container->get(EnvelopeResponder::class);

        $app->get('/health', function ($request, $response) use ($container, $responder) {
            $health = $container->get(HealthService::class)->check();

            return $responder->json(200, ['data' => $health]);
        });

        $app->get('/.well-known/jwks.json', function ($request, $response) use ($container, $responder) {
            $jwks = $container->get(JwksService::class)->current();

            return $responder->json(200, $jwks);
        });

        $app->post('/console/owners', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['email'] ?? '')) === '' || trim((string) ($body['password'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'email', 'code' => 'required', 'message' => 'is required'],
                    ['path' => 'password', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            try {
                $owner = $container->get(AuthService::class)->registerOwner((string) $body['email'], (string) $body['password'], (string) $request->getAttribute('request_id', 'unknown'));
            } catch (AuthException $e) {
                if ($e->getMessage() === 'owner_conflict') {
                    return $responder->error('owner_conflict', 'owner already exists', (string) $request->getAttribute('request_id', 'unknown'), 409, $e->details());
                }

                return $responder->error($e->getMessage(), 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, $e->details());
            }

            return $responder->success($owner, 201);
        });

        $app->post('/api/auth/login', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['email'] ?? '')) === '' || trim((string) ($body['password'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'email', 'code' => 'required', 'message' => 'is required'],
                    ['path' => 'password', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            try {
                $tokens = $container->get(AuthService::class)->login((string) $body['email'], (string) $body['password'], (string) $request->getAttribute('request_id', 'unknown'));
            } catch (AuthException $e) {
                return $responder->error($e->getMessage(), 'invalid credentials', (string) $request->getAttribute('request_id', 'unknown'), 401, $e->details());
            }

            return $responder->json(200, ['data' => $tokens]);
        });

        $app->post('/api/auth/key-login', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['key_id'] ?? '')) === '' || trim((string) ($body['api_key'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'key_id', 'code' => 'required', 'message' => 'is required'],
                    ['path' => 'api_key', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            $login = $container->get(KeyLifecycleService::class)->keyLogin(
                (string) $body['key_id'],
                (string) $body['api_key'],
                (string) $request->getAttribute('request_id', 'unknown'),
                fn (array $claims, string $tokenClass, array $context, ?int $ttl): string => $container->get(\Cre8\Security\TokenSigner::class)->sign($claims, $tokenClass, $context, $ttl)
            );

            if ($login === null) {
                return $responder->error('auth_invalid', 'invalid credentials', (string) $request->getAttribute('request_id', 'unknown'), 401, ['reason' => 'api_key_invalid']);
            }

            return $responder->json(200, ['data' => $login]);
        });

        $app->post('/api/auth/refresh', function ($request, $response) use ($container, $responder) {
            $body = (array) $request->getParsedBody();
            if (trim((string) ($body['refresh_token'] ?? '')) === '') {
                return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                    ['path' => 'refresh_token', 'code' => 'required', 'message' => 'is required'],
                ]);
            }

            $requestId = (string) $request->getAttribute('request_id', 'unknown');
            try {
                $tokens = $container->get(AuthService::class)->refresh((string) $body['refresh_token'], $requestId);
            } catch (AuthException $e) {
                if (($e->details()['reason'] ?? null) === 'refresh_surface_mismatch') {
                    try {
                        $tokens = $container->get(KeyLifecycleService::class)->refresh(
                            (string) $body['refresh_token'],
                            $requestId,
                            fn (array $claims, string $tokenClass, array $context, ?int $ttl): string => $container->get(\Cre8\Security\TokenSigner::class)->sign($claims, $tokenClass, $context, $ttl)
                        );
                    } catch (AuthException $keyRefreshException) {
                        return $responder->error($keyRefreshException->getMessage(), 'invalid credentials', $requestId, 401, $keyRefreshException->details());
                    }
                } else {
                    return $responder->error($e->getMessage(), 'invalid credentials', $requestId, 401, $e->details());
                }
            }

            return $responder->json(200, ['data' => $tokens]);
        });

        $this->registerConsoleRoutes($app, $container, $responder, $perSurfaceMiddleware['console'] ?? []);
        $this->registerGatewayRoutes($app, $container, $responder, $perSurfaceMiddleware['gateway'] ?? []);
    }

    /** @param list<object> $surfaceMiddleware */
    private function registerConsoleRoutes(App $app, ContainerInterface $container, EnvelopeResponder $responder, array $surfaceMiddleware): void
    {
        $group = $app->group('/console/api', function ($group) use ($container, $responder) {
            $group->get('/posts', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $authorId = (string) ($principal['sub'] ?? 'owner_console');
                $posts = $container->get(PostsService::class)->listForAuthor($authorId);

                return $responder->list($posts, null, 50);
            });

            $group->post('/posts', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $authorId = (string) ($principal['sub'] ?? 'owner_console');
                $body = (array) $request->getParsedBody();
                $visibility = (string) ($body['visibility_scope'] ?? 'private');
                $title = trim((string) ($body['title'] ?? ''));
                $postBody = trim((string) ($body['body'] ?? ''));
                $state = (string) ($body['state'] ?? 'published');
                if (!in_array($visibility, ['public', 'private', 'delegated'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'visibility_scope', 'code' => 'unknown_value', 'message' => 'unsupported visibility scope'],
                    ]);
                }
                if ($title === '' || $postBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'title', 'code' => 'required', 'message' => 'is required'],
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $post = $container->get(PostsService::class)->create($authorId, $visibility, $title, $postBody, $state);

                return $responder->success($post, 201);
            });

            $group->get('/keychains', function ($request, $response) use ($responder) {
                return $responder->list([], null, 50);
            });

            $group->post('/invites', function ($request, $response) use ($responder) {
                return $responder->success([
                    'invite_id' => bin2hex(random_bytes(16)),
                    'status' => 'created',
                    'created_at_utc' => gmdate('c'),
                ], 201);
            });

            $group->post('/keys', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $ownerId = (string) ($principal['sub'] ?? 'owner_console');
                $body = (array) $request->getParsedBody();

                try {
                    $issued = $container->get(KeyLifecycleService::class)->issue($ownerId, [
                        'key_class' => $body['key_class'] ?? null,
                        'parent_envelope_id' => $body['parent_envelope_id'] ?? null,
                        'permissions' => is_array($body['permissions'] ?? null) ? array_map('strval', $body['permissions']) : ['posts:read'],
                        'scope' => is_array($body['scope'] ?? null) ? array_map('strval', $body['scope']) : ['posts:all'],
                        'ttl_seconds' => isset($body['ttl_seconds']) ? (int) $body['ttl_seconds'] : null,
                        'comments_enabled' => (bool) ($body['comments_enabled'] ?? false),
                    ], (string) $request->getAttribute('request_id', 'unknown'));
                } catch (AuthException $e) {
                    $status = $e->getMessage() === 'forbidden' ? 403 : 422;

                    return $responder->error($e->getMessage() === 'forbidden' ? 'forbidden' : 'validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), $status, $e->details());
                }

                return $responder->success($issued, 201);
            });

            $group->post('/keys/{keyId}/lifecycle', function ($request, $response, array $args) use ($container, $responder) {
                $body = (array) $request->getParsedBody();
                $state = (string) ($body['state'] ?? '');

                try {
                    $ok = $container->get(KeyLifecycleService::class)->transition((string) $args['keyId'], $state, (string) $request->getAttribute('request_id', 'unknown'));
                } catch (AuthException $e) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, $e->details());
                }

                if (!$ok) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->json(204, ['data' => null]);
            });

            $group->post('/posts/{postId}/moderation', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $action = trim((string) ($body['action'] ?? ''));
                $reasonCode = trim((string) ($body['reason_code'] ?? ''));

                if (!in_array($action, ['hide', 'lock', 'archive', 'delete'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'action', 'code' => 'unknown_value', 'message' => 'unsupported moderation action'],
                    ]);
                }

                $actorId = (string) ($principal['sub'] ?? 'owner_console');
                $result = $container->get(ModerationService::class)->moderatePost(
                    (string) $args['postId'],
                    $actorId,
                    $action,
                    $reasonCode !== '' ? $reasonCode : null,
                    (string) $request->getAttribute('request_id', 'unknown')
                );

                if ($result === null) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success($result);
            });

            $group->post('/posts/{postId}/comments/{commentId}/moderation', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $action = trim((string) ($body['action'] ?? ''));
                $reasonCode = trim((string) ($body['reason_code'] ?? ''));

                if (!in_array($action, ['hide', 'lock', 'delete'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'action', 'code' => 'unknown_value', 'message' => 'unsupported moderation action'],
                    ]);
                }

                $actorId = (string) ($principal['sub'] ?? 'owner_console');
                $result = $container->get(ModerationService::class)->moderateComment(
                    (string) $args['commentId'],
                    $actorId,
                    $action,
                    $reasonCode !== '' ? $reasonCode : null,
                    (string) $request->getAttribute('request_id', 'unknown')
                );

                if ($result === null) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success($result);
            });
        });

        foreach ($surfaceMiddleware as $middleware) {
            $group->add($middleware);
        }
    }

    /** @param list<object> $surfaceMiddleware */
    private function registerGatewayRoutes(App $app, ContainerInterface $container, EnvelopeResponder $responder, array $surfaceMiddleware): void
    {
        $group = $app->group('/api', function ($group) use ($container, $responder) {
            $group->get('/feed', function ($request, $response) use ($container, $responder) {
                $query = $request->getQueryParams();
                $scope = (string) ($query['scope'] ?? 'delegated');
                $limit = (int) ($query['limit'] ?? 50);
                $cursor = (string) ($query['cursor'] ?? '');

                $result = $container->get(FeedService::class)->list($scope, max(1, min($limit, 200)), $cursor !== '' ? $cursor : null);

                return $responder->list($result['items'], $result['next_cursor'], $result['limit']);
            });

            $group->post('/posts', function ($request, $response) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                if (!$this->hasPermission($principal, 'posts:create') || (($principal['key_class'] ?? '') === 'use')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'use_key_post_create_forbidden']);
                }

                $authorId = (string) ($principal['sub'] ?? 'gateway_key');
                $body = (array) $request->getParsedBody();
                $visibility = (string) ($body['visibility_scope'] ?? 'delegated');
                $title = trim((string) ($body['title'] ?? ''));
                $postBody = trim((string) ($body['body'] ?? ''));
                $state = (string) ($body['state'] ?? 'published');
                if (!in_array($visibility, ['public', 'private', 'delegated'], true)) {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'visibility_scope', 'code' => 'unknown_value', 'message' => 'unsupported visibility scope'],
                    ]);
                }
                if ($title === '' || $postBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'title', 'code' => 'required', 'message' => 'is required'],
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $post = $container->get(PostsService::class)->create($authorId, $visibility, $title, $postBody, $state);

                return $responder->success($post, 201);
            });

            $group->patch('/posts/{postId}', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                if (!$this->hasPermission($principal, 'posts:edit')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'posts_edit_forbidden']);
                }

                $body = (array) $request->getParsedBody();
                $title = trim((string) ($body['title'] ?? ''));
                $postBody = trim((string) ($body['body'] ?? ''));
                if ($title === '' || $postBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'title', 'code' => 'required', 'message' => 'is required'],
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $reason = trim((string) ($body['change_reason_code'] ?? 'manual_edit'));
                $revised = $container->get(PostsService::class)->revise(
                    (string) $args['postId'],
                    (string) ($principal['sub'] ?? 'gateway_key'),
                    $title,
                    $postBody,
                    $reason
                );

                if ($revised === null) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success($revised);
            });

            $group->post('/posts/{postId}/flags', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $reason = trim((string) ($body['reason_code'] ?? 'policy_review'));
                $ok = $container->get(PostsService::class)->flag(
                    (string) $args['postId'],
                    (string) ($principal['sub'] ?? 'gateway_key'),
                    $reason
                );

                if (!$ok) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                return $responder->success([
                    'post_id' => (string) $args['postId'],
                    'flagged' => true,
                    'reason_code' => $reason,
                ], 201);
            });

            $group->get('/posts/{postId}', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $post = $container->get(PostsService::class)->find((string) $args['postId']);
                if ($post === null || $post['state'] === 'deleted') {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                if (!$this->isVisibleToPrincipal($post, $principal)) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                if (!$this->hasPermission($principal, 'posts:read')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'permission_mask_forbidden']);
                }

                return $responder->success($post);
            });

            $group->get('/posts/{postId}/comments', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $post = $container->get(PostsService::class)->find((string) $args['postId']);
                if ($post === null || !$this->isVisibleToPrincipal($post, $principal)) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                $comments = $container->get(CommentsService::class)->listForPost((string) $args['postId']);

                return $responder->list($comments, null, 50);
            });

            $group->post('/posts/{postId}/comments', function ($request, $response, array $args) use ($container, $responder) {
                $principal = (array) $request->getAttribute('principal', []);
                $body = (array) $request->getParsedBody();
                $post = $container->get(PostsService::class)->find((string) $args['postId']);
                if ($post === null || !$this->isVisibleToPrincipal($post, $principal)) {
                    return $responder->error('not_found', 'not found', (string) $request->getAttribute('request_id', 'unknown'), 404);
                }

                if (in_array($post['state'], ['locked', 'archived', 'hidden', 'deleted'], true)) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'post_state_blocks_comment_create']);
                }

                if (!$this->hasPermission($principal, 'comments:create')) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'comments_permission_missing']);
                }

                if (!(bool) ($principal['comments_enabled'] ?? false)) {
                    return $responder->error('forbidden', 'forbidden', (string) $request->getAttribute('request_id', 'unknown'), 403, ['reason' => 'comments_toggle_off']);
                }

                $commentBody = trim((string) ($body['body'] ?? ''));
                if ($commentBody === '') {
                    return $responder->error('validation_failed', 'validation failed', (string) $request->getAttribute('request_id', 'unknown'), 422, [
                        ['path' => 'body', 'code' => 'required', 'message' => 'is required'],
                    ]);
                }

                $comment = $container->get(CommentsService::class)->create(
                    (string) $args['postId'],
                    (string) ($principal['sub'] ?? 'gateway_key'),
                    $commentBody,
                    (string) $request->getAttribute('request_id', 'unknown'),
                );

                return $responder->success($comment, 201);
            });
        });

        foreach ($surfaceMiddleware as $middleware) {
            $group->add($middleware);
        }
    }

    /** @param array<string,mixed> $principal */
    private function hasPermission(array $principal, string $permission): bool
    {
        $permissions = $principal['permissions'] ?? [];
        if (!is_array($permissions)) {
            return false;
        }

        return in_array($permission, array_map('strval', $permissions), true);
    }

    /** @param array<string,string> $post
     *  @param array<string,mixed> $principal
     */
    private function isVisibleToPrincipal(array $post, array $principal): bool
    {
        if ($post['visibility_scope'] === 'public') {
            return true;
        }

        if (($principal['sub'] ?? '') === $post['author_id']) {
            return true;
        }

        if ($post['visibility_scope'] !== 'delegated') {
            return false;
        }

        $scope = $principal['scope'] ?? [];
        if (!is_array($scope)) {
            return false;
        }

        $scope = array_map('strval', $scope);

        return in_array('posts:all', $scope, true) || in_array('post:' . $post['id'], $scope, true);
    }
}
```

## `src/Observability/AuditEmitter.php`
- **Line count:** 40

```php
<?php

declare(strict_types=1);

namespace Cre8\Observability;

interface AuditEmitter
{
    public const EVENT_VERSION = '1.0';

    /** @var list<string> */
    public const REQUIRED_FIELDS = [
        'event_name',
        'event_version',
        'timestamp_utc',
        'request_id',
        'trace_id',
        'actor_id',
        'actor_type',
        'target_type',
        'target_id',
        'decision',
        'outcome',
        'reason_code',
    ];

    /** @var list<string> */
    public const REDACTED_FIELD_KEYS = [
        'authorization',
        'bearer',
        'token',
        'password',
        'secret',
        'private_key',
        'refresh_token',
    ];

    public function emit(string $event, array $payload = []): void;
}
```

## `src/Observability/MonologAuditEmitter.php`
- **Line count:** 102

```php
<?php

declare(strict_types=1);

namespace Cre8\Observability;

use Psr\Log\LoggerInterface;

final class MonologAuditEmitter implements AuditEmitter
{
    private const SECURITY_EVENT_PREFIXES = ['auth.', 'security.', 'csrf.', 'rate_limit.', 'device_limit.', 'request_id.'];

    public function __construct(
        private readonly LoggerInterface $auditLogger,
        private readonly ?LoggerInterface $securityLogger = null,
        private readonly ?LoggerInterface $failureLogger = null,
    ) {
    }

    public function emit(string $event, array $payload = []): void
    {
        $logger = $this->isSecurityEvent($event) ? ($this->securityLogger ?? $this->auditLogger) : $this->auditLogger;
        $context = $this->normalizeContext($event, $payload);

        try {
            $logger->info($event, $context);
        } catch (\Throwable $exception) {
            $failureContext = [
                'event_name' => 'audit.delivery_failed',
                'event_version' => AuditEmitter::EVENT_VERSION,
                'timestamp_utc' => gmdate('c'),
                'failed_event_name' => $event,
                'failure_reason' => $exception->getMessage(),
            ];

            if ($this->failureLogger !== null) {
                $this->failureLogger->warning('audit.delivery_failed', $failureContext);

                return;
            }

            error_log('audit.delivery_failed ' . (string) json_encode($failureContext, JSON_THROW_ON_ERROR));
        }
    }

    private function isSecurityEvent(string $event): bool
    {
        foreach (self::SECURITY_EVENT_PREFIXES as $prefix) {
            if (str_starts_with($event, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /** @param array<string,mixed> $payload
     *  @return array<string,mixed>
     */
    private function normalizeContext(string $event, array $payload): array
    {
        $context = $this->redact($payload);

        $context['event_name'] = $event;
        $context['event_version'] = (string) ($context['event_version'] ?? AuditEmitter::EVENT_VERSION);
        $context['timestamp_utc'] = (string) ($context['timestamp_utc'] ?? gmdate('c'));

        foreach (AuditEmitter::REQUIRED_FIELDS as $field) {
            if (!array_key_exists($field, $context)) {
                $context[$field] = null;
            }
        }

        return $context;
    }

    /** @param array<string,mixed> $payload
     *  @return array<string,mixed>
     */
    private function redact(array $payload): array
    {
        $redacted = [];

        foreach ($payload as $key => $value) {
            $normalizedKey = strtolower((string) $key);
            if (in_array($normalizedKey, AuditEmitter::REDACTED_FIELD_KEYS, true)) {
                $redacted[$key] = '[REDACTED]';
                continue;
            }

            if (is_array($value)) {
                $redacted[$key] = $this->redact($value);
                continue;
            }

            $redacted[$key] = $value;
        }

        return $redacted;
    }
}
```

## `src/Security/ApiKeyHasher.php`
- **Line count:** 47

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

final class ApiKeyHasher
{
    private string $dummyHash;

    public function __construct(
        private readonly int $opsLimit = SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
        private readonly int $memLimit = SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
    ) {
        $this->dummyHash = sodium_crypto_pwhash_str('__cre8_dummy_key__', $this->opsLimit, $this->memLimit);
    }

    public function hash(string $plain): string
    {
        return sodium_crypto_pwhash_str($plain, $this->opsLimit, $this->memLimit);
    }

    public function verify(string $plain, string $hash): bool
    {
        if ($hash === '' || str_starts_with($hash, '$argon2id$') === false) {
            sodium_crypto_pwhash_str_verify($this->dummyHash, $plain);

            return false;
        }

        return sodium_crypto_pwhash_str_verify($hash, $plain);
    }

    /** @return array{hash:string,algorithm:string,ops_limit:int,mem_limit:int,key_version:string|null,rotated_at_utc:string|null} */
    public function hashWithMetadata(string $plain, ?string $keyVersion = null, ?string $rotatedAtUtc = null): array
    {
        return [
            'hash' => $this->hash($plain),
            'algorithm' => 'argon2id',
            'ops_limit' => $this->opsLimit,
            'mem_limit' => $this->memLimit,
            'key_version' => $keyVersion,
            'rotated_at_utc' => $rotatedAtUtc,
        ];
    }
}
```

## `src/Security/JwksService.php`
- **Line count:** 48

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Config\RuntimeConfig;

final class JwksService
{
    public function __construct(private readonly RuntimeConfig $config)
    {
    }

    /** @return array{keys:list<array<string,mixed>>} */
    public function current(): array
    {
        $publicPem = KeyMaterial::resolve($this->config->jwtPublicKey);
        $resource = openssl_pkey_get_public($publicPem);
        if ($resource === false) {
            throw new \RuntimeException('jwks_key_parse_failed');
        }

        $details = openssl_pkey_get_details($resource);
        if (!is_array($details) || ($details['type'] ?? null) !== OPENSSL_KEYTYPE_RSA || !isset($details['rsa']['n'], $details['rsa']['e'])) {
            throw new \RuntimeException('jwks_key_not_rsa');
        }

        $kid = substr(hash('sha256', $publicPem), 0, 16);

        return [
            'keys' => [[
                'kty' => 'RSA',
                'use' => 'sig',
                'alg' => 'RS256',
                'kid' => $kid,
                'n' => $this->base64Url((string) $details['rsa']['n']),
                'e' => $this->base64Url((string) $details['rsa']['e']),
            ]],
        ];
    }

    private function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
```

## `src/Security/JwtTokenSigner.php`
- **Line count:** 134

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Config\RuntimeConfig;
use Firebase\JWT\JWT;

final class JwtTokenSigner implements TokenSigner
{
    private string $privateKey;
    private string $publicKey;
    private string $kid;

    public function __construct(private readonly RuntimeConfig $config)
    {
        $this->privateKey = KeyMaterial::resolve($this->config->jwtPrivateKey);
        $this->publicKey = KeyMaterial::resolve($this->config->jwtPublicKey);
        $this->kid = substr(hash('sha256', $this->publicKey), 0, 16);
    }

    public function sign(array $claims, string $tokenClass = 'access', array $context = [], ?int $expiresInSeconds = null): string
    {
        $tokenType = $this->requiredString($claims, 'typ');
        $subject = $this->requiredString($claims, 'sub');
        $audience = $this->requiredString($claims, 'aud');

        if (!in_array($tokenType, ['owner', 'key', 'delegation'], true)) {
            throw new TokenValidationException('token_invalid_claims: unsupported typ');
        }

        if (strlen($subject) < 3) {
            throw new TokenValidationException('token_invalid_claims: subject too short');
        }

        $this->assertAudienceMatchesTokenType($tokenType, $audience);
        $this->assertDelegationClaims($tokenType, $claims);

        $now = time();
        $iat = isset($claims['iat']) ? (int) $claims['iat'] : $now;
        $nbf = isset($claims['nbf']) ? (int) $claims['nbf'] : $iat;
        $exp = isset($claims['exp']) ? (int) $claims['exp'] : $now + ($expiresInSeconds ?? $this->defaultTtlSeconds($tokenType));

        if ($iat > $now + 60) {
            throw new TokenValidationException('token_invalid_claims: iat cannot be in the far future');
        }

        if ($nbf < $iat - 60 || $nbf > $exp) {
            throw new TokenValidationException('token_invalid_claims: nbf must be within token validity window');
        }

        if ($exp <= $now) {
            throw new TokenValidationException('token_invalid_claims: exp must be in the future');
        }

        $ttl = $exp - $iat;
        if ($ttl <= 0 || $ttl > $this->maxTtlSeconds($tokenType)) {
            throw new TokenValidationException('token_invalid_claims: exp window exceeds policy for token type');
        }

        $payload = array_merge([
            'iss' => $this->config->jwtIssuer,
            'iat' => $iat,
            'nbf' => $nbf,
            'exp' => $exp,
            'jti' => bin2hex(random_bytes(16)),
            'token_class' => $tokenClass,
        ], $claims);

        if ($context !== []) {
            $payload['ctx'] = $context;
        }

        return JWT::encode($payload, $this->privateKey, 'RS256', $this->kid);
    }

    /** @param array<string,mixed> $claims */
    private function requiredString(array $claims, string $field): string
    {
        $value = trim((string) ($claims[$field] ?? ''));
        if ($value === '') {
            throw new TokenValidationException("token_invalid_claims: {$field} is required");
        }

        return $value;
    }

    private function assertAudienceMatchesTokenType(string $tokenType, string $audience): void
    {
        if ($tokenType === 'owner' && $audience !== $this->config->jwtAudienceConsole) {
            throw new TokenValidationException('token_invalid_claims: owner token must target console audience');
        }

        if (in_array($tokenType, ['key', 'delegation'], true) && $audience !== $this->config->jwtAudienceGateway) {
            throw new TokenValidationException('token_invalid_claims: key/delegation token must target gateway audience');
        }
    }

    /** @param array<string,mixed> $claims */
    private function assertDelegationClaims(string $tokenType, array $claims): void
    {
        if ($tokenType !== 'delegation') {
            return;
        }

        foreach (['delegation_envelope_id', 'initial_author_key_id'] as $field) {
            if (trim((string) ($claims[$field] ?? '')) === '') {
                throw new TokenValidationException("token_invalid_claims: {$field} is required for delegation token");
            }
        }
    }

    private function defaultTtlSeconds(string $tokenType): int
    {
        return match ($tokenType) {
            'owner' => 900,
            'key' => 600,
            'delegation' => 300,
            default => 900,
        };
    }

    private function maxTtlSeconds(string $tokenType): int
    {
        return match ($tokenType) {
            'owner' => 900,
            'key' => 600,
            'delegation' => 3600,
            default => 900,
        };
    }
}
```

## `src/Security/JwtTokenVerifier.php`
- **Line count:** 172

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Config\RuntimeConfig;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

final class JwtTokenVerifier implements TokenVerifier
{
    private const CLOCK_SKEW_SECONDS = 60;

    private string $publicKey;

    public function __construct(private readonly RuntimeConfig $config)
    {
        $this->publicKey = KeyMaterial::resolve($this->config->jwtPublicKey);
    }

    public function verify(string $token): TokenVerificationResult
    {
        $previousLeeway = JWT::$leeway;
        JWT::$leeway = self::CLOCK_SKEW_SECONDS;
        try {
            $decoded = JWT::decode($token, new Key($this->publicKey, 'RS256'));
        } catch (SignatureInvalidException $e) {
            throw new TokenValidationException('token_invalid_signature', 0, $e);
        } catch (\UnexpectedValueException $e) {
            throw new TokenValidationException('token_invalid_signature', 0, $e);
        } catch (\Throwable $e) {
            throw new TokenValidationException('token_invalid_claims', 0, $e);
        } finally {
            JWT::$leeway = $previousLeeway;
        }

        $claims = (array) $decoded;
        $this->assertRequiredClaims($claims);
        $this->assertIssuer($claims);
        $this->assertTemporalClaims($claims);
        $this->assertAudienceAndType($claims);
        $this->assertDelegationClaims($claims);

        return new TokenVerificationResult(
            claims: $claims,
            principal: new VerifiedPrincipal(
                id: (string) $claims['sub'],
                type: (string) $claims['typ'],
                audience: (string) $claims['aud'],
                keyClass: isset($claims['key_class']) ? (string) $claims['key_class'] : null,
            ),
            policyViolations: $this->policyViolations($claims),
        );
    }

    /** @param array<string, mixed> $claims */
    private function assertRequiredClaims(array $claims): void
    {
        foreach (['iss', 'aud', 'exp', 'nbf', 'iat', 'sub', 'typ', 'jti'] as $required) {
            if (!array_key_exists($required, $claims) || trim((string) $claims[$required]) === '') {
                throw new TokenValidationException('token_invalid_claims');
            }
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertIssuer(array $claims): void
    {
        if ((string) $claims['iss'] !== $this->config->jwtIssuer) {
            throw new TokenValidationException('token_invalid_claims');
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertTemporalClaims(array $claims): void
    {
        $iat = (int) $claims['iat'];
        $nbf = (int) $claims['nbf'];
        $exp = (int) $claims['exp'];
        $now = time();

        if ($iat > $now + self::CLOCK_SKEW_SECONDS) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if ($nbf > $exp || $nbf < $iat - self::CLOCK_SKEW_SECONDS) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if ($exp <= $now - self::CLOCK_SKEW_SECONDS) {
            throw new TokenValidationException('token_invalid_claims');
        }

        $ttl = $exp - $iat;
        if ($ttl <= 0) {
            throw new TokenValidationException('token_invalid_claims');
        }

        $maxTtl = $this->maxTtlSeconds((string) $claims['typ']);
        if ($ttl > $maxTtl) {
            throw new TokenValidationException('token_invalid_claims');
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertAudienceAndType(array $claims): void
    {
        $audience = (string) $claims['aud'];
        $type = (string) $claims['typ'];

        if (!in_array($audience, [$this->config->jwtAudienceConsole, $this->config->jwtAudienceGateway], true)) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if ($type === 'owner' && $audience !== $this->config->jwtAudienceConsole) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if (in_array($type, ['key', 'delegation'], true) && $audience !== $this->config->jwtAudienceGateway) {
            throw new TokenValidationException('token_invalid_claims');
        }

        if (!in_array($type, ['owner', 'key', 'delegation'], true)) {
            throw new TokenValidationException('token_invalid_claims');
        }
    }

    /** @param array<string, mixed> $claims */
    private function assertDelegationClaims(array $claims): void
    {
        if (($claims['typ'] ?? '') !== 'delegation') {
            return;
        }

        foreach (['delegation_envelope_id', 'initial_author_key_id'] as $required) {
            if (trim((string) ($claims[$required] ?? '')) === '') {
                throw new TokenValidationException('token_invalid_claims');
            }
        }
    }


    /** @param array<string,mixed> $claims
     *  @return list<string>
     */
    private function policyViolations(array $claims): array
    {
        $violations = [];

        if (($claims['typ'] ?? null) === 'owner' && ($claims['aud'] ?? null) !== $this->config->jwtAudienceConsole) {
            $violations[] = 'owner_wrong_audience';
        }

        if (in_array((string) ($claims['typ'] ?? ''), ['key', 'delegation'], true) && ($claims['aud'] ?? null) !== $this->config->jwtAudienceGateway) {
            $violations[] = 'key_wrong_audience';
        }

        return $violations;
    }
    private function maxTtlSeconds(string $tokenType): int
    {
        return match ($tokenType) {
            'owner' => 900,
            'key' => 600,
            'delegation' => 3600,
            default => 900,
        };
    }
}
```

## `src/Security/KeyMaterial.php`
- **Line count:** 83

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

use Cre8\Observability\AuditEmitter;

final class KeyMaterial
{
    public static function resolve(string $value, ?AuditEmitter $auditEmitter = null, string $label = 'jwt_key'): string
    {
        if (str_starts_with($value, '-----BEGIN')) {
            return self::validatePem($value, $auditEmitter, 'inline', $label);
        }

        if (is_file($value)) {
            self::assertSafePermissions($value);

            $contents = file_get_contents($value);
            if ($contents === false || trim($contents) === '') {
                $auditEmitter?->emit('security.key_material.rejected', [
                    'reason_code' => 'key_material_unreadable',
                    'source' => 'file',
                    'key_label' => $label,
                    'path' => $value,
                ]);
                throw new \RuntimeException('JWT key material could not be read.');
            }

            return self::validatePem($contents, $auditEmitter, 'file', $label, $value);
        }

        $auditEmitter?->emit('security.key_material.rejected', [
            'reason_code' => 'key_material_missing',
            'source' => 'unknown',
            'key_label' => $label,
        ]);

        throw new \RuntimeException('JWT key material is missing.');
    }

    private static function assertSafePermissions(string $path): void
    {
        if (!is_readable($path)) {
            throw new \RuntimeException('JWT key material could not be read.');
        }

        $perms = fileperms($path);
        if ($perms === false) {
            throw new \RuntimeException('JWT key material permission metadata is unavailable.');
        }

        if (($perms & 0o022) !== 0) {
            throw new \RuntimeException('JWT key material permissions are too permissive.');
        }
    }

    private static function validatePem(string $pem, ?AuditEmitter $auditEmitter, string $source, string $label, ?string $path = null): string
    {
        $trimmed = trim($pem);
        if ($trimmed === '' || !preg_match('/^-----BEGIN [A-Z ]+-----[\s\S]+-----END [A-Z ]+-----$/', $trimmed)) {
            $auditEmitter?->emit('security.key_material.rejected', [
                'reason_code' => 'key_material_format_invalid',
                'source' => $source,
                'key_label' => $label,
                'path' => $path,
            ]);

            throw new \RuntimeException('JWT key material format is invalid.');
        }

        $auditEmitter?->emit('security.key_material.resolved', [
            'reason_code' => 'key_material_resolved',
            'source' => $source,
            'key_label' => $label,
            'path' => $path,
        ]);

        return $trimmed;
    }
}
```

## `src/Security/TokenSigner.php`
- **Line count:** 12

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

interface TokenSigner
{
    /** @param array<string,mixed> $claims @param array<string,mixed> $context */
    public function sign(array $claims, string $tokenClass = 'access', array $context = [], ?int $expiresInSeconds = null): string;
}
```

## `src/Security/TokenValidationException.php`
- **Line count:** 10

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

final class TokenValidationException extends \RuntimeException
{
}
```

## `src/Security/TokenVerificationResult.php`
- **Line count:** 20

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

final class TokenVerificationResult
{
    /**
     * @param array<string,mixed> $claims
     * @param list<string> $policyViolations
     */
    public function __construct(
        public readonly array $claims,
        public readonly VerifiedPrincipal $principal,
        public readonly array $policyViolations = [],
    ) {
    }
}
```

## `src/Security/TokenVerifier.php`
- **Line count:** 11

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

interface TokenVerifier
{
    public function verify(string $token): TokenVerificationResult;
}
```

## `src/Security/VerifiedPrincipal.php`
- **Line count:** 17

```php
<?php

declare(strict_types=1);

namespace Cre8\Security;

final class VerifiedPrincipal
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $audience,
        public readonly ?string $keyClass = null,
    ) {
    }
}
```

## `tests/Contract/BootChecksContractTest.php`
- **Line count:** 121

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Bootstrap\BootChecks;
use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenSigner;
use Cre8\Security\TokenVerificationResult;
use Cre8\Security\TokenVerifier;
use Cre8\Security\VerifiedPrincipal;
use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

final class BootChecksContractTest extends TestCase
{
    public function testBootChecksWritesStructuredEvidenceWhenConfigured(): void
    {
        [$private, $public] = $this->keyFiles();
        $evidencePath = tempnam(sys_get_temp_dir(), 'boot-evidence-');
        putenv('BOOT_EVIDENCE_PATH=' . $evidencePath);

        BootChecks::assert($this->container(), $this->config($private, $public, 'local'));

        $decoded = json_decode((string) file_get_contents($evidencePath), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('ok', $decoded['status']);
        self::assertSame('local', $decoded['app_env']);
        self::assertSame('path', $decoded['key_sources']['private']);

        @unlink($private);
        @unlink($public);
        @unlink($evidencePath);
        putenv('BOOT_EVIDENCE_PATH');
    }

    public function testBootChecksRejectsProdWildcardCorsProfile(): void
    {
        [$private, $public] = $this->keyFiles();
        $config = new RuntimeConfig(
            appEnv: 'prod',
            dbDsn: 'pgsql:host=localhost;dbname=cre8',
            dbUser: 'cre8',
            dbPass: 'cre8-pass',
            jwtIssuer: 'https://issuer.cre8.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $private,
            jwtPublicKey: $public,
            corsAllowedOrigins: ['*'],
            csrfSecret: str_repeat('a', 32),
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('wildcard CORS not allowed in prod');

        BootChecks::assert($this->container(), $config);
    }

    private function container(): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
            TokenVerifier::class => static fn () => new class implements TokenVerifier {
                public function verify(string $token): TokenVerificationResult
                {
                    return new TokenVerificationResult(['sub' => 'owner', 'typ' => 'owner', 'aud' => 'console'], new VerifiedPrincipal('owner', 'owner', 'console'));
                }
            },
            TokenSigner::class => static fn () => new class implements TokenSigner {
                public function sign(array $claims, string $tokenClass = 'access', array $context = [], ?int $expiresInSeconds = null): string
                {
                    return 'signed';
                }
            },
            AuditEmitter::class => static fn () => new class implements AuditEmitter {
                public function emit(string $event, array $payload = []): void
                {
                }
            },
            \PDO::class => static fn () => new \PDO('sqlite::memory:'),
        ]);

        return $builder->build();
    }

    private function config(string $private, string $public, string $env): RuntimeConfig
    {
        return new RuntimeConfig(
            appEnv: $env,
            dbDsn: 'pgsql:host=localhost;dbname=cre8',
            dbUser: 'cre8',
            dbPass: 'cre8-pass',
            jwtIssuer: 'https://issuer.cre8.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $private,
            jwtPublicKey: $public,
            corsAllowedOrigins: ['https://console.cre8.local'],
            csrfSecret: str_repeat('a', 32),
        );
    }

    /** @return array{string,string} */
    private function keyFiles(): array
    {
        $private = tempnam(sys_get_temp_dir(), 'key-priv-');
        $public = tempnam(sys_get_temp_dir(), 'key-pub-');

        file_put_contents($private, "-----BEGIN PRIVATE KEY-----\nkey\n-----END PRIVATE KEY-----\n");
        file_put_contents($public, "-----BEGIN PUBLIC KEY-----\nkey\n-----END PUBLIC KEY-----\n");

        chmod($private, 0600);
        chmod($public, 0644);

        return [$private, $public];
    }
}
```

## `tests/Contract/ComposerScriptsContractTest.php`
- **Line count:** 23

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use PHPUnit\Framework\TestCase;

final class ComposerScriptsContractTest extends TestCase
{
    public function testComposerDefinesQaAndOperationalSmokeScripts(): void
    {
        $composer = json_decode((string) file_get_contents(__DIR__ . '/../../composer.json'), true, 512, JSON_THROW_ON_ERROR);
        $scripts = (array) ($composer['scripts'] ?? []);

        foreach (['test', 'test:contract', 'test:security', 'qa', 'ops:health-smoke', 'ops:migrate-smoke'] as $required) {
            self::assertArrayHasKey($required, $scripts, "missing composer script: {$required}");
        }

        self::assertSame('8.2.0', $composer['config']['platform']['php'] ?? null);
    }
}
```

## `tests/Contract/ContainerFactoryContractTest.php`
- **Line count:** 44

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Bootstrap\ContainerFactory;
use Cre8\Config\RateLimitPolicy;
use Cre8\Config\RuntimeConfig;
use PHPUnit\Framework\TestCase;

final class ContainerFactoryContractTest extends TestCase
{
    public function testContainerFactoryUsesTypedRateLimitPolicy(): void
    {
        $config = new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: '',
            dbPass: '',
            jwtIssuer: 'https://issuer.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: "-----BEGIN PRIVATE KEY-----\nabc\n-----END PRIVATE KEY-----",
            jwtPublicKey: "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----",
            corsAllowedOrigins: ['https://console.local'],
            csrfSecret: str_repeat('a', 32),
            rateLimitPolicy: new RateLimitPolicy(id: 'policy-id', interval: '2 minutes', limit: 25),
        );

        $container = ContainerFactory::build($config);
        self::assertNotNull($container->get(\Symfony\Component\RateLimiter\RateLimiterFactory::class));

        $source = (string) file_get_contents(__DIR__ . '/../../src/Bootstrap/ContainerFactory.php');
        self::assertStringContainsString('$config->rateLimitPolicy?->id', $source);
        self::assertStringContainsString('$config->rateLimitPolicy?->interval', $source);
        self::assertStringContainsString('$config->rateLimitPolicy?->limit', $source);
        self::assertStringContainsString('coreDefinitions', $source);
        self::assertStringContainsString('securityDefinitions', $source);
        self::assertStringContainsString('httpDefinitions', $source);
        self::assertStringContainsString('appDefinitions', $source);
    }
}
```

## `tests/Contract/EnvelopeResponderContractTest.php`
- **Line count:** 38

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Core\Http\EnvelopeResponder;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ResponseFactory;

final class EnvelopeResponderContractTest extends TestCase
{
    public function testListEnvelopeIncludesPagingHasMoreAndMeta(): void
    {
        $responder = new EnvelopeResponder(new ResponseFactory());
        $response = $responder->list([['id' => 'p1']], 'cursor-1', 10);

        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(200, $response->getStatusCode());
        self::assertSame(10, $payload['paging']['limit']);
        self::assertTrue($payload['paging']['has_more']);
        self::assertArrayHasKey('timestamp_utc', $payload['meta']);
        self::assertSame('2026-04-03', $payload['meta']['envelope_version']);
    }

    public function testErrorEnvelopeAddsVersionHeaderAndRequestMeta(): void
    {
        $responder = new EnvelopeResponder(new ResponseFactory());
        $response = $responder->error('forbidden', 'nope', 'req-1', 403);
        $payload = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame('2026-04-03', $response->getHeaderLine('X-Envelope-Version'));
        self::assertSame('req-1', $payload['error']['request_id']);
        self::assertSame('req-1', $payload['meta']['request_id']);
    }
}
```

## `tests/Contract/HealthServiceContractTest.php`
- **Line count:** 63

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Application\Health\HealthService;
use Cre8\Config\RuntimeConfig;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

final class HealthServiceContractTest extends TestCase
{
    public function testHealthServiceReturnsStructuredSubsystemProbes(): void
    {
        $private = tempnam(sys_get_temp_dir(), 'priv-');
        $public = tempnam(sys_get_temp_dir(), 'pub-');
        file_put_contents($private, "-----BEGIN PRIVATE KEY-----\nabc\n-----END PRIVATE KEY-----\n");
        file_put_contents($public, "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----\n");

        $config = new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: '',
            dbPass: '',
            jwtIssuer: 'https://issuer.local',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $private,
            jwtPublicKey: $public,
            corsAllowedOrigins: ['https://console.local'],
            csrfSecret: str_repeat('a', 32),
        );

        $service = new HealthService(
            new \PDO('sqlite::memory:'),
            new Client(['http_errors' => false]),
            new RateLimiterFactory([
                'id' => 'health',
                'policy' => 'fixed_window',
                'interval' => '1 minute',
                'limit' => 100,
            ], new CacheStorage(new ArrayAdapter())),
            $config,
        );

        $health = $service->check();

        self::assertArrayHasKey('checked_at_utc', $health);
        self::assertArrayHasKey('latency_ms', $health);
        self::assertArrayHasKey('failures', $health);
        self::assertSame('ok', $health['services']['db']['status']);
        self::assertSame('ok', $health['services']['rate_limiter']['status']);
        self::assertSame('ok', $health['services']['key_material']['status']);

        @unlink($private);
        @unlink($public);
    }
}
```

## `tests/Contract/MiddlewareProductionDepthContractTest.php`
- **Line count:** 400

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Core\Http\EnvelopeResponder;
use Cre8\Http\Middleware\CorsMiddleware;
use Cre8\Http\Middleware\CsrfMiddleware;
use Cre8\Http\Middleware\DeviceLimitMiddleware;
use Cre8\Http\Middleware\ErrorHandlerMiddleware;
use Cre8\Http\Middleware\JsonBodyMiddleware;
use Cre8\Http\Middleware\KeyJwtMiddleware;
use Cre8\Http\Middleware\OwnerJwtMiddleware;
use Cre8\Http\Middleware\RateLimitMiddleware;
use Cre8\Http\Middleware\RequestIdMiddleware;
use Cre8\Http\Middleware\RoutingMarkerMiddleware;
use Cre8\Http\Middleware\SecurityHeadersMiddleware;
use Cre8\Http\Middleware\UseKeyLimitMiddleware;
use Cre8\Http\Middleware\ValidationMiddleware;
use Cre8\Config\RuntimeConfig;
use Cre8\Observability\AuditEmitter;
use Cre8\Security\TokenVerificationResult;
use Cre8\Security\TokenVerifier;
use Cre8\Security\VerifiedPrincipal;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\InMemoryStorage;

final class MiddlewareProductionDepthContractTest extends TestCase
{
    public function testRequestIdMiddlewareReplacesInvalidIncomingHeaderAndAuditsReplacement(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new RequestIdMiddleware($audit);

        $response = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/posts')->withHeader('X-Request-Id', 'not-a-uuid'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                $response = (new ResponseFactory())->createResponse(200);
                $response->getBody()->write((string) $request->getAttribute('request_id_source'));

                return $response;
            }),
        );

        self::assertSame('generated', (string) $response->getBody());
        self::assertMatchesRegularExpression('/^[0-9a-f-]{36}$/', $response->getHeaderLine('X-Request-Id'));
        self::assertSame('request_id.invalid_replaced', $audit->events[0]['event']);
    }

    public function testRoutingMarkerMiddlewareSetsSurfaceAndRouteFamilyForConsoleAndGateway(): void
    {
        $middleware = new RoutingMarkerMiddleware();

        $console = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/console/api/posts'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                $response = (new ResponseFactory())->createResponse(200);
                $response->getBody()->write((string) $request->getAttribute('route_surface') . ':' . (string) $request->getAttribute('route_family'));

                return $response;
            }),
        );
        self::assertSame('console:posts', (string) $console->getBody());

        $gateway = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/feed'),
            new CallableHandler(static function (ServerRequestInterface $request): ResponseInterface {
                $response = (new ResponseFactory())->createResponse(200);
                $response->getBody()->write((string) $request->getAttribute('route_surface') . ':' . (string) $request->getAttribute('route_family'));

                return $response;
            }),
        );
        self::assertSame('gateway:feed', (string) $gateway->getBody());
    }

    public function testSecurityHeadersMiddlewareAddsModernHeadersWithoutOverridingExistingCsp(): void
    {
        $middleware = new SecurityHeadersMiddleware();

        $response = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/feed'),
            new CallableHandler(static function (): ResponseInterface {
                return (new ResponseFactory())
                    ->createResponse(200)
                    ->withHeader('Content-Security-Policy', "default-src 'self'");
            }),
        );

        self::assertSame("default-src 'self'", $response->getHeaderLine('Content-Security-Policy'));
        self::assertSame('same-origin', $response->getHeaderLine('Cross-Origin-Opener-Policy'));
        self::assertSame('same-origin', $response->getHeaderLine('Cross-Origin-Resource-Policy'));
        self::assertSame('accelerometer=(), camera=(), geolocation=(), microphone=()', $response->getHeaderLine('Permissions-Policy'));
    }

    public function testErrorHandlerMiddlewareReturnsMappedErrorCodesAndDetailCodes(): void
    {
        $responder = new EnvelopeResponder(new ResponseFactory());
        $middleware = new ErrorHandlerMiddleware($responder);

        $badRequest = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('POST', '/api/posts')->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static function (): ResponseInterface {
                throw new \InvalidArgumentException('bad input');
            }),
        );

        self::assertSame(400, $badRequest->getStatusCode());
        $payload = (array) json_decode((string) $badRequest->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('bad_request', $payload['error']['code']);
        self::assertSame('invalid_argument', $payload['error']['details']['detail_code']);

        $internal = $middleware->process(
            (new ServerRequestFactory())->createServerRequest('GET', '/api/feed')->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static function (): ResponseInterface {
                throw new \RuntimeException('boom');
            }),
        );

        self::assertSame(500, $internal->getStatusCode());
        $internalPayload = (array) json_decode((string) $internal->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('unhandled_exception', $internalPayload['error']['details']['detail_code']);
    }

    public function testCorsMiddlewareRejectsDisallowedPreflightWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new CorsMiddleware($this->runtimeConfig(), new ResponseFactory(), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('OPTIONS', '/api/feed')
                ->withHeader('Origin', 'https://evil.example')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(403, $response->getStatusCode());
        self::assertSame('cors_origin_disallowed', $response->getHeaderLine('X-Cors-Error-Code'));
        self::assertSame('cors.preflight_rejected', $audit->events[0]['event']);
    }

    public function testCsrfMiddlewareReturnsMalformedDetailCodeAndAudits(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new CsrfMiddleware($this->runtimeConfig(), new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/console/api/posts')
                ->withHeader('X-CSRF-Token', 'not-hex')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(403, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('csrf_token_malformed', $payload['error']['details']['detail_code']);
        self::assertSame('csrf.rejected', $audit->events[0]['event']);
    }

    public function testDeviceLimitMiddlewareRejectsInvalidHeaderFormatWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new DeviceLimitMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('GET', '/api/feed')
                ->withHeader('X-Device-Id', 'bad')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(422, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('device_id_invalid_format', $payload['error']['details'][0]['detail_code']);
        self::assertSame('device_limit.rejected', $audit->events[0]['event']);
    }

    public function testJsonBodyMiddlewareRejectsJsonArrayPayloadRootAndAudits(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new JsonBodyMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/posts')
                ->withHeader('Content-Type', 'application/json')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111')
                ->withBody(\Slim\Psr7\Stream::create('[1,2]')),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(400, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('json_root_not_object', $payload['error']['details']['detail_code']);
        self::assertSame('json_body.rejected', $audit->events[0]['event']);
    }

    public function testKeyJwtMiddlewareRejectsWrongAudienceWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new KeyJwtMiddleware(
            new StubTokenVerifier(['typ' => 'key', 'aud' => 'console']),
            $this->runtimeConfig(),
            new EnvelopeResponder(new ResponseFactory()),
            $audit,
        );

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('GET', '/api/feed')
                ->withHeader('Authorization', 'Bearer token')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(401, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('token_audience_invalid', $payload['error']['details']['detail_code']);
        self::assertSame('auth.key_jwt.rejected', $audit->events[0]['event']);
    }

    public function testOwnerJwtMiddlewareRejectsWrongTypeWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new OwnerJwtMiddleware(
            new StubTokenVerifier(['typ' => 'key', 'aud' => 'console']),
            $this->runtimeConfig(),
            new EnvelopeResponder(new ResponseFactory()),
            $audit,
        );

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('GET', '/console/api/posts')
                ->withHeader('Authorization', 'Bearer token')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(401, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('token_type_invalid', $payload['error']['details']['detail_code']);
        self::assertSame('auth.owner_jwt.rejected', $audit->events[0]['event']);
    }

    public function testRateLimitMiddlewareReturnsDeterministicDetailCodeAndAuditWhenRejected(): void
    {
        $audit = new InMemoryAuditEmitter();
        $limiterFactory = new RateLimiterFactory(['id' => 'test', 'policy' => 'fixed_window', 'limit' => 1, 'interval' => '1 minute'], new InMemoryStorage());
        $middleware = new RateLimitMiddleware($limiterFactory, new EnvelopeResponder(new ResponseFactory()), $audit);

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/api/feed')
            ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111');

        $first = $middleware->process(
            $request,
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );
        self::assertSame(200, $first->getStatusCode());

        $second = $middleware->process(
            $request,
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );
        self::assertSame(429, $second->getStatusCode());
        $payload = (array) json_decode((string) $second->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('rate_limit_exceeded', $payload['error']['details']['detail_code']);
        self::assertSame('rate_limit.rejected', $audit->events[1]['event']);
    }

    public function testUseKeyLimitMiddlewareRejectsMutationWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new UseKeyLimitMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/keys/abc')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111')
                ->withAttribute('principal', ['key_class' => 'use']),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(403, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('use_key_key_mutation_forbidden', $payload['error']['details']['detail_code']);
        self::assertSame('auth.use_key_limit.rejected', $audit->events[0]['event']);
    }

    public function testValidationMiddlewareRejectsNonObjectBodyWithDetailCodeAndAudit(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new ValidationMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/auth/login')
                ->withParsedBody('invalid')
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(422, $response->getStatusCode());
        $payload = (array) json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        self::assertSame('validation_body_not_object', $payload['error']['details'][0]['detail_code']);
        self::assertSame('validation.rejected', $audit->events[0]['event']);
    }

    public function testValidationMiddlewareAuditsAcceptedRouteAfterSuccessfulValidation(): void
    {
        $audit = new InMemoryAuditEmitter();
        $middleware = new ValidationMiddleware(new EnvelopeResponder(new ResponseFactory()), $audit);

        $response = $middleware->process(
            (new ServerRequestFactory())
                ->createServerRequest('POST', '/api/posts')
                ->withParsedBody(['title' => 'A', 'body' => 'B', 'visibility_scope' => 'public'])
                ->withAttribute('request_id', '11111111-1111-4111-8111-111111111111'),
            new CallableHandler(static fn (): ResponseInterface => (new ResponseFactory())->createResponse(200)),
        );

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('validation.accepted', $audit->events[0]['event']);
        self::assertSame('POST /api/posts', $audit->events[0]['payload']['route_key']);
    }

    private function runtimeConfig(): RuntimeConfig
    {
        return new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: 'u',
            dbPass: 'p',
            jwtIssuer: 'https://issuer.example',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: '/tmp/private.pem',
            jwtPublicKey: '/tmp/public.pem',
            corsAllowedOrigins: ['https://app.example'],
            csrfSecret: 'csrf-secret',
        );
    }
}

final class CallableHandler implements RequestHandlerInterface
{
    /** @var \Closure(ServerRequestInterface):ResponseInterface */
    private \Closure $callback;

    /** @param callable(ServerRequestInterface):ResponseInterface $callback */
    public function __construct(callable $callback)
    {
        $this->callback = $callback(...);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->callback)($request);
    }
}

final class InMemoryAuditEmitter implements AuditEmitter
{
    /** @var list<array{event:string,payload:array<string,mixed>}> */
    public array $events = [];

    public function emit(string $event, array $payload = []): void
    {
        $this->events[] = ['event' => $event, 'payload' => $payload];
    }
}

final class StubTokenVerifier implements TokenVerifier
{
    /** @param array<string,mixed> $claims */
    public function __construct(private readonly array $claims)
    {
    }

    public function verify(string $token): TokenVerificationResult
    {
        return new TokenVerificationResult(
            claims: $this->claims,
            principal: new VerifiedPrincipal((string) ($this->claims['sub'] ?? ''), (string) ($this->claims['typ'] ?? ''), (string) ($this->claims['aud'] ?? ''), isset($this->claims['key_class']) ? (string) $this->claims['key_class'] : null),
        );
    }
}
```

## `tests/Contract/MiddlewareRegistryContractsTest.php`
- **Line count:** 61

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Http\Middleware\MiddlewareOrder;
use Cre8\Http\Middleware\MiddlewareRegistry;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

final class MiddlewareRegistryContractsTest extends TestCase
{
    public function testGlobalOrderLabelsAndClassMapStayInSync(): void
    {
        self::assertSame(array_keys(MiddlewareOrder::GLOBAL_CLASS_MAP), MiddlewareOrder::GLOBAL);
    }

    public function testRegistryResolvesGlobalAndPerSurfaceMiddlewareFromOrderCatalog(): void
    {
        $container = new class implements ContainerInterface {
            /** @var array<string, object> */
            private array $instances = [];

            public function get(string $id): object
            {
                if (!isset($this->instances[$id])) {
                    $this->instances[$id] = new class($id) {
                        public function __construct(public string $id)
                        {
                        }
                    };
                }

                return $this->instances[$id];
            }

            public function has(string $id): bool
            {
                return true;
            }
        };

        $registry = new MiddlewareRegistry($container);

        $global = $registry->global();
        self::assertSame(
            array_values(MiddlewareOrder::GLOBAL_CLASS_MAP),
            array_map(static fn (object $item): string => $item->id, $global),
        );

        $gateway = $registry->forSurface('gateway');
        self::assertSame(
            MiddlewareOrder::PER_SURFACE_CLASS_MAP['gateway'],
            array_map(static fn (object $item): string => $item->id, $gateway),
        );

        self::assertSame([], $registry->forSurface('unknown-surface'));
    }
}
```

## `tests/Contract/MonologAuditEmitterContractTest.php`
- **Line count:** 68

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Observability\MonologAuditEmitter;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;

final class MonologAuditEmitterContractTest extends TestCase
{
    public function testEmitterNormalizesRequiredSchemaFieldsAndRedactsSensitiveValues(): void
    {
        $auditLogger = new InMemoryLogger();
        $securityLogger = new InMemoryLogger();
        $emitter = new MonologAuditEmitter($auditLogger, $securityLogger);

        $emitter->emit('auth.login_success', [
            'request_id' => '11111111-1111-4111-8111-111111111111',
            'password' => 'should-never-leak',
            'nested' => ['token' => 'abc123'],
        ]);

        self::assertCount(1, $securityLogger->records);
        self::assertCount(0, $auditLogger->records);
        self::assertSame('[REDACTED]', $securityLogger->records[0]['context']['password']);
        self::assertSame('[REDACTED]', $securityLogger->records[0]['context']['nested']['token']);
        self::assertSame('auth.login_success', $securityLogger->records[0]['context']['event_name']);
        self::assertArrayHasKey('timestamp_utc', $securityLogger->records[0]['context']);
        self::assertArrayHasKey('reason_code', $securityLogger->records[0]['context']);
    }

    public function testEmitterWritesDeliveryFailureEventToFailureLogger(): void
    {
        $auditLogger = new ThrowingLogger();
        $failureLogger = new InMemoryLogger();
        $emitter = new MonologAuditEmitter($auditLogger, null, $failureLogger);

        $emitter->emit('posts.updated', ['request_id' => '11111111-1111-4111-8111-111111111111']);

        self::assertCount(1, $failureLogger->records);
        self::assertSame('warning', $failureLogger->records[0]['level']);
        self::assertSame('audit.delivery_failed', $failureLogger->records[0]['message']);
        self::assertSame('posts.updated', $failureLogger->records[0]['context']['failed_event_name']);
    }
}

final class InMemoryLogger extends AbstractLogger
{
    /** @var list<array{level:string,message:string,context:array<string,mixed>}> */
    public array $records = [];

    public function log($level, $message, array $context = []): void
    {
        $this->records[] = ['level' => (string) $level, 'message' => (string) $message, 'context' => $context];
    }
}

final class ThrowingLogger extends AbstractLogger
{
    public function log($level, $message, array $context = []): void
    {
        throw new \RuntimeException('logger unavailable');
    }
}
```

## `tests/Contract/PublicIndexBootstrapContractTest.php`
- **Line count:** 24

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use PHPUnit\Framework\TestCase;

final class PublicIndexBootstrapContractTest extends TestCase
{
    public function testIndexHasStartupFailureEnvelopeAndAuditLogging(): void
    {
        $index = (string) file_get_contents(__DIR__ . '/../../public/index.php');

        self::assertStringContainsString('boot.startup_ready', $index);
        self::assertStringContainsString('boot.startup_failed', $index);
        self::assertStringContainsString('catch (\\Throwable $e)', $index);
        self::assertStringContainsString("'code' => 'boot_failed'", $index);
        self::assertStringContainsString("header('X-Request-Id: '", $index);
        self::assertStringContainsString('function loadRuntimeEnv()', $index);
        self::assertStringContainsString('$value = getenv($key);', $index);
        self::assertStringContainsString('$config = RuntimeConfig::fromEnv(loadRuntimeEnv());', $index);
    }
}
```

## `tests/Contract/RouteRegistrarContractsTest.php`
- **Line count:** 60

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use PHPUnit\Framework\TestCase;

final class RouteRegistrarContractsTest extends TestCase
{
    private const ROOT = __DIR__ . '/../../';

    public function testRouteRegistrarUsesServiceBackedPostAndFeedHandlers(): void
    {
        $registrarPhp = $this->read('src/Http/Routes/RouteRegistrar.php');

        self::assertStringContainsString('registerConsoleRoutes', $registrarPhp);
        self::assertStringContainsString('registerGatewayRoutes', $registrarPhp);
        self::assertStringContainsString('PostsService::class', $registrarPhp);
        self::assertStringContainsString('FeedService::class', $registrarPhp);
        self::assertStringContainsString('AuthService::class', $registrarPhp);
        self::assertStringContainsString('/console/api', $registrarPhp);
        self::assertStringContainsString('/console/owners', $registrarPhp);
        self::assertStringContainsString('/api', $registrarPhp);
        self::assertStringContainsString('/console/api/keys', $registrarPhp);
        self::assertStringContainsString('/console/api/keys/{keyId}/lifecycle', $registrarPhp);
        self::assertStringContainsString('/console/api/posts/{postId}/moderation', $registrarPhp);
        self::assertStringContainsString('/console/api/posts/{postId}/comments/{commentId}/moderation', $registrarPhp);
        self::assertStringContainsString('/api/auth/key-login', $registrarPhp);
        self::assertStringContainsString('/api/posts/{postId}', $registrarPhp);
        self::assertStringContainsString('/api/posts/{postId}/comments', $registrarPhp);
    }

    public function testRouteRegistrarNoLongerUsesEmptyFeedAndPostStubs(): void
    {
        $registrarPhp = $this->read('src/Http/Routes/RouteRegistrar.php');

        self::assertStringNotContainsString("responder->list([], null, 50)", $registrarPhp);
        self::assertStringNotContainsString("responder->success(['id' => bin2hex(random_bytes(16))], 201)", $registrarPhp);
        self::assertStringNotContainsString('rotated_access_stub', $registrarPhp);
        self::assertStringContainsString('visibility_scope', $registrarPhp);
        self::assertStringContainsString("['path' => 'refresh_token'", $registrarPhp);
    }

    public function testRouteRegistrarUsesAuthServiceForLoginAndRefresh(): void
    {
        $registrarPhp = $this->read('src/Http/Routes/RouteRegistrar.php');

        self::assertStringContainsString('->login(', $registrarPhp);
        self::assertStringContainsString('->refresh(', $registrarPhp);
        self::assertStringContainsString('->registerOwner(', $registrarPhp);
        self::assertStringContainsString('AuthException', $registrarPhp);
    }

    private function read(string $path): string
    {
        return (string) file_get_contents(self::ROOT . $path);
    }
}
```

## `tests/Contract/RuntimeConfigPoliciesContractTest.php`
- **Line count:** 63

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Contract;

use Cre8\Config\EnvValidator;
use Cre8\Config\RuntimeConfig;
use PHPUnit\Framework\TestCase;

final class RuntimeConfigPoliciesContractTest extends TestCase
{
    public function testEnvValidatorRejectsInvalidProdIssuerAndDsn(): void
    {
        $env = $this->validEnv();
        $env['APP_ENV'] = 'prod';
        $env['DB_DSN'] = 'sqlite::memory:';
        $env['JWT_ISSUER'] = 'http://issuer.local';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('config_disallowed_profile');

        EnvValidator::validateRequired($env);
    }

    public function testRuntimeConfigBuildsTypedPolicyObjectsFromEnv(): void
    {
        $env = $this->validEnv();
        $env['RATE_LIMIT_GLOBAL_LIMIT'] = '220';
        $env['RATE_LIMIT_GLOBAL_INTERVAL'] = '2 minutes';
        $env['JWT_OWNER_TTL_SECONDS'] = '901';
        $env['JWT_KEY_TTL_SECONDS'] = '601';
        $env['JWT_DELEGATION_TTL_SECONDS'] = '301';

        $config = RuntimeConfig::fromEnv($env);

        self::assertSame(220, $config->rateLimitPolicy?->limit);
        self::assertSame('2 minutes', $config->rateLimitPolicy?->interval);
        self::assertSame(901, $config->jwtPolicy?->ownerTtlSeconds);
        self::assertSame(601, $config->jwtPolicy?->keyTtlSeconds);
        self::assertSame(301, $config->jwtPolicy?->delegationTtlSeconds);
        self::assertSame(['https://console.cre8.local'], $config->corsPolicy?->allowedOrigins);
    }

    /** @return array<string, string> */
    private function validEnv(): array
    {
        return [
            'APP_ENV' => 'local',
            'DB_DSN' => 'pgsql:host=localhost;dbname=cre8',
            'DB_USER' => 'cre8',
            'DB_PASS' => 'cre8-pass',
            'JWT_ISSUER' => 'https://issuer.cre8.local',
            'JWT_AUDIENCE_CONSOLE' => 'console-aud',
            'JWT_AUDIENCE_GATEWAY' => 'gateway-aud',
            'JWT_PRIVATE_KEY' => '/tmp/private.pem',
            'JWT_PUBLIC_KEY' => '/tmp/public.pem',
            'CORS_ALLOWED_ORIGINS' => 'https://console.cre8.local',
            'CSRF_SECRET' => str_repeat('a', 32),
        ];
    }
}
```

## `tests/Security/ApiKeyHasherSecurityTest.php`
- **Line count:** 50

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Security;

use Cre8\Security\ApiKeyHasher;
use PHPUnit\Framework\TestCase;

final class ApiKeyHasherSecurityTest extends TestCase
{
    public function testHasherSupportsPolicyConfigurableArgonParametersAndVerification(): void
    {
        $hasher = new ApiKeyHasher(
            opsLimit: SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            memLimit: SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
        );

        $hash = $hasher->hash('cre8-secret-api-key');

        self::assertTrue($hasher->verify('cre8-secret-api-key', $hash));
        self::assertFalse($hasher->verify('wrong', $hash));
    }

    public function testHasherReturnsRotationMetadataAlongsideHashMaterial(): void
    {
        $hasher = new ApiKeyHasher();

        $metadata = $hasher->hashWithMetadata(
            'cre8-secret-api-key',
            keyVersion: 'key-v3',
            rotatedAtUtc: '2026-04-04T00:00:00Z',
        );

        self::assertSame('argon2id', $metadata['algorithm']);
        self::assertSame('key-v3', $metadata['key_version']);
        self::assertSame('2026-04-04T00:00:00Z', $metadata['rotated_at_utc']);
        self::assertTrue($hasher->verify('cre8-secret-api-key', $metadata['hash']));
    }

    public function testHasherVerificationHandlesMalformedHashUsingTimingSafeFallbackPath(): void
    {
        $hasher = new ApiKeyHasher();

        self::assertFalse($hasher->verify('cre8-secret-api-key', ''));
        self::assertFalse($hasher->verify('cre8-secret-api-key', 'not-an-argon-hash'));
    }
}
```

## `tests/Security/JwtTokenSecurityTest.php`
- **Line count:** 151

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Security;

use Cre8\Config\RuntimeConfig;
use Cre8\Security\JwtTokenSigner;
use Cre8\Security\JwtTokenVerifier;
use Cre8\Security\TokenValidationException;
use PHPUnit\Framework\TestCase;

final class JwtTokenSecurityTest extends TestCase
{
    public function testSignerProducesOwnerKeyAndDelegationTokensWithKidHeader(): void
    {
        $signer = new JwtTokenSigner($this->config());
        $verifier = new JwtTokenVerifier($this->config());

        $owner = $signer->sign(['sub' => 'owner_1', 'typ' => 'owner', 'aud' => 'console']);
        $key = $signer->sign(['sub' => 'key_1', 'typ' => 'key', 'aud' => 'gateway']);
        $delegation = $signer->sign([
            'sub' => 'delegation_1',
            'typ' => 'delegation',
            'aud' => 'gateway',
            'delegation_envelope_id' => 'env_123',
            'initial_author_key_id' => 'aauth_0123456789abcdef0123456789abcdef',
        ]);

        self::assertSame('owner', $verifier->verify($owner)->principal->type);
        self::assertSame('key', $verifier->verify($key)->principal->type);
        $delegationClaims = $verifier->verify($delegation);
        self::assertSame('delegation', $delegationClaims->principal->type);
        self::assertNotSame('', (string) ($delegationClaims->claims['jti'] ?? ''));

        self::assertNotSame('', $this->tokenHeaderKid($owner));
        self::assertNotSame('', $this->tokenHeaderKid($key));
        self::assertNotSame('', $this->tokenHeaderKid($delegation));
    }

    public function testSignerRejectsMissingRequiredClaims(): void
    {
        $signer = new JwtTokenSigner($this->config());

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $signer->sign(['typ' => 'owner', 'aud' => 'console']);
    }

    public function testVerifierRejectsInvalidAudienceTypeMapping(): void
    {
        $signer = new JwtTokenSigner($this->config());
        $verifier = new JwtTokenVerifier($this->config());
        $token = $signer->sign(['sub' => 'owner_1', 'typ' => 'owner', 'aud' => 'console']);
        $tampered = $this->rewriteClaim($token, 'aud', 'gateway');

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $verifier->verify($tampered);
    }


    public function testSignerRejectsDelegationTokenWithoutLineageClaims(): void
    {
        $signer = new JwtTokenSigner($this->config());

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $signer->sign(['sub' => 'delegation_1', 'typ' => 'delegation', 'aud' => 'gateway']);
    }

    public function testVerifierRejectsTokensExceedingPolicyTtl(): void
    {
        $signer = new JwtTokenSigner($this->config());
        $verifier = new JwtTokenVerifier($this->config());
        $token = $signer->sign([
            'sub' => 'owner_1',
            'typ' => 'owner',
            'aud' => 'console',
            'iat' => time(),
            'nbf' => time(),
            'exp' => time() + 1900,
        ]);

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_claims');
        $verifier->verify($token);
    }

    public function testVerifierRejectsInvalidSignature(): void
    {
        $verifier = new JwtTokenVerifier($this->config());

        $this->expectException(TokenValidationException::class);
        $this->expectExceptionMessage('token_invalid_signature');
        $verifier->verify('not-a-jwt-token');
    }

    private function config(): RuntimeConfig
    {
        if (!function_exists('openssl_pkey_new')) {
            self::markTestSkipped('openssl extension is required for JWT crypto tests');
        }

        $resource = openssl_pkey_new([
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'private_key_bits' => 2048,
        ]);
        self::assertNotFalse($resource);

        openssl_pkey_export($resource, $privateKey);
        $details = openssl_pkey_get_details($resource);
        self::assertIsArray($details);
        $publicKey = (string) ($details['key'] ?? '');
        self::assertNotSame('', $privateKey);
        self::assertNotSame('', $publicKey);

        return new RuntimeConfig(
            appEnv: 'local',
            dbDsn: 'sqlite::memory:',
            dbUser: 'u',
            dbPass: 'p',
            jwtIssuer: 'https://cre8.test',
            jwtAudienceConsole: 'console',
            jwtAudienceGateway: 'gateway',
            jwtPrivateKey: $privateKey,
            jwtPublicKey: $publicKey,
            corsAllowedOrigins: ['http://localhost:3000'],
            csrfSecret: str_repeat('x', 32),
        );
    }

    private function tokenHeaderKid(string $token): string
    {
        $parts = explode('.', $token);
        $header = json_decode((string) base64_decode(strtr($parts[0] ?? '', '-_', '+/')), true);

        return (string) ($header['kid'] ?? '');
    }

    private function rewriteClaim(string $token, string $claim, string $value): string
    {
        $parts = explode('.', $token);
        $payload = json_decode((string) base64_decode(strtr($parts[1] ?? '', '-_', '+/')), true);
        $payload[$claim] = $value;
        $parts[1] = rtrim(strtr(base64_encode((string) json_encode($payload)), '+/', '-_'), '=');

        return implode('.', $parts);
    }
}
```

## `tests/Security/KeyMaterialSecurityTest.php`
- **Line count:** 62

```php
<?php

declare(strict_types=1);

namespace Cre8\Tests\Security;

use Cre8\Observability\AuditEmitter;
use Cre8\Security\KeyMaterial;
use PHPUnit\Framework\TestCase;

final class KeyMaterialSecurityTest extends TestCase
{
    public function testResolveAcceptsInlinePemAndEmitsAuditEvent(): void
    {
        $audit = new InMemoryAuditEmitter();
        $pem = "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----";

        $resolved = KeyMaterial::resolve($pem, $audit, 'jwt_public');

        self::assertSame($pem, $resolved);
        self::assertSame('security.key_material.resolved', $audit->events[0]['event']);
        self::assertSame('inline', $audit->events[0]['payload']['source']);
    }

    public function testResolveRejectsWorldWritableFilePermissions(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'keymaterial-');
        file_put_contents($file, "-----BEGIN PUBLIC KEY-----\nabc\n-----END PUBLIC KEY-----\n");
        chmod($file, 0666);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('permissions are too permissive');
        KeyMaterial::resolve($file);
    }

    public function testResolveRejectsInvalidPemFormatAndAuditsReason(): void
    {
        $audit = new InMemoryAuditEmitter();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('format is invalid');

        try {
            KeyMaterial::resolve('not-a-key', $audit);
        } finally {
            self::assertSame('security.key_material.rejected', $audit->events[0]['event'] ?? null);
            self::assertSame('key_material_missing', $audit->events[0]['payload']['reason_code'] ?? null);
        }
    }
}

final class InMemoryAuditEmitter implements AuditEmitter
{
    /** @var list<array{event:string,payload:array<string,mixed>}> */
    public array $events = [];

    public function emit(string $event, array $payload = []): void
    {
        $this->events[] = ['event' => $event, 'payload' => $payload];
    }
}
```

