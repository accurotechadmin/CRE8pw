# Health Endpoint Contract

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define `/health` response semantics and subsystem expectations.

## Scope
Runtime liveness/readiness style checks for DB, limiter, key material, and HTTP dependency.

## Normative statements
- `/health` MUST return structured status and subsystem details.
- Health output SHOULD include timestamps and latency fields.
- Subsystem failures MUST not suppress correlation metadata.

## Interfaces / contracts
- Route: `GET /health`.
- Service anchor: `HealthService::check()` with subsystems (`db`, `rate_limiter`, `key_material`, `http_dependency`).

## Failure/rejection semantics
- Missing subsystem status entry SHOULD be treated as degraded health reporting.
- Hard failure of required dependency MUST produce non-pass status.

## Verification requirements
- Contract test for shape and subsystem keys.
- `composer ops:health-smoke` evidence in release checklist.

## Traceability hooks
- Code refs: `src/Application/Health/HealthService.php`, `src/Http/Routes/RouteRegistrar.php`
- Tests refs: `tests/Contract/HealthServiceContractTest.php`
- Related SSOT docs: `OPERATIONAL_SMOKE_CHECK_CONTRACT.md`, `PRODUCTION_READINESS_GATES.md`

## Open questions / known gaps
- Exact degraded/fail status semantics need tighter codification in OpenAPI response examples.
