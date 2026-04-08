# Error Code Catalog

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define stable error codes/detail reasons and HTTP status mappings.

## Scope
Envelope error codes emitted across auth, validation, authorization, and operations.

## Normative statements
- Every emitted `error.code` MUST be listed in this catalog.
- Detail reason fields SHOULD be bounded to documented enumerations.
- Error message text MAY evolve; code semantics MUST stay stable.

## Interfaces / contracts
| Code | HTTP | Typical detail reason(s) |
|---|---|---|
| `validation_failed` | 422 | `required`, `unknown_value` |
| `auth_invalid` | 401 | `api_key_invalid`, `refresh_replay` |
| `forbidden` | 403 | `permission_missing`, `scope_denied` |
| `not_found` | 404 | `resource_missing` |
| `owner_conflict` | 409 | `email_exists` |
| `boot_failed` | 500 | startup dependency failure |

## Failure/rejection semantics
- Unregistered error codes in code/tests MUST fail sync checks.
- Incorrect status-code mapping SHOULD fail contract tests.

## Verification requirements
- Scan route/service tests for emitted codes and compare with catalog.
- Validate boot failure response contract.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`, `public/index.php`
- Tests refs: `tests/Contract/PublicIndexBootstrapContractTest.php`, `tests/Contract/AuthServiceLoginContractTest.php`
- Related SSOT docs: `API_CONTRACT_GUIDE.md`, `../40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

## Open questions / known gaps
- Need machine-readable error registry artifact for stronger CI enforcement.

## Session progress (2026-04-08)
### Completed in this session
- Preserved contract-first structure for API, route inventory, error catalog, and authorization behavior.
- Confirmed machine-contract references (OpenAPI/schemas) are linked in contract docs.
- Standardized verification and traceability sections for contract-test alignment.
### Remaining to finish this document
- [ ] Populate full endpoint inventory and request/response examples.
- [ ] Complete stable error code mappings and authorization decision matrices.
- [ ] Synchronize final values with OpenAPI and contract tests.

