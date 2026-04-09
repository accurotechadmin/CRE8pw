# Known Gaps Tracker (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-09_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Purpose
Short, explicit register of unresolved SSOT-level gaps that could affect upcoming scaffolding and implementation planning.

## Open gaps

| Gap ID | Area | Gap statement | Impact if unresolved | Planned resolution target |
|---|---|---|---|---|
| NONE | n/a | No unresolved SSOT-level gaps currently tracked. | n/a | Add new row in same PR when a new unresolved decision appears. |

Prototype reconciliation notes are tracked in `Prototype_to_SSOT_Delta_Map.md` and should be converted into gap rows only when unresolved decisions (not implementation deltas) remain.

## Recently resolved in this SSOT cycle
- GAP-005 (Reference integrity) resolved by adding missing canonical artifacts (`Endpoint_Examples_All_Routes.md`, `Migration_Seed_Strategy.md`, `Prototype_to_SSOT_Delta_Map.md`) and normalizing filename references across SSOT docs.
- GAP-004 (SSOT automation) resolved by introducing `SSOT_AUTOMATION_AND_LINTING.md` and linking enforcement expectations into release and change-impact artifacts.
- GAP-001 (Keychain model) resolved by promoting keychain to v1 production-active auth/data model in `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `DATA_MODEL_REFERENCE.md`, `DATA_MODEL_SPEC.md`, `ERD.md`, route inventory, and contract artifacts.
- GAP-002 (Route inventory) resolved by adding canonical `ROUTE_INVENTORY_REFERENCE.md`.
- GAP-003 (SLO instrumentation ownership) resolved by adding ownership matrix and alert authority mapping in `SLO_SLI_SPEC.md`, plus operations linkage updates.

## Triage rules
- Keep entries short and actionable.
- Close a gap only when the linked SSOT artifacts are updated and reviewed.
- New unresolved architectural assumptions must be logged here in the same PR.

## Review cadence
Review at least once per release planning cycle and before major scaffolding milestones.
