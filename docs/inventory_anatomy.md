# Inventory & Anatomy of the CRE8.pw Codebase

_Last updated (UTC): 2026-04-05_

## 1. Runtime and entrypoint inventory

- `public/index.php`: process bootstrap, env loading/normalization, startup success/failure logging, startup-failure envelope fallback.
- `composer.json`: dependency graph, autoload config, QA/test/smoke composer scripts.
- `secrets/jwt/private.pem`, `secrets/jwt/public.pem`: development key material.

## 2. Backend source inventory (`src/`)

### Bootstrap
- `src/Bootstrap/AppFactory.php`: builds Slim app, adds global middleware, registers routes.
- `src/Bootstrap/BootChecks.php`: startup dependency/config/safety assertions and optional evidence emission.
- `src/Bootstrap/ContainerFactory.php`: DI bindings for core/security/http/application services.

### Configuration
- `src/Config/RuntimeConfig.php`: typed runtime config from env with policy objects.
- `src/Config/EnvValidator.php`: required env and profile safety validation.
- `src/Config/RateLimitPolicy.php`, `JwtPolicy.php`, `CorsPolicy.php`: typed policy DTOs.

### Core
- `src/Core/Http/EnvelopeResponder.php`: canonical JSON envelope responses.
- `src/Core/Request/RequestId.php`: UUIDv4 validation/generation helpers.

### Application services
- `src/Application/Auth/AuthService.php`: owner registration/login/refresh, owner seed, token-family storage.
- `src/Application/Auth/KeyLifecycleService.php`: key issuance/login/refresh, delegation policy, key lifecycle transitions, invites, keychain listing.
- `src/Application/Feed/FeedService.php`: cursor-based feed slice over post visibility query.
- `src/Application/Posts/PostsService.php`: posts CRUD-like operations, revisions, flags, SQLite schema bootstrap.
- `src/Application/Posts/CommentsService.php`: comment list/create + audit emission.
- `src/Application/Posts/ModerationService.php`: post/comment moderation state transitions + moderation action rows.
- `src/Application/Health/HealthService.php`: DB/rate-limiter/key-material/http dependency probes.

### HTTP routes
- `src/Http/Routes/RouteRegistrar.php`: all public/auth/gateway/console route wiring, UI file-serving logic, inline validation branches.

### Middleware
- `src/Http/Middleware/MiddlewareOrder.php`: global and per-surface middleware catalogs.
- `src/Http/Middleware/MiddlewareRegistry.php`: resolves middleware instances from DI container.
- `src/Http/Middleware/ErrorHandlerMiddleware.php`: exception-to-envelope mapping.
- `src/Http/Middleware/RequestIdMiddleware.php`: request ID normalization and response header injection.
- `src/Http/Middleware/SecurityHeadersMiddleware.php`: security headers and CSP policy.
- `src/Http/Middleware/CorsMiddleware.php`: CORS preflight/policy enforcement.
- `src/Http/Middleware/RateLimitMiddleware.php`: IP-based global rate limiting.
- `src/Http/Middleware/ValidationMiddleware.php`: route-keyed payload schema validation.
- `src/Http/Middleware/JsonBodyMiddleware.php`: mutating-route JSON parsing and content-type enforcement.
- `src/Http/Middleware/RoutingMarkerMiddleware.php`: surface/family attribute tagging.
- `src/Http/Middleware/CsrfMiddleware.php`: non-API console CSRF enforcement.
- `src/Http/Middleware/OwnerJwtMiddleware.php`: owner bearer verification and claim checks.
- `src/Http/Middleware/KeyJwtMiddleware.php`: key bearer verification and claim checks.
- `src/Http/Middleware/DeviceLimitMiddleware.php`: gateway device-id format requirement.
- `src/Http/Middleware/UseKeyLimitMiddleware.php`: `use` key mutation restrictions.

### Security
- `src/Security/TokenSigner.php`, `TokenVerifier.php`: signing/verification interfaces.
- `src/Security/JwtTokenSigner.php`: JWT signing + claim policy + kid generation.
- `src/Security/JwtTokenVerifier.php`: JWT verification + claim policy enforcement.
- `src/Security/TokenVerificationResult.php`, `VerifiedPrincipal.php`, `TokenValidationException.php`: verification result/value objects.
- `src/Security/KeyMaterial.php`: PEM/path key resolution and permission checks.
- `src/Security/ApiKeyHasher.php`: argon2id hashing and malformed-hash timing-safe fallback verify path.
- `src/Security/JwksService.php`: RSA JWKS document generation.

### Observability
- `src/Observability/AuditEmitter.php`: audit interface and schema/redaction constants.
- `src/Observability/MonologAuditEmitter.php`: logger routing, redaction, required field normalization, failure fallback.

## 3. Frontend inventory (`public/ui/`)

- `index.html`: app shell with nav/flash/view/inspector and skip-link accessibility hook.
- `styles.css`: component styling, focus-visible rules, state chips, forms/tables.
- `state.js`: session and device-id persistence.
- `api-client.js`: shared HTTP client and envelope/error normalization.
- `app.js`: route matching, view rendering, auth/session guard logic, endpoint form flows, confirmations, response inspector integration.

## 4. Ops and contract artifacts

- `scripts/health_smoke.php`: runtime health endpoint smoke check.
- `scripts/migrate_smoke.php`: SQLite schema sanity smoke for principal/content/delegation/invite tables.
- `tests/Contract/*`: API/runtime/middleware/boot/route/container contract lock suite.
- `tests/Security/*`: signer/verifier/hash/key-material security suite.
- `ui/endpoints_unified.json`: UI contract and endpoint/state model source data.
- `UI_IMPLEMENTATION_PLAN.md`: endpoint-coverage and phase implementation planning history.

## 5. Documentation inventory

- `docs/*.md`: canonical product, architecture, policy, and operations references.
- `docs/dev/*.md`: session-ledger execution history, decision logs, QA matrix, implementation status.
