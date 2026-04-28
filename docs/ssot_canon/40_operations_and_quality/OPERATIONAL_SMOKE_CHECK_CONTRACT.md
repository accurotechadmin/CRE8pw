# Operational Smoke Check Contract (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Define canonical operational smoke-check behaviors, expected outcomes, and failure evidence requirements for release readiness.

## Canonical smoke commands
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`
- `composer test:security` (auth-boundary subset required per this contract)

## Health smoke contract
`ops:health-smoke` must:
- call `/health` against configured base URL,
- require HTTP `200`,
- parse JSON envelope,
- validate `data.status` in `ok|degraded`,
- fail with deterministic machine-readable failure codes when invalid.

## Async projection health smoke extension
When `ARCH_PROJECTION_ASYNC=true`, `ops:health-smoke` must also validate:
- `data.services.projection_async` presence and schema (`lag_ms`, `queue_depth`, `dead_letter_depth`),
- deterministic degraded-state assertion when lag/depth thresholds are exceeded during failure injection,
- canonical envelope/error semantics remain unchanged while status is `degraded`.

## Migration smoke contract
`ops:migrate-smoke` must:
- validate migration artifact presence according to current migration strategy,
- execute migration sanity validation against ephemeral DB target,
- verify required core table set for target release profile,
- fail with deterministic machine-readable failure codes when artifacts/schema are missing.

## Auth-context boundary smoke contract
Auth-boundary smoke checks validate non-interchangeability of gateway and console authentication contexts in CRE8: the Credential Registry Engine.

Required checks:
- gateway routes reject owner-context tokens with canonical deny envelopes,
- console routes reject gateway key-context tokens with canonical deny envelopes,
- token `typ` confusion and audience confusion checks fail closed,
- gateway device-binding mismatch and missing-device scenarios fail closed,
- replaying a valid token on the wrong surface fails closed with stable detail codes.

Evidence requirements for auth-boundary smoke:
- command output from `composer test:security` showing the auth-boundary subset pass,
- explicit list of checked route families and token/context combinations,
- stable envelope `error.code` + `details.code` outcomes for each denied replay case,
- timestamp and environment profile.


## Architecture-upgrade integrated smoke controls
`ops:health-smoke` and `ops:migrate-smoke` are release-blocking controls for integrated PDP, BFF-by-surface, and CQRS-lite runtime semantics.

Required integrated assertions:
- PDP enforcement readiness: smoke evidence includes deterministic deny-path stability for policy decision middleware and no auth-context interchangeability regressions.
- BFF-by-surface readiness: smoke evidence confirms gateway and console route-family health checks run independently and fail closed on cross-surface dependency drift.
- CQRS-lite readiness: smoke evidence confirms projection mode subchecks reflect configured mode (`ARCH_PROJECTION_ASYNC=false` or `true`) with deterministic status outputs.
- Security hardening linkage: each smoke run references current SEC-01 and SEC-02 abuse-suite evidence identifiers in the release package.

Failure-code requirements:
- `ops:health-smoke` emits stable machine codes for `health_unreachable`, `health_schema_invalid`, `health_status_invalid`, and `health_projection_async_invalid`.
- `ops:migrate-smoke` emits stable machine codes for `migration_artifact_missing`, `migration_execution_failed`, and `migration_schema_incomplete`.
- Any auth-boundary smoke subset failure emits `security_boundary_smoke_failed` with attached denied-case matrix key.

## Evidence requirements
Each smoke execution must produce:
- command output,
- pass/fail status,
- failure reason code (if failed),
- timestamp and environment profile.

## Reconciliation rule
If migration strategy, boundary rules, or artifact paths change, smoke scripts and this contract must be updated in the same PR.

## Release gate linkage
- Gate A requires health smoke success.
- Gate D requires migration smoke and rollback-readiness evidence.
- Architecture-upgrade slices that modify auth boundary behavior require passing auth-context boundary smoke evidence.

## Related SSOT docs
- `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md`
- `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`
- `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md`
- `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md`
- `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`
- `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`
