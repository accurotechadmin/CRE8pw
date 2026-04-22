# Authorization and Delegation Spec

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

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

## Human-readable key class intent
- `primary_author`: broad delegated authoring role that may mint descendants only within inherited envelope bounds.
- `secondary_author`: constrained delegated authoring role with narrower mint authority and envelope-bound limits.
- `use`: consumption/interaction role (for example feed read/comment where policy permits) and no mint authority.
- `keychain`: aggregate key principal for collaborative access, governed through owner-controlled membership and effective-resolution rules.

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
- Child envelope must be a strict subset of parent permissions/scope (no unlimited-over-parent delegation is permitted).
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

## Owner bootstrap invitation requirement
- Default owner bootstrap policy requires a valid invite code at `POST /console/owners`.
- Deployments may enable open owner signup only through explicit configuration (`OWNER_SIGNUP_MODE=open`) and documented evidence.

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
- `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`
- `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`


## Device-bound token invariant
- Gateway key JWTs are minted with a mandatory `device_id` claim tied to the authenticating client device.
- Runtime validation requires strict equality between JWT `device_id` claim and `X-Device-Id` header on protected gateway routes.
- Device mismatch invalidates the token for that request and is treated as non-transferable credential enforcement.


## Non-owner participation model
- Non-owner actors can access the platform with key credentials and do not require local username/email/password registration in the default delegated model.
- Owner credentials remain governance-scoped and are not reused as keychain members.
