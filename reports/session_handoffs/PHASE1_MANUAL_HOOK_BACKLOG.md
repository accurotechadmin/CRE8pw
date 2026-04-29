# Phase 1 Manual Hook Automation Backlog

- Last updated (UTC): 2026-04-29T11:53:00Z
- Owner/session: Codex session `20260429-1153`

## Objective
Track residual manual verification hooks with deterministic automation targets needed to reduce Phase 1 verification risk.

Gate-critical manual hooks are closed for Phase 1 acceptance scope. The following **non-gate residual manual hooks remain open** and are intentionally tracked for Phase 2 automation.

| hook_id | source requirement(s) | owner | priority | current mode | target automation hook | target command/script | notes |
|---|---|---|---|---|---|---|---|
| HOOK-AUTH-INHERITANCE-BOUNDARY | CRE8-AUTH-REQ-0002 | Identity & Policy WG | High | manual | HOOK-AUTH-INHERITANCE-BOUNDARY | composer test:contract:auth-inheritance | Add fixture coverage for descendant boundary constraints and deny inheritance edge cases. |
| HOOK-AUTH-LIFECYCLE-ENFORCEMENT | CRE8-AUTH-REQ-0006 | Identity & Policy WG | High | manual | HOOK-AUTH-LIFECYCLE-ENFORCEMENT | composer test:contract:auth-lifecycle | Add suspend/revoke/expire enforcement test matrix tied to auth decision outcomes. |
| HOOK-IDENTITY-ID-FIRST-ISSUANCE | CRE8-ARCH-REQ-0001 | Platform Architecture WG | Medium | manual | HOOK-IDENTITY-ID-FIRST-ISSUANCE | composer test:contract:identity-issuance | Enforce deterministic ID-first issuance precondition in fixture scenarios. |
| HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION | CRE8-ARCH-REQ-0002 | Platform Architecture WG | Medium | manual | HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION | composer test:contract:identity-context | Verify utility-key context isolation and reject cross-context reuse. |
| HOOK-CONTRACT-SURFACE-PARITY | CRE8-CONTRACT-REQ-0030 | API Contracts WG | Medium | manual | HOOK-CONTRACT-SURFACE-PARITY | composer test:contract:surface-parity | Validate UI capability declarations map to route inventory or approved exception table. |
| HOOK-FEED-INTERACTION-DENY-MAPPING | CRE8-FEED-REQ-0021 | Product Policy WG | Medium | manual | HOOK-FEED-INTERACTION-DENY-MAPPING | composer test:contract:feed-interaction-deny | Enforce one-to-one interaction deny-condition to canonical error-code mapping. |
