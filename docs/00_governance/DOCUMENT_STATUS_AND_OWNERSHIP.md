---
doc_id: CRE8-GOV-DOC-OWNERSHIP
version: 1.0.0
status: normative
owner: Docs Governance WG
reviewers:
  - Platform Architecture WG
  - Delivery Operations WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md
---

# Document Status and Ownership

## Status lifecycle
- `draft`: exploratory content not approved for implementation direction.
- `provisional-normative`: approved for bounded implementation with identified follow-up gaps.
- `normative`: approved as authoritative implementation direction.
- `deprecated`: retained for history and backward reference; not valid for new implementation guidance.

## Normative requirements
- **CRE8-GOV-REQ-0020**: Every document in `docs/` **MUST** have exactly one declared owner team.
- **CRE8-GOV-REQ-0021**: Every normative or provisional-normative document **MUST** list at least one reviewer team distinct from the owner.
- **CRE8-GOV-REQ-0022**: A document **MUST NOT** move to `normative` status without recorded review completion under `CONTRIBUTION_WORKFLOW_SSOT.md`.
- **CRE8-GOV-REQ-0023**: `next_review_due_utc` **MUST** be no later than 90 days after `last_reviewed_utc` for `normative` documents.
- **CRE8-GOV-REQ-0024**: Changes to owner or status **MUST** be logged in the change artifact required by `CHANGE_CONTROL_POLICY.md`.
- **CRE8-GOV-REQ-0025**: `deprecated` documents **MUST** include replacement references or explicit retirement rationale.
- **CRE8-GOV-REQ-0026**: Documents **MUST** align owner/reviewer assignments with the domain matrix in this document unless an approved exception is recorded in the change artifact.
- **CRE8-GOV-REQ-0027**: `security-impacting` changes **MUST** include Security WG in reviewers even when the matrix lists Security WG as optional-by-class.


## Domain ownership and review matrix
| Domain path | Default owner team (A) | Required reviewer teams (R/C) | Notes |
|---|---|---|---|
| `docs/00_governance/` | Docs Governance WG | Platform Architecture WG; Security WG (when security-impacting) | Governance/process canon. |
| `docs/10_product_and_architecture/` | Platform Architecture WG | Docs Governance WG; Delivery Operations WG | Product and architectural direction. |
| `docs/20_identity_delegation_and_policy/` | Platform Architecture WG | Security WG; Docs Governance WG | Delegation and policy determinism. |
| `docs/30_contracts_and_interfaces/` | Platform Architecture WG | Delivery Operations WG; Docs Governance WG | Prose interface contracts. |
| `docs/31_machine_contracts/` | Platform Architecture WG | Delivery Operations WG; Security WG | OpenAPI/schema contract artifacts. |
| `docs/40_data_security_and_crypto/` | Security WG | Platform Architecture WG; Docs Governance WG | Crypto, trust, and key protections. |
| `docs/50_content_audience_and_feed/` | Product Policy WG | Platform Architecture WG; Security WG | Audience and interaction policy semantics. |
| `docs/60_operations_quality_and_release/` | Operations Quality WG | Delivery Operations WG; Platform Architecture WG | Verification and release controls. |
| `docs/70_extensibility_and_module_patterns/` | Platform Architecture WG | Security WG; Docs Governance WG | Extension invariants and compatibility seams. |
| `docs/80_traceability_decisions_and_program/` | Program Traceability WG | Docs Governance WG; Delivery Operations WG | Traceability and program controls. |
| `docs/evidence/` | Operations Quality WG | Program Traceability WG; Docs Governance WG | Evidence packs and automation outputs. |

## Ownership protocol
1. Proposer opens a change with owner and reviewer assignments.
2. Current owner validates scope and dependency impacts.
3. Reviewer(s) approve or request changes.
4. Owner updates metadata dates and status.
5. Change is merged only after Definition of Done checks pass.

## Verification hooks
- **HOOK-SSOT-OWNER-PRESENCE**: Validate owner/reviewer fields exist for all normative and provisional-normative docs.
- **HOOK-SSOT-REVIEW-CADENCE**: Validate review dates and maximum review age policy.
- **HOOK-SSOT-STATUS-TRANSITION**: Validate status promotions include workflow evidence references.

## See also
- [SSOT Index](./SSOT_INDEX.md)
- [Document Template and Style Guide](./DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)
- [Contribution Workflow SSOT](./CONTRIBUTION_WORKFLOW_SSOT.md)
- [Change Control Policy](./CHANGE_CONTROL_POLICY.md)
