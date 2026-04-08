# Test Data and Fixture Strategy

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define consistent test data patterns and fixture governance for contract/security/integration reliability.

## Scope
PHPUnit fixtures for auth, key lifecycle, posts/comments/moderation, and health checks.

## Normative statements
- Test fixtures MUST be deterministic and isolated per suite.
- Security-sensitive fixtures MUST avoid real secrets and production-like private keys unless explicitly synthetic.
- Canon-critical acceptance scenarios SHOULD have named fixture sets.

## Interfaces / contracts
- Fixture categories: auth principals, token families, delegation envelopes, content entities, degraded dependency states.
- Fixture ownership: suite-level maintainers under tests/Contract and tests/Security.

## Failure/rejection semantics
- Flaky fixtures causing nondeterministic outcomes SHOULD block merge.
- Shared mutable fixtures without reset semantics are non-compliant.

## Verification requirements
- CI rerun stability checks and periodic flaky-test audit.

## Traceability hooks
- Code refs: `tests/Contract/*`, `tests/Security/*`
- Tests refs: same
- Related SSOT docs: `../40_operations_and_quality/VERIFICATION_STRATEGY.md`, `../30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`

## Open questions / known gaps
- Repository lacks explicit fixture factory pattern documentation today.
