# Data Model Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Storage strategy
- PDO-backed relational storage.
- Services ensure baseline table existence for first-run resilience.

## Core entity groups
- Principals/auth: `principals`, `principal_emails`, `credentials`, `token_families`
- Delegation/lifecycle: `delegation_envelopes`, `invite_receipts`
- Content/moderation: `posts`, `post_revisions`, `post_flags`, `comments`, `moderation_actions`

## Lifecycle invariants
- Key classes: `primary_author|secondary_author|use`
- Delegation max depth: 3
- Post states: `draft|published|hidden|locked|archived|deleted`
- Comment states: `active|hidden|locked|deleted`
