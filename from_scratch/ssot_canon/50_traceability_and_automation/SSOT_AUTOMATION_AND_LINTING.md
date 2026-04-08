# SSOT Automation and Linting

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define CI-enforced SSOT checks and evidence outputs to prevent drift.

## Scope
Cross-link linting, contract sync checks, metadata checks, and traceability reporting.

## Normative statements
- SSOT-impacting PRs MUST run SSOT lint/sync/report checks in CI.
- Any failing SSOT check MUST block merge unless approved waiver exists.
- Automation output MUST include machine-readable and human-readable reports.

## Interfaces / contracts
- Required commands (target): `composer docs:ssot:lint`, `composer docs:ssot:sync-check`, `composer docs:ssot:report`.
- Current reality: commands exist in `code/composer.json` but not root `composer.json`; root adoption is pending.

## Failure/rejection semantics
- Missing command wiring in active runtime repo is an automation readiness gap.
- Broken cross-links or unsynced route inventory MUST fail sync checks.

## Verification requirements
- Add CI job invoking docs:ssot commands once root scripts are added.
- Keep placeholder evidence files under `from_scratch/ssot_canon/evidence/` (planned).

## Traceability hooks
- Code refs: `code/composer.json`, `composer.json`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php`
- Related SSOT docs: `TRACEABILITY_MATRIX.md`, `KNOWN_GAPS_TRACKER.md`, `../00_governance/CHANGE_CONTROL_POLICY.md`

## Open questions / known gaps
- Root CI workflow integration is not yet implemented; this doc sets enforcement intent.
