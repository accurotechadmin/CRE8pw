---
doc_id: CRE8-TRACE-ADR-005
version: 1.0.0
status: accepted
owner: Identity & Policy WG
reviewers:
  - API Contracts WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md
  - docs/80_traceability_decisions_and_program/ADR_INDEX.md
  - docs/80_traceability_decisions_and_program/DECISIONS_LOG.md
---

# ADR-005: Authorization gate order reconciliation

## Decision
The canonical authorization gate order is: lifecycle state -> credential validity -> explicit deny -> scope match -> permission match -> delegation depth -> expiry window.

## Status
Accepted on 2026-04-30.

## Consequences
All policy-order contract checks and reason-mapping artifacts must use this exact sequence.
