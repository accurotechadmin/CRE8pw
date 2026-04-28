# Architecture and Surfaces

_Status: adopted_
_Last updated (UTC): 2026-04-28_

## Architectural model
CRE8 is a multi-surface HTTP application with three primary runtime surfaces:
- **Public/bootstrap** (`/`, `/health`, `/ui/*`, owner signup/auth)
- **Gateway** (`/api/*`) for delegated-key content actions
- **Console** (`/console/api/*`) for owner governance actions

## Layering
1. HTTP ingress + middleware pipeline
2. Surface controllers (gateway controllers and console controllers)
3. Surface BFF orchestration modules (GatewayBff and ConsoleBff)
4. Domain services (auth, keys, keychains, content, moderation)
5. Persistence layer (transactional data model)
6. Observability + audit emissions

Gateway controllers call Gateway BFF modules only. Console controllers call Console BFF modules only. Shared domain services remain surface-neutral and are the only allowed cross-surface integration seam.

## Boundary rules
- Console and gateway auth contexts are never interchangeable.
- Authorization decision logic is centralized and table-driven.
- Data invariants are enforced both in service layer and schema constraints.
- Surface DTO/view-model contracts are isolated by surface; gateway DTOs are not reused in console BFF flows and console DTOs are not reused in gateway BFF flows.


## Surface enablement matrix
| Deployment profile | Public/bootstrap | Gateway | Console | Notes |
|---|---|---|---|---|
| Owner-first | required | optional/internal | required | Suitable for private systems using owner credentialing first. |
| Delegated platform | required | required | required | Full CRE8 model with external key-based API access. |
| Progressive | required | staged rollout | required | Start private; enable gateway externally when business/ops ready. |

## Human-operations note
The native UI routes are parity clients over the same APIs. This gives non-technical operators a guided UX while preserving the same contract behavior used by third-party API clients.
