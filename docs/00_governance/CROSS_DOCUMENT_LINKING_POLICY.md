---
doc_id: CRE8-GOV-CROSS-LINK-POLICY
version: 1.0.0
status: provisional-normative
owner: Docs Governance WG
reviewers:
  - Platform Architecture WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
  - seed/CRE8_SEED_CANON_INDEX.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Cross-Document Linking Policy

## Purpose
Define mandatory link topology, anti-orphan controls, and trace-link expectations for all CRE8 normative documentation.

## Normative requirements
- **CRE8-GOV-REQ-0060**: Every normative or provisional-normative document **MUST** include a `See also` section with at least two repository-relative links, including one governance or traceability link.
- **CRE8-GOV-REQ-0061**: Every normative or provisional-normative document **MUST** include `normative_dependencies` metadata entries for all documents that materially constrain interpretation.
- **CRE8-GOV-REQ-0062**: A domain document under `docs/10_*` through `docs/80_*` **MUST** be reachable by at least one vertical path from [`README.md`](README.md) through [`docs/00_governance/SSOT_INDEX.md`](docs/00_governance/SSOT_INDEX.md).
- **CRE8-GOV-REQ-0063**: Any requirement-bearing document **MUST NOT** be orphaned; at least one inbound link from [`SSOT_INDEX.md`](SSOT_INDEX.md) or a same-domain index document **MUST** exist.
- **CRE8-GOV-REQ-0064**: When a requirement in one document depends on a requirement in another document, the source document **MUST** include both a dependency entry and a `See also` cross-link to the dependent document.
- **CRE8-GOV-REQ-0065**: If a changed requirement ID is represented in [`TRACEABILITY_MATRIX.md`](TRACEABILITY_MATRIX.md), the source document **MUST** preserve a stable heading anchor or provide a redirect note in the same pull request.

## Required link topology
1. **Vertical topology**: [`README.md`](README.md) → [`docs/00_governance/SSOT_INDEX.md`](docs/00_governance/SSOT_INDEX.md) → domain documents.
2. **Lateral topology**: domain documents ↔ dependent domain documents declared in `normative_dependencies`.
3. **Trace topology**: requirement-bearing docs → [`TRACEABILITY_MATRIX.md`](TRACEABILITY_MATRIX.md) and related verification/evidence artifacts.

## Anti-orphan policy
- A document is considered orphaned when no canonical governance or domain index path links to it.
- Orphaned normative/provisional documents **MUST** fail SSOT lint and **MUST NOT** merge until linked.
- Transitional exceptions **MAY** be used only for newly created documents within a single PR and **MUST** be removed before merge.

## Verification hooks
- **HOOK-SSOT-LINK-INTEGRITY**: Validate markdown link targets resolve and no broken local links exist.
- **HOOK-SSOT-LINK-TOPOLOGY**: Validate required vertical and lateral link topology invariants.
- **HOOK-SSOT-ANTI-ORPHAN-CHECK**: Validate every normative/provisional doc has a discoverable inbound governance/domain index path.

## See also
- [README.md](../../README.md)
- [SSOT Index](./SSOT_INDEX.md)
- [Document Template and Style Guide](./DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [SSOT Automation and Linting](../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md)
