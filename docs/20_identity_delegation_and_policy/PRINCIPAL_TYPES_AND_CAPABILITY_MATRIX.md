---
doc_id: CRE8-IDPOL-PRINCIPAL-CAPABILITY-MATRIX
version: 1.1.0
status: normative
owner: Identity & Policy WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-05-04
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
normative_dependencies:
  - docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md
---

# Principal Types And Capability Matrix

## Normative requirements
- **CRE8-IDPOL-REQ-0006**: Every principal type MUST have an explicit allow/deny determination for every canonical capability row in the matrix; empty cells are prohibited. Enforcement dependency: no direct runtime dependency applies; completeness is governance-verified.
- **CRE8-IDPOL-REQ-0007**: Every `ALLOW` matrix cell MUST bind to exactly one token from `PERMISSION_VOCABULARY.md`. Enforcement dependency: `phpunit/phpunit` authorization fixtures verify allow-token reachability.
- **CRE8-IDPOL-REQ-0008**: `UTILITY_AGENT` principals MUST NOT perform ID keypair issuance/rotation/revocation capabilities. Enforcement dependency: `slim/slim` authorization middleware and `phpunit/phpunit` deny fixtures.
- **CRE8-IDPOL-REQ-0009**: `DELEGATEE` principals MUST be evaluated with grant scope intersection and expiry checks before matrix allow can apply. Enforcement dependency: `symfony/cache`/`symfony/rate-limiter` for grant lookup throttling and `phpunit/phpunit` lifecycle tests.

## Principal capability matrix

| Capability | ROOT_ADMIN | TENANT_ADMIN | IDENTITY_OPERATOR | UTILITY_AGENT | DELEGATEE |
|---|---|---|---|---|---|
| Issue ID keypair | ALLOW (`principal.id_keypair.issue`) | ALLOW (`principal.id_keypair.issue`) | ALLOW (`principal.id_keypair.issue`) | DENY | DENY |
| Rotate ID keypair | ALLOW (`principal.id_keypair.rotate`) | ALLOW (`principal.id_keypair.rotate`) | ALLOW (`principal.id_keypair.rotate`) | DENY | CONDITIONAL (`principal.id_keypair.rotate`) |
| Revoke ID keypair | ALLOW (`principal.id_keypair.revoke`) | ALLOW (`principal.id_keypair.revoke`) | ALLOW (`principal.id_keypair.revoke`) | DENY | DENY |
| Issue utility keypair | ALLOW (`principal.utility_keypair.issue`) | ALLOW (`principal.utility_keypair.issue`) | ALLOW (`principal.utility_keypair.issue`) | ALLOW (`principal.utility_keypair.issue`) | DENY |
| Rotate utility keypair | ALLOW (`principal.utility_keypair.rotate`) | ALLOW (`principal.utility_keypair.rotate`) | ALLOW (`principal.utility_keypair.rotate`) | ALLOW (`principal.utility_keypair.rotate`) | CONDITIONAL (`principal.utility_keypair.rotate`) |
| Revoke utility keypair | ALLOW (`principal.utility_keypair.revoke`) | ALLOW (`principal.utility_keypair.revoke`) | ALLOW (`principal.utility_keypair.revoke`) | DENY | DENY |
| Create delegation grant | ALLOW (`delegation.grant.create`) | ALLOW (`delegation.grant.create`) | ALLOW (`delegation.grant.create`) | DENY | DENY |
| Revoke delegation grant | ALLOW (`delegation.grant.revoke`) | ALLOW (`delegation.grant.revoke`) | ALLOW (`delegation.grant.revoke`) | DENY | CONDITIONAL (`delegation.grant.revoke`) |
| Inspect delegation grants | ALLOW (`delegation.grant.inspect`) | ALLOW (`delegation.grant.inspect`) | ALLOW (`delegation.grant.inspect`) | DENY | CONDITIONAL (`delegation.grant.inspect`) |

`CONDITIONAL` means allow only when delegation scope and lifecycle state permit the action per `AUTHORIZATION_DECISION_TABLES.md`.

## Principal taxonomy alignment

Canonical principal taxonomy for delegation-policy evaluation is: `ROOT_ADMIN`, `TENANT_ADMIN`, `IDENTITY_OPERATOR`, `UTILITY_AGENT`, `DELEGATEE`. Human-readable role labels (`Owner`, `Primary Author`, `Secondary Author`, `Use`) MAY appear in explanatory prose, but normative decision tables, capability matrices, route authorization metadata, and contract fixtures MUST use canonical taxonomy tokens from this document.

Mapping guidance:
- `Owner` maps to either `ROOT_ADMIN` (platform scope) or `TENANT_ADMIN` (tenant scope) depending on bounded governance context.
- `Primary Author` maps to `IDENTITY_OPERATOR` when delegating or mutating descendant credentials.
- `Secondary Author` and `Use` operations map to `DELEGATEE` unless explicitly executed by a registered utility credential process (`UTILITY_AGENT`).


## Change history
- 2026-05-04 (v1.1.0): Added canonical role-label to principal-token mapping rules to close Phase 4 taxonomy alignment slice P4-S2.1.
- 2026-04-30 (v1.0.0): Initial normative publication for Phase 3 slice P3-S4.2. Change Impact Map: [`reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md`](../../reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md).
