# Authorization and Delegation Spec

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Scope
Defines principals, key classes, delegation bounds, and route-surface authorization behavior for CRE8 v1.

## Principals
- **Owner principal:** governance and console authority.
- **Key principal:** gateway content authority.

## Key classes
- `primary_author`
- `secondary_author`
- `use`
- `keychain` (extension-scoped; not required for v1 production baseline)

## Permission model (v1 allow-list)
Canonical permission vocabulary:
- `posts:read`
- `posts:create`
- `posts:edit`
- `comments:create`
- `keys:issue`
- `keys:revoke`

## Delegation invariants
- Child envelope must be a strict subset of parent permissions/scope.
- Delegation max depth is `3`.
- Delegated credentials must carry explicit expiry.
- Delegation lineage must be preserved for token claim checks.

## Surface enforcement model
- **Console (`/console/api/*`)**: owner JWT (`typ=owner`, console audience).
- **Gateway (`/api/*`)**: key JWT (`typ=key`, gateway audience) + device guard where required.

## Lifecycle authority
- Owners can issue/revoke/suspend/cancel keys under governance policy.
- Key principals may mint descendants only within delegated envelope bounds.
- Revocation may be local or cascading according to lineage policy.

## Related SSOT docs
- `Security_Reference.md`
- `Request_Pipeline_Reference.md`
- `Data_Model_Reference.md`
