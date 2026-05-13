# Seed-Generating Program — Comprehensive Milestones and Slices

## Purpose
Define the complete execution roadmap for authoring and validating the full `seed-generating-docs` system and producing a fresh, normalized production-guidance doc set. All newly authored/generated program outputs are rooted under `/fresh` for repository-portable export.

## Status model
- `not_started`
- `in_progress`
- `blocked`
- `done`

## Milestone index
- M0: Session boot and continuity alignment
- M1: Source control layer completion
- M2: Preservation + traceability layer completion
- M3: Normalization layer completion
- M4: Resolution layer completion
- M5: Canonical knowledge layer authoring (10–19 seeds)
- M6: Generation layer completion
- M7: Validation and consistency closure
- M8: Final corpus generation dry run
- M9: Release handoff and operationalization

## Output root contract (`/fresh`)
- Create all **new** seed-authored and generated corpus documents under repository-root `/fresh`.
- Use `/fresh/seed-generating-docs/` as the canonical subtree for authored controls/seeds/final outputs created by this program.
- Legacy in-place governance/continuity artifacts outside `/fresh` may still be updated when explicitly required by session protocol.
- Any slice that creates documents must list the exact `/fresh/...` paths in-session and in handoff notes.

---

## M0 — Session boot and continuity alignment
**Goal:** deterministic startup, exact resume point, no continuity drift.

### Slices
- S0.1 Read onboarding corpus and governance anchors.
- S0.2 Read latest handoff/progress artifacts and extract last completed slice.
- S0.3 Publish startup summary + selected next slices.
- S0.4 Verify working branch clean, then begin execution.

### Exit criteria
- Startup summary recorded in current session response.
- Resume point identified with explicit prior slice reference.

---

## M1 — Source control layer completion
**Goal:** exhaustive source inventory and provenance map.

### Slices
- S1.1 Enumerate all source docs in `/seed`, `/docs`, relevant `/dev`, `/reports` continuity assets.
- S1.2 Populate `01_source_inventory.md` rows with required fields.
- S1.3 Classify each source as canonical/partial/legacy/duplicate/deprecated/unresolved.
- S1.4 Add downstream-target mapping hints for each source.
- S1.5 QA pass for omissions and duplicate rows.

### Exit criteria
- 100% inventoried source list.
- No empty required schema fields without `TBD` + note.

---

## M2 — Preservation + traceability layer completion
**Goal:** no-loss mapping from source content to normalized/final targets.

### Slices
- S2.1 Break sources into meaningful concepts/requirements.
- S2.2 Populate ledger rows for all meaningful source items.
- S2.3 Mark per-row status: preserved/merged/split/renamed/deprecated/superseded/conflict_unresolved.
- S2.4 Link decisions/conflicts where status requires justification.
- S2.5 Coverage audit: every meaningful source item has ledger row.

### Exit criteria
- No-loss gate satisfied.
- Preservation ledger coverage traceable and reviewable.

---

## M3 — Normalization layer completion
**Goal:** consistent terminology, style, and best-practice canon.

### Slices
- S3.1 Populate canonical vocabulary table with domain terms and definitions.
- S3.2 Build legacy->canonical replacement mapping from source corpus.
- S3.3 Normalize style-standard details for final docs.
- S3.4 Populate best-practices registry with source anchors and target docs.
- S3.5 Terminology drift scan and remediation entries.

### Exit criteria
- Vocabulary table materially complete for all core domains.
- Legacy phrase strategy documented and actionable.

---

## M4 — Resolution layer completion
**Goal:** explicit contradiction handling with auditable outcomes.

### Slices
- S4.1 Detect cross-doc conflicts (requirements, naming, behavior).
- S4.2 Record each unresolved conflict in conflict register.
- S4.3 Log open questions and ownership.
- S4.4 Record approved decisions with impacted docs/requirements.
- S4.5 Escalate behavior-blocking conflicts.

### Exit criteria
- No hidden conflicts.
- All active conflicts have status, owner, and next action.

---

## M5 — Canonical knowledge layer authoring (10–19 seeds)
**Goal:** fully author complete seed docs for each domain.

### Slices
- S5.1 Author `/fresh/seed-generating-docs/10_seeds/10_architecture_seed.md`.
- S5.2 Author `/fresh/seed-generating-docs/10_seeds/11_product_functional_seed.md`.
- S5.3 Author `/fresh/seed-generating-docs/10_seeds/12_implementation_seed.md`.
- S5.4 Author `/fresh/seed-generating-docs/10_seeds/13_domain_data_model_seed.md`.
- S5.5 Author `/fresh/seed-generating-docs/10_seeds/14_workflows_seed.md`.
- S5.6 Author `/fresh/seed-generating-docs/10_seeds/15_api_interface_seed.md`.
- S5.7 Author `/fresh/seed-generating-docs/10_seeds/16_ui_ux_seed.md`.
- S5.8 Author `/fresh/seed-generating-docs/10_seeds/17_testing_quality_seed.md`.
- S5.9 Author `/fresh/seed-generating-docs/10_seeds/18_security_privacy_reliability_seed.md`.
- S5.10 Author `/fresh/seed-generating-docs/10_seeds/19_operations_deployment_seed.md`.
- S5.11 Cross-seed alignment pass (entities/roles/flows/contracts/controls).

### Exit criteria
- Each seed document fully populated beyond template placeholders.
- Cross-seed alignment issues captured in consistency matrix.

---

## M6 — Generation layer completion
**Goal:** deterministic final-doc generation contract.

### Slices
- S6.1 Populate `20_final_document_blueprint.md` with final file map.
- S6.2 Expand `30_llm_generation_instructions.md` with strict step-by-step ops.
- S6.3 Define and enforce output folder conventions rooted at `/fresh` (including final corpus export paths) and naming policy.
- S6.4 Define minimum content thresholds for generated docs.
- S6.5 Define regeneration idempotency checks.

### Exit criteria
- Blueprint complete and executable by fresh LLM session.

---

## M7 — Validation and consistency closure
**Goal:** measurable completion gates and cross-doc consistency.

### Slices
- S7.1 Run full checklist in `31_validation_checklist.md`.
- S7.2 Populate `35_consistency_matrix.md` across major concept axes.
- S7.3 Resolve/flag residual inconsistency rows.
- S7.4 Confirm traceability, conflict, and decision artifacts are synchronized.

### Exit criteria
- Validation checklist at PASS or PASS-with-explicit-waivers.

---

## M8 — Final corpus generation dry run
**Goal:** prove end-to-end generation path works.

### Slices
- S8.1 Run a controlled dry run generating a subset of final docs.
- S8.2 Verify generated docs meet style/vocabulary/traceability rules.
- S8.3 Record defects and feed back into slices M3–M7.
- S8.4 Repeat until dry run passes defined threshold.

### Exit criteria
- Dry-run output accepted by checklist and consistency matrix.

---

## M9 — Release handoff and operationalization
**Goal:** make program resumable and operational for ongoing sessions.

### Slices
- S9.1 Update `dev/implementation/PROGRESS_BOARD.md` with milestone/slice statuses.
- S9.2 Update `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` with exact resume instructions.
- S9.3 Publish next-session queue (top 3 slices + blockers).
- S9.4 Archive decision/conflict deltas for auditability.

### Exit criteria
- Next session can resume deterministically within one startup pass.

---

## Slice execution protocol (mandatory each session)
1. Select 1–3 adjacent slices.
2. Execute with traceability updates as you go.
3. Update conflict/open-question/decision registers as needed.
4. Update progress board and latest handoff.
5. Commit with message format:
   - `docs(seed-gen): Mx Sy.y <short action>`

## Definition of done for a slice
- Required files updated, with any newly created authored/generated docs placed under `/fresh`.
- No placeholder-only completion claims.
- Traceability and continuity artifacts updated.
- Blockers explicitly logged if incomplete.
