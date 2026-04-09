# Health Endpoint Contract (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-09_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Purpose
Define canonical `/health` semantics for subsystem-level readiness and degraded-state triage.

## Route and surface
- Route: `GET /health`
- Surface: public
- Auth: none

## Response contract
Success envelope shape:
- `data.status` (`ok|degraded`)
- `data.checked_at_utc` (ISO-8601)
- `data.latency_ms` (integer)
- `data.failures` (array of failure reason strings)
- `data.services` object containing:
  - `db` status
  - `rate_limiter` status
  - `key_material` status
  - `http_dependency` status

Response `meta` must include canonical envelope metadata.

## Service-state semantics
- `ok`: subsystem healthy for current probe.
- `degraded`: subsystem reachable but policy threshold failed.
- `down`: subsystem unavailable or probe exception.

## HTTP status guidance
- `200`: endpoint reachable and contract response emitted (including degraded cases).
- `500`: unrecoverable handler/runtime error.

## Failure reason examples
- `db_probe_exception`
- `rate_limiter_rejected`
- `key_material_unavailable`
- `http_dependency_exception`

## Smoke-check expectations
`ops:health-smoke` must validate:
- route reachable,
- JSON envelope shape,
- `data.status` is valid (`ok|degraded`),
- subsystem object presence.

## Related SSOT docs
- `API_CONTRACT_GUIDE.md`
- `Endpoint_Examples_All_Routes.md`
- `RELEASE_CHECKLIST.md`
- `OPERATIONAL_SMOKE_CHECK_CONTRACT.md`
