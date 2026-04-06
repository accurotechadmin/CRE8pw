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
- required env vars present per `Configuration_Environment_Contract.md`

## Boot assertions
- Core DI resolvability
- dependency class presence
- key material safety checks
- profile hardening constraints
- middleware-order contract alignment

## Health checks
- `GET /health` validates DB (`ext-pdo`), limiter/cache dependencies (`symfony/rate-limiter`, `symfony/cache`), key material, and issuer dependency
- smoke script support and expected behavior are defined in `Operational_Smoke_Check_Contract.md`

## SLO instrumentation ownership baseline
- Signal ownership and alert authority are defined in `SLO_SLI_SPEC.md` and are operationally required.
- Platform/SRE owner is default dashboard owner for availability, health, and error-budget signals.
- Backend maintainer lead is dashboard owner for route-level latency signals (auth + feed).
- Platform on-call is the primary page receiver unless `SLO_SLI_SPEC.md` defines route-family-specific override.

## Infrastructure linkage
- Canonical topology and IaC requirements are defined in `Infrastructure_IaC_Reference.md`.
- Backup/restore and secret-isolation expectations from infrastructure SSOT are operationally required.
- Startup profile and boot failure behavior are defined in `Boot_and_Startup_Failure_Contract.md`.

## Failure model
- Deterministic `boot_failed` JSON with request ID
- structured startup failure event emission
