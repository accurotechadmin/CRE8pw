# ERD (Text + Mermaid)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

```mermaid
erDiagram
  PRINCIPALS ||--o{ PRINCIPAL_EMAILS : has
  PRINCIPALS ||--o{ CREDENTIALS : has
  PRINCIPALS ||--o{ TOKEN_FAMILIES : owns
  PRINCIPALS ||--o{ POSTS : authors
  PRINCIPALS ||--o{ COMMENTS : writes
  PRINCIPALS ||--o{ DELEGATION_ENVELOPES : issued_or_parent
  PRINCIPALS ||--o{ KEYCHAIN_MEMBERSHIPS : keychain_or_member
  PRINCIPALS ||--o{ KEYCHAIN_EFFECTIVE_SNAPSHOTS : snapshots
  POSTS ||--o{ POST_REVISIONS : revisions
  POSTS ||--o{ POST_FLAGS : flags
  POSTS ||--o{ COMMENTS : has
  POSTS ||--o{ MODERATION_ACTIONS : moderated
  COMMENTS ||--o{ MODERATION_ACTIONS : moderated
  PRINCIPALS ||--o{ INVITE_RECEIPTS : creates
  PRINCIPALS ||--o{ DOMAIN_EVENTS : actor
  POSTS ||--o{ FEED_ORDERING_PROJECTION : projected
  DOMAIN_EVENTS ||--o{ FEED_ORDERING_PROJECTION : drives
```

## Notes
- Delegation lineage is represented by `DELEGATION_ENVELOPES.parent_key_id` and `initial_author_key_id`.
- Refresh/replay protection is represented by `TOKEN_FAMILIES`.
- Keychain composition and effective aggregation history are represented by `KEYCHAIN_MEMBERSHIPS` and `KEYCHAIN_EFFECTIVE_SNAPSHOTS`.
- CQRS-lite audit/event lineage is represented by `DOMAIN_EVENTS`.
- Feed read ordering model maintenance is represented by `FEED_ORDERING_PROJECTION` keyed by projector source event IDs.
