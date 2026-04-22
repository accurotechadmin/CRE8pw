# Error Code Catalog (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-21_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Envelope-level canonical codes
| HTTP | code | Typical detail codes | Retryability | UI behavior |
|---|---|---|---|---|
| 400 | bad_request | malformed_json, non_object_json, invalid_argument | no | show request fix guidance |
| 401 | auth_required / auth_invalid | missing_bearer, token_invalid, token_type_invalid, token_audience_invalid, token_expired, token_device_mismatch | conditional (after re-auth) | clear session, route to login |
| 403 | forbidden | csrf_token_missing, csrf_token_malformed, csrf_token_mismatch, permission_denied, use_key_restricted, comments_disabled | no | show policy explanation |
| 404 | not_found | post_not_found, comment_not_found, key_not_found, keychain_not_found | no | show not found panel |
| 405 | method_not_allowed | route_method_not_allowed | no | show unsupported-action guidance |
| 415 | unsupported_media_type | content_type_unsupported | no | show content-type guidance |
| 409 | conflict | owner_exists, lifecycle_conflict | no | show conflict guidance |
| 422 | validation_failed | required, invalid_format, invalid_enum, out_of_range, device_id_missing, device_id_invalid_format | no | inline field errors |
| 429 | rate_limited | rate_limit_exceeded | yes (later) | show retry-after hint |
| 500 | internal_error | unhandled_exception | yes | show generic error + request id |

## Canonical middleware/handler detail-code registry (v1 baseline)
| Surface area | Detail code | Expected HTTP/code |
|---|---|---|
| Error handler | `route_not_found` (unmatched template only) | `404 not_found` |
| Error handler | `route_method_not_allowed` | `405 method_not_allowed` |
| Error handler | `http_unauthorized` | `401 auth_invalid` |
| Error handler | `invalid_argument` | `400 bad_request` |
| Error handler | `domain_validation` | `422 validation_failed` |
| Error handler | `unhandled_exception` | `500 internal_error` |
| JSON body | `content_type_unsupported` | `415 unsupported_media_type` |
| JSON body | `malformed_json` | `400 bad_request` |
| JSON body | `json_root_not_object` | `400 bad_request` |
| CSRF | `csrf_token_missing` | `403 forbidden` |
| CSRF | `csrf_token_malformed` | `403 forbidden` |
| CSRF | `csrf_token_mismatch` | `403 forbidden` |
| Device guard | `device_id_missing` | `422 validation_failed` |
| Device guard | `device_id_invalid_format` | `422 validation_failed` |
| Rate limit | `rate_limit_exceeded` | `429 rate_limited` |
| Gateway policy | `use_key_post_create_forbidden` | `403 forbidden` |
| Gateway policy | `use_key_key_mutation_forbidden` | `403 forbidden` |
| Token policy | `token_type_invalid` | `401 auth_invalid` |
| Token policy | `token_audience_invalid` | `401 auth_invalid` |
| Token policy | `token_device_mismatch` | `401 auth_invalid` |
| Domain resolver | `post_not_found` | `404 not_found` |
| Domain resolver | `comment_not_found` | `404 not_found` |
| Domain resolver | `key_not_found` | `404 not_found` |
| Domain resolver | `keychain_not_found` | `404 not_found` |

## Mapping requirements
- Every error response must include `error.request_id`.
- UI must preserve correlation ID in inspector/panel.
- New detail codes require this catalog update in same PR.
- Detail-code behavior must remain consistent with `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` and `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`.
