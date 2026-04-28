# Decisions Log

_Status: adopted_
_Last updated (UTC): 2026-04-28_

## Chronological entries
- **2026-04-06**: Adopted SSOT-first canonical structure and machine contract precedence.
- **2026-04-06**: Promoted keychain model to v1 production behavior.
- **2026-04-06**: Locked route inventory and acceptance matrix as behavioral source-of-truth.
- **2026-04-07**: Added abuse-case verification and readiness gate controls.
- **2026-04-08**: Finalized implementation-grade norms across the SSOT canon at `/workspace/CRE8pw/docs/ssot_canon/`.
- **2026-04-28**: Adopted in-process PDP as canonical authorization architecture (ADR-006).
- **2026-04-28**: Finalized PDP canonicalization closure; authorization policy evaluation is centralized in PDP and removed from protected route handlers (ADR-007).
- **2026-04-28**: Finalized BFF-by-surface architecture closure; migrated route families execute through surface BFF orchestration and superseded orchestration paths are retired (ADR-008).
- **2026-04-28**: Finalized CQRS-lite audit-first closure; migrated BFF read/write route families dispatch through canonical query/command bus boundaries and closure governance artifacts are synchronized (ADR-009).

## Update rule
Any decision that changes API shape, auth policy, data invariants, or release gates must be logged here in same PR.
