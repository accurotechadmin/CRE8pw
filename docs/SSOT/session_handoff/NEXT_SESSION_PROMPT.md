# NEXT SESSION PROMPT (Copy-Ready)

_Status: draft_
_Last updated (UTC): 2026-04-06_

Continue CRE8 SSOT-driven rebuild from current state.

## Project state snapshot
- Branch: `work`
- Implemented in `/code`:
  - `GET /health` vertical slice.
  - `POST /api/auth/login` vertical slice with thin handler + use-case + policy routing.
  - Login-focused contract/security tests authored.
- SSOT automation status:
  - `code/scripts/ssot/lint.php` ✅ passing
  - `code/scripts/ssot/sync_check.php` ✅ passing
  - `code/scripts/ssot/report.php` ✅ passing
  - CI workflow: `.github/workflows/ssot-automation.yml`
- Remaining blocker:
  - `composer install` in `/code` cannot reach Packagist in this environment (`CONNECT tunnel failed, response 403`).

## Exact next objective
Execute the highest unfinished priority item: **unblock `/code` dependency installation, run `composer test`, and then continue with the next SSOT-priority runtime slice**.

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
1. Clear dependency/test execution outcome (`composer install`, `composer test`) with exact evidence.
2. Next SSOT-priority runtime vertical slice (if tests runnable) with full synchronization bundle.
3. Updated handoff trilogy (`SESSION_LOG_*`, `LATEST_STATUS.md`, `NEXT_SESSION_PROMPT.md`) with command evidence.
