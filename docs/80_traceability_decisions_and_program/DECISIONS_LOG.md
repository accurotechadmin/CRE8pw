---
doc_id: CRE8-TRACE-DECISIONS-LOG
version: 1.0.0
status: provisional-normative
owner: Architecture Governance WG
reviewers:
  - Platform Architecture WG
  - Docs Governance WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/80_traceability_decisions_and_program/ADR_INDEX.md
  - docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
---

# Decisions Log

## Purpose
This document defines the append-only operational log for architecture and governance decisions that affect normative requirements, risk posture, or verification obligations.

## Normative requirements
- **CRE8-TRACE-REQ-0040**: Decision events **MUST** be append-only; existing rows **MUST NOT** be modified except to correct typographical errors with a correction note.
- **CRE8-TRACE-REQ-0041**: Every event row **MUST** include `Event ID`, `Timestamp (UTC)`, `ADR ID`, `Event Type`, `Actor`, `Change Summary`, `Impacted Requirement IDs`, and `Evidence Link`.
- **CRE8-TRACE-REQ-0042**: `Event Type` **MUST** be one of `created`, `status_changed`, `superseded`, `deprecated`, `rollback_invoked`, or `editorial_correction`.
- **CRE8-TRACE-REQ-0043**: Every `status_changed`, `superseded`, or `deprecated` event **MUST** reference a corresponding row in `ADR_INDEX.md` and **MUST** include prior and new status values in `Change Summary`.
- **CRE8-TRACE-REQ-0044**: Events impacting requirements **MUST** include at least one `CRE8-*-REQ-####` identifier and **MUST** trigger traceability-matrix update before merge.
- **CRE8-TRACE-REQ-0045**: `rollback_invoked` events **MUST** include rollback trigger, scope boundary, and restoration verification evidence path.

## Event schema
| Field | Type | Required | Rule |
|---|---|---:|---|
| Event ID | string | yes | `DLOG-YYYYMMDD-###` unique |
| Timestamp (UTC) | datetime | yes | ISO-8601 UTC |
| ADR ID | string | yes | `ADR-###` |
| Event Type | enum | yes | Allowed values in REQ-0042 |
| Actor | string | yes | Approver or automation actor |
| Change Summary | string | yes | Includes status transition when relevant |
| Impacted Requirement IDs | list | yes | `none` allowed only for editorial correction |
| Evidence Link | path | yes | Relative path to ADR/evidence artifact |

## Baseline events
| Event ID | Timestamp (UTC) | ADR ID | Event Type | Actor | Change Summary | Impacted Requirement IDs | Evidence Link |
|---|---|---|---|---|---|---|---|
| DLOG-20260429-003 | 2026-04-29T12:05:00Z | ADR-003 | status_changed | Platform Architecture WG | proposed -> accepted for Phase 1 freeze closure and residual-breadth waiver policy | CRE8-ACCEPT-REQ-0001, CRE8-ACCEPT-REQ-0006 | ./records/ADR-003-phase1-freeze-waiver.md |
| DLOG-20260429-001 | 2026-04-29T03:40:00Z | ADR-001 | status_changed | Docs Governance WG | proposed -> accepted for requirement ID normalization | CRE8-TRACE-REQ-0001, CRE8-TRACE-REQ-0002 | ./records/ADR-001-placeholder.md |
| DLOG-20260429-002 | 2026-04-29T03:45:00Z | ADR-002 | status_changed | Architecture Governance WG | proposed -> accepted for traceability matrix schema | CRE8-TRACE-REQ-0003, CRE8-TRACE-REQ-0004 | ./records/ADR-002-placeholder.md |

## Verification hooks
- **HOOK-TRACE-DECISION-APPENDONLY**: Assert stable hash for historical rows and detect non-tail edits.
- **HOOK-TRACE-DECISION-EVENT-TYPE**: Validate event type taxonomy and required fields by event type.
- **HOOK-TRACE-DECISION-ADR-LINK**: Validate ADR references exist in `ADR_INDEX.md` and target ADR file path resolves.

## See also
- [ADR Index](./ADR_INDEX.md)
- [Decision Record Template](./DECISION_RECORD_TEMPLATE.md)
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Definition of Done](../00_governance/DEFINITION_OF_DONE.md)
