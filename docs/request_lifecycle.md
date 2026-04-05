# Request Lifecycle (Scaffold)

_Last updated (UTC): 2026-04-05_

## Purpose

Trace request handling from entrypoint to response envelope.

## Sections to complete

- [ ] Startup path (`public/index.php`) and fail-fast behavior
- [ ] Middleware order and per-surface branching
- [ ] Route resolution and service invocation patterns
- [ ] Error mapping and envelope shaping
- [ ] Audit emission points per stage

## Trace template

1. Request arrives
2. Request-ID normalization
3. Surface detection
4. Security/policy middleware
5. Handler -> service -> persistence
6. EnvelopeResponder output
7. Access/error/audit logs
