---
doc_id: CRE8-CONTRACTS-ERROR-CATALOG
version: 1.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Security WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-13
source_seed_refs:
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Error Code Catalog

## Purpose
Define canonical API error envelope and stable error-code semantics for deterministic client handling and operator diagnostics.

## Normative requirements
- **CRE8-CONTRACT-REQ-0001**: Every non-2xx API response **MUST** use a stable JSON error envelope with fields: `error.code`, `error.message`, `error.category`, `error.request_id`, and `error.timestamp_utc`.
- **CRE8-CONTRACT-REQ-0002**: Error `code` values **MUST** be globally unique, uppercase snake-case strings, and **MUST NOT** be repurposed with different semantics once published.
- **CRE8-CONTRACT-REQ-0003**: Authorization and delegation failures **MUST** map to deterministic codes (`AUTH_DENY_*`) bound to policy-deny classes from `AUTHORIZATION_AND_DELEGATION_SPEC.md`.
- **CRE8-CONTRACT-REQ-0004**: 5xx responses **MUST NOT** expose secrets, key material, stack traces, or internal policy state in `error.message`.
- **CRE8-CONTRACT-REQ-0005**: Validation failures **SHOULD** include machine-parseable `details[]` entries with field path and violation type.
- **CRE8-CONTRACT-REQ-0006**: Error catalog updates **MUST** include contract test updates and traceability matrix updates in the same change.

## Baseline categories
- `AUTH_DENY_*`: authorization/delegation denials.
- `AUTHN_*`: authentication/proof validation failures.
- `INPUT_*`: request schema/semantic validation failures.
- `LIFECYCLE_*`: lifecycle state constraints (suspended/revoked/expired).
- `SYSTEM_*`: server/runtime failure classes.


## Baseline canonical error codes
| code | category | default_http_status | description |
|---|---|---:|---|
| AUTH_CREDENTIAL_INVALID | AUTHN | 401 | Credential proof is missing, malformed, expired, or cryptographically invalid. |
| AUTH_PERMISSION_DENIED | AUTH_DENY | 403 | Principal lacks required permission for requested operation. |
| AUTH_EXPLICIT_DENY | AUTH_DENY | 403 | Policy contains an explicit deny rule for the evaluated scope or action. |
| AUTH_SCOPE_DENIED | AUTH_DENY | 403 | Principal permission exists but requested scope boundary is not satisfied. |
| AUTH_DEPTH_EXCEEDED | AUTH_DENY | 403 | Delegation depth exceeds ancestor-defined maximum depth budget. |
| AUTH_GRANT_EXPIRED | AUTH_DENY | 403 | Grant or delegated credential is outside the allowed expiry window. |
| AUTH_LIFECYCLE_BLOCKED | LIFECYCLE | 403 | Principal or key lifecycle state blocks request authorization. |
| AUTH_POLICY_UNRESOLVED | AUTH_DENY | 403 | Policy context is missing or ambiguous and is resolved as deterministic deny. |

## Verification hooks
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE**: Verify all route inventory `error_code_set` declarations resolve to documented catalog codes.
- **HOOK-CONTRACT-ERROR-DETERMINISM**: Verify stable envelope shape and code mapping behavior.
- **HOOK-CONTRACT-ERROR-SECRETS-REDaction**: Verify sensitive data is absent from server error payloads.

## See also
- [API Contract Guide](./API_CONTRACT_GUIDE.md)
- [Authorization And Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [API Contract and Error Seed](../../seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md)
