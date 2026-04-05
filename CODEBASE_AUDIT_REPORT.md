# CRE8 Codebase Audit Report

Generated: 2026-04-05 (UTC).

## What CRE8 is (high-level)
- CRE8 is a Slim 4 + PHP 8.2 backend platform exposing auth, key lifecycle, feed, posts, comments, moderation, health, and JWKS APIs.
- Architecture is layered: Bootstrap/Config -> Middleware/Routes -> Application services -> Security/Observability utilities.
- The new `ui/` specs define frontend page contracts mapped to backend endpoints for design/implementation parity.

## Complete file inventory (72 files)

| File | Summary |
|---|---|
| `.htaccess` | Repository-level Apache rewrite/security directives for deployment hardening. |
| `CODEBASE_INVENTORY.md` | Prior generated full-content dump of repository files (very large historical inventory artifact). |
| `composer.json` | Composer manifest with runtime/dev dependencies, autoloading, and QA/test scripts. |
| `dot.env` | Example environment configuration template for local/stage/prod-safe runtime values. |
| `public/.htaccess` | Public webroot rewrite rules to route all requests through front controller. |
| `public/index.php` | HTTP entrypoint: loads env, builds DI container, runs boot checks, starts Slim app, and emits structured startup errors. |
| `scripts/health_smoke.php` | Operational smoke script for quick runtime validation (health smoke). |
| `scripts/migrate_smoke.php` | Operational smoke script for quick runtime validation (migrate smoke). |
| `secrets/jwt/private.pem` | Sample/dev JWT private key PEM used by local signing flows. |
| `secrets/jwt/public.pem` | Sample/dev JWT public key PEM used by local verification/JWKS flows. |
| `src/Application/Auth/AuthService.php` | Owner authentication domain service: registration, password login, refresh token rotation, and audit hooks. |
| `src/Application/Auth/KeyLifecycleService.php` | API key lifecycle domain service: issuance, login, refresh, transition/revoke, and policy checks. |
| `src/Application/Feed/FeedService.php` | Feed read service with scope-aware listing, cursor pagination, and visibility filtering. |
| `src/Application/Health/HealthService.php` | Health probe service returning subsystem checks and readiness payload. |
| `src/Application/Posts/CommentsService.php` | Comment read/create service for post comment threads with moderation-aware state behavior. |
| `src/Application/Posts/ModerationService.php` | Moderation service for post/comment actions (hide/lock/archive/delete) plus audit details. |
| `src/Application/Posts/PostsService.php` | Post service for create/read/list/revise/flag operations and visibility/state rules. |
| `src/Bootstrap/AppFactory.php` | Creates Slim application instance, registers middleware stack and routes. |
| `src/Bootstrap/BootChecks.php` | Startup safety checks for env/profile/key permissions/CORS policy with structured boot evidence. |
| `src/Bootstrap/ContainerFactory.php` | Dependency injection container wiring for config, middleware, services, security, DB, and observability. |
| `src/Config/CorsPolicy.php` | Runtime policy/config value object or validator used to normalize/validate environment inputs. |
| `src/Config/EnvValidator.php` | Runtime policy/config value object or validator used to normalize/validate environment inputs. |
| `src/Config/JwtPolicy.php` | Runtime policy/config value object or validator used to normalize/validate environment inputs. |
| `src/Config/RateLimitPolicy.php` | Runtime policy/config value object or validator used to normalize/validate environment inputs. |
| `src/Config/RuntimeConfig.php` | Runtime policy/config value object or validator used to normalize/validate environment inputs. |
| `src/Core/Http/EnvelopeResponder.php` | Standard JSON response envelope builder for success/list/error payloads and metadata headers. |
| `src/Core/Request/RequestId.php` | Request ID generator/validator utility (UUIDv4). |
| `src/Http/Middleware/CorsMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/CsrfMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/DeviceLimitMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/ErrorHandlerMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/JsonBodyMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/KeyJwtMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/MiddlewareOrder.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/MiddlewareRegistry.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/OwnerJwtMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/RateLimitMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/RequestIdMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/RoutingMarkerMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/SecurityHeadersMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/UseKeyLimitMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Middleware/ValidationMiddleware.php` | HTTP middleware component enforcing one cross-cutting concern in pipeline. |
| `src/Http/Routes/RouteRegistrar.php` | Central route map: auth, console, gateway, feed, post/comment, moderation, health, and JWKS endpoints. |
| `src/Observability/AuditEmitter.php` | Audit emitter interface contract for structured security/audit events. |
| `src/Observability/MonologAuditEmitter.php` | Monolog-backed audit emitter implementation with event classification helpers. |
| `src/Security/ApiKeyHasher.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/JwksService.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/JwtTokenSigner.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/JwtTokenVerifier.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/KeyMaterial.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/TokenSigner.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/TokenValidationException.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/TokenVerificationResult.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/TokenVerifier.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `src/Security/VerifiedPrincipal.php` | Security primitive for hashing, JWT sign/verify, JWKS exposure, key material checks, or auth principal typing. |
| `tests/Contract/BootChecksContractTest.php` | Contract test asserting API/runtime invariants for BootChecks behavior. |
| `tests/Contract/ComposerScriptsContractTest.php` | Contract test asserting API/runtime invariants for ComposerScripts behavior. |
| `tests/Contract/ContainerFactoryContractTest.php` | Contract test asserting API/runtime invariants for ContainerFactory behavior. |
| `tests/Contract/EnvelopeResponderContractTest.php` | Contract test asserting API/runtime invariants for EnvelopeResponder behavior. |
| `tests/Contract/HealthServiceContractTest.php` | Contract test asserting API/runtime invariants for HealthService behavior. |
| `tests/Contract/MiddlewareProductionDepthContractTest.php` | Contract test asserting API/runtime invariants for MiddlewareProductionDepth behavior. |
| `tests/Contract/MiddlewareRegistryContractsTest.php` | Contract test asserting API/runtime invariants for MiddlewareRegistryContractsTest.php behavior. |
| `tests/Contract/MonologAuditEmitterContractTest.php` | Contract test asserting API/runtime invariants for MonologAuditEmitter behavior. |
| `tests/Contract/PublicIndexBootstrapContractTest.php` | Contract test asserting API/runtime invariants for PublicIndexBootstrap behavior. |
| `tests/Contract/RouteRegistrarContractsTest.php` | Contract test asserting API/runtime invariants for RouteRegistrarContractsTest.php behavior. |
| `tests/Contract/RuntimeConfigPoliciesContractTest.php` | Contract test asserting API/runtime invariants for RuntimeConfigPolicies behavior. |
| `tests/Security/ApiKeyHasherSecurityTest.php` | Security-focused test covering ApiKeyHasher invariants and edge cases. |
| `tests/Security/JwtTokenSecurityTest.php` | Security-focused test covering JwtToken invariants and edge cases. |
| `tests/Security/KeyMaterialSecurityTest.php` | Security-focused test covering KeyMaterial invariants and edge cases. |
| `ui/endpoints.json` | Primary UI/API planning spec grouped by sprint, page requirements, UX states, and API contracts. |
| `ui/endpoints_flat.json` | Flattened page-spec list for easier consumption by tooling/design systems. |
| `ui/endpoints_schema.json` | JSON Schema that validates each page spec entry and API-call object structure. |
