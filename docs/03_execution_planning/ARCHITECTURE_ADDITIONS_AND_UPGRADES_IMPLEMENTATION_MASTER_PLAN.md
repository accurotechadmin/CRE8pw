# Architecture Additions and Upgrades Implementation Master Plan

_Status: adopted implementation specification_
_Last updated (UTC): 2026-04-28_

## Purpose
Provide a complete implementation plan for three architecture additions/upgrades using the current CRE8 PHP stack/dependencies:

1. **Upgrade A** — Policy Decision Point (PDP) service-in-process.
2. **Upgrade B** — BFF-by-surface (Gateway BFF + Console BFF in one Slim runtime).
3. **Upgrade C** — Evented Command/Query split (CQRS-lite) with audit-first core.

This document is the authoritative implementation specification for executing these upgrades slice-by-slice.

## Scope and assumptions
- This repository is SSOT-driven and may be partially scaffolded in runtime code.
- Instructions include both **codebase implementation** and **SSOT synchronization** tasks.
- The dependency baseline remains unchanged unless explicitly justified in an ADR.
- Existing contracts remain envelope-first and route-compatible unless versioned.

## Delivery strategy
- Implement in **three parallel-capable tracks** with shared prerequisites.
- Use feature flags for non-breaking activation.
- Land each track as small, evidence-backed PR slices.
- Preserve current behavior by default while introducing new architecture paths.

---

## 0) Cross-cutting prerequisites (required before A/B/C)

### 0.1 Governance and planning setup
1. Open a Class B planning PR to register this plan in docs.
2. Add three epic tickets (A/B/C) plus one integration epic.
3. Add risk register entries for policy regressions, auth boundary drift, and projection consistency.
4. Define rollout owners: security lead, backend lead, platform/SRE lead, QA lead.

### 0.2 Repository structure hardening
Create/confirm the following directories:
- `src/Application/Http/Middleware/`
- `src/Application/Http/Controller/Gateway/`
- `src/Application/Http/Controller/Console/`
- `src/Application/Policy/`
- `src/Application/Auth/`
- `src/Application/Domain/`
- `src/Application/Command/`
- `src/Application/Query/`
- `src/Application/Projection/`
- `src/Application/Audit/`
- `src/Infrastructure/Persistence/`
- `src/Infrastructure/Observability/`
- `config/`
- `database/migrations/`
- `database/seeds/`
- `tests/Contract/`
- `tests/Security/`
- `tests/Integration/`
- `tests/Unit/`

### 0.3 Configuration flags
Add to environment contract + runtime config:
- `ARCH_PDP_ENABLED=false`
- `ARCH_BFF_SPLIT_ENABLED=false`
- `ARCH_CQRS_LITE_ENABLED=false`
- `ARCH_PROJECTION_ASYNC=false`
- `ARCH_POLICY_DECISION_LOG=true`

### 0.4 Baseline quality harness
1. Ensure CI runs:
   - `composer qa`
   - `composer test:contract`
   - `composer test:security`
   - `composer ops:health-smoke`
2. Add coverage thresholds by test family.
3. Add per-surface smoke tests to assert owner/gateway context non-interchangeability.

### 0.5 SSOT synchronization prerequisites
Create an “architecture-additions-and-upgrades checklist” requiring updates in same PR where behavior changes:
- OpenAPI
- route inventory
- API contract guide
- UI runtime contract
- error catalog
- authorization spec/tables
- acceptance matrix
- traceability matrix
- ADR records

---

## 1) Upgrade A implementation plan — PDP service-in-process

## A.1 Target outcome
All authorization decisions are computed through a centralized, testable PDP module returning canonical outcomes (`allow/deny`, `http_status`, `error_code`, `detail_code`, `obligations`).

## A.2 Component changes

### A.2.1 New policy domain model
Create:
- `src/Application/Policy/Decision.php`
- `src/Application/Policy/DecisionContext.php`
- `src/Application/Policy/Obligation.php`
- `src/Application/Policy/PolicyRule.php`

Rules:
- No route handler may execute domain mutation before a positive decision.
- Decision object must carry request ID linkage and surface label.

### A.2.2 Policy context builders
Create:
- `src/Application/Policy/Context/OwnerContextBuilder.php`
- `src/Application/Policy/Context/KeyContextBuilder.php`
- `src/Application/Policy/Context/RouteActionResolver.php`

Inputs:
- JWT claims (issuer/audience/type/device/lineage)
- route metadata
- resolved principal + delegation envelope
- keychain effective snapshot (if actor is keychain)

### A.2.3 PDP engine and registry
Create:
- `src/Application/Policy/PdpService.php`
- `src/Application/Policy/RuleRegistry.php`
- `src/Application/Policy/Rules/*.php`

Seed rules for:
- owner-only console operations
- gateway permission checks (`posts:*`, `comments:create`, etc.)
- delegation subset/depth/expiry constraints
- use-key mutation restrictions
- keychain membership invariants
- master-key SYSADMIN boundaries
- device binding enforcement outcomes

### A.2.4 Middleware integration
Create/modify:
- `src/Application/Http/Middleware/AuthnMiddleware.php`
- `src/Application/Http/Middleware/PolicyDecisionMiddleware.php`

Behavior:
- Authn middleware authenticates identity only.
- Policy middleware invokes PDP and short-circuits deny with canonical envelope.
- Deny path must preserve `request_id` and catalog detail codes.

### A.2.5 Decision table externalization
Add config-backed tables:
- `config/policy/route_actions.php`
- `config/policy/permissions.php`
- `config/policy/detail_codes.php`

### A.2.6 Test plan for A
- Unit tests: all rule classes, context builders, decision formatter.
- Contract tests: 401/403/404/409/422 mapping with stable detail codes.
- Security tests: token type/audience/lineage/device mismatch + escalation attempts.
- Snapshot tests: decision table outputs by route/action matrix.

### A.2.7 SSOT/doc updates for A
Update:
- authorization spec (PDP as enforcement mechanism)
- authorization decision tables
- request pipeline contract (explicit policy stage semantics)
- error code catalog (new/clarified detail codes)
- traceability matrix (PdpService mapping)
- ADR: “PDP in-process as canonical authorization architecture”

### A.2.8 Rollout sequence for A
1. Shadow mode (`ARCH_PDP_ENABLED=false`, logging on).
2. Compare old vs PDP decisions in non-prod.
3. Fix mismatches.
4. Enable PDP for read routes.
5. Enable PDP for write routes.
6. Remove legacy ad-hoc checks.

---

## 2) Upgrade B implementation plan — BFF-by-surface

## B.1 Target outcome
Two internal BFF layers (Gateway and Console) orchestrate surface-specific flows while sharing domain services and policy controls.

## B.2 Component changes

### B.2.1 Surface module layout
Create:
- `src/Application/Http/Controller/Gateway/*`
- `src/Application/Http/Controller/Console/*`
- `src/Application/Bff/Gateway/*`
- `src/Application/Bff/Console/*`

Controller rules:
- Controllers delegate orchestration to BFF use-cases.
- BFF use-cases compose domain calls and shape response DTOs.

### B.2.2 DTO/view-model separation
Create:
- `src/Application/Bff/Gateway/Dto/*`
- `src/Application/Bff/Console/Dto/*`

Guidelines:
- Preserve envelope contract.
- Avoid leaking domain internals.
- Surface-specific diagnostics allowed via `meta` extensions (non-breaking only).

### B.2.3 Route registration split
Add:
- `config/routes_gateway.php`
- `config/routes_console.php`
- `config/routes_public.php`

Route bootstrap merges files but keeps isolated ownership.

### B.2.4 Surface error mapping adapters
Create:
- `src/Application/Bff/Gateway/ErrorStateMapper.php`
- `src/Application/Bff/Console/ErrorStateMapper.php`

Purpose:
- Keep canonical HTTP/envelope/detail codes.
- Provide UI-ready error-state hints consistent with UI runtime contract.

### B.2.5 Performance and caching seams
Implement optional caching (read routes only):
- gateway feed read model caching
- console inventory caching with short TTL

Cache key must include actor principal and scope to avoid cross-principal leakage.

### B.2.6 CSRF and session nuances for console BFF
- Ensure console write routes maintain CSRF checks.
- Add BFF-level helpers for CSRF recovery hints in error payload details where permitted.

### B.2.7 Test plan for B
- Contract tests split by surface folder.
- Integration tests for full route-to-BFF orchestration.
- UI parity tests verifying required route-state mappings and 404 resource-specific semantics.
- Security tests to assert no gateway token can access console BFF and vice versa.

### B.2.8 SSOT/doc updates for B
Update:
- architecture and surfaces (BFF layering note)
- UI runtime contract (surface-specific orchestration behavior)
- module boundaries and ownership
- acceptance criteria matrix (surface-specific Given/When/Then)
- traceability matrix with `GatewayBff*` and `ConsoleBff*` services
- ADR: “BFF-by-surface architecture in single runtime”

### B.2.9 Rollout sequence for B
1. Introduce BFF modules behind `ARCH_BFF_SPLIT_ENABLED`.
2. Migrate one gateway route family (feed).
3. Migrate one console route family (posts listing/create).
4. Expand family-by-family.
5. Delete legacy orchestration code.

---

## 3) Upgrade C implementation plan — CQRS-lite + audit-first

## C.1 Target outcome
Write operations follow explicit command handlers with audit/event emission; reads use query services/projections optimized for surface response needs.

## C.2 Component changes

### C.2.1 Command layer
Create:
- `src/Application/Command/CommandBus.php`
- `src/Application/Command/Handlers/*`
- `src/Application/Command/Commands/*`

Initial command set:
- IssueDelegatedKey
- ChangeKeyLifecycle
- CreatePost
- EditPost
- FlagPost
- CreateComment
- ModeratePost
- ModerateComment
- AddKeychainMember
- RemoveKeychainMember

### C.2.2 Query layer
Create:
- `src/Application/Query/QueryBus.php`
- `src/Application/Query/Handlers/*`
- `src/Application/Query/Queries/*`

Initial query set:
- GetFeed
- GetPostDetail
- GetPostComments
- ListConsolePosts
- ListKeychains
- GetKeychainMembers
- ResolveKeychainEffective

### C.2.3 Projection subsystem
Create:
- `src/Application/Projection/ProjectionUpdater.php`
- `src/Application/Projection/Projectors/*`

Data changes:
- add projection tables for feed ordering and keychain effective view if needed.
- ensure idempotent projector updates keyed by event ID.

### C.2.4 Domain event catalog implementation
Create:
- `src/Application/Audit/DomainEvent.php`
- `src/Application/Audit/EventPublisher.php`
- `src/Infrastructure/Observability/MonologEventSink.php`

Event requirements:
- include `event_name`, `timestamp_utc`, `request_id`, `surface`, actor ID, result, detail code.
- redact sensitive fields.

### C.2.5 Transaction boundaries
Rules:
- command handler executes transactional write + event append atomically.
- projection update can be sync (default) or async (flagged).
- async mode requires retry + dead-letter handling.

### C.2.6 Operational controls
- Add queue/worker process if async projections enabled.
- Add health subchecks for projector lag and queue depth.
- Add dashboards for command failure rates and projection latency.

### C.2.7 Test plan for C
- Unit tests: command handlers/query handlers/projectors.
- Integration tests: command->event->projection consistency.
- Failure-injection tests: event sink failures, projector retries, partial failure handling.
- Contract tests: ensure envelope shape unchanged during CQRS migration.

### C.2.8 SSOT/doc updates for C
Update:
- data model spec/reference (projection tables, event log tables if introduced)
- observability event catalog (domain event taxonomy)
- health endpoint contract (projection lag indicators if exposed)
- SLO/SLI spec (new indicators for projection latency/freshness)
- acceptance matrix (eventual-consistency expectations where applicable)
- ADR: “CQRS-lite with audit-first command path”

### C.2.9 Rollout sequence for C
1. Add command/query interfaces with existing services as adapters.
2. Move moderation and key lifecycle writes first (high audit value).
3. Add feed/query projections.
4. Enable async projections in staging only.
5. Promote to production with lag alarms and rollback switch.

---

## 4) Unified integration plan (A + B + C combined)

## 4.1 Recommended execution order
1. **A first (PDP)** to stabilize policy correctness.
2. **B second (BFF split)** to improve surface-level maintainability and UX orchestration.
3. **C third (CQRS-lite)** to improve scalability/audit depth.

## 4.2 Compatibility constraints
- BFF modules must call PDP for all authorization decisions.
- Command handlers must enforce PDP outcomes before mutation.
- Query/projection responses must keep envelope + detail-code contracts.

## 4.3 Cutover checkpoints
At each stage, require:
- full contract/security suite pass
- negative path matrix evidence
- route parity checks
- release gate evidence package updates

---

## 5) Migration slices

Normative exhaustive backlog: `docs/03_execution_planning/ARCHITECTURE_ADDITIONS_AND_UPGRADES_EXHAUSTIVE_SLICES.md`.

### Slice A1
- Create PDP primitives + decision objects.
- Add unit tests and static wiring.

### Slice A2
- Integrate PDP middleware for gateway read routes.
- Add security regressions for device mismatch/detail code mapping.

### Slice A3
- Integrate PDP middleware for write routes + console governance paths.
- Remove legacy per-handler policy branches.

### Slice B1
- Create Gateway BFF structure + migrate `GET /api/feed`.

### Slice B2
- Create Console BFF structure + migrate `GET/POST /console/api/posts`.

### Slice B3
- Migrate keychain and moderation flows to BFF modules.

### Slice C1
- Introduce command bus with moderation and lifecycle commands.

### Slice C2
- Introduce query bus + feed and keychain resolve queries.

### Slice C3
- Add projections + optional async pipeline + operational dashboards.

### Slice I1 (integration hardening)
- Remove dead code paths.
- Verify traceability rows and SSOT sync.
- Complete release readiness evidence.

---

## 6) Definition of done per upgrade track

## A done when
- 100% protected routes use PDP for authz decisions.
- No ad-hoc authorization logic remains in handlers.
- Decision table tests and security edge cases pass.

## B done when
- Gateway and console orchestration paths are fully BFF-managed.
- Route-level parity and UI state/error mapping tests pass.
- No cross-surface orchestration leakage exists.

## C done when
- All write routes execute via command handlers with event emission.
- Critical reads served through query services/projections.
- Projection lag/error SLOs are tracked and alerting validated.

---

## 7) Risk controls and rollback

### Key risks
- Authorization drift during dual-path migration.
- Cross-surface token confusion.
- Projection staleness impacting moderation or lifecycle UX.

### Controls
- Shadow-mode comparisons (old/new decisions).
- Route family canaries and progressive enablement flags.
- Strict fallback to sync projection mode.

### Rollback strategy
- Feature flags disable A/B/C independently.
- Keep legacy execution path until post-cutover soak period completes.
- Preserve migration reversibility for newly added tables.

---

## 8) Required document update matrix for each implementation PR

Every PR with behavioral change MUST include synchronized updates (when affected):
- `docs/ssot_canon/openapi/cre8.v1.yaml`
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
- `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`
- `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`
- `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`
- `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`
- `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`
- `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
- `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md`
- `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
- `docs/ssot_canon/60_decisions/ADR_INDEX.md` + new ADR records

---

## 9) Implementation kickoff checklist
- [ ] Plan approved by architecture/security/platform/QA owners.
- [ ] Feature flags merged with defaults off.
- [ ] Slice backlog created with acceptance criteria.
- [ ] CI jobs enforcing contract/security/ops checks.
- [ ] First PDP slice branch cut.
