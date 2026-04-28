# UI Runtime Contract (SSOT Appendix)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Capture implementation-grade SPA runtime conventions that are required to deliver deterministic UI/API parity behavior in the production no-build UI model.

## Session and device persistence contract
- Session storage key: `cre8_ui_session_v1`
- Device ID storage key: `cre8_ui_device_id_v1`
- Session model includes explicit `activeSurface` and per-surface tokens/context.
- Gateway calls requiring device policy attach persisted device ID in `X-Device-Id`.
- Device-bound JWTs must contain `device_id` claim equal to `X-Device-Id` for protected gateway requests.

## API client behavior contract
- Envelope-aware JSON parsing for all routes.
- Normalized error object containing status/code/message/details/request_id.
- Resolve `request_id` from response header and/or envelope.
- Expose envelope version for diagnostics where available.
- Preserve `details.code` without lossy mapping; UI state machine uses canonical detail codes.

## Surface BFF orchestration contract
- Gateway UI routes call gateway API endpoints orchestrated by Gateway BFF modules.
- Console UI routes call console API endpoints orchestrated by Console BFF modules.
- UI runtime behavior remains contract-driven by canonical status, envelope, and detail-code semantics regardless of internal BFF orchestration.
- UI parity validation treats BFF internals as non-authoritative; API contract and envelope semantics are authoritative.
- Gateway feed route states are orchestrated by Gateway BFF feed flow components without changing canonical response semantics for `GET /api/feed`.
- Gateway post route states are orchestrated by Gateway BFF posts flow components without changing canonical response semantics for `POST /api/posts`, `GET/PATCH /api/posts/{postId}`, and `POST /api/posts/{postId}/flags`.
- Gateway comments route states are orchestrated by Gateway BFF comments flow components without changing canonical response semantics for `GET/POST /api/posts/{postId}/comments`.
- Console posts route states are orchestrated by Console BFF posts-governance flow components without changing canonical response semantics for `GET/POST /console/api/posts`.
- Console moderation route states are orchestrated by Console BFF moderation flow components without changing canonical response semantics for `POST /console/api/posts/{postId}/moderation` and `POST /console/api/posts/{postId}/comments/{commentId}/moderation`.
- Console keychain route states are orchestrated by Console BFF keychain-governance flow components without changing canonical response semantics for keychain list/create/member/resolve route families.
- Console invite and key-governance route states are orchestrated by Console BFF governance flow components without changing canonical response semantics for `POST /console/api/invites`, `POST /console/api/keys`, and `POST /console/api/keys/{keyId}/lifecycle`.
- Gateway read-route states use actor/scope-aware cache entries for `GET /api/feed` and `GET /api/posts/{postId}/comments` only; cache hits and misses preserve the same canonical envelope/detail-code semantics as uncached responses.
- Console inventory route states use short-TTL owner-scoped cache entries for `GET /console/api/posts`, `GET /console/api/keychains`, and `GET /console/api/keychains/{keychainId}/members`; cached entries are never reused across owner principals.

- Route-state transitions for migrated gateway and console route families are emitted only from canonical surface BFF orchestration paths; superseded orchestration paths are removed from runtime execution.
- UI runtime parity verification includes a dead-path audit that confirms no route-state branch depends on superseded non-BFF orchestration modules.


## Surface error-state mapper contract
- Gateway BFF error-state mapper preserves canonical envelope semantics and canonical `details.code` values for all gateway responses.
- Gateway BFF error-state mapper translates canonical error semantics into gateway UI route-state transitions without introducing non-canonical error codes.
- Console BFF error-state mapper preserves canonical envelope semantics and canonical `details.code` values for all console responses.
- Console BFF error-state mapper attaches deterministic UI-runtime-compatible recovery hints for owner-governance flows (including CSRF/session recovery), while preserving canonical HTTP/envelope/detail-code behavior.
- Console CSRF recovery hints are emitted only when canonical CSRF detail codes are present and map to deterministic UI actions: refresh CSRF token, retry write request, or re-authenticate owner session.
- Console CSRF recovery hints do not add or replace detail codes and do not change state mapping precedence (`403 forbidden` remains authoritative).
- Gateway and console error-state mappers are isolated by surface and do not share surface-specific rendering hints.

## Route-state runtime model
Canonical required states:
- `idle`
- `loading`
- `submitting`
- `success`
- `validation_error`
- `forbidden`
- `not_found`
- `server_error`

Optional substates (implementation convenience):
- `validating`
- `empty`
- `auth_required`
- `rate_limited`

## Endpoint parity matrix: gateway + console

### Gateway surface
| API route | UI route | Success state | Error-state mapping | Notes |
|---|---|---|---|---|
| `GET /api/feed` | `/feed` | `success` or `empty` | `401 -> auth_required`, `403 -> forbidden`, `429 -> rate_limited`, `500 -> server_error` | Uses key JWT + device binding checks. |
| `POST /api/posts` | `/posts/new` | `success` | `401 -> auth_required`, `403 -> forbidden`, `422 -> validation_error`, `429 -> rate_limited`, `500 -> server_error` | Use-key mutation guard must map to forbidden explanation panel. |
| `GET /api/posts/{postId}` | `/posts/{postId}` | `success` | `404(post_not_found) -> not_found`, `401/403 -> forbidden/auth_required`, `500 -> server_error` | Resource-specific 404 required. |
| `PATCH /api/posts/{postId}` | `/posts/{postId}/edit` | `success` | `404(post_not_found) -> not_found`, `403 -> forbidden`, `422 -> validation_error`, `500 -> server_error` | Route maintains optimistic concurrency UX where implemented. |
| `POST /api/posts/{postId}/flags` | `/posts/{postId}/flag` | `success` | `404(post_not_found) -> not_found`, `422 -> validation_error`, `500 -> server_error` | Confirm modal required before submit. |
| `GET /api/posts/{postId}/comments` | `/posts/{postId}/comments` | `success` or `empty` | `404(post_not_found) -> not_found`, `401/403 -> auth_required/forbidden`, `500 -> server_error` | Distinguish empty comments from post missing. |
| `POST /api/posts/{postId}/comments` | `/posts/{postId}/comments/new` | `success` | `404(post_not_found) -> not_found`, `403(comments_disabled) -> forbidden`, `422 -> validation_error`, `500 -> server_error` | Comment-disabled must remain `forbidden`, not validation. |

### Console surface
| API route | UI route | Success state | Error-state mapping | Notes |
|---|---|---|---|---|
| `GET /console/api/posts` | `/console/posts` | `success` or `empty` | `401 -> auth_required`, `403 -> forbidden`, `500 -> server_error` | Owner session only. Route family is orchestrated by Console BFF posts-governance flow components. |
| `POST /console/api/posts` | `/console/posts/new` | `success` | `401 -> auth_required`, `403 -> forbidden`, `422 -> validation_error`, `500 -> server_error` | CSRF failures map to forbidden with deterministic CSRF recovery hints (`refresh_csrf`, `retry_write`, `re_auth_owner_session`). Route family is orchestrated by Console BFF posts-governance flow components. |
| `GET /console/api/keychains` | `/console/keychains` | `success` or `empty` | `401 -> auth_required`, `403 -> forbidden`, `500 -> server_error` | Includes membership counts and status badges. Route family is orchestrated by Console BFF keychain-governance flow components. |
| `POST /console/api/keychains` | `/console/keychains/new` | `success` | `401 -> auth_required`, `403 -> forbidden`, `422 -> validation_error`, `409 -> validation_error`, `500 -> server_error` | Conflict path renders duplicate-name/invariant guidance. Route family is orchestrated by Console BFF keychain-governance flow components. |
| `GET /console/api/keychains/{keychainId}/members` | `/console/keychains/{id}` | `success` or `empty` | `404(keychain_not_found) -> not_found`, `401/403 -> auth_required/forbidden`, `500 -> server_error` | Membership list and audit metadata must render together. Route family is orchestrated by Console BFF keychain-governance flow components. |
| `POST /console/api/keychains/{keychainId}/members` | `/console/keychains/{id}/add-member` | `success` | `404(keychain_not_found|key_not_found) -> not_found`, `409 -> validation_error`, `422 -> validation_error`, `500 -> server_error` | Prevent nested-keychain invariant errors via inline form hints. Route family is orchestrated by Console BFF keychain-governance flow components. |
| `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}` | `/console/keychains/{id}` | `success` | `404(keychain_not_found|key_not_found) -> not_found`, `401/403 -> auth_required/forbidden`, `500 -> server_error` | UI must refetch effective summary after delete success. Route family is orchestrated by Console BFF keychain-governance flow components. |
| `GET /console/api/keychains/{keychainId}/resolve` | `/console/keychains/{id}/resolve` | `success` | `404(keychain_not_found) -> not_found`, `401/403 -> auth_required/forbidden`, `500 -> server_error` | Render resolved permissions + lineage provenance. Route family is orchestrated by Console BFF keychain-governance flow components. |
| `POST /console/api/invites` | `/console/invites/new` | `success` | `401 -> auth_required`, `403 -> forbidden`, `422 -> validation_error`, `500 -> server_error` | One-shot invite material shown once then redacted. Route family is orchestrated by Console BFF governance flow components. |
| `POST /console/api/keys` | `/console/keys/new` | `success` | `401 -> auth_required`, `403 -> forbidden`, `422 -> validation_error`, `500 -> server_error` | Delegation envelope preview required pre-submit. Route family is orchestrated by Console BFF governance flow components. |
| `POST /console/api/keys/{keyId}/lifecycle` | `/console/keys/{keyId}/lifecycle` | `success` | `404(key_not_found) -> not_found`, `409 -> validation_error`, `422 -> validation_error`, `500 -> server_error` | Lifecycle transitions require post-action audit refresh. Route family is orchestrated by Console BFF governance flow components. |
| `POST /console/api/posts/{postId}/moderation` | `/console/moderation/posts/{postId}` | `success` | `404(post_not_found) -> not_found`, `409 -> validation_error`, `422 -> validation_error`, `500 -> server_error` | Transition matrix drives button availability. Route family is orchestrated by Console BFF moderation flow components. |
| `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | `/console/moderation/posts/{postId}/comments/{commentId}` | `success` | `404(post_not_found|comment_not_found) -> not_found`, `409/422 -> validation_error`, `500 -> server_error` | Post/comment correlation displayed in moderation drawer. Route family is orchestrated by Console BFF moderation flow components. |

## Diagnostics UX minimums
- Request inspector or equivalent diagnostics panel must expose:
  - status code,
  - request_id,
  - parsed envelope payload including `meta.envelope_version` when present.
- Error-state screens must preserve request_id visibility for support triage.

## Security/UX guardrails
- Owner routes must bind to owner session context.
- Gateway routes must bind to key session context + device header/JWT claim parity policy.
- UI pre-checks may reduce avoidable forbidden submissions but backend remains source-of-truth.

## Accessibility/runtime baseline
- Keyboard-navigable route transitions.
- Focus management after major state transitions.
- Explicit route-state visibility for async/error flows.

## Related SSOT docs
- `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
- `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
- `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`
- `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
