# SLO/SLI Spec

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define service-level indicators/objectives for reliability and security-sensitive operations.

## Scope
API availability, auth success rates, latency, and error budget policy.

## Normative statements
- At least one availability and one latency SLO MUST be defined for core surfaces.
- Security/error-rate indicators SHOULD track 401/403/429 anomalies.
- Breach policy MAY trigger release freeze until remediation.

## Interfaces / contracts
| SLI | Draft target | Measurement source |
|---|---|---|
| `/health` pass ratio | >=99.9% monthly | health probe logs |
| Auth p95 latency | <=300ms | app metrics/logs |
| 5xx rate | <0.5% | gateway logs |

## Failure/rejection semantics
- Missing SLI measurement pipeline means SLO is aspirational only.
- Repeated breach without action plan SHOULD block non-critical feature releases.

## Verification requirements
- Validate observability instrumentation and dashboard queries.

## Traceability hooks
- Code refs: `src/Application/Health/HealthService.php`, observability pipeline config (pending)
- Tests refs: `tests/Contract/HealthServiceContractTest.php`
- Related SSOT docs: `OBSERVABILITY_EVENT_CATALOG.md`, `PRODUCTION_READINESS_GATES.md`

## Open questions / known gaps
- Metrics backend and dashboard definitions are not yet committed in this repo.
