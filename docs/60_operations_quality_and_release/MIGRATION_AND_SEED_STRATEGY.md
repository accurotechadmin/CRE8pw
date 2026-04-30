---
doc_id: CRE8-OPS-MIGRATION-SEED-STRATEGY
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-20
source_seed_refs:
  - seed/CRE8_REPO_STUDY_REPORT.md
  - seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md
normative_dependencies:
  - docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md
  - docs/40_data_security_and_crypto/DATA_MODEL_REFERENCE.md
  - docs/60_operations_quality_and_release/CONFIGURATION_ENVIRONMENT_CONTRACT.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Migration and Seed Strategy

## Purpose
Define deterministic migration and seed execution policy for CRE8 persistence stores, including rollback boundaries, transaction guarantees, and promotion controls.

## Normative requirements
- **CRE8-OPS-REQ-0043**: Database schema evolution **MUST** use forward-only migrations; destructive rollback migration files **MUST NOT** be committed to the canonical migration path.
- **CRE8-OPS-REQ-0044**: Migration execution **MUST** run under `ext-pdo` transactional boundaries when the target engine supports DDL transactions; non-transactional engines **MUST** declare compensating safety steps in release notes before execution.
- **CRE8-OPS-REQ-0045**: Seed datasets **MUST** be partitioned into `baseline`, `test-fixture`, and `demo` classes, and production execution **MUST** allow only `baseline` seeds.
- **CRE8-OPS-REQ-0046**: Every migration batch **MUST** emit immutable execution evidence (batch id, migration ids, checksum set, start/end UTC, actor, outcome) to release artifacts for audit linkage.
- **CRE8-OPS-REQ-0047**: Blue/green or zero-downtime releases **MUST** apply expand-and-contract sequencing (additive schema first, code cutover second, cleanup last) and **MUST NOT** remove columns/tables until one stable release after cutover.

## Migration execution contract
| Stage | Required action | Failure response |
|---|---|---|
| Preflight | Validate environment contract, DB connectivity, and migration checksum manifest. | Abort batch before first DDL statement. |
| Apply | Execute pending migrations in monotonic order with lock protection. | Stop at first failure; preserve partial-state evidence; no automatic rollback script. |
| Verify | Run post-apply integrity checks and expected version assertion. | Mark release gate failed and block promotion. |
| Seed | Apply only approved seed class for environment. | Abort with deterministic deny code and no partial demo/test-fixture load. |

## Seed policy by environment
| Environment | Allowed seed class | Prohibited seed class |
|---|---|---|
| local/dev | `baseline`, `test-fixture`, `demo` | none |
| ci/test | `baseline`, `test-fixture` | `demo` |
| staging | `baseline`, `demo` (explicit release note approval) | `test-fixture` |
| production | `baseline` | `test-fixture`, `demo` |

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-SEC-LIFECYCLE-PROPAGATION` | Verifies lifecycle state propagation remains deterministic across migrated datasets. |
| `HOOK-SSOT-COMMAND-EXIT-SEMANTICS` | Verifies migration and seed smoke commands fail/exit deterministically under acceptance-bundle execution. |

Change Impact Map: `reports/change_impact_maps/20260430-1505-P3-S9.5-P3-S9.6.md`.

## See also
- [Configuration Environment Contract](./CONFIGURATION_ENVIRONMENT_CONTRACT.md)
- [Operational Smoke Check Contract](./OPERATIONAL_SMOKE_CHECK_CONTRACT.md)
- [Data Model Spec](../40_data_security_and_crypto/DATA_MODEL_SPEC.md)
