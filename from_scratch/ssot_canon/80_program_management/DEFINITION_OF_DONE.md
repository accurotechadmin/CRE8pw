# Definition of Done (SSOT-Impacting Work)

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide objective completion criteria for SSOT-impacting implementation and documentation changes.

## Scope
PR-level done criteria for class A/B/C/D changes.

## Normative statements
- Work is done only when docs, code, tests, and evidence are synchronized.
- Known gaps entries MUST exist for intentionally deferred deltas.
- Merge SHOULD be blocked when required commands fail.

## Interfaces / contracts
### Done checklist
- Canon docs updated
- OpenAPI/schema updated if contract changed
- Route inventory/error catalog/traceability matrix synced
- Required tests pass
- Smoke/release evidence attached where required
- ADR and impact map included if policy/architecture changed

## Failure/rejection semantics
- Partial updates across docs/code/tests are not done.
- Missing evidence artifacts for readiness gates are not done.

## Verification requirements
- Reviewer enforces checklist completion in PR.

## Traceability hooks
- Code refs: `composer.json`, `from_scratch/ssot_canon/*`
- Tests refs: `tests/Contract/*`, `tests/Security/*`
- Related SSOT docs: `../00_governance/CHANGE_CONTROL_POLICY.md`, `../40_operations_and_quality/PRODUCTION_READINESS_GATES.md`

## Open questions / known gaps
- Need integration with repository PR template and CI status checks.

## Session progress (2026-04-08)
### Completed in this session
- Kept PM artifacts structured for roadmap, risk, workflow, and DoD governance.
- Maintained explicit links between SSOT quality and delivery controls.
- Prepared these docs for milestone-driven execution tracking.
### Remaining to finish this document
- [ ] Add dated milestones with owners and acceptance evidence.
- [ ] Quantify risks using probability/impact and mitigation triggers.
- [ ] Finalize SSOT-specific definition-of-done gates used in PR reviews.

