# Architecture Upgrade PR Checklist (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

## Purpose
Define the mandatory checklist for architecture-upgrade PRs in CRE8: the Credential Registry Engine so every behavior change ships with synchronized SSOT, validation evidence, and rollback clarity.

## Checklist usage rule
- The checklist is required for any PR that touches U0/UA/UB/UC/UX/SEC/OPS/GOV/ACT slice scope.
- The checklist is attached in PR description and completed with links to evidence.
- Any unchecked required item blocks merge.

## Required checklist matrix

| Area | Required checks | Evidence artifact |
|---|---|---|
| Slice declaration | List slice IDs and confirm prerequisites are satisfied before marking complete. | Slice references + prerequisite notes |
| Contract sync | Update affected contract docs (`20_`) and machine artifacts (`openapi`, envelope schemas) when behavior or payload semantics change. | Diff links + contract verification output |
| Security and auth boundary | Verify gateway/console non-interchangeability, token `typ`/audience checks, device-binding checks, and canonical deny detail codes. | `composer test:security` auth-boundary evidence |
| Operations and readiness | Update operations docs (`40_`), smoke expectations, and readiness-gate dependencies when behavior changes impact runbooks or gates. | Updated docs + smoke command output |
| Traceability | Update traceability matrix and acceptance references for changed capabilities/routes/services/tests. | Traceability diff |
| Decisions/ADR | Update ADR index/records when architecture decisions are introduced, finalized, or superseded. | ADR links |
| Risk and assumptions | Update risk register for unresolved assumptions or new rollout risks with owner and trigger signal. | Risk register diff |
| Validation | Attach required command output: `composer qa`, `composer test:contract`, `composer test:security`, `composer ops:health-smoke`. | CI links or command logs |
| Rollback safety | Describe rollback path, feature-flag posture, and compatibility classification. | Rollback note in PR |

## Required closure statement
Every architecture-upgrade PR includes this closure statement in completed form:

`All impacted SSOT contracts, machine artifacts, traceability rows, and validation evidence are synchronized for listed slices; gateway and console auth contexts remain non-interchangeable; rollback path and compatibility classification are documented.`

## Related SSOT docs
- `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md`
- `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`
- `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`
- `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`
