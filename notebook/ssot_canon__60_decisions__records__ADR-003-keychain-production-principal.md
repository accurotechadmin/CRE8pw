# ADR-003: Keychain as production-active v1 principal class

_Status: adopted_
_Date: 2026-04-09_

## Context
Collaborative authoring needed group-based authority while preserving lineage and policy control.

## Decision
`keychain` is a first-class key principal in v1 with explicit membership and effective-permission/scope rules.

## Consequences
- Data model includes membership + effective snapshot tables.
- Authorization and route contracts include keychain governance behavior.

## Verification implications
Invariant tests must cover no-nesting, size cap, membership status filtering, and atomic recompute on mutation.
