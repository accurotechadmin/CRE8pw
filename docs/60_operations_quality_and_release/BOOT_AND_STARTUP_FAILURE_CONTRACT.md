---
doc_id: CRE8-OPS-BOOT-STARTUP-FAILURE-CONTRACT
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-15
source_seed_refs:
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - docs/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md
  - docs/60_operations_quality_and_release/HEALTH_ENDPOINT_CONTRACT.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Boot And Startup Failure Contract

## Normative requirements
- **CRE8-OPS-REQ-0028**: Startup **MUST** fail closed when required environment variables are missing or malformed.
- **CRE8-OPS-REQ-0029**: Startup **MUST** load environment values via `vlucas/phpdotenv` before constructing routing, policy, and persistence services.
- **CRE8-OPS-REQ-0030**: Startup failure responses and logs **MUST** emit deterministic `SYSTEM_STARTUP_FAILED` classification without exposing secret material.
- **CRE8-OPS-REQ-0031**: Startup **MUST NOT** mark readiness true until policy middleware, cryptographic services, and persistence connectivity checks complete.
- **CRE8-OPS-REQ-0032**: Startup decision order **MUST** be deterministic and documented as `config -> dependency wiring -> migration/read checks -> route mount -> readiness open`.

## Implementation-binding dependencies
- `vlucas/phpdotenv` **MUST** supply environment-loading semantics.
- `php-di/php-di` **MUST** enforce deterministic dependency wiring order.
- `slim/slim` **MUST** mount routes only after startup checks pass.
- `monolog/monolog` **MUST** capture startup failure evidence with correlation context.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-SSOT-COMMAND-EXIT-SEMANTICS` | Startup command chain returns non-zero on failure and zero only on fully ready completion. |
| `HOOK-SSOT-LINT-METADATA` | Ensures this contract remains in normative metadata compliance. |

Change Impact Map: [`reports/change_impact_maps/20260430-1246-P3-S9.1-P3-S9.4.md`](reports/change_impact_maps/20260430-1246-P3-S9.1-P3-S9.4.md).

## See also
- [Configuration Environment Contract](./CONFIGURATION_ENVIRONMENT_CONTRACT.md)
- [Health Endpoint Contract](./HEALTH_ENDPOINT_CONTRACT.md)
- [Request Pipeline and Middleware Contract](../10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md)
