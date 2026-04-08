# Module Boundaries and Ownership

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define target module boundaries and responsibility ownership for incremental refactoring toward modular architecture.

## Scope
Current `src/*` runtime and target `code/src/Modules/*` structure alignment.

## Normative statements
- New features SHOULD be assigned to a module boundary before implementation.
- Cross-module dependencies MUST flow through stable contracts/policies.
- Ownership for each module MUST include primary and backup roles.

## Interfaces / contracts
| Domain area | Current anchor | Target module | Owner role |
|---|---|---|---|
| Auth | `src/Application/Auth/*` | `code/src/Modules/Auth` | backend+security |
| Delegation | `KeyLifecycleService` | `code/src/Modules/Delegation` | backend |
| Content/Moderation | `src/Application/Posts/*` | `code/src/Modules/Content`,`Moderation` | backend |
| Health/ops | `src/Application/Health/*` | `code/src/Modules/Health` | platform |

## Failure/rejection semantics
- Features implemented outside declared boundaries without exception SHOULD be flagged.
- Ownerless module surfaces are non-compliant for production readiness.

## Verification requirements
- Architecture review at each release milestone.
- Traceability matrix module mapping audit.

## Traceability hooks
- Code refs: `src/Application/*`, `code/src/Modules/*`
- Tests refs: `tests/Contract/*`
- Related SSOT docs: `../10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`, `../50_traceability_and_automation/TRACEABILITY_MATRIX.md`

## Open questions / known gaps
- Named ownership assignments still pending team confirmation.
