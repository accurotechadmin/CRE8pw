# Authorization Decision Tables

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide explicit allow/deny matrices for high-risk capability decisions.

## Scope
Owner auth routes, gateway mutations, moderation actions, and lifecycle operations.

## Normative statements
- Decision outcomes MUST be deterministic for equivalent claim/context inputs.
- All table rows MUST map to tests.
- Unknown principal class MUST resolve to deny.

## Interfaces / contracts
| Capability | Principal | Preconditions | Decision |
|---|---|---|---|
| Create post | key | `posts:create` + scope allow + not revoked | allow |
| Create post | key(use) | mutation-disabled policy | deny(403) |
| Console post create | owner | valid owner JWT + CSRF | allow |
| Key lifecycle transition | owner | valid state transition | allow |

## Failure/rejection semantics
- Any uncovered decision branch SHOULD be treated as unverified risk.
- Decision-table/code mismatch MUST block release signoff.

## Verification requirements
- Add table-driven tests in contract/security suites.
- Review matrices during acceptance signoff.

## Traceability hooks
- Code refs: `src/Application/Auth/KeyLifecycleService.php`, `code/src/Modules/*/Domain/Policies/*.php`
- Tests refs: `tests/Contract/*`, `tests/Security/*`
- Related SSOT docs: `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `../40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

## Open questions / known gaps
- Need comprehensive row set for comments/moderation/read visibility branches.
