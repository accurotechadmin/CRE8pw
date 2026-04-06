# Error Code Catalog (SSOT)

_Last updated (UTC): 2026-04-06_

## Envelope-level canonical codes
| HTTP | code | Typical detail codes | Retryability | UI behavior |
|---|---|---|---|---|
| 400 | bad_request | malformed_json, non_object_json | no | show request fix guidance |
| 401 | auth_required / auth_invalid | missing_bearer, token_invalid, token_type_mismatch | conditional (after re-auth) | clear session, route to login |
| 403 | forbidden | csrf_invalid, permission_denied, use_key_restricted, comments_disabled | no | show policy explanation |
| 404 | not_found | post_not_found, comment_not_found, key_not_found | no | show not found panel |
| 409 | conflict | owner_exists, lifecycle_conflict | no | show conflict guidance |
| 422 | validation_failed | required, invalid_format, invalid_enum | no | inline field errors |
| 429 | rate_limited | limiter_exhausted | yes (later) | show retry-after hint |
| 500 | internal_error | unhandled_exception | yes | show generic error + request id |

## Mapping requirements
- Every error response must include `error.request_id`.
- UI must preserve correlation ID in inspector/panel.
- New detail codes require this catalog update in same PR.
