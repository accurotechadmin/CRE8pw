---
doc_id: CRE8-EXT-POST-TYPE-SPEC
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - Product Policy WG
  - API Contracts WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-21
source_seed_refs:
  - seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md
  - seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md
normative_dependencies:
  - docs/70_extensibility_and_module_patterns/EXTENSIBILITY_PLAYBOOK.md
  - docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md
  - docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md
---

# Post Type Extension Spec

## Purpose
Define mandatory obligations for adding a new CRE8 post family while preserving lifecycle, audience, feed ordering, moderation, policy, and contract parity invariants.

## Normative requirements
- **CRE8-EXT-REQ-0017**: A new post family **MUST** declare a unique `post_type` token and **MUST NOT** reuse or alias existing canonical tokens.
- **CRE8-EXT-REQ-0018**: Every new post family **MUST** inherit lifecycle obligations (draft/published/archived/deleted + moderation transitions) and **MUST** specify any additional states as additive-only with backward-compatible handlers.
- **CRE8-EXT-REQ-0019**: Audience-targeting semantics **MUST** map to canonical audience-group rules and **MUST NOT** bypass deny semantics for membership, suspension, or tenant isolation.
- **CRE8-EXT-REQ-0020**: Feed visibility/ranking behavior **MUST** declare deterministic ordering fields and tie-breakers and **MUST** preserve tenant-isolated cursor determinism.
- **CRE8-EXT-REQ-0021**: A post-family extension patch **MUST** update route inventory, OpenAPI/parity rows, and deny/error examples for all added or modified routes in the same change set.
- **CRE8-EXT-REQ-0028**: Post-family extension manifests **MUST** declare validator coverage for payload schema, lifecycle transition guards, audience eligibility, and policy-token resolution; release approval **MUST** fail closed when any validator result is missing or non-passing.
- **CRE8-EXT-REQ-0029**: Post-family extension patches **MUST** include a rollback plan with trigger thresholds, reversible migration scope, and required evidence artifacts; rollback execution **MUST** preserve canonical lifecycle and audience deny semantics.

## Required post-family manifest
| Field | Requirement |
|---|---|
| `post_type` | Unique canonical token. |
| `lifecycle_states` | Inherited canonical states plus additive extensions (if any). |
| `audience_constraints` | Allowed audience classes and mandatory deny mapping. |
| `ranking_fields` | Primary ordering fields and deterministic tie-breakers. |
| `policy_bindings` | Required PDP permissions and deny codes. |
| `contract_refs` | Route inventory rows + OpenAPI ops + parity rows + example fixtures. |
| `validator_coverage` | Required validator commands/results for schema, lifecycle, audience, and policy-token resolution checks. |
| `rollback_plan` | Trigger thresholds, reversible steps, and evidence artifacts for rollback execution. |

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-EXT-SEAM-COMPATIBILITY` | Verifies post-family extension manifest completeness and inherited invariant coverage. |
| `HOOK-CONTRACT-ROUTE-INVENTORY-PARITY` | Verifies route inventory and prose/machine parity updates for extension routes. |
| `HOOK-CONTRACT-EXAMPLE-COVERAGE` | Verifies allow/deny examples are present for new post-type routes. |

## Non-overridable core controls
- Post-family extensions **MUST** preserve all controls declared by `CRE8-EXT-REQ-0027`, including identity/delegation gate ordering, lifecycle deny semantics, data-classification boundaries, and cryptographic verification profiles.
- Any post-family behavior that conflicts with these controls **MUST** be rejected unless an ADR-approved bounded exception includes explicit expiry and rollback conditions.

## See also
- [Extensibility Playbook](./EXTENSIBILITY_PLAYBOOK.md)
- [Content Model and Targeting Spec](../50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md)
- [Feed Ranking and Ordering Rules](../50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md)
- [Route Inventory Reference](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [Webhook and Integration Contract](../30_contracts_and_interfaces/WEBHOOK_AND_INTEGRATION_CONTRACT.md)
- [Permission Vocabulary](../20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md)


Change Impact Map: [`reports/change_impact_maps/20260430-1317-P3-S10.2-P3-S10.3-P3-S10.4.md`](reports/change_impact_maps/20260430-1317-P3-S10.2-P3-S10.3-P3-S10.4.md).
