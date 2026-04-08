# Four-Section Repository Study

Generated: 2026-04-08 (UTC)

## Section 1 — Root codebase (`./`, excluding `./code`)

This section is the currently running CRE8 platform implementation.

### Composition
- Runtime entrypoint and web root (`public/index.php`, `.htaccess`).
- Backend service code under `src/` (Bootstrap, Config, Core, HTTP, Security, Observability, Application services).
- Test suites under `tests/` (Contract + Security).
- Operational scripts in `scripts/`.
- Unbundled static SPA assets in `public/ui/`.
- Root-level package/runtime manifests (`composer.json`, `dot.env`).

### Characteristics
- Full dependency stack includes Slim 4, PHP-DI, JWT, dotenv, CORS, Monolog, Symfony rate limiter/cache, and PHPUnit.
- Startup flow performs env loading, runtime normalization (including JWT key path normalization), typed config creation, boot checks, and deterministic startup-failure JSON envelopes.
- Middleware and route registration are centralized and policy-driven.

## Section 2 — Docs set (`./docs`, excluding `./docs/SSOT`)

This is the canonical narrative/reference documentation set for the current runtime, plus development execution artifacts.

### Composition
- Top-level docs (`docs/*.md`) define architecture, request lifecycle, API references, security/configuration, testing, operations, and glossary/backlog.
- `docs/dev/*` stores implementation history and working execution artifacts (status, QA matrix, decisions, session ledger).

### Characteristics
- Explicit reading order starts with inventory and architecture then progresses through lifecycle/contracts/ops.
- Documentation conventions tie claims directly to code and tests.
- `docs/dev` is intentionally transient compared to top-level durable docs.

## Section 3 — SSOT docs (`./docs/SSOT`)

This is the governance-grade, production-oriented source of truth intended to supersede non-SSOT docs on conflict.

### Composition
- Governance/index layer (`SSOT_INDEX.md`, terminology, curated ADRs, gaps/delta maps).
- Product/system contract layer (`CRE8_Spec.md`, architecture, pipeline, route inventory, API contract guide).
- Machine-verifiable contract artifacts (`openapi/cre8.v1.yaml`, JSON schemas).
- Security/ops/release control layer (threat model, controls, runbooks, smoke contracts, readiness gates, release checklist, SLO/SLI).
- Traceability/session continuity artifacts (`Traceability_Matrix.md`, session handoff logs).

### Characteristics
- Defines precedence and mandatory same-PR updates for contract changes.
- Encodes review cadence and ownership domains.
- Includes supersedes mapping from older docs to SSOT counterparts.

## Section 4 — Rebuild codebase (`./code`)

This is an SSOT-driven rebuild scaffold that is more modular and domain-oriented but currently partial compared to Section 1.

### Composition
- Separate package manifest (`code/composer.json`) with smaller dependency surface.
- Modular source layout:
  - `src/Kernel/*` for bootstrap/config/http contracts.
  - `src/Modules/*` by domain (Auth, Health, Content, Delegation, Moderation).
- Rebuild tests partitioned into Contract/Integration/Security/Unit with many scaffold placeholders.
- Embedded SSOT machine artifacts under `code/docs/SSOT`.
- SSOT automation scripts under `code/scripts/ssot` (lint/sync/report).

### Characteristics
- App bootstrap wires status/health/login endpoints through module-specific handlers/providers.
- Many classes/folders are placeholders (`.gitkeep` + TODO docs), signaling staged migration.
- Includes explicit SSOT drift-detection tooling to keep implementation aligned with docs/contracts.

## Relationship among the four sections

- Section 1 is the active, feature-richer runtime.
- Section 2 documents current behavior for developers/operators.
- Section 3 is the stricter governance/specification authority.
- Section 4 is the future-oriented implementation scaffold designed to converge on Section 3 contracts.

