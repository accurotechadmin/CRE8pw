# Phase 1 Manual Hook Automation Backlog

- Last updated (UTC): 2026-04-29T06:57:12Z
- Owner/session: Codex session `20260429-0657`

## Objective
Track residual manual verification hooks with deterministic automation targets needed to reduce Phase 1 verification risk.

| hook_id | source requirement(s) | owner | priority | current mode | target automation hook | target command/script | notes |
|---|---|---|---|---|---|---|---|
| HOOK-REVIEW-GATE-CHECK | CRE8-GOV-REQ-0033 | Docs Governance WG | P1 | manual | HOOK-REVIEW-GATE-CHECK-AUTO | `composer docs:ssot:review-gate-check` | Validate changed normative docs include owner/reviewer/impact-map references. |
| HOOK-DOD-TRACE-CHECK | CRE8-GOV-REQ-0053 | Program Traceability WG | P1 | manual | HOOK-DOD-TRACE-CHECK-AUTO | `composer docs:ssot:dod-trace-check` | Fail when requirement semantics change without matrix row update. |
| HOOK-TRACE-ROADMAP-SCHEMA | CRE8-TRACE-REQ-0060 | Program Traceability WG | P2 | manual | HOOK-TRACE-ROADMAP-SCHEMA-AUTO | `composer docs:ssot:roadmap-schema-check` | Parse roadmap sections and required fields. |
| HOOK-SEED-PROMOTION-SCHEMA | CRE8-TRACE-REQ-0070 | Program Traceability WG | P2 | manual | HOOK-SEED-PROMOTION-SCHEMA-AUTO | `composer docs:ssot:seed-promotion-schema` | Column/ID integrity and status checks. |
| HOOK-SEED-GAP-REGISTER-SCHEMA | CRE8-TRACE-REQ-0080 | Program Traceability WG | P2 | manual | HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO | `composer docs:ssot:seed-gap-schema` | Enforce tracker_ref existence and status semantics. |
