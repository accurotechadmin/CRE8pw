# Operations Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Runtime prerequisites
- PHP 8.2
- Composer dependencies present (`vendor/autoload.php`)
- PDO + sodium + openssl
- JWT key material configured and readable
- required env vars present

## Boot assertions
- Core DI resolvability
- dependency class presence
- key material safety checks
- profile hardening constraints
- middleware-order contract alignment

## Health checks
- `GET /health` validates DB, limiter, key material, issuer dependency
- smoke script support via `scripts/health_smoke.php`

## Failure model
- Deterministic `boot_failed` JSON with request ID
- structured startup failure event emission
