# Change Impact Map Templates (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Purpose
Standardize PR-level analysis for how a behavior change propagates across contracts, implementation, tests, operations, and documentation.

## Minimal template
| Field | Required content |
|---|---|
| Capability changed | Human-readable capability name |
| Routes/handlers impacted | Path + method + module |
| Contract artifacts impacted | OpenAPI/schemas/docs |
| Data/security impact | Schema/policy/control changes |
| Tests updated | Contract/security/unit/integration evidence |
| Operational impact | SLO/readiness/alerts/runbooks |
| Rollback strategy | Revert plan and safe fallback |

## Rule
A PR touching adopted SSOT docs must include a completed impact map.
