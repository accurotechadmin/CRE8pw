# Entity Relationship Diagram

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Capture canonical entity relationships supporting auth, delegation, content, and moderation flows.

## Scope
Logical ERD for core v1 entities.

## Normative statements
- ERD MUST remain consistent with data model spec and reference docs.
- Cardinality and ownership edges MUST support authorization auditing needs.

## Interfaces / contracts
```mermaid
erDiagram
  PRINCIPALS ||--o{{ CREDENTIALS : has
  PRINCIPALS ||--o{{ TOKEN_FAMILIES : owns
  PRINCIPALS ||--o{{ POSTS : authors
  POSTS ||--o{{ COMMENTS : contains
  PRINCIPALS ||--o{{ MODERATION_ACTIONS : executes
```

## Failure/rejection semantics
- Missing edge for implemented foreign-key dependency is an ERD defect.
- Contradictory cardinality definitions MUST be corrected before adoption.

## Verification requirements
- Validate diagram parse/render and cross-check with schema docs.
- Review with auth/data owners each release.

## Traceability hooks
- Code refs: `src/Application/Auth/*`, `src/Application/Posts/*`
- Tests refs: `tests/Contract/*`
- Related SSOT docs: `DATA_MODEL_SPEC.md`, `DATA_MODEL_REFERENCE.md`

## Open questions / known gaps
- Delegation/keychain-specific relationships require fuller ERD expansion.
