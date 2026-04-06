# Production Readiness Gates

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Gate A: Build/runtime integrity
- Dependencies installable in CI/CD from lockfile.
- App boots with no startup exceptions.
- `/health` returns subsystem pass (`db`, `rate_limiter`, `jwt_keys`, `issuer_dependency`).

## Gate B: Contract/security quality
- Contract tests pass.
- Security tests pass.
- No undocumented API or envelope changes.
- JWT claim, CSRF, CORS, and limiter behavior verified against SSOT.

## Gate C: UX parity
- All declared endpoint/UI mappings implemented.
- Error-state mappings validated for 401/403/404/422/429/5xx.
- Correlation IDs surfaced in UI diagnostics.

## Gate D: Operational readiness
- Rollback rehearsal completed.
- Key rotation runbook validated.
- Alerting/dashboard checks pass for SLO/SLI targets.

## Exit criteria
A release is eligible only when all gates pass and `RELEASE_CHECKLIST.md` is complete.
