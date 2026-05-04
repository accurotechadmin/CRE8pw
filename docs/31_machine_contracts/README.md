# `docs/31_machine_contracts/` — Machine-Readable Contract Source

This folder is the machine-contract counterpart to the prose API contract docs.

## What lives here

- [`openapi/cre8.v1.yaml`](openapi/cre8.v1.yaml) — primary OpenAPI specification.
- `schemas/*.schema.json` — JSON Schemas for response/envelope payloads and policy artifacts.
- [`PROSE_OPENAPI_PARITY_TABLE.md`](PROSE_OPENAPI_PARITY_TABLE.md) — mapping table between prose requirements/routes and OpenAPI entries.
- [`CONTRACT_VERSION_POLICY.md`](CONTRACT_VERSION_POLICY.md) — contract versioning policy and compatibility expectations.

## Why this folder matters

- Enables deterministic validation of request/response shapes.
- Supports parity checks between prose contracts and machine artifacts.
- Serves as integration source for tooling, tests, and client generation workflows.

## Authoring and maintenance expectations

- Any route/field/error behavioral change in prose should be reflected in OpenAPI/schemas.
- Any machine-contract change should be reconciled in prose docs and parity table.
- Keep envelopes and semantic fields consistent with error and API contract guides.

## Adjacent authoritative docs

- Prose API guide: [`../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- Route inventory: [`../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- Error catalog: [`../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md`](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- Verification strategy: [`../60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- Traceability matrix: [`../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)

## Practical review checklist

1. OpenAPI route and method coverage still matches route inventory.
2. Envelope and schema references are internally valid.
3. Error code set remains consistent with canonical error catalog.
4. Parity table is updated for changed/added/deprecated entries.
5. Relevant SSOT checks are re-run and evidence recorded.
