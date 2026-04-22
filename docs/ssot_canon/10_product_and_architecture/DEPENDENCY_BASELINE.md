# Dependency Baseline

_Status: adopted_
_Last updated (UTC): 2026-04-09_

## Baseline dependency families
- HTTP/runtime: PSR-7 compatible stack.
- Auth/security: JWT signing/verification + sodium-grade crypto.
- Validation/routing/middleware: deterministic request pipeline components.
- Testing: unit/contract/security suites and QA tooling.

## Dependency governance rules
- Security-sensitive dependency upgrades require threat/control review.
- Major-version upgrades require compatibility assessment and migration note.
- Dependency removal/addition must update verification strategy and readiness gates when behavior changes.

## Runtime expectations
- Dependencies must support stable envelope serialization.
- Middleware dependencies must expose predictable ordering and failure behavior.


## Canonical package baseline (root `../../../composer.json`)
- Runtime: `php:^8.2`, `slim/slim:^4.14`, `slim/psr7:^1.7`, `php-di/php-di:^7.0`
- Security/auth: `firebase/php-jwt:^6.11`, `ext-sodium:*`
- Data/runtime: `ext-pdo:*`, `vlucas/phpdotenv:^5.6`
- HTTP/dependencies: `guzzlehttp/guzzle:^7.10`, `neomerx/cors-psr7:^3.0`
- Observability/rate limit: `monolog/monolog:^3.9`, `symfony/rate-limiter:^7.3`, `symfony/cache:^7.3`
- QA: `phpunit/phpunit:^11.5`

## Script contract baseline
- `composer test`
- `composer test:contract`
- `composer test:security`
- `composer qa`
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`
