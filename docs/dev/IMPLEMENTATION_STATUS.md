# Implementation Status (Living)

Updated: 2026-04-05 (UTC)

Status legend: **not started** / **in progress** / **done**

## Phase Checklist (0–6)

- Phase 0 — Foundations (App shell + API client): **in progress**
  - App shell + nav + flash + inspector: **done** (`public/ui/index.html`, `public/ui/app.js`)
  - API client envelope/error normalization + request-id capture: **done** (`public/ui/api-client.js`)
  - Session store + clear session: **done** (`public/ui/state.js`, `public/ui/app.js`)
  - Global state primitives (full matrix idle/loading/submitting/success/etc.): **in progress** (`public/ui/app.js`)
- Phase 1 — Authentication & Session UX: **in progress**
- Phase 2 — Gateway Content Flows: **not started**
- Phase 3 — Console Content & Moderation: **not started**
- Phase 4 — Console Key Management: **not started**
- Phase 5 — Cross-Flow Quality & A11y: **not started**
- Phase 6 — QA Matrix & Release Readiness: **not started**

## Endpoint Coverage (18 endpoints)

1. `POST /api/auth/login` — **done** (UI form + session persist in `public/ui/app.js`)
2. `POST /api/auth/key-login` — **done** (UI form + session persist in `public/ui/app.js`)
3. `POST /console/owners` — **done** (UI form in `public/ui/app.js`)
4. `GET /api/feed` — **not started**
5. `POST /api/posts` — **not started**
6. `GET /api/posts/{postId}` — **not started**
7. `PATCH /api/posts/{postId}` — **not started**
8. `POST /api/posts/{postId}/flags` — **not started**
9. `GET /api/posts/{postId}/comments` — **not started**
10. `POST /api/posts/{postId}/comments` — **not started**
11. `GET /console/api/posts` — **not started**
12. `POST /console/api/posts` — **not started**
13. `POST /console/api/posts/{postId}/moderation` — **not started**
14. `POST /console/api/posts/{postId}/comments/{commentId}/moderation` — **not started**
15. `POST /console/api/keys` — **not started**
16. `POST /console/api/keys/{keyId}/lifecycle` — **not started**
17. `GET /console/api/keychains` — **not started**
18. `POST /console/api/invites` — **not started**

## Shared Infrastructure

- App shell (header/nav/flash/content): **done** (`public/ui/index.html`, `public/ui/app.js`)
- API client wrapper (JSON + envelope + errors): **done** (`public/ui/api-client.js`)
- State model (session by owner/key surface): **done** (`public/ui/state.js`)
- Error mapping (401/409/422 explicit, fallback generic): **in progress** (`public/ui/app.js`)
- Accessibility baseline (labels, aria-live for flash/inspector): **in progress** (`public/ui/index.html`)
- QA matrix tracking artifact: **not started**

## Session References

- Current session implementation commit: `cea2d65`
