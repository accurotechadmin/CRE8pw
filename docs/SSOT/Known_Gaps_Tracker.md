# Known Gaps Tracker (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Short, explicit register of unresolved SSOT-level gaps that could affect upcoming scaffolding and implementation planning.

## Open gaps

| Gap ID | Area | Gap statement | Impact if unresolved | Planned resolution target |
|---|---|---|---|---|
| GAP-001 | Keychain model | Keychain behavior is described conceptually but remains extension-scoped in core data/auth contracts. | Risk of premature schema and API assumptions during scaffolding. | Resolve in dedicated keychain v1/v2 decision ADR before keychain scaffolding. |
| GAP-002 | Surface-specific route inventory | SSOT route grouping exists, but a single canonical, versioned route inventory index doc is not yet separated from examples/OpenAPI. | Risk of drift between examples, UI parity tables, and implementation planning docs. | Add `Route_Inventory_Reference.md` before route scaffolding begins. |
| GAP-003 | SLO instrumentation ownership | SLO targets are defined, but metric-source ownership and alert authority are not mapped per signal. | Risk of monitoring blind spots and unclear operational accountability. | Extend `SLO_SLI_SPEC.md` + operations docs with owner mapping and runbook links. |
| GAP-004 | SSOT automation | Governance requires synchronized updates, but there is no formal SSOT lint/validation automation document yet. | Risk of review-time misses for cross-doc update requirements. | Add SSOT validation workflow spec and CI check definitions. |

## Triage rules
- Keep entries short and actionable.
- Close a gap only when the linked SSOT artifacts are updated and reviewed.
- New unresolved architectural assumptions must be logged here in the same PR.

## Review cadence
Review at least once per release planning cycle and before major scaffolding milestones.
