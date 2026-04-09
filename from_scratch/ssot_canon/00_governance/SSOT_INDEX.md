# SSOT Index

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Canon navigation
1. `00_governance/` — ownership, policy, standards.
2. `10_product_and_architecture/` — system intent and boundaries.
3. `20_contracts/` — API, authorization, error, UI runtime contracts.
4. `30_data_and_security/` — schema, controls, threat and abuse model.
5. `40_operations_and_quality/` — acceptance, verification, readiness.
6. `50_traceability_and_automation/` — change impact and lint/traceability controls.
7. `60_decisions/` — ADR workflow + decision history.
8. `70_implementation_guidance/` — module/version/migration/test-data guidance.
9. `80_program_management/` — workflow, DoD, risk, roadmap.

## Machine artifacts
- `openapi/cre8.v1.yaml`
- `schemas/success-envelope.schema.json`
- `schemas/error-envelope.schema.json`

## Usage rule
If two documents disagree, precedence is:
1) machine artifacts, 2) contracts/security docs, 3) operations docs, 4) program docs.
