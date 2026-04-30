---
doc_id: CRE8-CONTRACTS-ENDPOINT-EXAMPLES
version: 1.0.0
status: provisional-normative
owner: API Contracts WG
reviewers:
  - Platform Architecture WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md
normative_dependencies:
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
  - docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md
---

# Endpoint Examples All Routes

## Purpose
Define deterministic example obligations for every declared CRE8 route so implementation and validation teams can prove envelope, deny, and parity behavior without inferring missing contract details.

## Normative requirements
- **CRE8-CONTRACT-REQ-0060**: Every route declared in `ROUTE_INVENTORY_REFERENCE.md` MUST include at least one canonical success example and one canonical error example in this document; if a route is public-only and deny semantics are inapplicable, this document MUST explicitly mark the route as `deny_not_applicable`.
- **CRE8-CONTRACT-REQ-0061**: Every success example MUST use the stable `{data, meta}` envelope and every error example MUST use the stable `{error, meta}` envelope; envelope structure is enforced by `slim/psr7` response serialization boundaries and validated through `phpunit/phpunit` contract packs.
- **CRE8-CONTRACT-REQ-0062**: Every deny example for delegated routes MUST map to a canonical code from `ERROR_CODE_CATALOG.md` and MUST include the gate reason (`permission`, `scope`, `explicit_deny`, `depth`, `lifecycle`, or `expiry`) that aligns with the authorization gate order enforced by `slim/slim` middleware and validated by `phpunit/phpunit` suites.
- **CRE8-CONTRACT-REQ-0063**: Example request payloads MUST include only schema-declared fields and MUST reject undeclared fields; this behavior is enforced by request-schema validation policy (`respect/validation`) and verified via schema contract tests in `phpunit/phpunit`.
- **CRE8-CONTRACT-REQ-0064**: Every example carrying key-proof inputs MUST include deterministic placeholders for `public_key_id`, `nonce`, `ts`, and `signature`; cryptographic placeholder semantics are bound to `ext-sodium` and `firebase/php-jwt` verification contracts.

## Example coverage matrix

| Route family | Required example set | Dependency baseline |
|---|---|---|
| Public/bootstrap | success + validation error | `slim/slim`, `slim/psr7`, `respect/validation` |
| Authz decision | success + each deny-reason family | `slim/slim`, `phpunit/phpunit` |
| Identity issuance/context | success + lifecycle deny + scope deny | `ext-sodium`, `ext-pdo`, `phpunit/phpunit` |
| Feed/content interactions | success + permission deny + lifecycle deny | `slim/slim`, `ext-pdo`, `phpunit/phpunit` |

## Authoring and sync rules
- **CRE8-CONTRACT-REQ-0065**: Example IDs in this document MUST use format `EX-<route-family>-<route-slug>-<variant>` and MUST be unique; uniqueness is validated by `phpunit/phpunit` parser checks (manual fallback: none).
- **CRE8-CONTRACT-REQ-0066**: Any example change that modifies route behavior MUST be updated in the same change set as corresponding OpenAPI examples in `docs/31_machine_contracts/openapi/cre8.v1.yaml`; if no machine artifact update is required, the change MUST state `machine_artifact_change: none` in PR/session evidence (enforced by process governance; no direct Composer dependency applies).

## Verification hooks
- **HOOK-CONTRACT-EXAMPLE-COVERAGE**: Verifies one success + one error example exists for every route inventory row and validates example ID uniqueness.
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE**: Verifies example error codes are catalog-declared.
- **HOOK-CONTRACT-SCHEMA-COVERAGE**: Verifies example payload fields are schema-conformant.

## See also
- [API Contract Guide](./API_CONTRACT_GUIDE.md)
- [Route Inventory Reference](./ROUTE_INVENTORY_REFERENCE.md)
- [Error Code Catalog](./ERROR_CODE_CATALOG.md)
- [OpenAPI Contract](../31_machine_contracts/openapi/cre8.v1.yaml)
- [Prose↔OpenAPI Parity Table](../31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md)

Change Impact Map: [`reports/change_impact_maps/20260430-1135-P3-S5.1-P3-S5.2.md`](../../reports/change_impact_maps/20260430-1135-P3-S5.1-P3-S5.2.md)
