# CRE8 UI QA Matrix (Phase 6 Execution)

Updated: 2026-04-05 (UTC) — Session 8

Status legend:
- ✅ pass
- ❌ fail
- ⚠️ blocked (environment/dependency)

## Execution context

- Attempted backend startup command: `php -S 127.0.0.1:8081 -t public`.
- Result: startup process immediately crashes on first request because `vendor/autoload.php` is missing.
- Evidence:
  - `GET /` → `500` with fatal boot error.
  - server log shows: `Failed opening required '/workspace/cre8w/public/../vendor/autoload.php'`.
- Dependency install attempt (`composer install --no-interaction --prefer-dist`) was blocked by network policy (`curl error 56 ... CONNECT tunnel failed, response 403`).

> Consequence: endpoint-level runtime verification is blocked until dependencies are installable in this environment.

## Endpoint-by-endpoint checks (18)

### 1) `POST /api/auth/login`
- Happy: ❌ fail (blocked boot). Evidence: `POST /api/auth/login` could not be dispatched; backend dies before routing (`vendor/autoload.php` missing).
- Negative: ❌ fail (blocked boot). Evidence: route-level auth checks unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: validation middleware unreachable due bootstrap failure.

### 2) `POST /api/auth/key-login`
- Happy: ❌ fail (blocked boot). Evidence: `POST /api/auth/key-login` unreachable because bootstrap fails prior to route dispatch.
- Negative: ❌ fail (blocked boot). Evidence: cannot validate `401 auth_invalid`; app fails at autoload stage.
- Negative: ❌ fail (blocked boot). Evidence: cannot validate `422` field mapping; app fails at autoload stage.

### 3) `POST /console/owners`
- Happy: ❌ fail (blocked boot). Evidence: `POST /console/owners` unreachable due missing vendor autoloader.
- Negative: ❌ fail (blocked boot). Evidence: duplicate-email flow cannot execute while boot fails.
- Negative: ❌ fail (blocked boot). Evidence: payload validation cannot execute while boot fails.

### 4) `GET /api/feed`
- Happy: ❌ fail (blocked boot). Evidence: `GET /api/feed` cannot reach middleware/handler due autoload failure.
- Negative: ❌ fail (blocked boot). Evidence: 401/session-clear scenario untestable while app cannot boot.
- Negative: ❌ fail (blocked boot). Evidence: 403 scope scenario untestable while app cannot boot.

### 5) `POST /api/posts`
- Happy: ❌ fail (blocked boot). Evidence: `POST /api/posts` blocked by bootstrap failure before endpoint.
- Negative: ❌ fail (blocked boot). Evidence: permission/class guard cannot be exercised.
- Negative: ❌ fail (blocked boot). Evidence: 422 validation rendering cannot be exercised.

### 6) `GET /api/posts/{postId}`
- Happy: ❌ fail (blocked boot). Evidence: route unavailable while autoloader missing.
- Negative: ❌ fail (blocked boot). Evidence: cannot verify `404 not_found` mapping without runnable app.
- Negative: ❌ fail (blocked boot). Evidence: cannot verify `403 forbidden` mapping without runnable app.

### 7) `PATCH /api/posts/{postId}`
- Happy: ❌ fail (blocked boot). Evidence: patch route unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: edit-permission guard cannot be exercised.
- Negative: ❌ fail (blocked boot). Evidence: 422 path cannot be exercised.

### 8) `POST /api/posts/{postId}/flags`
- Happy: ❌ fail (blocked boot). Evidence: flag route unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: missing reason validation cannot execute.
- Negative: ❌ fail (blocked boot). Evidence: not-found mapping cannot execute.

### 9) `GET /api/posts/{postId}/comments`
- Happy: ❌ fail (blocked boot). Evidence: comments list route unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: not-found scenario cannot be validated.
- Negative: ❌ fail (blocked boot). Evidence: forbidden scenario cannot be validated.

### 10) `POST /api/posts/{postId}/comments`
- Happy: ❌ fail (blocked boot). Evidence: comment create route unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: comments toggle/permission behavior untestable.
- Negative: ❌ fail (blocked boot). Evidence: blocked-state behavior untestable.

### 11) `GET /console/api/posts`
- Happy: ❌ fail (blocked boot). Evidence: owner console list route unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: login-required panel behavior cannot be runtime-validated.
- Negative: ❌ fail (blocked boot). Evidence: server_error retry behavior cannot be runtime-validated.

### 12) `POST /console/api/posts`
- Happy: ❌ fail (blocked boot). Evidence: create route unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: 422 mapping cannot be validated.
- Negative: ❌ fail (blocked boot). Evidence: 401 expiration handling cannot be validated.

### 13) `POST /console/api/posts/{postId}/moderation`
- Happy: ❌ fail (blocked boot). Evidence: moderation endpoint unreachable due bootstrap failure.
- Negative: ⚠️ blocked (client-side only). Evidence: confirmation-checkbox blocking remains statically implemented in UI; backend action unverified.
- Negative: ❌ fail (blocked boot). Evidence: `404` mapping cannot be runtime-validated.

### 14) `POST /console/api/posts/{postId}/comments/{commentId}/moderation`
- Happy: ❌ fail (blocked boot). Evidence: comment moderation endpoint unreachable due bootstrap failure.
- Negative: ⚠️ blocked (client-side only). Evidence: confirmation-checkbox blocking remains statically implemented in UI; backend action unverified.
- Negative: ❌ fail (blocked boot). Evidence: unknown-comment mapping cannot be runtime-validated.

### 15) `POST /console/api/keys`
- Happy: ❌ fail (blocked boot). Evidence: key issue endpoint unreachable due bootstrap failure.
- Negative: ⚠️ blocked (client-side only). Evidence: form validation rules present in UI but endpoint cannot be invoked.
- Negative: ❌ fail (blocked boot). Evidence: delegation policy enforcement cannot be runtime-validated.

### 16) `POST /console/api/keys/{keyId}/lifecycle`
- Happy: ❌ fail (blocked boot). Evidence: lifecycle endpoint unreachable due bootstrap failure.
- Negative: ⚠️ blocked (client-side only). Evidence: checkbox gating implemented in UI but backend call unverified.
- Negative: ⚠️ blocked (client-side only). Evidence: typed `CONFIRM` gating implemented in UI but backend call unverified.

### 17) `GET /console/api/keychains`
- Happy: ❌ fail (blocked boot). Evidence: keychains endpoint unreachable due bootstrap failure.
- Negative: ❌ fail (blocked boot). Evidence: missing/expired owner session handling untestable end-to-end.
- Negative: ❌ fail (blocked boot). Evidence: backend failure retry behavior untestable end-to-end.

### 18) `POST /console/api/invites`
- Happy: ❌ fail (blocked boot). Evidence: invite endpoint unreachable due bootstrap failure.
- Negative: ⚠️ blocked (client-side only). Evidence: confirmation checkbox gating implemented in UI but backend call unverified.
- Negative: ❌ fail (blocked boot). Evidence: owner auth failure mapping untestable end-to-end.

## Role-based matrix

| Role | Auth Surface | Result | Evidence |
|---|---|---|---|
| owner-admin | owner JWT (`/console/api/*`) | ❌ fail (blocked boot) | could not execute `/api/auth/login` or `/console/api/posts`; boot fails before auth middleware. |
| key-operator | key JWT + `X-Device-Id` (`/api/*`) | ❌ fail (blocked boot) | could not execute `/api/auth/key-login` or `/api/feed`; boot fails before routing. |
| limited key | key JWT minimal perms (`/api/*`) | ❌ fail (blocked boot) | cannot validate permission-denied workflows because server cannot boot. |

## UAT script (prepared for rerun once backend is unblocked)

1. Owner logs in via `/ui/login`, confirms `/ui/console/posts` loads.
2. Owner creates console post, then performs post moderation action with confirmation flow.
3. Owner issues key via `/ui/console/keys/new` and stores one-time secret.
4. Key user logs in via `/ui/key-login`, opens `/ui/feed`, and loads post detail/comments.
5. Key user creates post/comment according to permission envelope.
6. Limited key attempts forbidden action (`/ui/posts/new` or edit route) and confirms 403 UX mapping.
7. Owner runs key lifecycle transition with typed `CONFIRM` for revoke.
8. Owner creates invite and verifies receipt UI.

## Cross-cutting QA focus areas

- Accessibility keyboard pass: ⚠️ blocked (manual browser/UAT pending runnable backend).
- Route-state consistency: ⚠️ blocked (runtime transitions pending runnable backend).
- Dangerous actions: ⚠️ blocked (client-side guards present; end-to-end confirmation pending runnable backend).
- Error envelope mapping: ⚠️ blocked (requires live API responses with request IDs).
