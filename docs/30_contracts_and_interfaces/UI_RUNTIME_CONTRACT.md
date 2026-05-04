---
doc_id: CRE8-CONTRACTS-UI-RUNTIME
version: 1.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Product Policy WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-20
source_seed_refs:
  - seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md
normative_dependencies:
  - docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# UI Runtime Contract

## Purpose
Define deterministic cross-surface parity requirements between Owner Console and API/Gateway for supported CRE8 capabilities.

## Normative requirements
- **CRE8-CONTRACT-REQ-0030**: Every capability marked `supported` in Owner Console **MUST** declare a canonical API route mapping in [`ROUTE_INVENTORY_REFERENCE.md`](ROUTE_INVENTORY_REFERENCE.md), unless explicitly classified `ui_only` with documented justification.
- **CRE8-CONTRACT-REQ-0031**: Authorization prerequisites (permission, scope, lifecycle preconditions) for parity-mapped UI actions **MUST** match API contract declarations.
- **CRE8-CONTRACT-REQ-0032**: Any intentional parity exception **MUST** include `exception_class`, `justification`, `owner`, and `review_due_utc`, and **MUST** be listed in release-impact notes.
- **CRE8-CONTRACT-REQ-0033**: UI-surfaced error states for parity-mapped capabilities **MUST** map to canonical API error codes from [`ERROR_CODE_CATALOG.md`](ERROR_CODE_CATALOG.md).


## Surface capability parity matrix
| capability_id | owner_console_status | route_id | route_method | route_path | expected_auth_model | expected_required_permission | expected_scope_type | parity_status | exception_class | justification | owner | review_due_utc |
|---|---|---|---|---|---|---|---|---|---|---|---|---|
| CAP-OWNER-HEALTH-VIEW | supported | CRE8-ROUTE-0001 | GET | /v1/system/health | public | system.health.read | global | parity_mapped | n/a | n/a | API Contracts WG | 2026-05-20 |
| CAP-OWNER-AUTH-DECISION-SIMULATE | supported | CRE8-ROUTE-0002 | POST | /v1/authz/decide | delegated | authz.decide | resource | parity_mapped | n/a | n/a | Identity & Policy WG | 2026-05-20 |
| CAP-OWNER-FEED-BROWSE | supported | CRE8-ROUTE-0004 | GET | /v1/feed/items | utility-key | feed.items.read | group | parity_mapped | n/a | n/a | Product Policy WG | 2026-05-20 |
| CAP-OWNER-AUDIT-EXPORT | ui_only | n/a | n/a | n/a | n/a | n/a | n/a | exception_documented | backend_not_exposed | Owner Console export wizard remains internal for Phase 2 and has no external API route by design. | Product Policy WG | 2026-05-20 |

## Verification hooks
- **HOOK-CONTRACT-SURFACE-PARITY**: Validate parity matrix entries against route inventory and documented exception records, including auth model/permission/scope prerequisite alignment for supported capabilities.
- **Next automation candidate**: Implemented as `composer test:contract:surface-parity` to compare parity table artifacts with route inventory IDs.

## See also
- [Architecture and Surfaces](../10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md)
- [API Contract Guide](./API_CONTRACT_GUIDE.md)
- [Route Inventory Reference](./ROUTE_INVENTORY_REFERENCE.md)
- [Error Code Catalog](./ERROR_CODE_CATALOG.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
