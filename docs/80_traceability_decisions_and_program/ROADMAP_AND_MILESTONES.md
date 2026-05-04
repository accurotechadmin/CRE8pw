---
doc_id: CRE8-TRACE-ROADMAP
version: 1.0.0
status: normative
owner: Program Traceability WG
reviewers:
  - Docs Governance WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - reports/PHASE1_CANON_HARDENING_ROADMAP.md
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/00_governance/DEFINITION_OF_DONE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/80_traceability_decisions_and_program/DECISIONS_LOG.md
  - docs/80_traceability_decisions_and_program/RISK_REGISTER.md
---

# Roadmap And Milestones

## Purpose
Define the canonical roadmap control contract for SSOT maturation so milestones, scope changes, and acceptance criteria are deterministic, traceable, and review-gated.

## Normative requirements
- **CRE8-TRACE-REQ-0060**: The roadmap **MUST** enumerate Phase slices with, at minimum: `slice_id`, `objective`, `entry_criteria`, `exit_criteria`, `owner`, and `verification_hooks`.
- **CRE8-TRACE-REQ-0061**: A slice **MUST NOT** be marked complete until all listed exit criteria are satisfied and linked evidence exists in the traceability matrix.
- **CRE8-TRACE-REQ-0062**: Changes to slice objective, scope, or exit criteria **MUST** include a corresponding decision event in [`DECISIONS_LOG.md`](DECISIONS_LOG.md) and reference at least one ADR ID when tradeoffs are architectural.
- **CRE8-TRACE-REQ-0063**: Roadmap milestone dates **MUST** be expressed in UTC ISO date format (`YYYY-MM-DD`) and **MUST** declare whether they are target or committed dates.
- **CRE8-TRACE-REQ-0064**: For every blocked slice, the roadmap **MUST** record `blocking_reason`, `blocking_owner`, and `next_review_utc`.
- **CRE8-TRACE-REQ-0065**: Each slice **MUST** map its top risks to `RISK-###` identifiers and define at least one mitigation checkpoint.
- **CRE8-TRACE-REQ-0066**: A roadmap update PR **MUST** include an impact summary covering affected requirements, changed verification hooks, and changed evidence artifacts.

## Required roadmap schema
| Field | Required | Description |
|---|---|---|
| slice_id | yes | Canonical slice key (e.g., `S1`, `S2`). |
| objective | yes | Deterministic objective statement for completion. |
| owner | yes | Accountable team/role. |
| status | yes | `not_started`, `in_progress`, `partially_complete`, `complete`, `blocked`. |
| entry_criteria | yes | Preconditions required before active work. |
| exit_criteria | yes | Required outcomes to mark slice complete. |
| target_date_utc | yes | Target completion date in UTC. |
| date_commitment_type | yes | `target` or `committed`. |
| verification_hooks | yes | Hook IDs required for acceptance. |
| evidence_refs | yes | Paths or matrix references proving acceptance. |
| risk_refs | no | Related risks (`RISK-###`). |
| decision_refs | no | Related ADR/decision refs (`ADR-###`, event IDs). |

## Phase 1 baseline milestones
| slice_id | status | owner | target_date_utc | date_commitment_type | notes |
|---|---|---|---|---|---|
| S1 | complete | Docs Governance WG | 2026-04-29 | target | Governance bootstrap hardened. |
| S2 | in_progress | Program Traceability WG | 2026-05-01 | target | Promotion tracker and unresolved-gap register pending hardening. |
| S3 | partially_complete | Docs Governance WG | 2026-05-03 | target | Cross-link policy not yet centralized. |
| S4 | in_progress | Docs Governance WG | 2026-05-05 | target | RACI coverage expansion pending. |
| S5 | in_progress | Program Traceability WG | 2026-04-30 | target | Roadmap artifact hardened in this session; automation alignment pending. |
| S6 | not_started | Platform Architecture WG | 2026-05-10 | target | Contract domain hardening not started. |
| S7 | not_started | Platform Architecture WG | 2026-05-13 | target | Prose-machine sync contract not started. |
| S8 | not_started | Ops Quality WG | 2026-05-17 | target | Verification catalog pending. |
| S9 | not_started | Ops Quality WG | 2026-05-20 | target | CI hard-fail gates pending. |
| S10 | not_started | Program Traceability WG | 2026-05-24 | target | Acceptance review and freeze pending. |

## Verification hooks
- **HOOK-ROADMAP-SCHEMA-CHECK**: Validate required roadmap schema fields and status enums.
- **HOOK-ROADMAP-EVIDENCE-LINK-CHECK**: Validate each complete slice has evidence references in traceability artifacts.
- **HOOK-ROADMAP-BLOCKER-FRESHNESS**: Validate blocked slices include `next_review_utc` and that it is not stale.

## See also
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Decisions Log](./DECISIONS_LOG.md)
- [Risk Register](./RISK_REGISTER.md)
- [Change Control Policy](../00_governance/CHANGE_CONTROL_POLICY.md)
- [Definition of Done](../00_governance/DEFINITION_OF_DONE.md)
- [Phase 1 Canon Hardening Roadmap Report](../../reports/PHASE1_CANON_HARDENING_ROADMAP.md)
