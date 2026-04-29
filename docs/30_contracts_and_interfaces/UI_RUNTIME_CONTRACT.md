---
doc_id: CRE8-CONTRACTS-SURFACE-PARITY
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
- **CRE8-CONTRACT-REQ-0030**: Every capability marked `supported` in Owner Console **MUST** declare a canonical API route mapping in `ROUTE_INVENTORY_REFERENCE.md`, unless explicitly classified `ui_only` with documented justification.
- **CRE8-CONTRACT-REQ-0031**: Authorization prerequisites (permission, scope, lifecycle preconditions) for parity-mapped UI actions **MUST** match API contract declarations.
- **CRE8-CONTRACT-REQ-0032**: Any intentional parity exception **MUST** include `exception_class`, `justification`, `owner`, and `review_due_utc`, and **MUST** be listed in release-impact notes.
- **CRE8-CONTRACT-REQ-0033**: UI-surfaced error states for parity-mapped capabilities **MUST** map to canonical API error codes from `ERROR_CODE_CATALOG.md`.

## Verification hooks
- **HOOK-CONTRACT-SURFACE-PARITY**: Validate parity matrix entries against route inventory and documented exception records.
- **Next automation candidate**: Implement `docs:ssot:surface-parity-check` to compare parity table artifacts with route inventory IDs.

## See also
- [Architecture and Surfaces](../10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md)
- [API Contract Guide](./API_CONTRACT_GUIDE.md)
- [Route Inventory Reference](./ROUTE_INVENTORY_REFERENCE.md)
- [Error Code Catalog](./ERROR_CODE_CATALOG.md)
