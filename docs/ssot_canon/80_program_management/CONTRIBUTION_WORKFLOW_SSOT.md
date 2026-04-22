# Contribution Workflow (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-22_

## Workflow
1. Identify changed capability and enumerate impacted SSOT artifacts (contracts, machine artifacts, data/security, operations, traceability).
2. Update normative docs first (`20_`, `30_`, `40_` families) before implementation PR merge.
3. Update machine artifacts (`openapi`, envelope schemas) in the same PR where interface shape changes.
4. Update tests and verification docs (`docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`, acceptance matrix rows, smoke expectations).
5. Update traceability (`docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`) and impact map.
6. Attach evidence using templates under `evidence/templates/`.
7. Request required owner/co-reviewers per `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`.
8. Narrative or explanatory updates MUST be checked for conflict against OpenAPI/schemas and authorization decision tables.

## Required PR payload
- Completed change-impact map.
- Verification command output (or CI links) for changed behavior.
- Explicit compatibility classification (breaking/non-breaking).
- Updated risk/task register entry when unresolved assumptions remain.

## Review policy
- No SSOT PR merges without explicit verification evidence.
- Breaking changes require architecture + security signoff.
- Contract changes without machine-artifact synchronization are rejected.
- Unresolved assumptions must be documented in `docs/ssot_canon/80_program_management/RISK_REGISTER.md` with owner and target date.

## SLA and escalation
- Owner review target: within 2 business days.
- Security-impacting changes: same-day triage by security owner.
- If reviewer SLA is missed, escalate through engineering manager/program owner.


## Emergency Class D workflow
- For production incidents requiring immediate mitigation, use the Class D process in `docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md`.
- Class D allows hotfix merge under temporary SLA waiver, but requires a remediation PR opened within 24 hours to fully synchronize SSOT artifacts.
- The remediation PR is mandatory and must include traceability and SSOT evidence payloads before closure.
