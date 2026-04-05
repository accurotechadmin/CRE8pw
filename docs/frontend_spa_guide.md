# Frontend SPA Guide (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Describe UI architecture, state management, route composition, and API coupling.

## 1) UI architecture map

- Entry shell (`index.html`)
- Styling and design tokens (`styles.css`)
- Session/device state (`state.js`)
- API contract adapter (`api-client.js`)
- Route/view controller (`app.js`)

## 2) Route registry worksheet

| Route | View function | Auth surface required | Primary endpoint(s) | State dependencies |
|---|---|---|---|---|
| `/login` | `ownerLoginView` | none | `/api/auth/login` | session(owner) |
| `/feed` | `feedView` | key | `/api/feed` | session(key), device id |
| _(expand all routes)_ | | | | |

## 3) UX state model

- global route state vocabulary (idle/loading/submitting/success/error variants)
- field-level validation mapping strategy
- session-expired handling behavior
- forbidden/not-found/server fallback behavior

## 4) Accessibility checklist (to complete)

- [ ] Landmark usage and heading hierarchy.
- [ ] Focus management and restoration.
- [ ] `aria-live` semantics for async result/status panels.
- [ ] keyboard-only navigation for all forms/actions.

## 5) Extensibility playbook

For each new endpoint-backed page:

1. add route + nav entry,
2. add view + API integration,
3. map known error codes,
4. add permission/auth guard,
5. add QA matrix entries.
