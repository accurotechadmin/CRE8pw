# NEXT SESSION PROMPT (Copy-Ready)

Continue CRE8 SSOT-driven rebuild from current state.

## Project state snapshot
- Branch: `work`
- Implemented in `/code`:
  - `GET /health` vertical slice.
  - `POST /api/auth/login` vertical slice with thin handler + use-case + policy routing.
  - Login-focused contract/security tests authored.
- Updated prompt asset:
  - `docs/SSOT/REUSABLE_LLM_SESSION_PROMPT.md` now enforces state-aware backlog selection via `LATEST_STATUS.md` + latest session logs.
- Blocker from prior execution remains: package installation is blocked by network policy in this environment.

## Exact next objective
Execute the highest unfinished priority item: **make `/code` tests executable (or capture unblock evidence), then implement SSOT drift automation scripts + CI wiring**.

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

## Constraints/guardrails
- Treat `/docs/SSOT` as immutable requirements unless human explicitly requests requirement edits.
- Keep implementation work in `/code` unless explicitly directed otherwise.
- Route/API behavior changes require same-PR sync across runtime routes + OpenAPI + route inventory + examples + tests.
- Keep handlers thin; behavior in use-cases/policies; fail closed on startup/auth/security.

## Mandatory validation commands before commit
- `git status --short --branch`
- Scaffold integrity check against `docs/SSOT/scaffold_stubs.json`
- `php -l` for each changed PHP file
- `php code/scripts/ssot/lint.php`
- `php code/scripts/ssot/sync_check.php`
- `php code/scripts/ssot/report.php`
- `cd code && composer test` (or capture exact blocker output)

## Expected deliverables for the next session
1. Clear dependency/test execution outcome (pass or documented blocker with smallest unblock step).
2. Implemented SSOT lint/sync/report automation scripts with usable output.
3. Initial composer/CI wiring for SSOT automation enforcement.
4. Updated handoff trilogy (`SESSION_LOG_*`, `LATEST_STATUS.md`, `NEXT_SESSION_PROMPT.md`) with command evidence and outcomes.
