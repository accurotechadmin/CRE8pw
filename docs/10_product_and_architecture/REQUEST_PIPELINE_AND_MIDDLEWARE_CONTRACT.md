---
doc_id: CRE8-ARCH-REQUEST-PIPELINE
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - API Contracts WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md
  - docs/10_product_and_architecture/DEPENDENCY_BASELINE.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
---

# Request Pipeline And Middleware Contract

## Normative requirements
- **CRE8-ARCH-REQ-0031**: The runtime request pipeline **MUST** execute in this order: transport/security headers, request-id correlation, input parsing, authentication proof verification, authorization decision gate, handler execution, envelope rendering, and structured error mapping. This ordering is enforced by `slim/slim` middleware sequencing and `slim/psr7` immutable message flow.
- **CRE8-ARCH-REQ-0032**: Protected routes **MUST** deny before handler invocation when authentication or authorization fails. Handlers **MUST NOT** perform independent allow/deny branching. This behavior is enforced by `slim/slim` middleware dispatch and policy evaluation contract binding.
- **CRE8-ARCH-REQ-0033**: Authentication middleware **MUST** validate `public_key_id`, `timestamp`, `nonce`, and `signature` before authorization middleware executes. Validation logic is enforced by `ext-sodium` cryptographic primitives and `respect/validation` request validation constraints.
- **CRE8-ARCH-REQ-0034**: Authorization middleware **MUST** call the centralized policy decision point once per protected request and **MUST** preserve the machine-readable deny reason for downstream error mapping. This behavior is enforced by `php-di/php-di` composition-root wiring and contract verification via `phpunit/phpunit`.
- **CRE8-ARCH-REQ-0035**: Error mapping middleware **MUST** transform policy deny reasons into canonical error codes defined by [`ERROR_CODE_CATALOG.md`](ERROR_CODE_CATALOG.md) without remapping in route handlers. This behavior is enforced by `slim/slim` global error middleware and `phpunit/phpunit` contract tests.
- **CRE8-ARCH-REQ-0036**: Successful responses **MUST** emit the canonical `{data, meta}` envelope and denied/failed responses **MUST** emit `{error, meta}` with `meta.request_id` continuity. This behavior is enforced by `slim/psr7` response immutability and route-contract tests in `phpunit/phpunit`.
- **CRE8-ARCH-REQ-0037**: Pipeline components **MUST** emit structured audit/application logs containing the shared correlation/request identifier at each security-significant stage. This behavior is enforced by `monolog/monolog`; no additional Composer dependency is required.

## Deterministic middleware contract

| Stage | Purpose | Failure class | Enforcing dependency |
|---|---|---|---|
| Transport/security headers | Apply baseline response hardening and CORS policy | `SYSTEM_*` | `neomerx/cors-psr7`, `slim/slim` |
| Correlation setup | Ensure per-request stable `request_id` | `SYSTEM_*` | `slim/psr7`, `monolog/monolog` |
| Input parsing/validation | Validate required fields and shapes | `INPUT_*` | `respect/validation`, `slim/psr7` |
| Authentication proof verify | Verify signature/timestamp/nonce | `AUTHN_*` | `ext-sodium`, `firebase/php-jwt` |
| Authorization decision | Resolve allow/deny from PDP | `AUTH_DENY_*` | `php-di/php-di`, `slim/slim` |
| Handler execution | Apply business side-effects only | route-specific | `slim/slim` |
| Envelope + error rendering | Emit canonical response contract | all | `slim/psr7`, `slim/slim` |

## Prohibited behaviors
- Handler-local authorization branching.
- Handler-local remapping of canonical deny reasons.
- Mutation of `request_id` between middleware stages.
- Bypassing middleware chain for protected routes.

## Requirement triads (actor/trigger/precondition/outcome)

| Requirement | Actor | Trigger | Preconditions | Required outcome |
|---|---|---|---|---|
| CRE8-ARCH-REQ-0031 | Runtime middleware orchestrator | Any HTTP request enters canonical API surface | Middleware stack initialized and route resolution succeeded | Runtime executes middleware stages in declared order before response emission. |
| CRE8-ARCH-REQ-0032 | Authorization middleware + route handler runtime | Request targets a protected route | Authentication and authorization checks have executed | Runtime denies before handler invocation when auth fails; handlers MUST NOT perform independent allow/deny logic. |
| CRE8-ARCH-REQ-0033 | Authentication middleware | Protected request reaches authentication stage | Request includes authn proof fields and parser stage completed | Middleware validates `public_key_id`, `timestamp`, `nonce`, and `signature` before any authorization decision stage. |
| CRE8-ARCH-REQ-0034 | Authorization middleware | Protected request reaches authorization stage | Authentication stage succeeded and policy engine is available | Middleware performs exactly one centralized policy decision call and preserves deny reason for error mapping. |
| CRE8-ARCH-REQ-0035 | Error mapping middleware | Middleware stack receives deny/failure result | Canonical deny reason code exists in catalog mapping | Runtime maps deny reason to canonical error code without handler remapping. |
| CRE8-ARCH-REQ-0036 | Response envelope middleware | Handler or deny path completes | Request has stable `meta.request_id` context | Runtime emits canonical success/error envelope and preserves `meta.request_id` continuity. |
| CRE8-ARCH-REQ-0037 | Pipeline logging components | Security-significant middleware stage executes | Correlation ID has been established | Runtime emits structured logs containing shared correlation/request identifier at each stage. |

## See also
- [`docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`](docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md)
- [`docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md`](docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md)
- [`docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`](docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)

## Change history
- 2026-04-30 (v1.0.0): Initial normative publication for Phase 3 slices P3-S3.3/P3-S3.5/P3-S3.6. Change Impact Map: [[`reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md`](reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md)](../../reports/change_impact_maps/20260430-1305-P3-S3.3-P3-S3.5-P3-S3.6.md).
