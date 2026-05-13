# Reusable Prompt — Expert Coding LLM Session for Seed-Generating Program

Copy/paste this prompt into a fresh expert coding LLM session.

---

You are entering the CRE8 repository to continue the seed-generating documentation program.

## Mission (what “success” means)
Build and mature the **seed-generating documentation system** so that it can reliably produce a complete, production-usable guidance corpus for CRE8.

Your objective is not just to fill templates; it is to:
- preserve source meaning with auditable traceability,
- resolve or explicitly register contradictions,
- normalize vocabulary/style/decision logic,
- and deliver a deterministic generation workflow that can be re-run by future sessions with minimal ambiguity.

Primary execution plan:
- `dev/SEED_GENERATING_MILESTONES_AND_SLICES.md`

Program-level alignment and production relevance cross-check:
- `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`

## Required control documents (runtime instructions)
- `seed-generating-docs/00_control/00_master_readme.md`
- `seed-generating-docs/00_control/01_source_inventory.md`
- `seed-generating-docs/00_control/02_content_preservation_ledger.md`
- `seed-generating-docs/00_control/02_canonical_vocabulary.md`
- `seed-generating-docs/00_control/03_document_style_standard.md`
- `seed-generating-docs/00_control/04_conflict_resolution_rules.md`
- `seed-generating-docs/00_control/04a_conflict_register.md`
- `seed-generating-docs/00_control/05_best_practices_registry.md`
- `seed-generating-docs/20_generation/30_llm_generation_instructions.md`
- `seed-generating-docs/20_generation/31_validation_checklist.md`

## Required startup sequence (before implementation)
1. Read onboarding and governance canon in order:
   - `dev/CRE8_ONBOARDING_COMPREHENSIVE_READING_LIST.md`
   - `docs/00_governance/SSOT_INDEX.md`
   - `docs/00_governance/CHANGE_CONTROL_POLICY.md`
   - `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`
2. Read session continuity artifacts:
   - `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
   - `dev/implementation/LATEST_SESSION_HANDOFF.md`
   - `dev/implementation/PROGRESS_BOARD.md`
3. Read milestone execution plans:
   - `dev/SEED_GENERATING_MILESTONES_AND_SLICES.md`
   - `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`
4. Determine where prior session stopped and which next slices are eligible.
5. Publish startup output (mandatory):
   - authority hierarchy summary,
   - current milestone/slice status summary,
   - next 1–3 slices selected with rationale,
   - risk/conflict watchlist,
   - production-relevance check (which implementation milestones are better enabled by today’s planned seed work).

## Execution rules (non-negotiable)
- No substantive source content may be dropped unless explicitly marked deprecated/duplicate/obsolete/superseded in preservation records.
- Never silently resolve contradictions; record unresolved conflicts in `04a_conflict_register.md`.
- Keep terminology normalized against `02_canonical_vocabulary.md`.
- Keep traceability current: **source -> normalized concept -> target seed section -> downstream implementation implication**.
- Prefer additive clarification over destructive rewrites when source meaning is uncertain.
- Update progress artifacts continuously during the session.

## Required artifacts to update during work
- `seed-generating-docs/00_control/01_source_inventory.md`
- `seed-generating-docs/00_control/02_content_preservation_ledger.md`
- `seed-generating-docs/00_control/04a_conflict_register.md` (if needed)
- `seed-generating-docs/30_governance/32_open_questions.md` (if needed)
- `seed-generating-docs/30_governance/33_decision_register.md` (if decisions made)
- `seed-generating-docs/30_governance/34_legacy_language_register.md` (as terms are normalized)
- `seed-generating-docs/30_governance/35_consistency_matrix.md`
- `dev/implementation/PROGRESS_BOARD.md`
- `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`

## Slice-level working protocol (required)
For each selected slice:
1. Declare scope boundaries and expected updated files.
2. Execute changes while maintaining preservation/trace links.
3. Record conflicts, open questions, and decisions as they occur (not only at end).
4. Run applicable validation checks.
5. Record completion state (`done` / `partial` / `blocked`) with concrete evidence.

## Session completion requirements
1. Execute selected slices fully (or mark partial with blockers).
2. Update logs/boards/handoff with:
   - completed slices,
   - changed files,
   - open blockers,
   - next-slice recommendation,
   - explicit implementation-readiness impact (which future production slices now have better guidance).
3. Run validation against `seed-generating-docs/20_generation/31_validation_checklist.md` and report PASS/PARTIAL/FAIL with evidence.
4. Commit changes with a slice-scoped commit message.
5. Produce final response including:
   - summary of completed slice outputs,
   - updated traceability/conflict status,
   - explicit next session starting point,
   - residual risks to seed quality or implementation usability.

## Quality gates for this program
Treat the following as mandatory gates before claiming substantive progress:
- **Preservation gate:** all touched source concepts mapped in preservation ledger.
- **Conflict gate:** no unresolved contradiction omitted from conflict register.
- **Consistency gate:** touched cross-domain concepts updated in consistency matrix.
- **Generation gate:** touched generation instructions remain executable by a fresh session.
- **Implementation-relevance gate:** touched seed content identifies downstream implementation implications.

## Prohibited behavior
- Do not skip startup sequence.
- Do not produce untracked content transformations.
- Do not leave continuity records stale.
- Do not claim completion for slices without updating milestone artifacts.
- Do not mark generated guidance as implementation-ready if traceability/conflict status is incomplete.

---
