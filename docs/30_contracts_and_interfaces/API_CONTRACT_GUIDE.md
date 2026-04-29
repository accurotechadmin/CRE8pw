---
doc_id: CRE8-CONTRACTS-API-GUIDE
version: 1.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - seed/
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
normative_dependencies:
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
---

# Api Contract Guide

## Purpose
Define normative API contract obligations, route lifecycle rules, and prose-to-machine parity expectations for CRE8 interfaces.

## Normative requirements
- **CRE8-CONTRACT-REQ-0010**: Every externally callable CRE8 route **MUST** have one canonical entry in `ROUTE_INVENTORY_REFERENCE.md` and one corresponding OpenAPI path+operation in `docs/31_machine_contracts/openapi/cre8.v1.yaml`.
- **CRE8-CONTRACT-REQ-0011**: Request and response bodies **MUST** use stable envelope fields with explicit required/optional semantics documented in prose and OpenAPI.
- **CRE8-CONTRACT-REQ-0012**: Contract-affecting changes **MUST** include backward-compatibility classification (`compatible`, `conditionally-compatible`, `breaking`) and migration notes before merge.
- **CRE8-CONTRACT-REQ-0013**: Routes requiring delegated authority **MUST** declare required permission, scope boundary, and lifecycle prerequisites.
- **CRE8-CONTRACT-REQ-0014**: Error responses **MUST** use codes defined in `ERROR_CODE_CATALOG.md`; undocumented codes are prohibited.
- **CRE8-CONTRACT-REQ-0015**: Route deprecation **MUST** include a documented sunset date, replacement route reference, and a verification-plan update.

## Parity policy (prose ↔ machine)
- Route identifiers in prose **MUST** match OpenAPI operation IDs when defined.
- Path/method tuples **MUST** be unique and consistent between sources.
- If drift is discovered, merge **MUST** be blocked until either prose or machine artifact is updated in the same change set.

## Verification hooks
- **HOOK-CONTRACT-ROUTE-INVENTORY-PARITY**: Compare route inventory entries against OpenAPI path/method tuples.
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE**: Validate all declared error codes exist in `ERROR_CODE_CATALOG.md`.
- **HOOK-CONTRACT-COMPAT-DECLARATION**: Validate compatibility classification and migration note sections for contract-impacting changes.

## Drift notes
- OpenAPI baseline routes are now synchronized with the route inventory baseline; remaining debt is breadth coverage beyond initial two routes.

## See also
- [Route Inventory Reference](./ROUTE_INVENTORY_REFERENCE.md)
- [Error Code Catalog](./ERROR_CODE_CATALOG.md)
- [OpenAPI Contract](../31_machine_contracts/openapi/cre8.v1.yaml)
- [Prose↔OpenAPI Parity Table](../31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)


See also: [UI Runtime Contract](./UI_RUNTIME_CONTRACT.md).
