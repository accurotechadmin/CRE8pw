# Verification Strategy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Automated suites
- Test framework dependency: `phpunit/phpunit` (see `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`).
- Contract tests (`tests/Contract/*`)
- Security tests (`tests/Security/*`)
- Abuse-case regressions aligned with `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`

## Required commands
- `composer test`
- `composer test:contract`
- `composer test:security`
- `composer qa`
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`

Smoke command semantics and evidence requirements are defined in `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`.

## Release verification scope
- Envelope stability
- Middleware decision/detail-code behavior (`slim/slim`, `respect/validation`, `neomerx/cors-psr7`, `symfony/rate-limiter`)
- Boot assertions and profile hardening
- JWT signing/verification and key safety (`firebase/php-jwt`, `ext-sodium`)
- Health endpoint and migration smoke

## Acceptance criteria enforcement
- Route acceptance intent is defined in `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` and must be used during QA signoff.
- Authorization truth-table behavior is validated against `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`.
- Middleware detail-code behavior is validated against `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`.

## Stable QA script (manual)
- owner login + console list/create/moderation
- key login + feed/post/comments
- key lifecycle revoke confirmation path
- invite issuance path


## CI baseline gate contract
- Every architecture-upgrade PR executes `composer qa`, `composer test:contract`, `composer test:security`, and `composer ops:health-smoke` in CI.
- CI fails closed when any required command fails or is missing from the workflow.
- PR evidence links include command outputs or CI job URLs for all required commands.

## Surface-boundary verification contract
- Verification includes explicit non-interchangeability checks for gateway and console auth contexts.
- Security regression suites include token `typ` confusion, audience confusion, and gateway device-binding mismatch scenarios.
- Release candidates are blocked when cross-surface replay or boundary confusion tests pass unexpectedly.

## Upgrade-feature-flag verification
- `ARCH_PDP_ENABLED`, `ARCH_BFF_SPLIT_ENABLED`, and `ARCH_CQRS_LITE_ENABLED` default to `false` until slice activation evidence is approved.
- `ARCH_PROJECTION_ASYNC=true` requires projection lag and replay/idempotency evidence in the same validation run.
- `ARCH_POLICY_DECISION_LOG` output is retained in CI artifacts for policy regression triage during PDP rollout.
