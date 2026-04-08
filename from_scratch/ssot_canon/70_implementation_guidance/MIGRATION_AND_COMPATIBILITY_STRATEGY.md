# Migration and Compatibility Strategy

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define how contract and data changes are introduced safely with backward-compatibility and migration windows.

## Scope
API versioning, schema migrations, and behavior toggles during transition from legacy SSOT/code to canon-driven state.

## Normative statements
- Breaking API/data changes MUST include migration plan and compatibility window.
- Deprecations MUST have announced removal date and mitigation path.
- Migration plans SHOULD include rollback validation steps.

## Interfaces / contracts
- Compatibility modes: additive, dual-path, hard-cutover.
- Required migration artifacts: impact map, release checklist delta, smoke evidence.

## Failure/rejection semantics
- Breaking changes without documented transition policy MUST block release.
- Compatibility assumptions not validated in tests are high-risk gaps.

## Verification requirements
- Run contract/security/smoke suites in both old/new compatibility paths where applicable.

## Traceability hooks
- Code refs: `scripts/migrate_smoke.php`, `src/Http/Routes/RouteRegistrar.php`
- Tests refs: `tests/Contract/*`
- Related SSOT docs: `DEPRECATION_AND_VERSIONING_POLICY.md`, `../40_operations_and_quality/RELEASE_CHECKLIST.md`, `../30_data_and_security/DATA_MODEL_SPEC.md`

## Open questions / known gaps
- Need explicit policy for deprecation window length by change severity.

## Session progress (2026-04-08)
### Completed in this session
- Preserved guidance scaffolds for migration, ownership, deprecation, and fixtures.
- Aligned guidance scope to modularization and compatibility outcomes.
- Prepared these docs for stepwise implementation planning.
### Remaining to finish this document
- [ ] Define concrete module ownership and accountability map.
- [ ] Add compatibility windows and deprecation schedules with enforcement rules.
- [ ] Tie fixture/test-data strategy to existing test suites and CI pipelines.

