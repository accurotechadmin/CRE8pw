# Phase 1 Manual Hook Automation Backlog

- Last updated (UTC): 2026-04-29T11:53:00Z
- Owner/session: Codex session `20260429-1153`

## Objective
Track residual manual verification hooks with deterministic automation targets needed to reduce Phase 1 verification risk.

Gate-critical manual hooks are closed for Phase 1 acceptance scope. The following **non-gate residual manual hooks remain open** and are intentionally tracked for Phase 2 automation.

| hook_id | source requirement(s) | owner | priority | current mode | target automation hook | target command/script | notes |
|---|---|---|---|---|---|---|---|
| HOOK-SSOT-LINT-METADATA | CRE8-GOV-REQ-0005 | Program Traceability WG | Medium | manual | HOOK-SSOT-LINT-METADATA | composer docs:ssot:lint | Transition matrix row mode to automated for this requirement binding so verification mode matches implemented command. |
| HOOK-SSOT-MANUAL-BACKLOG-LINK | CRE8-TRACE-REQ-0096 | Program Traceability WG | Medium | manual | HOOK-SSOT-SYNC-MANUAL-BACKLOG | composer docs:ssot:sync-check | Replace manual-only linkage check with fully automated sync-check enforcement and update row mode once complete. |
| HOOK-SSOT-PR-EVIDENCE-REQUIRED | CRE8-TRACE-REQ-0097 | Program Traceability WG | Medium | manual | HOOK-SSOT-PR-EVIDENCE-REQUIRED | .github/workflows/ssot_phase1_gate.yml | Add CI/PR template parser that fails when requirement-semantics changes lack evidence notes. |
| HOOK-IDENTITY-ID-FIRST-ISSUANCE | CRE8-ARCH-REQ-0001 | Platform Architecture WG | Medium | manual | HOOK-IDENTITY-ID-FIRST-ISSUANCE | composer test:contract:identity-issuance | Enforce deterministic ID-first issuance precondition in fixture scenarios. |
| HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION | CRE8-ARCH-REQ-0002 | Platform Architecture WG | Medium | manual | HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION | composer test:contract:identity-context | Verify utility-key context isolation and reject cross-context reuse. |
| HOOK-CONTRACT-SURFACE-PARITY | CRE8-CONTRACT-REQ-0030 | API Contracts WG | Medium | manual | HOOK-CONTRACT-SURFACE-PARITY | composer test:contract:surface-parity | Validate UI capability declarations map to route inventory or approved exception table. |
| HOOK-FEED-INTERACTION-DENY-MAPPING | CRE8-FEED-REQ-0021 | Product Policy WG | Medium | manual | HOOK-FEED-INTERACTION-DENY-MAPPING | composer test:contract:feed-interaction-deny | Enforce one-to-one interaction deny-condition to canonical error-code mapping. |
