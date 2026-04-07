# SSOT Gap Report — 2026-04-07

_Status: draft_
_Last updated (UTC): 2026-04-07_

## Scope
Executable evidence refresh for current `/code` rebuild baseline against SSOT priority artifacts:
- `docs/SSOT/Dependency_Reference.md`
- `docs/SSOT/Request_Pipeline_Reference.md`
- `docs/SSOT/Route_Inventory_Reference.md`
- `docs/SSOT/API_Contract_Guide.md`
- `docs/SSOT/openapi/cre8.v1.yaml`
- `docs/SSOT/Endpoint_Examples_All_Routes.md`
- `docs/SSOT/Acceptance_Criteria_Matrix.md`

## Executable evidence snapshot
- `cd code && composer install --no-interaction --no-progress` → **failed** with Packagist connectivity error: `CONNECT tunnel failed, response 403`.
- `cd code && composer test` → **failed** because PHPUnit is not installed (`phpunit: not found`) due to unresolved dependency installation.
- SSOT automation checks still pass from source-of-truth/docs perspective:
  - `php code/scripts/ssot/lint.php` ✅
  - `php code/scripts/ssot/sync_check.php` ✅
  - `php code/scripts/ssot/report.php` ✅

## Gap summary (priority ordered)
1. **Dependency execution gap (blocking):** Composer cannot reach Packagist from this environment; no lockfile/vendor snapshot is available to run PHPUnit offline.
2. **Runtime route coverage gap:** Route inventory/OpenAPI contain many routes not yet rebuilt under `/code`; next auth priority route after login + key-login is `POST /api/auth/refresh`.
3. **Test execution evidence gap:** Contract/security tests exist for implemented slices, but cannot be executed in this environment until dependencies install.

## Selected next SSOT-priority runtime slice
- **`POST /api/auth/refresh`**
  - Rationale: it is the next auth route in SSOT route inventory and OpenAPI after existing `/api/auth/login` and `/api/auth/key-login` slices.
  - Required sync set when implemented: runtime route registration, OpenAPI path schema, route inventory row verification, endpoint example block, contract + security tests.

## Smallest unblocking step
Provide one of the following, then rerun `composer install` + `composer test`:
1. Allowlist outbound access to `repo.packagist.org`, or
2. Configure Composer to use an approved internal mirror, or
3. Supply a vetted `composer.lock` + vendored dependencies cache compatible with this environment.
