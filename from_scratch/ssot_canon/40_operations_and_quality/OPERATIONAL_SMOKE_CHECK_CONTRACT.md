# Operational Smoke Check Contract (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Purpose
Define canonical operational smoke-check behaviors, expected outcomes, and failure evidence requirements for release readiness.

## Canonical smoke commands
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`

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

## Evidence requirements
Each smoke execution must produce:
- command output,
- pass/fail status,
- failure reason code (if failed),
- timestamp and environment profile.

## Reconciliation rule
If migration strategy or artifact paths change, smoke scripts and this contract must be updated in the same PR.

## Release gate linkage
- Gate A requires health smoke success.
- Gate D requires migration smoke and rollback-readiness evidence.

## Related SSOT docs
- `RELEASE_CHECKLIST.md`
- `VERIFICATION_STRATEGY.md`
- `Migration_Seed_Strategy.md`
- `PRODUCTION_READINESS_GATES.md`
