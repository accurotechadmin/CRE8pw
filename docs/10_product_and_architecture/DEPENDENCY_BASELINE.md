---
doc_id: CRE8-ARCH-DEPENDENCY-BASELINE
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - Security Engineering WG
  - Operations Quality WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-15
source_seed_refs:
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - seed/CRE8_REPO_STUDY_REPORT.md
normative_dependencies:
  - composer.json
  - docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Dependency Baseline

## Normative requirements
- **CRE8-ARCH-REQ-0020**: Runtime HTTP request handling **MUST** use `slim/slim` + `slim/psr7`; alternative frameworks **MUST NOT** be introduced without a superseding ADR.
- **CRE8-ARCH-REQ-0021**: Dependency injection for service construction **MUST** use `php-di/php-di` and **MUST** avoid ad-hoc global singletons.
- **CRE8-ARCH-REQ-0022**: Credential signature and token verification logic **MUST** use `firebase/php-jwt` and `ext-sodium` for cryptographic primitives; deprecated algorithms **MUST NOT** be used.
- **CRE8-ARCH-REQ-0023**: Persistence-facing behavior **MUST** target `ext-pdo` abstractions and **MUST** preserve deterministic error mapping for database failures.
- **CRE8-ARCH-REQ-0024**: Input contract validation **MUST** use `respect/validation` for declarative constraints used by policy and contract checks.
- **CRE8-ARCH-REQ-0025**: Environment bootstrapping **MUST** resolve configuration via `vlucas/phpdotenv`; direct ad-hoc environment parsing **MUST NOT** replace it.
- **CRE8-ARCH-REQ-0026**: Outbound HTTP integration client behavior **MUST** be implemented with `guzzlehttp/guzzle` when machine-to-machine requests are required.
- **CRE8-ARCH-REQ-0027**: CORS policy enforcement **MUST** use `neomerx/cors-psr7` for middleware-level header control.
- **CRE8-ARCH-REQ-0028**: Logging adapters **MUST** use `monolog/monolog` and map deterministic severity semantics.
- **CRE8-ARCH-REQ-0029**: Rate-limiting and cache-backed policy controls **MUST** use `symfony/rate-limiter` and `symfony/cache` where those controls are declared.
- **CRE8-ARCH-REQ-0030**: Contract and acceptance verification suites **MUST** execute with `phpunit/phpunit` and Composer script wiring.

## See also
- [Architecture And Surfaces](./ARCHITECTURE_AND_SURFACES.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)


## Change history
- 2026-04-30 (v1.0.0): Initial normative publication under Phase 3 slices P3-S3.2/P3-S3.4. Change Impact Map: [`reports/change_impact_maps/20260430-1200-P3-S3.2-P3-S3.4.md`](../../reports/change_impact_maps/20260430-1200-P3-S3.2-P3-S3.4.md).
