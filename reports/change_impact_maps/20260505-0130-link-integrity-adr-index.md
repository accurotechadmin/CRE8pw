# Change impact map — 20260505-0130 UTC

## Scope
- SSOT link resolution in `scripts/docs_ssot_lint.php` (repository-root and unique `docs/**/*.md` basename fallback).
- Canonical markdown link repairs across glossary, identity, human operating model, Phase 2 registers, automation index, parity table, traceability matrix.
- `ADR_INDEX.md` restoration of `ADR-003` and `ADR-004` index rows (status `deprecated` / `superseded`) to satisfy `HOOK-TRACE-DECISION-ADR-LINK`, `HOOK-CONTRACT-ROUTE-INVENTORY-PARITY`, and `HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA`.
- `AUTHORIZATION_AND_DELEGATION_SPEC.md` Change Impact Map template cross-link for review-gate automation.

## Compatibility
`backward-compatible` (documentation and verification tooling alignment; no machine contract behavior change).

## Affected requirements / hooks
- `CRE8-GOV-REQ-0060` .. cross-link integrity (lint).
- `CRE8-TRACE-REQ-0030`, `CRE8-TRACE-REQ-0035` (ADR index completeness).
- `HOOK-SSOT-LINK-INTEGRITY`, `HOOK-REVIEW-GATE-CHECK-AUTO`, `HOOK-CONTRACT-ROUTE-INVENTORY-PARITY`, `HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA`.

## Evidence
- Verification: `composer docs:ssot:lint`, `composer phase3:final-acceptance-bundle` (post-fix).
