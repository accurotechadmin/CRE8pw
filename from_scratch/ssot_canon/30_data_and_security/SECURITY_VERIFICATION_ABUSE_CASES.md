# Security Verification Abuse Cases

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Enumerate negative-path security scenarios that must be regression tested.

## Scope
Auth failures, token misuse, replay, scope bypass, header/csrf bypass, and startup hardening.

## Normative statements
- Every critical abuse case MUST have at least one automated test.
- Abuse-case IDs MUST be traceable to threat model entries.
- Regression failures MUST block release.

## Interfaces / contracts
| Abuse case ID | Scenario | Expected outcome |
|---|---|---|
| SEC-AC-001 | tampered JWT signature | `401 auth_invalid` |
| SEC-AC-002 | refresh token replay | `401 auth_invalid` + family invalidation |
| SEC-AC-003 | console write without CSRF | `403 forbidden` |
| SEC-AC-004 | key uses disallowed mutation | `403 forbidden` |

## Failure/rejection semantics
- Missing automated coverage for critical abuse case is a release blocker.
- Ambiguous expected outcome MUST be resolved in error catalog.

## Verification requirements
- Execute security suite and report abuse-case coverage map.
- Validate detail codes against error catalog.

## Traceability hooks
- Code refs: `src/Security/TokenVerifier.php`, `src/Http/Middleware/CsrfMiddleware.php`
- Tests refs: `tests/Security/JwtTokenSecurityTest.php`, `tests/Security/ApiKeyHasherSecurityTest.php`
- Related SSOT docs: `SECURITY_THREAT_MODEL.md`, `../20_contracts/ERROR_CODE_CATALOG.md`, `../40_operations_and_quality/VERIFICATION_STRATEGY.md`

## Open questions / known gaps
- Existing repo lacks dedicated abuse-case test file naming convention; mapping is manual for now.
