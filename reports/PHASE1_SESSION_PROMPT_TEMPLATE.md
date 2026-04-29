# Reusable Prompt Template — CRE8 Phase 1 Canon Hardening Session Driver

Use this prompt at the start of each fresh expert coding LLM session.

---

## COPY/PASTE PROMPT START

You are continuing **CRE8 Phase 1 — Canon hardening** work in this repository.

### Mission for this session
Work through a **small, high-quality batch** of Phase 1 issues (usually 2–5 issues per session), execute changes with traceability and verification rigor, and leave behind a **clear handoff report** so the next session can continue without re-discovery.

### Primary references you must read first
1. `reports/PHASE1_CANON_HARDENING_ROADMAP.md`
2. `reports/REPO_FULL_STUDY_2026-04-29.md`
3. `README.md`
4. `docs/00_governance/SSOT_INDEX.md`
5. Any existing session handoff logs under `reports/session_handoffs/`

### Mandatory operating model
1. **Assess current state first**
   - Locate latest handoff report in `reports/session_handoffs/`.
   - Summarize “last completed”, “in progress”, “blocked”, and “next queued” items.
   - Confirm what Phase 1 slice(s) are currently active.

2. **Select a focused batch (2–5 issues)**
   - Choose issues that are contiguous within one or two slices from the roadmap.
   - Prefer foundational dependencies first (metadata schema, ownership, traceability, verification hooks).
   - Explicitly list chosen issues before editing.

3. **Execute with normative quality**
   - Replace scaffold prose with deterministic normative requirements (MUST/SHOULD/MAY).
   - Add/normalize doc metadata headers.
   - Add cross-document links and traceability references.
   - Keep requirement IDs structured and consistent.

4. **Verification and evidence discipline**
   - Run available checks relevant to changed files.
   - If automation is missing, add manual verification notes and identify exact next automation hook.
   - Record any drift between prose and machine contracts.

5. **Produce end-of-session handoff artifacts (required)**
   - Create/update a conspicuous handoff report in:
     - `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`
   - Update a stable pointer file:
     - `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
     - This file should contain a short summary and a link/path to the newest handoff file.
   - Update (or create) progress tracker:
     - `reports/session_handoffs/PHASE1_PROGRESS_BOARD.md`

### Session scope guardrails
- Do **not** attempt all slices in one session.
- Favor completion of a few issues with strong quality over broad shallow edits.
- If a task is ambiguous, document assumptions and proceed with reversible, clearly marked decisions.

### Required deliverables this session
By the end of this session, provide all of the following:

1. **Changed files** with concise rationale.
2. **Issue-level completion report** for each selected issue:
   - Objective
   - Changes made
   - Verification performed
   - Residual risks / open questions
3. **Phase 1 status snapshot**:
   - Slice-by-slice status (`not started`, `in progress`, `partially complete`, `complete`, `blocked`)
   - Percent estimate per slice (rough, explicit as estimate)
4. **Next-session pickup plan**:
   - Top 3–7 recommended next issues
   - Dependency notes
   - Suggested first command(s)/file(s) for next session

### Required handoff report format
Use this structure in `SESSION_HANDOFF_<timestamp>.md`:

```md
# CRE8 Phase 1 Session Handoff
- Timestamp (UTC):
- Session focus slices:
- Branch/commit:

## 1) What I reviewed first
- Previous handoff used:
- Key roadmap sections referenced:

## 2) Issues selected for this session
1. ...
2. ...

## 3) Work completed
### Issue X
- Objective:
- Files changed:
- Requirement IDs added/updated:
- Verification:
- Notes:

## 4) Current Phase 1 status board
| Slice | Status | % | Notes |
|---|---:|---:|---|

## 5) Risks, blockers, and decisions
- Risks:
- Blockers:
- ADR/decision notes:

## 6) Next-session pickup guide
- Start here:
- Next issues (priority order):
- Suggested commands:
```

### Progress board format (always maintained)
Maintain `PHASE1_PROGRESS_BOARD.md` with:
- Master checklist of slices and key issues.
- Last updated timestamp.
- Current owner/session.
- Quick links to the latest 5 handoff reports.

### Conspicuous discoverability requirement
At the end of the session, ensure these are true:
1. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` points to the newest handoff.
2. The newest handoff filename is timestamped and sortable.
3. The final session response prints the exact handoff file path prominently.

### Output style for final response
In your final response include:
1. Session summary (what was finished).
2. Commands/checks run and outcomes.
3. Exact path of new handoff report.
4. Exact path of updated `LATEST_SESSION_HANDOFF.md` and `PHASE1_PROGRESS_BOARD.md`.
5. “Next session should start with…” section.

Now begin by:
1. Reading the roadmap and latest handoff files.
2. Proposing the 2–5 issues for this session.
3. Waiting only if truly blocked by missing repository context; otherwise proceed.

## COPY/PASTE PROMPT END

---

## Notes for operator
- This template is designed to make each session self-contained, traceable, and resumable.
- If you want stricter enforcement, add a CI rule that fails when `LATEST_SESSION_HANDOFF.md` is not updated in a PR that touches Phase 1 docs.
