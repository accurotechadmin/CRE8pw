# Production Readiness Gates

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Gate A: Build/runtime integrity
- Dependencies installable in CI/CD from lockfile.
- App boots with no startup exceptions.
- Startup behavior matches `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md`.
- `/health` returns subsystem pass (`db`, `rate_limiter`, `jwt_keys`, `issuer_dependency`).

## Gate B: Contract/security quality
- Contract tests pass.
- Security tests pass.
- Abuse-case security regressions pass.
- No undocumented API or envelope changes.
- JWT claim, CSRF, CORS, and limiter behavior verified against SSOT.

## Gate C: UX parity
- All declared endpoint/UI mappings implemented.
- Error-state mappings validated for 401/403/404/422/429/5xx.
- Correlation IDs surfaced in UI diagnostics.

## Gate D: Operational readiness
- Rollback rehearsal completed.
- Key rotation runbook validated.
- Infrastructure/IaC evidence reviewed (plan/apply + backup/restore readiness).
- Alerting/dashboard checks pass for SLO/SLI targets.
- Operational smoke checks pass per `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`.
- Architecture-upgrade integrated smoke evidence package includes: `composer ops:health-smoke`, `composer ops:migrate-smoke`, and auth-boundary subset output from `composer test:security`.
- Gate evidence links SEC-01 and SEC-02 security hardening results and confirms deterministic deny-code parity remained stable during the release candidate run.
- Gate evidence confirms configured projection mode (`ARCH_PROJECTION_ASYNC`) and matching `/health` degraded-threshold behavior.

## Exit criteria
A release is eligible only when all gates pass, `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md` is complete, and the architecture-upgrade evidence payload contains explicit links to UA-20, UB-18, UC-21, OPS-01, SEC-01, and SEC-02 validation artifacts.
