# Technical Foundation And Runtime Baseline

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

## Runtime capability baseline
1. Bootstrap/runtime wiring and middleware ordering are operationalized.
2. Public/auth surfaces and envelope responder are production-governed.
3. Gateway content routes enforce permission/scope/device guards.
4. Console governance routes cover keys/keychains/moderation/invites.
5. Security hardening and abuse-case verification are release gates.
6. Operational readiness checks and release controls are enforced per SSOT.

## Engineering quality bars
- Zero undocumented route behavior.
- Explicit failure mapping for authz/validation/internal errors.
- Backward-compatibility policy enforced during contract updates.
