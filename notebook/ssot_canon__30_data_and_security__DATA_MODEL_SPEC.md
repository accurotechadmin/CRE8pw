# Data Model Spec (Production)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

This schema-level contract is implemented through `ext-pdo` prepared statements and transactional writes (see `DEPENDENCY_BASELINE.md`).

## Table contracts

### principals
- `id` PK
- `principal_type` (`owner|key`)
- `key_class` nullable (`primary_author|secondary_author|use|keychain` when `principal_type=key`)
- `disabled_at` nullable timestamp
- indexes: `(principal_type)`, `(key_class)`, `(disabled_at)`

### principal_emails
- `principal_id` FK principals(id)
- `email_normalized` unique

### credentials
- `principal_id` FK principals(id)
- `credential_type` (`password|api_key`)
- `secret_hash`
- `revoked_at` nullable timestamp
- index: `(principal_id, credential_type)`

### token_families
- `family_id` PK
- `principal_id` FK principals(id)
- `current_token_hash`
- `previous_nonce_hash`
- `expires_at`
- `revoked_at`
- indexes: `(principal_id)`, `(expires_at)`, `(revoked_at)`

### delegation_envelopes
- `id` PK
- `parent_key_id` nullable FK principals(id)
- `issued_key_id` FK principals(id)
- `initial_author_key_id` FK principals(id)
- `depth` int (<=3)
- `permissions_json`
- `scope_json`
- `expires_at`
- `status` (`active|suspended|cancelled|revoked`)
- indexes: `(issued_key_id)`, `(parent_key_id)`, `(status)`, `(expires_at)`

### keychain_memberships
- `id` PK
- `keychain_key_id` FK principals(id) where `key_class=keychain`
- `member_key_id` FK principals(id) where `key_class in (primary_author,secondary_author,use)`
- `added_by_owner_id` FK principals(id)
- `added_at`
- `removed_at` nullable
- `status` (`active|removed`)
- uniqueness: active `(keychain_key_id, member_key_id)`
- indexes: `(keychain_key_id, status)`, `(member_key_id, status)`

### keychain_effective_snapshots
- `id` PK
- `keychain_key_id` FK principals(id)
- `effective_permissions_json`
- `effective_scope_json`
- `member_count`
- `computed_at`
- `computed_by` (`system|owner_action`)
- indexes: `(keychain_key_id, computed_at DESC)`

### invite_receipts
- `id` PK
- `owner_id` FK principals(id)
- `invite_code_hash`
- `email_target`
- `expires_at`
- `used_at` nullable

### posts
- `id` PK
- `author_id` FK principals(id)
- `visibility_scope`
- `state`
- `title`
- `body`
- `created_at`, `updated_at`, `deleted_at`
- indexes: `(author_id, created_at DESC)`, `(state)`, `(visibility_scope)`

### post_revisions
- `id` PK
- `post_id` FK posts(id)
- `editor_id` FK principals(id)
- `reason_code`
- `title`, `body`
- `created_at`

### post_flags
- `id` PK
- `post_id` FK posts(id)
- `actor_key_id` FK principals(id)
- `reason_code`
- `notes`
- `created_at`

### comments
- `id` PK
- `post_id` FK posts(id)
- `author_id` FK principals(id)
- `body`
- `state`
- `created_at`, `deleted_at`
- indexes: `(post_id, created_at ASC)`, `(state)`

### moderation_actions
- `id` PK
- `target_type` (`post|comment`)
- `target_id`
- `action`
- `reason_code`
- `actor_owner_id` FK principals(id)
- `created_at`

## Retention
- Soft-delete metadata retained by default.
- Audit and moderation rows retained for compliance and incident analysis.
- Keychain snapshots retained for lineage and incident reconstruction.

## Consistency notes
- Keychain behavior is part of the v1 required schema surface.
- Any schema change requires synchronized updates to `DATA_MODEL_REFERENCE.md`, `ERD.md`, `TRACEABILITY_MATRIX.md`, and `ROUTE_INVENTORY_REFERENCE.md`.
