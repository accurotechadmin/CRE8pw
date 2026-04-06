# Verification Strategy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Automated suites
- Test framework dependency: `phpunit/phpunit` (see `Dependency_Reference.md`).
- Contract tests (`tests/Contract/*`)
- Security tests (`tests/Security/*`)

## Required commands
- `composer test`
- `composer test:contract`
- `composer test:security`
- `composer qa`
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`

## Release verification scope
- Envelope stability
- Middleware decision/detail-code behavior (`slim/slim`, `respect/validation`, `neomerx/cors-psr7`, `symfony/rate-limiter`)
- Boot assertions and profile hardening
- JWT signing/verification and key safety (`firebase/php-jwt`, `ext-sodium`)
- Health endpoint and migration smoke

## Stable QA script (manual)
- owner login + console list/create/moderation
- key login + feed/post/comments
- key lifecycle revoke confirmation path
- invite issuance path
