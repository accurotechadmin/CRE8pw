# Endpoint Inventory + Frontend UI Coverage

_Last updated (UTC): 2026-04-05_

This document lists all HTTP endpoints registered in `RouteRegistrar` and identifies which ones are already wired to interactive HTML pages in the SPA under `public/ui`.

## 1) Full backend endpoint list (from route registration)

### Public + bootstrap/auth endpoints

| Method | Endpoint | Surface | Notes |
|---|---|---|---|
| GET | `/` | public | Service banner / status payload. |
| GET | `/health` | public | Deep health checks across subsystems. |
| GET | `/ui[/{route:.*}]` | public | Serves SPA shell + static UI assets. |
| GET | `/.well-known/jwks.json` | public | Returns active JWKS key set. |
| POST | `/console/owners` | public (signup) | Owner registration. |
| POST | `/api/auth/login` | public/auth | Owner login. |
| POST | `/api/auth/key-login` | public/auth | Key login. |
| POST | `/api/auth/refresh` | public/auth | Refresh owner token, with key-refresh fallback path. |

### Console endpoints (`/console/api/*`)

| Method | Endpoint | Surface | Notes |
|---|---|---|---|
| GET | `/console/api/posts` | console | List owner posts. |
| POST | `/console/api/posts` | console | Create owner post. |
| GET | `/console/api/keychains` | console | List keychain records. |
| POST | `/console/api/invites` | console | Create invite receipt. |
| POST | `/console/api/keys` | console | Issue key. |
| POST | `/console/api/keys/{keyId}/lifecycle` | console | Lifecycle transition (`suspend/cancel/revoke`). |
| POST | `/console/api/posts/{postId}/moderation` | console | Moderate post (`hide/lock/archive/delete`). |
| POST | `/console/api/posts/{postId}/comments/{commentId}/moderation` | console | Moderate comment (`hide/lock/delete`). |

### Gateway endpoints (`/api/*`)

| Method | Endpoint | Surface | Notes |
|---|---|---|---|
| GET | `/api/feed` | gateway | Feed list (supports scope/limit/cursor query params). |
| POST | `/api/posts` | gateway | Create post. |
| PATCH | `/api/posts/{postId}` | gateway | Revise post. |
| POST | `/api/posts/{postId}/flags` | gateway | Flag post (requires `reason_code`). |
| GET | `/api/posts/{postId}` | gateway | Get post detail. |
| GET | `/api/posts/{postId}/comments` | gateway | List comments for post. |
| POST | `/api/posts/{postId}/comments` | gateway | Create comment for post. |

---

## 2) Endpoints with HTML frontend pages ready to use

The SPA is served by `GET /ui[/{route:.*}]` and drives calls to the endpoints below.

### A) Auth/bootstrap endpoints with UI screens

| Endpoint | UI route(s) in SPA |
|---|---|
| `POST /console/owners` | `/signup-owner` |
| `POST /api/auth/login` | `/login` |
| `POST /api/auth/key-login` | `/key-login` |

### B) Gateway endpoints with UI screens

| Endpoint | UI route(s) in SPA |
|---|---|
| `GET /api/feed` | `/feed` |
| `POST /api/posts` | `/posts/new` |
| `GET /api/posts/{postId}` | `/posts/{postId}`, `/posts/{postId}/edit`, `/posts/{postId}/comments/new` |
| `PATCH /api/posts/{postId}` | `/posts/{postId}/edit` |
| `POST /api/posts/{postId}/flags` | `/posts/{postId}/flag` |
| `GET /api/posts/{postId}/comments` | `/posts/{postId}/comments` |
| `POST /api/posts/{postId}/comments` | `/posts/{postId}/comments/new` |

### C) Console endpoints with UI screens

| Endpoint | UI route(s) in SPA |
|---|---|
| `GET /console/api/posts` | `/console/posts` |
| `POST /console/api/posts` | `/console/posts/new` |
| `GET /console/api/keychains` | `/console/keychains` |
| `POST /console/api/invites` | `/console/invites/new` |
| `POST /console/api/keys` | `/console/keys/new` |
| `POST /console/api/keys/{keyId}/lifecycle` | `/console/keys/{keyId}/lifecycle` |
| `POST /console/api/posts/{postId}/moderation` | `/console/posts/{postId}/moderation` |
| `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | `/console/posts/{postId}/comments/{commentId}/moderation` |

---

## 3) Backend endpoints currently **not** exposed via dedicated SPA pages

These endpoints exist but do not currently have a dedicated in-app page/flow:

- `GET /`
- `GET /health`
- `GET /.well-known/jwks.json`
- `POST /api/auth/refresh` (the current SPA stores tokens after login but does not present a refresh-token UI workflow)

