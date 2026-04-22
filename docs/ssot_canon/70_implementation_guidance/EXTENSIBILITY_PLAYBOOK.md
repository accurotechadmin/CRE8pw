# Extensibility Playbook

_Status: adopted_
_Last updated (UTC): 2026-04-22_

## Purpose
Define safe, repeatable extension patterns so teams can customize CRE8 behavior without breaking SSOT traceability, contract parity, or security controls.

## Extension seam map
- Route-level behavior: add/extend endpoints with synchronized OpenAPI + inventory + examples + acceptance updates.
- Policy-level behavior: add permission rules/decision rows with authz and error-catalog synchronization.
- Data shape evolution: additive fields or new entities with migration/compatibility evidence.
- UI parity evolution: update UI runtime parity matrix with route-state/error-state mappings.

## Pattern 1: Extend post payloads
- Additive-json approach: extend post payload fields while preserving envelope and existing required behavior.
- New-entity approach: create a new domain entity (for example annotations or direct-message bodies) by cloning route/policy/schema/test patterns from posts.

## Pattern 2: Add a new governed action
1. Define route + OpenAPI schema.
2. Define authorization policy row and detail-code outcomes.
3. Define persistence + migration implications.
4. Add acceptance/security/abuse-case tests.
5. Update traceability and evidence templates.

## Guardrails
- No extension may bypass delegation subset/depth/expiry invariants.
- No extension may alter envelope shape without versioning policy compliance.
- No extension may merge without synchronized SSOT artifacts and evidence payload.

## Related SSOT docs
- `docs/ssot_canon/70_implementation_guidance/MIGRATION_AND_COMPATIBILITY_STRATEGY.md`
- `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`
- `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
