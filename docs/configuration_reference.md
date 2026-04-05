# Configuration Reference (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Define runtime environment variables and validation semantics.

## 1) Variable catalog template

| Variable | Required | Type | Example | Validation rule | Applies to env(s) | Notes |
|---|---|---|---|---|---|---|
| APP_ENV | yes | enum/string | `local` | must be present | all | runtime profile selector |
| JWT_ISSUER | yes | URL | `https://...` | strict in stage/prod | all | issuer claim source |
| _(expand all vars)_ | | | | | | |

## 2) Typed policy mapping

- Map env vars to:
  - `RuntimeConfig`
  - `JwtPolicy`
  - `CorsPolicy`
  - `RateLimitPolicy`

## 3) Safety constraints checklist

- [ ] Stage/prod issuer/cors hardening constraints documented.
- [ ] Private/public key sourcing behavior documented.
- [ ] TTL and rate-limit tuning guardrails documented.
- [ ] Failure mode examples documented (`boot_failed`, validation exceptions).

## 4) Extensibility notes

When adding new env vars:

- add to validator,
- map into typed config,
- add tests,
- update this reference and ops docs.
