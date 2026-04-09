# Change Control Policy

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Scope
Applies to all files under `from_scratch/ssot_canon/` plus top-level from-scratch planning/completion artifacts.

## Change classes
- **Class A (breaking contract):** route/schema/auth/data invariant changes.
- **Class B (behavioral):** acceptance criteria, policy decision, readiness gate changes.
- **Class C (editorial):** wording/formatting without normative impact.

## Approval requirements
- Class A: architecture + security + operations approvers required.
- Class B: relevant domain owner + QA reviewer.
- Class C: single maintainer review.

## Required PR payload
- Change-impact map (template in traceability folder).
- Updated traceability rows.
- Verification evidence for changed behavior.
- Decision log update when rationale changes policy/architecture.
