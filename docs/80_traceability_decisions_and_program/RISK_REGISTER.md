---
doc_id: CRE8-TRACE-RISK-REGISTER
version: 1.1.0
status: provisional-normative
owner: Security WG
reviewers:
  - Platform Architecture WG
  - Docs Governance WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
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
| RISK-001 | Requirement ID drift across docs and machine artifacts | governance | 4 | 4 | 16 | high | Docs Governance WG | mitigating | Enforce ID regex and uniqueness checks in lint | HOOK-SSOT-LINT-REQID-UNIQUE | CRE8-TRACE-REQ-0001, CRE8-TRACE-REQ-0002 | docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md | 2026-05-06 |
| RISK-002 | Missing requirement-to-hook coverage for new normative docs | delivery | 3 | 4 | 12 | high | Platform Architecture WG | open | Merge gate requiring traceability row and hook link | HOOK-TRACE-MATRIX-COVERAGE | CRE8-TRACE-REQ-0003, CRE8-TRACE-REQ-0008 | docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md | 2026-05-10 |
| RISK-010 | Authoring drift between concurrent Phase slices | delivery | 4 | 4 | 16 | high | Program Traceability WG | mitigating | Slice predecessor enforcement; one slice in progress per author at a time; mandatory progress board updates per session under active Phase 4 lock | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE, HOOK-TRACE-DECISION-ADR-LINK | CRE8-TRACE-REQ-0005, CRE8-TRACE-REQ-0043 | reports/PHASE4_CANON_COMPLETION_MILESTONES.md, reports/session_handoffs/PHASE4_PROGRESS_BOARD.md | 2026-06-30 |
| RISK-011 | OpenAPI schema and example desynchronization | contract | 4 | 4 | 16 | high | API Contracts WG | open | Schema/example coverage hooks enforced at CI under M11 | HOOK-CONTRACT-SCHEMA-COVERAGE, HOOK-CONTRACT-EXAMPLE-COVERAGE, HOOK-OPENAPI-LINT | ADR-004-REQ-0007, CRE8-MACHINE-REQ-0012 | docs/31_machine_contracts/openapi/cre8.v1.yaml, docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | 2026-06-30 |
| RISK-012 | Glossary churn invalidating downstream prose | governance | 3 | 3 | 9 | medium | Docs Governance WG | open | Glossary lint runs on every PR after P3-S2.5; term changes require change-impact map | HOOK-SSOT-GLOSSARY-COVERAGE | CRE8-GOV-REQ-0015, ADR-004-REQ-0007 | docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md | 2026-06-15 |
| RISK-013 | Threat model lags route additions | security | 4 | 5 | 20 | critical | Security WG | open | Each new route slice MUST add or extend a threat row + abuse case | HOOK-SEC-THREAT-CONTROL-MATRIX | CRE8-SEC-REQ-0006, ADR-004-REQ-0007 | docs/40_data_security_and_crypto/SECURITY_THREAT_MODEL.md, docs/40_data_security_and_crypto/SECURITY_VERIFICATION_ABUSE_CASES.md | 2026-06-15 |
| RISK-014 | Trace coverage regression while adding requirements | delivery | 4 | 4 | 16 | high | Program Traceability WG | mitigating | CI fails on `untraced_requirements > 0`; Phase 4 sessions MUST run requirement inventory and traceability-matrix closure before handoff publication | HOOK-TRACE-MATRIX-COVERAGE, HOOK-SSOT-REPORT-COVERAGE-COVERAGE | CRE8-TRACE-REQ-0003, CRE8-TRACE-REQ-0008, CRE8-TRACE-REQ-0044 | reports/ssot/coverage_latest.json, reports/session_handoffs/PHASE4_PROGRESS_BOARD.md | 2026-06-30 |

## Verification hooks
- **HOOK-TRACE-RISK-SCORE**: Validate score math and severity class mapping.
- **HOOK-TRACE-RISK-HIGHCRIT-FIELDS**: Validate due date/escalation/verification fields for high and critical rows.
- **HOOK-TRACE-RISK-LINKAGE**: Validate requirement IDs and evidence paths resolve.

## Change history

- 2026-04-30 (v1.1.0): Added Phase 3 risks `RISK-010` (authoring drift), `RISK-011` (schema/example desync), `RISK-012` (glossary churn), `RISK-013` (threat model lag), `RISK-014` (trace coverage regression) per [Phase 3 program plan](../../reports/PHASE3_AUTHORING_PROGRAM_PLAN.md) §4. Change Impact Map: [`reports/change_impact_maps/20260430-0400-P3-S0.2-adr-004-program-charter.md`](../../reports/change_impact_maps/20260430-0400-P3-S0.2-adr-004-program-charter.md).

## See also
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Decisions Log](./DECISIONS_LOG.md)
- [ADR Index](./ADR_INDEX.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Change Impact Map Templates](./CHANGE_IMPACT_MAP_TEMPLATES.md)
