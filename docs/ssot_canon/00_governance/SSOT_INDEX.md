# SSOT Index

_Status: adopted_
_Last updated (UTC): 2026-04-22_


## Canon status
This index governs the production SSOT canon at `/workspace/CRE8pw/docs/ssot_canon/`. Planning/completion scaffolding artifacts are intentionally excluded from authoritative scope.

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
- `docs/ssot_canon/openapi/cre8.v1.yaml`
- `docs/ssot_canon/schemas/success-envelope.schema.json`
- `docs/ssot_canon/schemas/error-envelope.schema.json`

## Usage rule
If two documents disagree, precedence is:
1) machine artifacts, 2) contracts/security docs, 3) operations docs, 4) program docs.


## Recent canon changes
- 2026-04-22: Removed key proposals and aligned canon to active key classes only (`primary_author`, `secondary_author`, `use`, `keychain`).
- 2026-04-22: Device-binding JWT requirements preserved and clarified across security/auth/runtime contracts.
- 2026-04-22: Known gaps tracker retired; risk/task registers are authoritative for open assumptions.
- 2026-04-22: Historical evidence artifacts explicitly labeled as non-current for readiness evaluation.
