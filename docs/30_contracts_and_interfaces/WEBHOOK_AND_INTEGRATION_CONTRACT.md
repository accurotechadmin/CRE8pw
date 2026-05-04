---
doc_id: CRE8-CONTRACTS-WEBHOOK-INTEGRATION
version: 1.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Security WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md
normative_dependencies:
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md
---

# Webhook And Integration Contract

## Purpose
Specify deterministic outbound webhook and inbound integration obligations for CRE8 external system interoperability.

## Normative requirements
- **CRE8-CONTRACT-REQ-0067**: All outbound webhook deliveries MUST be signed with detached signatures over canonical payload bytes and delivery metadata; signature generation/verification semantics MUST be compatible with `ext-sodium`.
- **CRE8-CONTRACT-REQ-0068**: Webhook authentication tokens, when used, MUST be JWTs with explicit expiry and audience claims; token verification contract is enforced by `firebase/php-jwt`.
- **CRE8-CONTRACT-REQ-0069**: Outbound delivery clients MUST enforce bounded retry policy with idempotency key reuse across retries and exponential backoff; HTTP transport behavior is enforced by `guzzlehttp/guzzle` and replay-safe persistence guarantees by `ext-pdo`.
- **CRE8-CONTRACT-REQ-0070**: Inbound integration endpoints MUST validate payload schema before business handling and MUST fail with canonical `INPUT_*` codes for schema violations; this behavior is enforced by `respect/validation` + `slim/slim` middleware.
- **CRE8-CONTRACT-REQ-0071**: Integration failures MUST emit observability events containing request_id, integration_id, failure_class, and retry_state; event emission dependency is `monolog/monolog`.

## Contract tables

| Topic | Requirement | Notes |
|---|---|---|
| Delivery authenticity | Detached signature + optional JWT | Required for all protected integrations |
| Retry behavior | Exponential backoff + idempotency key reuse | Prevent duplicate side effects |
| Error mapping | Canonical `INPUT_*`, `AUTHN_*`, `SYSTEM_*` families | Must align with error catalog |
| Observability | Structured integration event logging | Required for release evidence |

## Verification hooks
- **HOOK-CONTRACT-COMPAT-DECLARATION**: Validates compatibility declarations when integration contract behavior changes.
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE**: Validates webhook/integration error codes remain catalog-declared.

## See also
- [API Contract Guide](./API_CONTRACT_GUIDE.md)
- [Error Code Catalog](./ERROR_CODE_CATALOG.md)
- [Extensibility Module Boundaries](../70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)

Change Impact Map: [[`reports/change_impact_maps/20260430-1135-P3-S5.1-P3-S5.2.md`](reports/change_impact_maps/20260430-1135-P3-S5.1-P3-S5.2.md)](../../reports/change_impact_maps/20260430-1135-P3-S5.1-P3-S5.2.md)
