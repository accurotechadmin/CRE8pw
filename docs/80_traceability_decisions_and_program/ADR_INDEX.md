---
doc_id: CRE8-TRACE-ADR-INDEX
version: 1.2.0
status: provisional-normative
owner: Architecture Governance WG
reviewers:
  - Security WG
  - Docs Governance WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md
  - docs/80_traceability_decisions_and_program/DECISIONS_LOG.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
---

# ADR Index

## Purpose
This document defines the canonical index contract for Architecture Decision Records (ADRs), including status taxonomy, ordering semantics, backlink requirements, and publication gates.

## Normative requirements
- **CRE8-TRACE-REQ-0030**: Every published ADR **MUST** be listed in this index exactly once using ADR ID format `ADR-###` with zero-padded numeric sequence.
- **CRE8-TRACE-REQ-0031**: ADR IDs **MUST** be immutable after publication; supersession **MUST** be modeled through `Superseded by` and `Supersedes` fields, not by reusing IDs.
- **CRE8-TRACE-REQ-0032**: Index rows **MUST** include `ADR ID`, `Title`, `Status`, `Date (UTC)`, `Owner`, `Impacted Requirement IDs`, `Impacted Risk IDs`, and `Link`.
- **CRE8-TRACE-REQ-0033**: `Status` **MUST** be one of `proposed`, `accepted`, `rejected`, `superseded`, or `deprecated`.
- **CRE8-TRACE-REQ-0034**: ADR ordering **MUST** be descending by ADR numeric ID; ties are invalid and **MUST** fail review.
- **CRE8-TRACE-REQ-0035**: Every `accepted`, `superseded`, or `deprecated` ADR **MUST** have a corresponding append-only event in `DECISIONS_LOG.md`.
- **CRE8-TRACE-REQ-0036**: Every indexed ADR **MUST** backlink to at least one requirement in `TRACEABILITY_MATRIX.md` unless explicitly marked governance-editorial with justification.

## ADR index schema
| Field | Type | Required | Rule |
|---|---|---:|---|
| ADR ID | string | yes | `ADR-###` unique, immutable |
| Title | string | yes | Concise decision statement |
| Status | enum | yes | `proposed|accepted|rejected|superseded|deprecated` |
| Date (UTC) | date | yes | ISO `YYYY-MM-DD` |
| Owner | string | yes | Team or role accountable |
| Impacted Requirement IDs | list | yes | `CRE8-*-REQ-####` or `none` with reason |
| Impacted Risk IDs | list | yes | `RISK-###` or `none` with reason |
| Link | path | yes | Relative path to ADR markdown artifact |

## Baseline index entries
| ADR ID | Title | Status | Date (UTC) | Owner | Impacted Requirement IDs | Impacted Risk IDs | Link |
|---|---|---|---|---|---|---|---|
| ADR-005 | Authorization gate order reconciliation | accepted | 2026-04-30 | Identity & Policy WG | CRE8-AUTH-REQ-0001, CRE8-AUTH-REQ-0010, CRE8-AUTH-REQ-0011 | RISK-010 | ./records/ADR-005-authz-gate-order-reconciliation.md |
| ADR-004 | Phase 3 — Canon Completion Program Charter | accepted | 2026-04-30 | Platform Architecture WG | CRE8-TRACE-REQ-0001, CRE8-TRACE-REQ-0005, CRE8-OPS-REQ-0010 | RISK-001, RISK-002, RISK-010, RISK-011, RISK-012, RISK-013, RISK-014 | ./records/ADR-004-phase3-program-charter.md |
| ADR-003 | Phase 1 Freeze Closure with Explicit Residual-Breadth Waiver | accepted | 2026-04-29 | Platform Architecture WG | CRE8-ACCEPT-REQ-0001, CRE8-ACCEPT-REQ-0006 | RISK-004 | ./records/ADR-003-phase1-freeze-waiver.md |
| ADR-001 | Requirement ID Normalization | accepted | 2026-04-29 | Docs Governance WG | CRE8-TRACE-REQ-0001, CRE8-TRACE-REQ-0002 | RISK-001 | ./records/ADR-001-requirement-id-normalization.md |
| ADR-002 | Traceability Matrix Minimum Schema | accepted | 2026-04-29 | Architecture Governance WG | CRE8-TRACE-REQ-0003, CRE8-TRACE-REQ-0004 | RISK-002 | ./records/ADR-002-traceability-matrix-minimum-schema.md |


## Published ADR records
- [ADR-001: Requirement ID Normalization](./records/ADR-001-requirement-id-normalization.md)
- [ADR-002: Traceability Matrix Minimum Schema](./records/ADR-002-traceability-matrix-minimum-schema.md)
- [ADR-003: Phase 1 Freeze Closure with Explicit Residual-Breadth Waiver](./records/ADR-003-phase1-freeze-waiver.md)
- [ADR-005: Authorization gate order reconciliation](./records/ADR-005-authz-gate-order-reconciliation.md)
- [ADR-004: Phase 3 — Canon Completion Program Charter](./records/ADR-004-phase3-program-charter.md)

## Verification hooks
- **HOOK-TRACE-ADR-INDEX-UNIQUE**: Validate ADR ID uniqueness and immutability in index history.
- **HOOK-TRACE-ADR-INDEX-STATUS**: Validate status values against allowed taxonomy.
- **HOOK-TRACE-ADR-INDEX-BACKLINK**: Validate requirement and risk backlinks resolve to existing artifacts.

## Change history

- 2026-04-30 (v1.1.0): Added ADR-004 (Phase 3 — Canon Completion Program Charter) row at head and published-records bullet. Change Impact Map: [`reports/change_impact_maps/20260430-0400-P3-S0.2-adr-004-program-charter.md`](../../reports/change_impact_maps/20260430-0400-P3-S0.2-adr-004-program-charter.md).

## See also
- [Decision Record Template](./DECISION_RECORD_TEMPLATE.md)
- [Decisions Log](./DECISIONS_LOG.md)
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Risk Register](./RISK_REGISTER.md)
- [Change Control Policy](../00_governance/CHANGE_CONTROL_POLICY.md)
- [Change Impact Map Templates](./CHANGE_IMPACT_MAP_TEMPLATES.md)
