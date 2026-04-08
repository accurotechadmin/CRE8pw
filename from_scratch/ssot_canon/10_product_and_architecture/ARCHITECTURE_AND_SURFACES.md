# Architecture and Surfaces

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Describe system layering and trust boundaries as implemented by Slim middleware and route groups.

## Scope
Public, auth, gateway, and console surfaces plus cross-cutting services.

## Normative statements
- Route families MUST map to explicit surfaces with dedicated middleware stacks.
- Security controls MUST be fail-closed at boundary transitions.
- Architecture SHOULD remain modular monolith with clear service boundaries.

## Interfaces / contracts
- Surfaces: public (`/`, `/health`, `/ui*`, `/.well-known/jwks.json`), auth (`/api/auth/*`, `/console/owners`), gateway (`/api/*`), console (`/console/api/*`).
- Key anchors: `RouteRegistrar`, `MiddlewareRegistry`, `BootChecks`.

## Failure/rejection semantics
- Unassigned surface routes are invalid and MUST be rejected in review.
- Cross-surface auth leakage (e.g., console token accepted on gateway) is a security failure.

## Verification requirements
- Contract tests validate route families and middleware application.
- Security tests validate token surface rules.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`, `src/Http/Middleware/MiddlewareRegistry.php`
- Tests refs: `tests/Contract/RouteRegistrarContractsTest.php`, `tests/Security/JwtTokenSecurityTest.php`
- Related SSOT docs: `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`, `../20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`

## Open questions / known gaps
- Keychain member/resolve surface remains documented in legacy SSOT but not yet implemented in current registrar.

## Session progress (2026-04-08)
### Completed in this session
- Stabilized architecture/product skeleton and canonical terminology linkage.
- Kept normative constraints explicit to minimize interpretation drift.
- Aligned scope to current runtime surfaces and middleware-driven architecture.
### Remaining to finish this document
- [ ] Add authoritative capability boundaries and out-of-scope definitions.
- [ ] Add concrete diagrams/tables for surfaces, trust boundaries, and request flow.
- [ ] Trace every normative statement to code modules and tests.

