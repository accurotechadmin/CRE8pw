---
doc_id: CRE8-OPS-HEALTH-ENDPOINT-CONTRACT
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-15
source_seed_refs:
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
normative_dependencies:
  - docs/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Health Endpoint Contract

## Purpose
Define deterministic liveness/readiness semantics and response contract obligations for CRE8 health probes.

## Normative requirements
- **CRE8-OPS-REQ-0023**: The platform **MUST** expose a liveness endpoint that validates process availability only and **MUST NOT** perform dependency checks.
- **CRE8-OPS-REQ-0024**: The platform **MUST** expose a readiness endpoint that validates boot completion and required runtime dependencies (configuration load, persistence connectivity, and crypto provider availability) before returning ready.
- **CRE8-OPS-REQ-0025**: Liveness and readiness responses **MUST** use the canonical success envelope `{data, meta}` from `API_CONTRACT_GUIDE.md` with `meta.request_id`, `meta.timestamp_utc`, and `meta.contract_version`.
- **CRE8-OPS-REQ-0026**: Any failed readiness check **MUST** return deterministic error envelope `{error, meta}` with a stable `SYSTEM_*` code and **MUST NOT** leak secret values or connection strings.
- **CRE8-OPS-REQ-0027**: Readiness probe outcomes **MUST** be logged with correlation-ready request identifiers through `monolog/monolog` and **MUST** be linkable to operator triage evidence.

- **CRE8-OPS-REQ-0044**: Readiness dependency checks **MUST** be reconciled with dependency inventory in `docs/10_product_and_architecture/DEPENDENCY_BASELINE.md` and required configuration variables in `CONFIGURATION_ENVIRONMENT_CONTRACT.md`; unsupported or undocumented readiness dependencies **MUST NOT** be introduced.

## Endpoint behavior table
| Endpoint | Method | Scope | Success condition | Failure class |
|---|---|---|---|---|
| `/health/live` | `GET` | Liveness | Process loop active and route stack mounted | `SYSTEM_UNAVAILABLE` |
| `/health/ready` | `GET` | Readiness | Boot complete + required dependencies available | `SYSTEM_DEPENDENCY_UNREADY` |

## Implementation-binding dependencies
- `slim/slim` **MUST** host probe routes in deterministic middleware order.
- `slim/psr7` **MUST** provide response primitives for canonical envelopes.
- `ext-pdo` **MUST** back readiness persistence checks when relational storage is configured.
- `ext-sodium` **MUST** back readiness crypto capability checks.
- `monolog/monolog` **MUST** record probe outcomes with request correlation metadata.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-SSOT-COMMAND-EXIT-SEMANTICS` | Requires deterministic probe command semantics to be exercised via acceptance-bundle command chain and smoke checks. |
| `HOOK-CONTRACT-ERROR-DETERMINISM` | Verifies deterministic error envelope behavior for failed readiness conditions. |

Change Impact Map: `reports/change_impact_maps/20260430-1246-P3-S9.1-P3-S9.4.md`.

## See also
- [Boot and Startup Failure Contract](./BOOT_AND_STARTUP_FAILURE_CONTRACT.md)
- [Operational Smoke Check Contract](./OPERATIONAL_SMOKE_CHECK_CONTRACT.md)
- [Verification Strategy](./VERIFICATION_STRATEGY.md)
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
