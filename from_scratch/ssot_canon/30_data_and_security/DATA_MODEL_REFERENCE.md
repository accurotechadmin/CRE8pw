# Data Model Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Storage strategy
- Relational storage through `ext-pdo` prepared statements and transactions.
- Migration-safe schema evolution with backward-compatible change sequencing.
- Services may perform first-run table assertion checks; production migrations remain source of truth.

## Core entity groups
- Principals/auth: `principals`, `principal_emails`, `credentials`, `token_families`
- Delegation/lifecycle: `delegation_envelopes`, `invite_receipts`
- Content/moderation: `posts`, `post_revisions`, `post_flags`, `comments`, `moderation_actions`
- Keychain model: `keychain_memberships`, `keychain_effective_snapshots`

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

## Related SSOT docs
- `DATA_MODEL_SPEC.md`
- `ERD.md`
- `AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `ROUTE_INVENTORY_REFERENCE.md`
