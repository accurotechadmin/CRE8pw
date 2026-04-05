# Observability & Audit Runbook

_Last updated (UTC): 2026-04-05_

## Log and event producers

- `public/index.php`: startup readiness/failure JSON events (`boot.startup_ready`, `boot.startup_failed`).
- Middleware and services: structured audit events via `AuditEmitter`.
- `MonologAuditEmitter`: context normalization, required field backfill, sensitive-field redaction, optional security/failure logger routing.

## Event naming patterns in code

- Auth: `auth.*`, `auth.owner_jwt.*`, `auth.key_jwt.*`
- Security/runtime guards: `security.*`, `csrf.*`, `rate_limit.*`, `device_limit.*`, `request_id.*`
- Content/key operations: `keys.*`, `comments.*`, `moderation.*`, `invites.*`, `validation.*`, `routing.*`

## Incident triage

1. Start from `X-Request-Id` in response envelope.
2. Find corresponding middleware/service audit events.
3. Confirm detail/reason code and surface (`route_surface`, `route_family`).
4. Correlate with startup/health probes when widespread failures occur.

## Delivery-failure handling

If primary logger throws during event emission, emitter records `audit.delivery_failed` either to configured failure logger or PHP error log fallback.
