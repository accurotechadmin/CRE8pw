# Security Controls Spec

_Status: adopted_
_Last updated (UTC): 2026-04-09_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Control objectives
1. Ensure credential authenticity and bounded token lifetime.
2. Prevent unauthorized mutation/actions via layered claim/policy checks.
3. Preserve operational traceability with redacted structured logs.

## Trust boundaries
- Browser/third-party clients ↔ API
- API ↔ DB
- API ↔ signing material
- API ↔ logging/observability sinks

## Control baseline
- Key material validation and file permission checks at boot.
- JWT claim enforcement: issuer, audience, type, timing, lineage.
- Refresh family replay protection.
- Rate limiting + CSRF + CORS + device headers.
- Immutable error envelope with request correlation IDs.

## Dependency mapping
- JWT: `firebase/php-jwt`
- Crypto primitives: `ext-sodium`
- Policy middleware host: `slim/slim`
- CORS: `neomerx/cors-psr7`
- Rate limiting state/policy: `symfony/rate-limiter` + `symfony/cache`
- Structured audit logs: `monolog/monolog`

## Verification linkage
Security controls are verified by suites listed in `VERIFICATION_STRATEGY.md`, aligned with `SECURITY_THREAT_MODEL.md`, expanded through abuse-case requirements in `SECURITY_VERIFICATION_ABUSE_CASES.md`, and include mandatory header/CSP checks defined in `SECURITY_HEADERS_AND_CSP_POLICY.md`.
