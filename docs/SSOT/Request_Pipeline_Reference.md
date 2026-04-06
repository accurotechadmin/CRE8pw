# Request Pipeline Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Global middleware order
1. RequestId
2. SecurityHeaders (path-aware CSP)
3. CORS
4. RateLimit
5. Validation
6. JsonBody
7. RoutingMarker
8. CSRF (applicable console writes)
9. Surface middleware (owner/key/device/use-key)
10. Route handler + service

## Standard rejection outcomes
- 400 `bad_request`
- 401 `auth_required|auth_invalid`
- 403 `forbidden`
- 404 `not_found`
- 409 `conflict`
- 422 `validation_failed`
- 429 `rate_limited`
- 500 `internal_error`

All errors include envelope `error` + `meta` and `X-Request-Id`.
