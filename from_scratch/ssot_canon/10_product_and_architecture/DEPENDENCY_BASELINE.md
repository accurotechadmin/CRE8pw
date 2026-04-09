# Dependency Baseline

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Baseline dependency families
- HTTP/runtime: PSR-7 compatible stack.
- Auth/security: JWT signing/verification + sodium-grade crypto.
- Validation/routing/middleware: deterministic request pipeline components.
- Testing: unit/contract/security suites and QA tooling.

## Dependency governance rules
- Security-sensitive dependency upgrades require threat/control review.
- Major-version upgrades require compatibility assessment and migration note.
- Dependency removal/addition must update verification strategy and readiness gates when behavior changes.

## Runtime expectations
- Dependencies must support stable envelope serialization.
- Middleware dependencies must expose predictable ordering and failure behavior.
