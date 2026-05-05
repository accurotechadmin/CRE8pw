# Change Impact Map — 2026-05-05 05:15 UTC — Permission vocabulary expansion

## Scope classification

`contract-impacting` plus `security-impacting`: expands canonical PDP token surface, declares alias normalization (CRE8-IDPOL-REQ-0028), mandates route completeness mapping (CRE8-IDPOL-REQ-0029), and introduces delegated mint ergonomics tokens (invite/device/keychain/integration).

## Compatibility

Mixed:

- **`backward-compatible`**: every legacy [`ROUTE_INVENTORY_REFERENCE.md`](../../docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md) `required_permission` string retains a **`legacy_alias` → `successor_token`** mapping plus explicit classification column.
- **`conditionally-compatible`**: PDP runtimes MUST implement CRE8-IDPOL-REQ-0028 before routes drop legacy literals; omission yields `AUTH_DENY_PERMISSION_UNKNOWN`.
- **`breaking` / high risk**: issuing `integration.api_rate_limit.exempt` or collapsing moderation visibility semantics without PDP scope distinctions.

## Requirement IDs impacted / added

- **CRE8-IDPOL-REQ-0028**: legacy alias deterministic normalization precondition to PDP gates.
- **CRE8-IDPOL-REQ-0029**: authoritative registry completeness versus Phase 1 route inventory.

Supporting adjustments to **CRE8-IDPOL-REQ-0002** semantics (explicit alias path retained).

## Artifacts touched (immediate)

| Artifact | Purpose |
|---|---|
| [`docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md`](../../docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md) | Registry + normalization + parity checklist |
| [`docs/20_identity_delegation_and_policy/DRAFT_KEY_MINTING_PERMISSION_LATTICE.md`](../../docs/20_identity_delegation_and_policy/DRAFT_KEY_MINTING_PERMISSION_LATTICE.md) | Checklist clarification |
| [`docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../../docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md) | New REQ rows |

## Deferred coordinated updates (explicit follow-through)

Implementations MUST converge in subsequent PRs:

- [`docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`](../../docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md) canonical `required_permission` cells.
- [`docs/31_machine_contracts/openapi/cre8.v1.yaml`](../../docs/31_machine_contracts/openapi/cre8.v1.yaml) `action`/example payloads.
- [`docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`](../../docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md) prose parity rows referencing permissions.
- [`docs/31_machine_contracts/schemas/`](../../docs/31_machine_contracts/schemas/) PDP request schema enumerations (`authz`/policy fixtures).
- [`docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](../../docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md) intrinsic allow/deny/conditional rows binding new tokens (**CRE8-IDPOL-REQ-0006/0007**).
- Executable authorization fixtures / scripts once PHP runtime PDP ships (`composer test:contract:auth*`).

## Evidence / hooks

Manual governance review completes immediately; automate alias drift via strengthened `scripts/docs_ssot_permission_vocab_resolve.php` (planned) and PDP contract assertions.
