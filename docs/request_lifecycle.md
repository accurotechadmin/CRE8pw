# Request Lifecycle

_Last updated (UTC): 2026-04-05_

## End-to-end flow

1. `RequestIdMiddleware` accepts valid incoming UUIDv4 request IDs or generates one.
2. `SecurityHeadersMiddleware` appends CSP/security headers (UI-specific CSP for `/ui*`, strict API CSP otherwise).
3. `CorsMiddleware` handles preflight and CORS header injection.
4. `RateLimitMiddleware` enforces global limiter keyed by remote IP.
5. `ValidationMiddleware` validates known route payload schemas.
6. `JsonBodyMiddleware` enforces JSON content-type/parsing for mutating methods.
7. `RoutingMarkerMiddleware` attaches `route_surface` and `route_family` attributes.
8. `CsrfMiddleware` enforces `X-CSRF-Token` for non-API console write routes.
9. Surface middleware (console or gateway) performs JWT checks and gateway-specific controls.
10. Route handler invokes domain services and returns envelope responses via `EnvelopeResponder`.

## Global middleware order contract

Defined by `MiddlewareOrder::GLOBAL` and validated during boot (`BootChecks`).

## Common rejection outcomes

- `401 auth_required/auth_invalid`: missing/invalid bearer or token mismatch.
- `403 forbidden`: CSRF failure, permission failure, use-key mutation block, or comment/post policy blocks.
- `422 validation_failed`: schema violations and required fields.
- `429 rate_limited`: global limiter exceeded.
- `400 bad_request`: malformed JSON or non-object JSON root.

All error responses include normalized `error` + `meta` envelope fields and `X-Request-Id`.
