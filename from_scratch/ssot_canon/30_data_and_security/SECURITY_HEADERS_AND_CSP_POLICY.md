# Security Headers and CSP Policy

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Specify canonical response header and CSP behavior across UI and API paths.

## Scope
Global security headers and path-aware CSP differences.

## Normative statements
- Security headers MUST be applied to all responses unless explicitly exempted.
- UI and API paths SHOULD use tailored CSP directives.
- Existing explicit header values MAY be preserved to avoid unintended override.

## Interfaces / contracts
- Implementation anchor: `SecurityHeadersMiddleware`.
- Policy includes CSP, X-Content-Type-Options, X-Frame-Options, Referrer-Policy, and similar headers.

## Failure/rejection semantics
- Missing critical headers on protected responses SHOULD fail security verification.
- Overly permissive CSP in production MUST be blocked.

## Verification requirements
- Header assertions in contract/security tests and manual browser inspection for `/ui`.

## Traceability hooks
- Code refs: `src/Http/Middleware/SecurityHeadersMiddleware.php`
- Tests refs: `tests/Contract/MiddlewareRegistryContractsTest.php`
- Related SSOT docs: `SECURITY_CONTROLS_SPEC.md`, `../20_contracts/UI_RUNTIME_CONTRACT.md`

## Open questions / known gaps
- Detailed production CSP directive baseline requires final frontend asset inventory.
