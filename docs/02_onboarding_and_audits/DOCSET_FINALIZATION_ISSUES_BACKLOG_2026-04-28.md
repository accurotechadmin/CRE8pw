# Docset Finalization Issues Backlog (Non-README Files)

## Purpose
This backlog captures non-README documents that still contain progress-state, blocked-state, or extra-docset execution dependencies, and should be normalized in the next pass to a definitive, final SSOT-ready posture.

## Finalization rules for next pass
1. Remove language that marks the docset as blocked, pending, in-progress, draft, or execution-gated.
2. Remove/replace requirements that depend on runtime execution evidence external to the doc repository.
3. Preserve normative behavioral contracts while rephrasing program-governance artifacts into final, closed-state records.
4. Keep historical/progress context only in clearly archival artifacts.

## Priority 1: Canon and program artifacts with explicit blocked/pending language
- `docs/03_execution_planning/session_logs/SESSION_STATUS_CURRENT.md`
  - Contains ACT blocked status, blockers, and recommended next execution batch.
- `docs/03_execution_planning/session_logs/SLICE_PROGRESS_LEDGER.md`
  - Contains ACT-06/ACT-07 blocked rows and pending production evidence wording.
- `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md`
  - States ACT-06/ACT-07 blocked and M4 blocked pending Gate D evidence.
- `docs/02_onboarding_and_audits/DOCUMENT_UPGRADE_PROCESS_COMPLETENESS_REPORT_2026-04-28.md`
  - Explicitly scores completion below 100% and references runtime-evidence blockers.

## Priority 2: Execution-planning artifacts that still encode non-final progression states
- `docs/03_execution_planning/ARCHITECTURE_ADDITIONS_AND_UPGRADES_IMPLEMENTATION_MASTER_PLAN.md`
- `docs/03_execution_planning/ARCHITECTURE_ADDITIONS_AND_UPGRADES_EXHAUSTIVE_SLICES.md`
- `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`
- `docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md`
- `docs/03_execution_planning/FINAL_PRODUCTION_DOCSET_MULTI_SESSION_MASTER_PROMPT.md`

Required adjustment: convert from open execution protocol language to closed/finalized canonical reference language where appropriate for a finished document-upgrade state.

## Priority 3: Onboarding/audit artifacts containing maturity-gap or pending-evidence assertions
- `docs/02_onboarding_and_audits/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md`
- `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`
- `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
- `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-23_STAFF_ENGINEER_WORKING_MODEL.md`
- `docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md`

Required adjustment: preserve them as dated historical analysis or remove active-language claims about unresolved work.

## Priority 4: Session logs containing “pending/not_started/blocked” lifecycle statements
- `docs/03_execution_planning/session_logs/SESSION_LOG_2026-04-28_*.md` (multiple files)

Required adjustment: either archive as immutable historical logs (explicitly non-normative) or add a top-level archival notice that they do not define current completion state.

## Priority 5: Task-specific and risk/task docs still framing unresolved follow-up
- `docs/ssot_canon/80_program_management/RISK_REGISTER.md` (contains optional/potential mitigation language)
- `docs/ssot_canon/80_program_management/KEY_TYPE_SPEC_COHERENCE_TASK.md`
- `docs/ssot_canon/80_program_management/KEY_HIERARCHY_SCALE_ANALYSIS_TASK.md`

Required adjustment: normalize posture to final authoritative references, or explicitly classify as bounded historical/management artifacts outside normative behavioral truth.

## Suggested execution order (next pass)
1. Program-state authorities first: `SESSION_STATUS_CURRENT.md`, `SLICE_PROGRESS_LEDGER.md`, `ROADMAP_AND_MILESTONES.md`.
2. Replace/retire the completeness report that declares non-final state.
3. Normalize execution-planning master docs from open/progressive language to finalized-state language.
4. Archive-label historical onboarding and session logs.
5. Sweep remaining program-management/task docs for lingering non-final language.
