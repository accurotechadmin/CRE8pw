---
doc_id: CRE8-EVIDENCE-EVENT-CATALOG-TEMPLATE
version: 1.0.0
status: provisional-normative
owner: Program Traceability WG
reviewers:
  - Operations Quality WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/seed-intro.md
normative_dependencies:
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Observability Event Catalog Evidence Template

## Purpose
Standardized evidence capture for: HOOK-OBS-EVENT-CATALOG-COVERAGE.

## Required evidence fields
- Hook ID
- Command executed
- Commit SHA
- UTC execution timestamp
- Result (PASS/FAIL)
- Artifact pointers

## Hook checklist
- [ ] HOOK-OBS-EVENT-CATALOG-COVERAGE

## Execution record template
```text
hook_id: <HOOK-ID>
command: <composer command>
commit: <SHA>
executed_utc: <YYYY-MM-DDTHH:MM:SSZ>
result: <PASS|FAIL>
artifacts:
  - <path-or-url>
notes: <optional>
```
