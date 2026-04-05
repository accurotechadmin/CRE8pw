# Backend vs UI Endpoint Parity Report

Date: 2026-04-05 (UTC)

## Scope and verification approach

- Parsed all UI `api_calls` from `ui/endpoints_unified.json` (18 page contracts, each with one API call).
- Compared each UI `(method, endpoint)` pair to registered backend routes in `src/Http/Routes/RouteRegistrar.php`.
- Reviewed backing service calls inside each route to determine whether behavior is implemented (not just declared).
- Considered UI-declared placeholder/lightweight contracts as **functionally supported** when backend behavior matches that expectation.

## Totals

- UI endpoints specified: **18**
- Backend endpoints with matching route + implemented behavior: **18**
- UI endpoints missing or not currently functional in backend: **0**

## Endpoint support matrix

| # | UI endpoint (method + path) | Backend status | Functional notes |
|---|---|---|---|
| 1 | `POST /api/auth/login` | ✅ Supported | Validates email/password; issues tokens via `AuthService::login`. |
| 2 | `POST /api/auth/key-login` | ✅ Supported | Validates key credentials; issues key-based token set via `KeyLifecycleService::keyLogin`. |
| 3 | `POST /console/owners` | ✅ Supported | Owner signup flow with validation and conflict handling via `AuthService::registerOwner`. |
| 4 | `GET /api/feed` | ✅ Supported | Scope/limit/cursor feed listing via `FeedService::list`. |
| 5 | `POST /api/posts` | ✅ Supported | Permission-gated create flow with payload validation via `PostsService::create`. |
| 6 | `GET /api/posts/{postId}` | ✅ Supported | Read flow with visibility and permission checks via `PostsService::find`. |
| 7 | `PATCH /api/posts/{postId}` | ✅ Supported | Permission-gated edit with required fields and revision via `PostsService::revise`. |
| 8 | `POST /api/posts/{postId}/flags` | ✅ Supported | Requires `reason_code`; flags via `PostsService::flag`. |
| 9 | `GET /api/posts/{postId}/comments` | ✅ Supported | Visibility-checked comment thread listing via `CommentsService::listForPost`. |
| 10 | `POST /api/posts/{postId}/comments` | ✅ Supported | State + permission + toggle guarded comment creation via `CommentsService::create`. |
| 11 | `GET /console/api/posts` | ✅ Supported | Author-scoped post list via `PostsService::listForAuthor`. |
| 12 | `POST /console/api/posts` | ✅ Supported | Console post creation with validation via `PostsService::create`. |
| 13 | `POST /console/api/posts/{postId}/moderation` | ✅ Supported | Validates action and applies moderation via `ModerationService::moderatePost`. |
| 14 | `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | ✅ Supported | Validates action and moderates comment via `ModerationService::moderateComment`. |
| 15 | `POST /console/api/keys` | ✅ Supported | Key issuance with policy enforcement via `KeyLifecycleService::issue`. |
| 16 | `POST /console/api/keys/{keyId}/lifecycle` | ✅ Supported | Lifecycle transition endpoint via `KeyLifecycleService::transition`. |
| 17 | `GET /console/api/keychains` | ✅ Supported (placeholder) | Returns empty list, which matches UI page purpose marked as backend placeholder. |
| 18 | `POST /console/api/invites` | ✅ Supported (lightweight) | Returns generated invite receipt, matching UI lightweight receipt contract. |

## Requested answer

- **Endpoints currently supported by backend in expected functional way:** **18**
- **UI-specified endpoints that are not currently functional in backend API server:** **0**
