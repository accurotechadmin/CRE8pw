# NEXT SESSION PROMPT (Copy-Ready)

Continue CRE8 SSOT-driven rebuild from current state.

## Project state snapshot
- Branch: `work`
- Implemented in `/code`:
  - `GET /health` vertical slice.
  - `POST /api/auth/login` vertical slice with thin handler + use-case + policies + route provider wiring.
  - Login tests authored: contract success + security invalid/validation failures.
  - Scaffold OpenAPI (`code/docs/SSOT/openapi/cre8.v1.yaml`) synced for health/login.
- Blocker: dependency installation still fails (`composer install` => Packagist CONNECT tunnel 403), so PHPUnit execution is pending.

## Exact next objective
Execute the highest-priority remaining item: **make tests executable and then implement SSOT drift automation scripts + CI wiring**.

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
- `/docs/SSOT` is immutable requirements SSOT unless explicitly requested.
- Keep work in `/code` scaffold unless explicitly directed otherwise.
- Route changes must sync route registration + OpenAPI + route inventory + examples + tests in same change set.
- Thin handlers; domain behavior in use-cases/policies.
- Fail closed for startup/auth/security.

## Mandatory validation commands before commit
- `git status --short --branch`
- `php -l` for each changed PHP file
- `php code/scripts/ssot/lint.php`
- `php code/scripts/ssot/sync_check.php`
- `php code/scripts/ssot/report.php`
- `cd code && composer test` (or capture exact blocker output)

## Expected deliverables for the next session
1. Executable tests in `/code` (or documented unblock patch if environment remains constrained).
2. Real implementation for SSOT lint/sync/report scripts and initial CI wiring.
3. Updated session handoff trilogy (`SESSION_LOG_*`, `LATEST_STATUS.md`, `NEXT_SESSION_PROMPT.md`) with sync matrix and blocker status.
