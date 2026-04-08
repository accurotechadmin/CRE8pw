# Data Model Spec

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Declare canonical domain entities, invariants, and lifecycle semantics.

## Scope
Principal/auth/delegation/content/moderation data model contracts.

## Normative statements
- Schema changes MUST be reflected in reference model and ERD in same PR.
- Token family and delegation lineage data MUST support replay and audit controls.
- Soft-delete and moderation retention SHOULD preserve incident reconstruction.

## Interfaces / contracts
- Core entities: principals, credentials, token_families, delegation_envelopes, posts/comments/moderation_actions.
- Implementation anchor uses PDO with prepared statements and transactions.

## Failure/rejection semantics
- Invariant violations (duplicate active membership, invalid lifecycle transition) MUST reject writes.
- Missing required audit lineage fields SHOULD block release.

## Verification requirements
- Contract tests for lifecycle and data behaviors.
- Migration smoke checks for schema compatibility.

## Traceability hooks
- Code refs: `src/Application/*`, `scripts/migrate_smoke.php`
- Tests refs: `tests/Contract/HealthServiceContractTest.php` (db path), future schema tests
- Related SSOT docs: `DATA_MODEL_REFERENCE.md`, `ERD.md`, `../20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`

## Open questions / known gaps
- Full table-level spec still needs migration-by-migration mapping from legacy SSOT.
