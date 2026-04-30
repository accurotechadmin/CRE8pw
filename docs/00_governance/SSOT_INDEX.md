---
doc_id: CRE8-GOV-SSOT-INDEX
version: 1.0.4
status: normative
owner: Docs Governance WG
reviewers:
  - Security WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
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
- **CRE8-GOV-REQ-0001**: The repository **MUST** treat `README.md` as the root project-level SSOT anchor.
- **CRE8-GOV-REQ-0002**: Domain canonical requirements **MUST** be authored under `docs/` and **MUST** supersede `seed/` material where both define the same behavior.
- **CRE8-GOV-REQ-0003**: `seed/` artifacts **MUST** be used as promotion input when corresponding mature normative domain documentation is incomplete.
- **CRE8-GOV-REQ-0004**: `reports/` artifacts **MUST** be treated as informational and non-normative unless explicitly promoted by governance-controlled change.
- **CRE8-GOV-REQ-0005**: Every normative document **MUST** include the metadata header defined by `DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`.
- **CRE8-GOV-REQ-0006**: Every normative document **MUST** declare `normative_dependencies` and **MUST** include at least one cross-domain or governance link when dependencies exist.
- **CRE8-GOV-REQ-0007**: Changes that alter requirement semantics **MUST** follow `CHANGE_CONTROL_POLICY.md` and pass `DEFINITION_OF_DONE.md` gates before merge.

## Canon precedence
1. `README.md`
2. Normative docs under `docs/`
3. `seed/` documents (fallback source for unpromoted requirements)
4. `reports/` session and analysis outputs

## Required SSOT map
- `docs/00_governance/`: governance policy, templates, workflow, and acceptance gates.
- `docs/10_*` through `docs/80_*`: domain contracts and program controls.
- `docs/31_machine_contracts/`: machine-readable contract artifacts (OpenAPI/schemas).
- `docs/evidence/`: evidence templates and automation linkage.

## Verification hooks
- **HOOK-SSOT-LINT-METADATA**: Validate metadata header presence and required keys across normative docs.
- **HOOK-SSOT-LINK-INTEGRITY**: Validate all internal markdown links and anti-orphan requirements.
- **HOOK-SSOT-PRECEDENCE-CHECK**: Detect explicit contradictions between `README.md` and updated normative docs before merge.

## Change history

- 2026-04-30 (v1.0.1): Added ADR-004 (Phase 3 — Canon Completion Program Charter) cross-link in See also. Change Impact Map: [`reports/change_impact_maps/20260430-0400-P3-S0.2-adr-004-program-charter.md`](../../reports/change_impact_maps/20260430-0400-P3-S0.2-adr-004-program-charter.md).

## See also
- [README.md](../../README.md)
- [Document Template and Style Guide](./DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)
- [Document Status and Ownership](./DOCUMENT_STATUS_AND_OWNERSHIP.md)
- [Contribution Workflow SSOT](./CONTRIBUTION_WORKFLOW_SSOT.md)
- [Change Control Policy](./CHANGE_CONTROL_POLICY.md)
- [Definition of Done](./DEFINITION_OF_DONE.md)
- [Cross-Document Linking Policy](./CROSS_DOCUMENT_LINKING_POLICY.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [ADR-001 Record](../80_traceability_decisions_and_program/records/ADR-001-placeholder.md)
- [ADR-002 Record](../80_traceability_decisions_and_program/records/ADR-002-placeholder.md)
- [ADR-003 Record](../80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md)
- [ADR-004 Record](../80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md)

- [Canonical Terminology](../10_product_and_architecture/CANONICAL_TERMINOLOGY.md)
- [Architecture And Surfaces](../10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md)
- [Dependency Baseline](../10_product_and_architecture/DEPENDENCY_BASELINE.md)
- [ID / Utility Keypair Model Specification](../10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md)

- [Request Pipeline And Middleware Contract](../10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md)
- [CRE8 Product And System Spec](../10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md)
- [CRE8 Human Operating Model](../10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md)

- [Endpoint Examples All Routes](../30_contracts_and_interfaces/Endpoint_Examples_All_Routes.md)
- [Webhook And Integration Contract](../30_contracts_and_interfaces/WEBHOOK_AND_INTEGRATION_CONTRACT.md)
