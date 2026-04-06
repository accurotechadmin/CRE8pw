# Migration and Seed Strategy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define deterministic, environment-safe migration, rollback, and seed-data expectations so schema and baseline data are reproducible across developer, CI, staging, and production surfaces.

## Scope
Applies to all schema-bearing entities in `Data_Model_Spec.md`, including principals, credential/auth tables, content/moderation tables, and keychain tables.

## Canonical migration policy
1. **Migrations are append-only artifacts**: never rewrite applied migration files.
2. **Every migration is idempotence-safe for deploy orchestration**: repeated execution must fail safely with explicit error, never silently diverge.
3. **Forward-only production posture**: production rollbacks are handled by compensating migrations or release rollback to prior artifact + DB restore strategy.
4. **One semantic change per migration where practical**: keep blast radius small and reviewable.
5. **Schema + SSOT sync in one PR**: changes to tables/enums/indexes/states require synchronized SSOT updates.

## Migration artifact contract
Each migration must include:
- unique monotonic identifier (`YYYYMMDDHHMMSS_description.sql`),
- explicit transaction boundaries,
- preconditions/assertions,
- forward SQL,
- rollback note (compensating strategy),
- dependency notes (if route or claim behavior depends on this migration),
- verification query snippets.

## Required migration classes
- **bootstrap**: initial schema objects.
- **evolution**: additive columns/indexes/tables.
- **state transitions**: enum/state policy updates.
- **backfill**: deterministic data backfills with progress markers.
- **guardrail**: constraints/uniqueness/foreign-key tightening.

## Environment strategy
- **Local developer**: full reset (`drop + migrate + seed:dev`) supported.
- **CI**: ephemeral DB, migrate from empty, run seed fixture pack, execute test suites.
- **Staging**: migrate forward from production-like snapshot; run smoke and replay-safe checks.
- **Production**: migrate during approved window, with pre-check backup snapshot and post-check health/smoke validation.

## Seed data taxonomy
- **`seed:dev`**: representative but non-sensitive synthetic fixtures.
- **`seed:test`**: deterministic fixtures used by contract/security tests.
- **`seed:staging`**: sanitized production-like fixture set for rehearsal only.
- **`seed:prod`**: forbidden except explicit bootstrap rows (e.g., feature flags with reviewed defaults).

## Determinism and safety rules
- Seed fixtures must be deterministic and keyed to stable IDs.
- No random/non-repeatable data in CI seeds unless explicitly normalized.
- No real customer or real secret material in any seed artifact.
- Any seed introducing auth credentials must store hashes only.

## Required migration runbook checks
Pre-migration:
- verify DB backup/restore readiness,
- verify app artifact and migration artifact checksums,
- verify lock acquisition for migration runner.

Post-migration:
- schema checksum/report emitted,
- key route smoke checks (`/health`, auth login, feed read),
- index and FK integrity checks,
- audit event for migration completion.

## Rollback strategy model
- **Code rollback first** when migration is additive and backward-compatible.
- **Data rollback path** via restore snapshot for destructive failures.
- **Compensating migration** required for non-destructive semantic corrections.
- Any rollback/compensation event requires SSOT and runbook postmortem updates.

## Required commands (canonical naming)
- `composer ops:migrate`
- `composer ops:migrate:dry-run`
- `composer ops:migrate:status`
- `composer ops:seed:dev`
- `composer ops:seed:test`
- `composer ops:migrate-smoke`

## Ownership and evidence
- **Owner**: backend maintainers + platform/SRE.
- PRs touching schema must include:
  - migration list,
  - expected runtime effect,
  - companion SSOT updates,
  - verification output references.

## Related SSOT docs
- `Data_Model_Spec.md`
- `Data_Model_Reference.md`
- `Operations_Runbook_Production.md`
- `Verification_Strategy.md`
- `Change_Impact_Map_Templates.md`
