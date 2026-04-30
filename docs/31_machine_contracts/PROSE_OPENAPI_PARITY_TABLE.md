---
doc_id: CRE8-MACHINE-PROSE-OPENAPI-PARITY
version: 2.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Docs Governance WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
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
- **CRE8-MACHINE-REQ-0010**: Each parity-row `error_codes` value **MUST** reference only canonical codes from `ERROR_CODE_CATALOG.md` and **MUST** be contained within the route `error_code_set` declared in `ROUTE_INVENTORY_REFERENCE.md`.
- **CRE8-MACHINE-REQ-0011**: For each route, every non-baseline deny code in `ROUTE_INVENTORY_REFERENCE.md#error_code_set` **MUST** be represented in parity-row `error_codes` to prevent deny-mapping undercoverage.
- **CRE8-MACHINE-REQ-0012**: Route Family Coverage Policy rows **MUST** include every route family derivable from active route inventory permission namespaces; missing family policy rows **MUST** fail parity checks.
- **CRE8-MACHINE-REQ-0013**: Every Route Family Coverage Policy row **MUST** declare accountable `owner` and `decision_ref`; `decision_ref` **MUST** reference `ADR-###` or `DLOG-YYYYMMDD-###` to preserve deferred-breadth governance linkage.
- **CRE8-MACHINE-REQ-0014**: Every Route Family Coverage Policy `decision_ref` **MUST** resolve to an existing ADR in `ADR_INDEX.md` or decision event in `DECISIONS_LOG.md`; format-only references are insufficient.
- **CRE8-MACHINE-REQ-0015**: Every Route Family Coverage Policy `owner` **MUST** resolve to an approved team present in `TRACEABILITY_MATRIX.md` owner taxonomy (non-empty canonical owner column values).
- **CRE8-MACHINE-REQ-0016**: Every Route Family Coverage Policy row with `decision_ref=ADR-003` **MUST** map to a `P2-DB-*` deferred breadth row in `reports/session_handoffs/archive/2026-04/PHASE2_PROGRESS_BOARD.md` whose owner matches the policy `owner` and whose hook set contains the policy `primary_hook_id`; parity checks **MUST** fail on missing/mismatched linkage.
- **CRE8-MACHINE-REQ-0017**: Every Route Family Coverage Policy row with `decision_ref=ADR-003` **MUST** declare `phase2_due_date_utc` in `YYYY-MM-DD`; the date **MUST** equal the matching `P2-DB-*` row due date in `PHASE2_PROGRESS_BOARD.md`.
- **CRE8-MACHINE-REQ-0018**: For every `decision_ref=ADR-003` route family, parity depth closure **MUST** be status-aligned with deferred breadth status in `PHASE2_PROGRESS_BOARD.md`: policy rows tied to deferred rows not marked `complete` **MUST NOT** set all family routes to `parity_depth_status=depth_complete`; parity checks **MUST** fail on premature closure drift.
- **CRE8-MACHINE-REQ-0019**: For every parity row with `primary_hook_id=HOOK-FEED-INTERACTION-DENY-MAPPING`, declared `error_example_refs` **MUST** resolve to OpenAPI examples whose error payload shape enforces canonical `error.code`/`error.category`, approved `request_id` prefixes, and parseable ISO-8601 `timestamp_utc`; parity checks **MUST** fail when fixture payload-shape semantics drift.


## Route Family Coverage Policy
| route_family | minimum_high_priority_routes | primary_requirement_id | primary_hook_id | owner | decision_ref | phase2_due_date_utc | notes |
|---|---:|---|---|---|---|---|---|
| system_health | 0 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | API Contracts WG | ADR-004 | n/a | System health + metadata routes. |
| auth_decision | 1 | CRE8-AUTH-REQ-0010 | HOOK-CONTRACT-POLICY-ORDER | Identity & Policy WG | ADR-004 | n/a | Authorization decision contract family. |
| key_lifecycle | 2 | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | Security Engineering WG | ADR-004 | n/a | Suspend/revoke/rotate lifecycle controls. |
| feed_audience | 1 | CRE8-FEED-REQ-0022 | HOOK-FEED-INTERACTION-DENY-MAPPING | Product Policy WG | ADR-004 | n/a | Feed audience retrieval and deny-mapping coverage. |
| principal_management | 1 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | Identity & Policy WG | ADR-004 | n/a | Principal issuance and bootstrap identity operations. |
| delegation_management | 1 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | Identity & Policy WG | ADR-004 | n/a | Delegation create/revoke operations. |
| audience_management | 1 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | Product Policy WG | ADR-004 | n/a | Audience-group CRUD operations. |
| post_management | 1 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | Product Policy WG | ADR-004 | n/a | Post CRUD operations. |
| comment_interaction | 1 | CRE8-CONTRACT-REQ-0020 | HOOK-FEED-INTERACTION-DENY-MAPPING | Product Policy WG | ADR-004 | n/a | Comment creation and listing operations. |
| audit_export | 1 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | Operations Quality WG | ADR-004 | n/a | Audit export creation operation. |
| system_meta | 0 | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | API Contracts WG | ADR-004 | n/a | System version and system info metadata routes. |

## Parity matrix
| route_id | inventory_method | inventory_path | openapi_method | openapi_path | parity_status | route_family | depth_priority | primary_requirement_id | primary_hook_id | parity_depth_status | success_schema_ref | error_schema_ref | success_status_codes | error_status_codes | error_example_refs | error_codes |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| CRE8-ROUTE-0001 | GET | /v1/system/health | GET | /v1/system/health | in_sync | system_health | baseline | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | baseline_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 401,500 | #/components/examples/ErrorCredentialInvalid,#/components/examples/ErrorSystemRedacted | AUTH_CREDENTIAL_INVALID,SYSTEM_INTERNAL_ERROR |
| CRE8-ROUTE-0002 | POST | /v1/authz/decide | POST | /v1/authz/decide | in_sync | auth_decision | high | CRE8-AUTH-REQ-0010 | HOOK-CONTRACT-POLICY-ORDER | depth_in_progress | #/components/schemas/AuthzDecisionSuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 400,403 | #/components/examples/ErrorExplicitDeny,#/components/examples/ErrorPermissionDenied,#/components/examples/ErrorScopeDenied,#/components/examples/ErrorAuthDepthExceeded,#/components/examples/ErrorGrantExpired,#/components/examples/ErrorMultiAncestorDepthExceeded,#/components/examples/ErrorMultiAncestorGrantExpired,#/components/examples/ErrorFeedLifecycleBlocked,#/components/examples/ErrorInteractionLifecycleBlocked | AUTH_EXPLICIT_DENY,AUTH_PERMISSION_DENIED,AUTH_SCOPE_DENIED,AUTH_DEPTH_EXCEEDED,AUTH_GRANT_EXPIRED,AUTH_LIFECYCLE_BLOCKED |
| CRE8-ROUTE-0003 | POST | /v1/keys/{key_id}/lifecycle/suspend | POST | /v1/keys/{key_id}/lifecycle/suspend | in_sync | key_lifecycle | high | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | depth_in_progress | #/components/schemas/LifecycleSuspendSuccessEnvelope | #/components/schemas/ErrorEnvelope | 202 | 403 | #/components/examples/ErrorLifecycleBlocked | AUTH_LIFECYCLE_BLOCKED |
| CRE8-ROUTE-0004 | GET | /v1/feed/items | GET | /v1/feed/items | in_sync | feed_audience | high | CRE8-FEED-REQ-0022 | HOOK-FEED-INTERACTION-DENY-MAPPING | depth_complete | #/components/schemas/FeedItemsSuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied,#/components/examples/ErrorScopeDenied,#/components/examples/ErrorAuthDepthExceeded,#/components/examples/ErrorGrantExpired,#/components/examples/ErrorFeedLifecycleBlocked | AUTH_PERMISSION_DENIED,AUTH_SCOPE_DENIED,AUTH_DEPTH_EXCEEDED,AUTH_GRANT_EXPIRED,AUTH_LIFECYCLE_BLOCKED |
| CRE8-ROUTE-0005 | POST | /v1/keys/{key_id}/lifecycle/revoke | POST | /v1/keys/{key_id}/lifecycle/revoke | in_sync | key_lifecycle | high | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | depth_in_progress | #/components/schemas/LifecycleRevokeSuccessEnvelope | #/components/schemas/ErrorEnvelope | 202 | 403 | #/components/examples/ErrorLifecycleBlocked | AUTH_LIFECYCLE_BLOCKED |
| CRE8-ROUTE-0006 | POST | /v1/principals | POST | /v1/principals | in_sync | principal_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 201 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0007 | POST | /v1/keys/id | POST | /v1/keys/id | in_sync | principal_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 201 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0008 | POST | /v1/keys/utility | POST | /v1/keys/utility | in_sync | principal_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 201 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0009 | POST | /v1/keys/{key_id}/lifecycle/rotate | POST | /v1/keys/{key_id}/lifecycle/rotate | in_sync | key_lifecycle | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 202 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0010 | POST | /v1/delegations | POST | /v1/delegations | in_sync | delegation_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 201 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0011 | DELETE | /v1/delegations/{delegation_id} | DELETE | /v1/delegations/{delegation_id} | in_sync | delegation_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0012 | GET | /v1/audience-groups | GET | /v1/audience-groups | in_sync | audience_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0013 | POST | /v1/audience-groups | POST | /v1/audience-groups | in_sync | audience_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 201 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0014 | PATCH | /v1/audience-groups/{id} | PATCH | /v1/audience-groups/{id} | in_sync | audience_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0015 | DELETE | /v1/audience-groups/{id} | DELETE | /v1/audience-groups/{id} | in_sync | audience_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0016 | POST | /v1/posts | POST | /v1/posts | in_sync | post_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 201 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0017 | GET | /v1/posts/{id} | GET | /v1/posts/{id} | in_sync | post_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0018 | PATCH | /v1/posts/{id} | PATCH | /v1/posts/{id} | in_sync | post_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0019 | DELETE | /v1/posts/{id} | DELETE | /v1/posts/{id} | in_sync | post_management | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0020 | POST | /v1/posts/{id}/comments | POST | /v1/posts/{id}/comments | in_sync | comment_interaction | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 201 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0021 | GET | /v1/posts/{id}/comments | GET | /v1/posts/{id}/comments | in_sync | comment_interaction | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0022 | POST | /v1/audit/exports | POST | /v1/audit/exports | in_sync | audit_export | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 202 | 403 | #/components/examples/ErrorPermissionDenied | AUTH_PERMISSION_DENIED |
| CRE8-ROUTE-0023 | GET | /v1/system/version | GET | /v1/system/version | in_sync | system_meta | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 500 | #/components/examples/ErrorSystemRedacted | SYSTEM_INTERNAL_ERROR |
| CRE8-ROUTE-0024 | GET | /v1/system/info | GET | /v1/system/info | in_sync | system_meta | high | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | depth_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope | 200 | 500 | #/components/examples/ErrorSystemRedacted | SYSTEM_INTERNAL_ERROR |

## Verification hooks
- **HOOK-CONTRACT-ROUTE-INVENTORY-PARITY**: Execute `composer docs:ssot:route-parity` and block merge if drift is detected.

## See also
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Route Inventory Reference](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [OpenAPI Contract](./openapi/cre8.v1.yaml)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
- Version policy authority: `CONTRACT_VERSION_POLICY.md`
