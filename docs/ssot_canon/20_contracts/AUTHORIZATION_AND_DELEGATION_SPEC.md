# Authorization and Delegation Spec

_Status: adopted_
_Last updated (UTC): 2026-04-28_

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
- `use`: consumption/interaction role (including feed-read and comment-create operations where policy permits) and no mint authority.
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
- **Owner-only console governance operations** are evaluated by dedicated owner rule packs in the PDP registry and deny non-owner actors before handler execution.
- All protected routes evaluate authorization through the PDP decision contract (`DecisionContext` -> `Decision`) and route handlers execute only after an explicit allow outcome.

## Canonical PDP decision contract
- `DecisionContext` is the canonical authorization input contract and includes:
  - `request_id`
  - `surface` (`public|gateway|console`)
  - `route_action` (deterministic action identity resolved from route metadata)
  - normalized actor claims (`typ`, `aud`, `sub`, `device_id`, lineage metadata when applicable)
  - resolved principal and delegation envelope inputs
- `Decision` is the canonical authorization output contract and includes:
  - `effect` (`allow|deny`)
  - `http_status`
  - `error_code` (for deny outcomes)
  - `detail_code` (for deny outcomes)
  - `obligations` (route-specific enforcement obligations such as `device_binding_required` and `csrf_required`)
- `PolicyRule` evaluates a `DecisionContext` and returns a deterministic `Decision` contribution under precedence rules defined in `AUTHORIZATION_DECISION_TABLES.md`.
- `Obligation` values are mandatory enforcement constraints, not advisory metadata.

## Policy context builders
- **Owner context builder** produces normalized `DecisionContext` values for console routes and enforces owner-token invariants before policy evaluation.
- **Key context builder** produces normalized `DecisionContext` values for gateway routes, including key lineage, effective delegation envelope inputs, and device-claim context.
- **Route-action resolver** maps each route to one canonical `route_action` used by policy rules and audit evidence.
- `PdpService` evaluates normalized context through `RuleRegistry` and returns authoritative `Decision` outcomes for all protected routes.
- `RuleRegistry` publishes deterministic rule ordering and surface-scoped rule packs, including owner-only console governance rules.
- Route handlers and service methods MUST NOT infer policy context ad hoc; they consume normalized context produced by builders/resolvers and PDP outcomes.

## Policy table externalization and rule loading contract
- `RuleRegistry` consumes canonical policy configuration from:
  - `config/policy/route_actions.php`
  - `config/policy/permissions.php`
  - `config/policy/detail_codes.php`
- `route_actions.php` is the authoritative map from method/path template to `route_action`; route handlers and middleware consume resolver outputs and never maintain parallel route-action maps.
- `permissions.php` is the authoritative map from `route_action` to required permission set and route-class constraints (including `use` mutation restrictions).
- `detail_codes.php` is the authoritative map from deny condition classes to canonical `details.code` values aligned to `ERROR_CODE_CATALOG.md`.
- Policy configuration loading is fail-closed:
  - missing file, malformed structure, duplicate `route_action`, unknown permission token, or unmapped deny condition prevents protected-route startup and records startup evidence.
  - unknown route-action at runtime denies with canonical policy error mapping and audit emission.
- Rule-pack composition is deterministic and immutable at runtime after boot:
  - owner-context rules
  - key-context rules
  - delegation-bound rules
  - keychain invariant rules
  - master-key SYSADMIN boundary rules
  - device-binding obligation rules
- Rule-pack precedence is canonical: auth-context validity -> lifecycle validity -> route-action/permission constraints -> delegation/keychain/master-key/device obligations -> final allow/deny shaping.
- Changes to policy config contracts require synchronized updates to authorization decision tables, verification strategy, traceability matrix, and middleware startup assertions.

## Gateway permission and use-key mutation enforcement
- Gateway authorization rules are bound to canonical `route_action` values and evaluate required permissions before handler execution.
- `GET /api/feed` requires `posts:read`.
- `POST /api/posts` requires `posts:create`.
- `PATCH /api/posts/{postId}` requires `posts:edit`.
- `POST /api/posts/{postId}/flags` requires `posts:read`.
- `GET /api/posts/{postId}/comments` requires `posts:read`.
- `POST /api/posts/{postId}/comments` requires `comments:create`.
- Key class `use` is mutation-restricted in gateway routes:
  - `use` MAY create comments when `comments:create` is present.
  - `use` MUST NOT create or edit posts.
  - `use` MUST NOT perform governance operations on console surfaces.
- Deny outcomes for permission or key-class mutation violations return canonical `403 forbidden` with stable detail-code mappings from `ERROR_CODE_CATALOG.md`.

## Delegation bound enforcement
- Delegation issuance rules are enforced through PDP delegation rule packs before issuance handlers execute.
- Requested child permissions MUST be strict subsets of issuer effective permissions.
- Requested child scope MUST be a subset of issuer effective scope envelope.
- Requested child depth MUST remain within canonical maximum depth `3`.
- Requested child expiry MUST be explicitly set and MUST NOT exceed the issuer expiry.
- Delegation-bound violations return deterministic deny outcomes:
  - Structural request defects return `422 validation_failed`.
  - Policy-bound violations return `403 forbidden`.


## Keychain membership invariant enforcement
- Keychain membership mutation routes are authorized through dedicated PDP keychain invariant rules before persistence handlers execute.
- Candidate membership is allowed only for active `primary_author`, `secondary_author`, and `use` key principals.
- Candidate membership MUST be denied for `master`, `keychain`, and owner principals.
- Nested keychain membership MUST be denied with canonical `403 forbidden` and detail code `keychain_nested_membership_forbidden`.
- Keychains with `50` existing members MUST reject additional member admission with canonical `403 forbidden` and detail code `keychain_membership_limit_exceeded`.
- Candidate keys in non-active lifecycle states MUST be denied with canonical `403 forbidden` and detail code `member_key_inactive`.
- Successful membership mutations MUST recompute effective keychain permission/scope snapshots atomically with membership writes.

## Master-key SYSADMIN boundary enforcement
- Master-key authorization is evaluated through dedicated PDP boundary rules for SYSADMIN-designated console governance operations.
- Master-key tokens MUST be denied for gateway route actions with canonical `403 forbidden` and detail code `master_key_gateway_forbidden`.
- Master-key issuance and lifecycle routes MUST deny non-owner actors with canonical `403 forbidden` and detail code `master_key_owner_required`.
- Master-key mint authority is restricted to owner principals and is never delegated to key principals or keychains.
- Master-key credential material MUST remain excluded from keychain membership resolution and effective-envelope computation.

## Device-binding deny semantics in PDP outcomes
- Device-binding requirements are expressed as mandatory PDP obligations for gateway route actions that require device-bound tokens.
- Missing `X-Device-Id` header on a device-bound route MUST deny with `422 validation_failed` and detail code `device_id_missing`.
- Malformed `X-Device-Id` header on a device-bound route MUST deny with `422 validation_failed` and detail code `device_id_invalid_format`.
- JWT/header `device_id` mismatch on a device-bound route MUST deny with `401 auth_invalid` and detail code `token_device_mismatch`.
- Missing JWT `device_id` claim on a route that requires device binding MUST deny with `401 auth_invalid` and detail code `token_device_claim_missing`.
- Device-binding deny mappings are canonical and are not overridden by route handlers.

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
