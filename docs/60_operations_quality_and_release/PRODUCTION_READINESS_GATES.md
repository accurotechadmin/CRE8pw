---
doc_id: CRE8-OPS-PRODUCTION-READINESS-GATES
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Security WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-16
source_seed_refs:
  - seed/CRE8_REPO_STUDY_REPORT.md
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
normative_dependencies:
  - docs/60_operations_quality_and_release/RELEASE_CHECKLIST.md
  - docs/60_operations_quality_and_release/OBSERVABILITY_EVENT_CATALOG.md
  - docs/80_traceability_decisions_and_program/RISK_REGISTER.md
---

# Production Readiness Gates

## Purpose
Define minimum non-negotiable gates that MUST pass before production deployment.

## Normative requirements
- **CRE8-OPS-REQ-0058**: Production promotion **MUST NOT** proceed unless all readiness gates in this document are marked `pass` for the target release artifact.
- **CRE8-OPS-REQ-0059**: Any open `critical` or `high` risk in `RISK_REGISTER.md` without an accepted ADR waiver **MUST** block production promotion.
- **CRE8-OPS-REQ-0060**: Threat-to-control coverage and abuse-case linkage **MUST** be complete for all in-scope routes before production promotion.
- **CRE8-OPS-REQ-0061**: Contract schema and example coverage **MUST** be 100% for routes listed in `ROUTE_INVENTORY_REFERENCE.md` before production promotion.
- **CRE8-OPS-REQ-0062**: Observability event coverage **MUST** include authz decision, lifecycle transition, and release gate events with deterministic field schemas.

## Readiness gate matrix
| Gate ID | Gate | Pass criteria | Evidence source |
|---|---|---|---|
| PRG-01 | Acceptance suite | `composer phase2:acceptance-bundle` pass (and Phase 3 bundle once available) | CI job logs |
| PRG-02 | Security risk closure | No unresolved high/critical risk without ADR-bound deferral | `RISK_REGISTER.md`, ADR index |
| PRG-03 | Threat/control completeness | Every `THREAT-###` row mapped to at least one control and one abuse case | Security threat and abuse-case docs |
| PRG-04 | Contract completeness | Route × schema × example coverage at 100% | contract coverage hooks |
| PRG-05 | Observability completeness | Required high-sensitivity events present with retention and sampling class | event catalog hook evidence |

## Implementation-binding dependencies
- `phpunit/phpunit` **MUST** execute acceptance and contract suites used as release gates.
- `monolog/monolog` **MUST** emit structured events required by PRG-05.
- `guzzlehttp/guzzle` **SHOULD** back external readiness probes when release orchestration validates dependent services.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-RELEASE-CHECKLIST-PRESENT` | Verifies readiness gates are aligned to ordered checklist and evidence sources. |
| `HOOK-SEC-THREAT-CONTROL-MATRIX` | Verifies threat/control and abuse-case linkage completeness. |
| `HOOK-CONTRACT-SCHEMA-COVERAGE` | Verifies schema coverage completeness against inventory and OpenAPI surface. |


Change Impact Map: `reports/change_impact_maps/20260430-1303-P3-S9.7-P3-S9.9.md`.

## See also
- [Release Checklist](./RELEASE_CHECKLIST.md)
- [SLO/SLI Spec](./SLO_SLI_SPEC.md)
- [Security Threat Model](../40_data_security_and_crypto/SECURITY_THREAT_MODEL.md)
- [Route Inventory Reference](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
