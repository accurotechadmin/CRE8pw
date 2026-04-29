---
doc_id: CRE8-GOV-CONTRIB-WORKFLOW
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
  - docs/00_governance/SSOT_INDEX.md
  - docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md
  - docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/00_governance/DEFINITION_OF_DONE.md
---

# Contribution Workflow SSOT

## Purpose
This document defines the mandatory contribution workflow for all normative SSOT changes in the CRE8 repository.

## Change classes
- `contract-impacting`: affects behavioral requirements, interfaces, or machine contracts.
- `security-impacting`: affects trust model, key lifecycle, abuse controls, or sensitive policy semantics.
- `governance-only`: affects process, ownership, lifecycle, or canon governance mechanics.
- `editorial-non-normative`: formatting, spelling, or readability changes with no requirement-semantic effect.

## Normative requirements
- **CRE8-GOV-REQ-0030**: Every pull request touching `docs/` **MUST** declare one change class from this document.
- **CRE8-GOV-REQ-0031**: Every pull request touching normative requirements **MUST** include an explicit impact map naming changed requirement IDs and affected dependent documents.
- **CRE8-GOV-REQ-0032**: `contract-impacting` changes **MUST** include review by Platform Architecture WG before merge.
- **CRE8-GOV-REQ-0033**: `security-impacting` changes **MUST** include Security WG review before merge.
- **CRE8-GOV-REQ-0034**: Any status promotion to `normative` **MUST** include owner approval and at least one reviewer approval distinct from owner.
- **CRE8-GOV-REQ-0035**: If a change modifies machine-contract-bound behavior, the pull request **MUST** reference corresponding machine artifact updates or an approved deferred-work item.
- **CRE8-GOV-REQ-0036**: Editorial changes **MUST NOT** alter requirement IDs, RFC keywords, or behavioral semantics.
- **CRE8-GOV-REQ-0037**: All merged normative changes **MUST** satisfy `DEFINITION_OF_DONE.md` checks and record outcomes in the PR body.

## Workflow gates
1. Author prepares change scope, class, and impacted requirements.
2. Author updates metadata, requirement IDs, dependencies, and trace links.
3. Required reviewers complete class-specific review gates.
4. Author executes required verification hooks and attaches evidence references.
5. Owner confirms Definition of Done and approves merge.

## Review SLA and escalation
- Initial reviewer response target: 2 business days.
- Final review closure target: 5 business days.
- Escalation path: owner team lead -> Docs Governance WG lead -> program sponsor.

## Verification hooks
- **HOOK-SSOT-PR-CHANGE-CLASS**: Validate each SSOT PR declares one change class.
- **HOOK-SSOT-PR-REVIEW-GATES**: Validate required reviewer group approvals by change class.
- **HOOK-SSOT-PR-DOD-REFERENCE**: Validate PR includes Definition of Done evidence references.

## See also
- [SSOT Index](./SSOT_INDEX.md)
- [Document Status and Ownership](./DOCUMENT_STATUS_AND_OWNERSHIP.md)
- [Change Control Policy](./CHANGE_CONTROL_POLICY.md)
- [Definition of Done](./DEFINITION_OF_DONE.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
