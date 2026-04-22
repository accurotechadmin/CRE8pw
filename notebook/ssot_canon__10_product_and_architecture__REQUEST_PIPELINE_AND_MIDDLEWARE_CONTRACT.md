# Request Pipeline and Middleware Contract

_Status: adopted_
_Last updated (UTC): 2026-04-21_

## Authoritative middleware order
1. Request ID/correlation injection
2. Security headers / CSP policy
3. CORS / content-type normalization
4. Surface-specific authn/authz guards
5. Validation guards
6. Rate limiting / abuse controls
7. Route handler execution
8. Envelope responder + error mapper

## Contract rules
- Middleware order is normative; reordering requires security + QA review.
- Unauthorized/forbidden/validation failures must return canonical error envelopes.
- Gateway routes requiring device policy must enforce `X-Device-Id` validation before handler execution.

## Failure mapping baseline
- Missing/invalid auth -> `401`
- Policy denial -> `403`
- Validation failure -> `422`
- Unhandled internal error -> `500`


## 404 resource-resolution policy
- The request pipeline and middleware stack MUST emit resource-specific `details.code` values for entity misses.
- `route_not_found` is reserved strictly for unmatched route templates at the router boundary.
- For matched routes where a target resource is absent, handlers/services MUST emit specific detail codes aligned to `ERROR_CODE_CATALOG.md` (for example: `post_not_found`, `comment_not_found`, `key_not_found`, `keychain_not_found`).
- UI runtime contracts depend on resource-specific 404 detail codes to drive deterministic `not_found` substates and recovery actions.
