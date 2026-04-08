# Route Inventory Reference

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
List canonical route inventory grouped by surface and status.

## Scope
HTTP routes registered by runtime route registrar.

## Normative statements
- Inventory MUST match mounted routes in `RouteRegistrar`.
- Deprecated/planned routes MUST be explicitly marked and not implied as implemented.
- Route methods and paths MUST align with OpenAPI.

## Interfaces / contracts
| Surface | Method | Path | Status | Notes |
|---|---|---|---|---|
| Public | GET | `/` | implemented | service status |
| Public | GET | `/health` | implemented | subsystem checks |
| Public | GET | `/.well-known/jwks.json` | implemented | verifier keys |
| Auth | POST | `/console/owners` | implemented | owner bootstrap |
| Auth | POST | `/api/auth/login` | implemented | owner token issue |
| Auth | POST | `/api/auth/key-login` | implemented | key token issue |
| Auth | POST | `/api/auth/refresh` | implemented | owner/key refresh |
| Console | GET | `/console/api/keychains` | implemented | list only |
| Console | GET/POST/DELETE | `/console/api/keychains/{id}/members*` | draft-gap | in legacy SSOT, not mounted now |
| Console | GET | `/console/api/keychains/{id}/resolve` | draft-gap | in legacy SSOT, not mounted now |

## Failure/rejection semantics
- Route drift between docs and code MUST be recorded as gap and blocks adoption.
- Missing auth/security annotations for protected routes SHOULD fail review.

## Verification requirements
- Diff route inventory vs `RouteRegistrar` and OpenAPI in CI.
- Contract tests should assert representative route availability.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`
- Tests refs: `tests/Contract/RouteRegistrarContractsTest.php`
- Related SSOT docs: `API_CONTRACT_GUIDE.md`, `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `../50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- Full inventory table still needs non-keychain console/gateway route expansion.
