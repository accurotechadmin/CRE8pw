# SLO/SLI Spec

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## SLI definitions
- API availability: successful non-5xx response ratio for `/api/*` and `/console/api/*`.
- Auth success latency: p95 for `/api/auth/login` and `/api/auth/key-login`.
- Feed read latency: p95 for `GET /api/feed`.
- Health reliability: `/health` pass ratio.
- Error budget burn: 5xx rate and auth failure anomalies.

## Initial SLO targets
- Availability: 99.9% monthly
- p95 auth latency: <= 350ms
- p95 feed read latency: <= 300ms
- Health pass ratio: 99.95%

## Measurement windows
- 1m realtime dashboards
- 1h ops review rollups
- 30d SLO compliance reports

## Instrumentation ownership matrix
| Signal / SLI | Source of truth | Dashboard owner | Alert authority | Escalation backup |
|---|---|---|---|---|
| API availability (`/api/*`, `/console/api/*`) | HTTP gateway metrics + envelope status counters | Platform/SRE owner | Platform on-call | Backend maintainer lead |
| Auth latency (owner/key login) | Route-level latency histogram (`/api/auth/login`, `/api/auth/key-login`) | Backend maintainer lead | Platform on-call | Security owner |
| Feed latency (`GET /api/feed`) | Route-level latency histogram + DB timing spans | Backend maintainer lead | Backend on-call rotation | Platform/SRE owner |
| `/health` reliability | Health probe success ratio + dependency status dimensions | Platform/SRE owner | Platform on-call | Backend maintainer lead |
| Error budget burn | 5xx ratio + anomaly detector on 401/403/429 families | Platform/SRE owner | Platform on-call | Security owner |

## Alerting guidance
- Page on sustained 5xx spikes and `/health` degradation.
- Ticket on rising 401/403/429 anomalies beyond baseline.
- Link alert context with `request_id` traces and event catalog families.
- Alerts must include direct links to the corresponding runbook sections in `RELEASE_CHECKLIST.md`.

## Accountability rules
- Every SLI has exactly one dashboard owner and one primary alert authority.
- Ownership changes require updates to this file and `RELEASE_CHECKLIST.md` in the same PR.
- Monthly operations review must confirm owner/authority assignments remain accurate.
