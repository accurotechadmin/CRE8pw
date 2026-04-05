# Session Ledger

## Session 2026-04-05T00:00:00Z (UTC)

- **Branch/commit**: `work` @ `cea2d65`
- **Scope chosen**:
  - Implement the next high-priority vertical slice: Phase 0 foundations + Phase 1 auth flows for first 3 endpoints.
  - Deliver end-to-end UI for owner login, key login, and owner signup with session persistence + error mapping.
- **Files changed**:
  - `public/ui/index.html`
  - `public/ui/styles.css`
  - `public/ui/app.js`
  - `public/ui/api-client.js`
  - `public/ui/state.js`
  - `src/Http/Routes/RouteRegistrar.php`
  - `docs/dev/IMPLEMENTATION_STATUS.md`
  - `docs/dev/DECISIONS.md`
  - `docs/dev/SESSION_LEDGER.md`
- **Decisions made (rationale)**:
  - Chose a static no-build SPA in `public/ui` to unblock immediate endpoint integration without framework/tooling setup overhead.
  - Added `/ui[/{route:.*}]` backend route to serve SPA entrypoint so deep links and refresh work.
  - Standardized client-side error normalization from envelope and HTTP status to keep page code simple.
- **Tests/checks run and outcomes**:
  - `php -l src/Http/Routes/RouteRegistrar.php` ✅ pass
  - `php -l public/index.php` ✅ pass
  - `./vendor/bin/phpunit tests/Contract/RouteRegistrarContractsTest.php` ⚠️ could not run (`vendor/bin/phpunit` missing in environment)
- **Open issues/blockers**:
  - Local test runner dependencies (`vendor`) unavailable, so automated contract test execution is blocked in this environment.
- **Assumptions recorded**:
  - Assumed static assets under `/public/ui` are acceptable for phased delivery and can be evolved incrementally.
  - Assumed preserving existing `/` JSON health payload behavior is important; UI mounted at `/ui` instead.
- **Recommended next session starting point**:
  - Implement Phase 2 read flows (`GET /api/feed`, `GET /api/posts/{postId}`, `GET /api/posts/{postId}/comments`) with auth header + `X-Device-Id` injection and pagination support.

## Session 2026-04-05T01:00:00Z (UTC)

- **Branch/commit**: `work` @ `21baa64`
- **Scope chosen**:
  - Implement Phase 2 gateway read vertical slice end-to-end.
  - Cover `GET /api/feed`, `GET /api/posts/{postId}`, and `GET /api/posts/{postId}/comments` with linked UI flows.
  - Add centralized bearer + `X-Device-Id` support in API client for gateway calls.
- **Files changed**:
  - `public/ui/app.js`
  - `public/ui/api-client.js`
  - `public/ui/state.js`
  - `public/ui/styles.css`
  - `FRONTEND_BACKEND_INTEGRATION_PLAYBOOK.md`
  - `UI_IMPLEMENTATION_PLAN.md`
  - `docs/dev/IMPLEMENTATION_STATUS.md`
  - `docs/dev/DECISIONS.md`
  - `docs/dev/SESSION_LEDGER.md`
- **Decisions made (rationale)**:
  - Added dynamic route matching in the SPA so `/posts/{postId}` and `/posts/{postId}/comments` are deep-linkable and refresh-safe under `/ui`.
  - Introduced `gatewayRequest()` helper in app layer to enforce key-surface auth and consistent 401 handling.
  - Persisted generated device id in `localStorage` to satisfy required `X-Device-Id` behavior across gateway requests.
- **Tests/checks run and outcomes**:
  - `node --check public/ui/app.js` ✅ pass
  - `node --check public/ui/api-client.js` ✅ pass
  - `node --check public/ui/state.js` ✅ pass
  - `php -l src/Http/Routes/RouteRegistrar.php` ✅ pass
- **Open issues/blockers**:
  - Automated browser-level UI execution is not available in this environment, so verification is limited to static checks.
- **Assumptions recorded**:
  - Assumed feed read endpoint remains key-authenticated and should enforce key session before page rendering.
  - Assumed single persistent generated device id per browser profile is acceptable for integration/operator workflow.
- **Recommended next session starting point**:
  - Implement remaining Phase 2 write flows (`POST /api/posts`, `PATCH /api/posts/{postId}`, `POST /api/posts/{postId}/flags`, `POST /api/posts/{postId}/comments`) with permission- and state-aware CTA guards.
