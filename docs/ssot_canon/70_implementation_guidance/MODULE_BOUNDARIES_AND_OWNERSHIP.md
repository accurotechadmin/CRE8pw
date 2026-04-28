# Module Boundaries and Ownership

_Status: adopted_
_Last updated (UTC): 2026-04-28_

## Core modules
- Auth and token lifecycle
- Authorization/policy evaluation
- Surface BFF orchestration (gateway and console)
- Keychain management
- Content (feed/posts/comments/flags)
- Moderation
- CQRS-lite command/query boundary
- Audit/domain event publication
- Operational/health/diagnostics

## Ownership model
| Module | Primary owner | Secondary owner |
|---|---|---|
| Auth + lifecycle | Security/backend lead | Platform lead |
| Authorization/policy | Security lead | Backend lead |
| Surface BFF orchestration | Backend lead | Frontend/QA leads |
| Content + moderation | Backend lead | QA lead |
| Operations + observability | Platform/SRE lead | Backend lead |

## Boundary rules
- Cross-module calls must occur through documented service contracts.
- Policy decisions cannot be duplicated ad hoc across handlers.
- Shared invariants belong in centralized policy/validation services.
- Controllers are surface-scoped and delegate orchestration to surface BFF modules; controllers do not contain multi-step orchestration logic.
- Surface BFF modules are the only layer that shapes surface DTO/view-model payloads.

## Authorization module internal contract
- The authorization module owns the PDP primitives: `Decision`, `DecisionContext`, `Obligation`, and `PolicyRule`.
- Route-action resolution and surface-specific context builders (owner and key) are authorization-module responsibilities and feed all protected-route policy evaluation.
- The authorization module owns `PdpService` and `RuleRegistry`, including deterministic rule-pack ordering and owner-only console governance rule families.
- The authorization module owns policy configuration loaders for `config/policy/route_actions.php`, `config/policy/permissions.php`, and `config/policy/detail_codes.php`, including boot-time integrity validation and immutable runtime snapshots.
- Gateway and console handlers consume authorization outcomes and obligations; they do not construct authorization decisions directly.

## Surface BFF module contract
- `src/Application/Http/Controller/Gateway/*` and `src/Application/Http/Controller/Console/*` own HTTP handling and envelope response invocation for their surface.
- `src/Application/Bff/Gateway/*` and `src/Application/Bff/Console/*` own route-family orchestration for their surface.
- `src/Application/Bff/Gateway/Dto/*` and `src/Application/Bff/Console/Dto/*` own surface-specific DTO/view-model contracts and remain isolated by surface.
- `src/Application/Bff/Gateway/Feed/*` owns gateway feed-read route-family orchestration (`GET /api/feed`).
- `src/Application/Bff/Gateway/Posts/*` owns gateway posts route-family orchestration (`POST /api/posts`, `GET/PATCH /api/posts/{postId}`, `POST /api/posts/{postId}/flags`).
- `src/Application/Bff/Gateway/Comments/*` owns gateway comments route-family orchestration (`GET/POST /api/posts/{postId}/comments`).
- `src/Application/Bff/Gateway/Cache/*` owns gateway read-cache key derivation, cache read/write orchestration, and mutation-triggered invalidation hooks for feed/comments read families.
- `src/Application/Bff/Gateway/Error/*` owns gateway error-state mapping and preserves canonical `error.code` and `details.code` behavior without lossy remapping.
- `src/Application/Bff/Console/Error/*` owns console error-state mapping and emits UI-runtime-compatible recovery hints while preserving canonical `error.code` and `details.code` behavior.
- `src/Application/Bff/Console/Cache/*` owns console inventory cache key derivation and short-TTL owner-principal cache controls for console read listings.
- `src/Application/Bff/Console/Error/CsrfRecoveryHintProvider.php` owns deterministic CSRF diagnostics-hint generation using canonical CSRF detail codes only.
- `src/Application/Bff/Console/Posts/*` owns console posts route-family orchestration (`GET/POST /console/api/posts`).
- `src/Application/Bff/Console/Moderation/*` owns console moderation route-family orchestration (`POST /console/api/posts/{postId}/moderation`, `POST /console/api/posts/{postId}/comments/{commentId}/moderation`).
- `src/Application/Bff/Console/Keychains/*` owns console keychain route-family orchestration (`GET/POST /console/api/keychains`, members list/mutate, resolve).
- `src/Application/Bff/Console/Governance/*` owns console invite and key-governance route-family orchestration (`POST /console/api/invites`, `POST /console/api/keys`, `POST /console/api/keys/{keyId}/lifecycle`).
- Surface BFF modules may call shared domain services and authorization outcomes but may not call each other directly.
- Legacy orchestration classes or handler-level multi-step flow logic superseded by surface BFF modules are prohibited from protected route execution paths.
- Build-time and integration verification checks fail closed on references from protected route handlers/controllers to superseded orchestration modules.
- Route registration ownership is partitioned by `config/routes_gateway.php`, `config/routes_console.php`, and `config/routes_public.php`.
- `config/routes_public.php` owns public/bootstrap route registration only; `config/routes_gateway.php` owns gateway route registration only; `config/routes_console.php` owns console route registration only.
- Route registration partition checks are required at boot and fail closed on cross-surface registration drift.



## CQRS-lite and audit module contract
- `src/Application/Command/CommandBus.php` owns command dispatch and command handler selection for mutation paths.
- `src/Application/Query/QueryBus.php` owns query dispatch and query handler selection for read paths.
- Base command and query abstractions define immutable payload boundaries and deterministic handler resolution.
- `src/Application/Audit/DomainEvent.php` owns canonical event shape fields required by observability and audit streams.
- `src/Application/Audit/EventPublisher.php` owns event publication guarantees and request-correlation propagation.
- Command handlers and query handlers may share domain services but must not bypass bus boundaries.

## Extension seam ownership map
| Extension seam | Required synchronized artifacts | Primary reviewer |
|---|---|---|
| Route/contract extension | OpenAPI + route inventory + endpoint examples + acceptance matrix | Architecture lead |
| Policy/authorization extension | Auth spec + decision tables + error catalog + abuse cases | Security lead |
| Data-model extension | Data model spec/reference/ERD + migration strategy + traceability matrix | Backend lead |
| UI-runtime extension | UI runtime contract + acceptance matrix + examples | Frontend/QA leads |
