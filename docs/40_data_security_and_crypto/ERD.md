---
doc_id: CRE8-DATA-ERD
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
normative_dependencies:
  - docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md
  - docs/40_data_security_and_crypto/DATA_MODEL_REFERENCE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# ERD

## Purpose
Define canonical relationship cardinality and foreign-key bindings for CRE8 persistence entities.

## Normative requirements
- **CRE8-DATA-REQ-0016**: ERD relationship rows **MUST** define parent entity, child entity, cardinality, and FK column.
- **CRE8-DATA-REQ-0017**: All FK columns **MUST** enforce delete/update behavior explicitly (`RESTRICT`, `CASCADE`, or `SET NULL`) and **MUST NOT** rely on engine defaults.
- **CRE8-DATA-REQ-0018**: Grant hierarchy edges **MUST** support deterministic maximum-depth evaluation aligned with delegation policy contracts.

## Relationship table
| parent | child | cardinality | fk_column | on_delete | on_update |
|---|---|---|---|---|---|
| principal | keypair | 1:N | keypair.principal_id | RESTRICT | CASCADE |
| principal | delegation_grant (issuer) | 1:N | delegation_grant.issuer_principal_id | RESTRICT | CASCADE |
| principal | delegation_grant (subject) | 1:N | delegation_grant.subject_principal_id | RESTRICT | CASCADE |
| delegation_grant | delegation_edge (parent) | 1:N | delegation_edge.parent_grant_id | CASCADE | CASCADE |
| delegation_grant | delegation_edge (child) | 1:N | delegation_edge.child_grant_id | CASCADE | CASCADE |
| principal | audit_event | 1:N | audit_event.actor_principal_id | SET NULL | CASCADE |

## Implementation binding
- Schema migrations executed through `ext-pdo` **MUST** materialize all FK constraints and reject schema drift that removes relationship rows defined above.

## Change Impact Map
- [`reports/change_impact_maps/20260430-0717-P3-S7.1-P3-S7.2-P3-S7.3.md`](reports/change_impact_maps/20260430-0717-P3-S7.1-P3-S7.2-P3-S7.3.md)

## See also
- [Data Model Spec](./DATA_MODEL_SPEC.md)
- [Data Model Reference](./DATA_MODEL_REFERENCE.md)
- [Delegation State Machine](../20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md)
