# ADR-002: Delegation envelope bounds (subset/depth/expiry)

_Status: adopted_
_Date: 2026-04-09_

## Context
Delegated key issuance required deterministic safety boundaries to prevent privilege escalation.

## Decision
Delegation must enforce strict subset permissions/scope, max depth of 3, and explicit expiry claims.

## Consequences
- Policy checks are deterministic and testable.
- Over-scoped or depth-violating issuance fails with stable error behavior.

## Verification implications
Authorization decision-table conformance tests are mandatory for issuance and lifecycle flows.
