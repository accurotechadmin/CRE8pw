# ADR-007: PDP canonicalization closure and no-ad-hoc-handler authorization policy

_Status: adopted_
_Date (UTC): 2026-04-28_
_Deciders: Architecture lead, Security lead, Backend lead_

## Context
Upgrade A introduced in-process PDP primitives, deterministic rule packs, and protected-route middleware enforcement. Protected gateway and console route families now execute canonical authorization checks before handlers.

Residual handler-level authorization branches create drift risk against canonical decision tables and produce inconsistent deny behavior. CRE8: the Credential Registry Engine requires deterministic, testable authorization semantics with stable envelope/error mappings.

## Decision
1. PDP decisions are the single authorization source of truth for protected gateway and console routes when `ARCH_PDP_ENABLED=true`.
2. Route handlers and downstream services do not perform independent authorization checks for permissions, delegation bounds, key-class restrictions, owner-context restrictions, or device-binding requirements.
3. Handler and service layers enforce domain invariants only after PDP allow and preserve canonical error mapping.
4. Reintroduction of ad-hoc handler authorization logic is release-blocking and requires same-PR remediation.

## Consequences
- Authorization behavior remains deterministic across surfaces and route families.
- Decision-table drift risk decreases because enforcement responsibility is centralized.
- Verification includes explicit no-ad-hoc-authorization audits and deny-code consistency checks.
- Traceability now includes a dedicated capability row for PDP canonicalization closure evidence.

## Verification implications
- Enforce UA-19 no-ad-hoc-auth audit evidence for protected handlers.
- Enforce UA-20 SSOT synchronization across authorization spec, decision tables, middleware contract, error catalog, traceability matrix, and ADR index/log.
- Block release when authorization deny behavior bypasses PDP or introduces non-canonical detail codes.
