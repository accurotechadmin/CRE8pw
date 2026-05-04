---
doc_id: CRE8-OPS-OPERATIONAL-SMOKE-CHECK-CONTRACT
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Platform Architecture WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-15
source_seed_refs:
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - docs/60_operations_quality_and_release/HEALTH_ENDPOINT_CONTRACT.md
  - docs/60_operations_quality_and_release/BOOT_AND_STARTUP_FAILURE_CONTRACT.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Operational Smoke Check Contract

## Normative requirements
- **CRE8-OPS-REQ-0038**: The repository **MUST** provide an operational smoke command chain that verifies startup success, liveness success, readiness success, and deterministic non-zero exit behavior for injected startup failure.
- **CRE8-OPS-REQ-0039**: Smoke command execution **MUST** be reproducible in local and CI contexts without interactive prompts.
- **CRE8-OPS-REQ-0040**: Smoke checks **MUST** emit machine-parseable summary output including command, status, and failure reason.
- **CRE8-OPS-REQ-0041**: Smoke checks **MUST** run after environment loading and before release promotion decisions.
- **CRE8-OPS-REQ-0042**: Smoke check evidence **MUST** be retained in session handoff artifacts for every Phase 3 slice that changes operations contracts.

## Implementation-binding dependencies
- `composer` script orchestration **MUST** execute ordered smoke command steps.
- `slim/slim` and `slim/psr7` **MUST** support probe request execution paths.
- `monolog/monolog` **MUST** capture startup/probe logs used by smoke diagnostics.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-SSOT-COMMAND-EXIT-SEMANTICS` | Validates deterministic zero/non-zero smoke command exits. |
| `HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE` | Ensures smoke semantics remain compatible with bundle-level gating. |

Change Impact Map: [`reports/change_impact_maps/20260430-1246-P3-S9.1-P3-S9.4.md`](reports/change_impact_maps/20260430-1246-P3-S9.1-P3-S9.4.md).

## See also
- [Health Endpoint Contract](./HEALTH_ENDPOINT_CONTRACT.md)
- [Verification Strategy](./VERIFICATION_STRATEGY.md)
- [Contribution Workflow SSOT](../00_governance/CONTRIBUTION_WORKFLOW_SSOT.md)
