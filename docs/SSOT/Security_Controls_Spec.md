# Security Controls Spec

_Last updated (UTC): 2026-04-06_

## Control objectives
1. Ensure credential authenticity and bounded token lifetime.
2. Prevent unauthorized mutation/actions by policy and claim checks.
3. Preserve operational traceability with redacted structured logs.

## Trust boundaries
- Browser/third-party clients ↔ API
- API ↔ DB
- API ↔ signing material
- API ↔ logging/observability sinks

## Key controls
- Key material validation and file permission checks.
- JWT claim enforcement: issuer, audience, type, timing, lineage.
- Refresh family replay protection.
- Rate limiting + CSRF + CORS + device headers.
- Use-key restrictions on mutations.

## Residual risks (tracked)
- LocalStorage token persistence tradeoffs in SPA.
- Optional HTTPS enforcement varies by environment profile.
- No mandatory MFA in v1.

## Mandatory evidence
- Security test suite pass.
- Boot checks pass in stage/prod profile.
- Health probes including key material readiness pass.
