# Risk Register

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Track delivery, security, operational, and governance risks that could compromise SSOT adoption and runtime integrity.

## Scope
Program-level risks tied to canon and implementation convergence.

## Normative statements
- High risks MUST have owner, mitigation, and review date.
- New critical risks MUST be logged within one working day.
- Closed risks SHOULD include evidence of mitigation effectiveness.

## Interfaces / contracts
| Risk ID | Risk | Severity | Mitigation | Owner role | Status |
|---|---|---|---|---|---|
| R-001 | Keychain route drift persists | high | implement or deprecate in sync | backend/arch | open |
| R-002 | SSOT CI gates not wired in root | medium | add docs:ssot scripts + workflow | platform | open |
| R-003 | Incomplete OpenAPI coverage | medium | expand spec + sync check | API owner | open |

## Failure/rejection semantics
- Unowned high-severity risks are governance failures.
- Expired mitigation dates without update SHOULD block milestone closure.

## Verification requirements
- Review at weekly triage and release checkpoints.

## Traceability hooks
- Code refs: `composer.json`, `src/Http/Routes/RouteRegistrar.php`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php`
- Related SSOT docs: `ROADMAP_AND_MILESTONES.md`, `../50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- Need risk scoring rubric and escalation thresholds.

## Session progress (2026-04-08)
### Completed in this session
- Kept PM artifacts structured for roadmap, risk, workflow, and DoD governance.
- Maintained explicit links between SSOT quality and delivery controls.
- Prepared these docs for milestone-driven execution tracking.
### Remaining to finish this document
- [ ] Add dated milestones with owners and acceptance evidence.
- [ ] Quantify risks using probability/impact and mitigation triggers.
- [ ] Finalize SSOT-specific definition-of-done gates used in PR reviews.

