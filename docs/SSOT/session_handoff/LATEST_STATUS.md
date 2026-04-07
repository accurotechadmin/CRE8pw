# LATEST STATUS (Canonical)

_Status: draft_
_Last updated (UTC): 2026-04-06_

## Current milestone status
- Session-start protocol executed (state scan + scaffold integrity check).
- Dependency install/test remains blocked by Packagist network policy in this environment.
- Next SSOT-priority runtime slice completed in `/code`: `POST /api/auth/key-login`.

## Completed slices/features
- ✅ `GET /health` vertical slice in `/code`.
- ✅ `POST /api/auth/login` vertical slice in `/code`.
- ✅ `GET /` service-status vertical slice in `/code`.
- ✅ `POST /api/auth/key-login` vertical slice in `/code`.
- ✅ Login + key-login contract/security tests authored.
- ✅ SSOT automation scripts + CI workflow implemented and currently passing.

## In-progress work
- `composer install` and therefore executable `composer test` in `/code` remain blocked (`CONNECT tunnel failed, response 403`).

## Pending priority queue (ordered)
1. Unblock `/code` dependency installation and execute `composer test` with full output capture.
2. Execute key-login and existing route PHPUnit suites and fix any discovered defects.
3. Produce/update explicit gap report versus SSOT priority artifacts with executable evidence.

## Risks and blockers
- Proxy/network policy denies outbound package retrieval from Packagist.
- PHPUnit cannot run until Composer dependencies are available locally.

## Exact next 3 actions
1. Configure reachable Composer package source (allowlisted Packagist/internal mirror/vendor cache) and run `cd code && composer install`.
2. Run `cd code && composer test` and capture full results, including key-login tests.
3. Update SSOT gap report with test-backed evidence and any remaining route/priority drift.
