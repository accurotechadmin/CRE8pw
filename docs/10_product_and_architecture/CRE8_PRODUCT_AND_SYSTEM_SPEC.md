---
doc_id: CRE8-ARCH-PRODUCT-SYSTEM
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - Product Policy WG
  - API Contracts WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-30
source_seed_refs:
  - README.md
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
  - seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md
normative_dependencies:
  - docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md
  - docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md
---

# CRE8 Product And System Spec

## Normative requirements
- **CRE8-ARCH-REQ-0038**: CRE8 **MUST** remain a Credential Registry Engine where principal issuance, delegation, and use are governed by deterministic policy outcomes. Runtime enforcement is bound to `slim/slim` (route/middleware execution) and `phpunit/phpunit` contract verification.
- **CRE8-ARCH-REQ-0039**: Principal mint operations for Primary Author, Secondary Author, and Use principals **MUST** issue an ID keypair atomically with principal creation. Enforcement is bound to `ext-sodium` key generation and `ext-pdo` transactional persistence.
- **CRE8-ARCH-REQ-0040**: Utility keypairs **MUST** be context-scoped and **MUST NOT** be widened in place; new contexts require newly issued utility credentials. Enforcement is bound to `ext-pdo` persistence controls and validated by `phpunit/phpunit` lifecycle tests.
- **CRE8-ARCH-REQ-0041**: All protected capabilities across Owner Console and API/Gateway surfaces **MUST** align with a shared capability model unless route inventory marks a reviewed exception. Enforcement is bound to `slim/slim` route parity checks and automated by existing route-parity hooks.
- **CRE8-ARCH-REQ-0042**: The system **MUST** provide deterministic content visibility and feed inclusion based on authorization outcome, lifecycle state, and audience targeting constraints. Enforcement is bound to policy middleware (`slim/slim`), persistence (`ext-pdo`), and tested via `phpunit/phpunit` feed contracts.
- **CRE8-ARCH-REQ-0043**: Security-significant state changes (issuance, delegation mutation, lifecycle mutation, moderation-impacting actions) **MUST** emit immutable provenance events with correlation IDs. Enforcement is bound to `monolog/monolog` logging and `ext-pdo` append-only event persistence.

## System capability pillars
1. Identity and key lifecycle governance.
2. Hierarchical, bounded delegation and policy evaluation.
3. Deterministic interface contracts and deny mapping.
4. Audience-scoped content visibility and deterministic feed ordering.
5. Immutable provenance and verification-ready evidence production.

## See also
- `docs/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- `docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`

## Change history
- 2026-04-30 (v1.0.0): Initial normative publication for Phase 3 slices P3-S3.3/P3-S3.5/P3-S3.6. Change Impact Map: [`reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md`](../../reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md).
