# Authorization Decision Tables (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Provide explicit policy truth tables for delegation, keychain resolution, and lifecycle authority so implementation and QA decisions are deterministic.

## Canonical PDP input/output primitives

| Primitive | Required fields | Enforcement rule |
|---|---|---|
| `DecisionContext` | `request_id`, `surface`, `route_action`, normalized actor claims, resolved principal state, delegation envelope inputs | Policy evaluation executes only against normalized context from route-action resolver and context builders |
| `Decision` | `effect`, `http_status`, `error_code`, `detail_code`, `obligations` | Deny outcomes are canonical and map directly to envelope/error contracts |
| `Obligation` | stable obligation key + value payload | Obligations are mandatory; missing obligation enforcement is a release-blocking defect |
| `PolicyRule` | stable rule id + deterministic predicate/evaluator | Rule execution order and precedence remain deterministic and testable |

## Delegation issuance decision table

| Condition | Required outcome |
|---|---|
| Child permissions are strict subset of parent envelope | Allow if all other checks pass |
| Child permissions exceed parent | Deny (`403 forbidden`, detail `permission_denied`) |
| Child scope exceeds parent | Deny (`403 forbidden`) |
| Parent depth is 3 and child requested | Deny (`403 forbidden`, detail `delegation_depth_exceeded`) |
| Child expiry missing | Deny (`422 validation_failed`, detail `expiry_required`) |
| Child expiry exceeds issuer expiry | Deny (`403 forbidden`, detail `delegation_expiry_exceeds_parent`) |
| Parent lacks `keys:issue` | Deny (`403 forbidden`) |
| Issuer is keychain principal | Deny (keychains cannot mint credentials) |
| Issuer is owner principal via console issue route | Allow subject to governance policy |

## Key class mint authority table (v1)

| Issuer class | Can mint primary_author | Can mint secondary_author | Can mint use | Can mint keychain |
|---|---:|---:|---:|---:|
| owner principal | yes | yes | yes | yes (console-governed) |
| primary_author key | yes (subset + depth + expiry) | yes (subset + depth + expiry) | yes (subset + depth + expiry) | no |
| secondary_author key | no | yes (subset + depth + expiry + `keys:issue`) | yes (subset + depth + expiry + `keys:issue`) | no |
| use key | no | no | no | no |
| keychain key | no | no | no | no |

## Keychain membership invariant decision table

| Condition | Required outcome |
|---|---|
| Candidate class is `primary_author`, `secondary_author`, or `use` and candidate lifecycle is active | Allow if all other checks pass |
| Candidate class is `keychain` | Deny (`403 forbidden`, detail `keychain_nested_membership_forbidden`) |
| Candidate class is `master` | Deny (`403 forbidden`, detail `keychain_member_class_forbidden`) |
| Candidate actor is owner principal credential | Deny (`403 forbidden`, detail `keychain_member_class_forbidden`) |
| Keychain membership count is already `50` before add | Deny (`403 forbidden`, detail `keychain_membership_limit_exceeded`) |
| Candidate lifecycle is suspended/cancelled/revoked | Deny (`403 forbidden`, detail `member_key_inactive`) |
| Membership mutation succeeds | Recompute effective snapshot atomically and emit audit event bound to `request_id` |

## Keychain effective permission/scope resolution

| Rule family | Resolution rule |
|---|---|
| Permissions | Set-union across active members, then constrained by keychain envelope |
| Positive scope tokens | Union |
| Restrictive scope dimensions | Intersection |
| Inactive/revoked member contribution | Excluded entirely |
| Membership change | Recompute effective snapshot atomically with mutation |

## Owner-only console operation table

| Condition | Required outcome |
|---|---|
| Console route is governance-scoped and actor is owner principal with valid owner token | Allow subject to route-specific permissions and obligations |
| Console route is governance-scoped and actor is key principal token | Deny (`403 forbidden`, detail `owner_context_required`) |
| Console route is governance-scoped and owner token has wrong audience/type | Deny (`401 auth_invalid`, detail `token_type_or_audience_invalid`) |
| Console write route requires CSRF obligation and obligation is unsatisfied | Deny (`403 forbidden`, detail `csrf_required`) |


## Master-key SYSADMIN boundary decision table

| Condition | Required outcome |
|---|---|
| Actor is owner principal, route is SYSADMIN-designated console governance operation, and master-key policy checks pass | Allow subject to route-specific obligations |
| Actor is key principal or keychain principal for master-key governance route | Deny (`403 forbidden`, detail `master_key_owner_required`) |
| Route action is gateway and token class is `master` | Deny (`403 forbidden`, detail `master_key_gateway_forbidden`) |
| Mint request targets `master` class and issuer is non-owner actor | Deny (`403 forbidden`, detail `master_key_owner_required`) |
| Membership request targets adding `master` key to keychain | Deny (`403 forbidden`, detail `keychain_member_class_forbidden`) |

## Lifecycle action authority table

| Actor | Action | Allowed? | Conditions |
|---|---|---|---|
| owner principal | suspend/cancel/revoke key | yes | lineage and governance policy checks |
| key principal | suspend/cancel/revoke ancestor | no | forbidden |
| key principal | manage descendants | conditional | only where delegated governance permits and never beyond envelope |
| admin (owner-delegated) | moderation actions | yes | scoped by owner delegation policy |
| admin | root governance policy changes | no | owner-only |

## Key-context normalization table (gateway)

| Condition | Required outcome |
|---|---|
| Key JWT has valid `typ=key`, gateway audience, and active lineage | Gateway `DecisionContext` includes normalized key claims and lineage inputs |
| Effective delegation envelope resolves for key principal | `DecisionContext` includes canonical permission/scope envelope inputs for PDP evaluation |
| Keychain actor resolves active membership snapshot | `DecisionContext` includes keychain effective permission/scope snapshot and source lineage references |
| Gateway route requires device binding and `device_id` claim/header are both present | `DecisionContext` includes normalized device binding claims for downstream obligation evaluation |
| Key claims cannot be normalized (missing lineage, invalid envelope inputs, malformed identifiers) | Deny (`401 auth_invalid` or `422 validation_failed`) before rule-family execution |

## Gateway permission table (route-action canonical)

| Route action | Required permission(s) | Additional rule |
|---|---|---|
| `gateway.feed.read` | `posts:read` | device-binding obligation where route requires it |
| `gateway.posts.create` | `posts:create` | key class `use` denied |
| `gateway.posts.edit` | `posts:edit` | key class `use` denied |
| `gateway.posts.flags.create` | `posts:read` | content lifecycle guard remains enforced |
| `gateway.comments.list` | `posts:read` | target post must be visible to actor scope |
| `gateway.comments.create` | `comments:create` | `use` allowed when permission present |

## Use-key mutation restriction table

| Condition | Required outcome |
|---|---|
| Actor key class is `use` and route action is `gateway.posts.create` | Deny (`403 forbidden`, detail `use_key_mutation_forbidden`) |
| Actor key class is `use` and route action is `gateway.posts.edit` | Deny (`403 forbidden`, detail `use_key_mutation_forbidden`) |
| Actor key class is `use` and route action is console governance operation | Deny (`403 forbidden`, detail `owner_context_required`) |
| Actor key class is `use` and route action is `gateway.comments.create` with `comments:create` permission | Allow if all other checks pass |

## Runtime decision order (authoritative)
1. Validate token type/audience/surface binding.
2. Validate lifecycle status (active vs suspended/cancelled/revoked).
3. Resolve canonical `route_action` from route metadata.
4. Build normalized `DecisionContext` for the active surface.
5. Validate permission string allow-list.
6. Validate scope coverage.
7. Validate route-specific policy guards (device/CSRF/use-key constraints) and emit obligations.
8. Evaluate `PdpService` using deterministic `RuleRegistry` ordering and collect mandatory obligations.
9. Execute operation and emit auditable policy decision event linked by `request_id` and `route_action`.

## Device-binding decision table

| Condition | Required outcome |
|---|---|
| Gateway route has JWT `device_id` claim matching `X-Device-Id` | Allow if all other checks pass |
| `X-Device-Id` missing | Deny (`422 validation_failed`, `device_id_missing`) |
| `X-Device-Id` malformed | Deny (`422 validation_failed`, `device_id_invalid_format`) |
| JWT `device_id` missing relative to route that requires device binding | Deny (`401 auth_invalid`, `token_device_claim_missing`) |
| JWT/header `device_id` mismatch | Deny (`401 auth_invalid`, `token_device_mismatch`) |

## Human interpretation notes (non-normative)
- Delegation flexibility exists, but only within strict parent bounds (subset/depth/expiry).
- Primary/secondary keys can be specialized so one actor may mint descendants while another can only post/comment.
- Use keys are intentionally non-minting and are safest for consumer-facing participation.

## Error mapping expectations
- Policy denials map to `403 forbidden` with stable detail codes.
- Structural request violations map to `422 validation_failed`.
- Missing/invalid auth maps to `401 auth_required|auth_invalid`.

## Related SSOT docs
- `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`
- `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`
