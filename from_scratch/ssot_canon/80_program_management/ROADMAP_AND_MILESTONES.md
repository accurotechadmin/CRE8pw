# Roadmap and Milestones

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide phased execution roadmap from scaffold to adopted, enforceable SSOT canon.

## Scope
Documentation maturity milestones and linked implementation outcomes.

## Normative statements
- Each milestone MUST define exit criteria and measurable deliverables.
- Milestone slippage SHOULD trigger risk register updates.
- Security and contract milestones MAY NOT be skipped.

## Interfaces / contracts
| Milestone | Target | Exit criteria |
|---|---|---|
| M1 Scaffold complete | 2026-04 | full file structure + starter content |
| M2 Contract completeness | 2026-05 | full route/OpenAPI/error sync |
| M3 Automation enforcement | 2026-05 | root CI docs:ssot gates active |
| M4 Adoption gate | 2026-06 | governance signoff, canon precedence active |

## Failure/rejection semantics
- Missing exit evidence means milestone remains open.
- Declaring completion without traceability evidence is invalid.

## Verification requirements
- Monthly roadmap review against traceability and known gaps reports.

## Traceability hooks
- Code refs: `from_scratch/ssot_canon/SCAFFOLD_BUILD_REPORT.md`
- Tests refs: n/a
- Related SSOT docs: `RISK_REGISTER.md`, `../50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- Need resourcing assumptions and capacity model for milestone dates.
