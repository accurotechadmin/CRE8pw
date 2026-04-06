# UI Parity Contract

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Route families
- Public auth and diagnostics: `/status`, `/health`, `/jwks`, `/signup-owner`, `/login`, `/key-login`, `/session/refresh`
- Gateway content: `/feed`, `/posts/*`
- Console governance: `/console/*` routes for posts, moderation, keys, keychains, invites, and lifecycle actions

## Endpoint-to-UI parity map (canonical)
| API endpoint | UI route parity target |
|---|---|
| `GET /` | `/status` |
| `GET /health` | `/health` |
| `GET /.well-known/jwks.json` | `/jwks` |
| `GET /ui/{route}` | `/ui/*` |
| `POST /console/owners` | `/signup-owner` |
| `POST /api/auth/login` | `/login` |
| `POST /api/auth/key-login` | `/key-login` |
| `POST /api/auth/refresh` | `/session/refresh` |
| `GET /api/feed` | `/feed` |
| `POST /api/posts` | `/posts/new` |
| `GET /api/posts/{postId}` | `/posts/{postId}` |
| `PATCH /api/posts/{postId}` | `/posts/{postId}/edit` |
| `POST /api/posts/{postId}/flags` | `/posts/{postId}/flag` |
| `GET /api/posts/{postId}/comments` | `/posts/{postId}/comments` |
| `POST /api/posts/{postId}/comments` | `/posts/{postId}/comments/new` |
| `GET /console/api/posts` | `/console/posts` |
| `POST /console/api/posts` | `/console/posts/new` |
| `GET /console/api/keychains` | `/console/keychains` |
| `POST /console/api/keychains` | `/console/keychains/new` |
| `GET /console/api/keychains/{keychainId}/members` | `/console/keychains/{id}` |
| `POST /console/api/keychains/{keychainId}/members` | `/console/keychains/{id}/add-member` |
| `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}` | `/console/keychains/{id}` |
| `GET /console/api/keychains/{keychainId}/resolve` | `/console/keychains/{id}/resolve` |
| `POST /console/api/invites` | `/console/invites/new` |
| `POST /console/api/keys` | `/console/keys/new` |
| `POST /console/api/keys/{keyId}/lifecycle` | `/console/keys/{keyId}/lifecycle` |
| `POST /console/api/posts/{postId}/moderation` | `/console/moderation/posts/{postId}` |
| `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | `/console/moderation/posts/{postId}/comments/{commentId}` |

## Auth-surface behavior
- Owner routes require owner token (`typ=owner`).
- Gateway routes require key token (`typ=key`) + `X-Device-Id` where enforced.
- Console writes must enforce CSRF where session-cookie flows apply.
- Unauthorized responses must preserve `request_id` for support diagnostics.

## Required UX for error classes
- `401`: session clear + redirect to appropriate login
- `403`: forbidden panel with reason mapping
- `404`: not-found state
- `422`: field-level validation mapping
- `429`: retry guidance
- `5xx`: generic server error + request-id display

## UX consistency rules
- UI field validation names map directly to `error.details[]` keys.
- Retry affordances must honor limiter metadata where present.
- Every API-backed page must include loading, empty, and failure states.
- Parity changes must be updated in `Route_Inventory_Reference.md`, `UI_Parity_and_Contract.md`, and `ui/endpoints_unified.json` in the same PR.
