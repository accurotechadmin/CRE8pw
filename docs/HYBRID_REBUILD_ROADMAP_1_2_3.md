# CRE8 Hybrid Rebuild Roadmap (1 + 2 + 3)

_Date: 2026-04-06_

## 0) Purpose and Scope
This roadmap defines a **super-structured rebuild plan** using the recommended hybrid:
1. **Hardened Modular Monolith**
2. **Contract-First Runtime**
3. **Domain-First Policy Engines (DDD-lite)**

It assumes:
- same core stack (PHP 8.2, Slim 4, PHP-DI, MySQL/MariaDB, JWT),
- rebuild from scratch,
- selective reuse of the current prototype codebase as reference only.

This document is the implementation roadmap and scaffolding guide. A separate future `.json` file will define exact file-by-file scaffolding.

---

## 1) North-Star Outcomes
By the end of this roadmap, CRE8 should be:
- **Correct-by-contract:** route/runtime/docs/test sync is automated.
- **Modular-by-design:** feature modules have strict boundaries.
- **Policy-driven:** security/authorization logic is centralized in explicit policy classes.
- **Extensible:** new products (e.g., XtraType) can add modules without touching core internals.
- **Operationally mature:** startup evidence, health probes, and release gates are first-class.

---

## 2) Guiding Principles (Non-Negotiables)
1. **SSOT first:** contracts, schemas, and policies are authoritative.
2. **Fail closed:** security and startup validation must halt on critical violations.
3. **Pure core, impure edges:** domain/policy layers are pure; IO lives in adapters.
4. **Feature ownership:** each feature owns handler → use case → policy → repository flow.
5. **Backward-compatible evolution:** additive API changes by default; breaking changes versioned.
6. **Automation over ceremony:** any high-risk sync rule must be CI-enforced.

---

## 3) Reference-Use Strategy for Existing Prototype
Use the current codebase as a **reference source**, not a direct transplant.

### 3.1 What to lift conceptually
- route names and endpoint intent,
- envelope shape/error semantics,
- JWT claims model and surface separation,
- key lifecycle and delegation constraints,
- baseline middleware chain and boot checks.

### 3.2 What to avoid copying 1:1
- mixed service responsibilities,
- route-to-domain coupling without explicit use-case layer,
- docs/runtime drift patterns,
- implicit policy logic embedded across handlers.

### 3.3 Migration method
- For each capability, create a **parity card**:
  - `Prototype behavior`
  - `Target SSOT behavior`
  - `Gap`
  - `Decision`
  - `Implementation owner`
  - `Acceptance checks`

---

## 4) Target Architecture (Hybrid 1 + 2 + 3)

## 4.1 Top-level shape
- **Kernel (core platform)**
  - shared contracts, envelope, boot/runtime, security primitives, policy interfaces.
- **Domain modules**
  - Auth, Delegation/Keychains, Content, Moderation, Health/Operations.
- **Infrastructure adapters**
  - PDO repositories, JWT signer/verifier adapters, rate limit/cors/http client adapters.
- **Interface layer**
  - Slim routes/handlers, middleware, request/response mappers.
- **Contract layer**
  - OpenAPI, JSON schemas, error catalog, examples, sync checkers.

## 4.2 Dependency direction
Allowed direction only:
- Interface → Application → Domain
- Infrastructure → Application/Domain interfaces
- Domain never depends on Slim/PDO/framework details.

## 4.3 Policy engine pattern
Each security-sensitive rule set becomes a pure policy object:
- `DelegationPolicy`
- `KeyLifecyclePolicy`
- `VisibilityPolicy`
- `ModerationPolicy`
- `TokenSurfacePolicy`

Policy methods return structured decisions:
- `allow | deny`
- `reason_code`
- `violations[]`

---

## 5) Staged Roadmap (Execution Plan)

## Stage A — Program Setup and Governance (Week 1)
### Goals
- lock scope and success metrics,
- define team roles and architecture ownership,
- establish baseline workflow.

### Deliverables
- architecture charter,
- SSOT synchronization rules,
- decision log template,
- parity card template.

### Exit criteria
- all stakeholders agree on module boundaries,
- Definition of Done includes contract + tests + docs sync.

---

## Stage B — Scaffolding and Foundation (Weeks 2–3)
### Goals
- create clean project skeleton,
- wire boot/runtime/config foundations,
- establish testing and linting harness.

### Deliverables
- base folder structure (see section 8),
- app bootstrap and DI wiring,
- envelope responder v1,
- middleware skeletons in canonical order,
- empty module skeletons with interfaces,
- test harness (unit/contract/security placeholders).

### Exit criteria
- app boots with health stub,
- CI runs static checks and placeholder tests,
- architectural dependency rules are enforced.

---

## Stage C — Contract-First Enablement (Weeks 4–5)
### Goals
- make SSOT contract executable,
- establish anti-drift automation.

### Deliverables
- OpenAPI v1 baseline committed,
- JSON schemas for success/error envelopes,
- contract validation middleware/hooks,
- automation commands:
  - `docs:ssot:lint`
  - `docs:ssot:sync-check`
  - `docs:ssot:report`
- CI gate integrating these checks.

### Exit criteria
- route inventory, OpenAPI, and runtime routes are diff-clean,
- contract examples validate against schemas.

---

## Stage D — Core Domain and Policy Extraction (Weeks 6–9)
### Goals
- implement critical domain logic with explicit policies,
- keep handlers thin and deterministic.

### Deliverables
- policy classes + test suites,
- use-case services per feature,
- repository interfaces + PDO adapters,
- first vertical slices implemented:
  - owner auth/login/refresh,
  - key issue/lifecycle,
  - feed + posts read/create,
  - comments create/list.

### Exit criteria
- policy coverage for high-risk authorization paths,
- security abuse-case tests pass for refresh replay, delegation depth/subset violations.

---

## Stage E — Module Completion and Extensibility (Weeks 10–12)
### Goals
- complete remaining route set,
- define extension points for downstream products.

### Deliverables
- keychain member/resolve capabilities,
- moderation flows,
- module registration contract,
- extension guide (how to add module/routes/policies/migrations),
- XtraType module scaffold example (non-production).

### Exit criteria
- new module can be added without core changes,
- end-to-end contract parity with SSOT for v1 routes.

---

## Stage F — Hardening and Release Readiness (Weeks 13–14)
### Goals
- operational hardening,
- production readiness evidence.

### Deliverables
- startup evidence writer + smoke scripts,
- SLO/SLI instrumentation hooks,
- release checklist automation,
- security header/CSP verification tests,
- runbook and rollback playbooks.

### Exit criteria
- production readiness gates pass,
- release candidate signed with artifacted verification evidence.

---

## 6) Workstream Breakdown (Parallel Tracks)

### WS1 — Platform Kernel
- boot lifecycle, runtime config, envelope contracts, shared value objects.

### WS2 — Contract System
- OpenAPI/spec artifacts, schema validators, examples, drift checkers.

### WS3 — Domain/Policy
- policy engines and use-cases for auth/delegation/content/moderation.

### WS4 — Interface/API
- route handlers, middleware orchestration, request/response mappers.

### WS5 — Persistence and Infra
- repository adapters, migrations, transaction boundaries, key material handling.

### WS6 — Quality/Operations
- CI gates, test packs, smoke checks, observability, release gates.

---

## 7) Definition of Done (Per Capability)
A capability is complete only when all are true:
1. OpenAPI + schemas updated.
2. Route implemented and registered.
3. Use-case + policy logic implemented.
4. Unit tests for policy and use-case pass.
5. Contract/security tests pass.
6. Error codes mapped in catalog.
7. Endpoint examples updated.
8. Traceability matrix row updated.
9. Operational notes/runbook deltas recorded (if relevant).

---

## 8) General Stub/Scaffolding Specification (High-Level)

> This is the high-level structure to guide the future official `.json` scaffolding spec.

## 8.1 Repository layout (proposed)
```text
/src
  /Kernel
    /Bootstrap
    /Config
    /Contracts
    /Http
    /Observability
    /Support
  /Modules
    /Auth
      /Application
      /Domain
      /Infrastructure
      /Interface
    /Delegation
      /Application
      /Domain
      /Infrastructure
      /Interface
    /Content
      /Application
      /Domain
      /Infrastructure
      /Interface
    /Moderation
      /Application
      /Domain
      /Infrastructure
      /Interface
    /Health
      /Application
      /Domain
      /Infrastructure
      /Interface
/tests
  /Unit
  /Contract
  /Security
  /Integration
/docs
  /SSOT
/scripts
/public
```

## 8.2 Standard per-module scaffolding contract
Each module should include:
- `Application/UseCases/*`
- `Domain/Entities/*`
- `Domain/Policies/*`
- `Domain/Repositories/*` (interfaces)
- `Infrastructure/Persistence/*Repository.php`
- `Interface/Http/Handlers/*`
- `Interface/Http/Requests/*`
- `Interface/Http/Responses/*`
- `Interface/Routes/*RouteProvider.php`
- `tests/Unit/Modules/<Module>/...`
- `tests/Contract/Modules/<Module>/...`

## 8.3 Core scaffolding primitives
- `Kernel/Http/EnvelopeResponder`
- `Kernel/Bootstrap/AppFactory`
- `Kernel/Bootstrap/ContainerFactory`
- `Kernel/Bootstrap/BootChecks`
- `Kernel/Contracts/ErrorCodeCatalog`
- `Kernel/Contracts/DecisionResult`
- `Kernel/Config/RuntimeConfig`

## 8.4 Contract artifacts scaffold
- `docs/SSOT/openapi/cre8.v1.yaml`
- `docs/SSOT/schemas/success-envelope.schema.json`
- `docs/SSOT/schemas/error-envelope.schema.json`
- `docs/SSOT/Route_Inventory_Reference.md`
- `docs/SSOT/Error_Code_Catalog.md`
- `docs/SSOT/Traceability_Matrix.md`

## 8.5 Automation scaffold
- Composer scripts placeholders:
  - `docs:ssot:lint`
  - `docs:ssot:sync-check`
  - `docs:ssot:report`
- Script stubs in `/scripts/ssot/*`
- CI workflow to execute contract + test gates.

---

## 9) Suggested Milestones and Gate Reviews

### Milestone M1 — Skeleton Ready
- foundation scaffolding done,
- boot + health stub operational,
- CI baseline green.

### Milestone M2 — Contract Lock
- OpenAPI/routes/examples synced,
- anti-drift checks enabled and required.

### Milestone M3 — Auth/Delegation Core
- owner + key auth flows complete,
- policy engines and abuse tests passing.

### Milestone M4 — Content and Keychain Completion
- posts/comments/moderation/keychain routes complete,
- extensibility guide and module template shipped.

### Milestone M5 — RC Readiness
- production gates, runbooks, and smoke checks pass.

---

## 10) Risk Register and Mitigations
1. **Scope creep** → enforce milestone-based backlog freeze.
2. **Policy inconsistency** → centralize decisions in policy classes only.
3. **Contract drift** → fail PRs on SSOT sync checker failure.
4. **Adapter leakage into domain** → architecture tests for dependency direction.
5. **Over-engineering early** → keep first release focused on v1 route parity.

---

## 11) Immediate Next Actions (First 10 Days)
1. Approve this roadmap and milestone definitions.
2. Draft official scaffolding `.json` schema shape (not file list yet).
3. Create repository skeleton per section 8.
4. Wire CI baseline + placeholder SSOT scripts.
5. Implement first end-to-end vertical slice (`/health`, `/api/auth/login`) as template.
6. Start parity cards for all existing prototype capabilities.

---

## 12) Decision Recommendation
Proceed with the hybrid rebuild using this staged plan. Use prototype behavior as validation input, while enforcing the new modular + contract-first + policy-first architecture as the implementation standard.

