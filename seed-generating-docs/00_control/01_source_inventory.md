# Source Document Inventory

## Schema
| source_id | file_path | title | doc_type | phase_origin | subject_area | intended_audience | status_classification | relevance | key_concepts | key_requirements | open_conflicts | downstream_targets | notes |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| SRC-001 | dev/SEED_GENERATING_MILESTONES_AND_SLICES.md | Seed-Generating Program — Comprehensive Milestones and Slices | roadmap | seed_program | execution_planning | seed_program_operators | canonical | high | milestone sequencing; scope-lock gates; /fresh export contract | startup sequence, slice protocol, scope-lock gate enforcement | none | all seed-generating control/governance artifacts | Primary execution plan for seed program sessions. |
| SRC-002 | dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md | CRE8 SSOT implementation milestones & slices | roadmap | implementation_program | implementation_alignment | implementation_and_seed_operators | canonical | high | seed-program coupling; production relevance checkpoints | SC-1..SC-6 coupling expectations | none | progress board; handoff updates; seed implementation relevance notes | Used to cross-check implementation-readiness impact. |
| SRC-003 | reports/session_handoffs/SESSION_HANDOFF_20260505-0605.md | Session Handoff — 2026-05-05 06:05 UTC | continuity | prior_session | resume_context | follow_on_sessions | canonical | high | last completed context; next session starts | deterministic resume point required | none | latest handoff pointer and startup summary | Latest seed-program handoff per pointer. |
| SRC-004 | seed-generating-docs/20_generation/31_validation_checklist.md | Validation and Completeness Checklist | control | seed_program | quality_gates | seed_program_operators | canonical | high | validation pass criteria | must report PASS/PARTIAL/FAIL with evidence | none | session closure report | Used for completion status in this session. |
| SRC-005 | seed-generating-docs/30_governance/36_scope_lock_register.md | Scope Lock Register | governance_register | seed_program | scope_control | seed_program_operators | canonical | high | ethos gate; dependency baseline gate; expansion risk tracking | record scope findings and blocked expansion candidates | none | continuity + validation evidence | Created this session for explicit scope-lock evidence. |

## Completion rules
- One row per source document (no omissions).
- If unknown, use `TBD` with note.
- Add conflict refs when discovered.
