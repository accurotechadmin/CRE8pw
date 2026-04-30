---
doc_id: CRE8-OPS-PHASE2-ACCEPTANCE
version: 1.3.0
status: provisional-normative
owner: Operations Quality WG
reviewers:
  - API Contracts WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-13
source_seed_refs:
  - reports/PHASE1_TRUE_COMPLETION_EXECUTION_20260429-1153.md
  - docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md
normative_dependencies:
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - reports/session_handoffs/PHASE2_PROGRESS_BOARD.md
---

# Phase 2 Acceptance Criteria

## Purpose
Define executable acceptance gates for Phase 2 machine-contract lock-in so closure claims are reproducible and evidence-backed.

## Normative requirements
- **CRE8-OPS-REQ-0010**: Phase 2 acceptance evaluation **MUST** be executed via `composer phase2:acceptance-bundle`.
- **CRE8-OPS-REQ-0011**: `phase2:acceptance-bundle` **MUST** hard-fail on any non-zero exit code from its required command set.
- **CRE8-OPS-REQ-0012**: Any Phase 2 scope change touching contracts, parity, hooks, or traceability **MUST** include bundle execution evidence in the latest session handoff.
- **CRE8-OPS-REQ-0013**: Deferred Phase 2 breadth items retained after a bundle run **MUST** remain listed in `PHASE2_PROGRESS_BOARD.md` with owner, due date, and decision reference.
- **CRE8-OPS-REQ-0014**: Pull-request and protected-branch CI that executes SSOT contract gates **MUST** invoke `composer phase2:acceptance-bundle` as a required hard-fail step.
- **CRE8-OPS-REQ-0015**: Any unresolved Phase 2 exception retained after acceptance-bundle execution **MUST** be listed in `PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md` before merge.
- **CRE8-OPS-REQ-0016**: `composer docs:ssot:phase2-exceptions-check` **MUST** run as a required command within the Phase 2 acceptance bundle and **MUST** fail on schema/ownership/deadline-reference violations in the unresolved exceptions register.
- **CRE8-OPS-REQ-0022**: `phase2:acceptance-bundle` required command list **MUST** include `composer test:contract:lifecycle` so lifecycle-propagation regressions cannot bypass acceptance.

## Required acceptance bundle commands
1. `composer docs:ssot:lint`
2. `composer docs:ssot:sync-check`
3. `composer docs:ssot:report`
4. `composer docs:ssot:route-parity`
5. `composer docs:ssot:review-gate-check`
6. `composer docs:ssot:phase2-exceptions-check`
7. `composer test:contract:auth`
8. `composer test:contract:feed`
9. `composer test:contract:identity-issuance`
10. `composer test:contract:identity-context`
11. `composer test:contract:lifecycle`
12. `composer test:contract:surface-parity`

## Change-impact map reference
- Template: `docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`
- Session artifact expectation: link the generated/updated change-impact map in the active `SESSION_HANDOFF_*.md` under verification evidence.

## Verification hooks
- **HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE**: Execute `composer phase2:acceptance-bundle`; expected result is zero exit with all constituent commands passing and logged in session handoff evidence.

- [Phase 2 Unresolved Exceptions Register](./PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md)

## See also
- [Verification Strategy](./VERIFICATION_STRATEGY.md)
- [Prose↔OpenAPI Parity Table](../31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Phase 2 Progress Board](../../reports/session_handoffs/PHASE2_PROGRESS_BOARD.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)


## Phase 3 supersession path

Upon completion of Phase 3 M11.3, `composer phase3:final-acceptance-bundle` MUST run as a superset gate over this Phase 2 bundle.
