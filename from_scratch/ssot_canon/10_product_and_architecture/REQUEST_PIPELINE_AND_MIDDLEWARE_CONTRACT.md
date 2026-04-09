# Request Pipeline and Middleware Contract

_Status: adopted_
_Last updated (UTC): 2026-04-08_

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
