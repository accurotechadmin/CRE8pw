# CRE8 Codebase + Documentation Study Report

_Date produced (UTC): 2026-04-05_

## Executive summary

- CRE8 is a Slim 4 + PHP-DI backend API with an unbundled static SPA under `public/ui`, built around policy-driven middleware, JWT auth (owner vs key surfaces), and service-layer domain logic.
- The codebase is intentionally contract-oriented: many tests assert route strings, middleware order, and behavior invariants, not only pure unit outputs.
- The document set is unusually well-aligned with code and is organized as a canonical operational/manual layer plus `docs/dev/*` execution artifacts.

---

## Part A — What I learned about the **codebase**

### 1) Runtime shape and bootstrap model

The process starts in `public/index.php`, which loads `.env`, normalizes JWT key inputs (inline PEM or path), builds `RuntimeConfig`, builds the DI container, runs startup assertions, logs structured boot readiness/failure events, and then runs Slim. On fatal startup exceptions it returns deterministic JSON with `boot_failed` and a generated request ID instead of raw traces. This is a strong production-hardening baseline.

### 2) Architectural decomposition

The project is cleanly segmented into:
- `Bootstrap` for app/container/boot checks,
- `Config` for typed runtime and env validation,
- `Http` for middleware/route wiring,
- `Application` for business services,
- `Security` for signing/verifying/hash/key material,
- `Observability` for structured auditing.

This separation is reinforced by both docs and contract tests.

### 3) Transport pipeline is policy-first

Global middleware order is explicitly declared in `MiddlewareOrder::GLOBAL`, then resolved via `MiddlewareRegistry`, and added in reverse so execution follows declared order.

Flow intent: normalize errors/request IDs first, enforce security and CORS/rate/validation/parsing, classify routing, then apply CSRF + per-surface middleware.

Per-surface middleware is explicit:
- console → owner JWT,
- gateway → key JWT + device limit + use-key mutation guard.

This gives very readable security boundaries between user-facing surfaces.

### 4) Routes are orchestrators, services hold domain behavior

`RouteRegistrar` is the single route map and keeps handlers mostly orchestration-focused:
- parse/request-level validations,
- call domain services,
- shape envelope responses.

Surface groupings are clear:
- public/bootstrap (`/`, `/health`, JWKS, `/ui*`, signup/login/refresh),
- gateway (`/api/*` feed/posts/comments/flags),
- console (`/console/api/*` posts, moderation, key lifecycle, keychains, invites).

Notable implementation detail: `/ui[/{route:.*}]` serves both SPA fallback and static assets safely (path traversal constrained via `realpath` and root prefix checks).

### 5) Auth and token model is dual-surface and strict

The system distinguishes owner vs key principals and enforces this both at signer and verifier levels:
- `typ=owner` ↔ console audience,
- `typ=key`/`typ=delegation` ↔ gateway audience.

Signer/verifier both enforce temporal windows and max TTLs; verifier uses 60-second leeway. Delegation tokens require lineage claims (`delegation_envelope_id`, `initial_author_key_id`).

Refresh flow has a pragmatic feature: `/api/auth/refresh` first tries owner refresh, then falls back to key refresh when mismatch reason indicates surface mismatch.

### 6) Configuration and profile hardening are strongly opinionated

`EnvValidator` + `BootChecks` implement layered constraints:
- required env set,
- profile constraints (`APP_ENV`, CORS wildcard only local, prod no SQLite),
- issuer format and HTTPS in stage/prod,
- key source format/path safety,
- optional policy integers must be positive.

`BootChecks` also validates dependency presence and middleware order contract, and can emit boot evidence to file if configured.

### 7) Data model and persistence style

The app uses PDO with service-owned SQL and SQLite-friendly auto-bootstrap of tables in constructors/services. Core entities include principals, credentials, token families, delegation envelopes/invites, posts/comments/revisions/flags/moderation actions.

This indicates a portability-first persistence strategy with lightweight schema migration assumptions.

### 8) Frontend architecture

The UI is a no-build static SPA:
- `index.html` shell with accessibility hooks,
- `app.js` for client-side router and view rendering,
- `state.js` for localStorage sessions + persistent `X-Device-Id`,
- `api-client.js` for envelope-aware fetch wrapper.

UX explicitly models route states (`idle/loading/submitting/success/validation_error/forbidden/not_found/server_error`) and includes a response inspector panel for integration debugging.

### 9) Observability model

Audit/event emission is first-class:
- startup emits `boot.startup_ready` / `boot.startup_failed`,
- middleware/services emit namespaced events,
- `MonologAuditEmitter` normalizes required fields and redacts sensitive keys recursively.

There is also fallback behavior when primary log delivery fails.

### 10) Testing philosophy

`composer.json` scripts define contract/security/QA and smoke checks. The test set emphasizes behavioral contracts (route wiring strings, middleware contracts, bootstrap invariants) and security primitives (JWT signer/verifier, API key hashing, key material safety).

This is good for preventing accidental drift in runtime policy guarantees.

---

## Part B — What I learned about the **document set**

### Overall quality and alignment

The docs are structured as an authoritative top-level reference set and explicitly map claims to concrete code locations and tests. `docs/README.md` provides a reading order and strongly positions docs as canonical state.

### Per-document findings

1. **`docs/inventory_anatomy.md`**
   - Comprehensive index of runtime, backend modules, UI files, scripts/tests, and doc layers.
   - Useful as a “where does X live?” orientation map.

2. **`docs/architecture_overview.md`**
   - Clear system composition and trust-surface model (`public`, `gateway`, `console`).
   - Highlights extension seams (new service, route, middleware, audit backend).

3. **`docs/request_lifecycle.md`**
   - Enumerates exact middleware sequence and common rejection taxonomy.
   - Particularly helpful for debugging `401/403/422/429/400` outcomes.

4. **`docs/api_reference_stub.md`**
   - Current endpoint inventory and envelope contract.
   - Documents notable policy constraints (permissions, use-key restrictions, moderation behavior).

5. **`docs/data_model_stub.md`**
   - Provides table-level conceptual model and lifecycle/state enums.
   - Calls out token-family rotation/replay behavior.

6. **`docs/security_model.md`**
   - Summarizes auth channels, JWT controls, key material safeguards, runtime controls, and redaction approach.
   - Mirrors code-level controls well.

7. **`docs/configuration_reference.md`**
   - Enumerates required/optional env vars and profile safety rules.
   - Ties runtime mapping to `RuntimeConfig` + policy DTOs.

8. **`docs/frontend_spa_guide.md`**
   - Good map of UI route inventory and state model.
   - Clarifies guard behavior for owner vs key sessions and write pre-checks.

9. **`docs/testing_strategy.md`**
   - Concise explanation of suite intent and key commands.
   - Correctly emphasizes contract-heavy approach.

10. **`docs/observability_runbook.md`**
    - Provides event families and request-ID-first triage flow.
    - Includes delivery-failure fallback expectations.

11. **`docs/deployment_operations.md`**
    - Captures prerequisites, boot checks, health verification, and startup failure behavior.

12. **`docs/contributing.md`**
    - Encodes expected workflow: source → tests → docs → checks.

13. **`docs/glossary.md`**
    - Defines core vocabulary aligned to auth/middleware/domain model.

14. **`docs/roadmap_backlog.md`**
    - Explicitly future-facing, avoids conflating shipped behavior with planned improvements.

### Doc-set strengths

- Strong code traceability and minimal ambiguity.
- Good separation between “current truth” and “future backlog”.
- Security/operations/testing are documented, not just product endpoints.

### Gaps/opportunities noted in docs themselves

- API docs are still “stub-level” in that they do not yet include endpoint-by-endpoint request/response examples.
- Architecture visuals (sequence/context/component diagrams) are listed as backlog items.
- A generated docs-to-code cross-reference index would improve maintainability further.

---

## Final assessment

The repository appears intentionally engineered for **policy consistency and operational safety** over rapid ad hoc changes. Its most distinctive traits are:
1. strict middleware/surface policying,
2. robust JWT claim/audience/type enforcement,
3. deterministic envelope/error handling with request correlation,
4. contract-first regression tests,
5. a documentation layer that mostly matches shipped behavior.

If this project continues adding richer endpoint examples and diagrams while preserving current test rigor, it should remain easy to operate and evolve safely.
