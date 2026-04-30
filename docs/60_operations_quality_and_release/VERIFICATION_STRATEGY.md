---
doc_id: CRE8-OPS-VERIFICATION-STRATEGY
version: 1.6.0
status: provisional-normative
owner: Operations Quality WG
reviewers:
  - Security WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-29
source_seed_refs:
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/00_governance/DEFINITION_OF_DONE.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md
  - docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md
---

# Verification Strategy

## Purpose
Define mandatory verification hook structure, execution policy, and evidence expectations for Phase 1 and Phase 2 normative contracts.

## Normative requirements
- **CRE8-OPS-REQ-0001**: Every normative or provisional-normative requirement **MUST** map to at least one verification hook recorded in `TRACEABILITY_MATRIX.md`.
- **CRE8-OPS-REQ-0002**: Each hook definition **MUST** declare `hook_id`, `trigger`, `tool_or_procedure`, `expected_result`, and `evidence_location`.
- **CRE8-OPS-REQ-0003**: Pull requests that modify requirement semantics **MUST** include verification execution evidence or explicit manual verification notes with reproducible steps.
- **CRE8-OPS-REQ-0004**: Hooks without automation **MUST** include a documented “next automation candidate” note and **MUST** be listed in `reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md` to support Slice 8 backlog reduction.
- **CRE8-OPS-REQ-0005**: Verification failures for `docs:ssot:lint`, `docs:ssot:sync-check`, or `docs:ssot:report` **MUST** block merge under `ssot_phase_gate`.

- **CRE8-OPS-REQ-0006**: Verification evidence for normative changes **MUST** include a reference to the applicable change-impact map artifact defined in `CHANGE_IMPACT_MAP_TEMPLATES.md`.
- **CRE8-OPS-REQ-0007**: CI workflows enforcing SSOT gates **MUST** execute the current phase acceptance-bundle command as an explicit hard-fail step.

- **CRE8-OPS-REQ-0008**: The repository **MUST** provide `composer docs:ssot:glossary-check` for glossary completeness and canonical-term presence checks bound to `HOOK-SSOT-GLOSSARY-COVERAGE`.

## Hook catalog schema
| Field | Required | Notes |
|---|---|---|
| hook_id | yes | Stable identifier (e.g., `HOOK-CONTRACT-POLICY-ORDER`). |
| trigger | yes | PR, release, nightly, or manual. |
| tool_or_procedure | yes | Command, script path, or step-by-step manual process. |
| expected_result | yes | Deterministic pass criteria. |
| evidence_location | yes | Artifact path or evidence template path. |
| next_automation_candidate | conditional | Required when verification mode is manual. |

## Phase 1 initial hooks
| hook_id | trigger | tool_or_procedure | expected_result | evidence_location | next_automation_candidate |
|---|---|---|---|---|---|
| HOOK-CONTRACT-POLICY-ORDER | PR | `composer test:contract:auth` | Deterministic pass/fail on order invariants | docs/evidence/templates/README.md | Implemented as `test:contract:auth` |
| HOOK-CONTRACT-ERROR-DETERMINISM | PR | `composer test:contract:error` | Stable envelope + code mapping | docs/evidence/templates/README.md | Implemented as `test:contract:error` |
| HOOK-CONTRACT-ERROR-SECRETS-REDACTION | PR | `composer test:contract:error-secrets` | OpenAPI error examples and descriptions contain no forbidden secret-leak tokens and include redacted 5xx example | docs/evidence/templates/README.md | Implemented as `test:contract:error-secrets` |
| HOOK-SSOT-LINT-METADATA | PR | `composer docs:ssot:lint` | Exit code 0 with no metadata/link failures | reports/ssot/coverage_latest.json |  |
| HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | PR | `composer docs:ssot:route-parity` | Method/path and route_id parity maintained with no undocumented drift | reports/ssot/coverage_latest.json; docs/evidence/templates/README.md | Implemented as `docs:ssot:route-parity` |
| HOOK-CONTRACT-ROUTE-UNIQUENESS | PR | `composer docs:ssot:route-uniqueness` | No duplicate IDs or method/path collisions | reports/ssot/coverage_latest.json; docs/evidence/templates/README.md | Implemented as `docs:ssot:route-uniqueness` |
| HOOK-CONTRACT-COMPAT-DECLARATION | PR | `composer docs:ssot:compat-declaration` | Compatibility class/migration/deprecation clauses are present in canonical API guide | reports/ssot/coverage_latest.json; docs/evidence/templates/README.md | Implemented as `docs:ssot:compat-declaration` |
| HOOK-CONTRACT-ERROR-CODE-COVERAGE | PR | `composer docs:ssot:error-code-coverage` | Every route inventory error code resolves to a canonical code in `ERROR_CODE_CATALOG.md` | reports/ssot/coverage_latest.json; docs/evidence/templates/README.md | Implemented as `docs:ssot:error-code-coverage` |
| HOOK-CONTRACT-DEPRECATION-SCHEMA | PR | `composer docs:ssot:deprecation-schema` | Every `deprecated`/`sunset` route includes `sunset_utc` and valid `replacement_route_id` format | reports/ssot/coverage_latest.json; docs/evidence/templates/README.md | Implemented as `docs:ssot:deprecation-schema` |
| HOOK-CONTRACT-FEED-ORDER-CURSOR | PR | `composer test:contract:feed` | Feed fixtures include deterministic ordering, tie-case behavior (`published_utc` tie => ascending `item_id`), and cursor semantics (`published_utc_desc__item_id_asc`; cursor points at final returned row) | reports/ssot/coverage_latest.json; docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md | Implemented as `test:contract:feed` |
| HOOK-CONTRACT-FEED-CURSOR-MULTIPAGE-MONOTONIC | PR | `composer test:contract:feed` | Sequential feed fixture pages preserve strict cursor monotonicity (`page2.input_cursor == page1.next_cursor`; `page2.next_cursor` older than page1 cursor basis order) | reports/ssot/coverage_latest.json; docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md | Implemented as `test:contract:feed` |
| HOOK-CONTRACT-FEED-CURSOR-GRAMMAR | PR | `composer test:contract:feed` | Feed cursor fixtures parse under `pub:<ISO8601 UTC>|<item_id>` grammar and enforce executable linkage checks (`page2.input_cursor == page1.next_cursor`) | reports/ssot/coverage_latest.json; docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md | Implemented as `test:contract:feed` |
| HOOK-CONTRACT-FEED-DENY-CODE-CATALOG | PR | `composer test:contract:feed` | Feed/interaction deny examples in OpenAPI resolve only to canonical error codes listed in `ERROR_CODE_CATALOG.md` and enforce example-level payload-shape semantics (`error.code`, `error.category`, `request_id` prefix, `timestamp_utc` ISO-8601 UTC), including lifecycle deny code coverage (`AUTH_LIFECYCLE_BLOCKED`) | reports/ssot/coverage_latest.json; docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md | Implemented as `test:contract:feed` |
| HOOK-AUTH-DECISION-REASON-MAPPING | PR | `composer test:contract:auth-reasons` | One-to-one reason/code mapping with no unmapped deny reason | docs/evidence/templates/README.md | Implemented as `test:contract:auth-reasons` |
| HOOK-SEC-LIFECYCLE-PROPAGATION | PR | `composer test:contract:lifecycle` | Runtime lifecycle propagation deny coverage requires lifecycle suspend/revoke route fixtures plus interaction lifecycle-blocked deny fixtures and parity hook linkage checks. | reports/ssot/coverage_latest.json; reports/session_handoffs/LATEST_SESSION_HANDOFF.md | Implemented as `test:contract:lifecycle` |
| HOOK-EXT-SEAM-COMPATIBILITY | PR | `composer docs:ssot:sync-check` | Trace row for seam compatibility exists and verification mode is `automated` | reports/ssot/coverage_latest.json | Extend with module seam contract fixture suite |
| HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | PR | `composer phase2:acceptance-bundle` | Bundle hard-fails on any failed SSOT/contract command in Phase 2 acceptance command contract | reports/ssot/coverage_latest.json; reports/session_handoffs/LATEST_SESSION_HANDOFF.md | Implemented as `phase2:acceptance-bundle` |
| HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA | PR | `composer docs:ssot:phase2-exceptions-check` | Unresolved exceptions register rows satisfy ID/status/due-date/decision-ref schema, decision-log/ADR existence checks, closed-row progress-board linkage, and open/blocked command obligations | reports/ssot/coverage_latest.json; docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md | Implemented as `docs:ssot:phase2-exceptions-check` |


| HOOK-SSOT-GLOSSARY-COVERAGE | PR | `composer docs:ssot:glossary-check` | Glossary contains at least 50 canonical terms and required anchor terms for Phase 3 M3.1 | reports/ssot/coverage_latest.json; docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md | Implemented as `docs:ssot:glossary-check` |


| HOOK-DATA-MODEL-COVERAGE | PR | Manual schema/ERD conformance walkthrough against DATA_MODEL_SPEC.md, DATA_MODEL_REFERENCE.md, and ERD.md | All CRE8-DATA-REQ-0001..0018 rows verified with no schema/relationship drift | docs/evidence/templates/README.md | Implement automated `composer test:data:model` in P3-S7.4 |

| HOOK-SEC-THREAT-CONTROL-MATRIX | PR | Manual threat-control matrix review across SECURITY_CONTROLS_SPEC.md, SECURITY_HEADERS_AND_CSP_POLICY.md, and SECURITY_THREAT_MODEL.md | Every CRE8-SEC-REQ-0001..0010 row has mapped control evidence and no orphan threat rows | docs/evidence/templates/README.md | Implement automated `composer test:security:threat-controls` in P3-S11.2 |

## See also
- [Definition of Done](../00_governance/DEFINITION_OF_DONE.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [SSOT Automation and Linting](../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md)
- [Phase 1 Manual Hook Backlog](../../reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md)
- [Phase 2 Acceptance Criteria](./PHASE2_ACCEPTANCE_CRITERIA.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
