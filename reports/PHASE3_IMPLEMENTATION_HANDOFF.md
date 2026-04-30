# Phase 3 Implementation Handoff Package

- Timestamp (UTC): 2026-04-30T13:36:00Z
- Status: normative
- Decision reference: ADR-004

## Canon-to-implementation mapping

| Canon doc set | Expected src scope | Expected tests scope |
|---|---|---|
| `docs/10_product_and_architecture/*` | request pipeline, middleware, surface adapters | `tests/Contract/SurfaceParity`, `tests/Contract/PipelineOrder` |
| `docs/20_identity_delegation_and_policy/*` | permission vocabulary, capability matrix, delegation state machine, authorization engine | `tests/Contract/Auth`, `tests/Lifecycle/Delegation`, `tests/Contract/Identity*` |
| `docs/30_contracts_and_interfaces/*`, `docs/31_machine_contracts/*` | route handlers, schema validators, error normalization | `tests/Contract/RequestSchema`, `tests/Contract/ResponseSchema`, `tests/Contract/Error` |
| `docs/40_data_security_and_crypto/*` | repositories, key lifecycle, crypto services, threat-control instrumentation | `tests/Security/*`, `tests/Lifecycle/KeyPropagation` |
| `docs/50_content_audience_and_feed/*` | audience membership, moderation workflows, ranking engine | `tests/Contract/Feed`, `tests/Lifecycle/Content` |
| `docs/60_operations_quality_and_release/*` | health checks, boot validators, event emitters, release gates | `tests/Operations/*`, `tests/Smoke/*` |
| `docs/70_extensibility_and_module_patterns/*` | extension registries, provider adapters, module manifests | `tests/Extensibility/*`, `tests/Contract/Compatibility` |
| `docs/80_traceability_decisions_and_program/*` | hook runners, coverage reporters, CI merge gates | `tests/Traceability/*`, `scripts/docs_ssot_*` integration checks |

## Implementation obligations

1. Implementation PRs MUST cite canon requirement IDs and the enforcing Composer command/hook IDs.
2. Contract-shape changes MUST update both machine artifacts and prose parity docs in the same patch.
3. New test suites MUST be wired into Composer before merge.
4. Canon deviations MUST be approved through ADR and recorded in the decisions log before implementation begins.

## Entry gates

Implementation MAY start only after PASS for:

- `composer phase2:acceptance-bundle`
- `composer phase3:final-acceptance-bundle`

## Seed status

Seed canon is preserved as historical origin trace; live normative canon is `docs/`.
