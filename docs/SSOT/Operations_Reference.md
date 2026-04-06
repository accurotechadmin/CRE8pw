# Operations Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Runtime prerequisites
- PHP 8.2
- Composer dependencies present (`vendor/autoload.php`)
- Dependency baseline satisfied per `Dependency_Reference.md` (`slim/slim`, `slim/psr7`, `php-di/php-di`, `firebase/php-jwt`, `respect/validation`, `vlucas/phpdotenv`, `neomerx/cors-psr7`, `monolog/monolog`, `symfony/rate-limiter`, `symfony/cache`, `guzzlehttp/guzzle`, `phpunit/phpunit`)
- PDO + sodium + openssl extensions available (`ext-pdo`, `ext-sodium`, `openssl`)
- JWT key material configured and readable
- required env vars present

## Boot assertions
- Core DI resolvability
- dependency class presence
- key material safety checks
- profile hardening constraints
- middleware-order contract alignment

## Health checks
- `GET /health` validates DB (`ext-pdo`), limiter/cache dependencies (`symfony/rate-limiter`, `symfony/cache`), key material, and issuer dependency
- smoke script support via `scripts/health_smoke.php`

## Failure model
- Deterministic `boot_failed` JSON with request ID
- structured startup failure event emission
