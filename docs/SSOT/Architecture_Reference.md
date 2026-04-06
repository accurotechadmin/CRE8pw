# Architecture Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Runtime composition
CRE8 runs as a single Slim 4 + PHP-DI process booted from `public/index.php`.

Primary composition dependencies are governed by `Dependency_Reference.md`, including `slim/slim`, `slim/psr7`, `php-di/php-di`, `vlucas/phpdotenv`, `ext-pdo`, and `ext-sodium`.

Boot sequence:
1. Load environment and key sources.
2. Build typed runtime config.
3. Build DI container.
4. Execute boot assertions.
5. Build Slim app and register middleware/routes.

## Layers
- Bootstrap/config: `src/Bootstrap/*`, `src/Config/*`
- HTTP policy: `src/Http/Middleware/*`
- Route orchestration: `src/Http/Routes/RouteRegistrar.php`
- Domain services: `src/Application/*/*Service.php`
- Security primitives: `src/Security/*`
- Observability: `src/Observability/*`
- UI runtime: `public/ui/*`

## Trust surfaces
- Public: `/`, `/health`, `/.well-known/jwks.json`, `/ui*`, auth bootstrap routes
- Gateway: `/api/*` (key JWT + device + policy controls)
- Console: `/console/api/*` (owner JWT)

## Extension seams
- Add domain behavior via `src/Application/<Domain>` service + DI binding.
- Add routes with explicit surface middleware mapping.
- Add policy controls in middleware/token services.
- Add observability backend via `AuditEmitter` implementation.
