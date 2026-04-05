# Deployment & Operations

_Last updated (UTC): 2026-04-05_

## Runtime prerequisites

- PHP 8.2 runtime.
- Composer dependencies installed (`vendor/autoload.php` required at startup).
- PDO + sodium + openssl compatible environment.
- JWT key material available (inline or readable file paths).
- Required env variables set (see configuration reference).

## Boot sequence checks

`BootChecks::assert` validates:

- DI resolve for core services (token verifier/signer, audit emitter, PDO).
- Required dependency classes are present.
- key material resolves and meets safety constraints.
- profile hardening (issuer/CORS rules) is respected.
- middleware order contract stays synchronized.
- optional boot evidence file write if `BOOT_EVIDENCE_PATH` is set.

## Health verification

- `GET /health` probes DB, rate limiter, key material, and issuer HTTP dependency.
- `scripts/health_smoke.php` provides CLI smoke validation.

## Failure handling

Startup exceptions return deterministic `boot_failed` JSON with generated request ID and log structured `boot.startup_failed` event.
