# Inventory & Anatomy of the CRE8.pw Codebase

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++ (high-detail inventory, pending final source-cited deep sections)_

## 1) System shape at a glance

CRE8.pw is a Slim/PHP service with a static browser SPA under `public/ui`, centered on:

- typed runtime policies,
- layered middleware enforcement,
- JWT + API key lifecycle controls,
- uniform API envelopes,
- structured audit logging,
- and strong contract/security test coverage.

## 2) Repository inventory by layer (high-level)

### A. Runtime and bootstrap

- `public/index.php` — startup orchestration, environment normalization, container build, boot checks, and startup-failure envelope behavior.
- `src/Bootstrap/*` — app factory, DI registration, startup safety assertions.

### B. Configuration + policy model

- `src/Config/*` — env validation and typed policy objects (`JwtPolicy`, `CorsPolicy`, `RateLimitPolicy`, `RuntimeConfig`).

### C. Core HTTP primitives

- `src/Core/Http/EnvelopeResponder.php` — success/list/error envelope response shape.
- `src/Core/Request/RequestId.php` — request correlation id generation/validation.

### D. Domain services

- `src/Application/Auth/*` — owner auth + key lifecycle + refresh/token family handling.
- `src/Application/Posts/*` — posts/comments/moderation.
- `src/Application/Feed/*` and `src/Application/Health/*` — feed pagination and health diagnostics.

### E. Transport boundary

- `src/Http/Routes/RouteRegistrar.php` — surface-aware route registration.
- `src/Http/Middleware/*` — auth, validation, CORS, CSRF, rate limiting, request-id, route marker, JSON parser, security headers, and scope restrictions.

### F. Security + identity primitives

- `src/Security/*` — signing/verifying, claim-policy checks, key-material safety checks, hasher, JWKS.

### G. Observability

- `src/Observability/*` — audit emission interface and Monolog implementation.

### H. Frontend integration layer

- `public/ui/*` — static SPA shell, routing, state, API client, and route views.

### I. Test and validation artifacts

- `tests/Contract/*` and `tests/Security/*` — behavioral contracts and security expectations.
- `scripts/*` — operational smoke checks.

### J. Planning and history

- `UI_IMPLEMENTATION_PLAN.md` + `docs/dev/*` — implementation, decisions, and QA execution history.

## 3) Inventory table template (to complete)

| Path | Layer | Responsibility | Key contracts/tests | Extensibility touchpoints |
|---|---|---|---|---|
| `src/Http/Routes/RouteRegistrar.php` | Transport | Route wiring by surface | `tests/Contract/RouteRegistrarContractsTest.php` | Add route families + policy guards |
| `src/Application/Auth/KeyLifecycleService.php` | Domain | Key issue/refresh/transition | security + contract suites | Add key classes, invite semantics |
| `public/ui/app.js` | Frontend | SPA router/views + UX guards | QA matrix + integration checks | Add endpoint pages + route policies |
| _(expand for all major files)_ | | | | |

## 4) Internal anatomy to capture in final version

### 4.1 Runtime composition chain

`index.php` → `RuntimeConfig::fromEnv` → `ContainerFactory::build` → `BootChecks::assert` → `AppFactory::create` → middleware pipeline → routes.

### 4.2 Middleware pipeline anatomy

Capture for each middleware:

- prerequisites,
- side effects (headers/context),
- rejection behavior (codes + detail codes),
- audit emission behavior,
- ordering dependencies.

### 4.3 Domain responsibility boundaries

Document ownership map:

- what logic lives in `AuthService` vs `KeyLifecycleService`,
- where moderation policy decisions occur,
- where persistence assumptions leak into service code.

### 4.4 Frontend/backed contract boundary

Define:

- envelope schema assumptions by UI,
- auth/session state assumptions,
- error reason-code mappings,
- route-level permission guards mirrored in UI.

## 5) Extensibility map (to complete)

### Extension seam catalog

- **New endpoint family:** add route + middleware policy + service + contract test + UI route.
- **New token type:** signer/verifier policy updates + middleware usage + tests.
- **New key policy dimension:** key lifecycle service + UI guard updates + docs glossary updates.
- **New observability sink:** implement `AuditEmitter` and wire via container.

### Compatibility checklist template

- [ ] Backward compatibility impact assessed.
- [ ] Envelope/error schema compatibility checked.
- [ ] Security model updated.
- [ ] Test contracts expanded.
- [ ] Docs index and glossary updated.

## 6) Gaps to close for final “authoritative” inventory

- [ ] Fill file-by-file ownership and dependency graph.
- [ ] Add package-level call graph diagrams.
- [ ] Add ADR links from each major subsystem.
- [ ] Add “common failure modes” references for operators.
- [ ] Add versioned change log for architecture movement.
