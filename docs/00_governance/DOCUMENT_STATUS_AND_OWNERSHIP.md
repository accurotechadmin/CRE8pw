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
