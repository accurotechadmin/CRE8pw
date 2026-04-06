# Observability Event Catalog

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

## Required fields
- `event_name`
- `timestamp_utc`
- `request_id`
- `route_surface`
- `route_family`
- `result` (`success|failure`)

## Redaction guarantees
Sensitive keys (token/password/secret/private_key/refresh_token) MUST be redacted before emission.

## Correlation process
1. Start from response `X-Request-Id`.
2. Query all matching events across middleware/services.
3. Reconstruct route + policy decision path.
