# Architecture and Surfaces

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Architectural model
CRE8 is a multi-surface HTTP application with three primary runtime surfaces:
- **Public/bootstrap** (`/`, `/health`, `/ui/*`, owner signup/auth)
- **Gateway** (`/api/*`) for delegated-key content actions
- **Console** (`/console/api/*`) for owner governance actions

## Layering
1. HTTP ingress + middleware pipeline
2. Route handlers (surface-scoped)
3. Domain services (auth, keys, keychains, content, moderation)
4. Persistence layer (transactional data model)
5. Observability + audit emissions

## Boundary rules
- Console and gateway auth contexts are never interchangeable.
- Authorization decision logic is centralized and table-driven.
- Data invariants are enforced both in service layer and schema constraints.
