---
doc_id: CRE8-MACHINE-CONTRACT-VERSION-POLICY
version: 1.1.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Docs Governance WG
last_reviewed_utc: 2026-05-04
next_review_due_utc: 2026-06-04
source_seed_refs:
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
normative_dependencies:
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Contract Version Policy

## Purpose
Define deterministic semantic-versioning, compatibility classification, and deprecation triggers for CRE8 machine contracts.

## Normative requirements
- **CRE8-MACHINE-REQ-0100**: Envelope `meta.contract_version` MUST follow `MAJOR.MINOR.PATCH` and MUST be emitted on every success and error response.
- **CRE8-MACHINE-REQ-0101**: Additive backward-compatible changes (optional field additions, additive enum values, additive endpoints) MUST increment `MINOR` and MUST NOT increment `MAJOR`.
- **CRE8-MACHINE-REQ-0102**: Breaking changes (required-field additions, field removals, type narrowing, enum value removal, status-code contract removal) MUST increment `MAJOR` and MUST include migration notes per [`CHANGE_CONTROL_POLICY.md`](CHANGE_CONTROL_POLICY.md).
- **CRE8-MACHINE-REQ-0103**: Editorial-only machine-artifact regeneration that does not alter request/response behavior SHOULD increment `PATCH`.
- **CRE8-MACHINE-REQ-0104**: `feed_metadata_schema_version` MUST be versioned independently from `meta.contract_version` and MUST advance only when feed metadata shape changes.
- **CRE8-MACHINE-REQ-0105**: Deprecation windows for externally consumed contract fields MUST be at least 90 calendar days before removal and MUST publish sunset details in release notes and [`PROSE_OPENAPI_PARITY_TABLE.md`](PROSE_OPENAPI_PARITY_TABLE.md) notes.
- **CRE8-MACHINE-REQ-0106**: Route-level compatibility declarations in contract-impacting changes MUST classify each affected route as `compatible`, `conditionally-compatible`, or `breaking` before merge.

## Compatibility trigger matrix

| Trigger | Compatibility class | Version action |
|---|---|---|
| Optional response field added | compatible | `MINOR` |
| New deny code added without removing existing codes | compatible | `MINOR` |
| Required request field added | breaking | `MAJOR` |
| Error status removed for an existing route | breaking | `MAJOR` |
| Enum value removed or renamed | breaking | `MAJOR` |
| Description/example-only correction | conditionally-compatible | `PATCH` |

## Verification hooks
- **HOOK-CONTRACT-COMPAT-DECLARATION**: Validates compatibility classification and migration-note presence for contract-impacting changes.
- **HOOK-CONTRACT-ROUTE-INVENTORY-PARITY**: Verifies route/method parity remains synchronized with OpenAPI after versioned changes.

## See also
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Prose↔OpenAPI Parity Table](./PROSE_OPENAPI_PARITY_TABLE.md)
- [Change Control Policy](../00_governance/CHANGE_CONTROL_POLICY.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)

Change Impact Map: [[`reports/change_impact_maps/20260504-2113-P4-S3.3-P4-S3.5-contract-parity.md`](reports/change_impact_maps/20260504-2113-P4-S3.3-P4-S3.5-contract-parity.md)](../../reports/change_impact_maps/20260504-2113-P4-S3.3-P4-S3.5-contract-parity.md)
