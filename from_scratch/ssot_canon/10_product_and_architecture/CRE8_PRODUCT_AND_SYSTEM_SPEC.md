# CRE8 Product and System Spec

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define the system mission, personas, capabilities, and non-negotiable constraints for CRE8 platform behavior.

## Scope
Covers owner console and key gateway capabilities, excluding non-canonical narrative docs.

## Normative statements
- CRE8 MUST support both owner-account and key-based authentication surfaces.
- Product behavior MUST remain policy-first with explicit authorization decisions.
- Capability claims SHOULD map to concrete routes, services, and tests.

## Interfaces / contracts
- Personas: owner/operator, delegated key holder, client integrator.
- Capability families: auth, delegation, content, moderation, operations.
- Reference contracts: `ARCHITECTURE_AND_SURFACES.md`, `API_CONTRACT_GUIDE.md`.

## Failure/rejection semantics
- Capability not mapped to contract/test is treated as unspecified.
- Conflicting persona expectations MUST be resolved by authz policy docs.

## Verification requirements
- Verify routes/services exist for each capability in traceability matrix.
- Validate acceptance criteria coverage in `../40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`, `src/Application/*`
- Tests refs: `tests/Contract/RouteRegistrarContractsTest.php`
- Related SSOT docs: `CANONICAL_TERMINOLOGY.md`, `ARCHITECTURE_AND_SURFACES.md`, `../50_traceability_and_automation/TRACEABILITY_MATRIX.md`

## Open questions / known gaps
- UI parity depth is still draft; concrete user journeys need expansion.
