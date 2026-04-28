# ADR-006: PDP in-process as canonical authorization architecture

_Status: adopted_
_Date: 2026-04-28_

## Context
Authorization behavior requires one deterministic decision path across gateway and console surfaces, with stable deny mapping and audit correlation.

## Decision
CRE8: the Credential Registry Engine enforces authorization through an in-process PDP architecture with canonical primitives: `DecisionContext`, `Decision`, `Obligation`, and `PolicyRule`. Protected routes resolve `route_action`, build normalized context, execute PDP evaluation, and execute handlers only after explicit allow outcomes.

## Consequences
- Authorization logic is centralized and testable, eliminating ad hoc handler-level policy branching.
- Gateway and console surfaces share one decision contract while preserving non-interchangeable authentication contexts.
- Deny outcomes produce stable `http_status`, `error_code`, and `detail_code` mappings aligned to canonical error-envelope contracts.
- Policy decision events are correlated by `request_id` and `route_action` for rollout comparison and incident triage.

## Verification implications
- Unit invariants for `Decision`, `DecisionContext`, `Obligation`, and `PolicyRule` are mandatory.
- Resolver matrix tests and owner/key context-builder tests are mandatory.
- Contract/security suites must detect any PDP allow/deny drift against authorization decision tables before rollout expansion.
