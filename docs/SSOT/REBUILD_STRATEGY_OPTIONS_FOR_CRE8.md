# CRE8 Rebuild Strategy Options (Same Tech Stack)

_Status: draft_
_Last updated (UTC): 2026-04-06_

_Date: 2026-04-06_

## Context
You asked whether to repeat the current approach when rebuilding from scratch, and what other clearly better paths could mature CRE8 into a highly extensible developer platform (including products like XtraType) while keeping the same stack (PHP 8.2, Slim 4, PHP-DI, MySQL/MariaDB, JWT, contract/security testing).

## Short answer
- **Do not repeat the current approach exactly as-is.**
- Keep the stack, but adopt a more explicit architectural shape so route/docs drift and domain/service coupling are less likely.
- The best path is likely a **modular monolith with strict ports/adapters + contract-first automation**.

---

## Option 1 — Hardened Modular Monolith (Recommended baseline)

### What it is
Keep one deployable app, but split into modules with clear boundaries:
- `Auth`
- `Delegation/Keychains`
- `Content (Posts/Comments/Moderation)`
- `Operations/Observability`

Each module has:
- Application services (use cases)
- Domain model/rules
- Infrastructure adapters (PDO repos, token signer/verifier, external HTTP)
- Explicit API contracts and mappers

### Why it’s better
- Fastest maturity gains with lowest rewrite risk.
- Better extensibility than a single broad service layer.
- Easier for third-party developers to “swap adapters” without changing core logic.

### Tradeoffs
- Requires discipline around boundaries and dependency direction.
- Some up-front refactoring cost.

---

## Option 2 — Contract-First Runtime (OpenAPI + schemas drive implementation)

### What it is
Treat `docs/SSOT/openapi/cre8.v1.yaml` + envelope schemas as the build source of truth:
- Generate/request-validate DTOs from OpenAPI where possible.
- Add CI checks that diff:
  1. route registrar ↔ OpenAPI
  2. OpenAPI ↔ endpoint examples
  3. error codes in code/tests ↔ catalog

### Why it’s better
- Directly prevents the biggest historical failure mode: docs/runtime drift.
- Safer for external developers integrating CRE8 as a package.

### Tradeoffs
- Slightly slower iteration when changing endpoints.
- Requires tooling setup and maintenance.

---

## Option 3 — Domain-First (DDD-lite) with Policy Engines

### What it is
Keep Slim/PHP, but model critical domains explicitly:
- `KeyLifecyclePolicy`
- `DelegationPolicy`
- `VisibilityPolicy`
- `ModerationPolicy`

Routes call use-cases; use-cases call policies; policies are pure and heavily tested.

### Why it’s better
- Makes CRE8’s unique value (delegation/key logic) explicit and reusable.
- Easier for app builders (e.g., XtraType) to extend rules safely.

### Tradeoffs
- Requires better modeling and naming discipline.
- Initial velocity dip while extracting policy objects.

---

## Option 4 — Product-Kernel + Extension Modules (Plugin-style within monolith)

### What it is
Create a stable “CRE8 kernel” package inside repo:
- AuthN/AuthZ core
- key/delegation primitives
- envelope/middleware contracts

Then add extension modules:
- `cre8-module-posts`
- `cre8-module-comments`
- `cre8-module-xtratype` (future)

Modules register routes/services via module manifests and DI wiring.

### Why it’s better
- Most directly supports “developers building their own creations.”
- Encourages reusable capabilities and clear extension points.

### Tradeoffs
- Requires robust module lifecycle/versioning docs.
- More complexity in bootstrapping and dependency management.

---

## Option 5 — Vertical Slice Architecture (Feature-by-feature, end-to-end)

### What it is
Organize by feature slice instead of technical layer:
- `Features/Auth/Login`
- `Features/Keys/Issue`
- `Features/Keychains/Resolve`
- `Features/Posts/Create`

Each slice owns handler, request validation, use-case, persistence adapter, tests.

### Why it’s better
- Keeps behavior cohesive and easier to extend safely.
- Reduces “god services” and hidden cross-feature coupling.

### Tradeoffs
- Shared primitives must be intentionally centralized.
- Can duplicate logic if governance is weak.

---

## Option 6 — Operationally Mature API Platform (same architecture, stronger engineering system)

### What it is
Retain current structure mostly, but invest heavily in maturity rails:
- mandatory architecture decision records for behavior changes
- strict SSOT automation gates in CI
- mutation/abuse-case tests for security-sensitive flows
- release train with readiness gates + smoke evidence artifacts

### Why it’s better
- Lower refactor risk; focuses on reliability/process maturity.
- Good if delivery speed is critical and architecture changes must be minimal.

### Tradeoffs
- Won’t fully solve extensibility limitations alone.
- Can harden the wrong abstractions if underlying shape stays weak.

---

## Comparative view

| Option | Extensibility | Delivery speed | Risk | Best for |
|---|---:|---:|---:|---|
| 1. Modular monolith | High | High | Medium | Most teams rebuilding pragmatically |
| 2. Contract-first runtime | High | Medium | Low-Med | API reliability and integrator trust |
| 3. Domain-first policies | Very High | Medium | Medium | Complex auth/delegation correctness |
| 4. Kernel + extension modules | Very High | Medium-Low | Medium-High | Productizing CRE8 as a framework |
| 5. Vertical slices | High | Medium-High | Medium | Fast feature evolution with discipline |
| 6. Ops-maturity-first | Medium | High | Low | Immediate stability without big restructure |

---

## Recommended path for a fresh rebuild

### Recommended hybrid: **1 + 2 + 3**, staged
1. **Start with Option 1 (modular monolith)** as structural backbone.
2. **Add Option 2 (contract-first automation)** immediately to prevent drift from day one.
3. **Apply Option 3 (policy extraction)** to high-risk areas first:
   - delegation depth/subset rules
   - key lifecycle transitions
   - visibility/comment permissions

### Why this hybrid
- Keeps the current stack and team familiarity.
- Produces a maintainable product sooner than a full plugin framework jump.
- Builds a clean base for future module/plugin packaging.

---

## Practical 90-day blueprint (same stack)

### Phase 1 (Weeks 1–3): Foundation
- Define module boundaries and dependency rules.
- Introduce architecture tests enforcing boundary imports.
- Establish route contract sync checker in CI.

### Phase 2 (Weeks 4–7): Contract and policy extraction
- Extract pure policy classes for auth/delegation/content permissions.
- Convert key routes to use DTOs and validators tied to OpenAPI shapes.
- Add abuse-case tests for refresh replay, delegation violations, and comment toggles.

### Phase 3 (Weeks 8–10): Extension readiness
- Publish internal extension guide:
  - how to add a new post type
  - how to add a new permission class
  - how to register a module route set
- Add reference “XtraType annotation module” skeleton.

### Phase 4 (Weeks 11–13): Hardening and release
- Wire docs:ssot lint/sync/report commands into composer + CI.
- Add production-readiness evidence artifacts at release time.
- Freeze v1 extension points and document compatibility policy.

---

## Decision rule
If your top goal is **“be a readily extensible package for developers”**, choose the **hybrid path (1+2+3)** now, then evolve toward Option 4 after core behavior stabilizes.

