---
doc_id: CRE8-TRACE-RISK-REGISTER
version: 1.0.0
status: provisional-normative
owner: Security WG
reviewers:
  - Platform Architecture WG
  - Docs Governance WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/80_traceability_decisions_and_program/ADR_INDEX.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Risk Register

## Purpose
This document defines the canonical risk-to-control-to-evidence register for Phase 1 and beyond, including severity thresholds, ownership obligations, and review cadence.

## Normative requirements
- **CRE8-TRACE-REQ-0050**: Every active risk **MUST** have a unique `RISK-###` identifier, a named owner, a current status, and at least one mapped control.
- **CRE8-TRACE-REQ-0051**: Risk severity **MUST** be calculated from `Likelihood (1-5)` and `Impact (1-5)` using `Severity Score = Likelihood x Impact`.
- **CRE8-TRACE-REQ-0052**: Severity class **MUST** map as: `critical` (20-25), `high` (12-19), `medium` (6-11), `low` (1-5).
- **CRE8-TRACE-REQ-0053**: `critical` and `high` risks **MUST** include mitigation due date, verification hook ID, and escalation target before normative change approval.
- **CRE8-TRACE-REQ-0054**: Every risk row **MUST** reference impacted requirement IDs and at least one evidence path proving current control state.
- **CRE8-TRACE-REQ-0055**: Risk status transitions (`open`, `mitigating`, `accepted`, `closed`) **MUST** be logged in `DECISIONS_LOG.md` when severity class is `high` or `critical`.

## Risk schema
| Field | Type | Required | Rule |
|---|---|---:|---|
| Risk ID | string | yes | `RISK-###` immutable |
| Title | string | yes | Short risk statement |
| Domain | enum | yes | governance, contract, security, operations, delivery |
| Likelihood (1-5) | integer | yes | 1-5 inclusive |
| Impact (1-5) | integer | yes | 1-5 inclusive |
| Severity Score | integer | yes | `Likelihood x Impact` |
| Severity Class | enum | yes | low, medium, high, critical |
| Owner | string | yes | Accountable role/team |
| Status | enum | yes | open, mitigating, accepted, closed |
| Controls | list | yes | Control IDs or control statements |
| Verification Hook IDs | list | yes | Hook IDs proving mitigation |
| Impacted Requirement IDs | list | yes | `CRE8-*-REQ-####` |
| Evidence Paths | list | yes | Relative evidence/doc paths |
| Mitigation Due (UTC) | date | conditional | Required for high/critical |

## Baseline risks
| Risk ID | Title | Domain | Likelihood (1-5) | Impact (1-5) | Severity Score | Severity Class | Owner | Status | Controls | Verification Hook IDs | Impacted Requirement IDs | Evidence Paths | Mitigation Due (UTC) |
|---|---|---|---:|---:|---:|---|---|---|---|---|---|---|---|
| RISK-001 | Requirement ID drift across docs and machine artifacts | governance | 4 | 4 | 16 | high | Docs Governance WG | mitigating | Enforce ID regex and uniqueness checks in lint | HOOK-TRACE-MATRIX-ID-VALIDATION | CRE8-TRACE-REQ-0001, CRE8-TRACE-REQ-0002 | docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md | 2026-05-06 |
| RISK-002 | Missing requirement-to-hook coverage for new normative docs | delivery | 3 | 4 | 12 | high | Platform Architecture WG | open | Merge gate requiring traceability row and hook link | HOOK-TRACE-MATRIX-COVERAGE | CRE8-TRACE-REQ-0003, CRE8-TRACE-REQ-0008 | docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md | 2026-05-10 |

## Verification hooks
- **HOOK-TRACE-RISK-SCORE**: Validate score math and severity class mapping.
- **HOOK-TRACE-RISK-HIGHCRIT-FIELDS**: Validate due date/escalation/verification fields for high and critical rows.
- **HOOK-TRACE-RISK-LINKAGE**: Validate requirement IDs and evidence paths resolve.

## See also
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Decisions Log](./DECISIONS_LOG.md)
- [ADR Index](./ADR_INDEX.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
