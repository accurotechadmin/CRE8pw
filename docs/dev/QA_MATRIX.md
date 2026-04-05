# CRE8 UI QA Matrix (Phase 6 Seed)

Updated: 2026-04-05 (UTC) — Session 7

Status legend: ☐ pending / ☑ completed

## Endpoint-by-endpoint checks (18)

### 1) `POST /api/auth/login`
- Happy: ☐ Valid owner email/password returns tokens and redirects to owner surface.
- Negative: ☐ Invalid credentials return `401 auth_invalid` and error flash.
- Negative: ☐ Invalid payload returns `422 validation_failed` with field-level messages.

### 2) `POST /api/auth/key-login`
- Happy: ☐ Valid key credentials return key claims and route to `/feed`.
- Negative: ☐ Invalid credentials return `401 auth_invalid`.
- Negative: ☐ Invalid key_id format returns `422` with inline field errors.

### 3) `POST /console/owners`
- Happy: ☐ Valid owner signup returns created owner payload.
- Negative: ☐ Duplicate email returns `409 owner_conflict`.
- Negative: ☐ Invalid email/password returns `422` field errors.

### 4) `GET /api/feed`
- Happy: ☐ Authenticated key session loads list and supports cursor pagination.
- Negative: ☐ Missing/expired key token returns `401` and clears session.
- Negative: ☐ Forbidden scope returns `403` and forbidden state panel.

### 5) `POST /api/posts`
- Happy: ☐ Key with `posts:create` and non-`use` class creates post and redirects.
- Negative: ☐ Missing permission/class mismatch returns `403` guard + API failure mapping.
- Negative: ☐ Missing title/body returns `422` inline field errors.

### 6) `GET /api/posts/{postId}`
- Happy: ☐ Existing visible post renders metadata and action links.
- Negative: ☐ Unknown post id returns `404` not-found state.
- Negative: ☐ Unauthorized scope returns `403` forbidden state.

### 7) `PATCH /api/posts/{postId}`
- Happy: ☐ Key with `posts:edit` updates post and returns to detail.
- Negative: ☐ Missing edit permission blocked by guard or `403` mapping.
- Negative: ☐ Validation error (`422`) renders field errors.

### 8) `POST /api/posts/{postId}/flags`
- Happy: ☐ Valid reason code submits and returns success flash.
- Negative: ☐ Missing reason code yields `422` field error.
- Negative: ☐ Unknown post returns `404` state panel.

### 9) `GET /api/posts/{postId}/comments`
- Happy: ☐ Existing comments list renders with navigation links.
- Negative: ☐ Missing post returns `404` state panel.
- Negative: ☐ Forbidden access returns `403` state panel.

### 10) `POST /api/posts/{postId}/comments`
- Happy: ☐ Enabled key with `comments:create` posts comment and redirects.
- Negative: ☐ Comments toggle off or permission missing returns `403` mapped error.
- Negative: ☐ Post state blocked (`locked|archived|hidden|deleted`) is pre-guarded and/or `403`.

### 11) `GET /console/api/posts`
- Happy: ☐ Owner session loads list and moderation links.
- Negative: ☐ Missing owner session renders forbidden/login-required panel.
- Negative: ☐ Backend error returns server_error state with retry.

### 12) `POST /console/api/posts`
- Happy: ☐ Owner creates console post; list refreshes.
- Negative: ☐ Missing required fields returns `422` errors.
- Negative: ☐ Expired owner token returns `401` and session clear.

### 13) `POST /console/api/posts/{postId}/moderation`
- Happy: ☐ Confirmed moderation action succeeds with summary + flash.
- Negative: ☐ Submit without confirmation checkbox blocked client-side.
- Negative: ☐ Missing post id returns `404` mapped moderation error.

### 14) `POST /console/api/posts/{postId}/comments/{commentId}/moderation`
- Happy: ☐ Confirmed comment moderation succeeds.
- Negative: ☐ Missing confirmation is blocked client-side.
- Negative: ☐ Unknown comment id returns `404` mapped error.

### 15) `POST /console/api/keys`
- Happy: ☐ Valid payload issues key and displays one-time secret panel.
- Negative: ☐ `use` class without `parent_envelope_id` blocked by validation.
- Negative: ☐ Delegation policy violation returns `403` mapped console message.

### 16) `POST /console/api/keys/{keyId}/lifecycle`
- Happy: ☐ Confirmed lifecycle transition succeeds and locks repeat submissions.
- Negative: ☐ Missing checkbox blocks submit.
- Negative: ☐ Revoke without typed `CONFIRM` blocks submit.

### 17) `GET /console/api/keychains`
- Happy: ☐ Owner session loads rows or empty-state messaging.
- Negative: ☐ Missing/expired owner session returns `401` and login-required state.
- Negative: ☐ Backend failure returns server_error state + retry.

### 18) `POST /console/api/invites`
- Happy: ☐ Confirmed submit creates invite and shows receipt.
- Negative: ☐ Missing confirmation checkbox blocks submit.
- Negative: ☐ Owner auth failure returns mapped error state.

## Cross-cutting QA focus areas
- Accessibility keyboard pass: ☐ Verify tab order, skip-link behavior, and focus targets after submit/errors.
- Route-state consistency: ☐ Verify each route surfaces state legend with active status.
- Dangerous actions: ☐ Confirm moderation/lifecycle/invite all use shared confirmation pattern.
- Error envelope mapping: ☐ Verify `401|403|404|409|422|5xx` mappings + response inspector request id.
