# Operational Smoke Check Contract

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define minimum smoke checks and evidence formats for deploy validation.

## Scope
Post-build and pre-release operational probes.

## Normative statements
- Smoke checks MUST run for health and migration paths before production release.
- Smoke output MUST include timestamp, environment, and pass/fail verdict.
- Failures MUST be attached to release decision record.

## Interfaces / contracts
- Commands: `composer ops:health-smoke`, `composer ops:migrate-smoke`.
- Evidence artifacts: command output logs and summarized verdict table.

## Failure/rejection semantics
- Missing smoke evidence is release blocker.
- Partial execution without explicit waiver is non-compliant.

## Verification requirements
- CI or release automation captures artifacts and stores with release notes.

## Traceability hooks
- Code refs: `scripts/health_smoke.php`, `scripts/migrate_smoke.php`
- Tests refs: `tests/Contract/HealthServiceContractTest.php`
- Related SSOT docs: `HEALTH_ENDPOINT_CONTRACT.md`, `RELEASE_CHECKLIST.md`

## Open questions / known gaps
- Artifact storage location convention has not yet been standardized.

## Session progress (2026-04-08)
### Completed in this session
- Kept operations/quality documents structured for executable release governance.
- Preserved sections for verification evidence, startup behavior, health semantics, and release controls.
- Prepared docs for measurable SLO/SLI and acceptance-criteria expansion.
### Remaining to finish this document
- [ ] Set numeric thresholds for SLO/SLI and go/no-go gates.
- [ ] Add concrete smoke commands, expected outputs, and evidence artifact paths.
- [ ] Complete Given/When/Then acceptance criteria per critical route family.

