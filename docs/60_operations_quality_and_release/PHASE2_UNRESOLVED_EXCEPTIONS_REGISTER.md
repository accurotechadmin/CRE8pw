---
doc_id: CRE8-OPS-PHASE2-EXCEPTIONS-REGISTER
version: 1.0.0
status: provisional-normative
owner: Operations Quality WG
reviewers:
  - Program Traceability WG
  - Docs Governance WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-14
source_seed_refs:
  - reports/PHASE1_CANON_HARDENING_ROADMAP.md
  - docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md
normative_dependencies:
  - docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md
  - reports/session_handoffs/PHASE2_PROGRESS_BOARD.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/80_traceability_decisions_and_program/DECISIONS_LOG.md
---

# Phase 2 Unresolved Exceptions Register

## Purpose
Define the canonical register format for unresolved exceptions retained while Phase 2 remains active.

## Normative requirements
- **CRE8-OPS-REQ-0015**: Any unresolved Phase 2 exception retained after acceptance-bundle execution **MUST** be listed in this register before merge.
- **CRE8-OPS-REQ-0016**: Each exception row **MUST** include `exception_id`, `lane_or_slice`, `owner`, `status`, `due_utc`, `decision_ref`, and `verification_hook_ids`.
- **CRE8-OPS-REQ-0017**: Rows with `status=open` or `status=blocked` **MUST** include at least one deterministic next verification command in `next_command`.
- **CRE8-OPS-REQ-0018**: `decision_ref` **MUST** reference an ADR ID or a `DECISION-YYYYMMDD-###` event logged in `DECISIONS_LOG.md`.
- **CRE8-OPS-REQ-0019**: A row **MUST NOT** transition to `closed` unless supporting evidence path(s) are populated and the related item is removed or marked complete in `PHASE2_PROGRESS_BOARD.md`.

## Register schema
| Field | Required | Description |
|---|---|---|
| exception_id | yes | Unique ID (`P2-EXC-###`). |
| lane_or_slice | yes | Lane/Slice scope (e.g., `Lane B / P2-DB-006`). |
| owner | yes | Accountable team/role. |
| status | yes | `open`, `in_progress`, `blocked`, `closed`. |
| due_utc | yes | UTC date `YYYY-MM-DD` for resolution/review. |
| decision_ref | yes | ADR ID or decision event ID. |
| verification_hook_ids | yes | One or more hook IDs for closure verification. |
| next_command | conditional | Required when `status` is `open` or `blocked`. |
| evidence_paths | no | Semicolon-separated artifact paths used when closing. |
| notes | no | Residual context. |

## Current unresolved exceptions
| exception_id | lane_or_slice | owner | status | due_utc | decision_ref | verification_hook_ids | next_command | evidence_paths | notes |
|---|---|---|---|---|---|---|---|---|---|
| P2-EXC-001 | Lane B / P2-DB-001 | Identity & Policy WG | in_progress | 2026-05-06 | ADR-003 | HOOK-AUTH-INHERITANCE-BOUNDARY; HOOK-AUTH-LIFECYCLE-ENFORCEMENT; HOOK-CONTRACT-POLICY-ORDER | composer test:contract:auth |  | Multi-ancestor runtime matrix breadth still pending beyond fixture-depth checks. |
| P2-EXC-002 | Lane B / P2-DB-002 | Platform Architecture WG | in_progress | 2026-05-10 | ADR-003 | HOOK-IDENTITY-ID-FIRST-ISSUANCE; HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION | composer test:contract:identity-issuance && composer test:contract:identity-context |  | Runtime-integrated multi-actor issuance/context breadth pending. |
| P2-EXC-003 | Lane B / P2-DB-006 | Security Engineering WG | in_progress | 2026-05-12 | ADR-003 | HOOK-SEC-LIFECYCLE-PROPAGATION | composer test:contract:lifecycle |  | Multi-actor descendant lifecycle propagation coverage pending. |

## Verification hooks
- **HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA**: Validate register row schema, ID format, mandatory fields, and command requirement for open/blocked rows.

## See also
- [Phase 2 Acceptance Criteria](./PHASE2_ACCEPTANCE_CRITERIA.md)
- [Phase 2 Progress Board](../../reports/session_handoffs/PHASE2_PROGRESS_BOARD.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Decisions Log](../80_traceability_decisions_and_program/DECISIONS_LOG.md)
