# ERD (Text + Mermaid)

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
- `delegation_envelopes` links parent and child credentials for lineage.
- Moderation actions capture governance transitions for both posts and comments.
