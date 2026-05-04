# `reports/session_responses/` — Session Final-Response Archive

This directory stores the full text of final responses produced by authoring/maintenance sessions.

## Why it exists

- Preserves reasoning context across stateless or time-separated sessions.
- Complements `reports/session_handoffs/` by retaining full narrative detail.
- Provides durable, auditable communication history for program continuity.

## Naming convention

- File pattern: `<YYYYMMDD-HHMM>_RESPONSE.md`
- Time basis: UTC
- Intended pairing: `reports/session_handoffs/SESSION_HANDOFF_<YYYYMMDD-HHMM>.md`

## Content expectations

A response archive should include (as applicable):

- Work summary and scope
- Verification commands and outcomes
- Files changed
- Risks, blockers, and follow-up guidance
- Pointers to artifacts generated/updated

## Operating rules

- Save the response archive in this directory before session closure when required by workflow.
- Preserve existing archives; corrections should be appended as newer timestamped files.
- Keep entries free of secrets and credentials.

## Navigation tips

- Start from `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` to locate the newest linked handoff.
- Sort filenames lexicographically to get chronological order.

## Related references

- Reports root: `../README.md`
- Latest handoff pointer: `../session_handoffs/LATEST_SESSION_HANDOFF.md`
- Program plan: `../PHASE3_AUTHORING_PROGRAM_PLAN.md`
