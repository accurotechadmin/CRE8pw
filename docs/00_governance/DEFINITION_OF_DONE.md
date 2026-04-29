---
doc_id: CRE8-GOV-DEFINITION-OF-DONE
version: 1.0.0
status: normative
owner: Docs Governance WG
reviewers:
  - Platform Architecture WG
  - Security WG
  - Delivery Operations WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Definition of Done

## Purpose
This document defines the mandatory completion criteria for SSOT changes prior to merge.

## Normative requirements
- **CRE8-GOV-REQ-0050**: Every normative document change **MUST** pass metadata-header completeness checks.
- **CRE8-GOV-REQ-0051**: Every normative document change **MUST** include deterministic requirement statements and **MUST NOT** contain scaffold placeholder prose.
- **CRE8-GOV-REQ-0052**: Requirement ID changes **MUST** be unique and conform to `CRE8-<DOMAIN>-REQ-####` format.
- **CRE8-GOV-REQ-0053**: Each changed requirement **MUST** include a declared verification hook or explicit reference to centralized verification catalog coverage.
- **CRE8-GOV-REQ-0054**: Each normative change **MUST** include traceability references to impacted dependencies and related artifacts.
- **CRE8-GOV-REQ-0055**: Required reviewers and owner approvals **MUST** be complete according to change class gates.
- **CRE8-GOV-REQ-0056**: Any unresolved ambiguity, risk, or deferred item **MUST** be documented in a visible follow-up artifact before merge.

## Done checklist
- Metadata header valid and complete.
- Requirement statements updated with stable IDs.
- Cross-links and dependencies updated.
- Verification executed and evidence recorded.
- Traceability and impact artifacts updated.
- Required approvals complete.

## Verification hooks
- **HOOK-SSOT-DOD-METADATA**: Validate metadata schema compliance.
- **HOOK-SSOT-DOD-PLACEHOLDER-BLOCK**: Detect prohibited scaffold language in normative docs.
- **HOOK-SSOT-DOD-TRACEABILITY**: Validate requirement-level traceability references exist.

## See also
- [Contribution Workflow SSOT](./CONTRIBUTION_WORKFLOW_SSOT.md)
- [Change Control Policy](./CHANGE_CONTROL_POLICY.md)
- [Document Template and Style Guide](./DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
