# CRE8 Phase 1 — True Completion Execution Prompt (Post-Audit)

You are a fresh expert coding/governance LLM session continuing CRE8 Phase 1 work.

## Mission
Use repository evidence to convert **Phase 1 from acceptance-closed to truly complete**. Your job is to finish all remaining Phase 1 obligations that are still partial, ambiguous, unproven, or manually reconciled.

This is an execution session with strict truth standards:
- Do not inherit prior “complete” claims without re-verifying.
- Distinguish: (a) implemented and passing, (b) documented but not executable, (c) deferred/waived, (d) unproven.
- If a requirement is not demonstrably satisfied, treat it as open.

---

## You MUST ask clarifying questions early
Before major edits, ask the user any high-impact clarifying questions needed to remove ambiguity. Ask in a compact numbered list and proceed on defaults only if the user does not answer.

At minimum, confirm:
1. Whether “true Phase 1 completion” should include resolving all residual manual hooks or only Phase-1 gate-critical ones.
2. Whether ADR-003 deferred breadth should be partially pulled back into Phase 1 or kept strictly in Phase 2.
3. Desired tolerance for provisional-normative status at close (allowed vs not allowed).
4. Whether to prioritize stricter automation over additional prose hardening when tradeoffs arise.

If unanswered, apply conservative defaults: maximize executable verification and explicit residual tracking.

---

## Mandatory reading order (first actions)
Read these first, in order:
1. `reports/PHASE1_CANON_HARDENING_ROADMAP.md`
2. `reports/PHASE1_COMPLETION_AUDIT_20260429-1133.md`
3. `reports/PHASE1_ACCEPTANCE_REVIEW_DRAFT.md`
4. `reports/session_handoffs/PHASE1_PROGRESS_BOARD.md`
5. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
6. Latest timestamped handoff under `reports/session_handoffs/`
7. `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`
8. `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`
9. `reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md`
10. `docs/00_governance/DEFINITION_OF_DONE.md`
11. `docs/80_traceability_decisions_and_program/ADR_INDEX.md`
12. `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`

---

## Required operating model

### 1) Build a “true completion” closure inventory
Create a concrete list of all still-open or ambiguous Phase 1 obligations. Include:
- requirement ID (or `UNMAPPED` if missing),
- source file,
- current claim/status,
- evidence quality,
- closure criterion,
- closure owner,
- verification hook.

### 2) Select a focused batch (3–7 issues)
Pick 3–7 contiguous issues from one or two slices that most directly block true completion (not cosmetic cleanup).

Priority order:
1. Manual-hook ambiguity and backlog/matrix reconciliation.
2. Traceability completeness for already-claimed normative requirements.
3. Verification hook executability and evidence location validity.
4. Prose↔machine contract parity drift.
5. Acceptance memo language that overstates completion.

List selected issues before edits.

### 3) Execute deterministic fixes
Where claims are partial/false/unproven, fix canon artifacts with normative language (MUST/SHOULD/MAY) and structured IDs.

You MUST:
- eliminate contradictory completion language across acceptance memo, progress board, and latest handoff;
- ensure manual hooks are either (a) automated, or (b) explicitly tracked with owner/priority/automation target;
- reconcile `TRACEABILITY_MATRIX.md` rows with verification strategy and backlog declarations;
- repair missing links/dependencies/metadata inconsistencies;
- update/append ADR/decision log entries only if decision semantics change.

### 4) Verification discipline
Run all relevant checks for touched areas. At minimum, run:
- `composer docs:ssot:lint`
- `composer docs:ssot:sync-check`
- `composer docs:ssot:report`
- `composer phase1:acceptance-bundle`

If any check fails:
- classify root cause,
- either fix now or create explicit residual gap entry with owner and next hook.

### 5) Truth re-baseline
Produce an updated slice-by-slice status using:
- not started / in progress / partially complete / complete / blocked,
- explicit % estimate,
- confidence (High/Medium/Low),
- one-sentence evidence basis.

No blanket 100% claims without direct evidence.

---

## Required deliverables (must create/update)
1. New audit execution report:
   - `reports/PHASE1_TRUE_COMPLETION_EXECUTION_<UTC-YYYYMMDD-HHMM>.md`
2. New session handoff:
   - `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`
3. Updated latest pointer:
   - `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
4. Updated progress board:
   - `reports/session_handoffs/PHASE1_PROGRESS_BOARD.md`
5. If manual-hook state changes:
   - `reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md`

---

## Required format: PHASE1_TRUE_COMPLETION_EXECUTION_<timestamp>.md

# CRE8 Phase 1 True Completion Execution Report
- Timestamp (UTC):
- Session:
- Branch/commit:
- Scope (issues/slices):

## 1) Clarifying questions and answers
- Q1:
- A1:

## 2) Sources reviewed
- ...

## 3) Closure inventory (open -> closed/in-progress)
| Item ID | Requirement ID | Source | Prior state | Action taken | New state | Evidence |
|---|---|---|---|---|---|---|

## 4) Claim verification updates
| Claim ID | Claim | Verdict | Evidence | Remediation |
|---|---|---|---|---|

## 5) Checks executed
| Command | Result | Notes |
|---|---|---|

## 6) Re-baselined Phase 1 status
| Slice | Status | % (est.) | Confidence | Evidence basis |
|---|---|---:|---|---|

## 7) Remaining gaps (if any)
| Gap ID | Blocking requirement(s) | Severity | Needed change | Owner | Verification hook |
|---|---|---|---|---|---|

## 8) Next actions
1. ...
2. ...

---

## Required format: session handoff
Use the existing repository handoff structure already in use.

---

## Final response contract for this session
In your final response, include:
1. What you changed and why.
2. Claim-verdict totals.
3. Exact commands run and outcomes.
4. Exact paths to all artifacts created/updated.
5. Explicit statement:
   - “What is now truly complete in Phase 1.”
   - “What still remains (if anything) and why.”
6. A short “Questions for user” section for any unresolved strategic choices.

Start now by reading required files and asking clarifying questions before major edits.
