# Configuration and Environment Contract (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define the canonical runtime environment-variable contract, default policy values, and profile hardening constraints required for deterministic CRE8 boot behavior.

## Required environment variables
- `APP_ENV` (`local|stage|prod`)
- `DB_DSN`
- `DB_USER`
- `DB_PASS`
- `JWT_ISSUER`
- `JWT_AUDIENCE_CONSOLE`
- `JWT_AUDIENCE_GATEWAY`
- `JWT_PRIVATE_KEY` (inline PEM or path)
- `JWT_PUBLIC_KEY` (inline PEM or path)
- `CORS_ALLOWED_ORIGINS` (comma-separated)
- `CSRF_SECRET` (minimum length 32)

## Optional policy variables (with defaults)
- `RATE_LIMIT_GLOBAL_ID` (default: `global`)
- `RATE_LIMIT_GLOBAL_POLICY` (default: `fixed_window`)
- `RATE_LIMIT_GLOBAL_INTERVAL` (default: `1 minute`)
- `RATE_LIMIT_GLOBAL_LIMIT` (default: `180`)
- `JWT_OWNER_TTL_SECONDS` (default: `900`)
- `JWT_KEY_TTL_SECONDS` (default: `600`)
- `JWT_DELEGATION_TTL_SECONDS` (default: `300`)
- `BOOT_EVIDENCE_PATH` (optional path for startup evidence JSON)

## Profile hardening constraints
- `APP_ENV` must be one of `local|stage|prod`.
- Wildcard CORS (`*`) is allowed only in `local`.
- `JWT_ISSUER` must be a valid URL.
- `JWT_ISSUER` must be `https://` in `stage|prod`.
- `DB_DSN` must use `sqlite:`, `mysql:`, or `pgsql:` prefixes.
- `prod` must not use SQLite DSN.
- Optional numeric policy variables must be positive integers.
- In `stage|prod`, private-key file paths must satisfy strict permission checks.

## Key material source rules
- `JWT_PRIVATE_KEY` and `JWT_PUBLIC_KEY` may be:
  1. inline PEM, or
  2. filesystem paths.
- Relative key paths are resolved against repository root at startup.
- PEM strings must include end markers; key paths must be readable.

## Runtime mapping contract
Environment values are mapped into:
- `RuntimeConfig`
- `RateLimitPolicy`
- `CorsPolicy`
- `JwtPolicy`

Boot validation then performs:
- profile safety checks,
- key source resolvability,
- key path safety checks,
- middleware-order alignment checks.

## Related SSOT docs
- `Boot_and_Startup_Failure_Contract.md`
- `Operations_Reference.md`
- `Security_Controls_Spec.md`
- `Dependency_Reference.md`
