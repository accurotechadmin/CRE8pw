# API Contract Guide (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Canonical machine contract
- OpenAPI source: `openapi/cre8.v1.yaml`
- Envelope schemas: `schemas/success-envelope.schema.json`, `schemas/error-envelope.schema.json`
- PSR-7 runtime primitives: `slim/psr7` (see `Dependency_Reference.md`)

## Envelope contract
- Success: `{ data, meta }`
- Error: `{ error: { code, message, details, request_id }, meta }`
- `X-Envelope-Version` emitted on responder-managed responses.

## Route groups
- Public/bootstrap: `/`, `/health`, `/.well-known/jwks.json`, `/ui*`, owner/signup/auth routes
- Gateway: `/api/*`
- Console: `/console/api/*`

## Endpoint examples
See `Endpoint_Examples_All_Routes.md` for concrete request/response payload samples for every route.

## Synchronization rule
Any change to route paths, request schema, response schema, or error semantics must update OpenAPI and this guide in the same PR.

## Backward compatibility
- Breaking changes require a new major `openapi` version file.
- Additive fields are non-breaking if envelope and required claims remain stable.
