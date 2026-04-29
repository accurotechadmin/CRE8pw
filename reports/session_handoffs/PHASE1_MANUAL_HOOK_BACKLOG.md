# Phase 1 Manual Hook Automation Backlog
- Last updated (UTC): 2026-04-29T13:09:00Z
- Owner/session: Codex session `20260429-1309`

## Objective
Track residual manual verification hooks with deterministic automation targets needed to reduce Phase 1 verification risk.

Gate-critical manual hooks are closed for Phase 1 acceptance scope. The following **non-gate residual manual hooks remain open** and are intentionally tracked for Phase 2 automation.

| hook_id | source requirement(s) | owner | priority | current mode | target automation hook | target command/script | notes |
|---|---|---|---|---|---|---|---|
| HOOK-SSOT-LINT-METADATA | CRE8-GOV-REQ-0005 | Program Traceability WG | Medium | manual | HOOK-SSOT-LINT-METADATA | composer docs:ssot:lint | Transition matrix row mode to automated for this requirement binding so verification mode matches implemented command. |
