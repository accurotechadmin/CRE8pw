---
doc_id: CRE8-TRACE-SEED-PROMOTION-TRACKER
version: 1.0.0
status: provisional-normative
owner: Program Traceability WG
reviewers:
  - Docs Governance WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-06
source_seed_refs:
  - seed/CRE8_SEED_CANON_INDEX.md
  - seed/CRE8_SEED_PRESERVATION_MATRIX.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md
---

# Seed Promotion Tracker

## Purpose
Define the mandatory mapping contract from seed requirements to promoted canonical requirements in `docs/`.

## Normative requirements
- **CRE8-TRACE-REQ-0070**: Every seed requirement selected for Phase 1 promotion **MUST** have one tracker row keyed by a unique `seed_requirement_ref`.
- **CRE8-TRACE-REQ-0071**: Each row **MUST** include: `seed_requirement_ref`, `target_doc_id`, `target_requirement_id`, `promotion_status`, and `verification_hook_id`.
- **CRE8-TRACE-REQ-0072**: `promotion_status` **MUST** be one of: `candidate`, `drafted`, `reviewed`, `promoted`, `deferred`, `retired`.
- **CRE8-TRACE-REQ-0073**: A row **MUST NOT** transition to `promoted` unless `target_requirement_id` exists in the target doc and is represented in `TRACEABILITY_MATRIX.md`.
- **CRE8-TRACE-REQ-0074**: Rows marked `deferred` or `retired` **MUST** include `decision_ref` to either ADR ID or decision event ID.
- **CRE8-TRACE-REQ-0075**: Multiple seed refs **MAY** map to one target requirement only when semantic consolidation is explicitly documented in `notes`.

## Tracker schema
| Field | Required | Description |
|---|---|---|
| seed_requirement_ref | yes | Seed document path + anchor/identifier. |
| target_doc_id | yes | Target normative doc `doc_id`. |
| target_requirement_id | yes | Promoted requirement ID (`CRE8-*-REQ-####`) or `TBD` while drafting. |
| promotion_status | yes | `candidate`, `drafted`, `reviewed`, `promoted`, `deferred`, `retired`. |
| verification_hook_id | yes | Hook ID for acceptance verification. |
| decision_ref | no | ADR ID or decision event ID for deferred/retired/consolidated mappings. |
| notes | no | Rationale and consolidation details. |

## Initial promotion tracker (Phase 1 baseline)
| seed_requirement_ref | target_doc_id | target_requirement_id | promotion_status | verification_hook_id | decision_ref | notes |
|---|---|---|---|---|---|---|
| seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md#id-keypair-first-principal-model | CRE8-ARCH-IDENTITY-FOUNDATIONS | TBD | candidate | HOOK-SEED-PROMOTION-SCHEMA |  | Foundational identity model seed; queued for Slice 6 contract hardening. |
| seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md#permission-evaluation-order | CRE8-CONTRACTS-ACCESS-POLICY | TBD | candidate | HOOK-CONTRACT-POLICY-ORDER |  | Candidate for deterministic policy evaluation contract. |
| seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md#revoke-rotate-propagation | CRE8-SEC-KEY-LIFECYCLE | TBD | candidate | HOOK-SEC-LIFECYCLE-PROPAGATION |  | Candidate for lifecycle enforcement hardening. |
| seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md#cross-surface-parity | CRE8-CONTRACTS-SURFACE-PARITY | TBD | candidate | HOOK-CONTRACT-SURFACE-PARITY |  | Candidate for Owner Console/API parity obligations. |
| seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md#authorized-feed-ordering | CRE8-FEED-AUDIENCE-CONTRACT | TBD | candidate | HOOK-FEED-AUTH-ORDER |  | Candidate for deterministic audience/feed ordering controls. |
| seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md#error-envelope-determinism | CRE8-CONTRACTS-ERROR-CATALOG | TBD | candidate | HOOK-CONTRACT-ERROR-DETERMINISM |  | Candidate for error envelope stabilization and deny semantics. |
| seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md#module-seam-compatibility | CRE8-EXT-MODULE-SEAMS | TBD | candidate | HOOK-EXT-SEAM-COMPATIBILITY |  | Candidate for extension invariants and compatibility gates. |
| seed/CRE8_SEED_PRESERVATION_MATRIX.md#preservation-obligations | CRE8-TRACE-SEED-PRESERVATION | TBD | candidate | HOOK-SEED-PRESERVATION-COVERAGE |  | Candidate for preservation accountability and redesign traceability. |

## Verification hooks
- **HOOK-SEED-PROMOTION-SCHEMA**: Validate required columns and promotion status enums.
- **HOOK-SEED-PROMOTION-TRACE-LINK**: Validate `promoted` rows have matching traceability matrix row.
- **HOOK-SEED-PROMOTION-DECISION-REF**: Validate deferred/retired rows include decision references.

## See also
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Roadmap and Milestones](./ROADMAP_AND_MILESTONES.md)
- [Unresolved Seed Gap Register](./UNRESOLVED_SEED_GAP_REGISTER.md)
- [Seed Canon Index](../../seed/CRE8_SEED_CANON_INDEX.md)
