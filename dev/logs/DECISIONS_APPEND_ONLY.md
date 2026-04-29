# DECISIONS_APPEND_ONLY

## DEC-2026-04-29-001
- **Date (UTC):** 2026-04-29
- **Context:** Fresh onboarding session required continuity logs under `dev/logs/*`, but directory was absent.
- **Decision:** Create `dev/logs/` structure immediately with required baseline artifacts (`SESSION_STATUS_CURRENT`, `CHANGE_LEDGER`, per-session log, append-only decisions log).
- **Consequences:** Future sessions can resume with standardized continuity state and explicit evidence capture trail.
- **Related files:** `dev/logs/SESSION_STATUS_CURRENT.md`, `dev/logs/CHANGE_LEDGER.md`, `dev/logs/sessions/SESSION_LOG_2026-04-29_onboarding-continuity-bootstrap.md`, `dev/logs/DECISIONS_APPEND_ONLY.md`
