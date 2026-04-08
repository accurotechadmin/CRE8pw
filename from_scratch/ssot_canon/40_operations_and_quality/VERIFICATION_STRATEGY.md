# Verification Strategy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Automated suites
- Test framework dependency: `phpunit/phpunit` (see `Dependency_Reference.md`).
- Contract tests (`tests/Contract/*`)
- Security tests (`tests/Security/*`)
- Abuse-case regressions aligned with `Security_Verification_Abuse_Cases.md`

## Required commands
- `composer test`
- `composer test:contract`
- `composer test:security`
- `composer qa`
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`

Smoke command semantics and evidence requirements are defined in `Operational_Smoke_Check_Contract.md`.

## Release verification scope
- Envelope stability
- Middleware decision/detail-code behavior (`slim/slim`, `respect/validation`, `neomerx/cors-psr7`, `symfony/rate-limiter`)
- Boot assertions and profile hardening
- JWT signing/verification and key safety (`firebase/php-jwt`, `ext-sodium`)
- Health endpoint and migration smoke

## Acceptance criteria enforcement
- Route acceptance intent is defined in `Acceptance_Criteria_Matrix.md` and must be used during QA signoff.
- Authorization truth-table behavior is validated against `Authorization_Decision_Tables.md`.
- Middleware detail-code behavior is validated against `Error_Code_Catalog.md`.

## Stable QA script (manual)
- owner login + console list/create/moderation
- key login + feed/post/comments
- key lifecycle revoke confirmation path
- invite issuance path
