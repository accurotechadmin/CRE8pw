# Security Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Auth model
- Owner JWT (`typ=owner`, console audience)
- Key JWT (`typ=key`, gateway audience)

## JWT controls
- RS256 signing with `kid`
- Strict claims + audience/type checks
- 60s verifier leeway
- Delegation lineage claims required for delegated key flows

## Runtime controls
- CORS policy allowlist
- CSRF for applicable console writes
- Global rate limiting
- Device ID guard for gateway
- Use-key mutation restrictions
- Security headers/CSP

## Sensitive handling
- Redaction of token/secret/private key fields in audit contexts
- Correlated request IDs in errors without stack trace disclosure
