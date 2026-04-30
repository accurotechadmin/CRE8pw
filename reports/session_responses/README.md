# `reports/session_responses/` — CRE8 Session Response Archive

Durable archive of full final responses produced by Phase 3 (and subsequent) authoring sessions driven by [`../PHASE3_AUTHORING_SESSION_PROMPT.md`](../PHASE3_AUTHORING_SESSION_PROMPT.md).

This folder is the narrative counterpart to `../session_handoffs/`. Handoffs capture structured progress data (slices, requirement IDs, hooks, status board snapshot). Response archives capture the verbatim text the session returned to the operator at the end of its run, so a later session can reconstruct prior reasoning without rediscovery.

---

## 1. Convention

- **File name**: `<UTC-YYYYMMDD-HHMM>_RESPONSE.md`. UTC, sortable, paired by timestamp with the matching `../session_handoffs/SESSION_HANDOFF_<UTC>.md`.
- **Content**: the verbatim text of the session's final response to the operator, including the structured sections required by the prompt template:
  1. session summary (slices selected, completed, partial, blocked),
  2. verification commands run and outcomes (compact table),
  3. files changed grouped by domain,
  4. requirement IDs and hook IDs added or updated,
  5. exact paths of all artifacts created or updated (new handoff, updated `LATEST_SESSION_HANDOFF.md`, updated progress board, this archived response, any new ADR or decisions log entry, any Change Impact Map),
  6. PR URL or branch name,
  7. open questions and proposed next ADRs,
  8. "Next session should start with…" recommendation listing 3–7 next slices in priority order with dependency status.
- **Save before reply**: each authoring session MUST save its full final response file before returning the response to the user, so the file path can be cited inside the response itself.
- **Persistence**: response files are append-only. Do not edit a previously saved response file. If a correction is needed, add a newer dated response file and reference the prior one.
- **Pairing rule**: a session MUST NOT close without producing both a handoff and a response file with matching timestamps.

---

## 2. Why this exists

Cloud-agent sessions are bounded; the next session has no chat history. Only what is committed to `reports/session_handoffs/` and `reports/session_responses/` survives. The handoff is structured for fast lookup; the response archive is the prose of record. Together they form the durable session log that allows uninterrupted, low-friction handoff across many sessions.

---

## 3. Index and discoverability

The latest 5 response files are linked from `../session_handoffs/PHASE3_PROGRESS_BOARD.md` (once Phase 3 milestone M0 P3-S0.3 has created it). Until that board exists, the latest response is found by sorting filenames in this folder lexicographically (the UTC `YYYYMMDD-HHMM` prefix is a chronological sort key).

The corresponding pointer file is `../session_handoffs/LATEST_SESSION_HANDOFF.md`, which points to the matching handoff for the most recent session.

---

## 4. See also

- [Phase 3 program plan](../PHASE3_AUTHORING_PROGRAM_PLAN.md)
- [Phase 3 session prompt](../PHASE3_AUTHORING_SESSION_PROMPT.md)
- [`reports/` README](../README.md)
- [Latest session handoff pointer](../session_handoffs/LATEST_SESSION_HANDOFF.md)
- [Project root README](../../README.md)
