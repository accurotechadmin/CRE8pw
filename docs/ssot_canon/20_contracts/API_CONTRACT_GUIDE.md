# API Contract Guide (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Canonical machine contract
- OpenAPI source: `docs/ssot_canon/openapi/cre8.v1.yaml`
- Envelope schemas: `docs/ssot_canon/schemas/success-envelope.schema.json`, `docs/ssot_canon/schemas/error-envelope.schema.json`
- PSR-7 runtime primitives: `slim/psr7` (see `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`)

## Envelope contract
- Success: `{ data, meta }`
- Error: `{ error: { code, message, details, request_id }, meta }`
- `X-Envelope-Version` emitted on responder-managed responses.

## Route groups
- Public/bootstrap: `/`, `/health`, `/.well-known/jwks.json`, `/ui/{route}`, owner/signup/auth routes
- Gateway: `/api/*`
- Console: `/console/api/*`
- Canonical human route index: `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`

Gateway protected routes require `X-Device-Id` parity with JWT `device_id` claim.

## Endpoint examples
See `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md` for concrete request/response payload samples for every route.
For deep health semantics use `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md`.

## Acceptance criteria linkage
Use `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` for route-level Given/When/Then intent, including negative and edge behavior requirements.

## Synchronization rule
Any change to route paths, request schema, response schema, or error semantics must update OpenAPI and this guide in the same PR.

## Backward compatibility
- Breaking changes require a new major `openapi` version file.
- Additive fields are non-breaking if envelope and required claims remain stable.
