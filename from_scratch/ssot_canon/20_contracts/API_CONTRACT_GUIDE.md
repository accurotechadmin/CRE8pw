# API Contract Guide

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define API envelope behavior, route family expectations, and machine-contract precedence.

## Scope
All public/auth/gateway/console HTTP APIs and response envelopes.

## Normative statements
- OpenAPI and JSON schemas MUST be updated with any route or envelope change.
- Success envelope MUST use `data` and `meta`; error envelope MUST use `error` and `meta`.
- Request correlation (`request_id`) MUST be present on failures.

## Interfaces / contracts
- Machine contract: `../openapi/cre8.v1.yaml`.
- Schemas: `../schemas/success-envelope.schema.json`, `../schemas/error-envelope.schema.json`.
- Route-level behavior reference: `ROUTE_INVENTORY_REFERENCE.md`.

## Failure/rejection semantics
- Undocumented endpoint or field is a contract failure.
- Invalid envelope shape SHOULD fail contract tests.

## Verification requirements
- Run contract tests and schema validation in CI.
- Cross-check against route registrar and acceptance matrix.

## Traceability hooks
- Code refs: `src/Core/Http/EnvelopeResponder.php`, `src/Http/Routes/RouteRegistrar.php`
- Tests refs: `tests/Contract/EnvelopeResponderContractTest.php`, `tests/Contract/RouteRegistrarContractsTest.php`
- Related SSOT docs: `ROUTE_INVENTORY_REFERENCE.md`, `ERROR_CODE_CATALOG.md`, `../40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

## Open questions / known gaps
- OpenAPI contains only starter subset in this scaffold and needs full endpoint expansion.
