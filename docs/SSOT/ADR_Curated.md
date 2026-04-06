# ADR Curated (Production-Relevant)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Included ADRs (durable)
1. Static no-build SPA under `/public/ui` for parity delivery.
2. Per-surface session state model with explicit active surface.
3. Centralized gateway header policy (`Authorization` + `X-Device-Id`).
4. Shared dangerous-action confirmation UX primitives.
5. Path-aware `/ui` asset serving with SPA fallback for deep links.
6. Path-aware CSP split (strict API, UI-safe CSP for `/ui*`).

## Exclusion rule
Session-specific execution notes remain in `docs/dev/SESSION_LEDGER.md`; only durable architecture/UX decisions belong here.
