# Release Evidence Template

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide a consistent template for release-evidence bundles.

## Scope
Pre-release, go-live, and post-release evidence summaries.

## Normative statements
- Release evidence MUST include required command outputs and gate verdicts.
- Incident or waiver notes MUST be explicitly documented.
- Evidence template SHOULD be attached to release ticket.

## Interfaces / contracts
### Template
- Release ID/date/environment
- Commands executed + outcomes
- Gate summary (A/B/C/D)
- Known gaps/waivers
- Approvals
- Follow-up actions

## Failure/rejection semantics
- Missing gate verdicts invalidates release evidence package.
- Unapproved waivers are non-compliant.

## Verification requirements
- QA/platform signoff confirms completed template.

## Traceability hooks
- Code refs: release pipeline (pending)
- Tests refs: command outputs
- Related SSOT docs: `../../40_operations_and_quality/PRODUCTION_READINESS_GATES.md`, `../../40_operations_and_quality/RELEASE_CHECKLIST.md`

## Open questions / known gaps
- Need finalized release ID convention.
