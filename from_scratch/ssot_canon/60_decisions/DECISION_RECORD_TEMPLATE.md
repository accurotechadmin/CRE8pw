# Decision Record Template

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide a reusable ADR template to ensure decisions are structured, reviewable, and traceable.

## Scope
Template for all new ADR entries.

## Normative statements
- ADRs MUST include context, decision, alternatives considered, consequences, and rollback path.
- Security-impacting ADRs SHOULD include threat and abuse-case deltas.
- Data-impacting ADRs MUST reference migration and compatibility strategy docs.

## Interfaces / contracts
### ADR template
- ADR ID
- Title
- Status
- Date
- Context
- Decision
- Alternatives considered
- Consequences (positive/negative)
- Verification plan
- Rollback/deprecation path
- Linked docs/routes/tests

## Failure/rejection semantics
- ADRs missing consequences or verification plan are incomplete.
- ADRs without linked SSOT impact docs MUST not be accepted.

## Verification requirements
- Reviewer checklist verifies every required section.
- Adoption PR must include ADR link in description.

## Traceability hooks
- Code refs: n/a template document
- Tests refs: n/a
- Related SSOT docs: `ADR_INDEX.md`, `../70_implementation_guidance/MIGRATION_AND_COMPATIBILITY_STRATEGY.md`, `../50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`

## Open questions / known gaps
- Need final decision on whether ADR IDs are global or area-scoped.
