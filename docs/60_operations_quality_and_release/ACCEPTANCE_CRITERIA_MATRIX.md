---
doc_id: CRE8-OPS-ACCEPTANCE-CRITERIA-MATRIX
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Program Traceability WG
  - Security WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-18
source_seed_refs:
  - seed/CRE8_REPO_STUDY_REPORT.md
normative_dependencies:
  - docs/60_operations_quality_and_release/RELEASE_CHECKLIST.md
  - docs/60_operations_quality_and_release/PRODUCTION_READINESS_GATES.md
  - docs/60_operations_quality_and_release/SLO_SLI_SPEC.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Acceptance Criteria Matrix

## Purpose
Define deterministic acceptance criteria per release type so canary, GA, and rollback decisions are machine-verifiable and consistent with release gates, SLO policy, contract checks, security checks, and Definition of Done.

## Normative requirements
- **CRE8-OPS-REQ-0068**: Release decisions **MUST** use the matrix in this document and **MUST NOT** bypass any required criterion for the selected release type.
- **CRE8-OPS-REQ-0069**: Canary and GA release rows **MUST** include successful `composer phase2:acceptance-bundle` evidence and **MUST** include `composer phase3:final-acceptance-bundle` evidence once introduced.
- **CRE8-OPS-REQ-0070**: GA release rows **MUST** include explicit SLO/error-budget posture and **MUST** fail closed when error budget is exhausted unless an ADR-approved emergency exception exists.
- **CRE8-OPS-REQ-0071**: Rollback release rows **MUST** include deterministic rollback trigger class, rollback command evidence, and post-rollback verification outputs.
- **CRE8-OPS-REQ-0072**: Each completed matrix execution **MUST** produce immutable evidence references (CI run URL, artifact path, decision log reference, UTC timestamp, accountable owner).

## Acceptance criteria matrix
| Release type | Release checklist gates | SLO/SLI posture | Contract/security verification | DoD and governance checks | Decision output |
|---|---|---|---|---|---|
| Canary | `docs:ssot:lint`, `docs:ssot:sync-check`, `test:contract:all`, `phase2:acceptance-bundle` PASS; Phase 3 bundle gate marked PASS or blocked-by-program-dependency with owner. | Error budget remaining > 0; canary SLI alert thresholds configured. | Route parity PASS; auth/feed/lifecycle/identity contract suites PASS; no unresolved critical security control gaps. | Traceability matrix row coverage PASS; no unresolved `P3-EXC-*` tied to canary scope. | `canary_approved` or `canary_blocked` with deterministic reason code. |
| GA | All canary criteria plus `phase3:final-acceptance-bundle` PASS once available; release checklist sign-off present. | Surface SLOs in policy and current 28-day rollups within target; error budget not exhausted. | Threat-control matrix complete; schema and example coverage complete for changed routes; no open critical risk entries. | Definition-of-Done checks PASS; decision log entry recorded with owner + UTC timestamp. | `ga_approved` or `ga_blocked` with remediation owner and due date. |
| Rollback | Rollback checklist and command evidence recorded; rollback target release hash/version confirmed. | Post-rollback SLI stabilization window declared and monitored. | Post-rollback smoke + contract subset PASS (`health`, auth deny mapping, lifecycle deny mapping). | Decision log and incident linkage complete; exception register updated if residual risk remains. | `rollback_executed` or `rollback_blocked` with blocker classification. |

## Implementation-binding dependencies
- `phpunit/phpunit` **MUST** execute contract checks referenced by matrix criteria.
- `monolog/monolog` **MUST** capture release decision evidence with correlation IDs.
- `symfony/rate-limiter` and `symfony/cache` **SHOULD** be validated in canary/GA smoke outputs where rate-limiter behavior is in changed scope.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-RELEASE-CHECKLIST-PRESENT` | Confirms acceptance matrix rows include release-checklist gate linkage and blocking semantics. |
| `HOOK-SLO-SLI-PRESENT` | Confirms acceptance rows include explicit SLO/error-budget posture for canary/GA/rollback. |

Change Impact Map: `reports/change_impact_maps/20260430-1335-P3-S9.10-P3-S10.1.md`.

## See also
- [Release Checklist](./RELEASE_CHECKLIST.md)
- [Production Readiness Gates](./PRODUCTION_READINESS_GATES.md)
- [SLO SLI Spec](./SLO_SLI_SPEC.md)
- [Definition of Done](../00_governance/DEFINITION_OF_DONE.md)
