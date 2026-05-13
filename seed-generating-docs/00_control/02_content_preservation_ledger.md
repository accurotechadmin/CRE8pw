# Content Preservation Ledger

## Schema
| ledger_id | source_doc | source_section | original_concept | normalized_concept | target_doc | target_section | status | decision_ref | conflict_ref | notes |
|---|---|---|---|---|---|---|---|---|---|---|
| CPL-001 | dev/SEED_GENERATING_MILESTONES_AND_SLICES.md | M0 startup + scope-lock gates | startup + scope-lock must run before slice execution | startup_gate_enforcement | reports/session_handoffs/LATEST_SESSION_HANDOFF.md | current-session startup summary | preserved | none | none | Resume discipline preserved with explicit startup output obligations. |
| CPL-002 | dev/SEED_GENERATING_MILESTONES_AND_SLICES.md | Output root contract | all new authored/generated docs under `/fresh` | fresh_export_root_contract | fresh/seed-generating-docs | root subtree | preserved | none | none | Session created root export subtree to remove ambiguity. |
| CPL-003 | dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md | SC-1..SC-6 coupling | seed-program output must improve production readiness | seed_to_implementation_handshake | dev/implementation/PROGRESS_BOARD.md | session seed-program alignment note | preserved | none | none | Added board note on seed-program startup alignment impact. |
| CPL-004 | seed-generating-docs/20_generation/31_validation_checklist.md | checklist closure requirement | report PASS/PARTIAL/FAIL with evidence | validation_status_reporting | reports/session_handoffs/LATEST_SESSION_HANDOFF.md | validation status block | preserved | none | none | Validation summary captured in handoff pointer artifact. |

## Hard gate
Fresh doc set is incomplete until every meaningful source item has a ledger row.
