# Change Impact Map Templates (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

## Purpose
Standardize PR-level analysis for how a behavior change propagates across contracts, implementation, tests, operations, and documentation.

## Minimal template
| Field | Required content |
|---|---|
| Capability changed | Human-readable capability name |
| Slice IDs | Architecture-upgrade slice IDs covered by the PR |
| Prerequisites satisfied | Explicit prerequisite slice confirmation |
| Routes/handlers impacted | Path + method + module |
| Contract artifacts impacted | OpenAPI/schemas/docs |
| Data/security impact | Schema/policy/control changes |
| Tests updated | Contract/security/unit/integration evidence |
| Operational impact | SLO/readiness/alerts/runbooks |
| Rollback strategy | Revert plan and safe fallback |

## Rule
- A PR touching adopted SSOT docs includes a completed impact map.
- Architecture-upgrade PRs include the completed checklist in `docs/ssot_canon/80_program_management/ARCHITECTURE_UPGRADE_PR_CHECKLIST.md`.
