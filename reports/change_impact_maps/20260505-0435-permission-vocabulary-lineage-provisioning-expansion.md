# Change impact map — Permission vocabulary lineage/provisioning expansion

- **Executed (UTC):** 2026-05-05
- **Change class:** `contract-impacting` (canonical permission registry + new normative **`CRE8-IDPOL-REQ-*`** semantics; **Deferred:** HTTP route/machine surface sync per user roadmap follow batch).
- **Primary documents:** [`docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md`](../../docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md); [`docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../../docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md).

## Compatibility

- **`backward-compatible` additive expansion** at the prose registry boundary: Phase 1 route inventory literals untouched; **`CRE8-IDPOL-REQ-0029`** obligations unchanged pending coordinated inventory/OpenAPI modernization.
- New tokens **extend** PDP vocabulary; runtime **SHOULD NOT** treat unknown-but-registered successors as implicit grants until PDP wiring lands.

## Requirement impact summary

| ID | Change |
|---|---|
| `CRE8-IDPOL-REQ-0030` | **New** provisioning envelope intersection rule binding mint/delegation policy surfaces |
| `CRE8-IDPOL-REQ-0031` | **New** guidance discouraging provisioning-only literals on Route ACL rows |
| Numerous tokens | Registry rows added (**lineage navigation**, issuance caps/template locks, delegation width/transfers, owner console complements, draft harmonization crumbs) |

## Follow-up deltas (explicitly **not** in this batch — user directed)

 [`PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](../../docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md) intrinsic rows for new authoring/navigation domains; [`KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md`](../../docs/20_identity_delegation_and_policy/KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md) union-vs-intersection narrative alignment; Route inventory / OpenAPI / schemas / parity table refresh when **`required_permission`** cells adopt successors.
