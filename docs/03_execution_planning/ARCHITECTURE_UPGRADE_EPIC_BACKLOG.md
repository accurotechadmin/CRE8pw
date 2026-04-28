# Architecture Upgrade Epic Backlog

_Status: adopted backlog definition_
_Last updated (UTC): 2026-04-28_

## Purpose
Define the authoritative epic/ticket structure for architecture upgrades A/B/C and integration hardening for CRE8: the Credential Registry Engine.

## Epic structure
| Epic ID | Title | Scope | Owner |
|---|---|---|---|
| EPIC-A | Upgrade A — PDP service-in-process | UA-01 through UA-20 | Security + Backend leads |
| EPIC-B | Upgrade B — BFF-by-surface | UB-01 through UB-18 | Backend + Platform/SRE leads |
| EPIC-C | Upgrade C — CQRS-lite + audit-first | UC-01 through UC-21 | Backend + Platform/SRE leads |
| EPIC-INT | Integration hardening and activation | UX-01, UX-02, SEC-01, SEC-02, OPS-01, OPS-02, GOV-01, GOV-02, ACT-01 through ACT-07 | Security + QA + Platform/SRE leads |

## Dependency and sequencing controls
- U0 prerequisite slices complete before starting upgrade implementation slices unless a slice is explicitly parallel-safe.
- Activation slices start only after corresponding UA/UB/UC and hardening prerequisites are complete.
- Every epic maintains traceability links to impacted SSOT contracts and validation evidence.

## Ticket model requirements
Each ticket includes:
- slice ID(s),
- prerequisite checklist,
- changed SSOT artifacts,
- validation commands and evidence links,
- rollback plan and compatibility classification,
- owner and reviewer assignments.

## Backlog governance rule
Backlog updates that change scope, dependencies, or owners require same-PR synchronization with:
- `ARCHITECTURE_ADDITIONS_AND_UPGRADES_IMPLEMENTATION_MASTER_PLAN.md`,
- `ARCHITECTURE_ADDITIONS_AND_UPGRADES_EXHAUSTIVE_SLICES.md`,
- `SESSION_STATUS_CURRENT.md`, and
- `SLICE_PROGRESS_LEDGER.md`.
