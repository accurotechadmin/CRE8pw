# Reusable Prompt — CRE8 SSOT-Driven Development Session Handoff (Post-Scaffold, Execution-Ready)

Copy/paste everything below into a fresh expert coding LLM session.

---

You are continuing development of the CRE8 platform from a prior session.

## Mission
Pick up where the last session ended and execute the next highest-priority SSOT-aligned work to move CRE8 toward production readiness. Use existing implementation as reference, not authority.

## Non-negotiable operating rules
1. Treat **all docs in `/docs/SSOT` as immutable SSOT** for this session.
   - If implementation conflicts with SSOT, SSOT wins.
   - Do not modify SSOT requirements unless explicitly requested by the human.
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

## Current baseline assumption
- Initial scaffold/stubs are already instantiated under `/code` from `scaffold_stubs.json`.
- Begin by validating current state, then continue from remaining highest-priority backlog.

## Session start protocol (mandatory)
1. **State scan**
   - Inspect git status/log.
   - Identify what was completed in previous session and what remains.
   - Confirm scaffold integrity against `scaffold_stubs.json` (if relevant).
2. **Drift check (lightweight first pass)**
   - Detect likely SSOT/code drift for any area you intend to modify.
   - List exact SSOT artifacts that must be synchronized in this session.
3. **Plan**
   - Produce a short execution plan with smallest reviewable increments.
   - Prefer vertical slices (route + use-case + policy + tests + docs sync).
4. **Execute**
   - Make minimal, coherent changes.
   - Run targeted tests/checks after each increment.
   - If blocked, stop early, record blocker, and propose smallest unblocking step.

## Priority queue (default unless human overrides)
1. Vertical slice: `POST /api/auth/login`
2. Minimal contract + security tests for both slices
3. SSOT drift automation script implementation + CI wiring
4. Gap report vs SSOT priority artifacts

## Working tree focus
- Implement rebuild slices under `/code` unless the human explicitly asks to change legacy runtime under `/src`.
- Keep `/docs/SSOT` authoritative requirements immutable; update only synchronization artifacts or explicit handoff docs requested by the human.

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
3. `NEXT_SESSION_PROMPT.md` (copy-ready prompt for immediate continuation)

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

### Required structure for `NEXT_SESSION_PROMPT.md`
- Project state snapshot
- Exact next objective
- Relevant SSOT docs to re-open first
- Constraints/guardrails
- Mandatory validation commands before commit
- Expected deliverables for the next session

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
- For each slice, attach a “sync matrix” listing runtime route file, OpenAPI section, route inventory row, example block, and test files.
- If any mandatory sync artifact is intentionally deferred, record exact reason + owner + deadline in session log.
