# Security Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Auth model
- Owner JWT (`typ=owner`, console audience)
- Key JWT (`typ=key`, gateway audience)

## JWT controls
- Dependency mapping: `firebase/php-jwt` for issuance/verification and JWKS compatibility.
- RS256 signing with `kid`
- Strict claims + audience/type checks
- 60s verifier leeway
- Delegation lineage claims required for delegated key flows

## Runtime controls
- Dependency mapping: `neomerx/cors-psr7` (CORS policy), `symfony/rate-limiter` + `symfony/cache` (rate limiting), `slim/slim` middleware ordering.
- CORS policy allowlist
- CSRF for applicable console writes
- Global rate limiting
- Device ID guard for gateway
- Use-key mutation restrictions
- Security headers/CSP

## Sensitive handling
- Dependency mapping: `ext-sodium` for Argon2id hashing/secure random/constant-time compare; `monolog/monolog` for structured security/audit logging.
- Redaction of token/secret/private key fields in audit contexts
- Correlated request IDs in errors without stack trace disclosure
