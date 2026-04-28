# Verification Strategy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Automated suites
- Test framework dependency: `phpunit/phpunit` (see `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`).
- Contract tests (`tests/Contract/*`)
- Security tests (`tests/Security/*`)
- Abuse-case regressions aligned with `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`

## Required commands
- `composer test`
- `composer test:contract`
- `composer test:security`
- `composer qa`
- `composer ops:health-smoke`
- `composer ops:migrate-smoke`

Smoke command semantics and evidence requirements are defined in `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`.

## Release verification scope
- Envelope stability
- Middleware decision/detail-code behavior (`slim/slim`, `respect/validation`, `neomerx/cors-psr7`, `symfony/rate-limiter`)
- Boot assertions and profile hardening
- JWT signing/verification and key safety (`firebase/php-jwt`, `ext-sodium`)
- Health endpoint and migration smoke
- Auth-context boundary smoke for gateway/console non-interchangeability

## Acceptance criteria enforcement
- Route acceptance intent is defined in `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` and is required during QA signoff.
- Authorization truth-table behavior is validated against `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`.
- Middleware detail-code behavior is validated against `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`.

## Stable QA script (manual)
- owner login + console list/create/moderation
- key login + feed/post/comments
- key lifecycle revoke confirmation path
- invite issuance path

## CI baseline gate contract
- Every architecture-upgrade PR executes `composer qa`, `composer test:contract`, `composer test:security`, and `composer ops:health-smoke` in CI.
- CI fails closed when any required command fails or is missing from the workflow.
- PR evidence links include command outputs or CI job URLs for all required commands.

## Surface-boundary verification contract
- Verification includes explicit non-interchangeability checks for gateway and console auth contexts.
- Security regression suites include token `typ` confusion, audience confusion, wrong-surface replay, and gateway device-binding mismatch scenarios.
- Boundary denials return canonical envelope errors with stable `error.code` and `details.code` mappings.
- Release candidates are blocked when cross-surface replay or boundary confusion tests pass unexpectedly.

## Upgrade-feature-flag verification
- `ARCH_PDP_ENABLED`, `ARCH_BFF_SPLIT_ENABLED`, and `ARCH_CQRS_LITE_ENABLED` default to `false` until slice activation evidence is approved.
- `ARCH_PROJECTION_ASYNC=true` requires projection lag and replay/idempotency evidence in the same validation run.
- `ARCH_POLICY_DECISION_LOG` output is retained in CI artifacts for policy regression triage during PDP rollout.

## PDP primitive verification contract
- UA-01 requires unit tests that verify invariants for `Decision`, `DecisionContext`, `Obligation`, and `PolicyRule`.
- UA-02 requires resolver matrix tests that prove deterministic route-to-`route_action` mapping for gateway and console surfaces.
- UA-03 requires owner-context tests that prove normalization and fail-closed handling for console actor claims.
- UA-04 requires key-context tests that prove gateway claim normalization, lineage/envelope input hydration, and fail-closed behavior for malformed key claims.
- UA-05 requires PDP invocation tests that prove deterministic `RuleRegistry` ordering and stable allow/deny decision shaping in `PdpService`.
- UA-06 requires owner-rule tests that prove owner-only console governance operations deny non-owner actors with canonical detail-code mappings.
- UA-07 requires gateway permission matrix tests that prove canonical route-action to permission enforcement for feed, posts, comments, and flags routes.
- UA-08 requires delegation-bound regression tests that prove subset/depth/expiry constraints and canonical deny mapping for bound violations.
- UA-09 requires use-key mutation negative-path tests that prove `use` keys cannot create/edit posts and preserve canonical deny detail codes.

- UA-10 requires keychain-invariant rule tests that prove class admission constraints, non-nesting enforcement, lifecycle-state exclusions, and membership-cap deny mappings.
- UA-11 requires master-key boundary tests that prove owner-only governance authority and gateway-surface deny behavior for `master` tokens.
- UA-12 requires device-binding decision tests that prove missing header, invalid format, missing claim, and mismatch outcomes map to canonical deny codes.


- UA-13 requires policy-table configuration integrity tests that fail startup on missing/duplicate route-action mappings and malformed policy table structures.
- UA-14 requires permission/detail-code externalization tests that fail startup on unknown permissions, missing route-action permission bindings, or missing deny detail-code mappings.
- UA-15 requires rule-registry composition tests that verify deterministic rule-pack ordering, immutable boot snapshots, and fail-closed behavior for composition drift.
- UA-16 requires gateway-read enforcement tests that prove `PolicyDecisionMiddleware` gates `GET /api/feed` and `GET /api/posts/{postId}/comments` on PDP allow outcomes.
- UA-17 requires gateway-write enforcement tests that prove PDP deny outcomes block write handlers for posts, flags, and comment creation with canonical detail-code stability.
- UA-18 requires console-governance enforcement tests that prove owner-context PDP evaluation and CSRF obligations gate key, invite, and keychain governance routes.
- UA-19 requires no-ad-hoc-authorization audit evidence proving protected handlers do not evaluate permission/delegation/key-class/owner-context/device-binding policy branches.
- UA-20 requires full SSOT synchronization checks for authorization spec, decision tables, middleware pipeline, error catalog, traceability matrix, and ADR linkage.
- UB-01 requires route-ownership verification that gateway controllers map only to `/api/*` route families and console controllers map only to `/console/api/*` route families.
- UB-02 requires BFF-wiring tests that verify gateway controllers depend on Gateway BFF services and console controllers depend on Console BFF services without cross-surface BFF calls.
- UB-03 requires DTO contract tests that verify gateway DTO/view-model schemas and console DTO/view-model schemas are isolated by surface and preserve canonical envelope/error semantics.
- UB-04 requires route-boot parity tests that prove `config/routes_public.php`, `config/routes_gateway.php`, and `config/routes_console.php` register only their canonical surface route families and fail closed on cross-surface registration drift.
- UB-05 requires gateway error-mapper regression tests that prove canonical HTTP/envelope/detail-code preservation for gateway deny/error flows and stable gateway UI state transitions.
- UB-06 requires console error-mapper parity tests that prove canonical HTTP/envelope/detail-code preservation with deterministic UI-runtime-compatible recovery hints for owner-governance error flows.
