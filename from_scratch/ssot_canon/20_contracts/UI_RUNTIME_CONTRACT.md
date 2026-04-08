# UI Runtime Contract

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define no-build UI runtime behavior and parity expectations with API contracts.

## Scope
`/ui` route fallback, static asset serving, and error-state diagnostics in browser workflows.

## Normative statements
- `/ui[/{route:.*}]` MUST return UI shell for client-side routes.
- Missing UI static assets MUST return 404 without API-only side effects.
- UI diagnostics SHOULD expose request ID for API failures.

## Interfaces / contracts
- Runtime implementation: `RouteRegistrar::renderUiRoute`.
- Security header behavior ties to UI path-aware policy in middleware.

## Failure/rejection semantics
- UI path traversal or unsafe asset resolution MUST be rejected (404).
- Missing index shell MUST fail with explicit 404 response.

## Verification requirements
- Contract tests for UI route and static asset behavior.
- Manual browser parity smoke in release process.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`, `src/Http/Middleware/SecurityHeadersMiddleware.php`
- Tests refs: `tests/Contract/RouteRegistrarContractsTest.php`
- Related SSOT docs: `API_CONTRACT_GUIDE.md`, `../30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md`

## Open questions / known gaps
- Front-end interaction acceptance matrix entries are still minimal.
