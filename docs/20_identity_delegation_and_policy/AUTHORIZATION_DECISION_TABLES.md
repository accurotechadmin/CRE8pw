---
doc_id: CRE8-AUTH-DECISION-TABLES
version: 1.0.0
status: provisional-normative
owner: Identity & Policy WG
reviewers:
  - Security WG
  - API Contracts WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - seed/
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
normative_dependencies:
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Authorization Decision Tables

## Purpose
Define deterministic authorization decision-table requirements that implement the evaluation order and inheritance rules specified in `AUTHORIZATION_AND_DELEGATION_SPEC.md`.

## Normative requirements
- **CRE8-AUTH-REQ-0010**: Authorization checks **MUST** evaluate the gate sequence in this exact order: lifecycle state, credential validity, explicit deny, scope match, permission match, delegation depth, expiry window.
- **CRE8-AUTH-REQ-0011**: Any failed gate in the sequence **MUST** terminate evaluation and produce one deterministic deny reason code.
- **CRE8-AUTH-REQ-0012**: Descendant grants **MUST NOT** exceed ancestor permissions, scope set, expiry ceiling, or depth budget.
- **CRE8-AUTH-REQ-0013**: Effective decision records **MUST** include `principal_id`, `resource_scope`, `action`, `ancestor_chain_ref`, `deny_or_allow`, and `decision_reason_code` for provenance export.
- **CRE8-AUTH-REQ-0014**: Missing or ambiguous policy input **MUST** resolve to deny with reason code `AUTH_POLICY_UNRESOLVED`.
- **CRE8-AUTH-REQ-0015**: Decision-table rows **MUST** map each deny reason code to one and only one API error code in `ERROR_CODE_CATALOG.md`.

## Deterministic decision table (minimum)
| Step | Gate | Pass condition | Fail condition | Required reason code |
|---|---|---|---|---|
| 1 | Lifecycle state | Principal and key are active | Suspended, revoked, expired, pending | `AUTH_LIFECYCLE_BLOCKED` |
| 2 | Credential validity | Signature, nonce, timestamp valid | Signature invalid or replay/skew violation | `AUTH_CREDENTIAL_INVALID` |
| 3 | Explicit deny | No applicable deny rules | Any deny rule applies | `AUTH_EXPLICIT_DENY` |
| 4 | Scope match | Requested scope within grant envelope | Scope outside envelope | `AUTH_SCOPE_DENIED` |
| 5 | Permission match | Requested action granted | Action missing from grants | `AUTH_PERMISSION_DENIED` |
| 6 | Delegation depth | Chain depth <= allowed maximum | Depth exceeds ancestor limit | `AUTH_DEPTH_EXCEEDED` |
| 7 | Expiry window | Request time <= effective expiry | Grant or credential expired | `AUTH_GRANT_EXPIRED` |

## Verification hooks
- **HOOK-CONTRACT-POLICY-ORDER**: Validate evaluation order and short-circuit semantics against decision-table sequence.
- **HOOK-AUTH-INHERITANCE-BOUNDARY**: Validate descendant grants do not exceed ancestor boundaries.
- **HOOK-AUTH-DECISION-REASON-MAPPING**: Validate one-to-one mapping between decision reason codes and API error codes.

## Drift notes
- Reason-to-error mapping is automated via `composer test:contract:auth-reasons`; policy-order verification is automated via `composer test:contract:auth`.

## See also
- [Authorization And Delegation Spec](./AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
