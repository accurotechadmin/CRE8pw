# Data Model Spec (Production)

_Last updated (UTC): 2026-04-06_

## Table contracts

### principals
- `id` PK
- `principal_type` (`owner|key`)
- `disabled_at` nullable timestamp
- indexes: `(principal_type)`, `(disabled_at)`

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
