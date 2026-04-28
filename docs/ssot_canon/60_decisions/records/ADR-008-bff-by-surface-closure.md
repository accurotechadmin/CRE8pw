# ADR-008: BFF-by-Surface Closure and Legacy Orchestration Retirement

_Status: adopted_
_Date (UTC): 2026-04-28_

## Context
CRE8: the Credential Registry Engine executes gateway and console route families through surface-specific controller and BFF orchestration modules. UB-01 through UB-15 established surface module boundaries, route-family orchestration ownership, surface error-state mapper contracts, and optional surface-scoped cache semantics. UB-16 through UB-18 close Upgrade B by requiring end-to-end integration verification, retirement of superseded orchestration paths, and synchronized SSOT governance updates.

## Decision
CRE8 adopts BFF-by-surface closure as mandatory runtime architecture:
1. Migrated gateway route families execute through Gateway controllers and Gateway BFF orchestration modules only.
2. Migrated console route families execute through Console controllers and Console BFF orchestration modules only.
3. Superseded non-BFF orchestration paths are removed from protected route-family execution and are prohibited by module-boundary policy.
4. Surface integration suites and dead-path audits are mandatory release evidence for BFF-by-surface integrity.
5. SSOT closure for BFF-by-surface requires synchronized updates across architecture, UI runtime contract, module ownership guidance, acceptance matrix, traceability matrix, and decision records.

## Consequences
- Route-family orchestration is deterministic by surface and remains auditable through integration evidence.
- Runtime and documentation drift risks for route orchestration ownership are reduced through dead-path audits and synchronized SSOT closure requirements.
- Release gates block on any reachable superseded orchestration path or unsynchronized SSOT closure artifacts.

## Verification implications
- Verification strategy includes UB-16 integration suite obligations, UB-17 dead-path audit obligations, and UB-18 SSOT closure obligations.
- Acceptance criteria matrix includes route-to-BFF integration parity and legacy orchestration dead-path acceptance criteria.
- Traceability matrix includes explicit capability mapping for surface integration coverage, dead-path elimination, and BFF-by-surface governance closure.
