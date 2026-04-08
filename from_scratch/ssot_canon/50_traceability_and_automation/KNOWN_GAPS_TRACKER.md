# Known Gaps Tracker

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Maintain a canonical ledger of unresolved canon↔code or canon↔legacy conflicts.

## Scope
All unresolved drifts affecting correctness, security, or delivery confidence.

## Normative statements
- Every known drift MUST include owner role, severity, target date, and mitigation.
- Closed gaps MUST reference the resolving PR/change.
- Critical security gaps MUST be escalated immediately.

## Interfaces / contracts
| Gap ID | Summary | Severity | Owner role | Target date | Current status |
|---|---|---|---|---|---|
| GAP-001 | Keychain member/resolve routes in docs but not mounted | high | backend+architecture | 2026-04-30 | open |
| GAP-002 | Root composer missing docs:ssot scripts | medium | platform | 2026-04-22 | open |
| GAP-003 | Legacy pipeline doc omitted ErrorHandler stage | low | docs | 2026-04-15 | canon-fixed |

## Failure/rejection semantics
- Untracked known gap discovered in review is process failure.
- Expired target dates without update SHOULD be escalated in release review.

## Verification requirements
- Weekly gap review and monthly governance audit.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`, `composer.json`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php`
- Related SSOT docs: `TRACEABILITY_MATRIX.md`, `../00_governance/CHANGE_CONTROL_POLICY.md`

## Open questions / known gaps
- Need agreement on severity rubric and SLA per severity level.

## Session progress (2026-04-08)
### Completed in this session
- Maintained templates and structure for SSOT drift prevention workflows.
- Preserved linkage points among requirements, code references, and tests.
- Prepared these docs for CI automation rule authoring.
### Remaining to finish this document
- [ ] Populate the traceability matrix with capability-level mappings.
- [ ] Define CI lint checks and failure policies for SSOT-code drift.
- [ ] Track open gaps with owners, target dates, and risk severity.

