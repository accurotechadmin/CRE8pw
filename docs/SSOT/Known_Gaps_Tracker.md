# Known Gaps Tracker (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Short, explicit register of unresolved SSOT-level gaps that could affect upcoming scaffolding and implementation planning.

## Open gaps

| Gap ID | Area | Gap statement | Impact if unresolved | Planned resolution target |
|---|---|---|---|---|
| NONE | n/a | No unresolved SSOT-level gaps currently tracked. | n/a | Add new row in same PR when a new unresolved decision appears. |

## Recently resolved in this SSOT cycle
- GAP-004 (SSOT automation) resolved by introducing `SSOT_Automation_and_Linting.md` and linking enforcement expectations into release and change-impact artifacts.
- GAP-001 (Keychain model) resolved by promoting keychain to v1 production-active auth/data model in `Authorization_and_Delegation_Spec.md`, `Data_Model_Reference.md`, `Data_Model_Spec.md`, `ERD.md`, route inventory, and contract artifacts.
- GAP-002 (Route inventory) resolved by adding canonical `Route_Inventory_Reference.md`.
- GAP-003 (SLO instrumentation ownership) resolved by adding ownership matrix and alert authority mapping in `SLO_SLI_SPEC.md`, plus operations linkage updates.

## Triage rules
- Keep entries short and actionable.
- Close a gap only when the linked SSOT artifacts are updated and reviewed.
- New unresolved architectural assumptions must be logged here in the same PR.

## Review cadence
Review at least once per release planning cycle and before major scaffolding milestones.
