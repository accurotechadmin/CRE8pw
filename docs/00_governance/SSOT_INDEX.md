---
doc_id: CRE8-GOV-SSOT-INDEX
version: 1.0.7
status: normative
owner: Docs Governance WG
reviewers:
  - Security WG
  - Platform Architecture WG
last_reviewed_utc: 2026-05-05
next_review_due_utc: 2026-05-30
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md
  - docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md
  - docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/00_governance/DEFINITION_OF_DONE.md
  - docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md
---

# SSOT Index

## Purpose
This document defines the authoritative SSOT topology, precedence model, and minimum governance linkage rules for the CRE8 repository.

## Normative requirements
- **CRE8-GOV-REQ-0001**: The repository **MUST** treat [`README.md`](../../README.md) as the root project-level SSOT anchor.
- **CRE8-GOV-REQ-0002**: Domain canonical requirements **MUST** be authored under `docs/` and **MUST** supersede `seed/` material where both define the same behavior.
- **CRE8-GOV-REQ-0004**: `reports/` artifacts **MUST** be treated as informational and non-normative unless explicitly promoted by governance-controlled change.
- **CRE8-GOV-REQ-0005**: Every normative document **MUST** include the metadata header defined by [`DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`](DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md).
- **CRE8-GOV-REQ-0006**: Every normative document **MUST** declare `normative_dependencies` and **MUST** include at least one cross-domain or governance link when dependencies exist.
- **CRE8-GOV-REQ-0007**: Changes that alter requirement semantics **MUST** follow [`CHANGE_CONTROL_POLICY.md`](CHANGE_CONTROL_POLICY.md) and pass [`DEFINITION_OF_DONE.md`](DEFINITION_OF_DONE.md) gates before merge.

## Canon precedence
1. [`README.md`](../../README.md)
2. Normative docs under `docs/`
3. `reports/` session and analysis outputs

## Required SSOT map
- **`dev/`**: developer-facing onboarding, **`dev/`** README, SSOT syllabus reading list, expert boot prompt, and **implementation milestones** (engineering planning keyed to canon; **`docs/`** remains authoritative where behavior diverges unless governance promotes **`dev/`** material).
- `docs/00_governance/`: governance policy, templates, workflow, and acceptance gates.
- `docs/10_*` through `docs/80_*`: domain contracts and program controls.
- `docs/31_machine_contracts/`: machine-readable contract artifacts (OpenAPI/schemas).
- `docs/evidence/`: evidence templates and automation linkage.

## Verification hooks
- **HOOK-SSOT-LINT-METADATA**: Validate metadata header presence and required keys across normative docs.
- **HOOK-SSOT-LINK-INTEGRITY**: Validate all internal markdown links and anti-orphan requirements.
- **HOOK-SSOT-PRECEDENCE-CHECK**: Detect explicit contradictions between [`README.md`](../../README.md) and updated normative docs before merge.

## See also
- [`dev/` README (developer workspace index)](../../dev/README.md)
- [Implementation milestones & slices roadmap](../../dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md)
- [Expert coding LLM boot prompt](../../dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md)
- [Developer SSOT canon reading list](../../dev/SSOT_CANON_READING_LIST.md)
- [README.md](../../README.md)
- [Document Template and Style Guide](./DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)
- [Document Status and Ownership](./DOCUMENT_STATUS_AND_OWNERSHIP.md)
- [Contribution Workflow SSOT](./CONTRIBUTION_WORKFLOW_SSOT.md)
- [Change Control Policy](./CHANGE_CONTROL_POLICY.md)
- [Definition of Done](./DEFINITION_OF_DONE.md)
- [Cross-Document Linking Policy](./CROSS_DOCUMENT_LINKING_POLICY.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [ADR-001 Record](../80_traceability_decisions_and_program/records/ADR-001-requirement-id-normalization.md)
- [ADR-002 Record](../80_traceability_decisions_and_program/records/ADR-002-traceability-matrix-minimum-schema.md)
- [ADR-003 Record](../80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md)
- [ADR-004 Record](../80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md)
- [ADR-005 Record](../80_traceability_decisions_and_program/records/ADR-005-authz-gate-order-reconciliation.md)
- [ADR-006 Record](../80_traceability_decisions_and_program/records/ADR-006-phase4-program-lock-and-legacy-waiver-retirement.md)

- [Canonical Terminology](../10_product_and_architecture/CANONICAL_TERMINOLOGY.md)
- [Architecture And Surfaces](../10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md)
- [Dependency Baseline](../10_product_and_architecture/DEPENDENCY_BASELINE.md)
- [ID / Utility Keypair Model Specification](../10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md)

- [Draft: Key Minting Permission Lattice](../20_identity_delegation_and_policy/DRAFT_KEY_MINTING_PERMISSION_LATTICE.md) (brainstorm; non-normative until promoted)

- [Request Pipeline And Middleware Contract](../10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md)
- [CRE8 Product And System Spec](../10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md)
- [CRE8 Human Operating Model](../10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md)

- [Endpoint Examples All Routes](../30_contracts_and_interfaces/Endpoint_Examples_All_Routes.md)
- [Webhook And Integration Contract](../30_contracts_and_interfaces/WEBHOOK_AND_INTEGRATION_CONTRACT.md)

- [Audience Group Spec](../50_content_audience_and_feed/AUDIENCE_GROUP_SPEC.md)

- [Migration and Seed Strategy](../60_operations_quality_and_release/MIGRATION_AND_SEED_STRATEGY.md)
- [Observability Event Catalog](../60_operations_quality_and_release/OBSERVABILITY_EVENT_CATALOG.md)
