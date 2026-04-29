---
doc_id: CRE8-TRACE-SEED-PROMOTION-TRACKER
version: 1.4.0
status: provisional-normative
owner: Program Traceability WG
reviewers:
  - Docs Governance WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-13
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
- **CRE8-TRACE-REQ-0076**: A row marked `promoted` **MUST** include a non-`TBD` `target_requirement_id` and **MUST** use a verification hook that exists in the authoritative hook registry within `TRACEABILITY_MATRIX.md`.

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
| tracker_ref | seed_requirement_ref | target_doc_id | target_requirement_id | promotion_status | verification_hook_id | decision_ref | notes |
|---|---|---|---|---|---|---|---|
| SPR-001 | seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md#id-keypair-first-principal-model | CRE8-ARCH-IDENTITY-FOUNDATIONS | CRE8-ARCH-REQ-0001 | promoted | HOOK-IDENTITY-ID-FIRST-ISSUANCE |  | Promoted into ID-keypair-first issuance requirement in identity foundations spec. |
| SPR-002 | seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md#utility-key-context-compartmentalization | CRE8-ARCH-IDENTITY-FOUNDATIONS | CRE8-ARCH-REQ-0002 | promoted | HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION |  | Promoted into utility-key context compartmentalization requirement set. |
| SPR-003 | seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md#permission-evaluation-order | CRE8-AUTH-DECISION-TABLES | CRE8-AUTH-REQ-0010 | promoted | HOOK-CONTRACT-POLICY-ORDER |  | Promoted into deterministic authorization gate ordering requirements. |
| SPR-004 | seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md#deterministic-deny-reasoning | CRE8-AUTH-DECISION-TABLES | CRE8-AUTH-REQ-0015 | promoted | HOOK-AUTH-DECISION-REASON-MAPPING |  | Promoted into reason-to-error-code mapping requirements. |
| SPR-005 | seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md#revoke-rotate-propagation | CRE8-SEC-KEY-LIFECYCLE | CRE8-SEC-REQ-0006 | promoted | HOOK-SEC-LIFECYCLE-PROPAGATION |  | Promoted into immediate revoke/rotate propagation requirements with explicit hook coverage. |
| SPR-006 | seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md#cross-surface-parity | CRE8-CONTRACTS-SURFACE-PARITY | CRE8-CONTRACT-REQ-0030 | promoted | HOOK-CONTRACT-SURFACE-PARITY |  | Promoted into Owner Console/API supported-capability parity requirements. |
| SPR-007 | seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md#authorized-feed-ordering | CRE8-FEED-AUDIENCE-CONTRACT | CRE8-FEED-REQ-0002 | promoted | HOOK-FEED-AUTH-ORDER |  | Promoted into deterministic authorized feed ordering rules. |
| SPR-008 | seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md#error-envelope-determinism | CRE8-CONTRACTS-ERROR-CATALOG | CRE8-CONTRACT-REQ-0001 | promoted | HOOK-CONTRACT-ERROR-DETERMINISM |  | Promoted into deterministic error envelope and stable error code requirements. |
| SPR-009 | seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md#contract-machine-parity | CRE8-CONTRACTS-API-GUIDE | CRE8-CONTRACT-REQ-0010 | promoted | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY |  | Promoted into route inventory and machine contract parity requirements. |
| SPR-010 | seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md#compatibility-and-migration-disclosure | CRE8-CONTRACTS-API-GUIDE | CRE8-CONTRACT-REQ-0014 | promoted | HOOK-CONTRACT-COMPAT-DECLARATION |  | Promoted into mandatory compatibility declaration obligations. |
| SPR-011 | seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md#route-inventory-determinism | CRE8-CONTRACTS-ROUTE-INVENTORY | CRE8-CONTRACT-REQ-0020 | promoted | HOOK-CONTRACT-ROUTE-UNIQUENESS |  | Promoted into unique route_id and method/path constraints. |
| SPR-012 | seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md#route-deprecation-fields | CRE8-CONTRACTS-ROUTE-INVENTORY | CRE8-CONTRACT-REQ-0023 | promoted | HOOK-CONTRACT-DEPRECATION-SCHEMA |  | Promoted into deprecation schema completeness requirements. |
| SPR-013 | seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md#module-seam-compatibility | CRE8-EXT-MODULE-SEAMS | CRE8-EXT-REQ-0002 | promoted | HOOK-EXT-SEAM-COMPATIBILITY |  | Promoted into module seam compatibility and PDP-preservation requirements. |
| SPR-014 | seed/CRE8_SEED_PRESERVATION_MATRIX.md#preservation-obligations | CRE8-TRACE-SEED-PROMOTION-TRACKER | CRE8-TRACE-REQ-0070 | promoted | HOOK-SSOT-SYNC-PROMOTED-TRACE |  | Seed preservation obligation promoted into mandatory seed row mapping contract. |
| SPR-015 | seed/CRE8_SEED_PRESERVATION_MATRIX.md#unresolved-gap-accountability | CRE8-TRACE-SEED-GAP-REGISTER | CRE8-TRACE-REQ-0080 | promoted | HOOK-SSOT-SYNC-PROMOTED-TRACE |  | Seed gap accountability obligations promoted into canonical unresolved-gap register requirements. |

## Verification hooks
- **HOOK-SEED-PROMOTION-SCHEMA**: Validate required columns and promotion status enums.
- **HOOK-SEED-PROMOTION-TRACE-LINK**: Validate `promoted` rows have matching traceability matrix row.
- **HOOK-SEED-PROMOTION-DECISION-REF**: Validate deferred/retired rows include decision references.
- **HOOK-SSOT-SYNC-PROMOTED-TARGET**: Validate every `promoted` tracker row has non-`TBD` target requirement and doc presence.

## See also
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Roadmap and Milestones](./ROADMAP_AND_MILESTONES.md)
- [Unresolved Seed Gap Register](./UNRESOLVED_SEED_GAP_REGISTER.md)
- [Seed Canon Index](../../seed/CRE8_SEED_CANON_INDEX.md)
