---
doc_id: CRE8-OPS-SLO-SLI-SPEC
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-17
source_seed_refs:
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
normative_dependencies:
  - docs/60_operations_quality_and_release/OBSERVABILITY_EVENT_CATALOG.md
  - docs/60_operations_quality_and_release/PRODUCTION_READINESS_GATES.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
---

# SLO SLI Spec

## Purpose
Define service-level indicators and objectives that govern reliability and operational quality for CRE8 surfaces.

## Normative requirements
- **CRE8-OPS-REQ-0063**: The platform **MUST** publish SLIs for latency, availability, error rate, lifecycle propagation latency, and audit completeness ratio.
- **CRE8-OPS-REQ-0064**: The platform **MUST** define per-surface SLO targets for API gateway and policy decision point (PDP) surfaces.
- **CRE8-OPS-REQ-0065**: Error budget consumption **MUST** be tracked weekly and **MUST** block feature release when budget is exhausted unless an ADR-bound exception exists.
- **CRE8-OPS-REQ-0066**: Alerting thresholds **MUST** bind to SLO burn-rate rules and **MUST** emit deterministic incident events.
- **CRE8-OPS-REQ-0067**: SLI measurements **MUST** rely on canonical event schemas from `OBSERVABILITY_EVENT_CATALOG.md` and **MUST NOT** use unversioned ad-hoc fields.

## SLI/SLO targets
| Surface | SLI | Measurement window | SLO target |
|---|---|---|---|
| API Gateway | Availability | 28 rolling days | >= 99.9% |
| API Gateway | p95 latency (`/v1/authz/decide`) | 7 rolling days | <= 250 ms |
| API Gateway | Server error rate (5xx) | 7 rolling days | <= 0.1% requests |
| PDP lifecycle | Grant lifecycle propagation latency | 24 hours | p99 <= 60 seconds |
| Audit pipeline | Audit completeness ratio | 7 rolling days | >= 99.99% expected events |

## Error budget policy
- Monthly availability budget for 99.9% target = 43m 12s total unavailability.
- If 50% of budget is consumed before day 15, release managers **SHOULD** trigger change-freeze review.
- If 100% of budget is consumed, release managers **MUST** block non-remediation releases until burn rate returns below threshold.

## Implementation-binding dependencies
- `monolog/monolog` **MUST** emit structured events used to compute SLIs.
- `symfony/cache` **MUST** stabilize metric aggregation windows when the runtime performs in-process aggregation for SLI evaluation windows.
- `phpunit/phpunit` **SHOULD** enforce SLI calculator fixture tests as part of acceptance suites.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-SLO-SLI-PRESENT` | Verifies SLI/SLO document existence, required metric set, and explicit targets. |
| `HOOK-OBS-EVENT-CATALOG-COVERAGE` | Verifies SLI fields map to canonical observability event schemas. |


Change Impact Map: `reports/change_impact_maps/20260430-1303-P3-S9.7-P3-S9.9.md`.

## See also
- [Observability Event Catalog](./OBSERVABILITY_EVENT_CATALOG.md)
- [Production Readiness Gates](./PRODUCTION_READINESS_GATES.md)
- [Release Checklist](./RELEASE_CHECKLIST.md)
- [Verification Strategy](./VERIFICATION_STRATEGY.md)
