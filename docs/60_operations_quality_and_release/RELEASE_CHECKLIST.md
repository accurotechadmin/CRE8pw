---
doc_id: CRE8-OPS-RELEASE-CHECKLIST
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Program Traceability WG
  - Security WG
last_reviewed_utc: 2026-04-30
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

## Ordered release gates
| Gate order | Gate name | Command/evidence | Blocking behavior |
|---|---|---|---|
| 1 | Metadata + links lint | `composer docs:ssot:lint` and `composer docs:ssot:sync-check` | Any non-zero exit **MUST** block release. |
| 2 | Contract integrity | `composer test:contract:all` | Any non-zero exit **MUST** block release. |
| 3 | Phase 2 acceptance baseline | `composer phase2:acceptance-bundle` | Any non-zero exit **MUST** block release. |
| 4 | Phase 3 acceptance gate | `composer phase3:final-acceptance-bundle` (or tracked pending dependency) | Missing command or non-zero exit **MUST** block GA release. |
| 5 | Change-control sign-off | Decision log entry + handoff update | Missing decision evidence **MUST** block release publication. |

## Implementation-binding dependencies
- `phpunit/phpunit` **MUST** execute deterministic contract and acceptance suites.
- `monolog/monolog` **MUST** capture release gate outcomes and correlation IDs.
- `slim/slim` **SHOULD** remain unchanged between gate pass and release artifact creation to avoid unverified runtime drift.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-RELEASE-CHECKLIST-PRESENT` | Confirms checklist document exists, contains ordered gates, and references acceptance-bundle gates. |
| `HOOK-SSOT-COMMAND-EXIT-SEMANTICS` | Verifies release commands enforce deterministic non-zero exit behavior on failure. |


Change Impact Map: `reports/change_impact_maps/20260430-1303-P3-S9.7-P3-S9.9.md`.

## See also
- [Production Readiness Gates](./PRODUCTION_READINESS_GATES.md)
- [Acceptance Criteria Matrix](./ACCEPTANCE_CRITERIA_MATRIX.md)
- [Verification Strategy](./VERIFICATION_STRATEGY.md)
- [Phase 2 Acceptance Criteria](./PHASE2_ACCEPTANCE_CRITERIA.md)
