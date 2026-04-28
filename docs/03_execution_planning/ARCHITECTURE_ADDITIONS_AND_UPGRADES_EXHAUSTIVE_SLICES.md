> **Finalization note (2026-04-28):** This artifact is preserved as a canonical implementation-governance reference. Slice progression language is archival context; SSOT production-readiness closure is complete.

# Architecture Additions and Upgrades — Exhaustive Slice Backlog

_Status: adopted execution backlog_
_Last updated (UTC): 2026-04-28_
_Canonical scope: final A/B/C architecture upgrade execution slices_

## Purpose
Provide the exhaustive, implementation-ready slice list for the three architecture upgrades:

- **Upgrade A** — PDP service-in-process.
- **Upgrade B** — BFF-by-surface.
- **Upgrade C** — CQRS-lite + audit-first.

This backlog is the authoritative execution plan for iterative PR-based delivery with evidence.

## Usage rules
1. Do not start an upgrade slice before completing prerequisites (`U0-*`) unless explicitly marked parallel-safe.
2. Every slice that changes behavior must include SSOT synchronization in the same PR.
3. Every slice must include validation evidence and rollout/rollback notes.
4. Keep feature flags default-off until the corresponding activation slice.

---

## U0 — Cross-cutting prerequisites and guardrails

| Slice ID | Objective | Depends on | Deliverables | Validation/Evidence |
|---|---|---|---|---|
| U0-01 | Register architecture-upgrade execution in governance flow. | none | Class B planning artifact + owner approvals | Planning approval record |
| U0-02 | Create epic/ticket structure for A/B/C + integration hardening. | U0-01 | Backlog with dependencies and owners | Backlog completeness review |
| U0-03 | Add risk register entries for policy drift, auth boundary drift, projection consistency. | U0-01 | Risk rows with mitigations and dates | Risk review signoff |
| U0-04 | Harden repository structure for policy/BFF/CQRS modules. | U0-02 | Required directories under `src/`, `config/`, `database/`, `tests/` | Structure diff + owner signoff |
| U0-05 | Add architecture feature flags to config and env contracts. | U0-04 | Flag plumbing for `ARCH_*` variables | Config positive/negative tests |
| U0-06 | Wire baseline CI checks (`qa`, contract, security, health smoke). | U0-04 | CI workflow updates | Green CI run artifact |
| U0-07 | Add per-surface smoke checks for auth-context non-interchangeability. | U0-06 | Smoke tests for gateway/console boundary | Smoke evidence bundle |
| U0-08 | Publish PR checklist enforcing affected SSOT update matrix. | U0-01,U0-06 | Upgrade checklist in contribution workflow/template | PR checklist dry-run |

---

## UA — Upgrade A (PDP service-in-process)

| Slice ID | Objective | Depends on | Deliverables | Validation/Evidence |
|---|---|---|---|---|
| UA-01 | Implement core PDP decision primitives. | U0-05 | `Decision`, `DecisionContext`, `Obligation`, `PolicyRule` | Unit tests for object invariants |
| UA-02 | Implement route-action resolver + metadata policy context plumbing. | UA-01 | Route action resolver and context extraction | Resolver matrix tests |
| UA-03 | Implement owner-context builder for console policy evaluation. | UA-01 | Owner context builder + claim normalization | Owner-context tests |
| UA-04 | Implement key-context builder for gateway policy evaluation. | UA-01 | Key context builder + envelope inputs | Key-context tests |
| UA-05 | Implement PDP engine and rule registry scaffolding. | UA-02,UA-03,UA-04 | `PdpService`, `RuleRegistry` + invocation contract | PDP happy/deny path tests |
| UA-06 | Implement owner-only console operation rules. | UA-05 | Owner rule set | Rule decision-table tests |
| UA-07 | Implement gateway permission rules (`posts:*`, comments, flags). | UA-05 | Gateway permission rules | Permission matrix tests |
| UA-08 | Implement delegation subset/depth/expiry rule family. | UA-05 | Delegation bound rules | Escalation-prevention tests |
| UA-09 | Implement use-key mutation restrictions. | UA-05 | Use-key mutation deny rules | Negative-path tests |
| UA-10 | Implement keychain membership invariant rules. | UA-05 | Keychain invariants in PDP | Membership edge-case tests |
| UA-11 | Implement master-key SYSADMIN boundary rules. | UA-05 | Master-key boundary rules | Boundary abuse tests |
| UA-12 | Implement device-binding enforcement outcomes in PDP decisions. | UA-05 | Device mismatch/absence rules + detail codes | Device binding security tests |
| UA-13 | Externalize policy tables (`route_actions`, permissions, detail codes). | UA-05 | Config policy tables and loaders | Table snapshot regression tests |
| UA-14 | Integrate policy decision middleware into request pipeline (shadow mode). | UA-06..UA-13 | `PolicyDecisionMiddleware` + shadow comparison logging | Shadow-mode comparison report |
| UA-15 | Refactor authn middleware to identity-only responsibility boundary. | UA-14 | Authn middleware simplification | Middleware order/behavior tests |
| UA-16 | Enable PDP enforcement for gateway read routes behind flag. | UA-14,UA-15 | Read-route PDP enforcement | Contract/security regressions |
| UA-17 | Enable PDP enforcement for gateway write routes behind flag. | UA-16 | Write-route PDP enforcement | Contract/security regressions |
| UA-18 | Enable PDP enforcement for console governance routes behind flag. | UA-16 | Console route PDP enforcement | Console authz regression suite |
| UA-19 | Remove legacy ad-hoc authorization logic from handlers. | UA-17,UA-18 | Dead-path deletion and cleanup | No-ad-hoc-auth audit report |
| UA-20 | SSOT sync + ADR for PDP canonicalization. | UA-14..UA-19 | Updates to auth spec/tables, pipeline, errors, traceability, ADR | SSOT sync check + docs review |

---

## UB — Upgrade B (BFF-by-surface)

| Slice ID | Objective | Depends on | Deliverables | Validation/Evidence |
|---|---|---|---|---|
| UB-01 | Create Gateway/Console controller module split. | U0-04 | Controller namespaces and route ownership boundaries | Route ownership review |
| UB-02 | Create Gateway/Console BFF service module scaffolding. | UB-01 | `Application/Bff/Gateway` and `Application/Bff/Console` base services | Wiring tests |
| UB-03 | Introduce surface-specific DTO/view-model packages. | UB-02 | Gateway/Console DTO definitions | DTO contract tests |
| UB-04 | Split route registration into public/gateway/console config files. | UB-01 | `routes_public`, `routes_gateway`, `routes_console` | Route boot parity tests |
| UB-05 | Build gateway error-state mapper with canonical detail-code preservation. | UB-02 | Gateway error mapper | Error mapping regression tests |
| UB-06 | Build console error-state mapper with UI-runtime-compatible hints. | UB-02 | Console error mapper | UI-runtime parity tests |
| UB-07 | Migrate gateway feed read route family to Gateway BFF. | UB-03,UB-04,UB-05,UA-16 | Gateway feed BFF flow | Contract + latency comparison |
| UB-08 | Migrate gateway post create/edit/flag route family to Gateway BFF. | UB-07,UA-17 | Gateway posts BFF flow | Contract/security regressions |
| UB-09 | Migrate gateway comments route family to Gateway BFF. | UB-07,UA-17 | Gateway comments BFF flow | Route parity tests |
| UB-10 | Migrate console posts list/create flows to Console BFF. | UB-03,UB-04,UB-06,UA-18 | Console post BFF flow | Contract + CSRF tests |
| UB-11 | Migrate console moderation flows to Console BFF. | UB-10,UA-18 | Console moderation BFF flow | Moderation lifecycle tests |
| UB-12 | Migrate console keychain/invite/key issuance flows to Console BFF. | UB-10,UA-18 | Console governance BFF flow | Authz/contract regressions |
| UB-13 | Implement optional gateway read caching with actor/scope-aware keys. | UB-07 | Gateway cache seams + invalidation rules | Cache correctness tests |
| UB-14 | Implement optional console inventory caching with short TTL controls. | UB-10 | Console cache seams | TTL/leakage tests |
| UB-15 | Add console BFF CSRF-recovery helpers and safe diagnostics hints. | UB-10,UB-06 | CSRF helper integration | CSRF UX/security checks |
| UB-16 | Expand surface-level integration tests for route->BFF orchestration. | UB-07..UB-12 | Integration suite by surface | Integration report |
| UB-17 | Remove legacy orchestration paths superseded by BFF modules. | UB-08,UB-09,UB-11,UB-12 | Dead-path cleanup | Diff-based dead-path audit |
| UB-18 | SSOT sync + ADR for BFF-by-surface architecture. | UB-07..UB-17 | Updates to architecture, UI runtime, module ownership, acceptance, traceability, ADR | SSOT sync check + docs review |

---

## UC — Upgrade C (CQRS-lite + audit-first)

| Slice ID | Objective | Depends on | Deliverables | Validation/Evidence |
|---|---|---|---|---|
| UC-01 | Introduce command bus interface and base command contract. | U0-04 | `CommandBus`, base command abstractions | Bus dispatch tests |
| UC-02 | Introduce query bus interface and base query contract. | U0-04 | `QueryBus`, base query abstractions | Query dispatch tests |
| UC-03 | Implement audit/domain event core model and publisher contract. | U0-04 | `DomainEvent`, `EventPublisher` | Event shape tests |
| UC-04 | Implement observability event sink with redaction safeguards. | UC-03 | Monolog event sink integration | Redaction + schema tests |
| UC-05 | Implement transactional command boundary contract (write + event append). | UC-01,UC-03 | Transaction coordinator contract | Atomicity tests |
| UC-06 | Add initial command handlers for moderation + key lifecycle paths. | UC-01,UC-05,UA-18 | Command handlers for highest-audit operations | Integration consistency tests |
| UC-07 | Add command handlers for content creation/edit/flag/comment routes. | UC-06,UA-17 | Content command handlers | Command-path contract tests |
| UC-08 | Add command handlers for keychain membership operations. | UC-06,UA-18 | Keychain membership commands | Keychain command tests |
| UC-09 | Add initial query handlers for feed/post/comments/read families. | UC-02 | Read query handlers | Query parity tests |
| UC-10 | Add query handlers for console listings/keychain resolve flows. | UC-02,UB-12 | Console query handlers | Console query parity tests |
| UC-11 | Implement projection updater and projector contracts. | UC-02,UC-03 | Projection updater and projector interfaces | Idempotency tests |
| UC-12 | Add feed ordering projection model and projector. | UC-11,UC-07 | Feed projection table/model logic | Projection freshness tests |
| UC-13 | Add keychain effective-view projection model and projector. | UC-11,UC-08 | Keychain projection table/model logic | Resolution parity tests |
| UC-14 | Add event-idempotency and replay protection in projectors. | UC-11 | Event ID dedupe controls | Replay-resilience tests |
| UC-15 | Enable sync projection mode by default in runtime flow. | UC-11..UC-14 | Sync projection wiring | Contract regression pass |
| UC-16 | Implement optional async projection mode (worker + retries + DLQ). | UC-15 | Queue/worker + retry/DLQ controls | Failure-injection evidence |
| UC-17 | Add health checks for projector lag and queue depth (if async enabled). | UC-16 | Health subchecks + metrics exposure | Health contract tests |
| UC-18 | Add operational dashboards for command failures and projection latency. | UC-15,UC-17 | Dashboard definitions/alerts | Alert drill evidence |
| UC-19 | Migrate BFF read paths to query services/projections incrementally. | UB-07..UB-12,UC-09..UC-15 | BFF to query-service integration | Route parity + latency report |
| UC-20 | Migrate BFF write paths to command handlers incrementally. | UB-08..UB-12,UC-06..UC-08 | BFF to command integration | Contract/security regression report |
| UC-21 | SSOT sync + ADR for CQRS-lite audit-first architecture. | UC-11..UC-20 | Updates to data model, observability, health, SLO/SLI, acceptance, ADR | SSOT sync check + docs review |

---

## UI / Contract / Security / Ops hardening slices for A+B+C integration

| Slice ID | Objective | Depends on | Deliverables | Validation/Evidence |
|---|---|---|---|---|
| UX-01 | Re-validate UI runtime error-state mapping against new BFF/PDP outcomes. | UB-18,UA-20 | Updated UI-runtime parity matrix | UI parity evidence |
| UX-02 | Re-validate 404 resource-specific detail semantics across surfaces. | UB-16,UA-20 | 404 semantics regression pack | Contract/UI regression report |
| SEC-01 | Re-run full auth boundary abuse matrix after A+B migration. | UA-20,UB-18 | Security abuse test bundle | Security signoff |
| SEC-02 | Re-run device-binding + token-type confusion matrix post-CQRS integration. | UC-20 | Expanded security test suite | Security signoff |
| OPS-01 | Update smoke contracts (`ops:health-smoke`, `ops:migrate-smoke`) for new controls. | UC-17,U0-07 | Smoke scripts/expectations updates | Smoke CI artifacts |
| OPS-02 | Update release readiness gates with upgrade-specific evidence requirements. | UA-20,UB-18,UC-21,OPS-01 | Readiness gate checklist updates | Gate review signoff |
| GOV-01 | Update traceability matrix rows for PDP/BFF/CQRS component mapping. | UA-20,UB-18,UC-21 | Traceability deltas | Traceability completeness check |
| GOV-02 | Final integration ADR/log update package across A/B/C cutover decisions. | UA-20,UB-18,UC-21 | ADR index/log + records | Architecture council approval |

---

## Activation and cutover slices

| Slice ID | Objective | Depends on | Deliverables | Validation/Evidence |
|---|---|---|---|---|
| ACT-01 | Activate PDP for all read routes in staging, compare outcomes. | UA-16 | Flag rollout evidence and mismatch log | Staging comparison report |
| ACT-02 | Activate PDP for all write and console routes in staging. | UA-17,UA-18,ACT-01 | Staging enforcement evidence | Full contract/security pass |
| ACT-03 | Activate BFF split route families progressively in staging. | UB-07..UB-12,ACT-02 | Staging cutover checklist | Route family parity report |
| ACT-04 | Activate CQRS sync mode for selected route families in staging. | UC-19,UC-20,ACT-03 | CQRS sync activation evidence | Freshness/consistency report |
| ACT-05 | Activate async projections in staging with alarms under bounded retry and rollback controls. | UC-16,UC-17,UC-18,ACT-04 | Async activation, rollback-switch execution, and alert drill evidence | Lag/retry/dead-letter evidence pack + health degraded-state validation |
| ACT-06 | Execute production canary activation in deterministic sequence A then B then C with rollback guards. | ACT-02,ACT-03,ACT-04 | Executed canary waves, rollback-drill records per wave, unresolved-delta disposition ledger | Canary acceptance evidence with stage-gated signoff (Platform/SRE + Release Engineering) |
| ACT-07 | Retire legacy toggles/paths after soak and finalize stabilization closure. | ACT-06 | Toggle/path retirement diff audit, cleanup PR package, final architecture-state documentation | Post-soak regression evidence bundle + incident review record |

---

## Completion criteria (upgrade program)
- All `U0-*`, `UA-*`, `UB-*`, `UC-*`, hardening slices, and `ACT-*` slices complete with evidence.
- No unresolved auth boundary regressions.
- No SSOT drift across OpenAPI/contracts/security/ops/traceability/ADR artifacts.
- Release gate package approved with explicit A/B/C cutover evidence.
