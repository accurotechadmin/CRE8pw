---
doc_id: CRE8-IDPOL-KEYCHAIN-RESOLUTION
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
  - docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md
---

# Keychain Composition And Resolution Spec

## Normative requirements
- **CRE8-IDPOL-REQ-0010**: Effective permission scope MUST be the intersection of (a) principal intrinsic matrix permissions, (b) active delegation grants, and (c) request context constraints (tenant, audience, lifecycle state). Enforcement dependency: `php-di/php-di` policy engine composition and `phpunit/phpunit` contract fixtures.
- **CRE8-IDPOL-REQ-0011**: Keychain resolution MUST process grants in deterministic order: newest active grant first, then descending by `issued_at`, with stable tie-breaker on `grant_id`. Enforcement dependency: `ext-pdo` deterministic query ordering and `phpunit/phpunit` lifecycle tests.
- **CRE8-IDPOL-REQ-0012**: Expired, revoked, or suspended grants MUST be excluded from effective scope before permission matching. Enforcement dependency: `ext-pdo` persistence filters and `phpunit/phpunit` lifecycle propagation fixtures.
- **CRE8-IDPOL-REQ-0013**: Resolution MUST return both `effective_permissions` and `decision_path` (principal type, grant ids, deny reason if any) for auditability. Enforcement dependency: `monolog/monolog` structured logging and `phpunit/phpunit` auth-reason tests.
- **CRE8-IDPOL-REQ-0014**: Where no eligible grants remain after filtering, the decision MUST be deny with reason `AUTH_DENY_DELEGATION_SCOPE`. Enforcement dependency: `slim/slim` middleware decision mapping and `phpunit/phpunit` auth-reasons contract tests.

- **CRE8-IDPOL-REQ-0026**: Keychain terminology **MUST** use `id_keypair` and `utility_keypair` labels exactly as defined in [`PERMISSION_VOCABULARY.md`](PERMISSION_VOCABULARY.md), and alias labels (`id_key`, `use_key`, `utility_key`) **MUST NOT** appear in normative decision outputs (`slim/slim`, `phpunit/phpunit`).
- **CRE8-IDPOL-REQ-0027**: Keypair lifecycle terms consumed by resolution **MUST** align to canonical state names from [`KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md`](KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md) and [`DATA_MODEL_REFERENCE.md`](DATA_MODEL_REFERENCE.md); non-canonical states **MUST** be treated as deterministic deny inputs. Enforcement dependency: `ext-pdo` query filters and `phpunit/phpunit` deny-path fixtures.

## Resolution algorithm
1. Load principal type and base capabilities from [`PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md).
2. Load candidate grants for request principal/context from persistence.
3. Filter grants to `active` lifecycle state and unexpired window.
4. Sort grants deterministically (`created_at DESC`, then `grant_id ASC`).
5. Intersect grant tokens with base capabilities and request-context predicates.
6. Return allow with `effective_permissions` if the requested token is present; otherwise deny with canonical reason.

## Deterministic walkthrough (multi-grant)
- Principal: `DELEGATEE`
- Requested token: `principal.utility_keypair.rotate`
- Grants (same subject):
  - `G-102` active, unexpired, includes `principal.utility_keypair.rotate`
  - `G-091` active, unexpired, includes `principal.utility_keypair.issue`
  - `G-055` revoked, includes `principal.utility_keypair.rotate`
- Resolution result:
  - `G-055` excluded by lifecycle filter.
  - Sorted active grants: `G-102`, `G-091`.
  - Matrix row for `DELEGATEE` is `CONDITIONAL` for rotate; intersection with `G-102` yields token present.
  - Decision: `ALLOW`, `effective_permissions=[principal.utility_keypair.rotate]`, `decision_path=[DELEGATEE,G-102]`.

## Change history
- 2026-05-04 (v1.1.0): Completed Phase 4 slice P4-S2.4 by aligning keychain and keypair lifecycle terminology with canonical crypto/data-state vocabulary.
- 2026-04-30 (v1.0.0): Initial normative publication for Phase 3 slice P3-S4.3. Change Impact Map: [[`reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md`](reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md)](../../reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md).
