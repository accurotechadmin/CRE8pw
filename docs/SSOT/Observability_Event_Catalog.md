# Observability Event Catalog

_Status: adopted_
_Last updated (UTC): 2026-04-06_

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

## Correlation requirements
- `request_id` must correlate between HTTP response envelope and emitted events.
- Incident timelines should be reconstructable using only event stream + request IDs.
