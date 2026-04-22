# Security Controls Spec

_Status: adopted_
_Last updated (UTC): 2026-04-22_

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
- JWT claim enforcement: issuer, audience, type, timing, lineage, and bound `device_id` claim for gateway/session-bound token families.
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


## Device binding control
- Gateway and session-bound JWTs include a mandatory `device_id` claim at issuance time.
- `X-Device-Id` header validation is a claim-match check, not header-format-only validation.
- Requests with missing `X-Device-Id`, missing JWT `device_id`, malformed values, or mismatched values MUST fail with canonical outcomes by pipeline stage: `422 validation_failed` (`device_id_missing` / `device_id_invalid_format`) or `401 auth_invalid` (`token_device_mismatch`).
- Tokens are non-transferable across devices; replay from a different device identifier is denied even with otherwise valid signature/timing claims.
