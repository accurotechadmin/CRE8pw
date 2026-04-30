# CRE8 Session Response Archive

This folder is the durable archive of full final responses produced by Phase 3 (and later) authoring sessions driven by `reports/PHASE3_AUTHORING_SESSION_PROMPT.md`.

## Convention

- File name: `<UTC-YYYYMMDD-HHMM>_RESPONSE.md`.
- Content: the verbatim text of the session's final response to the operator, including the structured sections required by the prompt template (session summary, verification outcomes, files changed, requirement and hook IDs, artifact paths, PR/branch link, open questions, next-session recommendation).
- Pairing: each response file MUST share its timestamp with the matching session handoff file under `reports/session_handoffs/SESSION_HANDOFF_<UTC>.md` so the two artifacts are easy to correlate.
- Persistence: response files are append-only. Do not edit a previously-saved response file; if a correction is needed, add a new dated response file and reference the prior one.

## Why this exists

Session handoffs already capture structured progress data (slices, requirement IDs, hooks, status board snapshot). The response archive captures the full narrative the session returned to the operator at the end of its run, including any open questions, recommended next slices, and inline summaries. Together they let any subsequent session reconstruct the prior session's reasoning without rediscovery.

## Index

The latest 5 response files are linked from `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` for discoverability.
