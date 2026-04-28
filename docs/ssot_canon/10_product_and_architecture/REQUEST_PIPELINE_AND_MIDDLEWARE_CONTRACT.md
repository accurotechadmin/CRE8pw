# Request Pipeline and Middleware Contract

_Status: adopted_
_Last updated (UTC): 2026-04-28_

## Authoritative middleware order
1. Request ID/correlation injection
2. Security headers / CSP policy
3. CORS / content-type normalization
4. Surface-specific authentication guard
5. Route-action resolution + policy-context builders (owner or key by surface)
6. PDP policy decision guard (`PdpService` + `RuleRegistry`; deny short-circuit + obligation handoff)
7. Validation guards
8. Rate limiting / abuse controls
9. Route handler execution
10. Envelope responder + error mapper

## Contract rules
- Middleware order is normative; reordering requires security + QA review.
- Unauthorized/forbidden/validation failures must return canonical error envelopes.
- Gateway routes requiring device policy must enforce `X-Device-Id` validation before handler execution.
- PDP deny outcomes are authoritative and route handlers execute only after explicit policy allow.
- PDP decision events carry `request_id`, `surface`, and `route_action` for audit and regression comparison.
- Gateway read, gateway write, and console governance protected route families execute `PolicyDecisionMiddleware` with canonical context builders before handlers; deny outcomes short-circuit the pipeline with canonical envelopes.

## Failure mapping baseline
- Missing/invalid auth -> `401`
- Policy denial -> `403`
- Validation failure -> `422`
- Unhandled internal error -> `500`


## 404 resource-resolution policy
- The request pipeline and middleware stack MUST emit resource-specific `details.code` values for entity misses.
- `route_not_found` is reserved strictly for unmatched route templates at the router boundary.
- For matched routes where a target resource is absent, handlers/services MUST emit specific detail codes aligned to `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md` (including `post_not_found`, `comment_not_found`, `key_not_found`, and `keychain_not_found`).
- UI runtime contracts depend on resource-specific 404 detail codes to drive deterministic `not_found` substates and recovery actions.


## Policy bootstrap and registry integrity contract
- Boot sequence validates `config/policy/route_actions.php`, `config/policy/permissions.php`, and `config/policy/detail_codes.php` before protected routes are activated.
- Startup fails closed when policy maps are missing, malformed, duplicated, or inconsistent with canonical permission/detail-code vocabularies.
- `PolicyDecisionMiddleware` consumes immutable in-memory policy tables produced at boot and does not read mutable policy state from handlers.
- Runtime policy decisions use the boot-validated `RuleRegistry` composition snapshot; composition drift is a release-blocking defect.
