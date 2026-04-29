---
doc_id: CRE8-MACHINE-PROSE-OPENAPI-PARITY
version: 1.0.0
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

## Parity matrix
| route_id | inventory_method | inventory_path | openapi_method | openapi_path | parity_status | route_family | depth_priority | primary_requirement_id | primary_hook_id | parity_depth_status | success_schema_ref | error_schema_ref |
|---|---|---|---|---|---|---|---|---|---|---|---|---|
| CRE8-ROUTE-0001 | GET | /v1/system/health | GET | /v1/system/health | in_sync | system_health | baseline | CRE8-CONTRACT-REQ-0020 | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | baseline_complete | #/components/schemas/SuccessEnvelope | #/components/schemas/ErrorEnvelope |
| CRE8-ROUTE-0002 | POST | /v1/authz/decide | POST | /v1/authz/decide | in_sync | auth_decision | high | CRE8-AUTH-REQ-0010 | HOOK-CONTRACT-POLICY-ORDER | depth_in_progress | #/components/schemas/AuthzDecisionSuccessEnvelope | #/components/schemas/ErrorEnvelope |
| CRE8-ROUTE-0003 | POST | /v1/keys/{key_id}/lifecycle/suspend | POST | /v1/keys/{key_id}/lifecycle/suspend | in_sync | key_lifecycle | high | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | depth_in_progress | #/components/schemas/LifecycleSuspendSuccessEnvelope | #/components/schemas/ErrorEnvelope |
| CRE8-ROUTE-0004 | GET | /v1/feed/items | GET | /v1/feed/items | in_sync | feed_audience | high | CRE8-FEED-REQ-0021 | HOOK-FEED-INTERACTION-DENY-MAPPING | depth_in_progress | #/components/schemas/FeedItemsSuccessEnvelope | #/components/schemas/ErrorEnvelope |
| CRE8-ROUTE-0005 | POST | /v1/keys/{key_id}/lifecycle/revoke | POST | /v1/keys/{key_id}/lifecycle/revoke | in_sync | key_lifecycle | high | CRE8-SEC-REQ-0006 | HOOK-SEC-LIFECYCLE-PROPAGATION | depth_in_progress | #/components/schemas/LifecycleRevokeSuccessEnvelope | #/components/schemas/ErrorEnvelope |

## Verification hooks
- **HOOK-CONTRACT-ROUTE-INVENTORY-PARITY**: Execute `composer docs:ssot:route-parity` and block merge if drift is detected.

## See also
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Route Inventory Reference](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [OpenAPI Contract](./openapi/cre8.v1.yaml)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
