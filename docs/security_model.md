# Security Model

_Last updated (UTC): 2026-04-05_

## Authentication

- **Owner auth:** password login (`AuthService::login`) and refresh (`AuthService::refresh`) issuing `typ=owner` console-audience JWTs.
- **Key auth:** API key verification (`KeyLifecycleService::keyLogin`) and refresh (`KeyLifecycleService::refresh`) issuing `typ=key` gateway-audience JWTs containing permissions/scope/key_class/comments flags.

## JWT controls

- RSA signing via `JwtTokenSigner` with `kid` derived from public key hash.
- Verification via `JwtTokenVerifier` with strict claim requirements and 60s leeway.
- Audience/type consistency enforced both in verifier and auth middlewares.
- Delegation tokens require lineage claims (`delegation_envelope_id`, `initial_author_key_id`).

## Key material controls

- Keys can be inline PEM or filesystem paths.
- World-writable key files are rejected.
- PEM format sanity checks enforced.
- Boot checks enforce stricter private key permissions in stage/prod.

## HTTP/runtime controls

- CORS allowlist from runtime config.
- CSRF HMAC validation for non-API console writes.
- Global rate limiting via Symfony limiter.
- Device header validation for gateway requests.
- Use-key guard middleware blocks restricted mutation patterns.
- Security headers + CSP applied globally.

## Sensitive-data handling

- Audit emitter recursively redacts sensitive keys (e.g., token/password/secret/private_key/refresh_token).
- Error envelopes include request correlation but do not expose stack traces.
