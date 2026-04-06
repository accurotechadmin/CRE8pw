# LATEST STATUS (Canonical)

_Status: draft_
_Last updated (UTC): 2026-04-06_

## Current milestone status
- Session-start protocol executed again (state scan + scaffold integrity check).
- Dependency install in `/code` still blocked by proxy/network policy.
- Next SSOT-priority runtime slice completed in `/code`: `GET /` service status.

## Completed slices/features
- ✅ `GET /health` vertical slice in `/code`.
- ✅ `POST /api/auth/login` vertical slice in `/code`.
- ✅ `GET /` service-status vertical slice in `/code`.
- ✅ Login-focused contract/security tests authored (`200`, `401`, `422`).
- ✅ Status route contract test authored for `GET /`.
- ✅ SSOT automation scripts + CI workflow implemented and currently passing.

## In-progress work
- `composer install` and therefore `composer test` remain blocked in this environment (`CONNECT tunnel failed, response 403` for Packagist).

## Pending priority queue (ordered)
1. Unblock `/code` dependency installation and execute `composer test`.
2. Deliver next SSOT-priority runtime slice in `/code` (`POST /api/auth/key-login`) with full synchronization bundle.
3. Produce/update explicit gap report versus SSOT priority artifacts with executable test evidence.

## Risks and blockers
- Proxy/network policy denies outbound package retrieval from Packagist.
- PHPUnit cannot run until Composer dependencies are available locally.

## Exact next 3 actions
1. Provide reachable Composer package source (allowlisted Packagist/internal mirror/vendor cache) and run `cd code && composer install`.
2. Run `cd code && composer test` and capture failures/success with full output.
3. Build `POST /api/auth/key-login` vertical slice (runtime + docs sync artifacts + tests) once tests are runnable.
