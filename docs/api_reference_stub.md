# API Reference

_Last updated (UTC): 2026-04-05_

## Envelope contract

- Success responses: `{ data, meta }` with optional `paging` for list endpoints.
- Error responses: `{ error: { code, message, details, request_id }, meta }`.
- `X-Envelope-Version` header is emitted on all responder-generated payloads.

## Endpoint catalog

### Public/auth/bootstrap

- `GET /` → health banner payload.
- `GET /health` → deep subsystem checks.
- `GET /.well-known/jwks.json` → active RSA JWKS.
- `GET /ui[/{route:.*}]` → UI asset/file fallback serving.
- `POST /console/owners` → owner registration.
- `POST /api/auth/login` → owner access+refresh issue.
- `POST /api/auth/key-login` → key access+refresh issue.
- `POST /api/auth/refresh` → owner refresh, with fallback to key refresh on surface mismatch.

### Gateway (`/api/*`)

- `GET /api/feed`
- `POST /api/posts`
- `PATCH /api/posts/{postId}`
- `POST /api/posts/{postId}/flags`
- `GET /api/posts/{postId}`
- `GET /api/posts/{postId}/comments`
- `POST /api/posts/{postId}/comments`

### Console (`/console/api/*`)

- `GET /console/api/posts`
- `POST /console/api/posts`
- `GET /console/api/keychains`
- `POST /console/api/invites`
- `POST /console/api/keys`
- `POST /console/api/keys/{keyId}/lifecycle`
- `POST /console/api/posts/{postId}/moderation`
- `POST /console/api/posts/{postId}/comments/{commentId}/moderation`

## Notable policy behaviors

- Gateway write flows require permissions in key claims (`posts:create`, `posts:edit`, `comments:create`).
- `use` keys cannot create posts or mutate keys.
- Comments create is additionally gated by post state and `comments_enabled` claim.
- Console moderation actions are allowlisted per route and emit moderation audit events.
