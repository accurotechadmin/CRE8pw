# Master Key Spec

_Status: adopted_
_Last updated (UTC): 2026-04-21_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Define the production contract for Master-Key-Level credentials used exclusively for owner-governed SYSADMIN system access.

## Principal and key-class definition
- Key class: `master` (Master-Key-Level).
- Principal type: owner-governed, non-delegable system-administration principal.
- Scope: system-governance and platform administrative operations only.

## Authorization constraints
- Master keys are reserved for **Owners**.
- Master-key tokens are valid only for SYSADMIN-designated surfaces and never for gateway content-authoring routes.
- Master keys cannot be minted by key principals (`primary_author`, `secondary_author`, `use`, or `keychain`).
- Master keys do not participate in keychain membership.

## Rotation and ownership invariant
- Only the Owner who is the recorded owner of a Master Key may trigger rotation for that Master Key.
- Rotation requests from any other owner or delegated actor MUST be denied with `403 forbidden` (`permission_denied`).
- Rotation must preserve an auditable lineage event linking previous key id, rotated key id, owner id, request id, and UTC timestamp.

## Lifecycle and operational controls
- Mandatory short-lived access token TTL and explicit rotation cadence enforcement.
- Compromise response requires immediate revoke + rotate sequence under incident policy.
- All Master-key usage events are high-severity audit events and must include correlation/request IDs.

## Cross-document synchronization requirements
Any change to this spec requires same-PR updates to:
- `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md` (if routes change)
- `docs/ssot_canon/openapi/cre8.v1.yaml` (for interface-shape changes)
