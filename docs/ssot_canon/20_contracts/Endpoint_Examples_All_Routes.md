# Endpoint Examples (All Routes)

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Provide concrete request/response examples for every v1 route so backend, frontend, QA, and tooling teams can implement and validate behavior without inferential gaps.

## Envelope conventions used in examples
- Success envelope shape: `{ data, meta }`.
- Error envelope shape: `{ error: { code, message, details, request_id }, meta }`.
- `meta.envelope_version` is always present.

## Human journey quick maps
- **Owner bootstrap journey:** owner receives invite -> registers owner account -> logs in -> governs keys/invites/moderation from console.
- **Delegated creator journey:** owner mints key -> delegated actor logs in via key-login -> uses gateway APIs or native parity UI.
- **Consumer journey:** use-class key reads feed and may comment where policy allows.

## Public + auth surfaces
### `GET /`
**Response 200**
```json
{
  "data": {"service": "cre8", "status": "ok"},
  "meta": {"envelope_version": "1", "timestamp_utc": "2026-04-09T00:00:00Z"}
}
```

### `GET /health`
**Response 200 (degraded sample)**
```json
{
  "data": {
    "status": "degraded",
    "checked_at_utc": "2026-04-09T00:00:00Z",
    "latency_ms": 24,
    "failures": ["http_dependency_exception"],
    "services": {
      "db": "ok",
      "rate_limiter": "ok",
      "key_material": "ok",
      "http_dependency": "degraded"
    }
  },
  "meta": {"envelope_version": "1", "timestamp_utc": "2026-04-09T00:00:00Z"}
}
```

### `GET /.well-known/jwks.json`
**Response 200**
```json
{"keys": [{"kty": "RSA", "kid": "k-2026-04", "alg": "RS256", "use": "sig", "n": "...", "e": "AQAB"}]}
```

### `POST /console/owners`
**Request**
```json
{"email": "owner@example.com", "password": "long-and-strong-passphrase", "invite_code": "INV-8F29KQ1M"}
```
**Response 201**
```json
{
  "data": {"owner_id": "own_123", "email": "owner@example.com"},
  "meta": {"envelope_version": "1"}
}
```

### `POST /api/auth/login`
**Request**
```json
{"email": "owner@example.com", "password": "long-and-strong-passphrase"}
```
**Response 200**
```json
{
  "data": {"access_token": "...", "refresh_token": "...", "token_type": "Bearer", "expires_in": 900},
  "meta": {"envelope_version": "1"}
}
```

### `POST /api/auth/key-login`
**Request**
```json
{"key_id": "key_abc", "api_key": "k_live_..."}
```
**Response 200**
```json
{
  "data": {"access_token": "...", "refresh_token": "...", "token_type": "Bearer", "expires_in": 600},
  "meta": {"envelope_version": "1"}
}
```

### `POST /api/auth/refresh`
**Request**
```json
{"refresh_token": "rfr_..."}
```
**Response 200**
```json
{
  "data": {"access_token": "...", "refresh_token": "...", "token_type": "Bearer", "expires_in": 600},
  "meta": {"envelope_version": "1"}
}
```

## Gateway surface
### `GET /api/feed`
**Response 200**
```json
{
  "data": {"items": [{"post_id": "pst_1", "title": "Hello", "scope": "public"}], "next_cursor": null},
  "meta": {"envelope_version": "1"}
}
```

### `POST /api/posts`
**Request**
```json
{"title": "Post title", "body": "Post body", "visibility_scope": "public"}
```
**Response 201**
```json
{
  "data": {"post_id": "pst_1", "state": "published"},
  "meta": {"envelope_version": "1"}
}
```

### `GET /api/posts/{postId}`
**Response 200**
```json
{
  "data": {"post_id": "pst_1", "title": "Post title", "body": "Post body", "state": "published"},
  "meta": {"envelope_version": "1"}
}
```

### `PATCH /api/posts/{postId}`
**Request**
```json
{"title": "Edited title", "reason_code": "author_edit"}
```
**Response 200**
```json
{"data": {"post_id": "pst_1", "revision_id": "rev_1"}, "meta": {"envelope_version": "1"}}
```

### `POST /api/posts/{postId}/flags`
**Request**
```json
{"reason_code": "abuse", "notes": "policy concern"}
```
**Response 201**
```json
{"data": {"flag_id": "flg_1"}, "meta": {"envelope_version": "1"}}
```

### `GET /api/posts/{postId}/comments`
**Response 200**
```json
{"data": {"items": [{"comment_id": "c_1", "body": "first"}]}, "meta": {"envelope_version": "1"}}
```

### `POST /api/posts/{postId}/comments`
**Request**
```json
{"body": "Nice post"}
```
**Response 201**
```json
{"data": {"comment_id": "c_2"}, "meta": {"envelope_version": "1"}}
```

## Console surface
### `GET /console/api/posts`
**Response 200**
```json
{"data": {"items": []}, "meta": {"envelope_version": "1"}}
```

### `POST /console/api/posts`
**Request**
```json
{"title": "Admin post", "body": "...", "visibility_scope": "org"}
```
**Response 201**
```json
{"data": {"post_id": "pst_2"}, "meta": {"envelope_version": "1"}}
```

### `GET /console/api/keychains`
**Response 200**
```json
{"data": {"items": [{"keychain_id": "kc_1", "member_count": 2}]}, "meta": {"envelope_version": "1"}}
```

### `POST /console/api/keychains`
**Request**
```json
{"name": "Editorial Keychain", "policy": {"permissions": ["posts:read", "posts:edit"]}}
```
**Response 201**
```json
{"data": {"keychain_id": "kc_1", "key_id": "key_kc_1"}, "meta": {"envelope_version": "1"}}
```

### `GET /console/api/keychains/{keychainId}/members`
**Response 200**
```json
{"data": {"items": [{"member_key_id": "key_2", "status": "active"}]}, "meta": {"envelope_version": "1"}}
```

### `POST /console/api/keychains/{keychainId}/members`
**Request**
```json
{"member_key_id": "key_2", "role_hint": "editor"}
```
**Response 201**
```json
{"data": {"membership_id": "km_1"}, "meta": {"envelope_version": "1"}}
```

### `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}`
**Response 200**
```json
{"data": {"removed": true}, "meta": {"envelope_version": "1"}}
```

### `GET /console/api/keychains/{keychainId}/resolve`
**Response 200**
```json
{
  "data": {
    "effective_permissions": ["posts:read", "posts:edit"],
    "effective_scope": {"visibility": ["org"]},
    "lineage": [{"member_key_id": "key_2", "status": "active"}]
  },
  "meta": {"envelope_version": "1"}
}
```

### `POST /console/api/invites`
**Request**
```json
{"email_target": "new.author@example.com", "expires_at": "2026-04-16T00:00:00Z"}
```
**Response 201**
```json
{"data": {"invite_id": "inv_1"}, "meta": {"envelope_version": "1"}}
```

### `POST /console/api/keys`
**Request**
```json
{
  "key_class": "secondary_author",
  "permissions": ["posts:read", "posts:create"],
  "scope": {"visibility": ["org"]},
  "expires_at": "2026-05-01T00:00:00Z"
}
```
**Response 201**
```json
{"data": {"key_id": "key_new", "api_key": "k_live_..."}, "meta": {"envelope_version": "1"}}
```

### `POST /console/api/keys/{keyId}/lifecycle`
**Request**
```json
{"action": "revoke", "reason_code": "compromised"}
```
**Response 200**
```json
{"data": {"key_id": "key_new", "status": "revoked"}, "meta": {"envelope_version": "1"}}
```

### `POST /console/api/posts/{postId}/moderation`
**Request**
```json
{"action": "hide", "reason_code": "policy_violation"}
```
**Response 200**
```json
{"data": {"post_id": "pst_1", "state": "hidden"}, "meta": {"envelope_version": "1"}}
```

### `POST /console/api/posts/{postId}/comments/{commentId}/moderation`
**Request**
```json
{"action": "remove", "reason_code": "abuse"}
```
**Response 200**
```json
{"data": {"comment_id": "c_1", "state": "removed"}, "meta": {"envelope_version": "1"}}
```

## Canonical negative-path example
### Any protected route with missing token
**Response 401**
```json
{
  "error": {
    "code": "auth_required",
    "message": "Authentication is required.",
    "details": {"surface": "gateway"},
    "request_id": "req_123"
  },
  "meta": {"envelope_version": "1"}
}
```

### Matched post route with missing post resource
**Response 404**
```json
{
  "error": {
    "code": "not_found",
    "message": "Requested post was not found.",
    "details": {"code": "post_not_found", "post_id": "pst_missing"},
    "request_id": "req_404_post"
  },
  "meta": {"envelope_version": "1"}
}
```

### Matched key route with missing key resource
**Response 404**
```json
{
  "error": {
    "code": "not_found",
    "message": "Requested key was not found.",
    "details": {"code": "key_not_found", "key_id": "key_missing"},
    "request_id": "req_404_key"
  },
  "meta": {"envelope_version": "1"}
}
```

### Device-binding mismatch on protected gateway route
**Response 401**
```json
{
  "error": {
    "code": "auth_invalid",
    "message": "Token is invalid for this device.",
    "details": {"code": "token_device_mismatch"},
    "request_id": "req_401_device"
  },
  "meta": {"envelope_version": "1"}
}
```

## Synchronization rule
Any route behavior, payload-shape, or error-semantics update must modify this file, `docs/ssot_canon/openapi/cre8.v1.yaml`, and `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` in the same PR.
