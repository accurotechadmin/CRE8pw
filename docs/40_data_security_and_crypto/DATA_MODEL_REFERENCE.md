---
doc_id: CRE8-DATA-MODEL-REFERENCE
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Identity & Policy WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md
  - docs/40_data_security_and_crypto/ERD.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Data Model Reference

## Purpose
Provide machine-readable field-level reference constraints for entities defined in the Data Model Spec.

## Normative requirements
- **CRE8-DATA-REQ-0011**: Reference tables **MUST** define field name, type, nullability, and validation constraint for every persisted field.
- **CRE8-DATA-REQ-0012**: Identifier fields (`*_id`) **MUST** match `^[a-z0-9][a-z0-9_-]{2,63}$`.
- **CRE8-DATA-REQ-0013**: UTC timestamps **MUST** serialize as RFC3339 with `Z` suffix.
- **CRE8-DATA-REQ-0014**: Enum-typed fields **MUST** list canonical value sets and **MUST NOT** permit aliases.
- **CRE8-DATA-REQ-0015**: Reference rows **MUST** define deterministic default behavior for optional fields.

## Field reference
| entity | field | type | nullable | constraint |
|---|---|---|---|---|
| principal | principal_id | string | no | pattern `^[a-z0-9][a-z0-9_-]{2,63}$` |
| principal | principal_type | string | no | enum per principal vocabulary |
| keypair | keypair_id | string | no | pattern `^[a-z0-9][a-z0-9_-]{2,63}$` |
| keypair | lifecycle_state | string | no | enum `active|suspended|revoked|rotated|expired` |
| delegation_grant | grant_expiry_utc | string(date-time) | yes | RFC3339 UTC when present |
| delegation_grant | state | string | no | enum `pending|active|suspended|revoked|expired` |
| audit_event | request_id | string | no | pattern `^req-[a-z0-9-]{6,64}$` |
| audit_event | created_utc | string(date-time) | no | RFC3339 UTC |

## Implementation binding
- Validation runtimes using `respect/validation` **MUST** enforce regex and enum constraints in this document for API ingest and persistence writes.

## Change Impact Map
- `reports/change_impact_maps/20260430-0717-P3-S7.1-P3-S7.2-P3-S7.3.md`

## See also
- [Data Model Spec](./DATA_MODEL_SPEC.md)
- [ERD](./ERD.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
