# SSOT-to-Code Implementation Map

## Objective
Map core SSOT domains into concrete implementation lanes for development sessions.

## Lanes
- **Contracts lane:** OpenAPI + envelope schemas + error catalog => route handlers, serializers, responders, validation.
- **Authorization lane:** authorization spec + decision tables => policy engine, context builders, rule registry, deny mappings.
- **Data lane:** data model spec/reference/ERD => migrations, repositories, transaction boundaries, invariant enforcement.
- **Security lane:** controls + threat + abuse verification => middleware, hardening policies, regression tests.
- **Operations lane:** startup/health/verification/readiness => boot checks, health probes, smoke scripts, release evidence artifacts.
- **Traceability lane:** trace matrix + automation => change-impact mapping and sync-check discipline.

## Session execution checklist
1. Identify impacted SSOT artifacts.
2. Implement runtime change in scoped modules.
3. Update tests by family (unit/contract/security/integration).
4. Update docs/traceability/evidence artifacts in the same commit set.
5. Validate against verification strategy commands.
