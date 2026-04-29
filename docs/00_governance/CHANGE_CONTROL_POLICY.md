---
doc_id: CRE8-GOV-CHANGE-CONTROL
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
  - docs/00_governance/DEFINITION_OF_DONE.md
  - docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Change Control Policy

## Purpose
This document defines how SSOT changes are proposed, reviewed, approved, and recorded to preserve canon integrity and deterministic platform direction.

## Normative requirements
- **CRE8-GOV-REQ-0040**: Every normative SSOT change **MUST** include a change record containing scope, rationale, affected requirement IDs, and compatibility notes.
- **CRE8-GOV-REQ-0041**: Change records **MUST** classify compatibility as one of `backward-compatible`, `conditionally-compatible`, or `breaking`.
- **CRE8-GOV-REQ-0042**: `breaking` changes **MUST** include migration notes and explicit rollout sequencing requirements.
- **CRE8-GOV-REQ-0043**: Changes that add or modify requirement IDs **MUST** update the traceability mapping location referenced by `TRACEABILITY_MATRIX.md`.
- **CRE8-GOV-REQ-0044**: Deferred verification or deferred machine-contract sync **MUST** include a time-bounded follow-up item with named owner and due date.
- **CRE8-GOV-REQ-0045**: A change **MUST NOT** be merged when required review gates defined by `CONTRIBUTION_WORKFLOW_SSOT.md` are incomplete.
- **CRE8-GOV-REQ-0046**: Post-merge discovery of semantic drift **MUST** trigger corrective change control within 2 business days.

## Required change artifacts
1. Change summary and scope statement.
2. Requirement impact map (IDs changed, added, removed).
3. Compatibility classification and migration notes when applicable.
4. Verification evidence links.
5. Deferred-work register entries (if any) with owner and due date.

## Verification hooks
- **HOOK-SSOT-CHANGE-RECORD-COMPLETE**: Validate presence of required change artifacts for normative changes.
- **HOOK-SSOT-COMPAT-CLASSIFICATION**: Validate compatibility class and migration notes for breaking changes.
- **HOOK-SSOT-DEFERRED-WORK-BOUNDED**: Validate deferred items contain owner and due date.

## See also
- [Contribution Workflow SSOT](./CONTRIBUTION_WORKFLOW_SSOT.md)
- [Definition of Done](./DEFINITION_OF_DONE.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
