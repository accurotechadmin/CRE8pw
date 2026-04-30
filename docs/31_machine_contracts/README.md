# `docs/31_machine_contracts/` — CRE8 Machine Contracts

This folder is the home of CRE8's **machine-readable contract layer**: the OpenAPI 3.1 specification, JSON Schema 2020-12 envelopes and payloads, and the prose↔OpenAPI parity table that binds them to the prose contract specs in `../30_contracts_and_interfaces/`.

Every active route in `../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md` MUST have a matching OpenAPI operation here, schemas for its request and success/error responses, and a parity-table row. CI enforces this via `composer docs:ssot:route-parity` and `composer phase2:acceptance-bundle`.

---

## 1. Inventory

```text
31_machine_contracts/
  README.md                          ← this file
  PROSE_OPENAPI_PARITY_TABLE.md      ← authoritative parity matrix and route family coverage policy
  openapi/
    cre8.v1.yaml                     ← OpenAPI 3.1 contract baseline
  schemas/
    success-envelope.schema.json     ← {data, meta} success envelope
    error-envelope.schema.json       ← {error, meta} error envelope (with required fields)
    policy-decision.schema.json      ← /v1/authz/decide request schema
    authz-decision-response.schema.json  ← /v1/authz/decide success envelope (allOf success)
    feed-items-response.schema.json  ← /v1/feed/items success envelope (data, ordering, cursor metadata)
    lifecycle-suspend-response.schema.json  ← /v1/keys/{key_id}/lifecycle/suspend success
    lifecycle-revoke-response.schema.json   ← /v1/keys/{key_id}/lifecycle/revoke success
```

---

## 2. Authoritative artifacts and what each one binds

| File | Binds | Updated together with |
|---|---|---|
| `openapi/cre8.v1.yaml` | Operation IDs, paths, methods, request/response schemas, examples for every active route. | `ROUTE_INVENTORY_REFERENCE.md`, `ERROR_CODE_CATALOG.md`, prose API guide, parity table. |
| `PROSE_OPENAPI_PARITY_TABLE.md` | Route-by-route parity rows, route family coverage policy, depth status, error code coverage, hook linkage. | Inventory, OpenAPI, traceability matrix, decision log, Phase 2 progress board. |
| `schemas/success-envelope.schema.json` | Stable success envelope `{data, meta}` with required `meta.request_id`, `meta.timestamp_utc`, `meta.contract_version`. | All success-bearing schemas via `allOf`. |
| `schemas/error-envelope.schema.json` | Stable error envelope `{error, meta}` with required `error.code`, `error.message`, `error.category`, `error.request_id`, `error.timestamp_utc`, optional `error.details[]`. | Error catalog, every error response across OpenAPI. |
| `schemas/policy-decision.schema.json` | `/v1/authz/decide` request body shape (`principal_id`, `action`, `resource_scope`, `request_context`). | OpenAPI authz examples, contract tests under `composer test:contract:auth`. |
| `schemas/authz-decision-response.schema.json` | `/v1/authz/decide` success envelope, `decision`, `decision_reason_code`, `evaluated_gate`. | Decision tables, deny mapping. |
| `schemas/feed-items-response.schema.json` | `/v1/feed/items` payload, `audience_labels`, `moderation_state`, `next_cursor`, `cursor_basis=published_utc_desc__item_id_asc`, `feed_metadata_schema_version`. | Feed ranking spec, content model, `composer test:contract:feed`. |
| `schemas/lifecycle-suspend-response.schema.json` and `lifecycle-revoke-response.schema.json` | Lifecycle transition success envelopes with `data.lifecycle_state` const. | Key lifecycle spec, lifecycle contract tests. |

---

## 3. Required parity invariants

These are restated from `PROSE_OPENAPI_PARITY_TABLE.md` for quick reference; the parity table is the canonical statement.

1. Every active inventory route has exactly one matching OpenAPI `path` + `method` tuple.
2. Every OpenAPI operation has matching prose entries in the inventory and the API contract guide.
3. Every error code referenced in OpenAPI examples is declared in `../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md`.
4. Feed and interaction deny examples enforce payload-shape semantics: canonical `error.code`, `error.category`, approved `request_id` prefix (`req-feed-`, `req-authz-`, `req-interact-`, `req-life-`, `req-ident-*`), and ISO-8601 `timestamp_utc`.
5. Every parity-table row maps to a `primary_requirement_id` in the traceability matrix and a `primary_hook_id` in the verification strategy.
6. Schema and example pairs MUST stay validatable: every request example validates against its schema (Phase 3 milestone M1 closes existing residual drift around `policy-decision.schema.json`).

---

## 4. Required tooling and verification

The minimum verification command set for any PR that changes files in this folder:

- `composer docs:ssot:route-parity`
- `composer docs:ssot:route-uniqueness`
- `composer docs:ssot:error-code-coverage`
- `composer docs:ssot:deprecation-schema`
- `composer docs:ssot:compat-declaration`
- `composer test:contract:auth`
- `composer test:contract:auth-reasons`
- `composer test:contract:feed`
- `composer test:contract:lifecycle`
- `composer test:contract:identity-issuance`
- `composer test:contract:identity-context`
- `composer test:contract:surface-parity`
- `composer phase2:acceptance-bundle`
- (Phase 3 M1 onward) `composer docs:ssot:openapi-lint`
- (Phase 3 M6 onward) `composer test:contract:request-schema`, `composer test:contract:response-schema`, `composer docs:ssot:schema-coverage`, `composer docs:ssot:example-coverage`

---

## 5. Required Change Impact Map (machine-artifact rule)

Any change to `openapi/cre8.v1.yaml`, any file under `schemas/`, or `PROSE_OPENAPI_PARITY_TABLE.md` MUST be accompanied by a Change Impact Map under `../../reports/change_impact_maps/<UTC>-<slice-id>.md` using `../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`. This is non-negotiable because machine-contract drift is the highest-cost regression class for this codebase.

---

## 6. Roadmap context

| Phase | Effect on this folder |
|---|---|
| Phase 1 (closed) | Initial OpenAPI baseline + JSON Schema set delivered for the five baseline routes. |
| Phase 2 (active) | Parity table and route-family coverage policy locked in; depth expansion across feed and lifecycle deny semantics. |
| Phase 3 M1 | Tier-1 fixes: OpenAPI `/v1/authz/decide` `examples` nesting; `policy-decision.schema.json` extended to validate every example. |
| Phase 3 M5 | Route inventory expansion (principals, keys, delegations, audience groups, posts/comments, audit, integrations) and matching machine artifacts. |
| Phase 3 M6 | Schema completeness pass, schema/example coverage hooks, contract version policy, request and response schema fixtures. |

See `../../reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` for the slice-level plan.

---

## 7. See also

- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Route Inventory Reference](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [Prose↔OpenAPI Parity Table](./PROSE_OPENAPI_PARITY_TABLE.md)
- [OpenAPI Contract v1](./openapi/cre8.v1.yaml)
- [JSON Schemas](./schemas/)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
