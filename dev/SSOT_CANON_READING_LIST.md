# CRE8 SSOT canon reading list (developers)

_Last updated (UTC): 2026-05-05_

## Purpose

This list is the **sequential developer-facing reading path** through every repository document that still carries **normative or operational specification value** for implementing and evolving the CRE8 application platform. Session transcripts, phase execution logs, handoffs, and most material under `reports/` are **not** listed here; they remain useful for program history but are not SSOT for product behavior (see [`docs/00_governance/SSOT_INDEX.md`](../docs/00_governance/SSOT_INDEX.md)).

## How to use this list

- Read **in order** the first time; later, use section headings as a domain index.
- Prefer **`docs/`** for authoritative requirements; **`seed/`** is provenance and baseline context where noted.
- **`reports/`** is informational unless governance explicitly promotes an artifact.

---

## 1. Repository anchors

| Order | Document | Role |
|---:|---|---|
| 1.1 | [`README.md`](../README.md) | Project SSOT anchor; repository map and shortest canonical reading order. |
| 1.2 | [`docs/README.md`](../docs/README.md) | Hub for the numbered domain layout under `docs/`. |
| 1.3 | [`CRE8_EXPERT_SSOT_BOOT_PROMPT.md`](CRE8_EXPERT_SSOT_BOOT_PROMPT.md) | Optional paste-first message for expert coding LLM sessions; orients the model to this list and `REFERENCE_MAINTENANCE_SOP.md`. |
| 1.4 | [`SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`](SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md) | Primary phased milestones (**M0**–**M12** plus **M6b**) and delivery slices for engineering work keyed to this reading list (**development planning**, not normative SSOT under `docs/`). Includes appendix mapping each **§** of this list to milestones, **`seed/`** alignment rules, and **`REFERENCE_MAINTENANCE_SOP.md`** maintenance triggers. |

---

## 2. Governance, authoring, and change control (`docs/00_governance/`)

| Order | Document | Role |
|---:|---|---|
| 2.1 | [`SSOT_INDEX.md`](../docs/00_governance/SSOT_INDEX.md) | Canon topology, precedence (`README` → `docs/` → `reports/`), SSOT map. |
| 2.2 | [`DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`](../docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md) | Metadata headers, requirement ID format, authoring rules. |
| 2.3 | [`DOCUMENT_STATUS_AND_OWNERSHIP.md`](../docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md) | Ownership and promotion expectations. |
| 2.4 | [`CONTRIBUTION_WORKFLOW_SSOT.md`](../docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md) | How canonical changes flow through review and SSOT discipline. |
| 2.5 | [`CHANGE_CONTROL_POLICY.md`](../docs/00_governance/CHANGE_CONTROL_POLICY.md) | Normative change proposal and acceptance rules. |
| 2.6 | [`DEFINITION_OF_DONE.md`](../docs/00_governance/DEFINITION_OF_DONE.md) | Merge-ready gates for normative work. |
| 2.7 | [`CROSS_DOCUMENT_LINKING_POLICY.md`](../docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md) | Stable linking and dependency declarations across docs. |

---

## 3. Product, terminology, and architecture (`docs/10_product_and_architecture/`)

| Order | Document | Role |
|---:|---|---|
| 3.1 | [`CANONICAL_TERMINOLOGY.md`](../docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md) | Shared vocabulary for all domains. |
| 3.2 | [`ARCHITECTURE_AND_SURFACES.md`](../docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md) | System boundaries and surfaces. |
| 3.3 | [`CRE8_PRODUCT_AND_SYSTEM_SPEC.md`](../docs/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md) | Core product and system specification. |
| 3.4 | [`REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`](../docs/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md) | Request path and middleware obligations. |
| 3.5 | [`DEPENDENCY_BASELINE.md`](../docs/10_product_and_architecture/DEPENDENCY_BASELINE.md) | Allowed dependency posture. |
| 3.6 | [`ID_UTILITY_KEYPAIR_MODEL_SPEC.md`](../docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md) | Identity / utility keypair model. |
| 3.7 | [`CRE8_HUMAN_OPERATING_MODEL.md`](../docs/10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md) | Human-facing operating model aligned to the platform. |

---

## 4. Identity, delegation, and authorization (`docs/20_identity_delegation_and_policy/`)

| Order | Document | Role |
|---:|---|---|
| 4.1 | [`AUTHORIZATION_AND_DELEGATION_SPEC.md`](../docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md) | Core authorization and delegation spec. |
| 4.2 | [`PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](../docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md) | Principal types and capabilities. |
| 4.3 | [`PERMISSION_VOCABULARY.md`](../docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md) | Permission vocabulary. |
| 4.4 | [`KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md`](../docs/20_identity_delegation_and_policy/KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md) | Keychain composition and resolution. |
| 4.5 | [`DELEGATION_STATE_MACHINE.md`](../docs/20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md) | Delegation lifecycle states. |
| 4.6 | [`AUTHORIZATION_DECISION_TABLES.md`](../docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md) | Decision tables for authz outcomes. |
| 4.7 | [`USAGE_SCENARIOS_AND_PERMISSION_STORIES.md`](../docs/20_identity_delegation_and_policy/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md) | Scenarios and permission narratives. |

---

## 5. API contracts, routes, errors, and clients (`docs/30_contracts_and_interfaces/`)

| Order | Document | Role |
|---:|---|---|
| 5.1 | [`API_CONTRACT_GUIDE.md`](../docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md) | API shape, envelopes, conventions. |
| 5.2 | [`ROUTE_INVENTORY_REFERENCE.md`](../docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md) | Authoritative route inventory. |
| 5.3 | [`ERROR_CODE_CATALOG.md`](../docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md) | Error codes and semantics. |
| 5.4 | [`Endpoint_Examples_All_Routes.md`](../docs/30_contracts_and_interfaces/Endpoint_Examples_All_Routes.md) | Examples across routes. |
| 5.5 | [`WEBHOOK_AND_INTEGRATION_CONTRACT.md`](../docs/30_contracts_and_interfaces/WEBHOOK_AND_INTEGRATION_CONTRACT.md) | Webhooks and integrations. |
| 5.6 | [`UI_RUNTIME_CONTRACT.md`](../docs/30_contracts_and_interfaces/UI_RUNTIME_CONTRACT.md) | UI/runtime expectations vs API parity. |

---

## 6. Machine-readable contracts (`docs/31_machine_contracts/`)

| Order | Document | Role |
|---:|---|---|
| 6.1 | [`README.md`](../docs/31_machine_contracts/README.md) | How OpenAPI, schemas, and parity tooling fit together. |
| 6.2 | [`CONTRACT_VERSION_POLICY.md`](../docs/31_machine_contracts/CONTRACT_VERSION_POLICY.md) | Versioning and compatibility. |
| 6.3 | [`openapi/cre8.v1.yaml`](../docs/31_machine_contracts/openapi/cre8.v1.yaml) | Primary OpenAPI specification (YAML). |
| 6.4 | `docs/31_machine_contracts/schemas/*.schema.json` | JSON Schemas for payloads and envelopes (read alongside the README). |
| 6.5 | [`PROSE_OPENAPI_PARITY_TABLE.md`](../docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md) | Prose ↔ OpenAPI parity mapping. |

---

## 7. Security, cryptography, and data (`docs/40_data_security_and_crypto/`)

| Order | Document | Role |
|---:|---|---|
| 7.1 | [`KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md`](../docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md) | Keys and cryptographic lifecycle. |
| 7.2 | [`CRYPTO_PROFILE.md`](../docs/40_data_security_and_crypto/CRYPTO_PROFILE.md) | Approved algorithms and parameters. |
| 7.3 | [`SECURITY_THREAT_MODEL.md`](../docs/40_data_security_and_crypto/SECURITY_THREAT_MODEL.md) | Threat model. |
| 7.4 | [`SECURITY_CONTROLS_SPEC.md`](../docs/40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md) | Control obligations. |
| 7.5 | [`SECURITY_HEADERS_AND_CSP_POLICY.md`](../docs/40_data_security_and_crypto/SECURITY_HEADERS_AND_CSP_POLICY.md) | HTTP security headers and CSP. |
| 7.6 | [`SECURITY_VERIFICATION_ABUSE_CASES.md`](../docs/40_data_security_and_crypto/SECURITY_VERIFICATION_ABUSE_CASES.md) | Abuse-case-driven verification. |
| 7.7 | [`DATA_MODEL_SPEC.md`](../docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md) | Data model specification. |
| 7.8 | [`DATA_MODEL_REFERENCE.md`](../docs/40_data_security_and_crypto/DATA_MODEL_REFERENCE.md) | Reference detail for entities and fields. |
| 7.9 | [`ERD.md`](../docs/40_data_security_and_crypto/ERD.md) | Entity-relationship view. |

---

## 8. Content, audience, and feed (`docs/50_content_audience_and_feed/`)

| Order | Document | Role |
|---:|---|---|
| 8.1 | [`CONTENT_MODEL_AND_TARGETING_SPEC.md`](../docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md) | Content model and targeting. |
| 8.2 | [`AUDIENCE_GROUP_SPEC.md`](../docs/50_content_audience_and_feed/AUDIENCE_GROUP_SPEC.md) | Audience groups. |
| 8.3 | [`FEED_RANKING_AND_ORDERING_RULES.md`](../docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md) | Feed ordering rules. |
| 8.4 | [`COMMENTING_AND_INTERACTION_POLICY.md`](../docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md) | Commenting and interactions. |

---

## 9. Operations, quality, release, and runtime contracts (`docs/60_operations_quality_and_release/`)

| Order | Document | Role |
|---:|---|---|
| 9.1 | [`VERIFICATION_STRATEGY.md`](../docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md) | Verification hooks and strategy. |
| 9.2 | [`CONFIGURATION_ENVIRONMENT_CONTRACT.md`](../docs/60_operations_quality_and_release/CONFIGURATION_ENVIRONMENT_CONTRACT.md) | Configuration and environments. |
| 9.3 | [`HEALTH_ENDPOINT_CONTRACT.md`](../docs/60_operations_quality_and_release/HEALTH_ENDPOINT_CONTRACT.md) | Health endpoints. |
| 9.4 | [`BOOT_AND_STARTUP_FAILURE_CONTRACT.md`](../docs/60_operations_quality_and_release/BOOT_AND_STARTUP_FAILURE_CONTRACT.md) | Startup failure semantics. |
| 9.5 | [`OPERATIONAL_SMOKE_CHECK_CONTRACT.md`](../docs/60_operations_quality_and_release/OPERATIONAL_SMOKE_CHECK_CONTRACT.md) | Operational smoke expectations. |
| 9.6 | [`OBSERVABILITY_EVENT_CATALOG.md`](../docs/60_operations_quality_and_release/OBSERVABILITY_EVENT_CATALOG.md) | Events and observability. |
| 9.7 | [`MIGRATION_AND_SEED_STRATEGY.md`](../docs/60_operations_quality_and_release/MIGRATION_AND_SEED_STRATEGY.md) | Migrations and seeding approach. |
| 9.8 | [`RELEASE_CHECKLIST.md`](../docs/60_operations_quality_and_release/RELEASE_CHECKLIST.md) | Release checklist. |
| 9.9 | [`PRODUCTION_READINESS_GATES.md`](../docs/60_operations_quality_and_release/PRODUCTION_READINESS_GATES.md) | Production readiness gates. |
| 9.10 | [`SLO_SLI_SPEC.md`](../docs/60_operations_quality_and_release/SLO_SLI_SPEC.md) | SLO/SLI definitions. |
| 9.11 | [`ACCEPTANCE_CRITERIA_MATRIX.md`](../docs/60_operations_quality_and_release/ACCEPTANCE_CRITERIA_MATRIX.md) | Cross-cutting acceptance criteria. |
| 9.12 | [`PHASE2_ACCEPTANCE_CRITERIA.md`](../docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md) | Phase 2 acceptance criteria (still referenced by verification tooling). |
| 9.13 | [`PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md`](../docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md) | Documented exceptions register for phase gates. |

---

## 10. Extensibility and modules (`docs/70_extensibility_and_module_patterns/`)

| Order | Document | Role |
|---:|---|---|
| 10.1 | [`MODULE_BOUNDARIES_AND_OWNERSHIP.md`](../docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md) | Module boundaries and ownership. |
| 10.2 | [`EXTENSIBILITY_PLAYBOOK.md`](../docs/70_extensibility_and_module_patterns/EXTENSIBILITY_PLAYBOOK.md) | How to extend safely. |
| 10.3 | [`POST_TYPE_EXTENSION_SPEC.md`](../docs/70_extensibility_and_module_patterns/POST_TYPE_EXTENSION_SPEC.md) | Post-type extensions. |
| 10.4 | [`PRINCIPAL_TYPE_EXTENSION_SPEC.md`](../docs/70_extensibility_and_module_patterns/PRINCIPAL_TYPE_EXTENSION_SPEC.md) | Principal-type extensions. |
| 10.5 | [`INTEGRATION_PROVIDER_PATTERN.md`](../docs/70_extensibility_and_module_patterns/INTEGRATION_PROVIDER_PATTERN.md) | Integration provider pattern. |

---

## 11. Traceability, decisions, and program controls (`docs/80_traceability_decisions_and_program/`)

| Order | Document | Role |
|---:|---|---|
| 11.1 | [`TRACEABILITY_MATRIX.md`](../docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md) | Requirements ↔ hooks ↔ evidence spine. |
| 11.2 | [`ADR_INDEX.md`](../docs/80_traceability_decisions_and_program/ADR_INDEX.md) | Architecture decision record index. |
| 11.3 | [`records/ADR-001-requirement-id-normalization.md`](../docs/80_traceability_decisions_and_program/records/ADR-001-requirement-id-normalization.md) | ADR 001. |
| 11.4 | [`records/ADR-002-traceability-matrix-minimum-schema.md`](../docs/80_traceability_decisions_and_program/records/ADR-002-traceability-matrix-minimum-schema.md) | ADR 002. |
| 11.5 | [`records/ADR-003-phase1-freeze-waiver.md`](../docs/80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md) | ADR 003. |
| 11.6 | [`records/ADR-004-phase3-program-charter.md`](../docs/80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md) | ADR 004. |
| 11.7 | [`records/ADR-005-authz-gate-order-reconciliation.md`](../docs/80_traceability_decisions_and_program/records/ADR-005-authz-gate-order-reconciliation.md) | ADR 005. |
| 11.8 | [`records/ADR-006-phase4-program-lock-and-legacy-waiver-retirement.md`](../docs/80_traceability_decisions_and_program/records/ADR-006-phase4-program-lock-and-legacy-waiver-retirement.md) | ADR 006. |
| 11.9 | [`DECISIONS_LOG.md`](../docs/80_traceability_decisions_and_program/DECISIONS_LOG.md) | Consolidated decision log entries. |
| 11.10 | [`CHANGE_IMPACT_MAP_TEMPLATES.md`](../docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md) | Templates for significant changes. |
| 11.11 | [`DECISION_RECORD_TEMPLATE.md`](../docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md) | Template for new decisions. |
| 11.12 | [`RISK_REGISTER.md`](../docs/80_traceability_decisions_and_program/RISK_REGISTER.md) | Risk tracking. |
| 11.13 | [`ROADMAP_AND_MILESTONES.md`](../docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md) | Roadmap and milestones. |
| 11.14 | [`SSOT_AUTOMATION_AND_LINTING.md`](../docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md) | Automation and lint hook catalog. |
| 11.15 | [`SEED_PROMOTION_TRACKER.md`](../docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md) | Seed promotion status vs canonical docs. |
| 11.16 | [`UNRESOLVED_SEED_GAP_REGISTER.md`](../docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md) | Outstanding seed ↔ SSOT gaps. |

---

## 12. Evidence framework (`docs/evidence/`)

| Order | Document | Role |
|---:|---|---|
| 12.1 | [`README.md`](../docs/evidence/README.md) | Evidence model and workflow. |
| 12.2 | [`automation/README.md`](../docs/evidence/automation/README.md) | Where automated checks write artifacts. |
| 12.3 | [`templates/README.md`](../docs/evidence/templates/README.md) | Index of evidence templates. |
| 12.4 | Domain templates under [`docs/evidence/templates/`](../docs/evidence/templates/) | Use when attaching evidence to hooks (contract, data model, feed, identity, release gates, security, events, etc.). |

---

## 13. Tooling, CI, and repository operations

| Order | Document | Role |
|---:|---|---|
| 13.1 | [`composer.json`](../composer.json) | Composer script aliases (`docs:ssot:*`, `test:contract:*`, bundles). |
| 13.2 | [`.github/workflows/ssot_phase_gate.yml`](../.github/workflows/ssot_phase_gate.yml) | CI SSOT gate workflow. |
| 13.3 | [`REFERENCE_MAINTENANCE_SOP.md`](../REFERENCE_MAINTENANCE_SOP.md) | Mandatory inventory/index updates when files move or are added. |
| 13.4 | [`master_index.md`](../master_index.md) | Operational map of the whole repo tree. |
| 13.5 | [`FILE_INVENTORY.md`](../FILE_INVENTORY.md) | Complete tracked-file list (maintained per SOP). |
| 13.6 | [`reports/REFERENCE_REFRESH_SESSION_PROMPT.md`](../reports/REFERENCE_REFRESH_SESSION_PROMPT.md) | Executor prompt for full reference reconciliation (maintenance). |

---

## 14. Seed corpus (provenance; secondary to `docs/`)

Normative behavior lives in **`docs/`**. Read **`seed/`** when you need lineage, preserved truths, or historical rationale. Start with [`seed/seed-index.md`](../seed/seed-index.md), then follow its document index (including `seed-intro.md`, `CRE8_SEED_CANON_INDEX.md`, domain `CRE8_*_SEED.md` files, and preservation/assessment reports).

---

## Explicitly out of scope for this reading list

The following remain valuable for **program history** but are **not** treated as implementation SSOT unless promoted via governance:

- `reports/session_handoffs/`, `reports/session_responses/`, `reports/session_prompts/`
- Phase execution artifacts (for example `reports/PHASE*.md` audit/plan/memo files not duplicated in `docs/`)
- Generated metrics under `reports/ssot/` (consume as **output**, not requirements)

Use [`reports/README.md`](../reports/README.md) to navigate that workspace when you need session continuity or archives.
