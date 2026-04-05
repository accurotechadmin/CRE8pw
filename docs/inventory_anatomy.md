# Inventory & Anatomy of the CRE8 Codebase

_Last updated (UTC): 2026-04-05_

## 1) System shape at a glance

CRE8 is a Slim/PHP backend with a static SPA frontend under `public/ui`, backed by typed runtime configuration, policy-heavy middleware, JWT/key lifecycle controls, and broad contract/security test coverage.

## 2) Repository inventory by layer

### Root configuration and orchestration

- `composer.json`: dependency graph, autoloading, QA/test/smoke scripts.
- `dot.env`: local environment template and policy knobs.
- `UI_IMPLEMENTATION_PLAN.md`: endpoint-complete UI implementation plan.

### Runtime entry and bootstrap

- `public/index.php`: process bootstrap, env load, typed config, container build, startup safety checks, fatal envelope fallback.
- `src/Bootstrap/AppFactory.php`: Slim app creation.
- `src/Bootstrap/ContainerFactory.php`: DI definitions for core/security/http/app services.
- `src/Bootstrap/BootChecks.php`: startup assertions and readiness evidence.

### Configuration model

- `src/Config/RuntimeConfig.php`: typed config aggregate from env.
- `src/Config/EnvValidator.php`: required field and safety validation.
- `src/Config/JwtPolicy.php`: issuer/audience/TTL policy object.
- `src/Config/CorsPolicy.php`: origin/credential policy object.
- `src/Config/RateLimitPolicy.php`: global limiter policy object.

### Core utilities

- `src/Core/Request/RequestId.php`: request-id generation/validation.
- `src/Core/Http/EnvelopeResponder.php`: uniform API envelope responses.

### Application services

- `src/Application/Auth/AuthService.php`: owner auth registration/login/refresh and token-family persistence.
- `src/Application/Auth/KeyLifecycleService.php`: key issuance/login/refresh/transition, invite flows, delegation envelopes.
- `src/Application/Posts/PostsService.php`: post list/create/find/revise/flag flows.
- `src/Application/Posts/CommentsService.php`: comment list/create flows.
- `src/Application/Posts/ModerationService.php`: moderation actions for posts/comments.
- `src/Application/Feed/FeedService.php`: feed listing and cursor pagination.
- `src/Application/Health/HealthService.php`: subsystem health probes.

### Routing + middleware

- `src/Http/Routes/RouteRegistrar.php`: UI + console + gateway route registration.
- `src/Http/Middleware/*`: layered middleware for request-id, routing marks, security headers, CORS, CSRF, rate limits, JSON parsing, validation, auth guards, and key/device restrictions.

### Security primitives

- `src/Security/TokenSigner.php`, `TokenVerifier.php`: core interfaces.
- `src/Security/JwtTokenSigner.php`, `JwtTokenVerifier.php`: claim/signature/policy enforcement.
- `src/Security/KeyMaterial.php`: PEM source resolution and permission checks.
- `src/Security/ApiKeyHasher.php`: API key hashing and verification.
- `src/Security/JwksService.php`: public-key JWKS representation.
- `src/Security/VerifiedPrincipal.php`, `TokenVerificationResult.php`, `TokenValidationException.php`: security data/exception types.

### Observability

- `src/Observability/AuditEmitter.php`: audit contract.
- `src/Observability/MonologAuditEmitter.php`: structured audit logging with normalization/redaction.

### Frontend SPA

- `public/ui/index.html`: shell.
- `public/ui/styles.css`: styling system.
- `public/ui/state.js`: session/device local state.
- `public/ui/api-client.js`: request/error normalization helper.
- `public/ui/app.js`: router, views, auth/session guards, forms, API integrations.

### Specifications and scripts

- `ui/endpoints_unified.json`: unified endpoint/spec artifact.
- `scripts/health_smoke.php`: health smoke check.
- `scripts/migrate_smoke.php`: migration smoke check via in-memory SQLite normalization.

### Tests

- `tests/Contract/*`: middleware, config, route, bootstrap, responder, and integration contracts.
- `tests/Security/*`: JWT, key-material, and hasher behavior security assertions.

### Existing dev docs

- `docs/dev/IMPLEMENTATION_STATUS.md`
- `docs/dev/QA_MATRIX.md`
- `docs/dev/SESSION_LEDGER.md`
- `docs/dev/DECISIONS.md`

## 3) Cross-cutting design characteristics

- **Policy-centric runtime:** typed policies for JWT/CORS/rate limiting wired through DI.
- **Envelope-first API style:** uniform success/list/error payload shape.
- **Defense in depth:** auth/validation/rate/CORS/CSRF middleware boundaries.
- **Contract-first maintenance:** dense PHPUnit suites lock runtime behavior.
- **No-build UI delivery:** static asset SPA for fast iteration and low infra complexity.

## 4) Suggested next deep-dive documents

Follow the rest of this `/docs` set in reading order (see `docs/README.md`) to expand each layer into implementation-level detail.
