# Usage Scenarios and Permission Stories

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Provide human-readable, contract-grounded stories that map real workflows to routes, policy decisions, and expected outcomes.

## Scenario 1: Invite-gated owner bootstrap (default)
1. Existing owner issues invite at `POST /console/api/invites`.
2. New owner registers at `POST /console/owners` using email/password/invite code.
3. New owner logs in at `POST /api/auth/login` and begins console governance.

Expected outcomes:
- Missing/invalid invite code is denied (`403/422` per policy/validation stage).
- Successful registration returns canonical success envelope.

## Scenario 2: Owner mints delegated author key
1. Owner issues key via `POST /console/api/keys` with bounded envelope.
2. Delegated actor uses `POST /api/auth/key-login`.
3. Actor creates/edits content on allowed routes.

Expected outcomes:
- Any child key request exceeding parent envelope is denied.
- Delegation depth and expiry constraints are always enforced.

## Scenario 3: Use key as consumer access credential
1. Use key logs in via key-login.
2. Reads feed (`GET /api/feed`) and comments only where `comments:create` is allowed.
3. Cannot mint descendants or perform owner-governed operations.

## Scenario 4: Keychain collaborative access
1. Owner creates keychain and adds member keys.
2. Keychain effective permissions/scope resolved via `/console/api/keychains/{keychainId}/resolve`.
3. Membership changes trigger recompute of effective snapshot.

Expected outcomes:
- Nested keychains are rejected.
- Inactive/revoked members contribute no effective authority.

## Related SSOT docs
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
- `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`
- `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
