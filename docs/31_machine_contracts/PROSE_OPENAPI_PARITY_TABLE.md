---
doc_id: CRE8-MACHINE-PROSE-OPENAPI-PARITY
version: 1.2.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Docs Governance WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
normative_dependencies:
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md
---

# Prose↔OpenAPI Parity Table

## Purpose
Define the authoritative parity mapping between route inventory prose and OpenAPI operations for Phase 1 machine-contract synchronization.

## Normative requirements
- **CRE8-MACHINE-REQ-0001**: Every active route in `ROUTE_INVENTORY_REFERENCE.md` **MUST** have exactly one matching OpenAPI `path` + `method` tuple.
- **CRE8-MACHINE-REQ-0002**: The parity table **MUST** be updated in the same change set as any route addition, removal, or method/path change.
- **CRE8-MACHINE-REQ-0003**: Parity validation **MUST** pass `composer docs:ssot:route-parity` before merge for contract-impacting changes.
- **CRE8-MACHINE-REQ-0004**: Each parity row `primary_requirement_id` and `primary_hook_id` **MUST** resolve to active entries in `TRACEABILITY_MATRIX.md`.
- **CRE8-MACHINE-REQ-0005**: Each parity row **MUST** declare the complete error example and error code set exposed by OpenAPI error statuses (no omissions/additions).
- **CRE8-MACHINE-REQ-0006**: The parity table **MUST NOT** contain duplicate `route_id` rows.
- **CRE8-MACHINE-REQ-0007**: Every parity row `route_family` **MUST** be represented in a Route Family Coverage Policy table with explicit `minimum_high_priority_routes` threshold.
- **CRE8-MACHINE-REQ-0008**: For each route family, the count of `depth_priority=high` rows in the parity matrix **MUST** be greater than or equal to the declared minimum threshold.
- **CRE8-MACHINE-REQ-0009**: `parity_depth_status` values **MUST** use only `baseline_complete`, `depth_in_progress`, or `depth_complete`.

## Route Family Coverage Policy
| route_family | minimum_high_priority_routes | primary_requirement_id | primary_hook_id | notes |
|---|---:|---|---|---|
| system_health | 0 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | Baseline-only family; high-priority depth not required. |
| auth_decision | 1 | CRE8-AUTH-REQ-0010 | HOOK-CONTRACT-POLICY-ORDER | High-risk authorization family under ADR-003 depth expansion. |
| key_lifecycle | 2 | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | Includes suspend and revoke lifecycle controls. |
| feed_audience | 1 | CRE8-FEED-REQ-0021 | HOOK-FEED-INTERACTION-DENY-MAPPING | Interaction deny mapping and audience safeguards are high priority. |

## Parity matrix
| route_id | inventory_method | inventory_path | openapi_method | openapi_path | parity_status | route_family | depth_priority | primary_requirement_id | primary_hook_id | parity_depth_status | success_schema_ref | error_schema_ref | success_status_codes | error_status_codes | error_example_refs | error_codes |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| CRE8-ROUTE-0001 | GET | /v1/system/health | GET | /v1/system/health | in_sync | system_health | baseline | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | baseline_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 401,500 | #/components/examples/ErrorCredentialInvalid,#/components/examples/ErrorSystemRedacted | AUTH_CREDENTIAL_INVALID,SYSTEM_INTERNAL_ERROR |
| CRE8-ROUTE-0002 | POST | /v1/authz/decide | POST | /v1/authz/decide | in_sync | auth_decision | high | CRE8-AUTH-REQ-0010 | HOOK-CONTRACT-POLICY-ORDER | depth_in_progress | #/components/schemas/AuthzDecisionSuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 400,403 | #/components/examples/ErrorScopeDenied,#/components/examples/ErrorAuthDepthExceeded,#/components/examples/ErrorGrantExpired,#/components/examples/ErrorFeedLifecycleBlocked,#/components/examples/ErrorInteractionLifecycleBlocked | AUTH_SCOPE_DENIED,AUTH_DEPTH_EXCEEDED,AUTH_GRANT_EXPIRED,AUTH_LIFECYCLE_BLOCKED |
| CRE8-ROUTE-0003 | POST | /v1/keys/{key_id}/lifecycle/suspend | POST | /v1/keys/{key_id}/lifecycle/suspend | in_sync | key_lifecycle | high | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | depth_in_progress | #/components/schemas/LifecycleSuspendSuccessEnvelope | #/components/schemas/ErrorEnvelope | 202 | 403 | #/components/examples/ErrorLifecycleBlocked | AUTH_LIFECYCLE_BLOCKED |
| CRE8-ROUTE-0004 | GET | /v1/feed/items | GET | /v1/feed/items | in_sync | feed_audience | high | CRE8-FEED-REQ-0021 | HOOK-FEED-INTERACTION-DENY-MAPPING | depth_in_progress | #/components/schemas/FeedItemsSuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied,#/components/examples/ErrorScopeDenied,#/components/examples/ErrorAuthDepthExceeded,#/components/examples/ErrorGrantExpired,#/components/examples/ErrorFeedLifecycleBlocked | AUTH_PERMISSION_DENIED,AUTH_SCOPE_DENIED,AUTH_DEPTH_EXCEEDED,AUTH_GRANT_EXPIRED,AUTH_LIFECYCLE_BLOCKED |
| CRE8-ROUTE-0005 | POST | /v1/keys/{key_id}/lifecycle/revoke | POST | /v1/keys/{key_id}/lifecycle/revoke | in_sync | key_lifecycle | high | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | depth_in_progress | #/components/schemas/LifecycleRevokeSuccessEnvelope | #/components/schemas/ErrorEnvelope | 202 | 403 | #/components/examples/ErrorLifecycleBlocked | AUTH_LIFECYCLE_BLOCKED |

## Verification hooks
- **HOOK-CONTRACT-ROUTE-INVENTORY-PARITY**: Execute `composer docs:ssot:route-parity` and block merge if drift is detected.

## See also
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Route Inventory Reference](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [OpenAPI Contract](./openapi/cre8.v1.yaml)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
