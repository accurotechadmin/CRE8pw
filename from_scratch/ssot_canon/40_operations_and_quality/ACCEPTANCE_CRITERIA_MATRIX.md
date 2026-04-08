# Acceptance Criteria Matrix

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Capture Given/When/Then acceptance criteria for key route capabilities.

## Scope
Core public/auth/gateway/console route families.

## Normative statements
- Each route family MUST have positive and negative acceptance criteria.
- Matrix entries MUST map to executable tests.
- Behavioral acceptance MUST stay synchronized with OpenAPI contracts.

## Interfaces / contracts
| Capability | Route(s) | Positive | Negative/edge |
|---|---|---|---|
| Service status | `GET /` | returns success envelope | internal error returns error envelope |
| Owner login | `POST /api/auth/login` | valid credentials issue tokens | invalid creds -> 401 |
| Key login | `POST /api/auth/key-login` | valid key issues tokens | revoked/invalid -> 401 |
| Console write | `POST /console/api/posts` | owner+csrf succeeds | missing csrf -> 403 |

## Failure/rejection semantics
- Missing negative criteria for protected route is QA gap.
- Drift with route inventory or OpenAPI MUST block release.

## Verification requirements
- Contract/security tests and manual QA checklist evidence.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`
- Tests refs: `tests/Contract/RouteRegistrarContractsTest.php`, `tests/Security/*`
- Related SSOT docs: `VERIFICATION_STRATEGY.md`, `../20_contracts/ROUTE_INVENTORY_REFERENCE.md`

## Open questions / known gaps
- Full matrix parity with legacy SSOT still pending migration pass.
