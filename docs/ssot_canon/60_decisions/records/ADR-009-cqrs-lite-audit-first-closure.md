# ADR-009: CQRS-lite audit-first closure and BFF-to-bus integration authority

_Status: adopted_
_Date (UTC): 2026-04-28_

## Context
Upgrade C establishes CQRS-lite command/query separation with audit-first event publication. UC-01 through UC-18 define canonical bus, handler, projection, observability, health, and alerting contracts. UC-19 and UC-20 require migrated surface BFF route families to execute through canonical bus boundaries. A closure decision is required to finalize architecture authority, retire bypass paths, and lock cross-document synchronization obligations.

## Decision
CRE8 adopts CQRS-lite audit-first closure as canonical runtime behavior for migrated protected route families.

1. Migrated gateway and console read route families dispatch through `QueryBus` and canonical query handlers.
2. Migrated gateway and console write route families dispatch through `CommandBus` and `TransactionalCommandExecutor` with canonical command handlers.
3. Surface BFF orchestration remains the only surface-layer flow-composition boundary; BFF modules do not bypass command/query buses.
4. Command/event atomicity, projection idempotency, and envelope/detail-code parity remain mandatory across migrated routes.
5. Closure governance requires synchronized updates across architecture, module boundaries, UI runtime contract, acceptance criteria, verification strategy, traceability matrix, and decisions artifacts in one change set.

## Consequences
- Route-path authority is deterministic: surface controllers → surface BFF orchestration → command/query bus → canonical handlers.
- Contract and security regressions fail closed through existing verification and readiness-gate controls.
- CQRS-lite semantics are production-authoritative and are no longer treated as incremental transition behavior for migrated route families.

## Verification implications
- Verification evidence includes BFF read-to-query integration parity tests, BFF write-to-command integration parity tests, and CQRS closure SSOT sync-check output.
- Traceability matrix rows for CQRS closure governance remain required release evidence for slices UC-21, OPS-02, GOV-01, and GOV-02.
