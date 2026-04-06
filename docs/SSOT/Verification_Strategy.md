# Verification Strategy (SSOT)

_Last updated (UTC): 2026-04-06_

## Automated suites
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
- Middleware decision/detail-code behavior
- Boot assertions and profile hardening
- JWT signing/verification and key safety
- Health endpoint and migration smoke

## Stable QA script (manual)
- owner login + console list/create/moderation
- key login + feed/post/comments
- key lifecycle revoke confirmation path
- invite issuance path
