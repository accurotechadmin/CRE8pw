---
doc_id: CRE8-ADR-001
version: 1.0.0
status: accepted
owner: Docs Governance WG
reviewers:
  - Platform Architecture WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/80_traceability_decisions_and_program/ADR_INDEX.md
  - docs/80_traceability_decisions_and_program/DECISIONS_LOG.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# ADR-001: Requirement ID Normalization
- Status: accepted
- Date (UTC): 2026-04-29
- Owners: Docs Governance WG
- Reviewers: Platform Architecture WG, Program Traceability WG

## Context
Phase 1 canon hardening introduced requirement statements across governance, contracts, and traceability documents. Early drafts mixed unstructured identifiers and inconsistent formatting, which caused ambiguity during link validation and evidence mapping.

## Decision
CRE8 adopts a mandatory requirement identifier format: `CRE8-<DOMAIN>-REQ-####`.

Normative decision requirements:
- **ADR-001-REQ-0001**: All new normative requirements **MUST** use `CRE8-<DOMAIN>-REQ-####` with four-digit zero padding.
- **ADR-001-REQ-0002**: Existing requirement identifiers that do not conform **MUST** be normalized in-place before a document can move to `normative` status.
- **ADR-001-REQ-0003**: Traceability rows **MUST** reference normalized IDs exactly as authored (case-sensitive, hyphen-preserving).
- **ADR-001-REQ-0004**: Automation checks for requirement IDs **MUST** fail hard on malformed IDs and **MUST NOT** autocorrect identifiers.

## Alternatives considered
- Keep mixed historical ID styles and rely on narrative mapping (rejected: high drift risk).
- Use UUID-style opaque identifiers (rejected: poor readability and review ergonomics).

## Consequences
- Positive:
  - Deterministic requirement linking across docs, traceability matrix, and evidence hooks.
  - Simpler parser logic for lint and sync checks.
- Negative:
  - One-time migration cost for legacy scaffold artifacts.
- Neutral:
  - Domain acronym choice remains local as long as global pattern is respected.

## Traceability linkage
- Requirement IDs: CRE8-TRACE-REQ-0001, CRE8-TRACE-REQ-0002
- Risk IDs: RISK-001
- Verification hooks: HOOK-SSOT-LINT-METADATA, HOOK-SSOT-SYNC-PROMOTED-TRACE

## Supersession
- Supersedes: none
- Superseded by: none

## See also
- [ADR Index](../ADR_INDEX.md)
- [Decisions Log](../DECISIONS_LOG.md)
- [Traceability Matrix](../TRACEABILITY_MATRIX.md)
