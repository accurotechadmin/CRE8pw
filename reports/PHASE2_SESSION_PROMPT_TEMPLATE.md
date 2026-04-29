# Reusable Prompt Template — CRE8 Phase 2 Machine-Contract Lock-In Session Driver

Use this prompt at the start of each fresh expert coding LLM session.

---

## COPY/PASTE PROMPT START

You are continuing **CRE8 Phase 2 — Machine contract lock-in** work in this repository.

Phase 1 is already acceptance-complete (with ADR-003 waiver semantics) and your job is to execute Phase 2 depth work without regressing governance rigor, traceability discipline, or prose↔machine parity guarantees.

### Mission for this session
Work through a **small, high-quality batch** of Phase 2 issues (usually 2–5 issues per session), convert deferred/manual/depth residuals into executable, evidence-backed outcomes, and leave behind a **clear handoff report** so the next session can continue without re-discovery.

### Mandatory sequence: read these references in order before making changes
1. `README.md` (especially Phase 2 context and long-range platform intent)
2. `docs/00_governance/SSOT_INDEX.md`
3. `docs/00_governance/CHANGE_CONTROL_POLICY.md`
4. `docs/00_governance/DEFINITION_OF_DONE.md`
5. `docs/80_traceability_decisions_and_program/ADR_INDEX.md`
6. `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`
7. `docs/80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md`
8. `reports/PHASE1_CANON_HARDENING_ROADMAP.md`
9. `reports/PHASE1_COMPLETION_AUDIT_20260429-1133.md`
10. `reports/PHASE1_TRUE_COMPLETION_EXECUTION_20260429-1153.md`
11. `reports/session_handoffs/PHASE1_PROGRESS_BOARD.md`
12. `reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md`
13. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
14. The latest 3–5 files under `reports/session_handoffs/SESSION_HANDOFF_*.md`
15. `reports/REPO_STUDY_HIGH_LEVEL_REPORT_2026-04-29.md`
16. `reports/PHASE_PLAN_AND_RECORDS_STATUS_SUMMARY_2026-04-29.md`
17. `reports/session_handoffs/PHASE2_PROGRESS_BOARD.md` (if present; otherwise create in this session before close)
18. `docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`
19. `docs/31_machine_contracts/openapi/cre8.v1.yaml`
20. `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`
21. `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`
22. `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`
23. `docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md`
24. `docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md`

### Phase 2 objective model (non-optional)
Treat these as the Phase 2 completion drivers:
1. Convert residual manual verification hooks to executable automation with deterministic pass/fail behavior.
2. Expand deferred Slice 6/7 breadth into owner-assigned, hook-bound, test-verified milestones.
3. Strengthen prose↔OpenAPI↔schema parity depth for core and newly promoted route families.
4. Enforce traceability completeness: requirement -> hook -> evidence -> owner -> decision linkage.
5. Preserve governance gates: no untracked deferred work, no silent scope drift, no unverifiable normative changes.

### Mandatory operating model
1. **Assess current state first**
   - Locate latest handoff via `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`.
   - Open `reports/session_handoffs/PHASE2_PROGRESS_BOARD.md` first for the current Phase 2 lane state and burn-down tables; if missing, bootstrap it before other edits.
   - Summarize:
     - last completed,
     - in progress,
     - blocked,
     - next queued,
     - open manual hooks,
     - deferred Slice 6/7 breadth items.
   - Confirm current phase as **Phase 2** and explicitly restate ADR-003 constraints.

2. **Select a focused batch (2–5 issues)**
   - Choose contiguous issues from one or two tightly related lanes:
     - contract depth,
     - machine parity,
     - verification automation,
     - traceability hardening.
   - Prioritize highest-risk residuals first (auth inheritance/lifecycle, identity issuance/context isolation, surface parity, feed interaction deny mapping).
   - Explicitly list chosen issues before editing.

3. **Execute with normative + machine-contract rigor**
   - Keep/extend deterministic MUST/SHOULD/MAY requirements.
   - Update both prose and machine artifacts where behavior is changed.
   - Update route parity tables and schema references when routes/payloads evolve.
   - Preserve and extend requirement IDs, hook IDs, and decision references.

4. **Verification and evidence discipline (required each session)**
   - Run relevant checks for touched scope (e.g., SSOT lint/sync/report, parity checks, contract tests).
   - If automation is still missing, create/extend explicit backlog row with owner, priority, target command, and due/date context.
   - Record exact command outputs and failure semantics.

5. **Phase 2 traceability hygiene**
   - Every changed requirement must map to:
     - trace row(s),
     - verification hook(s),
     - evidence location,
     - ownership,
     - decision/risk entry when applicable.
   - Any deferred item must include explicit owner + due date + decision reference.

6. **Produce end-of-session handoff artifacts (required)**
   - Create/update timestamped handoff:
     - `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`
   - Update stable pointer:
     - `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
   - Update progress tracker:
     - `reports/session_handoffs/PHASE2_PROGRESS_BOARD.md`
       - If it does not exist yet, create it.
       - Keep a “latest 5 handoffs” list.
   - If you changed Phase 2 status interpretation, reflect it in:
     - `reports/PHASE_PLAN_AND_RECORDS_STATUS_SUMMARY_2026-04-29.md` (or create a newer dated status summary and reference it in the handoff).

### Session scope guardrails
- Do **not** attempt all remaining Phase 2 work in one session.
- Prefer a few fully verified conversions over broad shallow edits.
- If ambiguous, log assumptions and make reversible decisions.
- Do not claim “complete” unless evidence demonstrates closure of stated acceptance criteria.

### Required deliverables this session
By the end of this session, provide all of the following:

1. **Changed files** with concise rationale.
2. **Issue-level completion report** for each selected issue:
   - Objective
   - Changes made
   - Requirement IDs/hook IDs added or updated
   - Verification performed (exact commands)
   - Residual risks / open questions
3. **Phase 2 status snapshot**:
   - Lane/slice-by-slice status (`not started`, `in progress`, `partially complete`, `complete`, `blocked`)
   - Percent estimate and confidence per lane/slice
4. **Next-session pickup plan**:
   - Top 3–7 next issues
   - Dependency notes
   - Suggested first commands/files for the next session

### Required handoff report format
Use this structure in `SESSION_HANDOFF_<timestamp>.md`:

```md
# CRE8 Phase 2 Session Handoff
- Timestamp (UTC):
- Session focus lanes/slices:
- Branch/commit:

## 1) What I reviewed first
- Latest handoff pointer used:
- Key Phase 2 references reviewed in order:

## 2) Issues selected for this session
1. ...
2. ...

## 3) Work completed
### Issue X
- Objective:
- Files changed:
- Requirement IDs added/updated:
- Hook IDs added/updated:
- Verification commands + outcomes:
- Notes:

## 4) Current Phase 2 status board
| Lane/Slice | Status | % (est.) | Confidence | Notes |
|---|---|---:|---|---|

## 5) Risks, blockers, and decisions
- Risks:
- Blockers:
- ADR/decision notes:
- Deferred items (owner + due date + decision_ref):

## 6) Next-session pickup guide
- Start here:
- Next issues (priority order):
- Suggested commands:
```

### Progress board format (always maintained)
Maintain `PHASE2_PROGRESS_BOARD.md` with:
- Last updated timestamp.
- Current owner/session.
- Master checklist of Phase 2 lanes and key issues.
- Residual manual-hook burn-down table.
- Deferred breadth decomposition table (owner, hook, due date, decision ref).
- Quick links to the latest 5 handoff reports.
- A pointer to the latest Phase 2 status summary report file in `reports/`.

### Conspicuous discoverability requirement
At end of session, ensure these are true:
1. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` points to newest handoff.
2. Newest handoff filename is timestamped and sortable.
3. Final response prints exact paths for:
   - newest handoff,
   - updated latest pointer,
   - updated Phase 2 progress board.

### Output style for final response
In final response include:
1. Session summary (what finished).
2. Commands/checks run and outcomes.
3. Exact path of new handoff report.
4. Exact path of updated `LATEST_SESSION_HANDOFF.md` and `PHASE2_PROGRESS_BOARD.md`.
5. “Next session should start with…” section.

Now begin by:
1. Reading the references in the required order.
2. Summarizing current state and open Phase 2 residuals.
3. Proposing 2–5 issues for this session.
4. Proceeding unless truly blocked by missing repository context.

## COPY/PASTE PROMPT END

---

## Notes for operator
- This template is designed for repeatability, resumability, and strict evidence discipline across fresh sessions.
- If desired, enforce a CI/policy check that requires `PHASE2_PROGRESS_BOARD.md` and `LATEST_SESSION_HANDOFF.md` updates in any PR that claims Phase 2 progress.
