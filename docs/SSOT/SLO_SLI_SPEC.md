# SLO/SLI Spec

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## SLI definitions
- API availability: successful non-5xx response ratio for `/api/*` and `/console/api/*`.
- Auth success latency: p95 for `/api/auth/login` and `/api/auth/key-login`.
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

## Alerting guidance
- Page on sustained 5xx spikes and `/health` degradation.
- Ticket on rising 401/403/429 anomalies beyond baseline.
- Link alert context with `request_id` traces and event catalog families.
