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

## Route registration partition contract
- Route registration is partitioned into `config/routes_public.php`, `config/routes_gateway.php`, and `config/routes_console.php`.
- `config/routes_public.php` registers public/bootstrap routes only (`/`, `/health`, `/.well-known/jwks.json`, `/ui/*`, `/console/owners`, auth endpoints).
- `config/routes_gateway.php` registers gateway route families only (`/api/*`).
- `config/routes_console.php` registers console route families only (`/console/api/*`).
- Boot fails closed when a route is registered in the wrong surface route file or when a protected-route family is missing from its canonical surface route file.

## Gateway BFF route-family orchestration contract
- `GET /api/feed` is orchestrated by Gateway BFF feed-read flow components.
- `POST /api/posts`, `GET /api/posts/{postId}`, `PATCH /api/posts/{postId}`, and `POST /api/posts/{postId}/flags` are orchestrated by Gateway BFF posts flow components.
- `GET /api/posts/{postId}/comments` and `POST /api/posts/{postId}/comments` are orchestrated by Gateway BFF comments flow components.
- Gateway controllers invoke Gateway BFF route-family orchestration and do not call domain services directly for multi-step flow composition.
- Gateway BFF route-family orchestration preserves canonical API envelope semantics, canonical error/detail-code mappings, and gateway/console auth-context non-interchangeability constraints.

## Boundary rules
- Console and gateway auth contexts are never interchangeable.
- Authorization decision logic is centralized and table-driven.
- Data invariants are enforced both in service layer and schema constraints.
- Surface DTO/view-model contracts are isolated by surface; gateway DTOs are not reused in console BFF flows and console DTOs are not reused in gateway BFF flows.
- Gateway and console error-state mappers are surface-scoped. Gateway mapper preserves canonical envelope/detail-code semantics for delegated-key UX. Console mapper preserves canonical envelope/detail-code semantics and exposes UI-runtime-compatible recovery hints for owner-governance UX.


## Surface enablement matrix
| Deployment profile | Public/bootstrap | Gateway | Console | Notes |
|---|---|---|---|---|
| Owner-first | required | optional/internal | required | Suitable for private systems using owner credentialing first. |
| Delegated platform | required | required | required | Full CRE8 model with external key-based API access. |
| Progressive | required | staged rollout | required | Start private; enable gateway externally when business/ops ready. |

## Human-operations note
The native UI routes are parity clients over the same APIs. This gives non-technical operators a guided UX while preserving the same contract behavior used by third-party API clients.
