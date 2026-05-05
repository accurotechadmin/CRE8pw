---
doc_id: CRE8-ARCH-HUMAN-OPERATING-MODEL
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - Docs Governance WG
  - Operations Quality WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-30
source_seed_refs:
  - README.md
  - seed/CRE8_SEED_CANON_INDEX.md
  - seed/CRE8_SEED_PRESERVATION_MATRIX.md
normative_dependencies:
  - docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md
  - docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md
  - docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md
---

# CRE8 Human Operating Model

## Normative requirements
- **CRE8-ARCH-REQ-0044**: Canon changes **MUST** be owned by the accountable working group declared in document metadata and **MUST** include reviewer coverage from at least one adjacent domain WG. Enforcement is process-governed and validated by `HOOK-SSOT-OWNER-PRESENCE`; no runtime Composer dependency applies.
- **CRE8-ARCH-REQ-0045**: Every requirement-bearing change **MUST** update [`TRACEABILITY_MATRIX.md`](TRACEABILITY_MATRIX.md) in the same patch and include evidence-path updates for verification hooks. Enforcement is process-governed and validated by `HOOK-TRACE-MATRIX-COVERAGE`; no runtime Composer dependency applies.
- **CRE8-ARCH-REQ-0046**: Sessions **MUST** preserve deterministic handoff continuity by updating [`LATEST_SESSION_HANDOFF.md`](../../reports/session_handoffs/LATEST_SESSION_HANDOFF.md), creating one timestamped handoff under `reports/session_handoffs/SESSION_HANDOFF_<UTC>.md`, and archiving the final response under `reports/session_responses/<UTC>_RESPONSE.md`. Enforcement is process-governed and validated by `HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE`; no runtime Composer dependency applies.
- **CRE8-ARCH-REQ-0047**: Deferrals during Phase 3 **MUST** reference ADR-004 or a successor ADR and **MUST NOT** reference ADR-003 as a generic waiver mechanism. Enforcement is process-governed and validated by manual governance review hooks.
- **CRE8-ARCH-REQ-0048**: Human operators **SHOULD** execute the published acceptance command set before commit, and deviations **MUST** be recorded with cause classification (introduced, pre-existing, environment). Execution is toolchain-enforced through `composer` scripts and verified by `phpunit/phpunit`-backed contract checks.

## Working-group operating contract
| Activity | Primary owner | Mandatory outputs |
|---|---|---|
| Requirement authoring | Domain WG owner | Normative doc update + trace row |
| Hook registration | Operations Quality WG / Program Traceability WG | Verification strategy + automation index updates |
| Program deferral decisions | Architecture Governance WG | ADR record + decisions log event |
| Session closure | Active session operator | Handoff, progress board update, response archive |

## See also
- [`docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md`](docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md)
- [`docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`](docs/80_traceability_decisions_and_program/DECISIONS_LOG.md)
- [`reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`](reports/session_handoffs/PHASE3_PROGRESS_BOARD.md)

## Change history
- 2026-04-30 (v1.0.0): Initial normative publication for Phase 3 slices P3-S3.3/P3-S3.5/P3-S3.6. Change Impact Map: [[`reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md`](reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md)](../../reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md).
