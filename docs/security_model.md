# Security Model (Scaffold)

_Last updated (UTC): 2026-04-05_

## Purpose

Capture threat model assumptions and implemented controls.

## Sections to complete

- [ ] Authentication flows (owner + key login + refresh)
- [ ] Authorization and permission checks by route family
- [ ] JWT claim requirements and TTL policy boundaries
- [ ] Key material handling and file-permission safety rules
- [ ] CSRF/CORS/rate-limit/device controls and failure modes
- [ ] Secrets handling and environment hardening checklist

## Seed references

- `src/Security/*`
- `src/Http/Middleware/*`
- `tests/Security/*`
