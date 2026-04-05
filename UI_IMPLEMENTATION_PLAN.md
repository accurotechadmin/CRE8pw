# CRE8 UI Implementation Plan (Endpoint-Coverage Complete)

Date: 2026-04-05 (UTC)

## Current Delivery Snapshot (Session 3)

- Phases 0–1 are functionally implemented in the current static SPA (`public/ui`).
- Phase 2 is now complete for gateway read/write flows:
  - `/feed` → `GET /api/feed` with cursor pagination.
  - `/posts/new` → `POST /api/posts`.
  - `/posts/{postId}` → `GET /api/posts/{postId}`.
  - `/posts/{postId}/edit` → `PATCH /api/posts/{postId}`.
  - `/posts/{postId}/flag` → `POST /api/posts/{postId}/flags`.
  - `/posts/{postId}/comments` → `GET /api/posts/{postId}/comments`.
  - `/posts/{postId}/comments/new` → `POST /api/posts/{postId}/comments`.
- Feed-to-post-to-comments navigation now includes guarded write entry points based on key claims and known post state constraints.
- Remaining phase work continues per the checklist below.

## 1) Objective

Implement a browser-based HTML interface that allows users to view and interact with every UI-specified API endpoint in `ui/endpoints_unified.json`.

Success criteria:
1. Every endpoint in the UI contract has at least one usable page/flow.
2. Every page supports success, loading, validation, and error states.
3. Console and gateway auth contexts are supported cleanly.
4. The interface can be used for day-to-day operator workflows and API validation.

---

## 2) Endpoint Inventory to Cover

The UI contract defines 18 endpoint interactions to support:

1. `POST /api/auth/login`
2. `POST /api/auth/key-login`
3. `POST /console/owners`
4. `GET /api/feed`
5. `POST /api/posts`
6. `GET /api/posts/{postId}`
7. `PATCH /api/posts/{postId}`
8. `POST /api/posts/{postId}/flags`
9. `GET /api/posts/{postId}/comments`
10. `POST /api/posts/{postId}/comments`
11. `GET /console/api/posts`
12. `POST /console/api/posts`
13. `POST /console/api/posts/{postId}/moderation`
14. `POST /console/api/posts/{postId}/comments/{commentId}/moderation`
15. `POST /console/api/keys`
16. `POST /console/api/keys/{keyId}/lifecycle`
17. `GET /console/api/keychains`
18. `POST /console/api/invites`

---

## 3) Delivery Strategy (Phased)

### Phase 0 — Foundations (App shell + API client)

Deliverables:
- HTML app shell with persistent header, nav, flash/toast region, and content pane.
- Central API client (fetch wrapper) handling:
  - bearer token injection,
  - JSON parsing,
  - response envelope normalization,
  - error mapping (`401/403/404/409/422/5xx`),
  - request-id capture from responses.
- Session store for:
  - owner token set,
  - key token set,
  - active auth surface (`owner` vs `key`),
  - token expiration metadata.
- Global state primitives:
  - `idle`, `loading`, `submitting`, `success`, `empty`, `validation_error`, `forbidden`, `not_found`, `server_error`.

Direct support elements:
- Global nav links for all pages.
- Login status chip + active principal scope/permissions chip row.
- “Clear session” action.

Indirect support elements:
- Reusable field-level validation renderer.
- Reusable response inspector panel (status, payload, request ID) for operator/debug use.
- Reusable confirmation modal for destructive actions.

### Phase 1 — Authentication & Session UX

Endpoints covered:
- `POST /api/auth/login`
- `POST /api/auth/key-login`
- `POST /console/owners`

Pages:
1. `/login` (owner login)
2. `/key-login` (gateway key login)
3. `/signup-owner` (initial owner creation)

Direct support elements:
- Form fields with required validation.
- Submit/loading states and disabled CTA rules.
- 422 mapping to inline field errors.
- 401/409 banner-level messaging.
- Success redirects to feed or console based on role/surface.

Indirect support elements:
- Session hydration on page reload.
- “Auth mode switcher” links between owner and key login.
- Safe secret handling (password/api key never echoed in UI logs).

### Phase 2 — Gateway Content Flows (Read/Write Posts + Comments)

Endpoints covered:
- `GET /api/feed`
- `POST /api/posts`
- `GET /api/posts/{postId}`
- `PATCH /api/posts/{postId}`
- `POST /api/posts/{postId}/flags`
- `GET /api/posts/{postId}/comments`
- `POST /api/posts/{postId}/comments`

Pages:
1. `/feed`
2. `/posts/new`
3. `/posts/{postId}`
4. `/posts/{postId}/edit`
5. `/posts/{postId}/flag`
6. `/posts/{postId}/comments`
7. `/posts/{postId}/comments/new`

Direct support elements:
- Feed list with cursor pagination and scope controls.
- Post create/edit forms with required `title/body` validation.
- Post detail metadata panel (visibility, state, author).
- Flag form with `reason_code` required.
- Comment list and create form with empty/thread states.

Indirect support elements:
- Permission-aware CTA visibility (`posts:create`, `posts:edit`, `comments:create`).
- State-aware guards (locked/archived/hidden/deleted post behavior).
- Retry affordances on transient errors.
- Linking helpers between feed -> post -> comments.

### Phase 3 — Console Content & Moderation Flows

Endpoints covered:
- `GET /console/api/posts`
- `POST /console/api/posts`
- `POST /console/api/posts/{postId}/moderation`
- `POST /console/api/posts/{postId}/comments/{commentId}/moderation`

Pages:
1. `/console/posts`
2. `/console/posts/new`
3. `/console/posts/{postId}/moderation`
4. `/console/posts/{postId}/comments/{commentId}/moderation`

Direct support elements:
- Console post listing (author-scoped list table).
- Console create form (same core fields + console hints).
- Moderation action pickers with reason code support.
- Confirm-before-submit for moderation actions.

Indirect support elements:
- Audit-friendly action summaries before confirmation.
- Decision outcome banners (e.g., hidden/locked/deleted).
- Context breadcrumbing: post -> comment -> moderation action.

### Phase 4 — Console Key Management Flows

Endpoints covered:
- `POST /console/api/keys`
- `POST /console/api/keys/{keyId}/lifecycle`
- `GET /console/api/keychains`
- `POST /console/api/invites`

Pages:
1. `/console/keys/new`
2. `/console/keys/{keyId}/lifecycle`
3. `/console/keychains`
4. `/console/invites/new`

Direct support elements:
- Key issue form:
  - key class,
  - parent envelope (optional),
  - permissions,
  - scope,
  - TTL,
  - comments toggle.
- Lifecycle transition form (`active`, `suspended`, `revoked`, etc. per backend rules).
- Keychains list placeholder state (empty-list friendly UX).
- Invite create action + generated invite receipt display.

Indirect support elements:
- One-time secret display handling (copy/download affordance where applicable).
- Dangerous-action confirmation for lifecycle transitions.
- Placeholder messaging strategy for keychains until richer backend support exists.

### Phase 5 — Cross-Flow Quality, Accessibility, and Hardening

Deliverables:
- Accessibility pass:
  - semantic headings,
  - labels/aria for all form controls,
  - keyboard-only navigation,
  - focus management after submit/errors.
- Design-system consistency:
  - shared components (input, button, banner, table, modal, status chip).
- Error resilience:
  - consistent 401 handling (reauth prompt),
  - 403 forbidden states,
  - 404 resource states,
  - 422 details rendering.
- Security hygiene:
  - no token leakage in UI logs,
  - avoid persisting sensitive values in query params,
  - clear session on logout and auth failures where needed.

### Phase 6 — QA Matrix & Release Readiness

Deliverables:
- Endpoint-by-endpoint QA checklist (18/18).
- Role-based test matrix:
  - owner-admin,
  - key-operator,
  - limited-permission key.
- Negative test coverage:
  - validation failures,
  - auth failures,
  - forbidden actions,
  - missing resources,
  - backend error simulation.
- UAT script for operators (happy path + recoverable failures).

---

## 4) Endpoint-to-Page Mapping Table

| Endpoint | Primary Page | Secondary Navigation Touchpoints |
|---|---|---|
| `POST /api/auth/login` | `/login` | Header auth menu |
| `POST /api/auth/key-login` | `/key-login` | Header auth menu |
| `POST /console/owners` | `/signup-owner` | First-run onboarding |
| `GET /api/feed` | `/feed` | Post detail links |
| `POST /api/posts` | `/posts/new` | Feed “create post” CTA |
| `GET /api/posts/{postId}` | `/posts/{postId}` | Feed item clickthrough |
| `PATCH /api/posts/{postId}` | `/posts/{postId}/edit` | Post detail “edit” CTA |
| `POST /api/posts/{postId}/flags` | `/posts/{postId}/flag` | Post detail “flag” CTA |
| `GET /api/posts/{postId}/comments` | `/posts/{postId}/comments` | Post detail comment CTA |
| `POST /api/posts/{postId}/comments` | `/posts/{postId}/comments/new` | Comment thread “add comment” |
| `GET /console/api/posts` | `/console/posts` | Console nav |
| `POST /console/api/posts` | `/console/posts/new` | Console posts page CTA |
| `POST /console/api/posts/{postId}/moderation` | `/console/posts/{postId}/moderation` | Console post row action |
| `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | `/console/posts/{postId}/comments/{commentId}/moderation` | Comment row action |
| `POST /console/api/keys` | `/console/keys/new` | Console nav |
| `POST /console/api/keys/{keyId}/lifecycle` | `/console/keys/{keyId}/lifecycle` | Key details/actions menu |
| `GET /console/api/keychains` | `/console/keychains` | Console nav |
| `POST /console/api/invites` | `/console/invites/new` | Console nav |

---

## 5) Required UI Support Components

### A) Direct components (user-facing per endpoint)
- Auth forms (owner/key/signup).
- Feed list + filters.
- Post create/edit/detail panels.
- Flag modal/form.
- Comment thread list + composer.
- Console post table + moderation forms.
- Key issue/lifecycle forms.
- Keychains data grid (initially empty-state capable).
- Invite generation panel + copy-to-clipboard receipt.

### B) Indirect components (cross-cutting)
- API client with interceptors.
- Centralized form validation utilities.
- Shared envelope/error parser.
- Permission and feature guards.
- Reusable empty/error/loading state components.
- Notification/toast infrastructure.
- Audit/debug response inspector (dev/admin mode).
- Route guards for auth surface and role.

---

## 6) Use Cases to Validate End-to-End

1. **Owner first-run onboarding**
   - Signup owner -> login -> navigate console/gateway successfully.

2. **Gateway operator content lifecycle**
   - Key login -> create post -> open post -> edit post -> review in feed.

3. **Community safety workflow**
   - View post/comments -> submit flag -> owner moderates post/comment.

4. **Console key governance workflow**
   - Issue key -> change lifecycle state -> verify access behavior.

5. **Collaboration bootstrap workflow**
   - Create invite -> display/copy receipt -> communicate invite metadata.

---

## 7) Implementation Sequencing (Detailed Team Tasks)

1. **Initialize frontend project skeleton**
   - Define routing, page layout, base styles, and shared state store.

2. **Build API integration layer first**
   - Implement typed request functions for all 18 endpoints.
   - Add unified response/error transformation.

3. **Ship auth pages and guards**
   - Implement login/key-login/signup-owner.
   - Add route protection and post-login redirects.

4. **Ship gateway read flows**
   - Feed + post detail + comments list pages.

5. **Ship gateway write flows**
   - Post create/edit + flag + comment create.

6. **Ship console content flows**
   - Console posts list/create + post/comment moderation pages.

7. **Ship console key flows**
   - Key issue + lifecycle + keychains + invites.

8. **Harden UX and accessibility**
   - Keyboard/focus/a11y pass, consistent microcopy and status messaging.

9. **Execute QA matrix and release gate**
   - Validate all endpoints, all role contexts, and all major error states.

---

## 8) Definition of Done (DoD)

- 18/18 endpoints are accessible through HTML UI interactions.
- All pages implement loading, success, empty (where applicable), and error states.
- Validation errors are field-mapped where backend returns 422 details.
- Role/permission restrictions are represented in both UX controls and response handling.
- QA matrix completed and signed off by frontend + backend + product.
