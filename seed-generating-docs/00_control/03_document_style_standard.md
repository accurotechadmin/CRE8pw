# Document Style and Presentation Standard

## Tone
- Deterministic, implementation-ready, non-aspirational.

## Required frontmatter keys
- doc_id
- version
- status
- owner
- reviewers
- last_reviewed_utc
- next_review_due_utc
- source_seed_refs
- normative_dependencies

## Required section order template
1. Purpose
2. Scope
3. Canonical Decisions
4. Requirements
5. Implementation Notes
6. Dependencies
7. Edge Cases
8. Open Questions
9. Source Traceability
10. Verification Hooks
11. See Also

## Requirement phrasing rules
- Use RFC terms: MUST/SHOULD/MAY.
- One behavioral invariant per bullet.
- Explicit failure semantics where applicable.

## Legacy-language control
- Avoid unqualified: temporary, prototype, WIP, future phase.
- If still true, capture in open question + conflict/decision registers.
