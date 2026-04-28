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
