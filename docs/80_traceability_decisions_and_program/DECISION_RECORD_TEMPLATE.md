---
doc_id: CRE8-TRACE-DECISION-RECORD-TEMPLATE
version: 1.0.0
status: normative
owner: Program Traceability WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/80_traceability_decisions_and_program/ADR_INDEX.md
  - docs/80_traceability_decisions_and_program/RISK_REGISTER.md
---

# Decision Record Template

## Purpose
Provide the required ADR structure for decisions that alter normative behavior, architecture, or control posture.

## Normative requirements
- **CRE8-TRACE-REQ-0020**: ADR identifiers **MUST** use `ADR-###` and be unique.
- **CRE8-TRACE-REQ-0021**: Every ADR **MUST** include status, context, decision, consequences, and linked requirement IDs.
- **CRE8-TRACE-REQ-0022**: ADRs impacting security/privacy/crypto controls **MUST** include explicit risk linkage to `RISK-###` entries.
- **CRE8-TRACE-REQ-0023**: Accepted ADRs **MUST** be indexed in `ADR_INDEX.md` and logged in `DECISIONS_LOG.md` in the same pull request.
- **CRE8-TRACE-REQ-0024**: Superseded ADRs **MUST** declare successor ADR ID and rationale.

## Required ADR template
```markdown
# ADR-###: <Title>
- Status: proposed | accepted | superseded | rejected
- Date (UTC): YYYY-MM-DD
- Owners:
- Reviewers:

## Context
<Problem statement and constraints>

## Decision
<Chosen approach>

## Alternatives considered
- Option A:
- Option B:

## Consequences
- Positive:
- Negative:
- Neutral:

## Traceability linkage
- Requirement IDs: CRE8-...-REQ-....
- Risk IDs: RISK-... (if applicable)
- Verification hooks: HOOK-...

## Supersession
- Supersedes:
- Superseded by:
```

## Verification
- Manual gate: `DEFINITION_OF_DONE` review verifies required sections and linkage fields.
- Future automation hook: `HOOK-ADR-FORMAT-LINT` to validate sections and ID patterns.

## See also
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [ADR Index](./ADR_INDEX.md)
- [Decisions Log](./DECISIONS_LOG.md)
- [Risk Register](./RISK_REGISTER.md)
