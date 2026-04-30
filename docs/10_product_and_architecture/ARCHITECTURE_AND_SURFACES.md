---
doc_id: CRE8-ARCH-SURFACES
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - API Contracts WG
  - Operations Quality WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-15
source_seed_refs:
  - seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
  - docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md
---

# Architecture And Surfaces

## Normative requirements
- **CRE8-ARCH-REQ-0010**: CRE8 **MUST** expose exactly three externally documented surfaces: HTTP API, operational command surface (Composer commands), and SSOT evidence/report surface; each surface **MUST** have a canonical owner and verification hook. Runtime enforcement dependency: none (documentation governance requirement).
- **CRE8-ARCH-REQ-0011**: The HTTP API surface **MUST** be the only network-reachable application surface and **MUST** be routed through Slim middleware/route resolution (`slim/slim`, `slim/psr7`).
- **CRE8-ARCH-REQ-0012**: The route set declared in `ROUTE_INVENTORY_REFERENCE.md` **MUST** remain parity-synchronized with `docs/31_machine_contracts/openapi/cre8.v1.yaml` (`slim/slim`; verification via route-parity tooling).
- **CRE8-ARCH-REQ-0013**: Every HTTP surface deny outcome **MUST** resolve to a cataloged code in `ERROR_CODE_CATALOG.md` and return deterministic envelope semantics (`slim/psr7`; `phpunit/phpunit` contract tests).
- **CRE8-ARCH-REQ-0014**: Surface behavior that depends on credential or delegation assertions **MUST** consume canonical policy outcomes produced by the authorization decision contract (`firebase/php-jwt`, `ext-sodium`, `respect/validation`).
- **CRE8-ARCH-REQ-0015**: Operational command surface checks **MUST** be executable through Composer script entrypoints and **MUST** exit non-zero on contract violations (dependency: Composer runtime + `phpunit/phpunit`; no additional runtime dependency).
- **CRE8-ARCH-REQ-0016**: Evidence/report surface artifacts under `reports/ssot/` **MUST** be treated as machine-readable acceptance evidence for merge gates (`symfony/cache` optional for performance only; enforcement is script logic, no strict package dependency).

## Surface topology
| Surface | Primary purpose | Canonical interface | Owner WG | Primary hooks |
|---|---|---|---|---|
| HTTP API | Runtime policy, identity, and feed interactions | OpenAPI + route inventory | API Contracts WG | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY, HOOK-CONTRACT-ERROR-CODE-COVERAGE |
| Ops command surface | Validation, lint, acceptance gates | `composer` scripts | Operations Quality WG | HOOK-SSOT-COMMAND-EXIT-SEMANTICS, HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE |
| SSOT evidence/report surface | Traceability and coverage evidence | `reports/ssot/*.json`, handoff artifacts | Program Traceability WG | HOOK-SSOT-REPORT-COVERAGE-COVERAGE, HOOK-TRACE-MATRIX-COVERAGE |

## See also
- [Canonical Terminology](./CANONICAL_TERMINOLOGY.md)
- [Request Pipeline And Middleware Contract](./REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md)


## Change history
- 2026-04-30 (v1.0.0): Initial normative publication under Phase 3 slices P3-S3.2/P3-S3.4. Change Impact Map: [`reports/change_impact_maps/20260430-1200-P3-S3.2-P3-S3.4.md`](../../reports/change_impact_maps/20260430-1200-P3-S3.2-P3-S3.4.md).
