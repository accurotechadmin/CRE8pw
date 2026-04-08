# Change Impact Map Templates

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide reusable templates for assessing SSOT and implementation impact per change.

## Scope
PR planning for contract, security, data, and operational modifications.

## Normative statements
- SSOT-impacting PRs MUST include an impact map.
- Impact maps SHOULD list modified docs, code paths, tests, and rollout risks.
- High-risk changes MAY require explicit rollback notes.

## Interfaces / contracts
### Template
- Change summary
- Impact class (A/B/C/D)
- Canon docs changed
- Code files changed
- Tests added/updated
- Risks + mitigations
- Rollback notes
- Known gap entries created/updated

## Failure/rejection semantics
- Missing impact map for class A/B change SHOULD block merge.
- Incomplete risk assessment for security/data changes is non-compliant.

## Verification requirements
- PR checklist validation and reviewer signoff.

## Traceability hooks
- Code refs: `.github` workflow/templates (pending)
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php` (policy check anchor)
- Related SSOT docs: `../00_governance/CHANGE_CONTROL_POLICY.md`, `KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- Repository currently has no standard PR template enforcing this map.

## Session progress (2026-04-08)
### Completed in this session
- Maintained templates and structure for SSOT drift prevention workflows.
- Preserved linkage points among requirements, code references, and tests.
- Prepared these docs for CI automation rule authoring.
### Remaining to finish this document
- [ ] Populate the traceability matrix with capability-level mappings.
- [ ] Define CI lint checks and failure policies for SSOT-code drift.
- [ ] Track open gaps with owners, target dates, and risk severity.

