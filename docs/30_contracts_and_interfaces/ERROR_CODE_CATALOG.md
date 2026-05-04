---
doc_id: CRE8-CONTRACTS-ERROR-CATALOG
version: 1.2.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Security WG
  - Identity & Policy WG
last_reviewed_utc: 2026-05-04
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
- **CRE8-CONTRACT-REQ-0003**: Authorization and delegation failures **MUST** map to deterministic codes (`AUTH_DENY_*`) bound to policy-deny classes from [`AUTHORIZATION_AND_DELEGATION_SPEC.md`](AUTHORIZATION_AND_DELEGATION_SPEC.md).
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
| AUTH_DENY_PERMISSION_UNKNOWN | AUTH_DENY | 403 | One or more evaluated permission tokens are unknown to the canonical registry and are denied deterministically. |
| AUTH_EXPLICIT_DENY | AUTH_DENY | 403 | Policy contains an explicit deny rule for the evaluated scope or action. |
| AUTH_SCOPE_DENIED | AUTH_DENY | 403 | Principal permission exists but requested scope boundary is not satisfied. |
| AUTH_DEPTH_EXCEEDED | AUTH_DENY | 403 | Delegation depth exceeds ancestor-defined maximum depth budget. |
| AUTH_GRANT_EXPIRED | AUTH_DENY | 403 | Grant or delegated credential is outside the allowed expiry window. |
| AUTH_LIFECYCLE_BLOCKED | LIFECYCLE | 403 | Principal or key lifecycle state blocks request authorization. |
| AUTH_POLICY_UNRESOLVED | AUTH_DENY | 403 | Policy context is missing or ambiguous and is resolved as deterministic deny. |
| SYSTEM_INTERNAL_ERROR | SYSTEM | 500 | Internal processing failed; response is redacted and correlation-friendly for operators. |
| INPUT_VALIDATION_FAILED | INPUT | 400 | Request body or query payload failed schema or semantic validation checks. |
| INPUT_FIELD_MISSING | INPUT | 400 | Required field missing from request payload. |
| INPUT_FIELD_INVALID | INPUT | 400 | Provided field value violates format, range, or enum constraints. |
| LIFECYCLE_TRANSITION_INVALID | LIFECYCLE | 409 | Requested lifecycle transition is not allowed from current state. |
| LIFECYCLE_ALREADY_TERMINAL | LIFECYCLE | 409 | Requested lifecycle action targets an already terminal state. |
| RESOURCE_NOT_FOUND | INPUT | 404 | Target resource identifier does not resolve to an accessible record. |
| RESOURCE_CONFLICT | INPUT | 409 | Requested create/update conflicts with unique constraints or invariants. |
| RATE_LIMITED | SYSTEM | 429 | Request exceeded per-scope rate limits and must be retried later. |
| INTEGRATION_UPSTREAM_UNAVAILABLE | SYSTEM | 503 | Required upstream integration is unavailable or timing out. |
| INTEGRATION_INVALID_SIGNATURE | AUTHN | 401 | Integration signature/JWT verification failed deterministic checks. |

## Verification hooks
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE**: Verify all route inventory `error_code_set` declarations resolve to documented catalog codes.
- **HOOK-CONTRACT-ERROR-DETERMINISM**: Verify stable envelope shape and code mapping behavior.
- **HOOK-CONTRACT-ERROR-SECRETS-REDACTION**: Verify sensitive data is absent from server error payloads.

## See also
- [API Contract Guide](./API_CONTRACT_GUIDE.md)
- [Authorization And Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [API Contract and Error Seed](../../seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)

## Change history

- 2026-05-04 (v1.2.0): Added `AUTH_DENY_PERMISSION_UNKNOWN` to align permission-vocabulary unknown-token deny semantics with canonical error catalog during Phase 4 slice P4-S2.2.


## Envelope and endpoint-context mapping
- **CRE8-CONTRACT-REQ-0007**: Every catalog code **MUST** map to `#/components/schemas/ErrorEnvelope` in OpenAPI and **MUST** be referenced by at least one endpoint context in [`ROUTE_INVENTORY_REFERENCE.md`](ROUTE_INVENTORY_REFERENCE.md) or [`PROSE_OPENAPI_PARITY_TABLE.md`](PROSE_OPENAPI_PARITY_TABLE.md).
- **CRE8-CONTRACT-REQ-0008**: Authorization deny codes (`AUTH_DENY_*`) **MUST** only appear on routes that declare delegated-policy evaluation and **MUST NOT** be emitted by unauthenticated bootstrap routes.

| code family | openapi schema ref | endpoint context families |
|---|---|---|
| AUTH_DENY_* | `#/components/schemas/ErrorEnvelope` | `auth_decision`, `feed_audience`, `key_lifecycle`, `comment_interaction`, `post_management` |
| AUTHN_* | `#/components/schemas/ErrorEnvelope` | all authenticated route families |
| INPUT_* | `#/components/schemas/ErrorEnvelope` | all routes with request/query validation |
| LIFECYCLE_* | `#/components/schemas/ErrorEnvelope` | `key_lifecycle`, delegated interaction routes |
| SYSTEM_* | `#/components/schemas/ErrorEnvelope` | all route families |
