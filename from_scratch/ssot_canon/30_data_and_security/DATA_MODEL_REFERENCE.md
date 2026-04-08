# Data Model Reference

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide implementation-facing field/index reference derived from canonical data model spec.

## Scope
Column-level reference, index expectations, and nullability notes.

## Normative statements
- Reference MUST not introduce semantics absent from `DATA_MODEL_SPEC.md`.
- Field names MUST align with actual schema/migrations.
- Performance-critical indexes SHOULD be listed with rationale.

## Interfaces / contracts
- Initial reference baseline imported from legacy SSOT tables (principals, credentials, token families, delegation, posts/comments).
- Mapping to repo migrations is pending formal extraction.

## Failure/rejection semantics
- Column-name drift between reference and DB schema MUST be flagged as drift.
- Missing index for documented query path SHOULD be a performance risk flag.

## Verification requirements
- Compare reference with migration scripts and DB introspection output.
- Include migration smoke evidence.

## Traceability hooks
- Code refs: `scripts/migrate_smoke.php`
- Tests refs: `tests/Contract/HealthServiceContractTest.php`
- Related SSOT docs: `DATA_MODEL_SPEC.md`, `ERD.md`, `../50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- No canonical migration manifest file is currently present for automated extraction.
