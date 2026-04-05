# FRONTEND ↔ BACKEND Integration Playbook (CRE8)

Date: 2026-04-05 (UTC)

## Implementation Progress Snapshot (Session 5)

- ✅ Auth/session baseline is live in `public/ui` (`/ui/login`, `/ui/key-login`, `/ui/signup-owner`).
- ✅ Gateway read slice implemented end-to-end for:
  - `GET /api/feed` (scope + limit + cursor pagination),
  - `GET /api/posts/{postId}`,
  - `GET /api/posts/{postId}/comments`.
- ✅ API client now injects bearer auth and `X-Device-Id` for gateway calls and preserves request-id inspection.
- ✅ Remaining Phase 2 write flows are now implemented in SPA routes:
  - `/posts/new` → `POST /api/posts`,
  - `/posts/{postId}/edit` → `PATCH /api/posts/{postId}`,
  - `/posts/{postId}/flag` → `POST /api/posts/{postId}/flags`,
  - `/posts/{postId}/comments/new` → `POST /api/posts/{postId}/comments`.
- ✅ Phase 3 console content/moderation slice is implemented end-to-end for:
  - `/console/posts` → `GET /console/api/posts`,
  - `/console/posts/new` → `POST /console/api/posts`,
  - `/console/posts/{postId}/moderation` → `POST /console/api/posts/{postId}/moderation`,
  - `/console/posts/{postId}/comments/{commentId}/moderation` → `POST /console/api/posts/{postId}/comments/{commentId}/moderation`.
- ✅ Phase 4 console key-management slice is now implemented end-to-end for:
  - `/console/keys/new` → `POST /console/api/keys`,
  - `/console/keys/{keyId}/lifecycle` → `POST /console/api/keys/{keyId}/lifecycle`,
  - `/console/keychains` → `GET /console/api/keychains`,
  - `/console/invites/new` → `POST /console/api/invites`.
- ✅ All `/console/api/*` routes now consistently use centralized owner bearer auth handling (`ownerRequest`) in the SPA.

## 1) Purpose

This document is the implementation-ready frontend integration guide for CRE8 backend APIs.

It includes:
- endpoint-by-endpoint integration details,
- concrete JSON request/response examples,
- auth/session handling matrix,
- exact UI error mapping,
- a plain JavaScript `fetch` wrapper skeleton aligned to backend behavior.

---

## 2) Global API Contract

### 2.1 Success envelope

Most successful responses are wrapped in a JSON envelope:

```json
{
  "data": { "...": "..." },
  "meta": {
    "envelope_version": "2026-04-03",
    "timestamp_utc": "2026-04-05T12:00:00Z"
  }
}
```

List endpoints include paging:

```json
{
  "data": [{ "id": "..." }],
  "paging": {
    "limit": 50,
    "cursor": "eyJjcmVhdGVkX2F0X3V0YyI6Ii4uLiIsImlkIjoiLi4uIn0",
    "has_more": true
  },
  "meta": {
    "envelope_version": "2026-04-03",
    "timestamp_utc": "2026-04-05T12:00:00Z"
  }
}
```

### 2.2 Error envelope

```json
{
  "error": {
    "code": "validation_failed",
    "message": "input validation failed",
    "details": [
      {
        "path": "email",
        "code": "invalid_format",
        "message": "must be a valid email",
        "detail_code": "validation_invalid_format"
      }
    ],
    "request_id": "11111111-1111-4111-8111-111111111111"
  },
  "meta": {
    "envelope_version": "2026-04-03",
    "timestamp_utc": "2026-04-05T12:00:00Z",
    "request_id": "11111111-1111-4111-8111-111111111111"
  }
}
```

### 2.3 Important headers

- `X-Request-Id` (always capture for debug/support)
- `X-Envelope-Version`
- CORS headers for allowed origins

---

## 3) Auth + Session Matrix

| Surface | Login | Access token claims | Protected routes | Extra requirement |
|---|---|---|---|---|
| Owner (console) | `POST /api/auth/login` | `typ=owner`, `aud=console` | `/console/api/*` | `Authorization: Bearer ...` |
| Key (gateway) | `POST /api/auth/key-login` | `typ=key`, `aud=gateway` | `/api/*` | `Authorization: Bearer ...` + `X-Device-Id` |
| Signup | `POST /console/owners` | none | public | none |

### 3.1 Session shape recommendation

```js
{
  activeSurface: "owner", // "owner" | "key" | null
  owner: {
    accessToken: "...",
    refreshToken: "...",
    expiresIn: 900,
    expiresAtMs: 0
  },
  key: {
    accessToken: "...",
    refreshToken: "...",
    expiresIn: 600,
    expiresAtMs: 0,
    keyId: "...",
    keyClass: "secondary_author",
    permissions: ["posts:read"],
    scope: ["posts:all"],
    commentsEnabled: false
  }
}
```

### 3.2 Refresh strategy

Use one endpoint for both surfaces:
- `POST /api/auth/refresh` with `{ "refresh_token": "..." }`

On `401`, clear session for active surface and route user to the correct login page.

---

## 4) Endpoint-by-Endpoint Playbook (18 UI endpoints)

## A. Authentication

### 1) `POST /api/auth/login`

**Request**
```json
{ "email": "owner@example.com", "password": "correct horse battery staple" }
```

**Success 200**
```json
{
  "data": {
    "access_token": "eyJ...",
    "refresh_token": "rft_...",
    "expires_in": 900
  }
}
```

**Common errors**
- `422 validation_failed`
- `401 auth_invalid`
- global: `429`, `400`, `415`, `500`

---

### 2) `POST /api/auth/key-login`

**Request**
```json
{ "key_id": "aabbccddeeff00112233445566778899", "api_key": "cre8k_..." }
```

**Success 200**
```json
{
  "data": {
    "access_token": "eyJ...",
    "refresh_token": "rft_...",
    "expires_in": 600,
    "key_id": "aabbccddeeff00112233445566778899",
    "key_class": "secondary_author",
    "permissions": ["posts:read"],
    "scope": ["posts:all"],
    "comments_enabled": false
  }
}
```

**Common errors**
- `422 validation_failed`
- `401 auth_invalid`
- global: `429`, `400`, `415`, `500`

---

### 3) `POST /console/owners`

**Request**
```json
{ "email": "owner@example.com", "password": "very-strong-password" }
```

**Success 201**
```json
{
  "data": {
    "owner_id": "f6af2d9ad8c84c82ad289a7438f9de12",
    "email": "owner@example.com",
    "created_at_utc": "2026-04-05T12:00:00Z"
  }
}
```

**Common errors**
- `422 validation_failed`
- `409 owner_conflict`
- global: `429`, `400`, `415`, `500`

---

## B. Gateway content

> All `/api/*` calls must send a valid `X-Device-Id` header.

### 4) `GET /api/feed`

**Query**: `scope`, `limit`, `cursor`

**Success 200**
```json
{
  "data": [
    {
      "id": "post1",
      "author_id": "key123",
      "visibility_scope": "public",
      "state": "published",
      "title": "Hello",
      "body": "World",
      "created_at_utc": "2026-04-05T10:00:00Z"
    }
  ],
  "paging": {
    "limit": 50,
    "cursor": "eyJjcmVhdGVkX2F0X3V0YyI6IjIwMjYtMDQtMDVUMTA6MDA6MDBaIiwiaWQiOiJwb3N0MSJ9",
    "has_more": true
  },
  "meta": {
    "envelope_version": "2026-04-03",
    "timestamp_utc": "2026-04-05T12:00:00Z"
  }
}
```

**Common errors**
- `401 auth_required/auth_invalid`
- `422 validation_failed` (`X-Device-Id` missing/invalid)
- `429`, `500`

---

### 5) `POST /api/posts`

**Request**
```json
{
  "title": "A title",
  "body": "A body",
  "visibility_scope": "delegated",
  "state": "published"
}
```

**Success 201** → created post in `data`.

**Common errors**
- `403 forbidden` (permission missing or `use` key restrictions)
- `422 validation_failed`
- `401`, `429`, `400`, `415`, `500`

---

### 6) `GET /api/posts/{postId}`

**Success 200** → post in `data`.

**Common errors**
- `404 not_found` (missing/deleted/invisible)
- `403 forbidden` (permission mask)
- `401`, `422` (device), `429`, `500`

---

### 7) `PATCH /api/posts/{postId}`

**Request**
```json
{
  "title": "Updated title",
  "body": "Updated body",
  "change_reason_code": "manual_edit"
}
```

**Success 200** → revised post in `data`.

**Common errors**
- `403 forbidden` (`posts:edit` missing)
- `404 not_found`
- `422 validation_failed`
- `401`, `429`, `400`, `415`, `500`

---

### 8) `POST /api/posts/{postId}/flags`

**Request**
```json
{ "reason_code": "spam" }
```

**Success 201**
```json
{ "data": { "post_id": "...", "flagged": true, "reason_code": "spam" } }
```

**Common errors**
- `404 not_found`
- `422 validation_failed` (reason required)
- `401`, `429`, `400`, `415`, `500`

---

### 9) `GET /api/posts/{postId}/comments`

**Success 200** → comment list in `data`.

**Common errors**
- `404 not_found` (post missing/invisible)
- `401`, `422` (device), `429`, `500`

---

### 10) `POST /api/posts/{postId}/comments`

**Request**
```json
{ "body": "Nice post" }
```

**Success 201** → created comment in `data`.

**Common errors**
- `404 not_found`
- `403 forbidden` for:
  - post state blocks comment creation,
  - missing `comments:create`,
  - `comments_enabled` false
- `422 validation_failed`
- `401`, `429`, `400`, `415`, `500`

---

## C. Console content + moderation

### 11) `GET /console/api/posts`

**Success 200** → author-scoped list envelope.

**Common errors**
- `401 auth_required/auth_invalid`
- `429`, `500`

---

### 12) `POST /console/api/posts`

**Request**
```json
{
  "title": "Console post",
  "body": "Body",
  "visibility_scope": "private",
  "state": "published"
}
```

**Success 201** → created post.

**Common errors**
- `422 validation_failed`
- `401`, `429`, `400`, `415`, `500`

---

### 13) `POST /console/api/posts/{postId}/moderation`

**Request**
```json
{ "action": "hide", "reason_code": "policy_violation" }
```

**Success 200**
```json
{
  "data": {
    "id": "...",
    "state": "hidden",
    "action": "hide",
    "reason_code": "policy_violation",
    "moderated_at_utc": "2026-04-05T12:00:00Z"
  }
}
```

**Common errors**
- `422 validation_failed` (unsupported action)
- `404 not_found`
- `401`, `429`, `400`, `415`, `500`

---

### 14) `POST /console/api/posts/{postId}/comments/{commentId}/moderation`

**Request**
```json
{ "action": "delete", "reason_code": "abuse" }
```

**Success 200** → moderated comment payload.

**Common errors**
- `422 validation_failed`
- `404 not_found`
- `401`, `429`, `400`, `415`, `500`

---

## D. Console key management

### 15) `POST /console/api/keys`

**Request**
```json
{
  "key_class": "secondary_author",
  "parent_envelope_id": null,
  "permissions": ["posts:read", "comments:create"],
  "scope": ["posts:all"],
  "ttl_seconds": 900,
  "comments_enabled": true
}
```

**Success 201**
```json
{
  "data": {
    "id": "new-key-id",
    "key_class": "secondary_author",
    "api_key": "cre8k_...",
    "delegation_envelope_id": "env-id",
    "parent_envelope_id": null,
    "permissions": ["posts:read", "comments:create"],
    "scope": ["posts:all"],
    "depth": 0,
    "comments_enabled": true,
    "initial_author_key_id": "new-key-id",
    "expires_at_utc": "2026-04-05T12:15:00Z"
  }
}
```

**Common errors**
- `422 validation_failed` (ttl/delegation/subset/etc.)
- `403 forbidden` (delegation ownership/issue constraints)
- `401`, `429`, `400`, `415`, `500`

---

### 16) `POST /console/api/keys/{keyId}/lifecycle`

**Request**
```json
{ "state": "revoke" }
```

**Success 204**
```json
{ "data": null }
```

**Common errors**
- `422 validation_failed` (state unsupported)
- `404 not_found`
- `401`, `429`, `400`, `415`, `500`

---

### 17) `GET /console/api/keychains`

**Success 200**
```json
{
  "data": [],
  "paging": { "limit": 50, "cursor": null, "has_more": false },
  "meta": { "envelope_version": "2026-04-03", "timestamp_utc": "2026-04-05T12:00:00Z" }
}
```

**Common errors**
- `401`, `429`, `500`

---

### 18) `POST /console/api/invites`

**Success 201**
```json
{
  "data": {
    "invite_id": "f26e7d...",
    "status": "created",
    "created_at_utc": "2026-04-05T12:00:00Z"
  }
}
```

**Common errors**
- `401`, `429`, `400`, `415`, `500`

---

## 5) UI Error-State Mapping

| HTTP | Primary UI state | UI behavior |
|---|---|---|
| `401` | `forbidden` / `auth_required` | Clear active surface session, show reauth prompt, preserve editable form data where safe. |
| `403` | `forbidden` | Show policy-specific message from `detail_code`/`reason`; disable blocked CTAs. |
| `404` | `not_found` | Show missing/invisible resource state and navigation fallback. |
| `409` | `validation_error` / conflict | Show conflict banner (notably owner already exists). |
| `422` | `validation_error` | Render inline per-field errors from `error.details[]`. |
| `429` | `server_error` (rate-limit variant) | Show retry notice/countdown (if `retry_after` present), keep form data. |
| `5xx` | `server_error` | Show generic server error with request-id and retry action. |

### 5.1 Detail code conventions to surface directly

Examples commonly returned by middleware/routes:
- `validation_body_not_object`
- `json_malformed`
- `content_type_unsupported`
- `device_id_missing`
- `device_id_invalid_format`
- `token_audience_invalid`
- `token_type_invalid`
- `token_policy_violation`
- `rate_limit_exceeded`
- `use_key_post_create_forbidden`
- `use_key_key_mutation_forbidden`

---

## 6) Plain JavaScript Fetch Wrapper Skeleton

```js
// apiClient.js

const API_BASE = window.__CRE8_API_BASE__ || "";

function nowMs() {
  return Date.now();
}

function makeDeviceId() {
  const key = "cre8_device_id";
  let v = localStorage.getItem(key);
  if (!v) {
    // backend expects 8..128 chars, [a-zA-Z0-9_.:-]
    v = `web.${Math.random().toString(36).slice(2)}.${Date.now()}`;
    localStorage.setItem(key, v);
  }
  return v;
}

export const sessionStore = {
  state: {
    activeSurface: null, // "owner" | "key" | null
    owner: null,
    key: null,
  },

  setOwner(tokens) {
    this.state.owner = {
      ...tokens,
      expiresAtMs: nowMs() + ((tokens.expires_in || 0) * 1000),
    };
    this.state.activeSurface = "owner";
  },

  setKey(tokens) {
    this.state.key = {
      ...tokens,
      expiresAtMs: nowMs() + ((tokens.expires_in || 0) * 1000),
    };
    this.state.activeSurface = "key";
  },

  clear(surface = null) {
    if (!surface) {
      this.state.owner = null;
      this.state.key = null;
      this.state.activeSurface = null;
      return;
    }
    this.state[surface] = null;
    if (this.state.activeSurface === surface) this.state.activeSurface = null;
  },

  getActiveAccessToken() {
    const s = this.state.activeSurface;
    if (!s || !this.state[s]) return null;
    return this.state[s].access_token || this.state[s].accessToken || null;
  },

  getActiveRefreshToken() {
    const s = this.state.activeSurface;
    if (!s || !this.state[s]) return null;
    return this.state[s].refresh_token || this.state[s].refreshToken || null;
  }
};

function mapUiState(status, errorCode) {
  if (status === 401) return "forbidden";
  if (status === 403) return "forbidden";
  if (status === 404) return "not_found";
  if (status === 409) return "validation_error";
  if (status === 422) return "validation_error";
  if (status === 429) return "server_error";
  if (status >= 500) return "server_error";
  if (errorCode === "validation_failed") return "validation_error";
  return "server_error";
}

async function tryParseJson(res) {
  const text = await res.text();
  if (!text) return null;
  try { return JSON.parse(text); } catch { return null; }
}

async function refreshActiveSession() {
  const refreshToken = sessionStore.getActiveRefreshToken();
  if (!refreshToken) return false;

  const res = await fetch(`${API_BASE}/api/auth/refresh`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ refresh_token: refreshToken }),
  });

  const payload = await tryParseJson(res);
  if (!res.ok || !payload?.data) return false;

  if (sessionStore.state.activeSurface === "owner") {
    sessionStore.setOwner(payload.data);
  } else if (sessionStore.state.activeSurface === "key") {
    sessionStore.setKey(payload.data);
  }

  return true;
}

export async function apiFetch(path, {
  method = "GET",
  body,
  auth = "auto", // "none" | "owner" | "key" | "auto"
  retryOn401 = true,
  headers = {},
} = {}) {
  const upperMethod = method.toUpperCase();
  const isJsonBodyMethod = ["POST", "PATCH", "PUT", "DELETE"].includes(upperMethod);
  const isGateway = path.startsWith("/api/");

  const reqHeaders = new Headers(headers);

  if (isJsonBodyMethod && !reqHeaders.has("Content-Type")) {
    reqHeaders.set("Content-Type", "application/json");
  }

  // Auth token injection
  const active = auth === "auto" ? sessionStore.state.activeSurface : auth;
  if (active === "owner" || active === "key") {
    const token = active === "owner"
      ? (sessionStore.state.owner?.access_token || sessionStore.state.owner?.accessToken)
      : (sessionStore.state.key?.access_token || sessionStore.state.key?.accessToken);

    if (token) reqHeaders.set("Authorization", `Bearer ${token}`);
  }

  // Gateway device-id requirement
  if (isGateway && !reqHeaders.has("X-Device-Id")) {
    reqHeaders.set("X-Device-Id", makeDeviceId());
  }

  const res = await fetch(`${API_BASE}${path}`, {
    method: upperMethod,
    headers: reqHeaders,
    body: body == null ? undefined : JSON.stringify(body),
  });

  const requestId = res.headers.get("X-Request-Id") || null;
  const payload = await tryParseJson(res);

  if (res.ok) {
    return {
      ok: true,
      status: res.status,
      requestId,
      data: payload?.data ?? null,
      paging: payload?.paging ?? null,
      meta: payload?.meta ?? null,
      raw: payload,
    };
  }

  // Optional one-time refresh on 401
  if (res.status === 401 && retryOn401 && (auth === "auto" || auth === "owner" || auth === "key")) {
    const refreshed = await refreshActiveSession();
    if (refreshed) {
      return apiFetch(path, { method, body, auth, retryOn401: false, headers });
    }

    // hard clear current surface on refresh failure
    sessionStore.clear(sessionStore.state.activeSurface);
  }

  const error = payload?.error || {};

  return {
    ok: false,
    status: res.status,
    requestId: error.request_id || requestId,
    uiState: mapUiState(res.status, error.code),
    error: {
      code: error.code || "unknown_error",
      message: error.message || "Request failed",
      details: error.details || [],
    },
    raw: payload,
  };
}
```

---

## 7) Suggested Frontend Usage Pattern

```js
import { apiFetch, sessionStore } from "./apiClient.js";

async function submitOwnerLogin(email, password) {
  const result = await apiFetch("/api/auth/login", {
    method: "POST",
    auth: "none",
    body: { email, password },
  });

  if (!result.ok) return result;

  sessionStore.setOwner(result.data);
  return { ok: true };
}

async function loadFeed() {
  return apiFetch("/api/feed?scope=delegated&limit=50", {
    method: "GET",
    auth: "key",
  });
}
```

---

## 8) QA Checklist for UI Integration

- [ ] All 18 routes wired in frontend nav/pages.
- [ ] Every mutating request sends `Content-Type: application/json`.
- [ ] Every `/api/*` request includes `X-Device-Id`.
- [ ] `X-Request-Id` displayed in debug panel for failures.
- [ ] `401/403/404/409/422/429/5xx` map to deterministic UI states.
- [ ] Inline rendering for `error.details[]` on `422`.
- [ ] Session clear + reauth prompt on refresh failure.
- [ ] Keychains page handles empty list gracefully.
