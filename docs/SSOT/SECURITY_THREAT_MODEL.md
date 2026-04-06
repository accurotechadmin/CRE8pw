# Security Threat Model

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Threat scenarios
1. Stolen bearer token replay.
2. Refresh token replay in family.
3. Delegation escalation via over-scoped child key.
4. CSRF on console write routes.
5. Key file tampering/world-writable private keys.
6. Abuse via request flooding.

## Mitigations
- Short JWT TTL + refresh rotation/replay invalidation.
- Subset-only delegation with depth/expiry constraints.
- CSRF validation for applicable writes.
- Boot-time key material safety checks.
- Global rate limiter with retry metadata.
- Structured audit events with request IDs.

## Dependency linkage
- JWT controls: `firebase/php-jwt`
- Crypto primitives: `ext-sodium`
- CORS: `neomerx/cors-psr7`
- Rate limiting: `symfony/rate-limiter` + `symfony/cache`
- Logging/audit traces: `monolog/monolog`
