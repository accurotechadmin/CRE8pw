# Test Data and Fixture Strategy

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Fixture principles
- Deterministic, minimal, and role-complete (owner + key classes + keychain members).
- Include lifecycle variants: active/suspended/cancelled/revoked.
- Include envelope edge cases and negative auth/validation inputs.

## Required fixture packs
1. Auth and refresh family replay pack.
2. Delegation and keychain invariant pack.
3. Content visibility and moderation transitions pack.
4. Operational failure simulation pack for health/smoke.

## Maintenance policy
- Fixture schema must evolve in lockstep with data model changes.
- Every bug fix adding behavior should add/adjust a fixture scenario.
