# Prototype-to-SSOT Delta Map (Rebuild Planning)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Provide an explicit reconciliation map between current prototype implementation behavior and SSOT v1 targets so fresh implementation planning can sequence required uplift work safely.

## Delta classes
- **Contract delta**: route or schema behavior differs from SSOT canonical contract.
- **Data delta**: prototype persistence model differs from `Data_Model_Spec.md` target.
- **Operations delta**: prototype runbook/smoke behavior differs from production SSOT expectations.
- **UX delta**: UI runtime behavior exists in prototype and should be promoted to explicit SSOT implementation guidance.

## Canonical delta register

| Delta ID | Class | Current prototype state | SSOT target state | Required action for fresh build |
|---|---|---|---|---|
| DELTA-001 | Contract | Console keychain routes currently expose list-only behavior in prototype-era APIs. | Full keychain lifecycle includes create, membership mutate/list, and resolve routes. | Implement full keychain route family and acceptance/security packs before release gate C. |
| DELTA-002 | Data | Prototype keychain behavior is represented via envelope scope metadata and list inventory only. | SSOT requires `keychain_memberships` + `keychain_effective_snapshots` with atomic recomputation behavior. | Implement schema + services + tests for membership invariants and effective snapshot updates. |
| DELTA-003 | Error mapping | Prototype has richer detail-code behavior in middleware/error handling than currently enumerated in catalog. | SSOT requires canonical detail-code registry aligned with middleware/runtime policies. | Keep catalog synchronized with runtime detail codes and contract/security tests. |
| DELTA-004 | Startup contract | Prototype startup emits deterministic `boot_failed` envelope and startup events. | SSOT now formalizes deterministic startup/failure behavior. | Preserve boot-failure envelope and evidence emission in fresh boot architecture. |
| DELTA-005 | Ops smoke | Prototype includes `ops:health-smoke` and `ops:migrate-smoke`; migration smoke references migration artifact path assumptions. | SSOT migration and smoke strategy requires canonical artifact + command alignment. | Introduce real migration artifacts and synchronize smoke scripts with migration strategy. |
| DELTA-006 | Local bootstrap | Prototype supports local default owner seeding via optional env policy. | SSOT now formalizes local bootstrap policy boundaries. | Preserve local-only bootstrap convenience while forbidding non-local implicit seed behavior. |

## Rebuild sequencing guidance
1. Reconcile contract + route deltas (`DELTA-001`, `DELTA-003`).
2. Reconcile data + migration deltas (`DELTA-002`, `DELTA-005`).
3. Lock startup and configuration behavior (`DELTA-004`).
4. Stabilize local-dev bootstrap ergonomics (`DELTA-006`).

## Governance rule
Any PR that closes a delta row must:
- update affected SSOT artifacts,
- link verification evidence,
- update `Traceability_Matrix.md` and `RELEASE_CHECKLIST.md` where applicable.

## Related SSOT docs
- `Known_Gaps_Tracker.md`
- `Route_Inventory_Reference.md`
- `Data_Model_Spec.md`
- `Operational_Smoke_Check_Contract.md`
- `Boot_and_Startup_Failure_Contract.md`
