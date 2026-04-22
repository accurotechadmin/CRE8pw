# Release Checklist

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Pre-release requirements
- All required test commands pass (`composer test`, contract, security, QA, smoke).
- OpenAPI/schema diffs reviewed and compatibility classified.
- Acceptance criteria for changed routes validated (positive + negative paths).
- Traceability matrix rows updated for changed capabilities.

## Security and operations gates
- Abuse-case suite green.
- Readiness gates A/B/C satisfied.
- Observability coverage confirms request_id correlation and key event families.

## Evidence package
- Attach release evidence template with command outputs and timestamps.
- Record known risks and mitigations in risk register.
- Confirm rollback/runbook readiness.
