# Request Lifecycle (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Trace the complete execution path for both successful and failing requests.

## 1) Lifecycle narrative template

1. **Process bootstrap** — environment and container are prepared.
2. **Inbound request normalization** — request-id and routing metadata attached.
3. **Policy middleware** — CORS, CSRF, rate-limit, JSON parse, validation.
4. **Authentication/authorization** — owner/key JWT and route policy checks.
5. **Handler dispatch** — route calls service methods.
6. **Domain and persistence work** — DB reads/writes + audit events.
7. **Response shaping** — envelope responder emits normalized output.
8. **Failure path mapping** — exceptions mapped to error envelope codes.

## 2) Per-middleware worksheet (repeat per middleware)

| Middleware | Runs on | Inputs required | Mutations | Reject conditions | Error details code(s) | Audit events |
|---|---|---|---|---|---|---|
| RequestIdMiddleware | global | optional `X-Request-Id` | normalized request-id | invalid UUID input replacement | _(fill)_ | _(fill)_ |
| _(expand)_ | | | | | | |

## 3) Route-family sequence templates

### 3.1 Auth route (`/api/auth/*`)

- Preconditions
- Happy path sequence
- Failure matrix
- Postconditions

### 3.2 Gateway route (`/api/*`)

- Device id expectations
- Key auth expectations
- Permission failure behavior

### 3.3 Console route (`/console/api/*`)

- Owner auth expectations
- Dangerous action confirmation implications (UI + backend)

## 4) Debugging map (to complete)

- [ ] “Where did this request fail?” decision tree.
- [ ] Common HTTP status triage playbook.
- [ ] Request-id tracing procedure across logs/audit events.
