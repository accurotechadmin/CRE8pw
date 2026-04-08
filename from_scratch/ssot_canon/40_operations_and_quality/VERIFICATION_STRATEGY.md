# Verification Strategy

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define mandatory automated and manual checks required before release.

## Scope
Contract tests, security tests, QA checks, smoke commands, and SSOT sync checks.

## Normative statements
- CI MUST execute contract and security suites on SSOT-impacting changes.
- Release candidates MUST include smoke evidence artifacts.
- SSOT sync/lint/report checks SHOULD gate merge when available in root project.

## Interfaces / contracts
- Required commands: `composer test`, `composer test:contract`, `composer test:security`, `composer qa`, `composer ops:health-smoke`, `composer ops:migrate-smoke`.
- Future canon command set: docs:ssot:*.

## Failure/rejection semantics
- Any failing required check MUST block release.
- Missing evidence SHOULD require explicit waiver entry.

## Verification requirements
- Enforce command matrix in CI and release checklist.
- Link route acceptance to matrix-driven QA review.

## Traceability hooks
- Code refs: `composer.json`, `code/composer.json`
- Tests refs: `tests/Contract/*`, `tests/Security/*`
- Related SSOT docs: `ACCEPTANCE_CRITERIA_MATRIX.md`, `OPERATIONAL_SMOKE_CHECK_CONTRACT.md`, `RELEASE_CHECKLIST.md`

## Open questions / known gaps
- Root project does not yet expose docs:ssot commands required by canon automation policy.

## Session progress (2026-04-08)
### Completed in this session
- Kept operations/quality documents structured for executable release governance.
- Preserved sections for verification evidence, startup behavior, health semantics, and release controls.
- Prepared docs for measurable SLO/SLI and acceptance-criteria expansion.
### Remaining to finish this document
- [ ] Set numeric thresholds for SLO/SLI and go/no-go gates.
- [ ] Add concrete smoke commands, expected outputs, and evidence artifact paths.
- [ ] Complete Given/When/Then acceptance criteria per critical route family.

