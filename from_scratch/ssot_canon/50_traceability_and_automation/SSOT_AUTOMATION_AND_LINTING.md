# SSOT Automation and Linting (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define automation requirements that enforce SSOT synchronization rules and reduce documentation drift risk.

## Required automation checks
1. **Cross-reference linter**: detect broken links/references between SSOT artifacts.
2. **Contract sync checker**: detect route diffs between `Route_Inventory_Reference.md` and `openapi/cre8.v1.yaml`.
3. **Error code sync checker**: verify error/detail codes used in examples/tests are registered in `Error_Code_Catalog.md`.
4. **UI parity sync checker**: verify API route inventory changes have matching UI parity updates.
5. **Timestamp/status checker**: ensure modified SSOT docs include updated metadata lines.
6. **Startup/config sync checker**: verify environment variable contract and boot-failure contract remain synchronized with runtime configuration and startup behavior.

## PR policy integration
- SSOT-impacting PRs must run the automation pack in CI.
- Any failed SSOT automation check blocks merge.
- Overrides require explicit architecture/security owner approval and follow-up issue.

## Minimal command contract
- `composer docs:ssot:lint`
- `composer docs:ssot:sync-check`
- `composer docs:ssot:report`

## Evidence output requirements
Automation run must emit:
- machine-readable report (JSON),
- human-readable summary,
- failing artifact list with remediation hints.

## Ownership
- Document/tooling owners: architecture + QA leads.
- CI enforcement owner: platform/SRE.

## Related SSOT docs
- `SSOT_INDEX.md`
- `Change_Impact_Map_Templates.md`
- `Known_Gaps_Tracker.md`
