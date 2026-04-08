# ADR Index

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Maintain an authoritative index of architectural and policy decisions that materially shape the SSOT canon and implementation behavior.

## Scope
All accepted/proposed/superseded Architecture Decision Records (ADRs) for CRE8 canon and runtime.

## Normative statements
- Any material architectural policy change MUST have an ADR entry before adoption.
- ADR status MUST be one of `proposed`, `accepted`, `superseded`, `deprecated`.
- Superseded ADRs SHOULD link to the replacement ADR.

## Interfaces / contracts
| ADR ID | Title | Status | Date | Supersedes | Related SSOT docs |
|---|---|---|---|---|---|
| ADR-000 | ADR process bootstrap | accepted | 2026-04-08 | - | `../00_governance/CHANGE_CONTROL_POLICY.md` |
| ADR-001 | SSOT canon precedence activation gate | proposed | 2026-04-08 | - | `../00_governance/SSOT_INDEX.md` |

## Failure/rejection semantics
- Missing ADR for major architecture/security direction change MUST block adoption.
- ADR entries without traceable linked docs SHOULD fail governance review.

## Verification requirements
- Governance review checks ADR linkage for class A/B changes.
- PR checklist validates ADR ID when required.

## Traceability hooks
- Code refs: `src/`, `code/src/Modules/*`
- Tests refs: `tests/Contract/*`, `tests/Security/*`
- Related SSOT docs: `../00_governance/CHANGE_CONTROL_POLICY.md`, `DECISION_RECORD_TEMPLATE.md`, `DECISIONS_LOG.md`

## Open questions / known gaps
- ADR markdown file storage convention (single file vs per-ADR files) is still open.

## Session progress (2026-04-08)
### Completed in this session
- Kept ADR/decision docs consistently structured and cross-link ready.
- Prepared decision workflow artifacts for chronological governance.
- Standardized template usage for future architectural records.
### Remaining to finish this document
- [ ] Backfill historical key decisions and supersession chains.
- [ ] Assign statuses and dates for accepted/proposed/superseded records.
- [ ] Link each decision to affected SSOT and implementation artifacts.

