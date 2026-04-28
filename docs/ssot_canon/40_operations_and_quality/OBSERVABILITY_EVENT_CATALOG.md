# Observability Event Catalog

_Status: adopted_
_Last updated (UTC): 2026-04-28_

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
- `domain_event.*`
- `command.*`
- `query.*`
- `projection.*`
- `projection.worker.*`
- `queue.*`
- `alert.*`
- `validation.*`
- `routing.*`

## Canonical event naming guidance
- Use `<family>.<action>` and `<family>.<entity>.<action>` patterns.
- Startup events:
  - `boot.startup_ready`
  - `boot.startup_failed`
- Delivery fallback event:
  - `audit.delivery_failed`

## Domain event publication contract
- `DomainEvent` payloads are published through `EventPublisher` and map to `domain_event.*` event names.
- Command-dispatch outcomes emit `command.dispatch.success` or `command.dispatch.failure`.
- Query-dispatch outcomes emit `query.dispatch.success` or `query.dispatch.failure` when dispatch-level failures occur.
- Projection updater outcomes emit `projection.update.applied`, `projection.update.skipped_duplicate`, or `projection.update.failed` with preserved `request_id`/`source_event_id` metadata.
- Keychain-effective projection updates for resolve flows emit the same canonical `projection.update.*` outcomes with `projector_name=KeychainEffectiveProjector`.
- Transactional command execution emits `command.transaction.committed` on atomic write+event success and `command.transaction.rolled_back` when the transaction is aborted.
- Sync projection mode emits `command.projection_sync.required` when `ARCH_CQRS_LITE_ENABLED=true`; sync-update failure paths emit `command.projection_sync.failed` and terminate with fail-closed command outcomes.
- Async projection worker events emit `projection.worker.dequeue`, `projection.worker.retry_scheduled`, `projection.worker.dead_lettered`, and `projection.worker.applied` with preserved `request_id` and `source_event_id` metadata where available.
- Queue health events emit `queue.depth.sampled` and `queue.dead_letter_depth.sampled` for async projection queues.
- Alert pipeline emits `alert.command_failure_rate.breached` and `alert.projection_latency.breached` when SLO thresholds are exceeded.
- Command handlers for moderation and key lifecycle flows emit `command.moderation.executed` and `command.key_lifecycle.executed` for successful high-audit mutations.
- Event publication failures emit `audit.delivery_failed` with preserved `request_id` and failed `event_name` metadata.
- Event emission redacts token material, secret material, and private-key material before sink delivery.

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
- `MonologEventSink` applies deterministic redaction before serialization and before channel write.
- Sensitive fields (`token`, `secret`, `private_key`) must be redacted before emission.
- Security-significant route outcomes (401/403/429) require an event emission.
- If primary audit delivery fails, fallback error-path emission must preserve `event_name`, `request_id` where available, and failure metadata.

## Correlation requirements
- `request_id` must correlate between HTTP response envelope and emitted events.
- Incident timelines should be reconstructable using only event stream + request IDs.
