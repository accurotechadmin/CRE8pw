# API Reference (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Provide endpoint-level canonical behavior for CRE8.pw APIs.

## 1) Reference authoring rules

- One endpoint section per route.
- Include: auth surface, required headers, request shape, response envelope, error matrix, and examples.
- Link every endpoint to at least one validating test.

## 2) Endpoint catalog template

| Method | Path | Surface | Auth required | Required headers | Handler/service | Status |
|---|---|---|---|---|---|---|
| POST | `/api/auth/login` | auth | none | `Content-Type: application/json` | `AuthService::login` | scaffold |
| GET | `/api/feed` | gateway | key JWT | `Authorization`, `X-Device-Id` | `FeedService::list` | scaffold |
| _(expand all endpoints)_ | | | | | | |

## 3) Per-endpoint section template

### `METHOD /path`

- **Intent:**
- **Auth model:**
- **Request headers:**
- **Request body schema:**
- **Success envelope example:**
- **Error matrix:**

| HTTP | `error.code` | Detail codes | Trigger |
|---|---|---|---|
| 4xx/5xx | _(fill)_ | _(fill)_ | _(fill)_ |

- **Side effects / idempotency:**
- **Rate limit notes:**
- **Validation references:**

## 4) Extensibility policy for new endpoints

- [ ] Add route registration entry.
- [ ] Add validation schema branch.
- [ ] Add middleware policy review notes.
- [ ] Add contract tests.
- [ ] Add UI integration notes (if user-facing).
