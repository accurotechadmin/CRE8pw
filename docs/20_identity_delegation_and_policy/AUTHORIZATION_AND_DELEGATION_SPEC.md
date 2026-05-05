---
doc_id: CRE8-AUTH-DELEGATION-SPEC
version: 1.2.0
status: normative
owner: Identity & Policy WG
reviewers:
  - Security WG
  - Platform Architecture WG
last_reviewed_utc: 2026-05-04
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Authorization And Delegation Spec

## Purpose
Define deterministic authorization and delegation behavior for CRE8 policy evaluation, including inheritance boundaries, deny precedence, and failure semantics.

## Normative requirements
- **CRE8-AUTH-REQ-0001**: Authorization decisions **MUST** evaluate inputs in this order: (1) lifecycle state, (2) credential validity, (3) explicit deny checks, (4) scope boundary checks, (5) permission match, (6) delegation depth checks, (7) expiry/time-window checks.
- **CRE8-AUTH-REQ-0002**: Descendant grants **MUST NOT** include permissions, scopes, lifecycle durations, or delegation depth beyond the effective limits of the delegating ancestor.
- **CRE8-AUTH-REQ-0003**: When policy inputs are ambiguous, incomplete, or contradictory, authorization evaluation **MUST** return a deterministic deny outcome and **MUST NOT** default to allow.
- **CRE8-AUTH-REQ-0004**: Authorization denials **MUST** map to stable machine-readable error codes defined in [`ERROR_CODE_CATALOG.md`](ERROR_CODE_CATALOG.md).
- **CRE8-AUTH-REQ-0005**: Delegation operations **MUST** emit provenance records containing delegator principal, delegate principal, inherited constraints, resulting effective constraints, and timestamp.
- **CRE8-AUTH-REQ-0006**: Credential lifecycle changes (`suspend`, `revoke`, `expire`) **MUST** be enforced on subsequent authorization decisions with no grace bypass path unless explicitly defined by normative emergency policy.
- **CRE8-AUTH-REQ-0007**: Conflicting policy signals **MUST** resolve by precedence order `explicit_deny > scope_constraint_deny > permission_missing_deny > delegated_allow > direct_allow`; when both direct and delegated allows are present, the decision record **MUST** mark `allow_source=direct` and retain delegated context as supplemental provenance.

## Decision outputs
- Allow/deny outputs MUST be reproducible from persisted policy state and request context.
- Deny outputs SHOULD include a single primary reason code and MAY include secondary diagnostic details for operators.

## Verification hooks
- **HOOK-CONTRACT-POLICY-ORDER**: Verify evaluation order and deny precedence using contract tests.
- **HOOK-AUTH-INHERITANCE-BOUNDARY**: Verify descendants cannot exceed ancestor authority.
- **HOOK-AUTH-LIFECYCLE-ENFORCEMENT**: Verify suspend/revoke/expire states are enforced in policy decisions.

## See also
- [Authorization Decision Tables](./AUTHORIZATION_DECISION_TABLES.md)
- [Permission Vocabulary](./PERMISSION_VOCABULARY.md)
- [Principal Types And Capability Matrix](./PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md)
- [Keychain Composition And Resolution Spec](./KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md)
- [Usage Scenarios And Permission Stories](./USAGE_SCENARIOS_AND_PERMISSION_STORIES.md)
- [Delegation State Machine](./DELEGATION_STATE_MACHINE.md)
- [API Contract Guide](./30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Error Code Catalog](./30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [Traceability Matrix](./80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Permission and Delegation Seed](././seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md)


