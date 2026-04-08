# Contribution Workflow (SSOT-First)

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define contributor workflow for making SSOT-first changes safely and consistently.

## Scope
End-to-end flow: issue triage, impact mapping, implementation, verification, and release handoff.

## Normative statements
- Contributors MUST start from canon docs before editing runtime contracts.
- SSOT-impacting changes MUST include change impact map and traceability updates.
- Security-relevant changes SHOULD include abuse-case test updates.

## Interfaces / contracts
1. Identify impact class and affected docs.
2. Update SSOT draft docs and gaps tracker.
3. Implement code/test changes.
4. Run required checks and collect evidence.
5. Submit PR with checklist + ADR/impact links.

## Failure/rejection semantics
- Skipping SSOT update step introduces drift and should fail review.
- Missing evidence links in PR description are workflow violations.

## Verification requirements
- Reviewer confirms step completion and artifact links.

## Traceability hooks
- Code refs: repository PR process files (pending)
- Tests refs: `tests/Contract/*`, `tests/Security/*`
- Related SSOT docs: `DEFINITION_OF_DONE.md`, `../50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`

## Open questions / known gaps
- Need final mapping to GitHub issue/PR templates in this repository.

## Session progress (2026-04-08)
### Completed in this session
- Kept PM artifacts structured for roadmap, risk, workflow, and DoD governance.
- Maintained explicit links between SSOT quality and delivery controls.
- Prepared these docs for milestone-driven execution tracking.
### Remaining to finish this document
- [ ] Add dated milestones with owners and acceptance evidence.
- [ ] Quantify risks using probability/impact and mitigation triggers.
- [ ] Finalize SSOT-specific definition-of-done gates used in PR reviews.

