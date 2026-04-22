# Authorization and Delegation Spec

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Scope
Defines principals, key classes, delegation bounds, keychain aggregation behavior, and route-surface authorization behavior for CRE8 v1.

## Principals
- **Owner principal:** governance and console authority.
- **Key principal:** gateway content authority.

## Key classes
- `master` (owner-only SYSADMIN class)
- `primary_author`
- `secondary_author`
- `use`
- `keychain` (v1 production-active)

## Permission model (v1 allow-list)
Canonical permission vocabulary:
- `posts:read`
- `posts:create`
- `posts:edit`
- `comments:create`
- `keys:issue`
- `keys:revoke`
- `keychains:manage`

## Delegation invariants
- Child envelope must be a strict subset of parent permissions/scope.
- Delegation max depth is `3`.
- Delegated credentials must carry explicit expiry.
- Delegation lineage must be preserved for token claim checks.

## Keychain invariants (v1 production)
- Keychains are key principals with `key_class=keychain` and credential material equivalent to other key principals.
- Keychain members may include only `primary_author`, `secondary_author`, and `use` keys.
- Keychain-in-keychain membership is forbidden.
- Max keychain membership size is `50`.
- Effective permissions are computed as set-union across active members, then constrained by explicit keychain policy envelope.
- Scope merge is union for positive scope tokens; restrictive dimensions use intersection where policy families define restrictive semantics.
- Any revoked/suspended/cancelled member contributes no effective permissions/scope.
- Keychain actions must record both keychain actor and resolved source-key lineage references.

## Surface enforcement model
- **Console (`/console/api/*`)**: owner JWT (`typ=owner`, console audience).
- **Gateway (`/api/*`)**: key JWT (`typ=key`, gateway audience) + device guard where required.
- **Keychain management routes** are console-governed and require owner JWT plus `keychains:manage` policy authorization.

## Lifecycle authority
- Owners can issue/revoke/suspend/cancel keys under governance policy.
- Key rotation authority follows delegated envelope and governance policy rules.
- Key principals may mint descendants only within delegated envelope bounds.
- Keychain creation and membership mutation are owner-governed operations in v1.
- Revocation may be local or cascading according to lineage policy.

## Related SSOT docs
- `SECURITY_CONTROLS_SPEC.md`
- `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- `DATA_MODEL_REFERENCE.md`
- `ROUTE_INVENTORY_REFERENCE.md`


## Device-bound token invariant
- Gateway key JWTs are minted with a mandatory `device_id` claim tied to the authenticating client device.
- Runtime validation requires strict equality between JWT `device_id` claim and `X-Device-Id` header on protected gateway routes.
- Device mismatch invalidates the token for that request and is treated as non-transferable credential enforcement.
