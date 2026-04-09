# Contribution Workflow (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-09_

## Workflow
1. Identify changed capability and enumerate impacted SSOT artifacts (contracts, machine artifacts, data/security, operations, traceability).
2. Update normative docs first (`20_`, `30_`, `40_` families) before implementation PR merge.
3. Update machine artifacts (`openapi`, envelope schemas) in the same PR where interface shape changes.
4. Update tests and verification docs (`VERIFICATION_STRATEGY.md`, acceptance matrix rows, smoke expectations).
5. Update traceability (`TRACEABILITY_MATRIX.md`) and impact map.
6. Attach evidence using templates under `evidence/templates/`.
7. Request required owner/co-reviewers per `DOCUMENT_STATUS_AND_OWNERSHIP.md`.

## Required PR payload
- Completed change-impact map.
- Verification command output (or CI links) for changed behavior.
- Explicit compatibility classification (breaking/non-breaking).
- Updated known-gaps entry when unresolved assumptions remain.

## Review policy
- No SSOT PR merges without explicit verification evidence.
- Breaking changes require architecture + security signoff.
- Contract changes without machine-artifact synchronization are rejected.
- Unresolved gaps must be documented in `KNOWN_GAPS_TRACKER.md`.

## SLA and escalation
- Owner review target: within 2 business days.
- Security-impacting changes: same-day triage by security owner.
- If reviewer SLA is missed, escalate through engineering manager/program owner.
