# Developer Bootstrap Guide

## What CRE8 is
CRE8: the Credential Registry Engine is a policy-governed platform with strict envelope-first APIs, non-interchangeable gateway/console auth contexts, centralized authorization semantics, and auditable request-correlation guarantees.

## What to read first
1. `README.md`
2. `docs/01_foundation/RECOMMENDED_READING_ORDER.md`
3. `docs/ssot_canon/00_governance/SSOT_INDEX.md`
4. `docs/ssot_canon/openapi/cre8.v1.yaml`
5. `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
6. `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`

## Development principles
- Implement contract-first from OpenAPI and JSON schemas.
- Preserve envelope invariants on all API responses.
- Preserve gateway/console auth non-interchangeability.
- Preserve decision-table parity for authorization outcomes.
- Maintain traceability updates for every behavior change.

## Expected scaffold areas
- `src/Application/` for policy/domain/http/command/query orchestration.
- `src/Infrastructure/` for persistence and observability implementations.
- `tests/` organized by unit/integration/contract/security.
- `config/` and `database/` aligned with SSOT operations/data contracts.

## Done criteria for development changes
A change is complete only when:
1. behavior is implemented,
2. SSOT artifacts remain synchronized,
3. contract/security/ops checks are updated,
4. traceability references are updated,
5. evidence outputs are attached.
