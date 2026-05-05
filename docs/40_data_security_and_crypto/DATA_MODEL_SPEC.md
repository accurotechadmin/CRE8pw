---
doc_id: CRE8-DATA-MODEL-SPEC
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Platform Architecture WG
  - Operations Quality WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md
  - docs/20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md
  - docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Data Model Spec

## Purpose
Define canonical entities, lifecycle semantics, relational invariants, and sensitivity classes for CRE8 persistence.

## Normative requirements
- **CRE8-DATA-REQ-0001**: Persistence **MUST** model principal, keypair, delegation grant, delegation edge, and audit event as first-class entities.
- **CRE8-DATA-REQ-0002**: Each entity **MUST** expose an immutable canonical identifier (`*_id`) and `created_utc` timestamp serialized as RFC3339 UTC.
- **CRE8-DATA-REQ-0003**: Delegation grants **MUST** include `state` constrained to `pending|active|suspended|revoked|expired` and **MUST NOT** persist out-of-enum values.
- **CRE8-DATA-REQ-0004**: Keypair rows **MUST** include `lifecycle_state` constrained to `active|suspended|revoked|rotated|expired` with transition validity enforced by the state machine.
- **CRE8-DATA-REQ-0005**: Delegation edge rows **MUST** encode acyclic parent-child relationships; insertion creating a cycle **MUST** fail deterministically.
- **CRE8-DATA-REQ-0006**: Authorization-relevant tables **MUST** provide indexes on `(principal_id, lifecycle_state)` and `(grant_id, state, grant_expiry_utc)` to preserve deterministic policy evaluation latency.
- **CRE8-DATA-REQ-0007**: Security-sensitive fields (private-key material, signing secrets, replay nonces) **MUST** be stored encrypted-at-rest using `ext-sodium` primitives and **MUST NOT** be logged in plaintext.
- **CRE8-DATA-REQ-0008**: Every mutation to lifecycle or delegation state **MUST** emit an audit event row containing `request_id`, actor principal, prior state, next state, and UTC transition time.
- **CRE8-DATA-REQ-0009**: Referential integrity **MUST** be enforced with explicit foreign keys for grant→principal and edge→grant relations; orphan records **MUST NOT** persist.
- **CRE8-DATA-REQ-0010**: Runtime implementations using `ext-pdo` **MUST** execute all multi-row lifecycle mutations in a single transaction boundary with rollback on first failure.

## Entity set
| entity | required key fields | sensitivity tier | notes |
|---|---|---|---|
| principal | principal_id, principal_type, status, created_utc | internal | Anchors ID/Utility key ownership. |
| keypair | keypair_id, principal_id, key_type, lifecycle_state, public_key_ref | restricted | Binds cryptographic material to principals. |
| delegation_grant | grant_id, issuer_principal_id, subject_principal_id, state, grant_expiry_utc | restricted | Contract source for capability delegation. |
| delegation_edge | edge_id, parent_grant_id, child_grant_id, created_utc | internal | Encodes hierarchy and depth traversal. |
| audit_event | event_id, request_id, actor_principal_id, event_type, payload_ref, created_utc | internal | Non-repudiation and forensics anchor. |

## Implementation binding
- `ext-pdo` enforces transactional and FK semantics (`CRE8-DATA-REQ-0009`, `CRE8-DATA-REQ-0010`).
- `ext-sodium` enforces authenticated encryption for sensitive fields (`CRE8-DATA-REQ-0007`).

## See also
- [Data Model Reference](./DATA_MODEL_REFERENCE.md)
- [ERD](./ERD.md)
- [Delegation State Machine](../20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
