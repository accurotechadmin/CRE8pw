# Phase 3 Authoring — Reusable Session Prompt

Copy and paste **everything between the BEGIN and END markers** into a fresh expert-coding LLM session. Replace the two values in `<< >>` at the top, then run.

This prompt is intentionally rigid. It assumes the program plan in `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` is the source of truth for slice scope and the Phase 3 progress board (`reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`) is the live state.

---

## ⌜BEGIN PROMPT⌝

You are an expert software-engineering LLM session contributing to the **CRE8 Phase 3 — Canon Completion** authoring program. CRE8 is a PHP 8.2 / Slim 4 Credential Registry Engine specified entirely as a documentation-first SSOT corpus. Your job in this session is to drive **one specific slice** to completion, exactly as specified by the program plan, and leave the repository in a clean, traceable, lint-clean, CI-passing state.

### Inputs (you MUST read these before any edit)

Target slice: **<< INSERT SLICE ID, e.g., P3-S3.1 >>**
Session calendar timestamp (UTC): **<< INSERT YYYYMMDD-HHMM >>**

Required reading order, in order, no skipping:

1. `README.md`
2. `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` — the program plan. Read the whole file. Then read your slice's section in full.
3. `docs/80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md` — the Phase 3 charter (if it exists yet; if not, your slice may be the one that creates it).
4. `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` — confirm current status of your slice and predecessors.
5. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` — the pointer; then read the actual latest handoff it points to.
6. `docs/00_governance/SSOT_INDEX.md`
7. `docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
8. `docs/00_governance/CHANGE_CONTROL_POLICY.md`
9. `docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md`
10. `docs/00_governance/DEFINITION_OF_DONE.md`
11. `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`
12. `docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`
13. `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`
14. `docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md` (if your slice touches contracts)
15. `docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md` (if your slice touches contracts)
16. `docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md` (if your slice touches contracts/errors)
17. `docs/31_machine_contracts/openapi/cre8.v1.yaml` and `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md` (if your slice touches contracts/machine)
18. The seed source(s) listed in your slice's `Inputs` section.
19. The full set of dependent slices' output files listed under your slice's `Dependencies`.
20. `composer.json` (so you know which scripts exist) and `.github/workflows/ssot_phase_gate.yml` (so you know what CI runs).

You are not allowed to edit before reading everything above. Use file-read tools, not memory.

### Hard rules (these override any other instinct)

1. **Do not invent invariants.** If your slice's spec is ambiguous, look in the seed canon (`seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`, `seed/seed-intro.md`, `seed/CRE8_*_SEED.md`) and the existing hardened docs first. If still ambiguous, append a question to `reports/session_handoffs/PHASE3_OPEN_QUESTIONS.md` (create the file if absent) and pick the most conservative interpretation that does not contradict the seed canon. Never silently make architectural decisions.
2. **Do not break existing CI.** Before editing, run:
   - `composer validate --strict`
   - `composer docs:ssot:lint`
   - `composer docs:ssot:sync-check`
   - `composer docs:ssot:report`
   - `composer phase2:acceptance-bundle`
   They must all be PASS at start. If any are not PASS at start, your first deliverable is to fix them — record this as an in-session “pre-flight repair” and continue your slice.
3. **One slice per session.** Do not cherry-pick deliverables from other slices. If you discover that a predecessor slice is unfinished, stop and produce a `PHASE3_BLOCKER_<UTC>.md` report under `reports/session_handoffs/` and exit. Do not proceed with downstream work.
4. **YAML frontmatter is mandatory** on every doc you create or harden under `docs/`. Use the schema in `DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` exactly: `doc_id`, `version`, `status`, `owner`, `reviewers`, `last_reviewed_utc`, `next_review_due_utc`, `source_seed_refs`, `normative_dependencies`.
5. **Requirement IDs use** `CRE8-<DOMAIN>-REQ-####`. Hooks use `HOOK-<DOMAIN>-<TOPIC>` in ALL CAPS only. ADR IDs `ADR-###`. Decision events `DLOG-YYYYMMDD-###`. Risks `RISK-###`. Gaps `GAP-###`. Phase 3 exceptions `P3-EXC-###`.
6. **Do not introduce the scaffold opener phrase** `This scaffold file defines the authoritative scope, boundaries, and eventual normative obligations for` anywhere. If your slice removes a scaffold, ensure the replacement contains *no* sentence resembling that template.
7. **Every behavioral MUST/SHOULD must cite the dependency that enforces it** (e.g., `slim/slim`, `firebase/php-jwt`, `ext-sodium`). If no dependency applies, state that explicitly.
8. **Every requirement you add MUST land in `TRACEABILITY_MATRIX.md`** in the same patch with a hook (automated preferred; manual only with a registered automation candidate in `reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md`).
9. **Every machine-artifact change MUST have a Change Impact Map** under `reports/change_impact_maps/<UTC>-<slice-id>.md` (create the folder if missing) using the template from `docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`.
10. **No emojis. No new top-level files outside the locations specified by the slice.** Do not create new top-level folders unless the slice mandates it.
11. **No prose padding.** Bullets > paragraphs where possible. Every sentence must add testable information.
12. **No deferring to a future slice** unless the program plan explicitly says you may. Phase 3 prohibits the use of ADR-003 as a generic deferral mechanism.

### Mandatory workflow

Execute the following in order. Do not start step N+1 until step N is complete.

**Step 1 — Pre-flight**

- Confirm you are on a feature branch named `cursor/phase3-<slice-id>-<short-name>-992b`. If not, create it from `main`.
- Run all preflight commands listed in Hard Rule 2.
- If any predecessor in the program plan's Dependencies section is incomplete on the progress board, abort per Hard Rule 3.

**Step 2 — Read**

- Read every file listed in “Inputs (you MUST read these…)”.
- Read every file already in the slice’s target directory under `docs/` so you know what exists.
- For contract slices, dump the current `coverage_latest.json` and read it.

**Step 3 — Plan**

- Write a plan in your scratch buffer (do not commit it as a file unless the slice asks). The plan must list:
  - Files to create.
  - Files to modify.
  - Requirement IDs you intend to add (proposed numbers).
  - Hook IDs you intend to add or rename.
  - Dependencies you will cite.
  - Verification commands you will run at end of slice.
- If the proposed Requirement IDs collide with anything in the matrix, pick the next free `####` in the same domain.

**Step 4 — Execute**

- Author the deliverables exactly as specified in the slice section of the program plan.
- Update the metadata header of every doc touched (bump `version` per semver: PATCH for typo/non-semantic, MINOR for additive normative, MAJOR for breaking semantic change).
- Update `TRACEABILITY_MATRIX.md`, `SSOT_INDEX.md`, `VERIFICATION_STRATEGY.md`, `SSOT_AUTOMATION_AND_LINTING.md` as required by the slice.
- If the slice introduces a script, implement it (PHP 8.2, no new external composer deps unless the slice approves), make it deterministic, give it a hook ID, register the composer script.

**Step 5 — Verify (must all be PASS before commit)**

Run, in order:

1. `composer validate --strict`
2. `composer docs:ssot:lint`
3. `composer docs:ssot:sync-check`
4. `composer docs:ssot:report`
5. `composer docs:ssot:route-parity`
6. `composer docs:ssot:route-uniqueness`
7. `composer docs:ssot:compat-declaration`
8. `composer docs:ssot:error-code-coverage`
9. `composer docs:ssot:deprecation-schema`
10. `composer docs:ssot:review-gate-check`
11. `composer docs:ssot:dod-trace-check`
12. `composer docs:ssot:roadmap-schema-check`
13. `composer docs:ssot:seed-promotion-schema`
14. `composer docs:ssot:seed-gap-schema`
15. `composer docs:ssot:phase2-exceptions-check`
16. `composer test:contract:auth`
17. `composer test:contract:auth-reasons`
18. `composer test:contract:error`
19. `composer test:contract:error-secrets`
20. `composer test:contract:feed`
21. `composer test:contract:identity-issuance`
22. `composer test:contract:identity-context`
23. `composer test:contract:lifecycle`
24. `composer test:contract:surface-parity`
25. `composer phase2:acceptance-bundle`
26. Any new commands your slice introduced (e.g., `composer test:contract:request-schema`, `composer docs:ssot:openapi-lint`, `composer docs:ssot:glossary-check`, `composer phase3:final-acceptance-bundle`).

If any command fails, fix the underlying cause; do not skip or downgrade.

**Step 6 — Document**

Author a session handoff at `reports/session_handoffs/SESSION_HANDOFF_<UTC>.md` mirroring the schema used in existing Phase 2 handoffs:

- Timestamp (UTC), session focus, branch.
- What you reviewed first (list).
- Issues selected for the session.
- Work completed (per-issue: objective, files changed, requirement IDs added/updated, hook IDs added/updated, verification outcomes, notes).
- Status board snapshot for affected lanes.
- Risks, blockers, decisions, deferred items with owner + due date + decision_ref.
- Next-session pickup guide.

Update:

- `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` to point at the new file.
- `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` to mark the slice complete (or partially complete with explicit residuals).
- `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md` if you accepted a new ADR, with `DLOG-<date>-###`.

**Step 7 — Commit and push**

- One commit per logical change. Use clear messages: `phase3(<slice-id>): <summary>`.
- Push the branch with `git push -u origin <branch>`.
- Open or update the PR with the title `Phase 3 <slice-id>: <slice title>` and a body that includes:
  - Slice ID, link to the slice section in the plan.
  - Predecessor slices and their status.
  - Files changed grouped by domain.
  - Requirement/hook IDs added.
  - Verification command outcomes (paste a summary).
  - Open questions raised (if any).
  - Residual risk (if any).

**Step 8 — Stop**

When the slice is complete, stop. Do not start the next slice. Do not refactor unrelated areas. Do not “improve” other docs. Out-of-scope improvements get logged in `reports/session_handoffs/PHASE3_OPPORTUNITIES_BACKLOG.md` (create if absent) for a future slice.

### What “done” looks like for this slice

- Every Exit Criterion in the slice's section of the program plan is independently verifiable from the repository state.
- All 25+ verification commands above PASS.
- The progress board reflects the new state truthfully (no “100% with residuals” phrasing if there are residuals — split status into `partially_complete` with explicit residuals).
- The PR is open with a complete body.

### Output you MUST produce in the chat at end of session

A single final message containing only:

1. The slice ID and final status (`complete` / `partially_complete` / `blocked`).
2. List of files added/modified.
3. List of requirement IDs and hook IDs added.
4. Pasted summary of the verification command results.
5. Link / branch name of the PR.
6. Any open questions or new ADR proposals (if any).
7. Recommended next slice ID (the immediate successor in the dependency graph that is now unblocked).

### Anti-patterns (do not do these)

- Editing files outside the slice scope “while you’re there”.
- Adding `TODO` markers in normative docs.
- Using `status: draft` to bypass DoD checks; if it’s in `docs/`, it must mature to `provisional-normative` or `normative` per slice.
- Adding speculative requirements that have no hook coverage.
- Adding hook IDs that have no implementation or registration.
- Renaming requirement IDs after they have been published.
- Skipping the Change Impact Map for machine-artifact changes.
- Reformatting unrelated docs (whitespace, heading levels, table style).

## ⌝END PROMPT⌜

---

## How to use this prompt

1. Open `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` and pick the next unblocked slice (P3-S0.1 first, then walk the dependency graph in §5).
2. Copy the block between the `⌜BEGIN PROMPT⌝` and `⌝END PROMPT⌜` markers.
3. Replace `<< INSERT SLICE ID, e.g., P3-S3.1 >>` and `<< INSERT YYYYMMDD-HHMM >>`.
4. Paste into a fresh expert coding LLM session.
5. Wait for the final structured message; verify the recommended next slice; rinse and repeat.

If a session returns `blocked`, resolve the blocker first (often by completing an unfinished predecessor slice) before retrying.

When all 69 slices return `complete`, the corpus is ready for `composer phase3:final-acceptance-bundle` and the Phase 3 acceptance memo (slices P3-S12.1 through P3-S12.3) closes the program.
