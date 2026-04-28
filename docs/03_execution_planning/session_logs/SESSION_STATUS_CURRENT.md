# CRE8 Docset Session Status (Current)

_Status: active_
_Last updated (UTC): 2026-04-28_

## Overall completion by slice family
- U0: completed (8/8 complete: U0-01 through U0-08)
- UA: completed (20/20 complete: UA-01 through UA-20)
- UB: completed (18/18 complete: UB-01 through UB-18)
- UC: in_progress (15/21 complete: UC-01 through UC-15)
- UX: not_started
- SEC: not_started
- OPS: not_started
- GOV: not_started
- ACT: not_started

## In-progress slices
- none recorded

## Blocked slices + blockers + owner needed
- none recorded

## Recently completed slices
- UC-15 — sync projection mode default runtime contract synchronized with fail-closed command-completion semantics requiring synchronous projector application when `ARCH_CQRS_LITE_ENABLED=true` (2026-04-28)
- UC-14 — projector idempotency and replay-protection contract synchronized with projection receipt controls and deterministic duplicate-event no-op semantics (2026-04-28)
- UC-13 — keychain effective-view projection model/projector contract synchronized across architecture, data model, route/UI runtime, acceptance, verification, and traceability artifacts (2026-04-28)
- UC-12 — feed-ordering projection model and projector contract synchronized with sync-first projection-update semantics, idempotent source-event handling, and projection freshness verification/traceability coverage (2026-04-28)
- UC-11 — projection updater/projector canonical ownership synchronized with deterministic projector registration and fail-closed idempotency obligations (2026-04-28)
- UC-10 — console read query-handler canonical ownership synchronized for posts/keychains/members/resolve routes with envelope/detail-code parity verification obligations (2026-04-28)
- UC-09 — gateway read query-handler canonical ownership synchronized for feed/post/comments read routes with resource-specific `404` detail-code stability and route-parity verification obligations (2026-04-28)
- UC-08 — keychain membership command-handler canonical ownership synchronized for membership mutation routes with invariant deny-path preservation and verification/traceability coverage (2026-04-28)
- UC-07 — gateway content command-handler canonical ownership synchronized for create/edit/flag/comment mutation routes with stable `403/404/422` detail-code semantics (2026-04-28)
- UC-06 — moderation and key-lifecycle command-handler canonical ownership synchronized with PDP-gated high-audit mutation path requirements and verification/traceability coverage (2026-04-28)
- UC-05 — transactional command boundary contract synchronized with atomic write+event append rollback semantics and verification/traceability coverage (2026-04-28)
- UC-04 — observability sink redaction safeguards synchronized with deterministic sink-level redaction and fallback delivery metadata requirements (2026-04-28)
- UC-03 — audit/domain-event core model and `EventPublisher` contract synchronized across architecture/module/observability/verification/traceability artifacts (2026-04-28)
- UC-02 — query-bus interface and base query contract synchronized with deterministic handler-resolution and fail-closed semantics (2026-04-28)
- UC-01 — command-bus interface and base command contract synchronized with deterministic handler-resolution and fail-closed semantics (2026-04-28)
- UB-18 — BFF-by-surface closure package synchronized across architecture, UI-runtime, module-boundary, acceptance, verification, traceability, and ADR artifacts (2026-04-28)
- UB-17 — legacy non-BFF orchestration paths retired from migrated protected routes with fail-closed dead-path audit obligations (2026-04-28)
- UB-16 — surface-level route-to-BFF integration verification obligations synchronized for all migrated gateway and console route families (2026-04-28)
- UB-15 — console BFF CSRF recovery-helper diagnostics contract synchronized with canonical CSRF detail-code preservation, deterministic hint taxonomy, and non-CSRF hint suppression verification obligations (2026-04-28)
- UB-14 — console inventory short-TTL caching contract synchronized with owner-principal cache isolation and fail-closed cache bypass obligations (2026-04-28)
- UB-13 — gateway read-cache seams synchronized with actor/scope-aware key derivation and mutation-triggered invalidation obligations (2026-04-28)
- UB-12 — console keychain/invite/key-issuance/lifecycle route families migrated to Console BFF governance/keychain orchestration contract with auth-context boundary and CSRF parity verification obligations (2026-04-28)
- UB-11 — console moderation route family migrated to Console BFF moderation orchestration contract with transition-rule parity and canonical detail-code stability obligations (2026-04-28)
- UB-10 — console posts list/create route family migrated to Console BFF posts-governance orchestration contract with CSRF and envelope/error parity obligations (2026-04-28)
- UB-09 — gateway comments route family migrated to Gateway BFF orchestration contract with route-parity/detail-code stability verification obligations and traceability coverage (2026-04-28)
- UB-08 — gateway post create/edit/flag route family migrated to Gateway BFF orchestration contract with contract/security regression obligations and traceability coverage (2026-04-28)
- UB-07 — gateway feed read route family migrated to Gateway BFF orchestration contract with contract-parity and latency-comparison verification obligations (2026-04-28)
- UB-06 — console error-state mapper contract synchronized with canonical detail-code preservation and deterministic UI-runtime recovery hints, including verification and traceability updates (2026-04-28)
- UB-05 — gateway error-state mapper contract synchronized with canonical envelope/detail-code preservation and regression-verification requirements (2026-04-28)
- UB-04 — route registration partition contract synchronized across architecture/module boundaries with fail-closed route boot drift checks (2026-04-28)
- UB-03 — surface-specific DTO/view-model package isolation synchronized across architecture/module/UI runtime contracts, verification obligations, and traceability mapping (2026-04-28)
- UB-02 — Gateway/Console BFF service scaffolding boundaries synchronized across architecture/module contracts, verification obligations, and traceability mapping (2026-04-28)
- UB-01 — Gateway/Console controller module split synchronized across architecture/module contracts, verification obligations, and traceability mapping (2026-04-28)
- UA-20 — SSOT/ADR PDP canonicalization closure completed with explicit no-ad-hoc-handler authorization boundary, error-catalog synchronization, and ADR-007 adoption (2026-04-28)
- UA-19 — legacy ad-hoc handler authorization logic removed from normative contract model with mandatory no-ad-hoc-auth verification evidence (2026-04-28)
- UA-18 — console governance protected-route PDP enforcement synchronized across authorization contracts, pipeline contract, verification obligations, and traceability matrix (2026-04-28)
- UA-17 — gateway write protected-route PDP enforcement synchronized with deny short-circuit and detail-code stability requirements (2026-04-28)
- UA-16 — gateway read protected-route PDP enforcement synchronized with route-family integration decision-table coverage (2026-04-28)
- UA-15 — deterministic policy rule-pack composition/loading controls synchronized with fail-closed startup and immutable registry snapshot requirements (2026-04-28)
- UA-14 — route-action/permission/detail-code policy table externalization synchronized with startup integrity assertions and canonical mapping contracts (2026-04-28)
- UA-13 — policy configuration externalization contract synchronized across authorization, middleware, verification, and traceability artifacts (2026-04-28)
- UA-12 — device-binding enforcement outcomes synchronized in PDP deny mappings and canonical detail-code catalog (2026-04-28)
- UA-11 — master-key SYSADMIN boundary rule family synchronized across authorization, master-key, verification, and traceability artifacts (2026-04-28)
- UA-10 — keychain membership invariant rule family synchronized with deterministic deny mappings and test obligations (2026-04-28)
- UA-09 — use-key mutation restriction rules synchronized across authorization spec, decision tables, verification strategy, and traceability matrix (2026-04-28)
- UA-08 — delegation subset/depth/expiry rule family synchronized with canonical deny mappings and verification obligations (2026-04-28)
- UA-07 — gateway permission rule pack synchronized with route-action permission matrix and traceability coverage (2026-04-28)
- UA-06 — owner-only console governance rule contract synchronized across authorization spec, decision tables, verification strategy, and traceability matrix (2026-04-28)
- UA-05 — PDP engine and rule-registry scaffolding contract synchronized across policy, middleware, module ownership, verification, and traceability artifacts (2026-04-28)
- UA-04 — key-context builder normalization contract adopted for gateway policy evaluation and fail-closed claim handling (2026-04-28)

## Upcoming recommended batch
1. UC-16 — implement optional async projection mode (worker + retries + DLQ)
2. UC-17 — add health checks for projector lag and queue depth
3. UC-18 — add operational dashboards for command failures and projection latency
