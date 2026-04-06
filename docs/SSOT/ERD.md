# ERD (Text + Mermaid)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

```mermaid
erDiagram
  PRINCIPALS ||--o{ PRINCIPAL_EMAILS : has
  PRINCIPALS ||--o{ CREDENTIALS : has
  PRINCIPALS ||--o{ TOKEN_FAMILIES : owns
  PRINCIPALS ||--o{ POSTS : authors
  PRINCIPALS ||--o{ COMMENTS : writes
  PRINCIPALS ||--o{ DELEGATION_ENVELOPES : issued_or_parent
  POSTS ||--o{ POST_REVISIONS : revisions
  POSTS ||--o{ POST_FLAGS : flags
  POSTS ||--o{ COMMENTS : has
  POSTS ||--o{ MODERATION_ACTIONS : moderated
  COMMENTS ||--o{ MODERATION_ACTIONS : moderated
  PRINCIPALS ||--o{ INVITE_RECEIPTS : creates
```

## Notes
- Delegation lineage is represented by `DELEGATION_ENVELOPES.parent_key_id` and `initial_author_key_id`.
- Refresh/replay protection is represented by `TOKEN_FAMILIES`.
- Keychains are extension-scoped and not included in the required v1 ERD.
