# ADR-006: Phase 4 Program Lock and Legacy Waiver Retirement

- **Status:** accepted
- **Date (UTC):** 2026-05-04
- **Owner:** Program Traceability WG
- **Supersedes:** ADR-004 (program charter scope), ADR-003 (freeze waiver usage)
- **Impacted Requirement IDs:** CRE8-TRACE-REQ-0005, CRE8-TRACE-REQ-0043, CRE8-TRACE-REQ-0054, CRE8-TRACE-REQ-0074
- **Impacted Risk IDs:** RISK-002, RISK-010, RISK-014

## Context
Phase 4 has advanced to milestone M8 and requires explicit lock conditions for traceability, risk mapping, and seed-promotion closure. Legacy waiver posture from ADR-003 and Phase 3 program-specific governance language in ADR-004 require reconciliation with the current Phase 4 closure model.

## Decision
1. ADR-004 program-charter control language is superseded for active execution by this ADR during M8 closure.
2. ADR-003 freeze-waiver mechanics are deprecated for current canonical promotions and MUST NOT be used for Phase 4 exception handling.
3. Phase 4 exceptions MUST use active registers and ADR-bounded expiry policies already codified in operational and extensibility requirements.

## Consequences
- Decision and ADR index artifacts must explicitly represent status transitions for ADR-003 and ADR-004.
- Risk and seed-promotion trackers must align to active Phase 4 closure posture without references to legacy waiver mechanics.

## Verification and evidence
- `docs/80_traceability_decisions_and_program/ADR_INDEX.md`
- `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`
- `docs/80_traceability_decisions_and_program/RISK_REGISTER.md`
- `docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md`
