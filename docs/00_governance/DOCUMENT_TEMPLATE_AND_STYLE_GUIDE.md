---
doc_id: CRE8-GOV-DOC-TEMPLATE
version: 1.0.0
status: normative
owner: Docs Governance WG
reviewers:
  - Platform Architecture WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Document Template and Style Guide

## Required metadata header schema
All normative documents under `docs/` **MUST** include a YAML frontmatter header with the following keys:
- `doc_id`
- `version`
- `status`
- `owner`
- `reviewers`
- `last_reviewed_utc`
- `next_review_due_utc`
- `source_seed_refs`
- `normative_dependencies`

## Normative requirements
- **CRE8-GOV-REQ-0010**: `doc_id` **MUST** be unique within the repository.
- **CRE8-GOV-REQ-0011**: `status` **MUST** be one of: `draft`, `provisional-normative`, `normative`, `deprecated`.
- **CRE8-GOV-REQ-0012**: `version` **MUST** follow semantic versioning (`MAJOR.MINOR.PATCH`).
- **CRE8-GOV-REQ-0013**: `last_reviewed_utc` and `next_review_due_utc` **MUST** use `YYYY-MM-DD` UTC date format.
- **CRE8-GOV-REQ-0014**: `normative_dependencies` **MUST** list relative paths to documents that materially constrain interpretation.
- **CRE8-GOV-REQ-0015**: Normative requirement statements **MUST** use RFC-style keywords (`MUST`, `SHOULD`, `MAY`) and **MUST NOT** use placeholder prose.
- **CRE8-GOV-REQ-0016**: Requirement identifiers **MUST** use `CRE8-<DOMAIN>-REQ-####` format and remain stable once published.
- **CRE8-GOV-REQ-0017**: Each normative document **MUST** declare at least one verification hook or explicit reference to a centralized verification catalog.

## Authoring conventions
- Prefer one behavioral invariant per bullet to reduce ambiguity.
- Keep failure semantics deterministic and machine-testable when possible.
- Include a `See also` section with direct links to adjacent and governing canon.

## Verification hooks
- **HOOK-SSOT-LINT-METADATA**: Verify required metadata keys and key formats.
- **HOOK-SSOT-LINT-NORMATIVE-TERMS**: Verify normative docs include RFC-style requirement terms and no scaffold placeholder language.
- **HOOK-SSOT-REQID-FORMAT**: Verify requirement IDs conform to mandated pattern.

## See also
- [SSOT Index](./SSOT_INDEX.md)
- [Document Status and Ownership](./DOCUMENT_STATUS_AND_OWNERSHIP.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
