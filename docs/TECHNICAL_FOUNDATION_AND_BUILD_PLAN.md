# Technical Foundation And Build Plan

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Runtime and stack assumptions
- PHP application stack with PSR-7 HTTP model and contract-first interfaces.
- JSON envelope standard for every API response path.
- JWT-based owner/key authentication with lifecycle controls.
- Database schema supporting principals, delegations, keychains, content, moderation, and auditability.

## Build principles
- Contract-first: OpenAPI/schema changes happen before handler implementation.
- Policy-first: authorization decisions must be table-driven and testable.
- Deterministic operations: startup assertions + health + smoke commands are release-gated.
- Observability-by-default: request_id propagation, event families, measurable SLOs.

## Implementation milestones
1. Bootstrap/runtime wiring + middleware skeleton.
2. Public/auth surfaces and envelope responder.
3. Gateway content routes + permission/scope guards.
4. Console governance routes (keys/keychains/moderation/invites).
5. Security hardening + abuse-case tests.
6. Operationalization + release gates.

## Engineering quality bars
- Zero undocumented route behavior.
- Explicit failure mapping for authz/validation/internal errors.
- Backward-compatibility policy enforced during contract updates.
