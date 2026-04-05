# Implementation Status (Living)

Updated: 2026-04-05 (UTC) — Session 12

Status legend: **not started** / **in progress** / **done**

## Phase Checklist (0–6)

- Phase 0 — Foundations (App shell + API client): **done**
  - App shell + nav + flash + inspector: **done** (`public/ui/index.html`, `public/ui/app.js`)
  - API client envelope/error normalization + request-id capture: **done** (`public/ui/api-client.js`)
  - Session store + clear session: **done** (`public/ui/state.js`, `public/ui/app.js`)
  - Global state primitives (full matrix idle/loading/submitting/success/validation_error/forbidden/not_found/server_error): **done** (`public/ui/app.js`)
- Phase 1 — Authentication & Session UX: **done**
- Phase 2 — Gateway Content Flows: **done**
- Phase 3 — Console Content & Moderation: **done**
- Phase 4 — Console Key Management: **done**
- Phase 5 — Cross-Flow Quality & A11y: **done**
- Phase 6 — QA Matrix & Release Readiness: **in progress** (execution attempted; blocked by missing dependencies/vendor autoload at runtime)

## Endpoint Coverage (18 endpoints)

1. `POST /api/auth/login` — **done** (UI form + session persist in `public/ui/app.js`)
2. `POST /api/auth/key-login` — **done** (UI form + session persist in `public/ui/app.js`)
3. `POST /console/owners` — **done** (UI form in `public/ui/app.js`)
4. `GET /api/feed` — **done** (feed page + cursor pagination in `public/ui/app.js`)
5. `POST /api/posts` — **done** (create form + guarded CTA in `public/ui/app.js`)
6. `GET /api/posts/{postId}` — **done** (post detail page in `public/ui/app.js`)
7. `PATCH /api/posts/{postId}` — **done** (edit form + permission guard in `public/ui/app.js`)
8. `POST /api/posts/{postId}/flags` — **done** (flag form + 422 mapping in `public/ui/app.js`)
9. `GET /api/posts/{postId}/comments` — **done** (comments page in `public/ui/app.js`)
10. `POST /api/posts/{postId}/comments` — **done** (comment create form + state/permission guard in `public/ui/app.js`)
11. `GET /console/api/posts` — **done** (console post list route in `public/ui/app.js`)
12. `POST /console/api/posts` — **done** (console post create form in `public/ui/app.js`)
13. `POST /console/api/posts/{postId}/moderation` — **done** (post moderation route + confirmation UX in `public/ui/app.js`)
14. `POST /console/api/posts/{postId}/comments/{commentId}/moderation` — **done** (comment moderation route + confirmation UX in `public/ui/app.js`)
15. `POST /console/api/keys` — **done** (key issue form + one-time secret reveal in `public/ui/app.js`)
16. `POST /console/api/keys/{keyId}/lifecycle` — **done** (lifecycle form + dangerous confirmation in `public/ui/app.js`)
17. `GET /console/api/keychains` — **done** (keychain list/empty state route in `public/ui/app.js`)
18. `POST /console/api/invites` — **done** (invite create + receipt panel in `public/ui/app.js`)

## Shared Infrastructure

- App shell (header/nav/flash/content): **done** (`public/ui/index.html`, `public/ui/app.js`)
- UI route asset serving under `/ui` (serves JS/CSS assets directly, SPA fallback for route paths): **done** (`src/Http/Routes/RouteRegistrar.php`)
- Security headers policy split (strict API CSP + UI-safe CSP for `/ui`): **done** (`src/Http/Middleware/SecurityHeadersMiddleware.php`)
- API client wrapper (JSON + envelope + errors): **done** (`public/ui/api-client.js`)
- API auth + `X-Device-Id` support for gateway flows: **done** (`public/ui/api-client.js`, `public/ui/state.js`)
- State model (session by owner/key surface): **done** (`public/ui/state.js`)
- Error mapping (401/403/404/409/422 explicit, fallback generic): **done** (`public/ui/app.js`)
- Dangerous-action confirmation primitive (moderation + lifecycle + invite): **done** (`public/ui/app.js`)
- Accessibility baseline (labels, aria-live, focus-management pass): **done** (`public/ui/index.html`, `public/ui/app.js`, `public/ui/styles.css`)
- QA matrix tracking artifact + endpoint evidence notes: **in progress** (`docs/dev/QA_MATRIX.md`)
- Role-based QA matrix + UAT script scaffold: **done** (`docs/dev/QA_MATRIX.md`)
- End-to-end endpoint execution against running backend: **not started** (blocked: backend bootstrap fails without `vendor/autoload.php`)

## Session References

- Session 1 implementation commit: `cea2d65`
- Session 2 implementation commit: `21baa64`

- Session 3 implementation commit: `work@HEAD`
- Session 4 implementation commit: `work@HEAD`
- Session 5 implementation commit: `work@HEAD`

- Session 6 implementation commit: `work@HEAD`
- Session 7 implementation commit: `work@HEAD`

- Session 8 implementation commit: `work@HEAD`

- Session 9 implementation commit: `work@HEAD`

- Session 10 implementation commit: `work@HEAD`

- Session 11 implementation commit: `work@HEAD`

- Session 12 implementation commit: `work@HEAD`
