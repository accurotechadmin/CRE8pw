# NEXT SESSION PROMPT (Copy-Ready)

Continue CRE8 SSOT-driven rebuild from current state.

## Project state snapshot
- Branch: `work`
- Implemented in `/code`:
  - `GET /health` vertical slice.
  - `POST /api/auth/login` vertical slice with thin handler + use-case + policy routing.
  - Login-focused contract/security tests authored.
- Newly implemented SSOT automation:
  - `code/scripts/ssot/lint.php`
  - `code/scripts/ssot/sync_check.php`
  - `code/scripts/ssot/report.php`
  - `code/scripts/ssot/Support/ssot_lib.php`
  - CI workflow: `.github/workflows/ssot-automation.yml`
- Current blocker remains: dependency installation (`composer install`) cannot reach Packagist in this environment.

## Exact next objective
Execute the highest unfinished priority item: **unblock `/code` dependency installation and run tests, then triage/fix SSOT automation findings to reach passing lint/sync/report checks**.

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
1. Clear test execution outcome after dependency unblocking (or precise blocker evidence with smallest unblocking step).
2. SSOT automation findings triaged/fixed or explicitly deferred with owner + deadline.
3. Updated handoff trilogy (`SESSION_LOG_*`, `LATEST_STATUS.md`, `NEXT_SESSION_PROMPT.md`) with command evidence.
