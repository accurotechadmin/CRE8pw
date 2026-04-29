---
doc_id: CRE8-EVIDENCE-FEED-CONTRACT-TEMPLATE
version: 1.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Operations Quality WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
normative_dependencies:
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Feed Contract Evidence Template

## Purpose
Provide standardized evidence capture for feed contract hooks (`test:contract:feed`) including ordering, cursor determinism, deny-code catalog coverage, and multi-page cursor monotonicity.

## Required evidence fields
- Hook ID
- Command executed
- Commit SHA
- UTC execution timestamp
- Result (PASS/FAIL)
- Artifact pointers (logs, snapshots, CI URL)

## Hook checklist
- [ ] HOOK-CONTRACT-FEED-ORDER-CURSOR
- [ ] HOOK-CONTRACT-FEED-DENY-CODE-CATALOG
- [ ] HOOK-CONTRACT-FEED-CURSOR-MULTIPAGE-MONOTONIC

## Execution record template
```text
hook_id: <HOOK-ID>
command: composer test:contract:feed
commit: <SHA>
executed_utc: <YYYY-MM-DDTHH:MM:SSZ>
result: <PASS|FAIL>
notes: <optional deterministic notes>
artifacts:
  - <path-or-url>
```
