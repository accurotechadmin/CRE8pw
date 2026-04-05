# Testing Strategy (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Define quality gates from unit-level behavior up to operational smoke checks.

## 1) Test taxonomy

| Test class | Location | Goal | Trigger | Owner |
|---|---|---|---|---|
| Contract | `tests/Contract/*` | lock API/middleware/config behavior | PR + CI | backend |
| Security | `tests/Security/*` | enforce auth/crypto/security assumptions | PR + CI | backend/security |
| Ops smoke | `scripts/*` | quick deployment sanity checks | deploy gate | ops |

## 2) Command matrix template

| Command | Expected outcome | Typical failures | Triage notes |
|---|---|---|---|
| `composer test` | all suites pass | missing deps/env mismatch | validate vendor + env |
| `php scripts/health_smoke.php` | `health_smoke_ok:*` | service unavailable | verify startup |
| `php scripts/migrate_smoke.php` | `migration_smoke_ok` | SQL incompatibility | inspect migration normalize |

## 3) Coverage expectations

- Required negative-path coverage for auth, validation, and moderation actions.
- Contract tests for envelope consistency and middleware ordering.
- Security tests for signer/verifier/key material/hasher behavior.

## 4) Extensibility checklist

When adding a new feature:

- [ ] Add/extend contract tests.
- [ ] Add security tests if auth/policy touched.
- [ ] Add/update smoke checks if deployment assumptions changed.
- [ ] Update QA matrix and docs references.
