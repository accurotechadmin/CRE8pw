# Security Controls Spec

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define required preventive, detective, and corrective controls for CRE8 runtime.

## Scope
Startup key safety, JWT claims, middleware protections, logging, and transport controls.

## Normative statements
- Security decisions MUST fail closed.
- Signing/verification material MUST be validated at boot.
- Request handling MUST include CORS, rate limiting, and security headers where applicable.

## Interfaces / contracts
- Controls anchored to `BootChecks`, `TokenVerifier`, security middleware, and Monolog audit output.
- Dependencies: `firebase/php-jwt`, `ext-sodium`, `neomerx/cors-psr7`, `symfony/rate-limiter`, `monolog`.

## Failure/rejection semantics
- Any bypass of claim/scope checks is critical severity.
- Missing request correlation for security failures SHOULD be treated as observability defect.

## Verification requirements
- Execute `tests/Security/*` and relevant contract tests.
- Review against threat model and abuse cases.

## Traceability hooks
- Code refs: `src/Bootstrap/BootChecks.php`, `src/Security/*`, `src/Http/Middleware/*`
- Tests refs: `tests/Security/JwtTokenSecurityTest.php`, `tests/Security/KeyMaterialSecurityTest.php`
- Related SSOT docs: `SECURITY_HEADERS_AND_CSP_POLICY.md`, `SECURITY_THREAT_MODEL.md`, `SECURITY_VERIFICATION_ABUSE_CASES.md`

## Open questions / known gaps
- Formal control-to-mitigation coverage matrix still to be added.
