---
doc_id: CRE8-IDPOL-DELEGATION-STATE-MACHINE
version: 1.0.0
status: normative
owner: Identity & Policy WG
reviewers:
  - Security WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
normative_dependencies:
  - ext-pdo
  - phpunit/phpunit
  - slim/slim
---

# Delegation State Machine

## States and events

States: `proposed, granted, active, suspended, revoked, rotated, expired, retired`.
Events: `grant, accept, suspend, resume, revoke, rotate, expire, retire`.

## Transition table

| From | Event | To | Guard | Illegal transition deny code |
|---|---|---|---|---|
| proposed | grant | granted | ancestor active, envelope valid | AUTH_LIFECYCLE_BLOCKED |
| granted | accept | active | principal proof valid | AUTH_CREDENTIAL_INVALID |
| active | suspend | suspended | actor has lifecycle authority | AUTH_PERMISSION_DENIED |
| suspended | resume | active | ancestor not revoked/expired | AUTH_LIFECYCLE_BLOCKED |
| active/suspended | revoke | revoked | actor has revoke authority | AUTH_PERMISSION_DENIED |
| active/suspended | rotate | rotated | rotation policy satisfied | AUTH_LIFECYCLE_BLOCKED |
| active/suspended/rotated | expire | expired | clock >= grant_expiry_utc | AUTH_GRANT_EXPIRED |
| revoked/expired | retire | retired | retention obligations complete | AUTH_LIFECYCLE_BLOCKED |

## Cascade semantics

- **CRE8-IDPOL-REQ-0019**: Entering `suspended` or `revoked` at any ancestor MUST propagate deny-effective state to descendants within the same lineage (`ext-pdo`).
- **CRE8-IDPOL-REQ-0020**: Descendant propagation MUST be externally observable via deterministic deny responses using `AUTH_LIFECYCLE_BLOCKED` (`slim/slim`).
- **CRE8-IDPOL-REQ-0021**: Lifecycle chronology used for propagation verification MUST preserve contiguous descendant request-id fixture sequence `req-desc-life-001..003` (`phpunit/phpunit`).
- **CRE8-IDPOL-REQ-0022**: Illegal transitions MUST fail closed and map to the deny code declared in the transition table; handlers MUST NOT rewrite lifecycle deny codes (`slim/slim`).

## Verification hook alignment

This state machine is verified by `HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY` and `HOOK-AUTH-LIFECYCLE-ENFORCEMENT` through lifecycle/auth contract suites.

## Change history

- 2026-04-30 (v1.0.0): Authored normative scenario corpus/state machine for P3-S4.4/P3-S4.5. Change Impact Map: [`reports/change_impact_maps/20260430-1030-P3-S4.4-P3-S4.5.md`](../../reports/change_impact_maps/20260430-1030-P3-S4.4-P3-S4.5.md).
