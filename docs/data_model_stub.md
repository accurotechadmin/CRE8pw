# Data Model & Persistence

_Last updated (UTC): 2026-04-05_

## Storage model

Persistence uses PDO with runtime SQL operations. Service constructors run `CREATE TABLE IF NOT EXISTS` for required auth/key/content tables to reduce first-run migration failures.

## Tables created/used by services

### Auth / principals

- `principals` (owner/key identity records, disable marker)
- `principal_emails` (owner email mapping)
- `credentials` (password/api_key hashes, revocation)
- `token_families` (refresh family state, nonce rotation, expiry)

### Key lifecycle

- `delegation_envelopes` (parent linkage, depth, scope_json, permissions_json, expiry)
- `invite_receipts` (invite issuance receipts with hashed invite code)

### Content

- `posts` (author, visibility, state, title/body, delete metadata)
- `post_revisions` (editor and reasoned edits)
- `post_flags` (flag actions)
- `comments` (comment body/state/delete metadata)
- `moderation_actions` (post/comment moderation audit rows)

## Lifecycle rules implemented in code

- Post states used: `draft`, `published`, `hidden`, `locked`, `archived`, `deleted`.
- Comment states used: `active`, `hidden`, `locked`, `deleted`.
- Key classes: `primary_author`, `secondary_author`, `use`.
- Delegation depth hard cap: `MAX_DEPTH = 3`.

## Refresh-token family behavior

Both owner and key flows hash refresh tokens, rotate on refresh, track previous nonce, and revoke on replay/expiry.
