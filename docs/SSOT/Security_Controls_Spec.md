# Security Controls Spec

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

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
Security controls are verified by suites listed in `Verification_Strategy.md`, aligned with `SECURITY_THREAT_MODEL.md`, expanded through abuse-case requirements in `Security_Verification_Abuse_Cases.md`, and include mandatory header/CSP checks defined in `Security_Headers_and_CSP_Policy.md`.
