# Migration and Compatibility Strategy

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Migration principles
- Prefer additive rollout, then gated cutover, then cleanup.
- Keep envelope format stable during migrations unless major version bump.
- Pair schema changes with reversible migration paths when feasible.

## Required migration artifacts
- Compatibility assessment (breaking/non-breaking).
- Data migration plan with backfill/rollback strategy.
- Test coverage for pre/post migration behavior.
- Operational smoke checks updated for new state assumptions.

## Compatibility checklist
- Route responses unchanged for legacy clients where promised.
- Auth/token semantics remain valid across transition window.
- Monitoring detects migration-induced regressions.
