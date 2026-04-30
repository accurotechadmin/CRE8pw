# CRE8 Phase 3 Unresolved Exceptions Register

- Last updated (UTC): 2026-04-30T04:30:00Z
- Current owner/session: cursor cloud agent / Phase 3 M0 batch (`P3-S0.3`)
- Phase status: **Phase 3 active — Canon Completion**
- Charter ADR: [`ADR-004`](../../docs/80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md)
- Schema mirror: this register schema mirrors the Phase 2 register defined in [`docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md`](../../docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md), substituting the `P3-EXC-###` ID prefix.

## Purpose

Track every Phase 3 exception that is retained between an authoring session and Phase 3 closure (`P3-S12.2`). An exception is anything that defers a Phase 3 deliverable, leaves a behavioral gap, or carries an open follow-up after a slice's nominal completion. Phase 3 exceptions **MUST NOT** rely on ADR-003; new ADRs are required (per `ADR-004-REQ-0003`).

## Normative requirements

- **Inherited from Phase 2 schema** (re-stated here for Phase 3 lifecycle clarity):
  - Every retained Phase 3 exception **MUST** be listed in this register before merge.
  - Each row **MUST** include `exception_id`, `slice`, `owner`, `status`, `due_utc`, `decision_ref`, and `verification_hook_ids`.
  - Rows with `status=open` or `status=blocked` **MUST** include at least one deterministic `next_command`.
  - `decision_ref` **MUST** reference an ADR ID listed in `docs/80_traceability_decisions_and_program/ADR_INDEX.md` or a `DLOG-YYYYMMDD-###` event listed in `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`. ADR-003 is **prohibited** as a Phase 3 deferral mechanism.
  - A row **MUST NOT** transition to `closed` unless supporting `evidence_paths` are populated **and** the related slice is `complete` in `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`.
- **Phase 3-specific**:
  - `exception_id` **MUST** use the `P3-EXC-###` format (zero-padded numeric, immutable once published).
  - Each open exception **MUST** be linked to at least one slice ID (`P3-S<milestone>.<slice>`) on the program plan.

## Register schema

| Field | Required | Description |
|---|---|---|
| exception_id | yes | Unique ID (`P3-EXC-###`). |
| slice | yes | Phase 3 slice scope (e.g., `P3-S1.1`). |
| owner | yes | Accountable team/role (per `docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`). |
| status | yes | `open`, `in_progress`, `blocked`, `closed`. |
| due_utc | yes | UTC date `YYYY-MM-DD` for resolution/review. |
| decision_ref | yes | ADR ID (e.g., `ADR-004`) or decision event ID (e.g., `DLOG-20260430-004`). ADR-003 prohibited. |
| verification_hook_ids | yes | One or more hook IDs for closure verification. |
| next_command | conditional | Required when `status` is `open` or `blocked`. |
| evidence_paths | no | Semicolon-separated artifact paths used when closing. |
| linked_slice_id | conditional | Required for `status=closed`; must match the `Slice` column row in `PHASE3_PROGRESS_BOARD.md` whose status is `complete`. |
| notes | no | Residual context. |

## Current Phase 3 unresolved exceptions

| exception_id | slice | owner | status | due_utc | decision_ref | verification_hook_ids | next_command | evidence_paths | linked_slice_id | notes |
|---|---|---|---|---|---|---|---|---|---|---|
| P3-EXC-001 | P3-S0.4 | Program Traceability WG | open | 2026-05-07 | ADR-004 | HOOK-SSOT-LINK-INTEGRITY | `composer docs:ssot:lint` | `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`; `reports/session_handoffs/SESSION_HANDOFF_20260430-0419.md` |  | Repo hygiene baseline deferred from initial M0 batch; tracked residual until completed. |
| P3-EXC-002 | P3-S2.3 | Program Traceability WG | open | 2026-05-13 | ADR-004 | HOOK-TRACE-MATRIX-COVERAGE; HOOK-SSOT-REPORT-COVERAGE | `composer docs:ssot:report` | `reports/ssot/coverage_latest.json`; `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` |  | Traceability backfill remains incomplete (`untraced_requirements` > 0). |



## Change-impact map reference

- Template: [`docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`](../../docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md).
- Session-artifact expectation: a Change Impact Map under `reports/change_impact_maps/<UTC>-<slice-id>.md` **MUST** accompany any row added, removed, or status-shifted in this register.

## Verification

- Manual gate: each row reviewed at session-end before commit.
- Future automation hook: `HOOK-SSOT-PHASE3-EXCEPTION-REGISTER-SCHEMA` (target, scheduled under `P3-S11.2`) — same shape as `HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA` from `scripts/docs_ssot_phase2_exceptions_check.php`, retargeted for Phase 3 IDs.

## See also

- [Phase 3 progress board](./PHASE3_PROGRESS_BOARD.md)
- [Phase 3 program plan](../PHASE3_AUTHORING_PROGRAM_PLAN.md)
- [Phase 3 entry audit](../PHASE3_ENTRY_AUDIT_20260430-0356.md)
- [ADR-004 Record](../../docs/80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md)
- [Decisions Log](../../docs/80_traceability_decisions_and_program/DECISIONS_LOG.md)
- [Phase 2 Unresolved Exceptions Register (schema source)](../../docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md)
