---
doc_id: CRE8-CONTRACTS-ROUTE-INVENTORY
version: 1.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - seed/
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
normative_dependencies:
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
---

# Route Inventory Reference

## Purpose
Define the minimum authoritative route inventory schema and parity obligations for all CRE8 HTTP interfaces.

## Normative requirements
- **CRE8-CONTRACT-REQ-0020**: The inventory table **MUST** contain one row per externally callable route with unique `route_id`.
- **CRE8-CONTRACT-REQ-0021**: Each row **MUST** include `method`, `path`, `auth_model`, `required_permission`, `scope_type`, `success_status`, and `error_code_set`.
- **CRE8-CONTRACT-REQ-0022**: `method`+`path` combinations **MUST NOT** be duplicated across active route rows.
- **CRE8-CONTRACT-REQ-0023**: Any route marked `deprecated` **MUST** include `sunset_utc` and `replacement_route_id`.
- **CRE8-CONTRACT-REQ-0024**: Inventory updates **MUST** occur in the same change set as related OpenAPI and API guide updates.

## Inventory schema (authoritative columns)
| Column | Required | Description |
|---|---|---|
| route_id | yes | Stable route identifier (`CRE8-ROUTE-####`). |
| method | yes | HTTP method. |
| path | yes | Absolute API path. |
| auth_model | yes | `public`, `id-key`, `utility-key`, `delegated`. |
| required_permission | yes | Permission token required to authorize request. |
| scope_type | yes | Scope family (`tenant`, `group`, `resource`, `global`). |
| success_status | yes | Deterministic success status code(s). |
| error_code_set | yes | Comma-separated codes from `ERROR_CODE_CATALOG.md`. |
| lifecycle | yes | `active`, `deprecated`, `sunset`. |
| sunset_utc | conditional | Required if lifecycle is `deprecated` or `sunset`. |
| replacement_route_id | conditional | Required if lifecycle is `deprecated` or `sunset`. |

## Baseline route inventory (Phase 1 promoted rows)
| route_id | method | path | auth_model | required_permission | scope_type | success_status | error_code_set | lifecycle | sunset_utc | replacement_route_id |
|---|---|---|---|---|---|---|---|---|---|---|
| CRE8-ROUTE-0001 | GET | /v1/system/health | public | system.health.read | global | 200 | AUTH_CREDENTIAL_INVALID,SYSTEM_INTERNAL_ERROR | active |  |  |
| CRE8-ROUTE-0002 | POST | /v1/authz/decide | delegated | authz.decide | resource | 200 | AUTH_CREDENTIAL_INVALID,AUTH_PERMISSION_DENIED,AUTH_SCOPE_DENIED,AUTH_DEPTH_EXCEEDED,AUTH_GRANT_EXPIRED,AUTH_LIFECYCLE_BLOCKED | active |  |  |
| CRE8-ROUTE-0003 | POST | /v1/keys/{key_id}/lifecycle/suspend | id-key | key.lifecycle.suspend | resource | 202 | AUTH_CREDENTIAL_INVALID,AUTH_PERMISSION_DENIED,AUTH_LIFECYCLE_BLOCKED | active |  |  |
| CRE8-ROUTE-0004 | GET | /v1/feed/items | utility-key | feed.items.read | group | 200 | AUTH_CREDENTIAL_INVALID,AUTH_PERMISSION_DENIED,AUTH_SCOPE_DENIED,AUTH_DEPTH_EXCEEDED,AUTH_GRANT_EXPIRED,AUTH_LIFECYCLE_BLOCKED | active |  |  |
| CRE8-ROUTE-0005 | POST | /v1/keys/{key_id}/lifecycle/revoke | id-key | key.lifecycle.revoke | resource | 202 | AUTH_CREDENTIAL_INVALID,AUTH_PERMISSION_DENIED,AUTH_LIFECYCLE_BLOCKED | active |  |  |

## Verification hooks
- **HOOK-CONTRACT-ROUTE-INVENTORY-PARITY**: Validate method/path parity with OpenAPI entries.
- **HOOK-CONTRACT-ROUTE-UNIQUENESS**: Validate uniqueness of `method`+`path` and `route_id` values.
- **HOOK-CONTRACT-DEPRECATION-SCHEMA**: Execute `composer docs:ssot:deprecation-schema` to validate sunset/replacement completeness and identifier format for `deprecated`/`sunset` routes.

## Drift notes
- Route inventory rows are synchronized with current OpenAPI baseline and MUST be updated in the same changeset when either source changes.

## See also
- [API Contract Guide](./API_CONTRACT_GUIDE.md)
- [OpenAPI Contract](../31_machine_contracts/openapi/cre8.v1.yaml)
- [Prose↔OpenAPI Parity Table](../31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md)
- [Error Code Catalog](./ERROR_CODE_CATALOG.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
