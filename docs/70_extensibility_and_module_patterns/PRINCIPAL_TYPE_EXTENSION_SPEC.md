---
doc_id: CRE8-EXT-PRINCIPAL-TYPE-SPEC
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - Identity & Policy WG
  - Security Engineering WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-21
source_seed_refs:
  - seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/70_extensibility_and_module_patterns/EXTENSIBILITY_PLAYBOOK.md
  - docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md
  - docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md
  - docs/20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
---

# Principal Type Extension Spec

## Purpose
Define mandatory obligations for introducing a new principal type while preserving permission vocabulary integrity, capability-matrix determinism, delegation lifecycle semantics, and policy-decision enforcement.

## Normative requirements
- **CRE8-EXT-REQ-0022**: A new principal type **MUST** declare a unique canonical principal token and **MUST NOT** ship with implicit wildcard permissions.
- **CRE8-EXT-REQ-0023**: Principal-type additions **MUST** extend `PERMISSION_VOCABULARY.md` and the capability matrix in the same patch, including explicit allow/deny/conditional posture for every relevant action family.
- **CRE8-EXT-REQ-0024**: New principal types **MUST** define delegation lifecycle transitions (grant, suspend, revoke, expire) and cascade semantics consistent with `DELEGATION_STATE_MACHINE.md`.
- **CRE8-EXT-REQ-0025**: Authorization fixtures for the new principal type **MUST** include deterministic allow and deny examples that exercise gate ordering and reason-code mapping.
- **CRE8-EXT-REQ-0026**: Principal extension manifests **MUST** include backward-compatibility declaration, migration impact, and rollback constraints before release approval.
- **CRE8-EXT-REQ-0030**: Principal-type extension manifests **MUST** declare validator coverage for permission-token resolution, capability-matrix completeness, delegation transition integrity, and authorization reason-code determinism; release approval **MUST** fail closed when required validator results are absent or non-passing.

## Required principal extension manifest
| Field | Requirement |
|---|---|
| `principal_type` | Unique canonical token. |
| `permission_tokens` | New/updated tokens and ownership namespace. |
| `capability_matrix_deltas` | Explicit allow/deny/conditional deltas by action family. |
| `delegation_transitions` | State transition additions and propagation semantics. |
| `authz_fixtures` | Allow/deny fixtures with expected reason codes. |
| `compatibility_declaration` | Additive vs breaking classification and rollback strategy. |
| `validator_coverage` | Required validator commands/results for token, matrix, delegation, and reason-code checks. |

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-PERMISSION-VOCAB-RESOLVE` | Verifies referenced permission tokens exist, remain canonical, and resolve without alias drift. |
| `HOOK-CAPABILITY-MATRIX-COMPLETE` | Verifies matrix coverage for new principal type across action families. |
| `HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY` | Verifies transition semantics remain valid and deterministic. |
| `HOOK-CONTRACT-POLICY-ORDER` | Verifies allow/deny fixtures preserve canonical authorization gate order and reason mapping. |

## Non-overridable core controls
- Principal-type extensions **MUST** preserve all controls declared by `CRE8-EXT-REQ-0027`, including identity/delegation invariants, lifecycle deny propagation, data-classification enforcement, and cryptographic verification controls.
- Any principal-type behavior that conflicts with these controls **MUST** be rejected unless an ADR-approved bounded exception includes explicit expiry and rollback conditions.

## See also
- [Permission Vocabulary](../20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md)
- [Principal Types and Capability Matrix](../20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md)
- [Delegation State Machine](../20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md)
- [Route Inventory Reference](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [Webhook and Integration Contract](../30_contracts_and_interfaces/WEBHOOK_AND_INTEGRATION_CONTRACT.md)


Change Impact Map: `reports/change_impact_maps/20260430-1317-P3-S10.2-P3-S10.3-P3-S10.4.md`.
