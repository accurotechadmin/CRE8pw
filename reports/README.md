# `reports/` — CRE8 Reports, Plans, and Session Artifacts

This folder is the **non-normative** working area for the CRE8 program. Everything under `reports/` is informational unless explicitly promoted by governance-controlled change (see project root `../README.md` §10).

It holds three categories of content:

1. **Program-level artifacts** — phase plans, audits, status summaries, and the Phase 3 program plan + reusable session prompt.
2. **Session artifacts** — handoffs, progress boards, archived final responses, and prompt records for each authoring session.
3. **Generated artifacts** — machine-emitted reports such as the SSOT coverage JSON.

Authoring sessions in any phase save their working output here so the SSOT domain folders under `docs/` stay reserved for canonical artifacts only.

---

## 1. Layout

```text
reports/
  README.md                                  ← this file
  PHASE1_CANON_HARDENING_ROADMAP.md          ← Phase 1 historical plan
  PHASE1_ACCEPTANCE_REVIEW_DRAFT.md          ← Phase 1 acceptance memo (closed by ADR-003)
  PHASE1_COMPLETION_AUDIT_*.md               ← Phase 1 truth audits
  PHASE1_TRUE_COMPLETION_EXECUTION_*.md      ← Phase 1 truth-rebaseline execution reports
  PHASE1_SESSION_PROMPT_TEMPLATE.md          ← Phase 1 reusable session prompt (historical)
  PHASE2_SESSION_PROMPT_TEMPLATE.md          ← Phase 2 reusable session prompt (historical/contextual)
  PHASE3_AUTHORING_PROGRAM_PLAN.md           ← Phase 3 — Canon Completion (active, 13 milestones, 69 slices)
  PHASE3_AUTHORING_SESSION_PROMPT.md         ← Phase 3 reusable session prompt (active)
  PHASE_PLAN_AND_RECORDS_STATUS_SUMMARY_*.md ← Cross-phase status summaries
  REPO_FULL_STUDY_*.md                       ← Deep repo studies
  REPO_STUDY_HIGH_LEVEL_REPORT_*.md          ← High-level repo studies
  change_impact_maps/                        ← Phase 3-required CIMs for machine-artifact changes (created on demand)
  session_handoffs/                          ← Per-session handoffs and progress boards
  session_prompts/                           ← Verbatim prompt records and historical execution prompts
  session_responses/                         ← Full final response archives from authoring sessions
  ssot/                                      ← Machine-generated SSOT coverage reports
```

---

## 2. The active program: Phase 3 — Canon Completion

Phase 3 is the active authoring effort. It supersedes the prior Phase 3 ("operational readiness integration") and Phase 4 ("scaled domain expansion"), consolidating both into one program that takes the SSOT corpus to fully authored, internally consistent, machine-verifiable, ready to drive a production codebase.

Authoritative artifacts:

- **Program plan**: [`PHASE3_AUTHORING_PROGRAM_PLAN.md`](./PHASE3_AUTHORING_PROGRAM_PLAN.md) — 13 milestones (M0..M12) and 69 slices with explicit dependencies, exit criteria, and verification commands per slice.
- **Reusable session prompt**: [`PHASE3_AUTHORING_SESSION_PROMPT.md`](./PHASE3_AUTHORING_SESSION_PROMPT.md) — a copy-paste prompt for fresh expert-coding LLM sessions; instructs the session to pick up where the last session left off, drive 2–5 contiguous unblocked slices, and produce a complete handoff + archived response.

Definition of Done lives in `PHASE3_AUTHORING_PROGRAM_PLAN.md` §6.

---

## 3. How a session works (and where it leaves evidence)

A typical Phase 3 authoring session:

1. Opens [`session_handoffs/LATEST_SESSION_HANDOFF.md`](./session_handoffs/LATEST_SESSION_HANDOFF.md) and reads the file it points to.
2. Opens the active progress board (`session_handoffs/PHASE3_PROGRESS_BOARD.md` once Phase 3 M0 P3-S0.3 has created it; meanwhile `session_handoffs/PHASE2_PROGRESS_BOARD.md`).
3. Reads the program plan, the governance set under `../docs/00_governance/`, the traceability and decisions under `../docs/80_traceability_decisions_and_program/`, the contracts and machine contracts, and the seed canon.
4. Selects 2–5 unblocked slices from the program plan and authors them.
5. Runs the SSOT lint/sync/report family + the contract test runners + `composer phase2:acceptance-bundle` (transitioning to `composer phase3:final-acceptance-bundle` under Phase 3 M11).
6. Writes a session handoff at `session_handoffs/SESSION_HANDOFF_<UTC>.md`, updates `session_handoffs/LATEST_SESSION_HANDOFF.md`, updates the progress board, and archives the full final response at `session_responses/<UTC>_RESPONSE.md`.
7. Pushes commits (to `main` or a feature branch per the operator’s workflow) and opens a PR when the workflow uses PRs.

---

## 4. Subfolder index

| Subfolder | Purpose |
|---|---|
| [`session_handoffs/`](./session_handoffs/) | Per-session handoffs, progress boards, manual-hook backlog, exceptions register, blocker reports. |
| [`session_prompts/`](./session_prompts/) | Verbatim prompt records and historical execution prompts (for traceability of which prompt drove which session). |
| [`session_responses/`](./session_responses/) | Durable archive of every session's full final response, paired by UTC timestamp with the handoff. |
| [`ssot/`](./ssot/) | Machine-generated artifacts — primarily `coverage_latest.json` from `composer docs:ssot:report`. |
| `change_impact_maps/` | Required for machine-artifact changes under Phase 3. Created on demand. |

---

## 5. Required hygiene

- **Discoverability**: every authoring session updates `session_handoffs/LATEST_SESSION_HANDOFF.md` to point at the newest handoff before commit.
- **Pairing**: every `session_handoffs/SESSION_HANDOFF_<UTC>.md` MUST have a matching `session_responses/<UTC>_RESPONSE.md`.
- **Append-only**: response archives and handoff files are append-only. To correct an earlier file, add a newer dated file and reference the prior one.
- **Naming**: filenames use UTC `YYYYMMDD-HHMM` so they sort chronologically.
- **No scaffold prose**: the prohibited scaffold opener phrase MUST NOT appear in any file under `reports/` (Phase 3 M2 wires this into the lint).
- **No real secrets**: never commit live credentials in any report or session artifact. `dot.env` placeholders only.

---

## 6. Cross-phase status references

| Phase | Status | Authoritative pointer |
|---|---|---|
| Phase 1 — Canon hardening | Closed by ADR-003 | `../docs/80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md`, `PHASE1_ACCEPTANCE_REVIEW_DRAFT.md`, `PHASE1_COMPLETION_AUDIT_20260429-1133.md` |
| Phase 2 — Machine-contract lock-in | Active, ~99% per `session_handoffs/PHASE2_PROGRESS_BOARD.md` | `../docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md`, `session_handoffs/PHASE2_PROGRESS_BOARD.md` |
| Phase 3 — Canon Completion (consolidated) | Active going forward | `PHASE3_AUTHORING_PROGRAM_PLAN.md`, eventual `session_handoffs/PHASE3_PROGRESS_BOARD.md`, eventual ADR-004 |
| Implementation phase (post-Phase 3) | Not started | Triggered by Phase 3 M12 closure |

---

## 7. Reading order for a new contributor or fresh session

1. Project root [`../README.md`](../README.md)
2. [`PHASE3_AUTHORING_PROGRAM_PLAN.md`](./PHASE3_AUTHORING_PROGRAM_PLAN.md)
3. [`PHASE3_AUTHORING_SESSION_PROMPT.md`](./PHASE3_AUTHORING_SESSION_PROMPT.md)
4. [`session_handoffs/LATEST_SESSION_HANDOFF.md`](./session_handoffs/LATEST_SESSION_HANDOFF.md) and the file it points to
5. The active progress board under [`session_handoffs/`](./session_handoffs/)
6. [`ssot/coverage_latest.json`](./ssot/coverage_latest.json) for current trace coverage
7. The most recent file under [`session_responses/`](./session_responses/) for prior session narrative
8. The relevant prior cross-phase status summary if needed

---

## 8. See also

- [Project root README](../README.md)
- [`docs/` README](../docs/README.md)
- [SSOT Index](../docs/00_governance/SSOT_INDEX.md)
- [Change Control Policy](../docs/00_governance/CHANGE_CONTROL_POLICY.md)
- [Definition of Done](../docs/00_governance/DEFINITION_OF_DONE.md)
- [Traceability Matrix](../docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Verification Strategy](../docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Seed canon entry](../seed/seed-intro.md)
