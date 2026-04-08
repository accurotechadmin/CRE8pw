# Security Headers and CSP Policy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define the mandatory HTTP security header baseline and path-aware Content Security Policy behavior for CRE8 surfaces.

## Required default security headers
- `X-Frame-Options: DENY`
- `X-Content-Type-Options: nosniff`
- `Referrer-Policy: no-referrer`
- `Strict-Transport-Security: max-age=31536000; includeSubDomains`
- `Cross-Origin-Opener-Policy: same-origin`
- `Cross-Origin-Resource-Policy: same-origin`
- `Permissions-Policy: accelerometer=(), camera=(), geolocation=(), microphone=()`

Middleware must set these defaults unless already present with stricter equivalent values.

## Path-aware CSP contract
- **API/public non-UI paths**: `default-src 'none'; frame-ancestors 'none'`
- **UI paths (`/ui*`)**: `default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; frame-ancestors 'none'; base-uri 'none'; form-action 'self'`

## Enforcement requirements
- CSP policy is computed from request path.
- API and UI CSP must not be merged into a permissive union.
- Response generation path must avoid silently dropping CSP/security headers on error envelopes.

## Verification requirements
At minimum:
- contract test for default headers present,
- contract test for UI-path CSP,
- contract test ensuring pre-existing stricter CSP is not overwritten,
- regression check for error-envelope responses preserving security headers.

## Related SSOT docs
- `Security_Controls_Spec.md`
- `Request_Pipeline_Reference.md`
- `Verification_Strategy.md`
- `Production_Readiness_Gates.md`
