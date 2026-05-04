---
doc_id: CRE8-IDPOL-PERMISSION-VOCAB
version: 1.0.0
status: normative
owner: Identity & Policy WG
reviewers:
  - Platform Architecture WG
  - API Contracts WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
normative_dependencies:
  - docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
---

# Permission Vocabulary

## Normative requirements
- **CRE8-IDPOL-REQ-0001**: Every permission token used by CRE8 policy evaluation MUST use `<domain>.<resource>.<action>` lower-case dot notation and MUST be registered in the canonical table in this document. Enforcement dependency: `respect/validation` for token-shape validation and `phpunit/phpunit` contract coverage.
- **CRE8-IDPOL-REQ-0002**: Authorization decision requests MUST reject unknown permission tokens with canonical deny reason `AUTH_DENY_PERMISSION_UNKNOWN` and MUST NOT evaluate fallback aliases. Enforcement dependency: `slim/slim` middleware error flow and `phpunit/phpunit` deny-reason mapping tests.
- **CRE8-IDPOL-REQ-0003**: Permission grants inherited through delegation MUST resolve only to tokens listed in this vocabulary; unresolved inherited tokens MUST be discarded as deny-evaluable gaps. Enforcement dependency: `php-di/php-di` policy service composition and `phpunit/phpunit` lifecycle fixtures.
- **CRE8-IDPOL-REQ-0004**: Runtime policy resolution SHOULD treat permission tokens as case-sensitive canonical strings to prevent privilege broadening by case normalization. Enforcement dependency: `respect/validation`; no additional Composer dependency applies.
- **CRE8-IDPOL-REQ-0005**: New route families or principal capabilities MUST add corresponding permission rows in this document in the same change set as route/OpenAPI updates. Enforcement dependency: no direct runtime dependency applies; governance enforcement is via SSOT automation/linting checks.

## Canonical permission registry

| Domain | Resource | Action | Token | Description |
|---|---|---|---|---|
| principal | id_keypair | issue | `principal.id_keypair.issue` | Create an ID keypair for a principal. |
| principal | id_keypair | rotate | `principal.id_keypair.rotate` | Rotate active ID key material. |
| principal | id_keypair | revoke | `principal.id_keypair.revoke` | Revoke an ID keypair. |
| principal | utility_keypair | issue | `principal.utility_keypair.issue` | Create a utility keypair. |
| principal | utility_keypair | rotate | `principal.utility_keypair.rotate` | Rotate active utility key material. |
| principal | utility_keypair | revoke | `principal.utility_keypair.revoke` | Revoke a utility keypair. |
| delegation | grant | create | `delegation.grant.create` | Create a scoped delegation grant. |
| delegation | grant | revoke | `delegation.grant.revoke` | Revoke an active delegation grant. |
| delegation | grant | inspect | `delegation.grant.inspect` | Read delegation chain and status. |
| content | post | create | `content.post.create` | Create a content post. |
| content | post | update | `content.post.update` | Update owned content. |
| content | post | delete | `content.post.delete` | Delete or tombstone content. |
| content | comment | create | `content.comment.create` | Create a comment. |
| content | comment | moderate | `content.comment.moderate` | Moderate comments within policy scope. |
| audience | group | manage | `audience.group.manage` | Create/update audience groups. |
| audience | group | view | `audience.group.view` | View audience group membership metadata. |
| feed | stream | view | `feed.stream.view` | Access feed timeline entries. |
| feed | stream | curate | `feed.stream.curate` | Apply curation controls to feed rankings. |
| audit | event | read | `audit.event.read` | Query audit event history. |
| system | health | read | `system.health.read` | Query system liveness/readiness endpoints. |

## Deprecated and prohibited aliases
- `post.create` is prohibited; use `content.post.create`.
- `key.rotate` is prohibited; use one of `principal.id_keypair.rotate` or `principal.utility_keypair.rotate`.
- `authz.grant` is prohibited; use `delegation.grant.create`.

## Change history
- 2026-04-30 (v1.0.0): Initial normative publication for Phase 3 slice P3-S4.1. Change Impact Map: [[`reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md`](reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md)](../../reports/change_impact_maps/20260430-0700-P3-S4.1-P3-S4.2-P3-S4.3.md).
