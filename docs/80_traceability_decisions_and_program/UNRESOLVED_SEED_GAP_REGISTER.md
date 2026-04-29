---
doc_id: CRE8-TRACE-SEED-GAP-REGISTER
version: 1.0.0
status: provisional-normative
owner: Program Traceability WG
reviewers:
  - Docs Governance WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-06
source_seed_refs:
  - seed/CRE8_SEED_CANON_ASSESSMENT_REPORT.md
  - seed/CRE8_SEED_PRESERVATION_MATRIX.md
normative_dependencies:
  - docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md
  - docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md
  - docs/80_traceability_decisions_and_program/RISK_REGISTER.md
---

# Unresolved Seed Gap Register

## Purpose
Define the canonical register for seed requirements that are not yet promoted into mature normative docs and require explicit triage.

## Normative requirements
- **CRE8-TRACE-REQ-0080**: Any seed requirement lacking an approved target requirement ID **MUST** be recorded in this register within the same session where the gap is identified.
- **CRE8-TRACE-REQ-0081**: Each gap record **MUST** include `gap_id`, `seed_requirement_ref`, `gap_class`, `proposed_target_slice`, `owner`, and `resolution_due_utc`.
- **CRE8-TRACE-REQ-0082**: `gap_class` **MUST** be one of `missing_doc`, `missing_requirement`, `verification_missing`, `conflict`, or `deferred_scope`.
- **CRE8-TRACE-REQ-0083**: Records older than `resolution_due_utc` **MUST** be reviewed and either resolved or escalated in `RISK_REGISTER.md`.
- **CRE8-TRACE-REQ-0084**: A gap **MUST NOT** be marked `closed` unless the associated promotion tracker row reaches `promoted`, `retired`, or `deferred` with decision reference.
- **CRE8-TRACE-REQ-0085**: Gap records with `gap_class=conflict` **MUST** reference an ADR or decision event documenting precedence resolution.

## Register schema
| Field | Required | Description |
|---|---|---|
| gap_id | yes | Unique ID (`GAP-###`). |
| seed_requirement_ref | yes | Seed source path + anchor/identifier. |
| gap_class | yes | `missing_doc`, `missing_requirement`, `verification_missing`, `conflict`, `deferred_scope`. |
| proposed_target_slice | yes | Roadmap slice ID intended to resolve gap. |
| owner | yes | Accountable team/role. |
| status | yes | `open`, `in_progress`, `blocked`, `closed`. |
| resolution_due_utc | yes | UTC due date for resolution/review. |
| tracker_ref | yes | Reference to row or ID in Seed Promotion Tracker. |
| risk_ref | no | Optional risk reference (`RISK-###`). |
| decision_ref | no | Optional ADR/event reference. |

## Initial unresolved gaps
| gap_id | seed_requirement_ref | gap_class | proposed_target_slice | owner | status | resolution_due_utc | tracker_ref | notes |
|---|---|---|---|---|---|---|---|---|
| GAP-001 | seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md#permission-evaluation-order | missing_requirement | S6 | Platform Architecture WG | open | 2026-05-10 | seed-promo-row-001 | Target requirement IDs not yet authored. |
| GAP-002 | seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md#error-envelope-determinism | missing_requirement | S6 | Platform Architecture WG | open | 2026-05-10 | seed-promo-row-002 | Machine/prose parity contract pending. |
| GAP-003 | seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md#revoke-rotate-propagation | verification_missing | S8 | Ops Quality WG | open | 2026-05-17 | seed-promo-row-003 | Verification hook exists as placeholder only. |

## Verification hooks
- **HOOK-SEED-GAP-SCHEMA**: Validate required fields and enum values for all gap rows.
- **HOOK-SEED-GAP-DUE-DATE**: Flag overdue open gaps for escalation.
- **HOOK-SEED-GAP-TRACKER-SYNC**: Validate each open gap has matching tracker row.

## See also
- [Seed Promotion Tracker](./SEED_PROMOTION_TRACKER.md)
- [Roadmap and Milestones](./ROADMAP_AND_MILESTONES.md)
- [Risk Register](./RISK_REGISTER.md)
- [Seed Preservation Matrix](../../seed/CRE8_SEED_PRESERVATION_MATRIX.md)
