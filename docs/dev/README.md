# `docs/dev` — Execution History and Working Artifacts

_Last updated (UTC): 2026-04-05_

This subfolder contains time-sequenced implementation artifacts used during active development.

## Contents

- `IMPLEMENTATION_STATUS.md` — phase and endpoint completion tracking.
- `QA_MATRIX.md` — execution evidence and blocked/pass/fail matrix.
- `SESSION_LEDGER.md` — chronological session logs and tactical decisions.
- `DECISIONS.md` — ADR-style architecture/UX/integration decisions.

## How this folder relates to top-level docs

- Top-level `/docs/*.md` should become long-lived, stable references.
- `docs/dev/*` remains execution-history detail and may contain transient notes.
- When a recurring pattern is observed in `docs/dev/*`, promote it into a top-level reference doc.

## Promotion checklist (dev artifact → canonical docs)

- [ ] Insight repeated in 2+ sessions.
- [ ] Behavior is now part of expected contract/operations.
- [ ] Supporting code/tests exist.
- [ ] Top-level docs updated and cross-linked.
