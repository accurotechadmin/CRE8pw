# Traceability Matrix

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Link product capabilities to routes, policies/middleware, services/modules, tests, and SSOT docs.

## Scope
High-value v1 capabilities for auth, content, moderation, and operations.

## Normative statements
- Every capability MUST map to at least one route (or explicit non-HTTP interface), one control/policy, one test anchor, and one SSOT source.
- Missing mapping MUST be tracked as known gap.
- Matrix SHOULD be updated with any contract-affecting change.

## Interfaces / contracts
| Capability | Route(s) | Policy/Middleware | Service/Module | Tests | Canon docs | Status |
|---|---|---|---|---|---|---|
| Owner login | `POST /api/auth/login` | validation + rate limit | `AuthService` | `AuthServiceLoginContractTest` | `API_CONTRACT_GUIDE`, `AUTHORIZATION_AND_DELEGATION_SPEC` | mapped |
| Key login | `POST /api/auth/key-login` | key JWT + token verifier | `KeyLifecycleService` | `JwtTokenSecurityTest` | same | mapped |
| Refresh replay protection | `POST /api/auth/refresh` | token-family checks | `AuthService`/`KeyLifecycleService` | security + contract auth tests | `SECURITY_CONTROLS_SPEC` | mapped |
| Keychain membership mutate | `/console/api/keychains/{id}/members*` | owner JWT + policy | (planned) | (planned) | `ROUTE_INVENTORY_REFERENCE` | drift-gap |
| Health reporting | `GET /health` | request id + headers | `HealthService` | `HealthServiceContractTest` | `HEALTH_ENDPOINT_CONTRACT` | mapped |

## Failure/rejection semantics
- Capability with `drift-gap` status MUST not be marked production-complete.
- Stale test references SHOULD fail traceability review.

## Verification requirements
- CI diff for route/test/doc references (planned).
- Manual monthly drift audit until automation lands.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`, `src/Http/Middleware/*`, `src/Application/*`
- Tests refs: `tests/Contract/*`, `tests/Security/*`
- Related SSOT docs: `../10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`, `KNOWN_GAPS_TRACKER.md`, `SSOT_AUTOMATION_AND_LINTING.md`

## Open questions / known gaps
- Service/module mapping for `code/src/Modules/*` rebuild path needs a second matrix column for target architecture.

## Session progress (2026-04-08)
### Completed in this session
- Maintained templates and structure for SSOT drift prevention workflows.
- Preserved linkage points among requirements, code references, and tests.
- Prepared these docs for CI automation rule authoring.
### Remaining to finish this document
- [ ] Populate the traceability matrix with capability-level mappings.
- [ ] Define CI lint checks and failure policies for SSOT-code drift.
- [ ] Track open gaps with owners, target dates, and risk severity.

