# Request Pipeline and Middleware Contract

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Freeze middleware sequencing and per-surface stacks, including global error and request-id handling.

## Scope
Global stack and console/gateway overlays in active runtime.

## Normative statements
- Global middleware order MUST match `MiddlewareOrder::GLOBAL`.
- `ErrorHandlerMiddleware` MUST remain first declared global stage.
- Surface-specific middleware MUST enforce token type and policy restrictions.

## Interfaces / contracts
- Global sequence (current): `ErrorHandler`, `RequestId`, `SecurityHeaders`, `Cors`, `RoutingMarker`, `JsonBody`.
- Console overlay includes owner JWT + CSRF + validation/rate limits.
- Gateway overlay includes key JWT + device/use-key/rate controls.

## Failure/rejection semantics
- Order mismatch at boot MUST fail startup checks.
- Missing required middleware on protected routes MUST be treated as release blocker.

## Verification requirements
- Validate against `src/Http/Middleware/MiddlewareOrder.php` and boot check assertions.
- Contract tests: middleware registry and production depth tests.

## Traceability hooks
- Code refs: `src/Http/Middleware/MiddlewareOrder.php`, `src/Bootstrap/BootChecks.php`
- Tests refs: `tests/Contract/MiddlewareRegistryContractsTest.php`, `tests/Contract/MiddlewareProductionDepthContractTest.php`
- Related SSOT docs: `ARCHITECTURE_AND_SURFACES.md`, `../20_contracts/ERROR_CODE_CATALOG.md`

## Open questions / known gaps
- Legacy request pipeline docs omitted ErrorHandler stage; canon now aligns with runtime.

## Session progress (2026-04-08)
### Completed in this session
- Stabilized architecture/product skeleton and canonical terminology linkage.
- Kept normative constraints explicit to minimize interpretation drift.
- Aligned scope to current runtime surfaces and middleware-driven architecture.
### Remaining to finish this document
- [ ] Add authoritative capability boundaries and out-of-scope definitions.
- [ ] Add concrete diagrams/tables for surfaces, trust boundaries, and request flow.
- [ ] Trace every normative statement to code modules and tests.

