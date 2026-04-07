# NEXT PROMPT — CRE8 SSOT-Driven Development Continuation (Reusable + Session-Aware)

_Status: draft_
_Last updated (UTC): 2026-04-06_

Copy/paste everything below into a fresh expert coding LLM session.

---

You are continuing development of the CRE8 platform from a prior session.

## Mission
Pick up where the last session ended and execute the next highest-priority **unfinished** SSOT-aligned work to move CRE8 toward production readiness. Use existing implementation as reference, not authority.

## Non-negotiable operating rules
1. Treat **all docs in `/docs/SSOT` as immutable SSOT requirements** for this session.
   - If implementation conflicts with SSOT, SSOT wins.
   - Do not modify SSOT requirement semantics unless explicitly requested by the human.
2. Keep stack and architecture constraints:
   - PHP 8.2, Slim 4, PHP-DI, PDO (MySQL/MariaDB), JWT, PHPUnit.
   - Modular monolith + contract-first + policy-first domain logic.
   - Thin handlers; use-cases/policies hold behavior.
   - Domain layer must remain framework-agnostic.
3. Any route/API behavior change must update all affected artifacts in the same change set:
   - runtime route registration,
   - `docs/SSOT/openapi/cre8.v1.yaml`,
   - `docs/SSOT/Route_Inventory_Reference.md`,
   - route examples and relevant test contracts.
4. Do not add fake business logic or speculative behavior.
5. Prefer smallest vertical slices that fully close the loop: **route + use-case/policy + tests + docs sync**.

## Required initial reading order (always do first)
1. `/docs/SSOT/SSOT_INDEX.md`
2. `/docs/SSOT/CRE8_Spec.md`
3. `/docs/SSOT/Architecture_Reference.md`
4. `/docs/SSOT/Dependency_Reference.md`
5. `/docs/SSOT/Request_Pipeline_Reference.md`
6. `/docs/SSOT/Route_Inventory_Reference.md`
7. `/docs/SSOT/API_Contract_Guide.md`
8. `/docs/SSOT/openapi/cre8.v1.yaml`
9. `/docs/SSOT/SSOT_Automation_and_Linting.md`
10. `/docs/SSOT/HYBRID_REBUILD_ROADMAP_1_2_3.md`
11. `/docs/SSOT/REBUILD_STRATEGY_OPTIONS_FOR_CRE8.md`
12. `/docs/SSOT/SSOT_CODEBASE_ALIGNMENT_ASSESSMENT_2026-04-06.md`
13. `/docs/SSOT/scaffold_stubs.json`

## Mandatory context bootstrap (state-aware)
Before choosing work, read these handoff files and use them as the first source of truth for “what remains”:
- `/docs/SSOT/session_handoff/LATEST_STATUS.md`
- newest `/docs/SSOT/session_handoff/SESSION_LOG_*.md`
- `/docs/SSOT/NEXT_PROMPT.md`

If any listed “next task” is already complete in code, do **not** redo it; pick the next unfinished item and record the correction in the new session log.

## Current project state snapshot (seed context)
- Branch: `work`
- Implemented in `/code`:
  - `GET /` vertical slice (service status envelope).
  - `GET /health` vertical slice.
  - `POST /api/auth/login` vertical slice with thin handler + use-case + policy routing.
  - `POST /api/auth/key-login` vertical slice with thin handler + use-case + policy routing.
  - Login and key-login contract/security tests authored.
- SSOT automation status:
  - `code/scripts/ssot/lint.php` ✅ passing
  - `code/scripts/ssot/sync_check.php` ✅ passing
  - `code/scripts/ssot/report.php` ✅ passing
  - CI workflow: `.github/workflows/ssot-automation.yml`
- Remaining blocker:
  - `composer install` in `/code` cannot reach Packagist in this environment (`CONNECT tunnel failed, response 403`).

## Session start protocol (mandatory)
1. **State scan**
   - Print `git status` and recent `git log`.
   - Identify what was completed in previous session and what remains.
   - Confirm scaffold integrity against `scaffold_stubs.json` before any edits.
2. **Drift check (lightweight first pass)**
   - Detect likely SSOT/code drift for the area you intend to modify.
   - List exact SSOT artifacts that must be synchronized in this session.
3. **Plan**
   - Produce a short execution plan with smallest reviewable increments.
   - Prefer vertical slices (route + use-case + policy + tests + docs sync).
4. **Execute**
   - Make minimal, coherent changes.
   - Run targeted tests/checks after each increment.
   - If blocked, stop early, record blocker, and propose smallest unblocking step.

## Priority queue (apply in order, skipping completed items)
1. Unblock `/code` dependency installation and execute `composer test`; capture blocker/root cause if still failing.
2. Deliver next missing SSOT-priority runtime slice with full synchronization.
3. Produce/update explicit gap report versus SSOT priority artifacts.

## Working tree focus
- Implement rebuild slices under `/code` unless the human explicitly asks to change legacy runtime under `/src`.
- Keep `/docs/SSOT` requirement docs immutable; update only synchronization artifacts or explicit handoff docs requested by the human.

## Development guardrails
- Keep interfaces explicit (contracts/value objects) and side effects isolated.
- Avoid hidden coupling between modules.
- New dependency additions must be justified against `Dependency_Reference.md`.
- Do not leave partially wired routes without tests or documented follow-up.
- Prefer failing-closed behavior for startup/auth/security paths.
- Use deterministic timestamps/IDs in tests where possible.

## Required per-session records and handoff artifacts
At the end of **every** coding session, produce/update the following under `/docs/SSOT/session_handoff/`:
1. `SESSION_LOG_<UTC_ISO>.md` (new file per session)
2. `LATEST_STATUS.md` (overwrite with newest canonical snapshot)
3. `NEXT_PROMPT.md` in `/docs/SSOT/` (update this file for the next run; keep copy-ready)

If the folder does not exist, create it.

### Required structure for `SESSION_LOG_<UTC_ISO>.md`
- Session metadata (UTC start/end, branch, commit range)
- Objective(s)
- SSOT artifacts consulted
- Plan executed
- Files changed (with rationale)
- Commands run + outcomes
- Tests/checks run + outcomes
- SSOT sync updates made
- Known issues / blockers
- Next recommended tasks (ordered)

### Required structure for `LATEST_STATUS.md`
- Current milestone status
- Completed slices/features
- In-progress work
- Pending priority queue (ordered)
- Risks and blockers
- Exact next 3 actions

### Required structure for this `NEXT_PROMPT.md`
- Project state snapshot
- Exact next objective
- Relevant SSOT docs to re-open first
- Constraints/guardrails
- Mandatory validation commands before commit
- Expected deliverables for the next session

## Exact next objective
Execute the highest unfinished priority item: **unblock `/code` dependency installation and run `composer test`; then produce/update the explicit SSOT gap report with executable evidence and select the next missing SSOT-priority runtime slice**.

## Relevant SSOT docs to re-open first
1. `docs/SSOT/SSOT_INDEX.md`
2. `docs/SSOT/Dependency_Reference.md`
3. `docs/SSOT/Request_Pipeline_Reference.md`
4. `docs/SSOT/Route_Inventory_Reference.md`
5. `docs/SSOT/API_Contract_Guide.md`
6. `docs/SSOT/openapi/cre8.v1.yaml`
7. `docs/SSOT/SSOT_Automation_and_Linting.md`
8. `docs/SSOT/Endpoint_Examples_All_Routes.md`
9. `docs/SSOT/Acceptance_Criteria_Matrix.md`
10. `docs/SSOT/scaffold_stubs.json`

## Constraints/guardrails (session execution)
- Treat `/docs/SSOT` requirement semantics as immutable unless explicitly requested by a human.
- Keep implementation work in `/code` unless explicitly directed otherwise.
- Route/API behavior changes require synchronized updates across runtime routes + OpenAPI + route inventory + endpoint examples + tests.
- Keep handlers thin; behavior belongs in use-cases/policies; fail closed for startup/auth/security.

## Mandatory validation commands before commit
- `git status --short --branch`
- Scaffold integrity check against `docs/SSOT/scaffold_stubs.json`
- `php -l` for each changed PHP file
- `php code/scripts/ssot/lint.php`
- `php code/scripts/ssot/sync_check.php`
- `php code/scripts/ssot/report.php`
- `cd code && composer test` (or capture exact blocker output)

## Expected deliverables for the next session
1. Clear dependency/test execution outcome (`composer install`, `composer test`) with exact evidence.
2. Executable PHPUnit evidence for all implemented slices (including key-login), with defects fixed if found.
3. Updated handoff artifacts (`SESSION_LOG_*`, `LATEST_STATUS.md`, `NEXT_PROMPT.md`) plus refreshed SSOT gap report evidence.

## Output expectations (for every response)
- Show a brief plan before edits.
- Make small, reviewable commits.
- Cite changed files with line references.
- Include exact commands run and test results.
- If blocked, explain blocker and propose the smallest unblocking step.

## Per-slice sync matrix (mandatory)
For each route slice changed, include a matrix with:
- runtime route file
- OpenAPI path section
- Route inventory row
- Endpoint example block
- Contract/security tests

If this session has no route changes, explicitly state: `No route behavior changed; sync matrix not applicable`.

## Completion checklist (must pass before ending session)
- [ ] Code changes align with SSOT docs touched by scope.
- [ ] Route/OpenAPI/inventory/examples/tests synchronized (if route behavior changed).
- [ ] Relevant checks/tests executed and reported.
- [ ] Session handoff artifacts written/updated.
- [ ] Clean, descriptive commit(s) prepared.

Now begin by running the Session start protocol, then execute the highest-priority pending work item.

---

## Optional strict execution addendum (recommended)
- Always print `git status` at start and end.
- Always run scaffold integrity check against `docs/SSOT/scaffold_stubs.json` before first code edit.
- For each slice, attach a sync matrix listing runtime route file, OpenAPI section, route inventory row, example block, and test files.
- If any mandatory sync artifact is intentionally deferred, record exact reason + owner + deadline in session log.
