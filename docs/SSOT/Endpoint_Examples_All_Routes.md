# Endpoint Examples — All Routes

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

> Examples are normative for shape and semantics; IDs/timestamps are illustrative.

## Public/bootstrap/auth

### GET /
```http
GET /
```
```json
{"data":{"service":"cre8","status":"ok"},"meta":{"envelope_version":"1","timestamp_utc":"2026-04-06T00:00:00Z"}}
```

### GET /health
```json
{"data":{"status":"ok","checked_at_utc":"2026-04-06T00:00:00Z","latency_ms":12,"failures":[],"services":{"db":{"status":"ok"},"rate_limiter":{"status":"ok"},"key_material":{"status":"ok"},"http_dependency":{"status":"ok","status_code":200}}},"meta":{"envelope_version":"1"}}
```

### GET /.well-known/jwks.json
```json
{"keys":[{"kty":"RSA","kid":"abc123","alg":"RS256","use":"sig","n":"...","e":"AQAB"}]}
```

### POST /console/owners
Request:
```json
{"email":"owner@example.com","password":"StrongPassphrase123!"}
```
Response 201:
```json
{"data":{"owner_id":"own_123"},"meta":{"envelope_version":"1"}}
```

### POST /api/auth/login
```json
{"email":"owner@example.com","password":"StrongPassphrase123!"}
```
```json
{"data":{"access_token":"...","refresh_token":"...","expires_in":900},"meta":{"envelope_version":"1"}}
```

### POST /api/auth/key-login
```json
{"key_id":"key_123","api_key":"cre8k_secret"}
```
```json
{"data":{"access_token":"...","refresh_token":"...","expires_in":600},"meta":{"envelope_version":"1"}}
```

### POST /api/auth/refresh
```json
{"refresh_token":"..."}
```
```json
{"data":{"access_token":"...","refresh_token":"...","expires_in":600},"meta":{"envelope_version":"1"}}
```

## Gateway routes
### GET /api/feed
```http
GET /api/feed?scope=public&limit=20&cursor=abc
Authorization: Bearer <key-jwt>
X-Device-Id: dev_001
```
```json
{"data":[{"id":"post_1","title":"Hello"}],"meta":{"paging":{"next_cursor":"def"}}}
```

### POST /api/posts
```json
{"title":"Hello","body":"World","visibility_scope":"public"}
```

### PATCH /api/posts/{postId}
```json
{"title":"Updated title","reason_code":"typo_fix"}
```

### POST /api/posts/{postId}/flags
```json
{"reason_code":"policy_violation","notes":"spam"}
```

### GET /api/posts/{postId}
```json
{"data":{"id":"post_1","title":"Hello","body":"World","state":"published"},"meta":{}}
```

### GET /api/posts/{postId}/comments
```json
{"data":[{"id":"c1","body":"nice","state":"active"}],"meta":{}}
```

### POST /api/posts/{postId}/comments
```json
{"body":"Great post"}
```

## Console routes
### GET /console/api/posts
```json
{"data":[{"id":"post_1","state":"published"}],"meta":{}}
```

### POST /console/api/posts
```json
{"title":"Operator note","body":"...","visibility_scope":"private"}
```

### GET /console/api/keychains
```json
{"data":[{"key_id":"kc_1","members":3}],"meta":{}}
```


### POST /console/api/keychains
```json
{"name":"Research Team Aggregate","ttl_seconds":2592000}
```
```json
{"data":{"keychain_id":"kc_101","key_class":"keychain"},"meta":{"envelope_version":"1"}}
```

### GET /console/api/keychains/{keychainId}/members
```json
{"data":[{"member_key_id":"key_a1","status":"active"}],"meta":{"envelope_version":"1"}}
```

### POST /console/api/keychains/{keychainId}/members
```json
{"member_key_id":"key_a1"}
```
```json
{"data":{"keychain_id":"kc_101","member_key_id":"key_a1","status":"active"},"meta":{"envelope_version":"1"}}
```

### DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}
```json
{"data":{"keychain_id":"kc_101","member_key_id":"key_a1","status":"removed"},"meta":{"envelope_version":"1"}}
```

### GET /console/api/keychains/{keychainId}/resolve
```json
{"data":{"keychain_id":"kc_101","effective_permissions":["posts:read","comments:create"],"effective_scope":["posts:all"],"member_count":3},"meta":{"envelope_version":"1"}}
```

### POST /console/api/invites
```json
{"email":"member@example.com","expires_at":"2026-04-07T00:00:00Z"}
```

### POST /console/api/keys
```json
{"key_class":"secondary_author","permissions":["posts:read"],"scope":["posts:all"],"ttl_seconds":86400}
```

### POST /console/api/keys/{keyId}/lifecycle
```json
{"action":"suspend","cascade":"none","reason_code":"investigation"}
```

### POST /console/api/posts/{postId}/moderation
```json
{"action":"hide","reason_code":"abuse"}
```

### POST /console/api/posts/{postId}/comments/{commentId}/moderation
```json
{"action":"delete","reason_code":"harassment"}
```
