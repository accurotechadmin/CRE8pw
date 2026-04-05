# Configuration Reference

_Last updated (UTC): 2026-04-05_

## Required environment variables

- `APP_ENV` (`local|stage|prod`)
- `DB_DSN`, `DB_USER`, `DB_PASS`
- `JWT_ISSUER`, `JWT_AUDIENCE_CONSOLE`, `JWT_AUDIENCE_GATEWAY`
- `JWT_PRIVATE_KEY`, `JWT_PUBLIC_KEY` (inline PEM or path)
- `CORS_ALLOWED_ORIGINS`
- `CSRF_SECRET` (>= 32 chars)

## Optional policy variables

- `RATE_LIMIT_GLOBAL_ID` (default `global`)
- `RATE_LIMIT_GLOBAL_POLICY` (default `fixed_window`)
- `RATE_LIMIT_GLOBAL_INTERVAL` (default `1 minute`)
- `RATE_LIMIT_GLOBAL_LIMIT` (default `180`)
- `JWT_OWNER_TTL_SECONDS` (default `900`)
- `JWT_KEY_TTL_SECONDS` (default `600`)
- `JWT_DELEGATION_TTL_SECONDS` (default `300`)

## Validation/hardening rules

- Wildcard CORS (`*`) is only allowed in `local`.
- Stage/prod JWT issuer must be HTTPS URL.
- DSN must start with `sqlite:`, `mysql:`, or `pgsql:`.
- Prod cannot use SQLite DSN.
- Optional numeric policy values must be positive integers.

## Runtime mapping

`RuntimeConfig::fromEnv()` maps raw env into:

- `RuntimeConfig`
- `RateLimitPolicy`
- `CorsPolicy`
- `JwtPolicy`

Startup then revalidates profile safety in `BootChecks` and resolves key material readiness.
