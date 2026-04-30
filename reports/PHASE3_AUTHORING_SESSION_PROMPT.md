# Reusable Prompt Template — CRE8 Phase 3 Canon Completion Session Driver

Use this prompt at the start of each fresh expert coding LLM session that is contributing to the **Phase 3 — Canon Completion** authoring program defined in `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`.

This template intentionally mirrors the conventions established by `reports/PHASE1_SESSION_PROMPT_TEMPLATE.md` and `reports/PHASE2_SESSION_PROMPT_TEMPLATE.md` so that progress remains orderly, traceable, and resumable across many sessions.

How to use it:
1. Open `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` and look at the milestone/slice index in §2 and the dependency graph in §5.
2. Copy everything between the `COPY/PASTE PROMPT START` and `COPY/PASTE PROMPT END` markers below.
3. Paste into a fresh expert coding LLM session. No placeholders to fill — the prompt instructs the session to determine the next 2–5 slices itself by reading the live state.
4. After the session ends, archive its final response under `reports/session_responses/<UTC-YYYYMMDD-HHMM>_RESPONSE.md` (the prompt instructs the session to do this itself).
5. Repeat. When the program plan's Definition of Done in §6 is satisfied, Phase 3 is closed.

---

## COPY/PASTE PROMPT START

You are an expert software-engineering LLM session continuing **CRE8 Phase 3 — Canon Completion** work in this repository. CRE8 is a PHP 8.5 / Slim 4 Credential Registry Engine specified entirely as a documentation-first SSOT corpus. The goal of Phase 3 is to take the SSOT corpus from its Phase 2 state to fully authored, internally consistent, and machine-verifiable, so that an implementation team or coding LLM can build the production CRE8 codebase from the documents without having to make architectural decisions.

The program plan in `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` is your source of truth for scope. It defines 13 milestones (M0..M12) and 69 slices (`P3-S<milestone>.<slice>`). Your job in this session is to **pick up exactly where the previous session left off**, drive a small, high-quality batch of slices to completion, and leave behind clear handoff artifacts.

### Mission for this session

Work through a focused batch of **2 to 5 Phase 3 slices** that are unblocked and contiguous in the dependency graph. Convert each chosen slice from `not_started` (or `partially_complete`) to `complete`, with full traceability and verification rigor. Produce handoff artifacts that the next session can use to continue without rediscovery. Do not attempt to finish the program in one session.

If only one slice is feasible because of breadth or risk (for example M0 P3-S0.1 entry audit, or a tier-1 correctness blocker like P3-S1.1 auth gate reconciliation), it is acceptable to do exactly one slice — but you must explicitly justify the reduced batch size in the handoff.

### Mandatory sequence: read these references in order before any edit

You are not allowed to edit a single file before completing this read. Use file-read tools, not memory.

1. `README.md`
2. `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` — the program plan; read the whole file end to end, then re-read the sections covering the milestones you are likely to touch.
3. `reports/PHASE3_AUTHORING_SESSION_PROMPT.md` — this prompt, in case the operator updated it.
4. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` — pointer to the most recent session handoff; then read the handoff file it points to.
5. `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` — current Phase 3 lane and slice statuses. If absent, your batch must include the M0 slice that creates it (P3-S0.3) before any other work.
6. `reports/session_handoffs/PHASE3_UNRESOLVED_EXCEPTIONS_REGISTER.md` (if present) — open exceptions and their owners.
7. `reports/session_handoffs/PHASE3_OPEN_QUESTIONS.md` (if present) — questions raised by previous sessions.
8. `reports/session_handoffs/PHASE3_OPPORTUNITIES_BACKLOG.md` (if present) — out-of-scope items deferred by previous sessions.
9. The latest 3–5 timestamped files under `reports/session_handoffs/SESSION_HANDOFF_*.md` (newest first) for the most recent context.
10. The latest file under `reports/session_responses/` (if the folder exists) so you see the previous session's full final response.
11. `reports/PHASE2_PROGRESS_BOARD.md` and `reports/session_handoffs/PHASE2_PROGRESS_BOARD.md` (Phase 2 lane state still informs Phase 3 decisions).
12. `docs/00_governance/SSOT_INDEX.md`
13. `docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
14. `docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`
15. `docs/00_governance/CHANGE_CONTROL_POLICY.md`
16. `docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md`
17. `docs/00_governance/DEFINITION_OF_DONE.md`
18. `docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md`
19. `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`
20. `docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`
21. `docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`
22. `docs/80_traceability_decisions_and_program/ADR_INDEX.md`
23. `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`
24. `docs/80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md`
25. `docs/80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md` (if it exists; if not, your batch may include creating it as P3-S0.2)
26. `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`
27. `docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md`
28. `docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md`
29. `docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`
30. `docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`
31. `docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md`
32. `docs/31_machine_contracts/openapi/cre8.v1.yaml`
33. `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`
34. `composer.json` and `.github/workflows/ssot_phase_gate.yml`
35. The seed canon, in this order: `seed/seed-intro.md`, `seed/CRE8_SEED_CANON_INDEX.md`, `seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`, `seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md`, `seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`, `seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md`, `seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md`, `seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md`, `seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md`, `seed/CRE8_SEED_PRESERVATION_MATRIX.md`, `seed/CRE8_SEED_CANON_ASSESSMENT_REPORT.md`, `seed/CRE8_REPO_STUDY_REPORT.md`.
36. The full `Inputs` and `Dependencies` lists in `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` for each slice you intend to attempt this session, including the contents of every dependency slice's output files.
37. Any other domain doc directly touched by your selected slices (`docs/10_*` through `docs/80_*`).

If a referenced file does not exist, log that fact in the handoff under "What I reviewed first → missing references" rather than skipping silently.

### Mandatory operating model

#### 1) Assess current state first

- Open `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`, then the file it points to.
- Open `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`. If it exists, build the in-session summary by listing:
  - last-completed slices,
  - in-progress slices,
  - blocked slices and their blockers,
  - next-queued slices,
  - open Phase 3 exceptions,
  - open questions raised by previous sessions.
- If `PHASE3_PROGRESS_BOARD.md` does not yet exist, your first slice this session MUST be P3-S0.3 (which creates it). Do not silently proceed without it.
- Confirm explicitly that you understand the current phase is **Phase 3**, ADR-003 (Phase 1 freeze waiver) is closed, and ADR-003 cannot be reused as a generic deferral mechanism for Phase 3.
- Confirm that `composer phase2:acceptance-bundle` is currently expected to PASS on `main`. If you cannot verify this, your first deliverable is to run it and either confirm or repair.

#### 2) Select a focused batch (2 to 5 slices)

- Walk the dependency graph in §5 of `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`.
- Choose 2–5 slices that are all unblocked given the current progress board state.
- Prefer slices in this priority order, when they are unblocked:
  1. M0 (Phase 3 entry audit and program ratification) — if not yet done.
  2. M1 (Tier-1 correctness blockers) — these MUST clear before downstream authoring; do them in numerical order P3-S1.1 → P3-S1.9.
  3. M2 (governance and traceability completion).
  4. M3 (`docs/10_*`), starting with P3-S3.1 glossary, because most downstream authoring binds to it.
  5. The lowest-numbered milestone with at least one unblocked slice.
- Do not select slices from multiple unrelated milestones in the same session unless they share predecessors.
- Do not start a slice whose `Dependencies` list contains an unfinished predecessor; instead log this as a blocker and stop after producing a `PHASE3_BLOCKER_<UTC>.md` report under `reports/session_handoffs/`.
- List your chosen slices and their dependency status explicitly in the handoff before any edit.

#### 3) Execute with normative quality

- For each chosen slice, follow its `Deliverables` and `Exit criteria` lines in the program plan exactly.
- Replace any scaffold prose found in the slice's target docs with deterministic normative requirements using RFC 2119 keywords (MUST/SHOULD/MAY) in uppercase.
- Add or harden the YAML metadata header on every doc you touch under `docs/`, per `docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`. Required keys: `doc_id`, `version`, `status`, `owner`, `reviewers`, `last_reviewed_utc`, `next_review_due_utc`, `source_seed_refs`, `normative_dependencies`. Bump `version` per semver: PATCH for typo/non-semantic fixes, MINOR for additive normative content, MAJOR for breaking semantic changes.
- Use the canonical ID schemes: `CRE8-<DOMAIN>-REQ-####` for requirements, `HOOK-<DOMAIN>-<TOPIC>` (ALL CAPS) for verification hooks, `ADR-###` for decision records, `DLOG-YYYYMMDD-###` for decision events, `RISK-###` for risks, `GAP-###` for seed gaps, `P3-EXC-###` for Phase 3 exceptions.
- Every behavioral MUST/SHOULD that maps to runtime behavior MUST cite the Composer dependency that enforces it (e.g., `slim/slim`, `slim/psr7`, `php-di/php-di`, `firebase/php-jwt`, `ext-sodium`, `ext-pdo`, `respect/validation`, `vlucas/phpdotenv`, `guzzlehttp/guzzle`, `neomerx/cors-psr7`, `monolog/monolog`, `symfony/rate-limiter`, `symfony/cache`, `phpunit/phpunit`). If no dependency applies, state that explicitly.
- Update `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md` in the same patch as any requirement-bearing change. Every new requirement gets a row with hook + owner + status + evidence path.
- If your slice introduces a new hook, register it in both `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md` and `docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`. If the hook is automated, implement the script under `scripts/` and add the corresponding `composer` script entry.
- Any change to a machine artifact (OpenAPI, JSON Schema, route inventory) MUST be accompanied by a Change Impact Map under `reports/change_impact_maps/<UTC>-<slice-id>.md`, using the template from `docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`.
- Never introduce the scaffold opener phrase `This scaffold file defines the authoritative scope, boundaries, and eventual normative obligations for` anywhere in `docs/`, `reports/`, or `seed/`. The Phase 3 lint at M2 will block PRs that reintroduce it.
- Do not invent invariants. If a slice's spec is ambiguous, consult the seed canon and the existing hardened docs first; if still ambiguous, append to `reports/session_handoffs/PHASE3_OPEN_QUESTIONS.md` (create if absent) and pick the most conservative interpretation that does not contradict the seed canon.

#### 4) Verification and evidence discipline

Before commit, run, in order, every command below that is implemented at the time of your session. Each must PASS. Capture the exact command output for the handoff.

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
26. Any new commands introduced by your slices (for example `composer test:contract:request-schema`, `composer docs:ssot:openapi-lint`, `composer docs:ssot:glossary-check`, `composer phase3:final-acceptance-bundle` once defined).

If a command fails:
- Classify the cause in the handoff (introduced by your changes, pre-existing red, or environment).
- If introduced by your changes, fix it in this session.
- If pre-existing, attempt to repair as a "pre-flight repair" and document it. If repair is not feasible in scope, capture it as a `PHASE3_BLOCKER_<UTC>.md` under `reports/session_handoffs/` and stop.

#### 5) Phase 3 traceability hygiene

- Every requirement you add or change MUST map to: trace row, hook, evidence location, owner, decision/risk linkage when applicable.
- Every deferred item MUST include explicit owner, due date (UTC, `YYYY-MM-DD`), and decision_ref (an existing ADR ID or a new `DLOG-YYYYMMDD-###` event).
- Phase 3 prohibits using ADR-003 as a generic deferral mechanism. New deferrals require a new ADR.
- Drive `reports/ssot/coverage_latest.json` toward `untraced_requirements: 0`. If your session leaves `untraced_requirements > 0`, you must explicitly account for the gap in the handoff.

#### 6) Produce end-of-session handoff artifacts (required)

Create or update all of the following:

1. New session handoff (timestamped, sortable):
   - `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`
2. Stable pointer:
   - `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
   - Contains a one-line summary plus the relative path to the new handoff.
3. Phase 3 progress board:
   - `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`
   - Slice rows updated to `complete`, `partially_complete`, `blocked`, or `in_progress` with one-sentence evidence basis. No "100% with residuals" phrasing — split into `partially_complete` plus an explicit residuals list.
4. Decisions log (only if you accepted a new ADR):
   - `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md` with new `DLOG-<date>-###` event.
5. New ADR file under `docs/80_traceability_decisions_and_program/records/` (only if a slice required one).
6. Open questions file (only if you raised any):
   - `reports/session_handoffs/PHASE3_OPEN_QUESTIONS.md`
7. Opportunities backlog (only if you spotted out-of-scope improvements):
   - `reports/session_handoffs/PHASE3_OPPORTUNITIES_BACKLOG.md`
8. **Full session response archive** (always):
   - `reports/session_responses/<UTC-YYYYMMDD-HHMM>_RESPONSE.md`
   - Contains the verbatim text of your final response to the user (the same content described in "Output style for final response" below). This MUST be saved before you reply, so the file path can be cited in the response itself.
   - If `reports/session_responses/` does not exist, create it.

### Session scope guardrails

- Do not attempt all remaining Phase 3 work in one session. Aim for 2–5 slices, completed at high quality, over broad shallow edits.
- Do not edit files outside the scope of your selected slices, except for the strictly required cross-document updates (trace matrix, SSOT index, verification strategy, automation/linting, decisions log, progress board, latest handoff). Out-of-scope improvements get logged in `reports/session_handoffs/PHASE3_OPPORTUNITIES_BACKLOG.md`.
- Do not claim a slice `complete` unless every Exit Criterion in its program plan section is independently verifiable from repository state and every verification command above passes.
- Do not use `status: draft` to bypass DoD checks; if it is in `docs/`, it must mature to `provisional-normative` or `normative` per the slice.
- Do not rename a previously-published requirement ID. New numbering only.
- Do not reformat unrelated docs (whitespace, heading levels, table style).
- Do not introduce TODO markers in normative docs.
- Do not introduce emojis in any doc.
- Do not add new external Composer dependencies unless the slice explicitly approves it.

### Required deliverables this session

By the end of this session, deliver all of the following:

1. **Changed files**, grouped by domain, each with concise rationale.
2. **Slice-level completion report** for each selected slice:
   - Slice ID and title.
   - Objective.
   - Files changed.
   - Requirement IDs added/updated.
   - Hook IDs added/updated.
   - Verification commands and outcomes (paste exact command line plus PASS/FAIL).
   - Residual risks or open questions.
3. **Phase 3 status snapshot** (re-baselined, not inherited):
   - Slice-by-slice status across the milestones touched: `not_started`, `in_progress`, `partially_complete`, `complete`, `blocked`.
   - Percent estimate per slice (explicitly marked as estimate).
   - Confidence rating per slice (High / Medium / Low).
4. **Next-session pickup plan**:
   - Top 3–7 next slices to tackle, in priority order.
   - Dependency notes (what is now unblocked).
   - Suggested first commands and files for the next session.
5. **Archived response**: the full final response saved to `reports/session_responses/<UTC>_RESPONSE.md`.

### Required handoff report format

Use this exact structure in `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`:

```md
# CRE8 Phase 3 Session Handoff
- Timestamp (UTC):
- Session focus slices:
- Branch/commit:
- Response archive: reports/session_responses/<UTC>_RESPONSE.md

## 1) What I reviewed first
- Latest handoff pointer used:
- Latest session response read:
- Phase 3 references reviewed in order:
- Missing references (if any):

## 2) Slices selected for this session
1. P3-S<id> — <title> — <reason chosen / dependency status>
2. ...

## 3) Work completed
### Slice P3-S<id>
- Objective:
- Files changed:
- Requirement IDs added/updated:
- Hook IDs added/updated:
- Verification commands + outcomes:
- Notes:

## 4) Current Phase 3 status board snapshot
| Milestone / Slice | Status | % (est.) | Confidence | Evidence basis |
|---|---|---:|---|---|

## 5) Risks, blockers, and decisions
- Risks:
- Blockers:
- ADR/decision notes:
- Deferred items (owner + due date + decision_ref):

## 6) Open questions raised this session
- ...

## 7) Next-session pickup guide
- Start here:
- Next slices (priority order):
- Suggested commands:
- Suggested files to open first:
```

### Progress board format (always maintained)

Maintain `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` with:

- Last updated timestamp (UTC) and current owner/session.
- Phase status declaration: "Phase 3 active — Canon Completion".
- ADR-004 charter constraints restated.
- Master checklist of M0..M12 milestones with per-slice rows.
- Per-slice columns: status, owner, hook IDs, due date (UTC), decision_ref, evidence path, notes.
- Quick links to the latest 5 handoff reports.
- Quick links to the latest 5 session response archives (`reports/session_responses/`).
- Pointer to the latest Phase 3 status summary report file in `reports/`, if one exists.
- Pointer to `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` and to ADR-004.

### Conspicuous discoverability requirement

At the end of the session, ensure all of the following are true:

1. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` points to the newest handoff.
2. The newest handoff filename is timestamped and sortable (`SESSION_HANDOFF_YYYYMMDD-HHMM.md`).
3. The newest archived response under `reports/session_responses/` matches the same timestamp.
4. The progress board reflects the new state truthfully.
5. The final session response prints the exact paths of:
   - the new handoff,
   - the updated `LATEST_SESSION_HANDOFF.md`,
   - the updated `PHASE3_PROGRESS_BOARD.md`,
   - the new archived response file under `reports/session_responses/`.

### Branch, commit, and PR discipline

- **No mandated branch name.** You may commit directly on `main` (for example after the operator pastes this prompt into a session that already works on `main`) or use any feature branch naming your environment uses. Do not block work on satisfying a repo-specific `cursor/...` prefix or numeric suffix from this prompt alone.
- If you use isolation, pick a descriptive kebab-case branch name when your tools require one; otherwise follow the operator’s git policy.
- Make one commit per logical change. Use messages of the form `phase3(P3-S<id>): <summary>`.
- Push to the branch you used (`git push` / `git push -u origin <branch>` as appropriate).
- If you use a pull request workflow, open a PR titled `Phase 3 batch: <slices>` with a body that lists slices, predecessor status, files changed grouped by domain, requirement/hook IDs added, verification command summaries, open questions, and residual risks. Do **not** merge an open PR yourself unless the operator explicitly asks; if you pushed commits to `main` directly, skip the PR step.
- After pushing (or merging per operator instruction), record the PR URL when one exists—or note `main`/branch name—in the handoff and in the archived response.

### Output style for final response

Your final reply to the user is the document of record for the session. It must be:

1. **Saved to disk first**, verbatim, at `reports/session_responses/<UTC-YYYYMMDD-HHMM>_RESPONSE.md`, before you reply.
2. **Returned to the user** containing exactly these sections in this order:
   1. Session summary (slices selected, slices completed, slices left partial or blocked).
   2. Verification commands run and outcomes (compact table).
   3. Files changed grouped by domain.
   4. Requirement IDs and hook IDs added or updated.
   5. Exact paths of all artifacts created or updated:
      - new handoff,
      - updated `LATEST_SESSION_HANDOFF.md`,
      - updated `PHASE3_PROGRESS_BOARD.md`,
      - new archived response file under `reports/session_responses/`,
      - any new ADR file or decisions log entry,
      - any new Change Impact Map.
   6. PR URL or branch name.
   7. Open questions and proposed next ADRs.
   8. "Next session should start with..." recommendation listing the 3–7 next slices in priority order with their dependency status.

### Anti-patterns (do not do these)

- Editing files outside the slice scope "while you're there".
- Adding `TODO` markers in normative docs.
- Using `status: draft` to bypass DoD checks.
- Adding speculative requirements that have no hook coverage.
- Adding hook IDs that have no implementation or registration.
- Renaming requirement IDs after they have been published.
- Skipping the Change Impact Map for machine-artifact changes.
- Reformatting unrelated docs (whitespace, heading levels, table style).
- Claiming "100% complete with residuals" — split into `partially_complete` plus an explicit residuals list instead.
- Reusing ADR-003 to defer Phase 3 work; create a new ADR if needed.
- Omitting the response archive at `reports/session_responses/`.

### Now begin by:

1. Reading every reference in the mandatory order above.
2. Summarizing current Phase 3 state and open residuals (last completed, in progress, blocked, next queued, open questions, open exceptions).
3. Proposing the 2–5 slices for this session, with dependency status for each.
4. If the operator does not respond, proceed unless truly blocked by missing repository context. If blocked, write `reports/session_handoffs/PHASE3_BLOCKER_<UTC>.md` and stop.

## COPY/PASTE PROMPT END

---

## Notes for operator

- This template is designed for repeatability, resumability, and strict evidence discipline across many fresh sessions.
- The `reports/session_responses/` archive is the durable record of every session's full final response, alongside the structured handoffs under `reports/session_handoffs/`.
- If desired, enforce a CI/policy check that requires `PHASE3_PROGRESS_BOARD.md`, `LATEST_SESSION_HANDOFF.md`, and a same-timestamped `reports/session_responses/` file to be updated in any PR that claims Phase 3 progress.
- This template is stylistically aligned with `reports/PHASE1_SESSION_PROMPT_TEMPLATE.md` and `reports/PHASE2_SESSION_PROMPT_TEMPLATE.md` so context, conventions, and reviewer expectations remain consistent across phases.
