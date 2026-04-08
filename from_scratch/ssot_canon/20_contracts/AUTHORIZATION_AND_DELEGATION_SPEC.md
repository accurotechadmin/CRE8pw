# Authorization and Delegation Spec

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Specify authorization model, delegation lineage rules, and token surface boundaries.

## Scope
Owner and key principals, key classes, permissions, scopes, and lifecycle transitions.

## Normative statements
- Authorization decisions MUST be deny-by-default.
- Use-key principals MUST NOT perform restricted mutations outside delegated policy.
- Delegation lineage depth SHOULD remain bounded and auditable.

## Interfaces / contracts
- Policy anchors: `src/Application/Auth/KeyLifecycleService`, `code/src/Modules/Delegation/Domain/Policies/*`.
- Claims contract includes subject, surface, token class, permissions, scope, and expiry.

## Failure/rejection semantics
- Missing lineage metadata for delegated actions is a security failure.
- Token surface mismatch MUST reject with `401 auth_invalid`.

## Verification requirements
- Security tests for claim enforcement and replay resistance.
- Contract tests for forbidden and lifecycle transition handling.

## Traceability hooks
- Code refs: `src/Application/Auth/KeyLifecycleService.php`, `src/Security/TokenVerifier.php`
- Tests refs: `tests/Security/JwtTokenSecurityTest.php`, `tests/Contract/AuthServiceLoginContractTest.php`
- Related SSOT docs: `AUTHORIZATION_DECISION_TABLES.md`, `../30_data_and_security/SECURITY_CONTROLS_SPEC.md`

## Open questions / known gaps
- Keychain membership and resolve behavior remain unresolved implementation gap.
