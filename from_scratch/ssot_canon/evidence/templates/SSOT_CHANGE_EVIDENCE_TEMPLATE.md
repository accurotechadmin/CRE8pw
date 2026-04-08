# SSOT Change Evidence Template

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Capture proof that SSOT-impacting changes remained synchronized across docs, code, tests, and automation.

## Scope
PR-level evidence packet for class A/B/C/D changes.

## Normative statements
- Changes MUST list affected canon docs and code files explicitly.
- Evidence MUST include test and sync-check command outputs.
- Deferred items MUST be logged in known gaps.

## Interfaces / contracts
### Template
- PR/change ID
- Impact class
- Canon docs changed
- Code/tests changed
- Commands run + outcomes
- Drift/waiver entries
- Reviewer signoff

## Failure/rejection semantics
- Incomplete evidence packet SHOULD fail review.
- Missing known gap entries for deferred drift is non-compliant.

## Verification requirements
- Architecture/QA reviewers validate template completeness.

## Traceability hooks
- Code refs: changed files in PR
- Tests refs: suite outputs
- Related SSOT docs: `../../50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`, `../../50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- Need automation to auto-populate changed-file lists.
