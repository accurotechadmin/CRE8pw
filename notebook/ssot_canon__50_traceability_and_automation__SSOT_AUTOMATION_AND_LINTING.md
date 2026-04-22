# SSOT Automation and Linting (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Purpose
Define automation requirements that enforce SSOT synchronization rules and reduce documentation drift risk.

## Optional automation checks (recommended)
1. **Cross-reference linter**: detect broken links/references between SSOT artifacts.
2. **Contract sync checker**: detect route diffs between `ROUTE_INVENTORY_REFERENCE.md` and `openapi/cre8.v1.yaml`.
3. **Error code sync checker**: verify error/detail codes used in examples/tests are registered in `ERROR_CODE_CATALOG.md`.
4. **UI parity sync checker**: verify API route inventory changes have matching UI parity updates.
5. **Timestamp/status checker**: ensure modified SSOT docs include updated metadata lines.
6. **Startup/config sync checker**: verify environment variable contract and boot-failure contract remain synchronized with runtime configuration and startup behavior.

## PR policy integration
- SSOT automation is recommended when available, but is not a required merge gate.
- Manual reviewer verification remains authoritative when automation tooling is unavailable.
- If automation checks run and fail, reviewers document disposition in change evidence.

## Optional command examples
- `composer docs:ssot:lint` (if tooling exists)
- `composer docs:ssot:sync-check` (if tooling exists)
- `composer docs:ssot:report` (if tooling exists)

## Evidence output requirements
Automation run must emit:
- machine-readable report (JSON),
- human-readable summary,
- failing artifact list with remediation hints,
- canonical artifact at `evidence/automation/ssot_report.json` (or equivalent CI artifact path).

## Ownership
- Document/tooling owners: architecture + QA leads.
- CI enforcement owner: platform/SRE.

## Related SSOT docs
- `SSOT_INDEX.md`
- `CHANGE_IMPACT_MAP_TEMPLATES.md`
- `RISK_REGISTER.md`
