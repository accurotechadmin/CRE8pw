# NEXT PROMPT — CRE8 SSOT-Driven Development Continuation (Reusable + Session-Aware)

_Status: draft_
_Last updated (UTC): 2026-04-07_

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
- `/docs/SSOT/session_handoff/GAP_REPORT_2026-04-07.md`
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
- Current blocker:
  - `composer install` in `/code` fails: `CONNECT tunnel failed, response 403` (Packagist unreachable).

## Priority queue (apply in order, skipping completed items)
1. Unblock `/code` dependency installation and execute `composer test`; capture blocker/root cause if still failing.
2. Deliver next missing SSOT-priority runtime slice: `POST /api/auth/refresh` with full synchronization.
3. Refresh explicit gap report versus SSOT priority artifacts using PHPUnit-backed evidence.

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
2. If dependency unblock succeeds, executable PHPUnit evidence for implemented slices; defects fixed if found.
3. If route slice changes, full sync matrix (runtime route + OpenAPI + route inventory + endpoint examples + tests).
4. Updated handoff artifacts: `SESSION_LOG_*`, `LATEST_STATUS.md`, and `NEXT_PROMPT.md`.
