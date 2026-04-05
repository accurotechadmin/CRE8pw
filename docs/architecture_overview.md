# Architecture Overview

_Last updated (UTC): 2026-04-05_

## System composition

CRE8 is a single PHP runtime process started from `public/index.php` that:

1. Loads env and normalizes key sources.
2. Builds typed runtime config (`RuntimeConfig`).
3. Builds DI container (`ContainerFactory`).
4. Runs startup assertions (`BootChecks`).
5. Builds Slim app + middleware + routes (`AppFactory`, `RouteRegistrar`).

Primary subsystems:

- **Bootstrap/config:** `public/index.php`, `src/Bootstrap/*`, `src/Config/*`.
- **Transport policy enforcement:** `src/Http/Middleware/*`.
- **Route orchestration:** `src/Http/Routes/RouteRegistrar.php`.
- **Domain services:** `src/Application/*/*Service.php`.
- **Security primitives:** `src/Security/*`.
- **Observability:** `src/Observability/*`.
- **UI runtime:** `public/ui/*` (no build toolchain).

## Trust surfaces

- **Public:** `/`, `/health`, `/.well-known/jwks.json`, `/ui*`, auth bootstrap routes.
- **Gateway surface:** `/api/*` protected by key JWT + device header + use-key constraints.
- **Console surface:** `/console/api/*` protected by owner JWT.

Surface middleware is selected from `MiddlewareOrder::PER_SURFACE_CLASS_MAP` and resolved by `MiddlewareRegistry`.

## Dependency model

- Runtime dependencies are declared in `composer.json` (Slim, PHP-DI, Firebase JWT, Respect Validation, Monolog, Symfony rate limiter/cache, Guzzle, Dotenv).
- Container bindings centralize infrastructure and service registrations in `ContainerFactory`.
- Storage is via PDO; core auth/content services attempt `CREATE TABLE IF NOT EXISTS` bootstrap on startup/runtime so missing tables are provisioned across supported PDO drivers.

## Extension seams

- Add domain behavior by introducing a service under `src/Application/<Domain>` and wiring in `ContainerFactory`.
- Add API routes in `RouteRegistrar` with explicit middleware surface selection.
- Add auth/policy controls in middleware and verifier/signer services.
- Add new audit backend by implementing `AuditEmitter` and rebinding in container definitions.
