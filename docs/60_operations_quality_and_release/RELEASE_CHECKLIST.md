---
doc_id: CRE8-OPS-RELEASE-CHECKLIST
version: 1.1.0
status: normative
owner: Operations Quality WG
reviewers:
  - Program Traceability WG
  - Security WG
last_reviewed_utc: 2026-05-04
next_review_due_utc: 2026-06-16
source_seed_refs:
  - seed/CRE8_REPO_STUDY_REPORT.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Release Checklist

## Purpose
Define ordered release gates that MUST execute before canary, GA, or rollback release actions.

## Normative requirements
- **CRE8-OPS-REQ-0053**: Every release candidate **MUST** execute the ordered checklist in this document without skipping gates.
- **CRE8-OPS-REQ-0054**: The release checklist **MUST** include a hard gate that runs `composer phase2:acceptance-bundle` and records pass/fail evidence.
- **CRE8-OPS-REQ-0055**: The release checklist **MUST** include a hard gate that runs `composer phase3:final-acceptance-bundle` once that command is introduced, and until then the checklist **MUST** mark that gate as pending program dependency with explicit owner.
- **CRE8-OPS-REQ-0056**: Any failed gate **MUST** block promotion and **MUST** produce a deterministic release decision record containing environment, command, exit code, and remediation owner.
- **CRE8-OPS-REQ-0057**: Each completed checklist execution **MUST** store immutable evidence references in `docs/evidence/` or CI logs for audit replay.
- **CRE8-OPS-REQ-0076**: Every release checklist gate **MUST** emit a deterministic pass/fail evidence record containing `gate_id`, `gate_name`, `command_or_artifact`, `result`, `executed_utc`, and `operator_id`; missing fields **MUST** block release promotion.

## Ordered release gates
| Gate order | Gate ID | Gate name | Command/evidence | Required evidence fields | Blocking behavior |
|---|---|---|---|
| 1 | RG-01 | Metadata + links lint | `composer docs:ssot:lint` and `composer docs:ssot:sync-check` | `gate_id`, `result`, `executed_utc`, `operator_id`, CI log URL | Any non-zero exit or missing required evidence fields **MUST** block release. |
| 2 | RG-02 | Contract integrity | `composer test:contract:all` | `gate_id`, `result`, `executed_utc`, contract report artifact path | Any non-zero exit or missing required evidence fields **MUST** block release. |
| 3 | RG-03 | Phase 2 acceptance baseline | `composer phase2:acceptance-bundle` | `gate_id`, `result`, `executed_utc`, acceptance artifact path | Any non-zero exit or missing required evidence fields **MUST** block release. |
| 4 | RG-04 | Phase 3 acceptance gate | `composer phase3:final-acceptance-bundle` (or tracked pending dependency) | `gate_id`, `result`, `executed_utc`, dependency-owner note when pending | Missing command, non-zero exit, or missing required evidence fields **MUST** block GA release. |
| 5 | RG-05 | Change-control sign-off | Decision log entry + handoff update | `gate_id`, decision reference, `executed_utc`, accountable approver | Missing decision evidence or missing required evidence fields **MUST** block release publication. |

## Implementation-binding dependencies
- `phpunit/phpunit` **MUST** execute deterministic contract and acceptance suites.
- `monolog/monolog` **MUST** capture release gate outcomes and correlation IDs.
- `slim/slim` **SHOULD** remain unchanged between gate pass and release artifact creation to avoid unverified runtime drift.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-RELEASE-CHECKLIST-PRESENT` | Confirms checklist document exists, contains ordered gates, and references acceptance-bundle gates. |
| `HOOK-SSOT-COMMAND-EXIT-SEMANTICS` | Verifies release commands enforce deterministic non-zero exit behavior on failure. |


Change Impact Map: [`reports/change_impact_maps/20260430-1303-P3-S9.7-P3-S9.9.md`](reports/change_impact_maps/20260430-1303-P3-S9.7-P3-S9.9.md).

## See also
- [Production Readiness Gates](./PRODUCTION_READINESS_GATES.md)
- [Acceptance Criteria Matrix](./ACCEPTANCE_CRITERIA_MATRIX.md)
- [Verification Strategy](./VERIFICATION_STRATEGY.md)
- [Phase 2 Acceptance Criteria](./PHASE2_ACCEPTANCE_CRITERIA.md)
