# SSOT ↔ Codebase Alignment Assessment (2026-04-06)

_Status: draft_
_Last updated (UTC): 2026-04-06_

## Scope
- Compared implementation under `src/`, `public/`, and executable project configuration to **only** `docs/SSOT/` documentation.
- Intentionally ignored non-SSOT docs per request.

## Executive alignment score
- **Overall alignment: 87% (High, with a few material drifts).**
- **Strongly aligned:** runtime config contract, boot fail-closed behavior, envelope/error structure, core route families, security headers, and health semantics.
- **Material drift:** keychain membership/resolve routes are documented in SSOT/OpenAPI but not implemented in `RouteRegistrar`.

## What is strongly aligned

### 1) API surface core (mostly)
- Implemented public/auth/gateway/console route families match SSOT intent and naming.
- Implemented routes include `/`, `/health`, `/.well-known/jwks.json`, `/ui*`, owner bootstrap, auth login/key-login/refresh, feed/posts/comments/moderation/key lifecycle.
- Response handling uses envelope responder patterns with versioned headers.

### 2) Boot/startup contract
- Startup flow loads env, constructs typed config, builds container, runs boot checks, then starts app.
- Boot checks enforce required dependency class presence, key material resolvability, profile safety checks, key-path safety checks, and middleware order consistency.
- Startup failures produce deterministic JSON with `error.code = boot_failed` and `X-Request-Id`.

### 3) Configuration/environment contract
- Required env vars and profile checks (`APP_ENV`, CORS wildcard policy, HTTPS issuer in stage/prod, DSN constraints, CSRF length, optional positive integer policy vars) are implemented.
- Key source validation supports inline PEM and path forms.
- Relative key paths are resolved during startup loading.

### 4) Security headers/CSP contract
- Baseline headers and path-aware CSP behavior (`/ui*` vs non-UI API/public paths) are implemented.
- Existing CSP/header values are not overwritten when already present.

### 5) Health endpoint contract
- `/health` returns structured health data including `status`, timestamps, latency, failure list, and subsystem breakdown (`db`, `rate_limiter`, `key_material`, `http_dependency`).

## Material drifts (highest priority)

### Drift A — Keychain member/resolve routes documented but not mounted
- SSOT/OpenAPI/Route Inventory include:
  - `GET|POST /console/api/keychains/{keychainId}/members`
  - `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}`
  - `GET /console/api/keychains/{keychainId}/resolve`
- `src/Http/Routes/RouteRegistrar.php` currently mounts `/console/api/keychains` list only, not member mutation/list/resolve endpoints.
- Impact: contract mismatch for clients relying on OpenAPI + SSOT route inventory.

### Drift B — Middleware order doc omits error handler stage
- SSOT request pipeline global order starts at `RequestId`.
- Runtime middleware contract (`MiddlewareOrder::GLOBAL`) includes `ErrorHandler` as the first declared stage.
- Impact: operational/diagnostic sequencing in docs is slightly inaccurate.

### Drift C — SSOT automation command contract not present in composer scripts
- SSOT Automation document requires:
  - `composer docs:ssot:lint`
  - `composer docs:ssot:sync-check`
  - `composer docs:ssot:report`
- `composer.json` scripts currently do not provide these commands.
- Impact: documented anti-drift CI gate is not wired in project scripts.

### Drift D — Traceability matrix names `KeychainService`, implementation uses `KeyLifecycleService`
- Traceability doc lists keychain capabilities under `KeychainService`.
- Current implementation routes and logic use `KeyLifecycleService` for keychain-related listing and key lifecycle concerns.
- Impact: low runtime risk, but architectural naming drift in SSOT mapping.

## Minor additive differences (non-breaking)
- Health service includes `services.http_client_class`, which is additive vs. SSOT health minimum fields.
- List envelopes include `paging` alongside `data/meta`, consistent with implementation pattern and non-breaking if OpenAPI/examples permit it.

## Recommendations
1. **Resolve Drift A first (high):** either implement keychain member/resolve routes or remove/deprecate them from SSOT/OpenAPI in one synchronized change.
2. **Update pipeline doc for ErrorHandler stage** to reflect true runtime stack ordering.
3. **Add SSOT automation scripts/checkers** (or relax SSOT requirement text if intentionally deferred).
4. **Normalize service naming in Traceability Matrix** (`KeyLifecycleService` vs `KeychainService`).
5. Add/enable a CI check to diff route inventory + OpenAPI + actual route registrar.

## Confidence and method
- Confidence: **high** for route/config/middleware/boot alignment; **medium-high** for broader architectural claims not fully executable in this environment.
- Method: static comparison of SSOT contracts against source implementation and runnable command checks available in this environment.
