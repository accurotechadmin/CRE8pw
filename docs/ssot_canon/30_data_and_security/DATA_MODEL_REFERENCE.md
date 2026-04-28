# Data Model Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Storage strategy
- Relational storage through `ext-pdo` prepared statements and transactions.
- Migration-safe schema evolution with backward-compatible change sequencing.
- Services may perform first-run table assertion checks; production migrations remain source of truth.

## Core entity groups
- Principals/auth: `principals`, `principal_emails`, `credentials`, `token_families`
- Delegation/lifecycle: `delegation_envelopes`, `invite_receipts`
- Content/moderation: `posts`, `post_revisions`, `post_flags`, `comments`, `moderation_actions`
- Keychain model: `keychain_memberships`, `keychain_effective_snapshots`
- CQRS-lite audit/projection model: `domain_events`, `feed_ordering_projection`, `keychain_effective_projection`, `projection_event_receipts`

## Lifecycle invariants
- Principal types: `owner|key`
- Key classes (v1 active): `primary_author|secondary_author|use|keychain`
- Delegation max depth: `3`
- Keychain membership max size: `50`
- Keychain member classes allowed: `primary_author|secondary_author|use`
- Keychain nesting: forbidden
- Post states: `draft|published|hidden|locked|archived|deleted`
- Comment states: `active|hidden|locked|deleted`

## Transaction boundaries (required)
- Auth issuance + audit event write occur in a single logical transaction scope.
- Key lifecycle mutations + lineage update occur atomically.
- Keychain membership mutation + effective-snapshot update + audit event write occur atomically.
- Moderation decisions + revision metadata must commit together.
- Command-state mutation + `domain_events` append must commit atomically.
- `feed_ordering_projection` updates are idempotent by `source_event_id` and execute through `ProjectionUpdater` in sync mode by default.
- `keychain_effective_projection` updates are idempotent by `(keychain_key_id, source_event_id)` and execute through `ProjectionUpdater` in sync mode by default.
- `projection_event_receipts` are inserted before projector state mutation; duplicate `(projector_name, source_event_id)` receipt detection produces deterministic replay no-op behavior.
- Sync projection mode is default runtime behavior when `ARCH_CQRS_LITE_ENABLED=true`; command success responses are emitted only after synchronous projection updates complete.

## Related SSOT docs
- `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`
- `docs/ssot_canon/30_data_and_security/ERD.md`
- `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
