# CRE8.pw Documentation Set

_Last updated (UTC): 2026-04-05_

This directory is the canonical documentation for the current repository state. The backend is a Slim 4 + PHP-DI API with a static SPA under `public/ui`, backed by policy-driven middleware, JWT auth, key lifecycle controls, and SQLite-compatible storage bootstrap inside services.

## Recommended reading order

1. [`inventory_anatomy.md`](./inventory_anatomy.md)
2. [`architecture_overview.md`](./architecture_overview.md)
3. [`request_lifecycle.md`](./request_lifecycle.md)
4. [`api_reference_stub.md`](./api_reference_stub.md)
5. [`data_model_stub.md`](./data_model_stub.md)
6. [`security_model.md`](./security_model.md)
7. [`configuration_reference.md`](./configuration_reference.md)
8. [`frontend_spa_guide.md`](./frontend_spa_guide.md)
9. [`testing_strategy.md`](./testing_strategy.md)
10. [`observability_runbook.md`](./observability_runbook.md)
11. [`deployment_operations.md`](./deployment_operations.md)
12. [`contributing.md`](./contributing.md)
13. [`glossary.md`](./glossary.md)
14. [`roadmap_backlog.md`](./roadmap_backlog.md)

## Documentation conventions

- All endpoint behavior is described against `src/Http/Routes/RouteRegistrar.php` and middleware in `src/Http/Middleware/*`.
- All security claims are tied to `src/Security/*`, auth services, and security tests in `tests/Security/*`.
- All operational checks map to composer scripts and `scripts/*.php`.
- `docs/dev/*` contains session history and execution artifacts; top-level docs are the durable reference layer.
