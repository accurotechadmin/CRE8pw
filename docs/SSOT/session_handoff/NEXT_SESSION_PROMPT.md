# NEXT SESSION PROMPT (Copy-Ready)

Continue CRE8 SSOT-driven rebuild from current state.

## Project state snapshot
- Branch: `work`
- Scaffold integrity: verified against `docs/SSOT/scaffold_stubs.json`.
- Implemented in `/code`:
  - `GET /health` route vertical slice (AppFactory wiring, route provider, handler, use-case, envelope responder).
  - Unit + contract tests for health authored.
  - `/code/docs/SSOT/openapi/cre8.v1.yaml` updated to include `/health`.
- Blocker: `composer install` failed (Packagist tunnel 403), so `composer test` did not run.

## Exact next objective
Implement the next priority queue item: **vertical slice `POST /api/auth/login`** in `/code`, SSOT-aligned and test-backed.

## Relevant SSOT docs to re-open first
1. `docs/SSOT/SSOT_INDEX.md`
2. `docs/SSOT/CRE8_Spec.md`
3. `docs/SSOT/Architecture_Reference.md`
4. `docs/SSOT/Dependency_Reference.md`
5. `docs/SSOT/Request_Pipeline_Reference.md`
6. `docs/SSOT/Route_Inventory_Reference.md`
7. `docs/SSOT/API_Contract_Guide.md`
8. `docs/SSOT/openapi/cre8.v1.yaml`
9. `docs/SSOT/Endpoint_Examples_All_Routes.md`
10. `docs/SSOT/Acceptance_Criteria_Matrix.md`

## Constraints/guardrails
- SSOT is immutable and authoritative.
- Keep thin handlers; use-case/policy carries behavior.
- Domain layer framework-agnostic.
- Any route behavior change must sync route registration + OpenAPI + route inventory + examples + tests in one change set.
- No fake business logic.

## Mandatory validation commands before commit
- `php -l` on all changed PHP files
- `php code/scripts/ssot/lint.php`
- `php code/scripts/ssot/sync_check.php`
- `php code/scripts/ssot/report.php`
- `cd code && composer test` (or report exact blocker)

## Expected deliverables for next session
1. Auth login vertical slice implementation in `/code`.
2. Contract + security tests for login (and health/login minimal pair where applicable).
3. Updated session handoff artifacts (`SESSION_LOG_*`, `LATEST_STATUS.md`, `NEXT_SESSION_PROMPT.md`).
