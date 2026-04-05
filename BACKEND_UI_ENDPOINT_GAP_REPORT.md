# Backend vs UI Endpoint Parity Report

Date: 2026-04-05 (UTC)

## Scope and method

- Parsed all UI API calls from `ui/endpoints_unified.json`.
- Reviewed backend route handlers in `src/Http/Routes/RouteRegistrar.php`.
- Checked service implementations backing these routes (`AuthService`, `KeyLifecycleService`, `PostsService`, `CommentsService`, `ModerationService`, `FeedService`) to judge whether each route is functionally implemented vs merely declared.

## Totals

- UI document defines **18 unique API endpoints** (method + path).
- Backend implements handlers for **all 18/18 endpoints** in `RouteRegistrar`.
- Strictly missing/non-functional endpoints from the UI list: **0**.
- Fully aligned with UI expected behavior: **16/18**.
- Implemented but contract-mismatched/partial: **2/18**.

## Endpoint-by-endpoint status

| UI endpoint | Backend route exists | Functional status | Notes |
|---|---:|---|---|
| POST `/api/auth/login` | Yes | ✅ Supported | Auth + validation implemented. |
| POST `/api/auth/key-login` | Yes | ✅ Supported | Key auth implemented via `KeyLifecycleService::keyLogin`. |
| POST `/console/owners` | Yes | ✅ Supported | Owner creation + conflict + validation implemented. |
| GET `/api/feed` | Yes | ✅ Supported | Cursor/limit/scope flow implemented in feed service. |
| POST `/api/posts` | Yes | ✅ Supported | Permission gates + validation + create implemented. |
| GET `/api/posts/{postId}` | Yes | ✅ Supported | Visibility and permission checks implemented. |
| PATCH `/api/posts/{postId}` | Yes | ✅ Supported | Edit permission + validation + revision implemented. |
| POST `/api/posts/{postId}/flags` | Yes | ⚠️ Partial | UI requires `reason_code` and expects 422 for validation; backend silently defaults reason and does not emit 422 for missing reason. |
| GET `/api/posts/{postId}/comments` | Yes | ✅ Supported | Post visibility checked; comments list returned. |
| POST `/api/posts/{postId}/comments` | Yes | ✅ Supported | Post-state/permission/toggle/validation gates implemented. |
| GET `/console/api/posts` | Yes | ✅ Supported | Author-scoped post list implemented. |
| POST `/console/api/posts` | Yes | ✅ Supported | Validation + create implemented. |
| POST `/console/api/posts/{postId}/moderation` | Yes | ✅ Supported | Action validation + moderation write implemented. |
| POST `/console/api/posts/{postId}/comments/{commentId}/moderation` | Yes | ⚠️ Partial | Route includes `{postId}` but backend moderates by `commentId` only; no post/comment relationship check. |
| POST `/console/api/keys` | Yes | ✅ Supported | Key issue flow and policy checks implemented. |
| POST `/console/api/keys/{keyId}/lifecycle` | Yes | ✅ Supported | Transition with 204/404/422 behavior implemented. |
| GET `/console/api/keychains` | Yes | ✅ Supported (placeholder) | Returns empty list; UI marks backend as placeholder. |
| POST `/console/api/invites` | Yes | ✅ Supported (lightweight) | Generates invite receipt; UI marks lightweight backend. |

## Bottom line requested by user

- **Endpoints currently supported by backend in expected functional way:** **16**
- **UI-specified endpoints not currently functional in backend API server:** **0**
- **UI-specified endpoints implemented but not fully matching expected contract:** **2**

