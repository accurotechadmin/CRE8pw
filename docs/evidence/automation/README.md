# `docs/evidence/automation/` — Automated Evidence and Output Mapping

This directory documents how automated SSOT checks generate evidence artifacts and where those artifacts are persisted.

## Automation sources

Primary executables live in `scripts/` and are exposed via [`composer.json`](composer.json) script aliases.

Key families include:

- SSOT lint/sync/report checks (`docs_ssot_*` scripts)
- Contract checks (`test_contract_*` scripts)
- Phase acceptance bundle scripts

## Output destinations

| Output type | Typical location |
|---|---|
| Coverage JSON and SSOT generated summaries | `reports/ssot/` |
| Session handoff command summaries | `reports/session_handoffs/` |
| Full narrative session output | `reports/session_responses/` |
| Change impact maps (when required) | `reports/change_impact_maps/` |

## Operational usage pattern

1. Execute required Composer script set.
2. Confirm pass/fail outcomes from command output.
3. Capture generated artifacts (paths + timestamps).
4. Record the evidence in handoff/response artifacts.
5. Ensure traceability references are updated where impacted.

## Recommended minimum command set for doc-impacting changes

- `composer run docs:ssot:lint`
- `composer run docs:ssot:sync-check`
- `composer run docs:ssot:report`
- Relevant `composer run test:contract:*` commands depending on impacted domains

## Cross references

- Evidence root: [`../README.md`](../README.md)
- Templates: [`../templates/README.md`](../templates/README.md)
- Verification strategy: [`../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- Automation and linting registry: [`../../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`](../../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md)
