# Testing Strategy

_Last updated (UTC): 2026-04-05_

## Automated test suites

- `tests/Contract/*`: API envelope, middleware behavior, boot checks, route wiring, config policy mapping, container/script contracts.
- `tests/Security/*`: key-material safety checks, API key hasher behavior, JWT signer/verifier policy checks.

## Composer commands

- `composer test`
- `composer test:contract`
- `composer test:security`
- `composer qa`
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`

## Operational smoke scripts

- `scripts/health_smoke.php`: boots app and validates `/health` response shape.
- `scripts/migrate_smoke.php`: in-memory SQLite schema sanity for principal/post/delegation/invite tables.

## Coverage emphasis

The suite is behavior-contract heavy: it focuses on middleware detail codes, envelope stability, startup guarantees, auth/token policy, and security-sensitive primitives.
