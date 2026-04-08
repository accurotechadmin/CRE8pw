# Deprecation and Versioning Policy

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Establish canonical approach for API/document/schema versioning and deprecation lifecycle.

## Scope
HTTP contracts, SSOT docs, schemas, and operational behavior changes.

## Normative statements
- Any deprecation MUST be announced in docs before behavior removal.
- Versioned artifacts MUST preserve compatibility guarantees defined in migration strategy.
- SSOT doc status SHOULD reflect deprecation state transitions.

## Interfaces / contracts
| Artifact type | Version unit | Deprecation signal | Removal gate |
|---|---|---|---|
| API route/field | v1 semantic patch | docs note + release checklist | readiness gates pass |
| SSOT doc section | status tag | changelog + known gaps | governance approval |
| JSON schema | schema version | schema changelog entry | contract tests green |

## Failure/rejection semantics
- Silent removals are contract violations.
- Unversioned breaking changes MUST be rejected.

## Verification requirements
- Release review verifies deprecation notices and removal criteria.

## Traceability hooks
- Code refs: `from_scratch/ssot_canon/openapi/cre8.v1.yaml`
- Tests refs: `tests/Contract/RouteRegistrarContractsTest.php`
- Related SSOT docs: `MIGRATION_AND_COMPATIBILITY_STRATEGY.md`, `../40_operations_and_quality/PRODUCTION_READINESS_GATES.md`

## Open questions / known gaps
- Need canonical changelog file for versioned contract history.

## Session progress (2026-04-08)
### Completed in this session
- Preserved guidance scaffolds for migration, ownership, deprecation, and fixtures.
- Aligned guidance scope to modularization and compatibility outcomes.
- Prepared these docs for stepwise implementation planning.
### Remaining to finish this document
- [ ] Define concrete module ownership and accountability map.
- [ ] Add compatibility windows and deprecation schedules with enforcement rules.
- [ ] Tie fixture/test-data strategy to existing test suites and CI pipelines.

