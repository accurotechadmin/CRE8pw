# Authorization Decision Tables (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Provide explicit policy truth tables for delegation, keychain resolution, and lifecycle authority so implementation and QA decisions are deterministic.

## Delegation issuance decision table

| Condition | Required outcome |
|---|---|
| Child permissions are strict subset of parent envelope | Allow if all other checks pass |
| Child permissions exceed parent | Deny (`403 forbidden`, detail `permission_denied`) |
| Child scope exceeds parent | Deny (`403 forbidden`) |
| Parent depth is 3 and child requested | Deny (`422 validation_failed` or `403` policy deny) |
| Child expiry missing | Deny (`422 validation_failed`) |
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

## Keychain membership admission table

| Candidate member class | Allowed? | Notes |
|---|---|---|
| `primary_author` | yes | must be active and not revoked/suspended/cancelled |
| `secondary_author` | yes | same activity constraints |
| `use` | yes | same activity constraints |
| `keychain` | no | nested keychains forbidden |
| owner principal | no | owner credentials are not keychain members |

## Keychain effective permission/scope resolution

| Rule family | Resolution rule |
|---|---|
| Permissions | Set-union across active members, then constrained by keychain envelope |
| Positive scope tokens | Union |
| Restrictive scope dimensions | Intersection |
| Inactive/revoked member contribution | Excluded entirely |
| Membership change | Recompute effective snapshot atomically with mutation |

## Lifecycle action authority table

| Actor | Action | Allowed? | Conditions |
|---|---|---|---|
| owner principal | suspend/cancel/revoke key | yes | lineage and governance policy checks |
| key principal | suspend/cancel/revoke ancestor | no | forbidden |
| key principal | manage descendants | conditional | only where delegated governance permits and never beyond envelope |
| admin (owner-delegated) | moderation actions | yes | scoped by owner delegation policy |
| admin | root governance policy changes | no | owner-only |

## Runtime decision order (authoritative)
1. Validate token type/audience/surface binding.
2. Validate lifecycle status (active vs suspended/cancelled/revoked).
3. Validate permission string allow-list.
4. Validate scope coverage.
5. Validate route-specific policy guards (device/CSRF/use-key constraints).
6. Execute operation and emit auditable policy decision event.

## Device-binding decision table

| Condition | Required outcome |
|---|---|
| Gateway route has JWT `device_id` claim matching `X-Device-Id` | Allow if all other checks pass |
| `X-Device-Id` missing | Deny (`422 validation_failed`, `device_id_missing`) |
| `X-Device-Id` malformed | Deny (`422 validation_failed`, `device_id_invalid_format`) |
| JWT `device_id` missing/mismatch relative to header | Deny (`401 auth_invalid`, `token_device_mismatch`) |

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
