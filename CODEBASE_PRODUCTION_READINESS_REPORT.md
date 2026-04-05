# Codebase Production-Readiness Audit (2026-04-05 UTC)

## Method used
- Enumerated all repository files (`rg --files`).
- Syntax-checked all PHP files (`php -l`).
- Syntax-checked frontend JS (`node --check`).
- Searched for unfinished markers and risky primitives (`rg` for TODO/FIXME/etc.).

## High-priority findings
- **Critical:** private key material is committed (`secrets/jwt/private.pem`).
- **High:** environment template includes live-looking DB credentials (`dot.env`).
- **High:** default owner auto-seed with static password in `AuthService` if account absent.
- **Medium:** some console endpoints are placeholders (`/keychains`, `/invites`).
- **Medium:** health check does not actively validate external HTTP dependencies.

## Per-file assessment
| File | Completion/readiness | Notes |
|---|---|---|
| `.htaccess` | Good | Bootstrap/routing infra present. |
| `BACKEND_UI_ENDPOINT_GAP_REPORT.md` | Planning | Gap report artifact; not runtime code. |
| `FRONTEND_BACKEND_INTEGRATION_PLAYBOOK.md` | Planning | Process/runbook doc. |
| `UI_IMPLEMENTATION_PLAN.md` | Planning | Planning artifact; not executable. |
| `composer.json` | Partial | test script depends on phpunit, but phpunit was unavailable in environment; cannot verify full automated tests here. |
| `docs/dev/DECISIONS.md` | Docs | Documentation artifact. |
| `docs/dev/IMPLEMENTATION_STATUS.md` | Docs | Documentation artifact. |
| `docs/dev/QA_MATRIX.md` | Docs | Documentation artifact. |
| `docs/dev/SESSION_LEDGER.md` | Docs | Documentation artifact. |
| `dot.env` | High risk | Contains real-looking DB credentials and absolute key paths; should not be committed. |
| `public/.htaccess` | Good | Bootstrap/routing infra present. |
| `public/index.php` | Good | Bootstrap/routing infra present. |
| `public/ui/api-client.js` | Good | Frontend logic present; no TODO/FIXME markers found. |
| `public/ui/app.js` | Good | Frontend logic present; no TODO/FIXME markers found. |
| `public/ui/index.html` | Good | Frontend asset appears complete for current scope. |
| `public/ui/state.js` | Good | Frontend logic present; no TODO/FIXME markers found. |
| `public/ui/styles.css` | Good | Frontend asset appears complete for current scope. |
| `scripts/health_smoke.php` | Good | Utility script with explicit non-zero exits for smoke-check failures. |
| `scripts/migrate_smoke.php` | Good | Utility script with explicit non-zero exits for smoke-check failures. |
| `secrets/jwt/private.pem` | Critical risk | Private RSA key committed to repo; must rotate/remove. |
| `secrets/jwt/public.pem` | Info | Public key committed; acceptable only if intentionally public and paired private key removed. |
| `src/Application/Auth/AuthService.php` | Partial | Auto-seeds default owner owner@cre8.local with static password owner-pass; unsafe outside local/dev. |
| `src/Application/Auth/KeyLifecycleService.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Application/Feed/FeedService.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Application/Health/HealthService.php` | Partial | Reports http_client class name only; no outbound probe despite dependency injection. |
| `src/Application/Posts/CommentsService.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Application/Posts/ModerationService.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Application/Posts/PostsService.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Bootstrap/AppFactory.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Bootstrap/BootChecks.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Bootstrap/ContainerFactory.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Config/CorsPolicy.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Config/EnvValidator.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Config/JwtPolicy.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Config/RateLimitPolicy.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Config/RuntimeConfig.php` | Partial | `CorsPolicy.allowWildcard` is set using `!in_array('*', origins)` in constructor, which appears logically inverted from field name intent. |
| `src/Core/Http/EnvelopeResponder.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Core/Request/RequestId.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/CorsMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/CsrfMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/DeviceLimitMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/ErrorHandlerMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/JsonBodyMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/KeyJwtMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/MiddlewareOrder.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/MiddlewareRegistry.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/OwnerJwtMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/RateLimitMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/RequestIdMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/RoutingMarkerMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/SecurityHeadersMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/UseKeyLimitMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Middleware/ValidationMiddleware.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Http/Routes/RouteRegistrar.php` | Partial | /console/api/keychains returns empty list and /console/api/invites is ephemeral random response; appears stubbed. |
| `src/Observability/AuditEmitter.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Observability/MonologAuditEmitter.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/ApiKeyHasher.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/JwksService.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/JwtTokenSigner.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/JwtTokenVerifier.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/KeyMaterial.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/TokenSigner.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/TokenValidationException.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/TokenVerificationResult.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/TokenVerifier.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `src/Security/VerifiedPrincipal.php` | Good | No obvious unfinished markers; compiles via php -l. |
| `tests/Contract/BootChecksContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/ComposerScriptsContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/ContainerFactoryContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/EnvelopeResponderContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/HealthServiceContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/MiddlewareProductionDepthContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/MiddlewareRegistryContractsTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/MonologAuditEmitterContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/PublicIndexBootstrapContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/RouteRegistrarContractsTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Contract/RuntimeConfigPoliciesContractTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Security/ApiKeyHasherSecurityTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Security/JwtTokenSecurityTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `tests/Security/KeyMaterialSecurityTest.php` | Good (tests) | Test coverage artifact; not production runtime. |
| `ui/endpoints_unified.json` | Good | API contract/reference data file. |
