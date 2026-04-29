---
doc_id: CRE8-TRACE-CHANGE-IMPACT-TEMPLATES
version: 1.0.0
status: normative
owner: Program Traceability WG
reviewers:
  - Docs Governance WG
  - Security WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - README.md
normative_dependencies:
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/00_governance/DEFINITION_OF_DONE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Change Impact Map Templates

## Purpose
Define required templates for documenting impact of normative changes before merge approval.

## Normative requirements
- **CRE8-TRACE-REQ-0010**: Every change classified as contract-impacting, security-impacting, or policy-impacting **MUST** include a completed change impact map.
- **CRE8-TRACE-REQ-0011**: Each impact map **MUST** enumerate impacted requirement IDs, affected documents, verification hooks, and evidence deltas.
- **CRE8-TRACE-REQ-0012**: Impact maps **MUST** include backwards-compatibility classification: `compatible`, `conditionally-compatible`, or `breaking`.
- **CRE8-TRACE-REQ-0013**: If classification is `breaking`, the map **MUST** include explicit migration notes, rollout gating, and rollback criteria.
- **CRE8-TRACE-REQ-0014**: Impact maps **MUST** reference associated ADR and risk entries when change introduces new architectural or control tradeoffs.

## Template A — Normative documentation change
```markdown
# Change Impact Map
- Change ID:
- Date (UTC):
- Author:
- Change class:
- Compatibility class:

## Impacted requirement IDs
- CRE8-...:

## Impacted artifacts
- docs/...:
- docs/31_machine_contracts/...:

## Verification hooks impacted
- HOOK-... (updated/new/removed):

## Evidence updates required
- docs/evidence/...:

## ADR/risk linkage
- ADR-...:
- RISK-...:

## Rollout and rollback notes
- Rollout prerequisites:
- Rollback trigger:
```

## Template B — Machine/prose contract sync change
Use Template A and additionally include:
- Route/schema inventory delta.
- Prose-to-machine parity notes.
- Drift detection changes (`docs:ssot:sync-check` readiness).

## Verification
- Manual check: reviewer verifies all required fields are present and non-empty for applicable change classes.
- Future automation hook: `HOOK-IMPACT-MAP-COMPLETE` for required section presence and ID format checks.

## See also
- [Change Control Policy](../00_governance/CHANGE_CONTROL_POLICY.md)
- [Definition of Done](../00_governance/DEFINITION_OF_DONE.md)
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Decision Record Template](./DECISION_RECORD_TEMPLATE.md)
