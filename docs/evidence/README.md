# `docs/evidence/` — Evidence Framework for SSOT Verification

This directory explains how CRE8 verification evidence is structured, captured, and linked back to requirements and hooks.

## Directory contents

- `templates/` — reusable evidence templates for major hook families.
- `automation/` — index of automation pathways and generated artifact locations.

## Evidence objectives

- Make verification outcomes reproducible.
- Standardize the minimal metadata captured per check.
- Ensure every relevant requirement/hook has attributable evidence references.

## Evidence model

Evidence should connect these layers:

1. Requirement IDs (canonical docs)
2. Hook IDs (verification strategy / automation docs)
3. Executed command(s) and result(s)
4. Produced artifact(s) and file paths
5. Session capture and archival in `reports/`

## Workflow

1. Select the right template from `templates/`.
2. Execute the relevant commands (usually via Composer scripts).
3. Record results + timestamps + artifact paths.
4. Link evidence in traceability where required.
5. Preserve session-level narrative in `reports/session_handoffs/` and `reports/session_responses/`.

## Related documents

- Automation index: [`automation/README.md`](automation/README.md)
- Template index: [`templates/README.md`](templates/README.md)
- Verification strategy: [`../60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- Traceability matrix: [`../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- Reports workspace: [`../../reports/README.md`](../../reports/README.md)
