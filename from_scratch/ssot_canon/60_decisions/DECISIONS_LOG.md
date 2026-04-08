# Decisions Log

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Track short-form chronological decision events before they are promoted to formal ADRs or canon updates.

## Scope
Temporary decision ledger for active rebuild period.

## Normative statements
- Significant decisions SHOULD be logged within 24 hours.
- Each log item MUST identify expected doc/code/test impact.
- Log items MUST be promoted to ADR or closed as discarded decision.

## Interfaces / contracts
| Date | Decision summary | Impact class | Owner role | Status | Promotion target |
|---|---|---|---|---|---|
| 2026-04-08 | Add decision layer to SSOT canon scaffold | governance | architecture | open | ADR-000 |
| 2026-04-08 | Add evidence template hierarchy | operations | qa/platform | open | release template docs |

## Failure/rejection semantics
- Decisions with unclear status older than one sprint SHOULD be escalated.
- Unpromoted critical decisions MAY cause policy drift.

## Verification requirements
- Weekly governance triage of open log items.

## Traceability hooks
- Code refs: n/a
- Tests refs: n/a
- Related SSOT docs: `ADR_INDEX.md`, `../00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`

## Open questions / known gaps
- Need automation to prevent stale decision entries.

## Session progress (2026-04-08)
### Completed in this session
- Kept ADR/decision docs consistently structured and cross-link ready.
- Prepared decision workflow artifacts for chronological governance.
- Standardized template usage for future architectural records.
### Remaining to finish this document
- [ ] Backfill historical key decisions and supersession chains.
- [ ] Assign statuses and dates for accepted/proposed/superseded records.
- [ ] Link each decision to affected SSOT and implementation artifacts.

