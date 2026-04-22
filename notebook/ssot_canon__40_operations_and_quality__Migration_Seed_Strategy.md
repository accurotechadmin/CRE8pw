# Migration Seed Strategy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-09_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Purpose
Define deterministic migration and seed execution behavior required for boot validation, smoke checks, and release readiness.

## Strategy
- Migrations are forward-only and versioned with monotonically increasing identifiers.
- Production paths run migrations without demo seed data.
- Non-production paths may run minimal deterministic seed fixtures for smoke and QA.
- Migration execution must be idempotent at the version ledger level.

## Required migration artifacts
- Schema migration scripts for all table contracts in `DATA_MODEL_SPEC.md`.
- Migration ledger table (or equivalent) that records applied versions and timestamps.
- Validation command for schema presence and version state.

## Required seed artifacts
- `owner_seed` (non-production only): one owner account fixture.
- `auth_seed` (non-production only): one keychain and one member key fixture.
- `content_seed` (optional): minimal post/comment fixtures for contract smoke.

## Safety rules
- Seed execution is forbidden by default in `prod`.
- Seed artifacts must never include plaintext secrets committed to VCS.
- Migration + seed commands must emit machine-readable pass/fail output.

## Command contract
- `composer ops:migrate-smoke` validates migration artifact presence and schema baseline.
- Optional seed smoke command must verify deterministic fixture counts where enabled.

## Verification linkage
- Related smoke semantics are defined in `OPERATIONAL_SMOKE_CHECK_CONTRACT.md`.
- Release proof requirements are defined in `RELEASE_CHECKLIST.md`.
- Traceability updates for schema behavior changes are required in `TRACEABILITY_MATRIX.md`.
