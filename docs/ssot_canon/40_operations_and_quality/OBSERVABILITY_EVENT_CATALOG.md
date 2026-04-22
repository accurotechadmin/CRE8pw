# Observability Event Catalog

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Event families
- `auth.*`
- `auth.owner_jwt.*`
- `auth.key_jwt.*`
- `security.*`
- `csrf.*`
- `rate_limit.*`
- `device_limit.*`
- `request_id.*`
- `keys.*`
- `comments.*`
- `moderation.*`
- `invites.*`
- `validation.*`
- `routing.*`

## Canonical event naming guidance
- Use `<family>.<action>` and `<family>.<entity>.<action>` patterns.
- Startup events:
  - `boot.startup_ready`
  - `boot.startup_failed`
- Delivery fallback event:
  - `audit.delivery_failed`

## Required event fields
- `event_name`
- `timestamp_utc`
- `request_id`
- `surface` (`public|gateway|console`)
- `actor_principal_id` (nullable where unauthenticated)
- `result` (`success|failure`)
- `detail_code` (when failure)

## Logging requirements
- Structured logs must be emitted through channelized application/security/audit streams.
- Sensitive fields (`token`, `secret`, `private_key`) must be redacted before emission.
- Security-significant route outcomes (401/403/429) require an event emission.
- If primary audit delivery fails, fallback error-path emission must preserve `event_name`, `request_id` where available, and failure metadata.

## Correlation requirements
- `request_id` must correlate between HTTP response envelope and emitted events.
- Incident timelines should be reconstructable using only event stream + request IDs.
