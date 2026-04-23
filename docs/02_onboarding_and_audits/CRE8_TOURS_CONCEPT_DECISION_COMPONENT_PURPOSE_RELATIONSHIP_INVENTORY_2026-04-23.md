# CRE8 Tours Concept/Decision/Component/Purpose/Relationship Inventory (2026-04-23)

_Status: analysis artifact_

- Generated at (UTC): 2026-04-23T13:28:49Z
- Documents scanned: 95
- Source scope: docs tree + machine contracts/schemas + root metadata (`composer.json`, `dot.env`) + root `README.md`.


## 0) Extraction policy and normalization notes (2026-04-23 refresh)

- Added strict-completeness scope entries for root `README.md`, this TOUR markdown, this TOUR JSON, and the artifact explanation file.
- Added source-precedence tier tagging model: `machine_contract`, `ssot_canon`, `governance_or_analysis`, `root_metadata`.
- Added extracted-item status model: `status` + `superseded_by` for downstream false-authority mitigation.
- Added stable source-location granularity in JSON via `source_locations` with `line_start`/`line_end`.
- Normalized malformed backtick fragments and filtered low-signal boilerplate tokens (`Field`, `Module`, `Document family`, `Notes`).

## 1) Document extraction index

| Document | Topics (sample) | Vocabulary/Components (sample) |
|---|---|---|
| `composer.json` | — | — |
| `dot.env` | CRE8 scaffold local-development environment example., Copy to `.env.local` (or equivalent) and replace all placeholder values before use., D | — |
| `README.md` | CRE8 repository overview and orientation | documentation-first |
| `docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md` | Core Identity And Value Proposition, Product identity, Primary value propositions | Deterministic governance:, Safe delegation: |
| `docs/01_foundation/README.md` | CRE8 From-Scratch SSOT Canon, Purpose, Canon scope | — |
| `docs/01_foundation/RECOMMENDED_READING_ORDER.md` | Recommended Documentation Reading Order, Supplemental machine-readable references (read after the core docs) | — |
| `docs/01_foundation/REPOSITORY_FILE_INVENTORY.md` | Repository File Inventory, Purpose, Root configuration artifacts | — |
| `docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md` | Technical Foundation And Runtime Baseline, Runtime and stack assumptions, Build principles | — |
| `docs/02_onboarding_and_audits/CRE8_COMPONENT_AND_SUBCOMPONENT_INVENTORY_2026-04-22.md` | CRE8 Component and Sub-component Inventory (2026-04-22), 1) System-level component map, 1.1 Product surfaces | /health, /.well-known/jwks.json |
| `docs/02_onboarding_and_audits/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md` | CRE8 Full Repository Document Audit (2026-04-22), Method used, A) Condition of the document set | Strategic and governance completion:, Contract completion:, /health, /health |
| `docs/02_onboarding_and_audits/HIGH_LEVEL_REPORT_2026-04-09.md` | From-Scratch Documentation High-Level Report (2026-04-09), Executive summary, What it is | Contract-first delivery, Authorization rigor, /workspace/CRE8pw/docs, /workspace/CRE8pw/docs |
| `docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md` | CRE8 Full-Context Bootstrap Prompt (for a fresh LLM session), Mission, Repository reality check (must internalize first) | SSOT maturity, Implementation maturity |
| `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md` | CRE8 Onboarding Analysis (2026-04-12), 1) Reading completion ledger, 2) CRE8 mental model (authoritative) | Drift between OpenAPI and route inventory, Auth decision drift from tables, `../../composer.json`, `dot.env` |
| `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_CODEX_REFRESH.md` | CRE8 Onboarding Analysis — Codex Refresh (2026-04-22), Scope and method, Key factual outcomes | Contract parity:, Policy parity: |
| `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md` | CRE8 Onboarding Analysis — Staff Engineer Working Model (2026-04-22), Phase 0 inventory and scope confirmation, 1) Reading completion ledger | Product mission/value:, System boundaries:, `composer.json`, `dot.env` |
| `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md` | CRE8 Onboarding Analysis — Senior Staff Engineer / Product-Architecture Model, 1) Reading completion ledger, 2) CRE8 mental model (authorita | Stage 0, Stages 1–4, `.htaccess`, `../../composer.json` |
| `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-23_STAFF_ENGINEER_WORKING_MODEL.md` | CRE8 Onboarding Analysis — Staff Engineer Working Model (2026-04-23), Scope note, Phase 0 snapshot | SSOT maturity, Implementation maturity, S0-01 |
| `docs/02_onboarding_and_audits/ARTIFACT_EXPLANATION_2026-04-23_ONBOARDING_INVENTORY_SET.md` | Artifact Explanation: 2026-04-23 Onboarding + Inventory Set, Scope | document_extractions, central_inventory |
| `docs/02_onboarding_and_audits/CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.md` | CRE8 Tours Concept/Decision/Component/Purpose/Relationship Inventory, Document extraction index | Documents scanned, Source scope |
| `docs/02_onboarding_and_audits/CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.json` | Inventory metadata, document_extractions, central_inventory | inventory_name, generated_at_utc |
| `docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md` | CRE8 Development Execution Detailed Slices (End-to-End), Purpose, Usage contract | S0-01, S0-02 |
| `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md` | CRE8 End-to-End Development Execution Master Plan, Plan intent and framing, Core principles | /health, /health |
| `docs/04_instructional_notes/INSTRUCTOR_FOLLOWUP_LECTURE_EXTENDING_CRE8.md` | Instructor Follow-Up Lecture: Extending CRE8 in a Third-Party Product, 1) Workshop Intent and Framing, 1.1 Why this follow-up exists | /ui/* |
| `docs/04_instructional_notes/INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md` | Instructor Lecture Notes: Building CRE8 (What It Is, How It Works, and How to Build It), 1) Instructor Quick-Start, 1.1 Lecture purpose | 1-minute paper:, Policy check quiz:, /health, /api/* |
| `docs/README.md` | Docs Directory Structure | — |
| `docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md` | Change Control Policy, Scope, Change classes | Class A (breaking contract):, Class B (behavioral):, /workspace/CRE8pw/docs/ssot_canon/ |
| `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md` | Document Status and Ownership, Status model, Ownership matrix | Document family, Governance + decisions |
| `docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` | Document Template and Style Guide, Required sections for adopted docs, Writing standards | — |
| `docs/ssot_canon/00_governance/SSOT_INDEX.md` | SSOT Index, Canon status, Canon navigation | /workspace/CRE8pw/docs/ssot_canon/ |
| `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md` | Architecture and Surfaces, Architectural model, Layering | Public/bootstrap, Gateway, /health, /ui/* |
| `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md` | Canonical Terminology, Principal terms, Security terms | Owner principal, Key principal |
| `docs/ssot_canon/10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md` | CRE8 Human Operating Model, Purpose, What CRE8 is | Owners, Primary/secondary/use keys |
| `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md` | CRE8 Product and System Spec, Product scope, System capabilities (v1) | Profile A (owner-first):, Profile B (delegated API platform): |
| `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md` | Dependency Baseline, Baseline dependency families, Dependency governance rules | — |
| `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` | Request Pipeline and Middleware Contract, Authoritative middleware order, Contract rules | — |
| `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md` | API Contract Guide (SSOT), Canonical machine contract, Envelope contract | /health, /.well-known/jwks.json |
| `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md` | Authorization and Delegation Spec, Scope, Principals | Owner principal:, Key principal:, /console/api/*, /api/* |
| `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md` | Authorization Decision Tables (SSOT), Purpose, Delegation issuance decision table | Child permissions are strict subset of parent envelope, Child permissions exceed parent |
| `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md` | Error Code Catalog (SSOT), Envelope-level canonical codes, Canonical middleware/handler detail-code registry (v1 baseline) | 400, 401 |
| `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md` | Endpoint Examples (All Routes), Purpose, Envelope conventions used in examples | Owner bootstrap journey:, Delegated creator journey: |
| `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md` | Route Inventory Reference (SSOT), Purpose, Inventory governance | `/`, /status |
| `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md` | UI Runtime Contract (SSOT Appendix), Purpose, Session and device persistence contract | API route, `GET /api/feed` |
| `docs/ssot_canon/20_contracts/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md` | Usage Scenarios and Permission Stories, Purpose, Scenario 1: Invite-gated owner bootstrap (default) | /console/api/keychains/{keychainId}/resolve |
| `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md` | Data Model Reference (SSOT), Storage strategy, Core entity groups | — |
| `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md` | Data Model Spec (Production), Table contracts, principals | — |
| `docs/ssot_canon/30_data_and_security/ERD.md` | ERD (Text + Mermaid), Notes | — |
| `docs/ssot_canon/30_data_and_security/MASTER_KEY_SPEC.md` | Master Key Spec, Purpose, Principal and key-class definition | — |
| `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md` | Security Controls Spec, Control objectives, Trust boundaries | — |
| `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md` | Security Headers and CSP Policy (SSOT), Purpose, Required default security headers | API/public non-UI paths, UI paths (`/ui*`), /ui* |
| `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md` | Security Threat Model, Threat scenarios, Mitigations | — |
| `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md` | Security Verification and Abuse Cases (SSOT), Purpose, Abuse-case matrix (minimum required) | Stolen access token replay, Refresh token replay |
| `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` | Acceptance Criteria Matrix (SSOT), Purpose, Usage contract | Service reachability, Deep health |
| `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md` | Boot and Startup Failure Contract (SSOT), Purpose, Startup sequence contract | — |
| `docs/ssot_canon/40_operations_and_quality/CONFIGURATION_ENVIRONMENT_CONTRACT.md` | Configuration and Environment Contract (SSOT), Purpose, Required environment variables | — |
| `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md` | Health Endpoint Contract (SSOT), Purpose, Route and surface | /health |
| `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md` | Migration Seed Strategy (SSOT), Purpose, Strategy | — |
| `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md` | Observability Event Catalog, Event families, Canonical event naming guidance | — |
| `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md` | Operational Smoke Check Contract (SSOT), Purpose, Canonical smoke commands | /health |
| `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md` | Production Readiness Gates, Gate A: Build/runtime integrity, Gate B: Contract/security quality | /health |
| `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md` | Release Checklist, Pre-release requirements, Security and operations gates | — |
| `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md` | SLO/SLI Spec, SLI definitions, Initial SLO targets | /api/*, /console/api/* |
| `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md` | Verification Strategy (SSOT), Automated suites, Required commands | — |
| `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md` | Change Impact Map Templates (SSOT), Purpose, Minimal template | Field, Capability changed |
| `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md` | Prototype to SSOT Delta Map (SSOT), Purpose, Delta map | Delta ID, D-001 |
| `docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md` | SSOT Automation and Linting (SSOT), Purpose, Optional automation checks (recommended) | — |
| `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md` | Traceability Matrix (Docs-to-Code) | Service banner + UI shell, Health + JWKS publishing |
| `docs/ssot_canon/60_decisions/ADR_INDEX.md` | ADR Index, Purpose, Current indexed records | — |
| `docs/ssot_canon/60_decisions/DECISIONS_LOG.md` | Decisions Log, Chronological entries, Update rule | 2026-04-06, 2026-04-06, /workspace/CRE8pw/docs/ssot_canon/ |
| `docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md` | Decision Record Template, Required fields, Quality bar | — |
| `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md` | ADR-001: SSOT-first contract governance model, Context, Decision | — |
| `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md` | ADR-002: Delegation envelope bounds (subset/depth/expiry), Context, Decision | — |
| `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md` | ADR-003: Keychain as production-active v1 principal class, Context, Decision | — |
| `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md` | ADR-004: Envelope-first API response standard, Context, Decision | — |
| `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md` | ADR-005: Release gating via verification + smoke + readiness controls, Context, Decision | — |
| `docs/ssot_canon/70_implementation_guidance/DEPRECATION_AND_VERSIONING_POLICY.md` | Deprecation and Versioning Policy, Versioning model, Deprecation process | — |
| `docs/ssot_canon/70_implementation_guidance/EXTENSIBILITY_PLAYBOOK.md` | Extensibility Playbook, Purpose, Extension seam map | — |
| `docs/ssot_canon/70_implementation_guidance/MIGRATION_AND_COMPATIBILITY_STRATEGY.md` | Migration and Compatibility Strategy, Migration principles, Required migration artifacts | Additive payload extension:, New entity introduction: |
| `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md` | Module Boundaries and Ownership, Core modules, Ownership model | Module, Auth + lifecycle |
| `docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md` | Test Data and Fixture Strategy, Fixture principles, Required fixture packs | — |
| `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md` | Contribution Workflow (SSOT), Workflow, Required PR payload | — |
| `docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md` | Definition of Done, Done means all are true, Required evidence checklist | — |
| `docs/ssot_canon/80_program_management/KEY_HIERARCHY_SCALE_ANALYSIS_TASK.md` | Tracking Task: Key Hierarchy Scale Analysis, Task type, Objective | — |
| `docs/ssot_canon/80_program_management/KEY_TYPE_SPEC_COHERENCE_TASK.md` | Tracking Task: Key Type Spec Coherence, Task type, Objective | — |
| `docs/ssot_canon/80_program_management/MASTER_KEY_HIERARCHY_ANALYSIS_TASK.md` | Tracking Task: Master-Key Hierarchy Scale Analysis, Task type, Objective | — |
| `docs/ssot_canon/80_program_management/RISK_REGISTER.md` | Risk Register, Active risks, Review cadence | R-001, R-002 |
| `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md` | Roadmap and Milestones, Milestones, Exit criteria by milestone | M1 Foundation, M2 Core implementation |
| `docs/ssot_canon/evidence/HISTORICAL_SSOT_CHANGE_EVIDENCE_2026-04-21.md` | Historical SSOT Change Evidence (2026-04-21), Historical context note, Summary | — |
| `docs/ssot_canon/evidence/README.md` | Evidence Package Guide, Purpose, Required evidence types | — |
| `docs/ssot_canon/evidence/SSOT_CHANGE_EVIDENCE_2026-04-21_MASTER_RESOLUTION.md` | SSOT Change Evidence, Change metadata, Documents/artifacts changed | — |
| `docs/ssot_canon/evidence/automation/ssot_report.json` | — | — |
| `docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md` | Release Evidence Template, Release metadata, Verification command results | — |
| `docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md` | SSOT Change Evidence Template, Change metadata, Documents/artifacts changed | — |
| `docs/ssot_canon/openapi/cre8.v1.yaml` | — | — |
| `docs/ssot_canon/schemas/error-envelope.schema.json` | — | — |
| `docs/ssot_canon/schemas/success-envelope.schema.json` | — | — |

## 2) Centralized inventory list

| ID | Item | Kind | Sources | Relationships |
|---|---|---|---:|---|
| `I-18d80423` | `400` | component | 1 | — |
| `I-816b112c` | `401` | component | 1 | — |
| `I-bbf94b34` | `403` | component | 1 | — |
| `I-4f4adcbf` | `404` | component | 1 | — |
| `I-bbcbff5c` | `405` | component | 1 | — |
| `I-a96b65a7` | `409` | component | 1 | — |
| `I-42e7aaa8` | `415` | component | 1 | — |
| `I-f85454e8` | `422` | component | 1 | — |
| `I-75fc093c` | `429` | component | 1 | — |
| `I-cee63112` | `500` | component | 1 | — |
| `I-d19da09e` | ``../../composer.json`` | component | 2 | — |
| `I-8052c42a` | ``.htaccess`` | component | 1 | — |
| `I-c13fccf4` | ``/api/posts/{postId}/comments`` | component | 2 | — |
| `I-895ae219` | ``/api/posts/{postId}/flags`` | component | 2 | — |
| `I-6d7579ed` | ``/api/posts/{postId}`` | component | 2 | — |
| `I-d7beea1b` | ``/api/posts`` | component | 2 | — |
| `I-0a5672ca` | ``/console/api/keychains/{keychainId}/members/{memberKeyId}`` | component | 2 | policy:delegation |
| `I-d0b0342e` | ``/console/api/keychains/{keychainId}/members`` | component | 2 | policy:delegation |
| `I-a907c779` | ``/console/api/keychains/{keychainId}/resolve`` | component | 3 | policy:delegation |
| `I-c069cb4d` | ``/console/api/keychains`` | component | 2 | policy:delegation |
| `I-75665dd2` | ``/console/api/keys/{keyId}/lifecycle`` | component | 2 | — |
| `I-d5363d5d` | ``/console/api/keys`` | component | 2 | — |
| `I-ba2c380a` | ``/console/api/posts/{postId}/comments/{commentId}/moderation`` | component | 2 | — |
| `I-3fe3f986` | ``/console/api/posts/{postId}/moderation`` | component | 2 | — |
| `I-5c2bf2de` | ``/console/api/posts`` | component | 2 | — |
| `I-6d163dd2` | `/health reliability` | component | 1 | — |
| `I-b5d0ee8c` | ``composer.json`` | component | 1 | — |
| `I-611208e6` | ``DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}`` | component | 2 | policy:delegation |
| `I-1c0851df` | ``docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md`` | component | 3 | — |
| `I-f587dd49` | ``docs/01_foundation/README.md`` | component | 3 | — |
| `I-50b7f8da` | ``docs/01_foundation/RECOMMENDED_READING_ORDER.md`` | component | 3 | — |
| `I-e3442bfd` | ``docs/01_foundation/REPOSITORY_FILE_INVENTORY.md`` | component | 3 | — |
| `I-86dc5431` | ``docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`` | component | 3 | — |
| `I-0fef8703` | ``docs/02_onboarding_and_audits/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md`` | component | 2 | — |
| `I-e36f82fc` | ``docs/02_onboarding_and_audits/HIGH_LEVEL_REPORT_2026-04-09.md`` | component | 3 | — |
| `I-6e47b524` | ``docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md`` | component | 3 | — |
| `I-bc856ef2` | ``docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`` | component | 2 | — |
| `I-314b0018` | ``docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_CODEX_REFRESH.md`` | component | 1 | — |
| `I-86c81147` | ``docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`` | component | 1 | — |
| `I-5b2c37cb` | ``docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md`` | component | 3 | — |
| `I-1ec3a593` | ``docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`` | component | 3 | — |
| `I-fede5857` | ``docs/04_instructional_notes/INSTRUCTOR_FOLLOWUP_LECTURE_EXTENDING_CRE8.md`` | component | 2 | — |
| `I-342e06bb` | ``docs/04_instructional_notes/INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md`` | component | 2 | — |
| `I-d0b43d61` | ``docs/README.md`` | component | 1 | — |
| `I-e9130218` | ``docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md`` | component | 3 | — |
| `I-871f0675` | ``docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`` | component | 3 | — |
| `I-0bcfd3ee` | ``docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`` | component | 3 | — |
| `I-0d36d3f7` | ``docs/ssot_canon/00_governance/SSOT_INDEX.md`` | component | 3 | — |
| `I-1b8d83d4` | ``docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`` | component | 3 | — |
| `I-be3c91d3` | ``docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`` | component | 3 | — |
| `I-e0299aa0` | ``docs/ssot_canon/10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md`` | component | 1 | — |
| `I-99356e19` | ``docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`` | component | 3 | — |
| `I-cf4b7f20` | ``docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`` | component | 3 | — |
| `I-923b498d` | ``docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`` | component | 3 | — |
| `I-18a9fd9e` | ``docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`` | component | 3 | policy:authorization |
| `I-5f4b875e` | ``docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`` | component | 3 | — |
| `I-cdc158b7` | ``docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`` | component | 3 | — |
| `I-eb91bba1` | ``docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`` | component | 3 | — |
| `I-f1c97b8d` | ``docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`` | component | 3 | — |
| `I-23cdbab6` | ``docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`` | component | 3 | — |
| `I-c444ca41` | ``docs/ssot_canon/20_contracts/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md`` | component | 1 | — |
| `I-31c41b64` | ``docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`` | component | 3 | — |
| `I-af57ede1` | ``docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`` | component | 3 | — |
| `I-76b183ae` | ``docs/ssot_canon/30_data_and_security/ERD.md`` | component | 3 | — |
| `I-26807f19` | ``docs/ssot_canon/30_data_and_security/MASTER_KEY_SPEC.md`` | component | 2 | — |
| `I-0f71b6fb` | ``docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`` | component | 3 | — |
| `I-c6033218` | ``docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md`` | component | 3 | — |
| `I-9663092e` | ``docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md`` | component | 3 | — |
| `I-3508800c` | ``docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`` | component | 3 | — |
| `I-cf8163f3` | ``docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`` | component | 3 | — |
| `I-c8b1b1f7` | ``docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md`` | component | 3 | — |
| `I-dc7d52ce` | ``docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md`` | component | 3 | — |
| `I-578d0cb7` | ``docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md`` | component | 3 | — |
| `I-22484797` | ``docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md`` | component | 3 | — |
| `I-5b98bf0b` | ``docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`` | component | 3 | — |
| `I-a4f7a780` | ``docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md`` | component | 3 | — |
| `I-6db962e7` | ``docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md`` | component | 3 | — |
| `I-8c0e19ac` | ``docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`` | component | 3 | — |
| `I-4c20d4e1` | ``docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`` | component | 3 | — |
| `I-07abf8c2` | ``docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`` | component | 3 | — |
| `I-c5169a30` | ``docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`` | component | 3 | — |
| `I-596e789e` | ``docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md`` | component | 3 | — |
| `I-51b7c7f1` | ``docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`` | component | 3 | — |
| `I-9c2ba77a` | ``docs/ssot_canon/60_decisions/ADR_INDEX.md`` | component | 3 | — |
| `I-0b0d2b16` | ``docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md`` | component | 3 | — |
| `I-cc6a48dd` | ``docs/ssot_canon/60_decisions/DECISIONS_LOG.md`` | component | 3 | — |
| `I-5277f3e0` | ``docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md`` | component | 3 | — |
| `I-f5be585e` | ``docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md`` | component | 3 | policy:authorization |
| `I-2fb455db` | ``docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md`` | component | 3 | policy:delegation |
| `I-51090d8d` | ``docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md`` | component | 3 | — |
| `I-e1dab679` | ``docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md`` | component | 3 | — |
| `I-e42bdd86` | ``docs/ssot_canon/70_implementation_guidance/EXTENSIBILITY_PLAYBOOK.md`` | component | 1 | — |
| `I-2d2e0cab` | ``docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`` | component | 3 | — |
| `I-af92af71` | ``docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md`` | component | 3 | — |
| `I-e0cc7255` | ``docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md`` | component | 3 | — |
| `I-42bfe9a0` | ``docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md`` | component | 3 | — |
| `I-528af75c` | ``docs/ssot_canon/80_program_management/KEY_HIERARCHY_SCALE_ANALYSIS_TASK.md`` | component | 2 | — |
| `I-41775b4e` | ``docs/ssot_canon/80_program_management/KEY_TYPE_SPEC_COHERENCE_TASK.md`` | component | 2 | — |
| `I-51d9e328` | ``docs/ssot_canon/80_program_management/MASTER_KEY_HIERARCHY_ANALYSIS_TASK.md`` | component | 2 | — |
| `I-cc59ebad` | ``docs/ssot_canon/80_program_management/RISK_REGISTER.md`` | component | 3 | — |
| `I-16d1de00` | ``docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md`` | component | 3 | — |
| `I-85a980df` | ``docs/ssot_canon/evidence/automation/ssot_report.json`` | component | 3 | — |
| `I-9061000e` | ``docs/ssot_canon/evidence/HISTORICAL_SSOT_CHANGE_EVIDENCE_2026-04-21.md`` | component | 2 | — |
| `I-eb75e66b` | ``docs/ssot_canon/evidence/README.md`` | component | 3 | — |
| `I-bcbee0e2` | ``docs/ssot_canon/evidence/SSOT_CHANGE_EVIDENCE_2026-04-21_MASTER_RESOLUTION.md`` | component | 2 | — |
| `I-64b6db3c` | ``docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md`` | component | 3 | — |
| `I-ae5acd5d` | ``docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md`` | component | 3 | — |
| `I-e9562552` | ``docs/ssot_canon/openapi/cre8.v1.yaml`` | component | 3 | — |
| `I-ee128594` | ``docs/ssot_canon/schemas/error-envelope.schema.json`` | component | 3 | — |
| `I-987a40d1` | ``docs/ssot_canon/schemas/success-envelope.schema.json`` | component | 3 | — |
| `I-7e1c9b54` | ``dot.env`` | component | 3 | — |
| `I-02fbd127` | ``GET /api/feed`` | component | 2 | — |
| `I-2c66e3a3` | ``GET /api/posts/{postId}/comments`` | component | 2 | — |
| `I-64ad687e` | ``GET /api/posts/{postId}`` | component | 2 | — |
| `I-be6fb47c` | ``GET /console/api/keychains/{keychainId}/members`` | component | 2 | policy:delegation |
| `I-d35b6968` | ``GET /console/api/keychains/{keychainId}/resolve`` | component | 2 | policy:delegation |
| `I-a34382a0` | ``GET /console/api/keychains`` | component | 2 | policy:delegation |
| `I-0d1d0f0f` | ``GET /console/api/posts`` | component | 2 | — |
| `I-14677f40` | ``PATCH /api/posts/{postId}`` | component | 2 | — |
| `I-5ef32a8f` | ``POST /api/posts/{postId}/comments`` | component | 2 | — |
| `I-c54aa6a8` | ``POST /api/posts/{postId}/flags`` | component | 2 | — |
| `I-d7070301` | ``POST /api/posts`` | component | 2 | — |
| `I-17f80b46` | ``POST /console/api/invites`` | component | 2 | — |
| `I-1c4a37e7` | ``POST /console/api/keychains/{keychainId}/members`` | component | 2 | policy:delegation |
| `I-41235f5e` | ``POST /console/api/keychains`` | component | 2 | policy:delegation |
| `I-1d082f46` | ``POST /console/api/keys/{keyId}/lifecycle`` | component | 2 | — |
| `I-39ca2998` | ``POST /console/api/keys`` | component | 2 | — |
| `I-88185e3d` | ``POST /console/api/posts/{postId}/comments/{commentId}/moderation`` | component | 2 | — |
| `I-f4d559ab` | ``POST /console/api/posts/{postId}/moderation`` | component | 2 | — |
| `I-4ee04f79` | ``POST /console/api/posts`` | component | 2 | — |
| `I-5ef76d30` | ``use`` | component | 1 | — |
| `I-88295d11` | `X-Device-Id malformed` | component | 1 | — |
| `I-43ad4669` | `X-Device-Id missing` | component | 1 | — |
| `I-21232f29` | `admin` | component | 1 | — |
| `I-24e23f18` | `admin (owner-delegated)` | component | 1 | — |
| `I-9fa518c5` | `API availability (`/api/*`, `/console/api/*`)` | component | 1 | — |
| `I-f8d649a4` | `API route` | component | 1 | — |
| `I-3e7e2d6b` | `Architecture & module boundaries` | component | 1 | — |
| `I-11fa3a9a` | `Auth + lifecycle` | component | 1 | — |
| `I-91255375` | `Auth latency (owner/key login)` | component | 1 | — |
| `I-1473e32d` | `Auth/AuthZ/Delegation` | component | 1 | policy:authorization |
| `I-d2697521` | `Authorization/policy` | component | 1 | — |
| `I-395d573f` | `Backend runtime` | component | 1 | — |
| `I-11a5688f` | `Capability changed` | component | 1 | — |
| `I-74ef8e10` | `Child expiry missing` | component | 1 | — |
| `I-26860d28` | `Child permissions are strict subset of parent envelope` | component | 1 | — |
| `I-07d0baf7` | `Child permissions exceed parent` | component | 1 | — |
| `I-c9b85e15` | `Child scope exceeds parent` | component | 1 | — |
| `I-d0df3bfb` | `Comment list/create` | component | 2 | — |
| `I-83d41889` | `Console post ops` | component | 1 | — |
| `I-c7d08ae1` | `Console posts` | component | 1 | — |
| `I-db72d56f` | `Content + moderation` | component | 1 | — |
| `I-15e44355` | `Contract artifacts impacted` | component | 1 | — |
| `I-ca969a1b` | `CSRF` | component | 1 | — |
| `I-c42a44bb` | `CSRF on console write` | component | 1 | — |
| `I-3e3b0316` | `D-001` | component | 1 | — |
| `I-63a0a710` | `D-002` | component | 1 | — |
| `I-208666f2` | `D-003` | component | 1 | — |
| `I-bdf7db9f` | `Data & migrations` | component | 1 | — |
| `I-8dba6756` | `Data + security` | component | 1 | — |
| `I-b9ac02a8` | `Data-model extension` | component | 1 | — |
| `I-e828296d` | `Data/security impact` | component | 1 | — |
| `I-cf8df498` | `Deep health` | component | 1 | — |
| `I-3e06203a` | `Delegated platform` | component | 1 | — |
| `I-2217c39f` | `Delegation escalation` | component | 1 | policy:authorization |
| `I-b789995b` | `Delta ID` | component | 1 | — |
| `I-e71e4f4d` | `Device guard` | component | 1 | — |
| `I-797ade3b` | `Device-header bypass` | component | 1 | — |
| `I-ba14f572` | `Document family` | component | 1 | — |
| `I-db899c25` | `Domain resolver` | component | 1 | — |
| `I-4ccb4cc9` | `Error budget burn` | component | 1 | — |
| `I-a4bdc899` | `Error handler` | component | 1 | — |
| `I-8ff495a1` | `Extension seam` | component | 1 | — |
| `I-40016185` | `Feed latency (`GET /api/feed`)` | component | 1 | — |
| `I-3328d6a5` | `Feed read` | component | 2 | — |
| `I-06e3d36f` | `Field` | component | 1 | — |
| `I-4f83a3e4` | `Frontend/UI` | component | 1 | — |
| `I-6d2d97bc` | `Gateway policy` | component | 1 | — |
| `I-3c31c689` | `Gateway route has JWT device_id claim matching X-Device-Id` | component | 1 | — |
| `I-f9f1a9f8` | `Governance & SSOT sync` | component | 1 | — |
| `I-1e55f26f` | `Governance + decisions` | component | 1 | — |
| `I-b0eb7991` | `Health + JWKS publishing` | component | 1 | — |
| `I-e973e284` | `Inactive/revoked member contribution` | component | 1 | — |
| `I-e47f9e0a` | `Invite create` | component | 1 | — |
| `I-1505410e` | `Invite issue` | component | 1 | — |
| `I-d4d10b73` | `Issuer is keychain principal` | component | 1 | policy:delegation |
| `I-69610698` | `Issuer is owner principal via console issue route` | component | 1 | — |
| `I-2cafd48e` | `JSON body` | component | 1 | — |
| `I-0c96660c` | `JWKS publishing` | component | 1 | — |
| `I-eb670351` | `JWT `device_id` missing/mismatch relative to header` | component | 1 | — |
| `I-570f179a` | `Key issue/lifecycle` | component | 2 | — |
| `I-1c22060a` | `Key login` | component | 2 | — |
| `I-4dea7c43` | `Keychain create/list` | component | 1 | policy:delegation |
| `I-d955fdf4` | `Keychain effective resolve` | component | 1 | policy:delegation |
| `I-6e80b930` | `keychain key` | component | 1 | policy:delegation |
| `I-a5c3ed92` | `Keychain list/create` | component | 1 | policy:delegation |
| `I-ccf2ae7e` | `Keychain membership mutate` | component | 2 | policy:delegation |
| `I-20d0449a` | `Keychain nesting bypass` | component | 1 | policy:delegation |
| `I-9ef248bf` | `Keychain resolve` | component | 1 | policy:delegation |
| `I-d5934373` | `Master-key SYSADMIN governance + device-bound auth invariants` | component | 1 | — |
| `I-d90444a7` | `Membership change` | component | 1 | — |
| `I-dea0878c` | `Moderation actions` | component | 2 | — |
| `I-22884db1` | `Module` | component | 1 | — |
| `I-fcd41db7` | `Observability & SRE` | component | 1 | — |
| `I-477983a7` | `Operational impact` | component | 1 | — |
| `I-0e23dd2a` | `Operations + observability` | component | 1 | — |
| `I-8d168cee` | `Operations + quality` | component | 1 | — |
| `I-a475274f` | `Owner bootstrap policy` | component | 2 | — |
| `I-01b4aa4c` | `Owner login` | component | 1 | — |
| `I-d63bbf8e` | `Owner signup` | component | 1 | — |
| `I-d1898ae6` | `Owner signup/login` | component | 1 | — |
| `I-d6a5f486` | `Owner-first` | component | 1 | — |
| `I-deb5b672` | `Parent depth is 3 and child requested` | component | 1 | — |
| `I-10ab83ea` | `Parent lacks `keys:issue`` | component | 1 | — |
| `I-41275a53` | `Permissions` | component | 1 | — |
| `I-8cf210df` | `Policy/authorization extension` | component | 1 | — |
| `I-54984243` | `Positive scope tokens` | component | 1 | — |
| `I-4e108d8c` | `Post create` | component | 1 | — |
| `I-fcb2dcfc` | `Post create/edit/flag` | component | 1 | — |
| `I-0a0dae5e` | `Post flag` | component | 1 | — |
| `I-ec877b11` | `Post read/edit` | component | 1 | — |
| `I-1bba1e55` | `primary_author key` | component | 1 | — |
| `I-10748015` | `Product + contracts` | component | 1 | — |
| `I-8b9aeb48` | `Program management` | component | 1 | — |
| `I-8cdb5495` | `Progressive` | component | 1 | — |
| `I-6cea94a2` | `Quality engineering` | component | 1 | — |
| `I-35adcf72` | `R-001` | component | 1 | — |
| `I-a5c9ae9f` | `R-002` | component | 1 | — |
| `I-04609fb7` | `R-003` | component | 1 | — |
| `I-1b22dc44` | `R-004` | component | 1 | — |
| `I-5bdc4517` | `R-005` | component | 1 | — |
| `I-85d7dbe3` | `R-006` | component | 1 | — |
| `I-690f57f2` | `R-007` | component | 1 | — |
| `I-7116c9b5` | `Rate limit` | component | 1 | — |
| `I-e0fe422b` | `Rate-limit exhaustion` | component | 1 | — |
| `I-03b62516` | `Refresh` | component | 1 | — |
| `I-f1ba5d88` | `Refresh token replay` | component | 1 | — |
| `I-1104bd10` | `Release engineering` | component | 1 | — |
| `I-d633542d` | `Restrictive scope dimensions` | component | 1 | — |
| `I-6ccb88fa` | `Rollback strategy` | component | 1 | — |
| `I-092f0832` | `Route/contract extension` | component | 1 | — |
| `I-5ebc398f` | `Routes/handlers impacted` | component | 1 | — |
| `I-436863bf` | `S0-02` | component | 1 | — |
| `I-c3fea00f` | `S0-03` | component | 1 | — |
| `I-343b2be7` | `S0-04` | component | 1 | — |
| `I-c907d357` | `S0-05` | component | 1 | — |
| `I-5cbe2e22` | `S0-06` | component | 1 | — |
| `I-bc69a64f` | `S0-07` | component | 1 | — |
| `I-b2bead73` | `S0-08` | component | 1 | — |
| `I-83763cde` | `S1-01` | component | 1 | — |
| `I-ff25ddfa` | `S1-02` | component | 1 | — |
| `I-32bb5558` | `S1-03` | component | 1 | — |
| `I-cf934e4f` | `S1-04` | component | 1 | — |
| `I-a836c1d3` | `S1-05` | component | 1 | — |
| `I-a32d7a03` | `S1-06` | component | 1 | — |
| `I-9c075e35` | `S1-07` | component | 1 | — |
| `I-0916e53e` | `S1-08` | component | 1 | — |
| `I-da2353bc` | `S1-09` | component | 1 | — |
| `I-1118ce16` | `S1-10` | component | 1 | — |
| `I-cc2238b8` | `S1-11` | component | 1 | — |
| `I-9b87d58e` | `S1-12` | component | 1 | — |
| `I-99d2d760` | `S1-13` | component | 1 | — |
| `I-2ca8b7b4` | `S1-14` | component | 1 | — |
| `I-db511205` | `S10-01` | component | 1 | — |
| `I-7f71750e` | `S10-02` | component | 1 | — |
| `I-05a806f6` | `S10-03` | component | 1 | — |
| `I-867dd3d1` | `S10-04` | component | 1 | — |
| `I-98eba95f` | `S10-05` | component | 1 | — |
| `I-678abeb6` | `S10-06` | component | 1 | — |
| `I-08bef5a7` | `S10-07` | component | 1 | — |
| `I-c86bd9d1` | `S10-08` | component | 1 | — |
| `I-669ac903` | `S2-01` | component | 1 | — |
| `I-0ddd8108` | `S2-02` | component | 1 | — |
| `I-587bbe66` | `S2-03` | component | 1 | — |
| `I-900c87c1` | `S2-04` | component | 1 | — |
| `I-97b64875` | `S2-05` | component | 1 | — |
| `I-e9addadb` | `S2-06` | component | 1 | — |
| `I-4f3c995d` | `S2-07` | component | 1 | — |
| `I-6fa9cc19` | `S2-08` | component | 1 | — |
| `I-a5800445` | `S2-09` | component | 1 | — |
| `I-18c834ad` | `S3-01` | component | 1 | — |
| `I-ac771dfa` | `S3-02` | component | 1 | — |
| `I-69eb2d7f` | `S3-03` | component | 1 | — |
| `I-e1e0ff13` | `S3-04` | component | 1 | — |
| `I-41eb950f` | `S3-05` | component | 1 | — |
| `I-e8b496e3` | `S3-06` | component | 1 | — |
| `I-9721d9b3` | `S3-07` | component | 1 | — |
| `I-aa42db30` | `S3-08` | component | 1 | — |
| `I-4e3ddaeb` | `S4-01` | component | 1 | — |
| `I-9243b376` | `S4-02` | component | 1 | — |
| `I-804dc7bf` | `S4-03` | component | 1 | — |
| `I-e6011c44` | `S4-04` | component | 1 | — |
| `I-ccd09e7c` | `S4-05` | component | 1 | — |
| `I-64845a6f` | `S4-06` | component | 1 | — |
| `I-2a69a0fa` | `S4-07` | component | 1 | — |
| `I-b82da51a` | `S4-08` | component | 1 | — |
| `I-9bb0707c` | `S4-09` | component | 1 | — |
| `I-b453eb87` | `S5-01` | component | 1 | — |
| `I-8e18d0ee` | `S5-02` | component | 1 | — |
| `I-fb65ae29` | `S5-03` | component | 1 | — |
| `I-7876d131` | `S5-04` | component | 1 | — |
| `I-587a9bf7` | `S5-05` | component | 1 | — |
| `I-4a79eb94` | `S5-06` | component | 1 | — |
| `I-613944d3` | `S5-07` | component | 1 | — |
| `I-083a7ff9` | `S5-08` | component | 1 | — |
| `I-2235dc1c` | `S5-09` | component | 1 | — |
| `I-b6241d7f` | `S5-10` | component | 1 | — |
| `I-ba49330d` | `S5-11` | component | 1 | — |
| `I-f33fb4b5` | `S6-01` | component | 1 | — |
| `I-900fa630` | `S6-02` | component | 1 | — |
| `I-71bba103` | `S6-03` | component | 1 | — |
| `I-cfc32d56` | `S6-04` | component | 1 | — |
| `I-79a13f87` | `S6-05` | component | 1 | — |
| `I-4d05459b` | `S6-06` | component | 1 | — |
| `I-84fb870f` | `S6-07` | component | 1 | — |
| `I-ce7ff1e5` | `S6-08` | component | 1 | — |
| `I-2596cd0a` | `S6-09` | component | 1 | — |
| `I-f633ae39` | `S7-01` | component | 1 | — |
| `I-1c1fdbb3` | `S7-02` | component | 1 | — |
| `I-3bf15b36` | `S7-03` | component | 1 | — |
| `I-9d5b153f` | `S7-04` | component | 1 | — |
| `I-46640c05` | `S7-05` | component | 1 | — |
| `I-abffe61f` | `S7-06` | component | 1 | — |
| `I-3965338d` | `S7-07` | component | 1 | — |
| `I-228f7f9a` | `S8-01` | component | 1 | — |
| `I-22901000` | `S8-02` | component | 1 | — |
| `I-25842c1e` | `S8-03` | component | 1 | — |
| `I-f8b91ae7` | `S8-04` | component | 1 | — |
| `I-4895ab56` | `S8-05` | component | 1 | — |
| `I-5ef2cef1` | `S8-06` | component | 1 | — |
| `I-2e4e82f5` | `S8-07` | component | 1 | — |
| `I-bfa04738` | `S9-01` | component | 1 | — |
| `I-fd9d356e` | `S9-02` | component | 1 | — |
| `I-d9bbdf36` | `S9-03` | component | 1 | — |
| `I-987d3a73` | `S9-04` | component | 1 | — |
| `I-d812e81e` | `S9-05` | component | 1 | — |
| `I-8d706c35` | `S9-06` | component | 1 | — |
| `I-3fe21031` | `S9-07` | component | 1 | — |
| `I-87abe035` | `S9-08` | component | 1 | — |
| `I-51fee658` | `secondary_author key` | component | 1 | — |
| `I-e91e6348` | `Security` | component | 1 | — |
| `I-d26594a3` | `Sensitive log leakage` | component | 1 | — |
| `I-82ecf6a3` | `Service banner + UI shell` | component | 1 | — |
| `I-25e4da8a` | `Service reachability` | component | 1 | — |
| `I-96bc4444` | `Signal / SLI` | component | 1 | — |
| `I-7641d853` | `Stolen access token replay` | component | 1 | — |
| `I-96959af5` | `Tests updated` | component | 1 | — |
| `I-7a4937e2` | `Token policy` | component | 1 | — |
| `I-8279920e` | `Token refresh` | component | 1 | — |
| `I-8451a11c` | `UI shell fallback` | component | 1 | — |
| `I-1c94a67b` | `UI-runtime extension` | component | 1 | — |
| `I-69bb079f` | `use key` | component | 1 | — |
| `I-99debc1a` | `# ADR-001: SSOT-first contract governance model` | decision | 1 | — |
| `I-9052f08e` | `# ADR-002: Delegation envelope bounds (subset/depth/expiry)` | decision | 1 | policy:authorization |
| `I-d22cc418` | `# ADR-003: Keychain as production-active v1 principal class` | decision | 1 | policy:delegation |
| `I-75085670` | `# ADR-004: Envelope-first API response standard` | decision | 1 | — |
| `I-c4ee2586` | `# ADR-005: Release gating via verification + smoke + readiness controls` | decision | 1 | — |
| `I-9113583e` | `## Decision` | decision | 5 | — |
| `I-bf2b61be` | `- `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md`` | decision | 1 | — |
| `I-b1971e13` | `- `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md`` | decision | 1 | policy:authorization |
| `I-76f68ef4` | `- `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md`` | decision | 1 | policy:delegation |
| `I-d236d589` | `- `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md`` | decision | 1 | — |
| `I-c5dac7b5` | `- `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md`` | decision | 1 | — |
| `I-ccff25d8` | `- ADR-001: SSOT-first contract governance model (`records/ADR-001-ssot-first-governance.md`).` | decision | 1 | — |
| `I-680cfac0` | `- ADR-001: SSOT-first governance precedence and drift intolerance.` | decision | 1 | — |
| `I-5986b23a` | `- ADR-002: Delegation envelope bounds as hard security/authorization constraints.` | decision | 1 | policy:authorization |
| `I-08f0ce6a` | `- ADR-002: Delegation envelope subset/depth/expiry enforcement (`records/ADR-002-delegation-envelope-bounds.md`).` | decision | 1 | policy:authorization |
| `I-7cdf699d` | `- ADR-003: Keychain as production-active v1 principal class (`records/ADR-003-keychain-production-principal.md`).` | decision | 1 | policy:delegation |
| `I-53d84d28` | `- ADR-003: Keychain elevated to production principal semantics.` | decision | 1 | policy:delegation |
| `I-949c3719` | `- ADR-004: Envelope-first API response standard (`records/ADR-004-envelope-first-api-standard.md`).` | decision | 1 | — |
| `I-4cbb855a` | `- ADR-004: Envelope-first API standardization.` | decision | 1 | — |
| `I-2f7c63c8` | `- ADR-005: Release gating controls and evidence-driven readiness.` | decision | 1 | — |
| `I-30e9a80c` | `- ADR-005: Release gating via verification + smoke + readiness controls (`records/ADR-005-release-gating-controls.md`).` | decision | 1 | — |
| `I-fcce9716` | `1. **ADR-001 SSOT-first governance**` | decision | 1 | — |
| `I-0e1c1bba` | `2. **ADR-002 Delegation bounds**` | decision | 1 | policy:authorization |
| `I-7dbbca8d` | `3. **ADR-003 Keychain production principal**` | decision | 1 | policy:delegation |
| `I-c77f3741` | `4. **ADR-004 Envelope-first API**` | decision | 1 | — |
| `I-e9c85544` | `47. `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md`` | decision | 1 | — |
| `I-9ad08038` | `48. `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md`` | decision | 1 | policy:authorization |
| `I-20f95105` | `49. `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md`` | decision | 1 | policy:delegation |
| `I-cd308e6d` | `5. **ADR-005 Release gating controls**` | decision | 1 | — |
| `I-58772ecf` | `50. `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md`` | decision | 1 | — |
| `I-47debdd2` | `51. `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md`` | decision | 1 | — |
| `I-7d7350f8` | `| `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md` | Read | ADR | - Machine-artifact precedence a` | decision | 1 | — |
| `I-ce917115` | `| `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md` | Read | ADR | - SSOT-first governance decisio` | decision | 1 | — |
| `I-05773a85` | `| `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md` | Read | Decisions | - SSOT-first governance d` | decision | 1 | — |
| `I-e321002f` | `| `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md` | Read | ADR | - Delegation constrained b` | decision | 1 | policy:authorization |
| `I-f1fb7515` | `| `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md` | Read | ADR | - Delegation envelope boun` | decision | 1 | policy:authorization |
| `I-cd645b75` | `| `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md` | Read | Decisions | - Delegation subset/` | decision | 1 | policy:authorization |
| `I-7e820596` | `| `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md` | Read | ADR | - Keychain production p` | decision | 1 | policy:delegation |
| `I-ec534605` | `| `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md` | Read | ADR | - Keychain promoted to ` | decision | 1 | policy:delegation |
| `I-e29d6c01` | `| `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md` | Read | Decisions | - Keychain as pro` | decision | 1 | policy:delegation |
| `I-5f7570dd` | `| `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md` | Read | ADR | - Canonical envelopes for` | decision | 1 | — |
| `I-f3a2420a` | `| `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md` | Read | ADR | - Envelope-first API stan` | decision | 1 | — |
| `I-46858a6f` | `| `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md` | Read | Decisions | - Envelope-first st` | decision | 1 | — |
| `I-b17178ec` | `| `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md` | Read | ADR | - Release is evidence-driven ` | decision | 1 | — |
| `I-d57a4779` | `| `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md` | Read | ADR | - Release-by-gate decision. -` | decision | 1 | — |
| `I-4bc3af7c` | `| `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md` | Read | Decisions | - Gate-based release co` | decision | 1 | — |
| `I-5810972d` | `/.well-known/jwks.json` | route | 7 | — |
| `I-88f59ab8` | `/api/*` | route | 9 | surface:gateway_or_auth |
| `I-62f8ec27` | `/api/auth/key-login` | route | 5 | surface:gateway_or_auth |
| `I-0611b681` | `/api/auth/login` | route | 5 | surface:gateway_or_auth |
| `I-2f12555a` | `/api/auth/refresh` | route | 4 | surface:gateway_or_auth |
| `I-d97417f1` | `/api/feed` | route | 3 | surface:gateway_or_auth |
| `I-f2047d48` | `/api/posts*` | route | 1 | surface:gateway_or_auth |
| `I-b37a8f06` | `/console/api/*` | route | 9 | surface:console |
| `I-a070d8a9` | `/console/api/invites` | route | 3 | surface:console |
| `I-98e0b069` | `/console/api/keychains*` | route | 1 | policy:delegation, surface:console |
| `I-7c1bf87f` | `/console/api/keys*` | route | 1 | surface:console |
| `I-00984ac5` | `/console/invites/new` | route | 2 | surface:console |
| `I-4205afcc` | `/console/keychains` | route | 2 | policy:delegation, surface:console |
| `I-ef4c772f` | `/console/keychains/new` | route | 2 | policy:delegation, surface:console |
| `I-d93e2141` | `/console/keychains/{id}` | route | 2 | policy:delegation, surface:console |
| `I-fb5e25bb` | `/console/keychains/{id}/add-member` | route | 2 | policy:delegation, surface:console |
| `I-9ded71d1` | `/console/keychains/{id}/resolve` | route | 2 | policy:delegation, surface:console |
| `I-056155e6` | `/console/keys/new` | route | 2 | surface:console |
| `I-109bc0dc` | `/console/keys/{keyId}/lifecycle` | route | 2 | surface:console |
| `I-b98025c0` | `/console/moderation/posts/{postId}` | route | 2 | surface:console |
| `I-25a57177` | `/console/moderation/posts/{postId}/comments/{commentId}` | route | 2 | surface:console |
| `I-9a188db9` | `/console/owners` | route | 4 | surface:console |
| `I-5b759215` | `/console/posts` | route | 2 | surface:console |
| `I-66c336a4` | `/console/posts/new` | route | 2 | surface:console |
| `I-da6f7b50` | `/feed` | route | 2 | — |
| `I-febd9bd9` | `/health` | route | 16 | surface:public |
| `I-fb67237e` | `/jwks` | route | 1 | — |
| `I-eef75a09` | `/key-login` | route | 1 | — |
| `I-4146ec82` | `/login` | route | 1 | — |
| `I-1bad8bd1` | `/posts/new` | route | 2 | — |
| `I-bd548ece` | `/posts/{postId}` | route | 2 | — |
| `I-df8d8ea0` | `/posts/{postId}/comments` | route | 2 | — |
| `I-b4915eb8` | `/posts/{postId}/comments/new` | route | 2 | — |
| `I-b066abe2` | `/posts/{postId}/edit` | route | 2 | — |
| `I-f0e4afa1` | `/posts/{postId}/flag` | route | 2 | — |
| `I-d0c0f4fb` | `/session/refresh` | route | 1 | — |
| `I-57625adf` | `/signup-owner` | route | 1 | — |
| `I-b31bbe62` | `/status` | route | 1 | — |
| `I-04ff4e5c` | `/ui*` | route | 1 | — |
| `I-4d0cf9ba` | `/ui/*` | route | 4 | — |
| `I-3b92c2e0` | `/ui/{route}` | route | 6 | — |
| `I-b8c0a672` | `/workspace/CRE8pw/...` | route | 1 | — |
| `I-a80c56c7` | `/workspace/CRE8pw/docs` | route | 1 | — |
| `I-f3ab442b` | `/workspace/CRE8pw/docs/ssot_canon/` | route | 3 | — |
| `I-418c5509` | `action` | term | 1 | — |
| `I-9d7d7a9b` | `activeSurface` | term | 1 | — |
| `I-122c179a` | `actor_key_id` | term | 1 | — |
| `I-b8de47e3` | `actor_owner_id` | term | 1 | — |
| `I-d391dd39` | `actor_principal_id` | term | 1 | — |
| `I-1fcb5435` | `added_at` | term | 1 | — |
| `I-077176e1` | `added_by_owner_id` | term | 1 | — |
| `I-c4728749` | `adopted` | term | 3 | — |
| `I-39802830` | `api_key` | term | 1 | — |
| `I-1adff618` | `APP_ENV` | term | 2 | — |
| `I-28143ffd` | `auth_invalid` | term | 1 | — |
| `I-f9abf45f` | `auth_required` | term | 1 | — |
| `I-fcf33058` | `auth_seed` | term | 1 | — |
| `I-4f331e2f` | `author_id` | term | 1 | — |
| `I-9c12da23` | `AuthService` | term | 1 | — |
| `I-841a2d68` | `body` | term | 1 | — |
| `I-b3dc3d76` | `BOOT_EVIDENCE_PATH` | term | 3 | — |
| `I-c1336794` | `code` | term | 2 | — |
| `I-a0e5c023` | `collection_memberships` | term | 1 | — |
| `I-cf7ab9da` | `collection_moderation_actions` | term | 1 | — |
| `I-0b9abfe6` | `collections` | term | 1 | — |
| `I-e825aa54` | `comment_not_found` | term | 2 | — |
| `I-a5d49106` | `comments` | term | 4 | — |
| `I-e701fe4d` | `comments:create` | term | 2 | — |
| `I-68bfa9f3` | `CommentsService` | term | 1 | — |
| `I-6b916c6a` | `computed_at` | term | 1 | — |
| `I-c0dbed16` | `computed_by` | term | 1 | — |
| `I-1e65a9b6` | `content_seed` | term | 1 | — |
| `I-6c6897f4` | `content_type_unsupported` | term | 1 | — |
| `I-2abdd45f` | `CORS_ALLOWED_ORIGINS` | term | 1 | — |
| `I-eaf1b05d` | `CorsPolicy` | term | 1 | — |
| `I-3e61ed19` | `cre8_ui_device_id_v1` | term | 1 | — |
| `I-faf3e518` | `cre8_ui_session_v1` | term | 1 | — |
| `I-fde81f11` | `created_at` | term | 1 | — |
| `I-a52fa2cd` | `credential_type` | term | 1 | — |
| `I-d3ed68f7` | `credentials` | term | 6 | — |
| `I-d8e36047` | `CSRF_SECRET` | term | 1 | — |
| `I-94ff1b29` | `csrf_token_malformed` | term | 1 | — |
| `I-2ce91381` | `csrf_token_mismatch` | term | 2 | — |
| `I-9048b183` | `csrf_token_missing` | term | 1 | — |
| `I-39718beb` | `current_token_hash` | term | 1 | — |
| `I-8d777f38` | `data` | term | 4 | — |
| `I-4ab17259` | `DB_DSN` | term | 1 | — |
| `I-f2da870b` | `DB_PASS` | term | 1 | — |
| `I-b37bb560` | `db_probe_exception` | term | 1 | — |
| `I-114feb09` | `DB_USER` | term | 1 | — |
| `I-8377f5fd` | `degraded` | term | 1 | — |
| `I-a9dd0755` | `delegation_envelopes` | term | 6 | policy:authorization |
| `I-f92d154b` | `deleted_at` | term | 1 | — |
| `I-54dac5af` | `deprecated` | term | 1 | — |
| `I-12a055bf` | `depth` | term | 1 | — |
| `I-f812fa07` | `detail_code` | term | 1 | — |
| `I-27792947` | `details` | term | 3 | — |
| `I-9379346c` | `device_id` | term | 6 | — |
| `I-7adbf7cf` | `device_id_invalid_format` | term | 4 | — |
| `I-e55d39c5` | `device_id_missing` | term | 3 | — |
| `I-04f85e7c` | `disabled_at` | term | 1 | — |
| `I-5d6c4646` | `docs:ssot:sync-check` | term | 1 | — |
| `I-275e6932` | `domain_validation` | term | 1 | — |
| `I-74e8333a` | `down` | term | 1 | — |
| `I-eb93b3b0` | `editor_id` | term | 1 | — |
| `I-25e84998` | `effective_permissions_json` | term | 1 | — |
| `I-cf019b3b` | `effective_scope_json` | term | 1 | — |
| `I-e80f956f` | `email_normalized` | term | 1 | — |
| `I-7830db72` | `email_target` | term | 1 | — |
| `I-a2e4822a` | `empty` | term | 1 | — |
| `I-df96c673` | `envelope_version` | term | 4 | — |
| `I-cb5e100e` | `error` | term | 3 | — |
| `I-71cf3871` | `ErrorEnvelope` | term | 1 | — |
| `I-2da2c443` | `event_name` | term | 1 | — |
| `I-81aefa79` | `expires_at` | term | 2 | — |
| `I-9a325d36` | `ext-pdo` | term | 2 | — |
| `I-6c68c248` | `ext-sodium` | term | 3 | — |
| `I-0caa70f7` | `family_id` | term | 1 | — |
| `I-7bf32c92` | `FeedService` | term | 1 | — |
| `I-614e3110` | `fixed_window` | term | 1 | — |
| `I-350f9d68` | `forbidden` | term | 2 | — |
| `I-9c70933a` | `global` | term | 1 | — |
| `I-f418eb5e` | `HealthService` | term | 1 | — |
| `I-b6999f63` | `historical_record` | term | 4 | — |
| `I-53769ae0` | `http_dependency` | term | 1 | — |
| `I-8afe040d` | `http_dependency_exception` | term | 1 | — |
| `I-e416f112` | `http_unauthorized` | term | 1 | — |
| `I-ec2f993a` | `idle` | term | 2 | — |
| `I-ceb420ca` | `initial_author_key_id` | term | 2 | — |
| `I-e55d43ea` | `invalid_argument` | term | 1 | — |
| `I-b27c7546` | `invite_code_hash` | term | 1 | — |
| `I-4faafbe8` | `invite_code_invalid` | term | 1 | — |
| `I-deb95271` | `invite_code_missing` | term | 1 | — |
| `I-6d2b9332` | `invite_receipts` | term | 3 | — |
| `I-c3a64963` | `invite_required` | term | 1 | — |
| `I-b637409e` | `issued_key_id` | term | 1 | — |
| `I-b2058fe7` | `issuer_dependency` | term | 1 | — |
| `I-0f9eb57a` | `json_root_not_object` | term | 1 | — |
| `I-6b70f7aa` | `JwksService` | term | 1 | — |
| `I-fb2a824d` | `JWT_AUDIENCE_CONSOLE` | term | 1 | — |
| `I-4a0fe8d8` | `JWT_AUDIENCE_GATEWAY` | term | 1 | — |
| `I-89affcb3` | `JWT_ISSUER` | term | 1 | — |
| `I-1df41a7a` | `JWT_KEY_TTL_SECONDS` | term | 1 | — |
| `I-2c36f9cc` | `jwt_keys` | term | 1 | — |
| `I-f56fdc9e` | `JWT_PRIVATE_KEY` | term | 1 | — |
| `I-fa3be4e8` | `JWT_PUBLIC_KEY` | term | 1 | — |
| `I-1d305e30` | `JwtPolicy` | term | 1 | — |
| `I-3c6e0b8a` | `key` | term | 1 | — |
| `I-26e9551d` | `key_class` | term | 1 | — |
| `I-07ae8b01` | `key_material` | term | 1 | — |
| `I-834c264a` | `key_material_unavailable` | term | 1 | — |
| `I-f2a6fdc6` | `key_not_found` | term | 3 | — |
| `I-857823c1` | `keychain` | term | 11 | policy:delegation |
| `I-e4dc4137` | `keychain_effective_snapshots` | term | 3 | policy:delegation |
| `I-97e68eaa` | `keychain_key_id` | term | 1 | policy:delegation |
| `I-5491c6f1` | `keychain_memberships` | term | 4 | policy:delegation |
| `I-f467f82f` | `keychain_not_found` | term | 2 | policy:delegation |
| `I-08d8d091` | `keychains` | term | 2 | policy:delegation |
| `I-2e1c5a1b` | `keychains:manage` | term | 1 | policy:delegation |
| `I-ba341076` | `KeychainService` | term | 1 | policy:delegation |
| `I-3f253762` | `KeyLifecycleService` | term | 1 | — |
| `I-b98878a1` | `keys:issue` | term | 2 | — |
| `I-29dacb31` | `keys:revoke` | term | 1 | — |
| `I-a14fa216` | `loading` | term | 2 | — |
| `I-f5ddaf0c` | `local` | term | 1 | — |
| `I-e579f5bb` | `malformed_json` | term | 1 | — |
| `I-eb0a1917` | `master` | term | 4 | — |
| `I-1bd207f5` | `member_count` | term | 1 | — |
| `I-324eefdb` | `member_key_id` | term | 1 | — |
| `I-78e73102` | `message` | term | 2 | — |
| `I-e9a23cbc` | `meta` | term | 7 | — |
| `I-8f5a3770` | `moderation_actions` | term | 3 | — |
| `I-32e2c7c8` | `ModerationService` | term | 1 | — |
| `I-baecdd92` | `mysql:` | term | 1 | — |
| `I-7500611b` | `not_found` | term | 3 | — |
| `I-4358b500` | `Notes` | term | 3 | — |
| `I-f706ec56` | `ONBOARDING_ANALYSIS` | term | 1 | — |
| `I-7cef8a73` | `open` | term | 1 | — |
| `I-d3cc7bb7` | `openapi` | term | 6 | — |
| `I-a39177e6` | `ops:health-smoke` | term | 4 | — |
| `I-3f758f2c` | `ops:migrate-smoke` | term | 3 | — |
| `I-72122ce9` | `owner` | term | 1 | — |
| `I-5e7b1936` | `owner_id` | term | 1 | — |
| `I-b845275d` | `owner_seed` | term | 1 | — |
| `I-e0555de9` | `OWNER_SIGNUP_MODE` | term | 1 | — |
| `I-6bc302b6` | `parent_key_id` | term | 1 | — |
| `I-5f4dcc3b` | `password` | term | 1 | — |
| `I-d3f3ec2d` | `pending-local` | term | 2 | — |
| `I-e8ee8388` | `permission_denied` | term | 2 | — |
| `I-47cf850e` | `permissions_json` | term | 1 | — |
| `I-ec8f5c71` | `pgsql:` | term | 1 | — |
| `I-66241d19` | `post_collection_links` | term | 1 | — |
| `I-05df5668` | `post_flags` | term | 3 | — |
| `I-f3aa1999` | `post_id` | term | 1 | — |
| `I-9bef57ee` | `post_not_found` | term | 4 | — |
| `I-cf8b9b9d` | `post_revisions` | term | 3 | — |
| `I-18958e30` | `posts` | term | 6 | — |
| `I-47a637c0` | `posts:create` | term | 2 | — |
| `I-ddf477b7` | `posts:edit` | term | 1 | — |
| `I-aac902c0` | `posts:read` | term | 1 | — |
| `I-b4efa325` | `PostsService` | term | 1 | — |
| `I-af32b3a9` | `previous_nonce_hash` | term | 1 | — |
| `I-34a39a2f` | `primary_author` | term | 10 | — |
| `I-53877e1c` | `principal_emails` | term | 6 | — |
| `I-53e1ab57` | `principal_id` | term | 1 | — |
| `I-ee98082f` | `principal_type` | term | 1 | — |
| `I-f8b42a80` | `principals` | term | 8 | — |
| `I-156a1733` | `private_key` | term | 1 | — |
| `I-d6e4a9b6` | `prod` | term | 2 | — |
| `I-4c9184f3` | `public` | term | 1 | — |
| `I-2fdfc82c` | `rate_limit_exceeded` | term | 1 | — |
| `I-8f46b40f` | `RATE_LIMIT_GLOBAL_ID` | term | 1 | — |
| `I-63e9ba60` | `rate_limited` | term | 1 | — |
| `I-c84f1106` | `rate_limiter` | term | 2 | — |
| `I-140719c8` | `rate_limiter_rejected` | term | 1 | — |
| `I-c44b22a7` | `RateLimitPolicy` | term | 1 | — |
| `I-c0c4eb0c` | `reason_code` | term | 1 | — |
| `I-2d2a408b` | `removed_at` | term | 1 | — |
| `I-f68d2c36` | `request_id` | term | 13 | ops:observability |
| `I-b4a88417` | `result` | term | 1 | — |
| `I-8aa7c21d` | `revoked_at` | term | 1 | — |
| `I-a9b53444` | `route_method_not_allowed` | term | 1 | — |
| `I-070a6cf9` | `route_not_found` | term | 4 | — |
| `I-be11644c` | `RuntimeConfig` | term | 1 | — |
| `I-2f1d12e4` | `S0-01` | term | 2 | — |
| `I-8f1278a1` | `S0-09` | term | 2 | — |
| `I-ccb617af` | `scope_json` | term | 1 | — |
| `I-82856726` | `secondary_author` | term | 10 | — |
| `I-5ebe2294` | `secret` | term | 1 | — |
| `I-88386f85` | `secret_hash` | term | 1 | — |
| `I-0317120d` | `server_error` | term | 2 | — |
| `I-c3eb98f7` | `sqlite:` | term | 1 | — |
| `I-9ed39e2e` | `state` | term | 1 | — |
| `I-9acb4454` | `status` | term | 3 | — |
| `I-54e2dc4c` | `submitting` | term | 2 | — |
| `I-260ca9dd` | `success` | term | 2 | — |
| `I-b986700a` | `SuccessEnvelope` | term | 1 | — |
| `I-382fa69b` | `superseded` | term | 1 | — |
| `I-d302e976` | `surface` | term | 1 | — |
| `I-c76da330` | `Sx-yy` | term | 1 | — |
| `I-55e2df16` | `target_id` | term | 1 | — |
| `I-2e463512` | `target_type` | term | 1 | — |
| `I-7f5b3e8f` | `TASK-DOC-UX-003` | term | 1 | — |
| `I-8d335794` | `TASK-KEY-SPEC-002` | term | 2 | — |
| `I-098f6bcd` | `test` | term | 1 | — |
| `I-17038a85` | `timestamp_utc` | term | 3 | — |
| `I-d5d3db17` | `title` | term | 1 | — |
| `I-94a08da1` | `token` | term | 1 | — |
| `I-0b2d1299` | `token_audience_invalid` | term | 1 | — |
| `I-ac11f22c` | `token_device_mismatch` | term | 5 | — |
| `I-5efe3cf5` | `token_families` | term | 7 | — |
| `I-f4715b28` | `token_type_invalid` | term | 1 | — |

## 3) Detailed source mapping

### I-18d80423 — `400` (component)
- Pertinent info:
  - table@L11: 400 | bad_request | malformed_json, non_object_json, invalid_argument
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-816b112c — `401` (component)
- Pertinent info:
  - table@L12: 401 | auth_required / auth_invalid | missing_bearer, token_invalid, token_type_invalid, token_audience_invalid, token_expired, token_device_mismatch
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-bbf94b34 — `403` (component)
- Pertinent info:
  - table@L13: 403 | forbidden | csrf_token_missing, csrf_token_malformed, csrf_token_mismatch, permission_denied, use_key_restricted, comments_disabled, invite_code_invalid
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-4f4adcbf — `404` (component)
- Pertinent info:
  - table@L14: 404 | not_found | post_not_found, comment_not_found, key_not_found, keychain_not_found
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-bbcbff5c — `405` (component)
- Pertinent info:
  - table@L15: 405 | method_not_allowed | route_method_not_allowed
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-a96b65a7 — `409` (component)
- Pertinent info:
  - table@L17: 409 | conflict | owner_exists, lifecycle_conflict
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-42e7aaa8 — `415` (component)
- Pertinent info:
  - table@L16: 415 | unsupported_media_type | content_type_unsupported
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-f85454e8 — `422` (component)
- Pertinent info:
  - table@L18: 422 | validation_failed | required, invalid_format, invalid_enum, out_of_range, device_id_missing, device_id_invalid_format, invite_code_missing
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-75fc093c — `429` (component)
- Pertinent info:
  - table@L19: 429 | rate_limited | rate_limit_exceeded
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-cee63112 — `500` (component)
- Pertinent info:
  - table@L20: 500 | internal_error | unhandled_exception
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-d19da09e — ``../../composer.json`` (component)
- Pertinent info:
  - table@L10: `../../composer.json` | Read | root/runtime contract
  - table@L7: `../../composer.json` | Read | Dependency/runtime baseline
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-8052c42a — ``.htaccess`` (component)
- Pertinent info:
  - table@L9: `.htaccess` | Read | root/runtime hosting
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-c13fccf4 — ``/api/posts/{postId}/comments`` (component)
- Pertinent info:
  - openapi path: /api/posts/{postId}/comments
  - route@L33: | `/api/posts/{postId}/comments` | GET | gateway | key JWT + device id | visibility + comment state policy | `/posts/{postId}/comments` |
  - route@L34: | `/api/posts/{postId}/comments` | POST | gateway | key JWT + device id | comments permission + enabled toggle | `/posts/{postId}/comments/new` |
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-895ae219 — ``/api/posts/{postId}/flags`` (component)
- Pertinent info:
  - openapi path: /api/posts/{postId}/flags
  - route@L32: | `/api/posts/{postId}/flags` | POST | gateway | key JWT + device id | flag reason validation | `/posts/{postId}/flag` |
  - table@L32: `/api/posts/{postId}/flags` | POST | gateway
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-6d7579ed — ``/api/posts/{postId}`` (component)
- Pertinent info:
  - openapi path: /api/posts/{postId}
  - route@L30: | `/api/posts/{postId}` | GET | gateway | key JWT + device id | scope/visibility checks | `/posts/{postId}` |
  - route@L31: | `/api/posts/{postId}` | PATCH | gateway | key JWT + device id | author/edit permission checks | `/posts/{postId}/edit` |
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-d7beea1b — ``/api/posts`` (component)
- Pertinent info:
  - openapi path: /api/posts
  - route@L29: | `/api/posts` | POST | gateway | key JWT + device id | permission + use-key mutation guard | `/posts/new` |
  - table@L29: `/api/posts` | POST | gateway
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-0a5672ca — ``/console/api/keychains/{keychainId}/members/{memberKeyId}`` (component)
- Pertinent info:
  - openapi path: /console/api/keychains/{keychainId}/members/{memberKeyId}
  - route@L41: | `/console/api/keychains/{keychainId}/members/{memberKeyId}` | DELETE | console | owner JWT | remove member; recompute effective snapshot | `/console/keychains/{id}` |
  - table@L41: `/console/api/keychains/{keychainId}/members/{memberKeyId}` | DELETE | console
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`
- Relationships: policy:delegation

### I-d0b0342e — ``/console/api/keychains/{keychainId}/members`` (component)
- Pertinent info:
  - openapi path: /console/api/keychains/{keychainId}/members
  - route@L39: | `/console/api/keychains/{keychainId}/members` | GET | console | owner JWT | list active/removed memberships | `/console/keychains/{id}` |
  - route@L40: | `/console/api/keychains/{keychainId}/members` | POST | console | owner JWT | add member key, enforce class/nesting/size invariants | `/console/keychains/{id}/add-member` |
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`
- Relationships: policy:delegation

### I-a907c779 — ``/console/api/keychains/{keychainId}/resolve`` (component)
- Pertinent info:
  - openapi path: /console/api/keychains/{keychainId}/resolve
  - route@L36: 2. Keychain effective permissions/scope resolved via `/console/api/keychains/{keychainId}/resolve`.
  - route@L42: | `/console/api/keychains/{keychainId}/resolve` | GET | console | owner JWT | preview effective permissions/scope + lineage summary | `/console/keychains/{id}/resolve` |
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/20_contracts/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`
- Relationships: policy:delegation

### I-c069cb4d — ``/console/api/keychains`` (component)
- Pertinent info:
  - openapi path: /console/api/keychains
  - route@L37: | `/console/api/keychains` | GET | console | owner JWT | keychain inventory and membership counts | `/console/keychains` |
  - route@L38: | `/console/api/keychains` | POST | console | owner JWT | create keychain key principal | `/console/keychains/new` |
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`
- Relationships: policy:delegation

### I-75665dd2 — ``/console/api/keys/{keyId}/lifecycle`` (component)
- Pertinent info:
  - openapi path: /console/api/keys/{keyId}/lifecycle
  - route@L45: | `/console/api/keys/{keyId}/lifecycle` | POST | console | owner JWT | suspend/cancel/revoke + cascade policy | `/console/keys/{keyId}/lifecycle` |
  - table@L45: `/console/api/keys/{keyId}/lifecycle` | POST | console
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-d5363d5d — ``/console/api/keys`` (component)
- Pertinent info:
  - openapi path: /console/api/keys
  - route@L44: | `/console/api/keys` | POST | console | owner JWT | issue delegated key with envelope bounds | `/console/keys/new` |
  - table@L44: `/console/api/keys` | POST | console
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-ba2c380a — ``/console/api/posts/{postId}/comments/{commentId}/moderation`` (component)
- Pertinent info:
  - openapi path: /console/api/posts/{postId}/comments/{commentId}/moderation
  - route@L47: | `/console/api/posts/{postId}/comments/{commentId}/moderation` | POST | console | owner JWT | comment moderation transitions | `/console/moderation/posts/{postId}/comments/{commentId}` |
  - table@L47: `/console/api/posts/{postId}/comments/{commentId}/moderation` | POST | console
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-3fe3f986 — ``/console/api/posts/{postId}/moderation`` (component)
- Pertinent info:
  - openapi path: /console/api/posts/{postId}/moderation
  - route@L46: | `/console/api/posts/{postId}/moderation` | POST | console | owner JWT | moderation action transitions | `/console/moderation/posts/{postId}` |
  - table@L46: `/console/api/posts/{postId}/moderation` | POST | console
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-5c2bf2de — ``/console/api/posts`` (component)
- Pertinent info:
  - openapi path: /console/api/posts
  - route@L35: | `/console/api/posts` | GET | console | owner JWT | governance listing | `/console/posts` |
  - route@L36: | `/console/api/posts` | POST | console | owner JWT (+ CSRF where applicable) | console-authored post actions | `/console/posts/new` |
- Found in:
  - `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
  - `docs/ssot_canon/openapi/cre8.v1.yaml`

### I-6d163dd2 — `/health reliability` (component)
- Pertinent info:
  - table@L32: `/health` reliability | Health probe success ratio + dependency status dimensions | Platform/SRE owner
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`

### I-b5d0ee8c — ``composer.json`` (component)
- Pertinent info:
  - table@L20: `composer.json` | Read | Root metadata
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`

### I-611208e6 — ``DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}`` (component)
- Pertinent info:
  - heading@L226: `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}`
  - table@L64: `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}` | `/console/keychains/{id}` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- Relationships: policy:delegation

### I-1c0851df — ``docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md`` (component)
- Pertinent info:
  - table@L11: `docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md` | Read | Product identity
  - table@L13: `docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md` | Read | product identity
  - table@L24: `docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md` | Read | Foundation
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-f587dd49 — ``docs/01_foundation/README.md`` (component)
- Pertinent info:
  - table@L12: `docs/01_foundation/README.md` | Read | repo governance
  - table@L23: `docs/01_foundation/README.md` | Read | Foundation
  - table@L9: `docs/01_foundation/README.md` | Read | Canon entrypoint
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-50b7f8da — ``docs/01_foundation/RECOMMENDED_READING_ORDER.md`` (component)
- Pertinent info:
  - table@L15: `docs/01_foundation/RECOMMENDED_READING_ORDER.md` | Read | onboarding protocol
  - table@L26: `docs/01_foundation/RECOMMENDED_READING_ORDER.md` | Read | Foundation
  - table@L77: `docs/01_foundation/RECOMMENDED_READING_ORDER.md` | Read | Onboarding map
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-e3442bfd — ``docs/01_foundation/REPOSITORY_FILE_INVENTORY.md`` (component)
- Pertinent info:
  - table@L16: `docs/01_foundation/REPOSITORY_FILE_INVENTORY.md` | Read | inventory/status
  - table@L28: `docs/01_foundation/REPOSITORY_FILE_INVENTORY.md` | Read | Foundation
  - table@L70: `docs/01_foundation/REPOSITORY_FILE_INVENTORY.md` | Read | Repo inventory
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-86dc5431 — ``docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`` (component)
- Pertinent info:
  - table@L12: `docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md` | Read | Technical strategy
  - table@L14: `docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md` | Read | technical foundation
  - table@L25: `docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md` | Read | Foundation
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-0fef8703 — ``docs/02_onboarding_and_audits/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md`` (component)
- Pertinent info:
  - table@L20: `docs/02_onboarding_and_audits/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md` | Read | synthesis/audit
  - table@L34: `docs/02_onboarding_and_audits/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md` | Read | Synthesis/audit
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-e36f82fc — ``docs/02_onboarding_and_audits/HIGH_LEVEL_REPORT_2026-04-09.md`` (component)
- Pertinent info:
  - table@L18: `docs/02_onboarding_and_audits/HIGH_LEVEL_REPORT_2026-04-09.md` | Read | synthesis historical
  - table@L30: `docs/02_onboarding_and_audits/HIGH_LEVEL_REPORT_2026-04-09.md` | Read | Synthesis/audit
  - table@L71: `docs/02_onboarding_and_audits/HIGH_LEVEL_REPORT_2026-04-09.md` | Read | SSOT status snapshot
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-6e47b524 — ``docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md`` (component)
- Pertinent info:
  - table@L17: `docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md` | Read | onboarding control
  - table@L36: `docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md` | Read | Synthesis/audit
  - table@L76: `docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md` | Read | Onboarding ops
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-bc856ef2 — ``docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`` (component)
- Pertinent info:
  - table@L19: `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md` | Read | synthesis
  - table@L32: `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md` | Read | Synthesis/audit
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-314b0018 — ``docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_CODEX_REFRESH.md`` (component)
- Pertinent info:
  - table@L38: `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_CODEX_REFRESH.md` | Read | Synthesis/audit
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`

### I-86c81147 — ``docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`` (component)
- Pertinent info:
  - table@L40: `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md` | Read | Synthesis/audit
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`

### I-5b2c37cb — ``docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md`` (component)
- Pertinent info:
  - table@L24: `docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md` | Read | execution slices
  - table@L44: `docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md` | Read | Execution planning
  - table@L79: `docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md` | Read | Execution planning
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-1ec3a593 — ``docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`` (component)
- Pertinent info:
  - table@L23: `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md` | Read | execution plan
  - table@L42: `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md` | Read | Execution planning
  - table@L78: `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md` | Read | Execution planning
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-fede5857 — ``docs/04_instructional_notes/INSTRUCTOR_FOLLOWUP_LECTURE_EXTENDING_CRE8.md`` (component)
- Pertinent info:
  - table@L22: `docs/04_instructional_notes/INSTRUCTOR_FOLLOWUP_LECTURE_EXTENDING_CRE8.md` | Read | supporting narrative
  - table@L48: `docs/04_instructional_notes/INSTRUCTOR_FOLLOWUP_LECTURE_EXTENDING_CRE8.md` | Read | Instructional
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-342e06bb — ``docs/04_instructional_notes/INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md`` (component)
- Pertinent info:
  - table@L21: `docs/04_instructional_notes/INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md` | Read | supporting narrative
  - table@L46: `docs/04_instructional_notes/INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md` | Read | Instructional
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-d0b43d61 — ``docs/README.md`` (component)
- Pertinent info:
  - table@L22: `docs/README.md` | Read | Documentation nav
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`

### I-e9130218 — ``docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md`` (component)
- Pertinent info:
  - table@L19: `docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md` | Read | Change control
  - table@L27: `docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md` | Read | governance canon
  - table@L54: `docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md` | Read | SSOT governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-871f0675 — ``docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`` (component)
- Pertinent info:
  - table@L18: `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md` | Read | Governance ownership
  - table@L26: `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md` | Read | governance canon
  - table@L52: `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md` | Read | SSOT governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-0bcfd3ee — ``docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`` (component)
- Pertinent info:
  - table@L20: `docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` | Read | Documentation standards
  - table@L28: `docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` | Read | governance canon
  - table@L56: `docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` | Read | SSOT governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-0d36d3f7 — ``docs/ssot_canon/00_governance/SSOT_INDEX.md`` (component)
- Pertinent info:
  - table@L10: `docs/ssot_canon/00_governance/SSOT_INDEX.md` | Read | Governance index
  - table@L25: `docs/ssot_canon/00_governance/SSOT_INDEX.md` | Read | governance canon
  - table@L50: `docs/ssot_canon/00_governance/SSOT_INDEX.md` | Read | SSOT governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-1b8d83d4 — ``docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`` (component)
- Pertinent info:
  - table@L15: `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md` | Read | Architecture boundaries
  - table@L31: `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md` | Read | architecture canon
  - table@L62: `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md` | Read | Product/architecture
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-be3c91d3 — ``docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`` (component)
- Pertinent info:
  - table@L14: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md` | Read | Terminology
  - table@L30: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md` | Read | product language
  - table@L60: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md` | Read | Product/architecture
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-e0299aa0 — ``docs/ssot_canon/10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md`` (component)
- Pertinent info:
  - table@L64: `docs/ssot_canon/10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md` | Read | Product/architecture
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`

### I-99356e19 — ``docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`` (component)
- Pertinent info:
  - table@L13: `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md` | Read | Product/system spec
  - table@L29: `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md` | Read | product/architecture canon
  - table@L58: `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md` | Read | Product/architecture
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-cf4b7f20 — ``docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`` (component)
- Pertinent info:
  - table@L17: `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md` | Read | Dependency governance
  - table@L33: `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md` | Read | architecture/runtime
  - table@L68: `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md` | Read | Product/architecture
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-923b498d — ``docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`` (component)
- Pertinent info:
  - table@L21: `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md` | Read | API contract
  - table@L34: `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md` | Read | API canon
  - table@L70: `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-18a9fd9e — ``docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`` (component)
- Pertinent info:
  - table@L23: `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md` | Read | AuthZ/delegation
  - table@L36: `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md` | Read | authz canon
  - table@L74: `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`
- Relationships: policy:authorization

### I-5f4b875e — ``docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`` (component)
- Pertinent info:
  - table@L24: `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md` | Read | Policy decision logic
  - table@L37: `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md` | Read | authz canon
  - table@L76: `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-cdc158b7 — ``docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`` (component)
- Pertinent info:
  - table@L27: `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md` | Read | Examples
  - table@L40: `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md` | Read | API examples
  - table@L82: `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-eb91bba1 — ``docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`` (component)
- Pertinent info:
  - table@L26: `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md` | Read | Error taxonomy
  - table@L39: `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md` | Read | error canon
  - table@L80: `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-f1c97b8d — ``docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`` (component)
- Pertinent info:
  - table@L22: `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md` | Read | Route governance
  - table@L35: `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md` | Read | route canon
  - table@L72: `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-23cdbab6 — ``docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`` (component)
- Pertinent info:
  - table@L25: `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md` | Read | UI/backend coupling
  - table@L38: `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md` | Read | UI contract
  - table@L78: `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-c444ca41 — ``docs/ssot_canon/20_contracts/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md`` (component)
- Pertinent info:
  - table@L84: `docs/ssot_canon/20_contracts/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md` | Read | Contracts
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`

### I-31c41b64 — ``docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`` (component)
- Pertinent info:
  - table@L29: `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md` | Read | Data architecture
  - table@L42: `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md` | Read | data canon
  - table@L88: `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md` | Read | Data/security
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-af57ede1 — ``docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`` (component)
- Pertinent info:
  - table@L28: `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md` | Read | Schema contract
  - table@L41: `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md` | Read | data canon
  - table@L86: `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md` | Read | Data/security
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-76b183ae — ``docs/ssot_canon/30_data_and_security/ERD.md`` (component)
- Pertinent info:
  - table@L30: `docs/ssot_canon/30_data_and_security/ERD.md` | Read | Data relationships
  - table@L43: `docs/ssot_canon/30_data_and_security/ERD.md` | Read | data canon
  - table@L90: `docs/ssot_canon/30_data_and_security/ERD.md` | Read | Data/security
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-26807f19 — ``docs/ssot_canon/30_data_and_security/MASTER_KEY_SPEC.md`` (component)
- Pertinent info:
  - table@L44: `docs/ssot_canon/30_data_and_security/MASTER_KEY_SPEC.md` | Read | security/data
  - table@L92: `docs/ssot_canon/30_data_and_security/MASTER_KEY_SPEC.md` | Read | Data/security
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-0f71b6fb — ``docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`` (component)
- Pertinent info:
  - table@L31: `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md` | Read | Security controls
  - table@L45: `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md` | Read | security canon
  - table@L94: `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md` | Read | Data/security
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-c6033218 — ``docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md`` (component)
- Pertinent info:
  - table@L33: `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md` | Read | Headers/CSP contract
  - table@L47: `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md` | Read | security canon
  - table@L98: `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md` | Read | Data/security
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-9663092e — ``docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md`` (component)
- Pertinent info:
  - table@L32: `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md` | Read | Threat model
  - table@L46: `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md` | Read | security canon
  - table@L96: `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md` | Read | Data/security
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-3508800c — ``docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`` (component)
- Pertinent info:
  - table@L100: `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md` | Read | Data/security
  - table@L34: `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md` | Read | Abuse-case verification
  - table@L48: `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md` | Read | security verification
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-cf8163f3 — ``docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`` (component)
- Pertinent info:
  - table@L104: `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` | Read | Ops/quality
  - table@L36: `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` | Read | Behavioral acceptance
  - table@L50: `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` | Read | ops/quality canon
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-c8b1b1f7 — ``docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md`` (component)
- Pertinent info:
  - table@L108: `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md` | Read | Ops/quality
  - table@L38: `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md` | Read | Startup behavior
  - table@L52: `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md` | Read | ops/runtime
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-dc7d52ce — ``docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md`` (component)
- Pertinent info:
  - table@L110: `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md` | Read | Ops/quality
  - table@L39: `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md` | Read | Health semantics
  - table@L53: `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md` | Read | ops/runtime
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-578d0cb7 — ``docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md`` (component)
- Pertinent info:
  - table@L116: `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md` | Read | Ops/quality
  - table@L42: `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md` | Read | DB operations
  - table@L56: `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md` | Read | ops/data
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-22484797 — ``docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md`` (component)
- Pertinent info:
  - table@L112: `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md` | Read | Ops/quality
  - table@L40: `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md` | Read | Observability
  - table@L54: `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md` | Read | observability
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-5b98bf0b — ``docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`` (component)
- Pertinent info:
  - table@L118: `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md` | Read | Ops/quality
  - table@L43: `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md` | Read | Ops smoke
  - table@L57: `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md` | Read | ops/release
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-a4f7a780 — ``docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md`` (component)
- Pertinent info:
  - table@L120: `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md` | Read | Ops/quality
  - table@L44: `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md` | Read | Release gates
  - table@L58: `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md` | Read | ops/release
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-6db962e7 — ``docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md`` (component)
- Pertinent info:
  - table@L122: `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md` | Read | Ops/quality
  - table@L45: `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md` | Read | Release process
  - table@L59: `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md` | Read | ops/release
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-8c0e19ac — ``docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`` (component)
- Pertinent info:
  - table@L114: `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md` | Read | Ops/quality
  - table@L41: `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md` | Read | Reliability targets
  - table@L55: `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md` | Read | reliability
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-4c20d4e1 — ``docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`` (component)
- Pertinent info:
  - table@L102: `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md` | Read | Ops/quality
  - table@L35: `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md` | Read | Test strategy
  - table@L49: `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md` | Read | ops/quality canon
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-07abf8c2 — ``docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`` (component)
- Pertinent info:
  - table@L128: `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md` | Read | Traceability/automation
  - table@L48: `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md` | Read | Impact templates
  - table@L62: `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md` | Read | traceability process
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-c5169a30 — ``docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`` (component)
- Pertinent info:
  - table@L130: `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md` | Read | Traceability/automation
  - table@L49: `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md` | Read | Reconciliation
  - table@L63: `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md` | Read | traceability process
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-596e789e — ``docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md`` (component)
- Pertinent info:
  - table@L126: `docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md` | Read | Traceability/automation
  - table@L47: `docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md` | Read | Automation governance
  - table@L61: `docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md` | Read | traceability automation
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-51b7c7f1 — ``docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`` (component)
- Pertinent info:
  - table@L124: `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md` | Read | Traceability/automation
  - table@L46: `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md` | Read | Docs-to-code traceability
  - table@L60: `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md` | Read | traceability canon
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-9c2ba77a — ``docs/ssot_canon/60_decisions/ADR_INDEX.md`` (component)
- Pertinent info:
  - table@L132: `docs/ssot_canon/60_decisions/ADR_INDEX.md` | Read | Decisions
  - table@L51: `docs/ssot_canon/60_decisions/ADR_INDEX.md` | Read | Decision index
  - table@L64: `docs/ssot_canon/60_decisions/ADR_INDEX.md` | Read | decision governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-0b0d2b16 — ``docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md`` (component)
- Pertinent info:
  - table@L146: `docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md` | Read | Decisions
  - table@L58: `docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md` | Read | ADR process
  - table@L66: `docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md` | Read | decision governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-cc6a48dd — ``docs/ssot_canon/60_decisions/DECISIONS_LOG.md`` (component)
- Pertinent info:
  - table@L134: `docs/ssot_canon/60_decisions/DECISIONS_LOG.md` | Read | Decisions
  - table@L52: `docs/ssot_canon/60_decisions/DECISIONS_LOG.md` | Read | Decision chronology
  - table@L65: `docs/ssot_canon/60_decisions/DECISIONS_LOG.md` | Read | decision governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-5277f3e0 — ``docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md`` (component)
- Pertinent info:
  - table@L136: `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md` | Read | Decisions
  - table@L53: `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md` | Read | ADR
  - table@L67: `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md` | Read | ADR
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-f5be585e — ``docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md`` (component)
- Pertinent info:
  - table@L138: `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md` | Read | Decisions
  - table@L54: `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md` | Read | ADR
  - table@L68: `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md` | Read | ADR
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`
- Relationships: policy:authorization

### I-2fb455db — ``docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md`` (component)
- Pertinent info:
  - table@L140: `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md` | Read | Decisions
  - table@L55: `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md` | Read | ADR
  - table@L69: `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md` | Read | ADR
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`
- Relationships: policy:delegation

### I-51090d8d — ``docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md`` (component)
- Pertinent info:
  - table@L142: `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md` | Read | Decisions
  - table@L56: `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md` | Read | ADR
  - table@L70: `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md` | Read | ADR
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-e1dab679 — ``docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md`` (component)
- Pertinent info:
  - table@L144: `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md` | Read | Decisions
  - table@L57: `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md` | Read | ADR
  - table@L71: `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md` | Read | ADR
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-e42bdd86 — ``docs/ssot_canon/70_implementation_guidance/EXTENSIBILITY_PLAYBOOK.md`` (component)
- Pertinent info:
  - table@L152: `docs/ssot_canon/70_implementation_guidance/EXTENSIBILITY_PLAYBOOK.md` | Read | Implementation guidance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`

### I-2d2e0cab — ``docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`` (component)
- Pertinent info:
  - table@L148: `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md` | Read | Implementation guidance
  - table@L59: `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md` | Read | Implementation guidance
  - table@L72: `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md` | Read | implementation guidance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-af92af71 — ``docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md`` (component)
- Pertinent info:
  - table@L156: `docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md` | Read | Implementation guidance
  - table@L62: `docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md` | Read | Test-data strategy
  - table@L75: `docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md` | Read | implementation guidance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-e0cc7255 — ``docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md`` (component)
- Pertinent info:
  - table@L158: `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md` | Read | Program management
  - table@L65: `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md` | Read | Contribution process
  - table@L77: `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md` | Read | program/governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-42bfe9a0 — ``docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md`` (component)
- Pertinent info:
  - table@L160: `docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md` | Read | Program management
  - table@L66: `docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md` | Read | DoD
  - table@L78: `docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md` | Read | program/governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-528af75c — ``docs/ssot_canon/80_program_management/KEY_HIERARCHY_SCALE_ANALYSIS_TASK.md`` (component)
- Pertinent info:
  - table@L170: `docs/ssot_canon/80_program_management/KEY_HIERARCHY_SCALE_ANALYSIS_TASK.md` | Read | Program management
  - table@L80: `docs/ssot_canon/80_program_management/KEY_HIERARCHY_SCALE_ANALYSIS_TASK.md` | Read | program task
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-41775b4e — ``docs/ssot_canon/80_program_management/KEY_TYPE_SPEC_COHERENCE_TASK.md`` (component)
- Pertinent info:
  - table@L166: `docs/ssot_canon/80_program_management/KEY_TYPE_SPEC_COHERENCE_TASK.md` | Read | Program management
  - table@L81: `docs/ssot_canon/80_program_management/KEY_TYPE_SPEC_COHERENCE_TASK.md` | Read | program task
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-51d9e328 — ``docs/ssot_canon/80_program_management/MASTER_KEY_HIERARCHY_ANALYSIS_TASK.md`` (component)
- Pertinent info:
  - table@L168: `docs/ssot_canon/80_program_management/MASTER_KEY_HIERARCHY_ANALYSIS_TASK.md` | Read | Program management
  - table@L82: `docs/ssot_canon/80_program_management/MASTER_KEY_HIERARCHY_ANALYSIS_TASK.md` | Read | program task
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-cc59ebad — ``docs/ssot_canon/80_program_management/RISK_REGISTER.md`` (component)
- Pertinent info:
  - table@L162: `docs/ssot_canon/80_program_management/RISK_REGISTER.md` | Read | Program management
  - table@L50: `docs/ssot_canon/80_program_management/RISK_REGISTER.md` | Read | Risk governance
  - table@L64: `docs/ssot_canon/80_program_management/RISK_REGISTER.md` | Read | Risk management
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-16d1de00 — ``docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md`` (component)
- Pertinent info:
  - table@L164: `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md` | Read | Program management
  - table@L63: `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md` | Read | Program roadmap
  - table@L76: `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md` | Read | program mgmt
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-85a980df — ``docs/ssot_canon/evidence/automation/ssot_report.json`` (component)
- Pertinent info:
  - table@L182: `docs/ssot_canon/evidence/automation/ssot_report.json` | Read | Evidence automation
  - table@L75: `docs/ssot_canon/evidence/automation/ssot_report.json` | Read | Automation evidence
  - table@L88: `docs/ssot_canon/evidence/automation/ssot_report.json` | Read | automation evidence
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-9061000e — ``docs/ssot_canon/evidence/HISTORICAL_SSOT_CHANGE_EVIDENCE_2026-04-21.md`` (component)
- Pertinent info:
  - table@L176: `docs/ssot_canon/evidence/HISTORICAL_SSOT_CHANGE_EVIDENCE_2026-04-21.md` | Read | Evidence
  - table@L87: `docs/ssot_canon/evidence/HISTORICAL_SSOT_CHANGE_EVIDENCE_2026-04-21.md` | Read | evidence historical
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-eb75e66b — ``docs/ssot_canon/evidence/README.md`` (component)
- Pertinent info:
  - table@L172: `docs/ssot_canon/evidence/README.md` | Read | Evidence
  - table@L67: `docs/ssot_canon/evidence/README.md` | Read | Evidence framework
  - table@L83: `docs/ssot_canon/evidence/README.md` | Read | evidence governance
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-bcbee0e2 — ``docs/ssot_canon/evidence/SSOT_CHANGE_EVIDENCE_2026-04-21_MASTER_RESOLUTION.md`` (component)
- Pertinent info:
  - table@L174: `docs/ssot_canon/evidence/SSOT_CHANGE_EVIDENCE_2026-04-21_MASTER_RESOLUTION.md` | Read | Evidence
  - table@L86: `docs/ssot_canon/evidence/SSOT_CHANGE_EVIDENCE_2026-04-21_MASTER_RESOLUTION.md` | Read | evidence record
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-64b6db3c — ``docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md`` (component)
- Pertinent info:
  - table@L180: `docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md` | Read | Evidence
  - table@L69: `docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md` | Read | Evidence template
  - table@L85: `docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md` | Read | evidence template
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-ae5acd5d — ``docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md`` (component)
- Pertinent info:
  - table@L178: `docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md` | Read | Evidence
  - table@L68: `docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md` | Read | Evidence template
  - table@L84: `docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md` | Read | evidence template
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-e9562552 — ``docs/ssot_canon/openapi/cre8.v1.yaml`` (component)
- Pertinent info:
  - table@L184: `docs/ssot_canon/openapi/cre8.v1.yaml` | Read | Machine contract
  - table@L72: `docs/ssot_canon/openapi/cre8.v1.yaml` | Read | Machine contract
  - table@L89: `docs/ssot_canon/openapi/cre8.v1.yaml` | Read | machine contract
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-ee128594 — ``docs/ssot_canon/schemas/error-envelope.schema.json`` (component)
- Pertinent info:
  - table@L188: `docs/ssot_canon/schemas/error-envelope.schema.json` | Read | Machine contract
  - table@L74: `docs/ssot_canon/schemas/error-envelope.schema.json` | Read | Machine schema
  - table@L91: `docs/ssot_canon/schemas/error-envelope.schema.json` | Read | machine contract
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-987a40d1 — ``docs/ssot_canon/schemas/success-envelope.schema.json`` (component)
- Pertinent info:
  - table@L186: `docs/ssot_canon/schemas/success-envelope.schema.json` | Read | Machine contract
  - table@L73: `docs/ssot_canon/schemas/success-envelope.schema.json` | Read | Machine schema
  - table@L90: `docs/ssot_canon/schemas/success-envelope.schema.json` | Read | machine contract
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-7e1c9b54 — ``dot.env`` (component)
- Pertinent info:
  - table@L11: `dot.env` | Read | root/config scaffold
  - table@L21: `dot.env` | Read | Root metadata
  - table@L8: `dot.env` | Read | Local env scaffold
- Found in:
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_ENGINEER_WORKING_MODEL.md`
  - `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-22_STAFF_MODEL.md`

### I-02fbd127 — ``GET /api/feed`` (component)
- Pertinent info:
  - heading@L110: `GET /api/feed`
  - table@L47: `GET /api/feed` | `/feed` | `success` or `empty`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-2c66e3a3 — ``GET /api/posts/{postId}/comments`` (component)
- Pertinent info:
  - heading@L161: `GET /api/posts/{postId}/comments`
  - table@L52: `GET /api/posts/{postId}/comments` | `/posts/{postId}/comments` | `success` or `empty`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-64ad687e — ``GET /api/posts/{postId}`` (component)
- Pertinent info:
  - heading@L132: `GET /api/posts/{postId}`
  - table@L49: `GET /api/posts/{postId}` | `/posts/{postId}` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-be6fb47c — ``GET /console/api/keychains/{keychainId}/members`` (component)
- Pertinent info:
  - heading@L210: `GET /console/api/keychains/{keychainId}/members`
  - table@L62: `GET /console/api/keychains/{keychainId}/members` | `/console/keychains/{id}` | `success` or `empty`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- Relationships: policy:delegation

### I-d35b6968 — ``GET /console/api/keychains/{keychainId}/resolve`` (component)
- Pertinent info:
  - heading@L232: `GET /console/api/keychains/{keychainId}/resolve`
  - table@L65: `GET /console/api/keychains/{keychainId}/resolve` | `/console/keychains/{id}/resolve` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- Relationships: policy:delegation

### I-a34382a0 — ``GET /console/api/keychains`` (component)
- Pertinent info:
  - heading@L194: `GET /console/api/keychains`
  - table@L60: `GET /console/api/keychains` | `/console/keychains` | `success` or `empty`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- Relationships: policy:delegation

### I-0d1d0f0f — ``GET /console/api/posts`` (component)
- Pertinent info:
  - heading@L178: `GET /console/api/posts`
  - table@L58: `GET /console/api/posts` | `/console/posts` | `success` or `empty`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-14677f40 — ``PATCH /api/posts/{postId}`` (component)
- Pertinent info:
  - heading@L141: `PATCH /api/posts/{postId}`
  - table@L50: `PATCH /api/posts/{postId}` | `/posts/{postId}/edit` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-5ef32a8f — ``POST /api/posts/{postId}/comments`` (component)
- Pertinent info:
  - heading@L167: `POST /api/posts/{postId}/comments`
  - table@L53: `POST /api/posts/{postId}/comments` | `/posts/{postId}/comments/new` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-c54aa6a8 — ``POST /api/posts/{postId}/flags`` (component)
- Pertinent info:
  - heading@L151: `POST /api/posts/{postId}/flags`
  - table@L51: `POST /api/posts/{postId}/flags` | `/posts/{postId}/flag` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-d7070301 — ``POST /api/posts`` (component)
- Pertinent info:
  - heading@L119: `POST /api/posts`
  - table@L48: `POST /api/posts` | `/posts/new` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-17f80b46 — ``POST /console/api/invites`` (component)
- Pertinent info:
  - heading@L245: `POST /console/api/invites`
  - table@L66: `POST /console/api/invites` | `/console/invites/new` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-1c4a37e7 — ``POST /console/api/keychains/{keychainId}/members`` (component)
- Pertinent info:
  - heading@L216: `POST /console/api/keychains/{keychainId}/members`
  - table@L63: `POST /console/api/keychains/{keychainId}/members` | `/console/keychains/{id}/add-member` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- Relationships: policy:delegation

### I-41235f5e — ``POST /console/api/keychains`` (component)
- Pertinent info:
  - heading@L200: `POST /console/api/keychains`
  - table@L61: `POST /console/api/keychains` | `/console/keychains/new` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- Relationships: policy:delegation

### I-1d082f46 — ``POST /console/api/keys/{keyId}/lifecycle`` (component)
- Pertinent info:
  - heading@L270: `POST /console/api/keys/{keyId}/lifecycle`
  - table@L68: `POST /console/api/keys/{keyId}/lifecycle` | `/console/keys/{keyId}/lifecycle` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-39ca2998 — ``POST /console/api/keys`` (component)
- Pertinent info:
  - heading@L255: `POST /console/api/keys`
  - table@L67: `POST /console/api/keys` | `/console/keys/new` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-88185e3d — ``POST /console/api/posts/{postId}/comments/{commentId}/moderation`` (component)
- Pertinent info:
  - heading@L290: `POST /console/api/posts/{postId}/comments/{commentId}/moderation`
  - table@L70: `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | `/console/moderation/posts/{postId}/comments/{commentId}` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-f4d559ab — ``POST /console/api/posts/{postId}/moderation`` (component)
- Pertinent info:
  - heading@L280: `POST /console/api/posts/{postId}/moderation`
  - table@L69: `POST /console/api/posts/{postId}/moderation` | `/console/moderation/posts/{postId}` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-4ee04f79 — ``POST /console/api/posts`` (component)
- Pertinent info:
  - heading@L184: `POST /console/api/posts`
  - table@L59: `POST /console/api/posts` | `/console/posts/new` | `success`
- Found in:
  - `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-5ef76d30 — ``use`` (component)
- Pertinent info:
  - table@L40: `use` | yes | same activity constraints
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-88295d11 — `X-Device-Id malformed` (component)
- Pertinent info:
  - table@L78: `X-Device-Id` malformed | Deny (`422 validation_failed`, `device_id_invalid_format`)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-43ad4669 — `X-Device-Id missing` (component)
- Pertinent info:
  - table@L77: `X-Device-Id` missing | Deny (`422 validation_failed`, `device_id_missing`)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-21232f29 — `admin` (component)
- Pertinent info:
  - table@L62: admin | root governance policy changes | no
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-24e23f18 — `admin (owner-delegated)` (component)
- Pertinent info:
  - table@L61: admin (owner-delegated) | moderation actions | yes
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-9fa518c5 — `API availability (`/api/*`, `/console/api/*`)` (component)
- Pertinent info:
  - table@L29: API availability (`/api/*`, `/console/api/*`) | HTTP gateway metrics + envelope status counters | Platform/SRE owner
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`

### I-f8d649a4 — `API route` (component)
- Pertinent info:
  - table@L45: API route | UI route | Success state
  - table@L56: API route | UI route | Success state
- Found in:
  - `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`

### I-3e7e2d6b — `Architecture & module boundaries` (component)
- Pertinent info:
  - table@L353: Architecture & module boundaries | Module contracts, ownership map, dependency policy | Architecture conformance checks, dependency graph report
- Found in:
  - `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`

### I-11fa3a9a — `Auth + lifecycle` (component)
- Pertinent info:
  - table@L17: Auth + lifecycle | Security/backend lead | Platform lead
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-91255375 — `Auth latency (owner/key login)` (component)
- Pertinent info:
  - table@L30: Auth latency (owner/key login) | Route-level latency histogram (`/api/auth/login`, `/api/auth/key-login`) | Backend maintainer lead
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`

### I-1473e32d — `Auth/AuthZ/Delegation` (component)
- Pertinent info:
  - table@L356: Auth/AuthZ/Delegation | Token flows, policy engine, lifecycle controls | Decision-table conformance, abuse-case tests, audit-event proof
- Found in:
  - `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`
- Relationships: policy:authorization

### I-d2697521 — `Authorization/policy` (component)
- Pertinent info:
  - table@L18: Authorization/policy | Security lead | Backend lead
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-395d573f — `Backend runtime` (component)
- Pertinent info:
  - table@L354: Backend runtime | Boot pipeline, middleware, handlers, domain services | Unit/integration/contract tests, startup evidence
- Found in:
  - `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`

### I-11a5688f — `Capability changed` (component)
- Pertinent info:
  - table@L12: Capability changed | Human-readable capability name
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`

### I-74ef8e10 — `Child expiry missing` (component)
- Pertinent info:
  - table@L19: Child expiry missing | Deny (`422 validation_failed`)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-26860d28 — `Child permissions are strict subset of parent envelope` (component)
- Pertinent info:
  - table@L15: Child permissions are strict subset of parent envelope | Allow if all other checks pass
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-07d0baf7 — `Child permissions exceed parent` (component)
- Pertinent info:
  - table@L16: Child permissions exceed parent | Deny (`403 forbidden`, detail `permission_denied`)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-c9b85e15 — `Child scope exceeds parent` (component)
- Pertinent info:
  - table@L17: Child scope exceeds parent | Deny (`403 forbidden`)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-d0df3bfb — `Comment list/create` (component)
- Pertinent info:
  - table@L17: Comment list/create | `GET/POST /api/posts/{postId}/comments` | key jwt + post/comment policy
  - table@L32: Comment list/create | `GET/POST /api/posts/{postId}/comments` | Given post visibility and comments policy, when requested/submitted, then comment list/create succeeds per permissions.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-83d41889 — `Console post ops` (component)
- Pertinent info:
  - table@L18: Console post ops | `GET/POST /console/api/posts` | owner jwt + csrf where applicable
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-c7d08ae1 — `Console posts` (component)
- Pertinent info:
  - table@L33: Console posts | `GET/POST /console/api/posts` | Given owner JWT (+CSRF for writes), when requested, then governance listing/create actions succeed.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

### I-db72d56f — `Content + moderation` (component)
- Pertinent info:
  - table@L19: Content + moderation | Backend lead | QA lead
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-15e44355 — `Contract artifacts impacted` (component)
- Pertinent info:
  - table@L14: Contract artifacts impacted | OpenAPI/schemas/docs
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`

### I-ca969a1b — `CSRF` (component)
- Pertinent info:
  - table@L34: CSRF | `csrf_token_missing` | `403 forbidden`
  - table@L35: CSRF | `csrf_token_malformed` | `403 forbidden`
  - table@L36: CSRF | `csrf_token_mismatch` | `403 forbidden`
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-c42a44bb — `CSRF on console write` (component)
- Pertinent info:
  - table@L18: CSRF on console write | Induce browser write without intent | CSRF middleware rejects invalid/missing token
- Found in:
  - `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`

### I-3e3b0316 — `D-001` (component)
- Pertinent info:
  - table@L14: D-001 | Route contracts | Prototype route docs were partial and non-versioned
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`

### I-63a0a710 — `D-002` (component)
- Pertinent info:
  - table@L15: D-002 | Authorization | Prototype omitted production keychain semantics
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`

### I-208666f2 — `D-003` (component)
- Pertinent info:
  - table@L16: D-003 | Verification | Prototype test guidance was ad hoc
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`

### I-bdf7db9f — `Data & migrations` (component)
- Pertinent info:
  - table@L355: Data & migrations | Schema, migrations, seeds, rollback scripts | Migration smoke, rollback rehearsal, integrity checks
- Found in:
  - `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`

### I-8dba6756 — `Data + security` (component)
- Pertinent info:
  - table@L16: Data + security | Security lead | Backend lead
- Found in:
  - `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`

### I-b9ac02a8 — `Data-model extension` (component)
- Pertinent info:
  - table@L33: Data-model extension | Data model spec/reference/ERD + migration strategy + traceability matrix | Backend lead
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-e828296d — `Data/security impact` (component)
- Pertinent info:
  - table@L15: Data/security impact | Schema/policy/control changes
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`

### I-cf8df498 — `Deep health` (component)
- Pertinent info:
  - table@L21: Deep health | `GET /health` | Given dependencies are healthy, when requested, then all subsystem checks pass.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

### I-3e06203a — `Delegated platform` (component)
- Pertinent info:
  - table@L29: Delegated platform | required | required
- Found in:
  - `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`

### I-2217c39f — `Delegation escalation` (component)
- Pertinent info:
  - table@L17: Delegation escalation | Mint child with broader perms/scope | Subset-only envelope enforcement + max-depth enforcement
- Found in:
  - `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`
- Relationships: policy:authorization

### I-b789995b — `Delta ID` (component)
- Pertinent info:
  - table@L12: Delta ID | Area | Prototype behavior
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`

### I-e71e4f4d — `Device guard` (component)
- Pertinent info:
  - table@L39: Device guard | `device_id_missing` | `422 validation_failed`
  - table@L40: Device guard | `device_id_invalid_format` | `422 validation_failed`
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-797ade3b — `Device-header bypass` (component)
- Pertinent info:
  - table@L21: Device-header bypass | Access gateway route without required device policy | Device policy denies missing/invalid header
- Found in:
  - `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`

### I-ba14f572 — `Document family` (component)
- Pertinent info:
  - table@L12: Document family | Primary owner | Required co-reviewers
- Found in:
  - `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`

### I-db899c25 — `Domain resolver` (component)
- Pertinent info:
  - table@L47: Domain resolver | `post_not_found` | `404 not_found`
  - table@L48: Domain resolver | `comment_not_found` | `404 not_found`
  - table@L49: Domain resolver | `key_not_found` | `404 not_found`
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-4ccb4cc9 — `Error budget burn` (component)
- Pertinent info:
  - table@L33: Error budget burn | 5xx ratio + anomaly detector on 401/403/429 families | Platform/SRE owner
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`

### I-a4bdc899 — `Error handler` (component)
- Pertinent info:
  - table@L25: Error handler | `route_not_found` (unmatched template only) | `404 not_found`
  - table@L26: Error handler | `route_method_not_allowed` | `405 method_not_allowed`
  - table@L27: Error handler | `http_unauthorized` | `401 auth_invalid`
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-8ff495a1 — `Extension seam` (component)
- Pertinent info:
  - table@L29: Extension seam | Required synchronized artifacts | Primary reviewer
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-40016185 — `Feed latency (`GET /api/feed`)` (component)
- Pertinent info:
  - table@L31: Feed latency (`GET /api/feed`) | Route-level latency histogram + DB timing spans | Backend maintainer lead
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`

### I-3328d6a5 — `Feed read` (component)
- Pertinent info:
  - table@L15: Feed read | `GET /api/feed` | key jwt + device + rate limit
  - table@L28: Feed read | `GET /api/feed` | Given key JWT and required headers, when requested, then feed returns scoped content in stable order.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-06e3d36f — `Field` (component)
- Pertinent info:
  - table@L10: Field | Required content
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`

### I-4f83a3e4 — `Frontend/UI` (component)
- Pertinent info:
  - table@L357: Frontend/UI | Contract-aware client, surfaces, diagnostics, a11y | E2E tests, UI-runtime parity report, accessibility checks
- Found in:
  - `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`

### I-6d2d97bc — `Gateway policy` (component)
- Pertinent info:
  - table@L42: Gateway policy | `use_key_post_create_forbidden` | `403 forbidden`
  - table@L43: Gateway policy | `use_key_key_mutation_forbidden` | `403 forbidden`
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-3c31c689 — `Gateway route has JWT device_id claim matching X-Device-Id` (component)
- Pertinent info:
  - table@L76: Gateway route has JWT device_id claim matching X-Device-Id | Allow if all other checks pass
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-f9f1a9f8 — `Governance & SSOT sync` (component)
- Pertinent info:
  - table@L352: Governance & SSOT sync | Change-impact map, updated docs, owner approvals | SSOT lint pass, traceability diff, review signoff
- Found in:
  - `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`

### I-1e55f26f — `Governance + decisions` (component)
- Pertinent info:
  - table@L14: Governance + decisions | Architecture lead | Platform lead
- Found in:
  - `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`

### I-b0eb7991 — `Health + JWKS publishing` (component)
- Pertinent info:
  - table@L11: Health + JWKS publishing | `GET /health`, `GET /.well-known/jwks.json` | public middleware stack
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-e973e284 — `Inactive/revoked member contribution` (component)
- Pertinent info:
  - table@L51: Inactive/revoked member contribution | Excluded entirely
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-e47f9e0a — `Invite create` (component)
- Pertinent info:
  - table@L22: Invite create | `POST /console/api/invites` | owner jwt + validation
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-1505410e — `Invite issue` (component)
- Pertinent info:
  - table@L37: Invite issue | `POST /console/api/invites` | Given owner JWT and valid target constraints, when submitted, then invite receipt persisted with expiry.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

### I-d4d10b73 — `Issuer is keychain principal` (component)
- Pertinent info:
  - table@L21: Issuer is keychain principal | Deny (keychains cannot mint credentials)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`
- Relationships: policy:delegation

### I-69610698 — `Issuer is owner principal via console issue route` (component)
- Pertinent info:
  - table@L22: Issuer is owner principal via console issue route | Allow subject to governance policy
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-2cafd48e — `JSON body` (component)
- Pertinent info:
  - table@L31: JSON body | `content_type_unsupported` | `415 unsupported_media_type`
  - table@L32: JSON body | `malformed_json` | `400 bad_request`
  - table@L33: JSON body | `json_root_not_object` | `400 bad_request`
- Found in:
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-0c96660c — `JWKS publishing` (component)
- Pertinent info:
  - table@L22: JWKS publishing | `GET /.well-known/jwks.json` | Given active signer set exists, when requested, then JWKS contains active verification keys.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

### I-eb670351 — `JWT `device_id` missing/mismatch relative to header` (component)
- Pertinent info:
  - table@L79: JWT `device_id` missing/mismatch relative to header | Deny (`401 auth_invalid`, `token_device_mismatch`)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-570f179a — `Key issue/lifecycle` (component)
- Pertinent info:
  - table@L23: Key issue/lifecycle | `POST /console/api/keys`, `POST /console/api/keys/{keyId}/lifecycle` | owner jwt + validation + lineage bounds
  - table@L38: Key issue/lifecycle | `POST /console/api/keys` + `POST /console/api/keys/{keyId}/lifecycle` | Given owner JWT and envelope bounds, when issuing/lifecycle actioning, then invariants and lineage are preserved atomically.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-1c22060a — `Key login` (component)
- Pertinent info:
  - table@L13: Key login | `POST /api/auth/key-login` | validation + json + key auth + device policy
  - table@L26: Key login | `POST /api/auth/key-login` | Given valid key credentials and policy compliance, when submitted, then key JWT + refresh issued.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-4dea7c43 — `Keychain create/list` (component)
- Pertinent info:
  - table@L19: Keychain create/list | `GET/POST /console/api/keychains` | owner jwt + validation
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
- Relationships: policy:delegation

### I-d955fdf4 — `Keychain effective resolve` (component)
- Pertinent info:
  - table@L21: Keychain effective resolve | `GET /console/api/keychains/{keychainId}/resolve` | owner jwt + lineage projection policy
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
- Relationships: policy:delegation

### I-6e80b930 — `keychain key` (component)
- Pertinent info:
  - table@L32: keychain key | no | no
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`
- Relationships: policy:delegation

### I-a5c3ed92 — `Keychain list/create` (component)
- Pertinent info:
  - table@L34: Keychain list/create | `GET/POST /console/api/keychains` | Given owner JWT, when requested, then keychain inventory/create succeeds with keychain principal semantics.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
- Relationships: policy:delegation

### I-ccf2ae7e — `Keychain membership mutate` (component)
- Pertinent info:
  - table@L20: Keychain membership mutate | `GET /console/api/keychains/{keychainId}/members`, `POST /console/api/keychains/{keychainId}/members`, `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}` | owner jwt + invaria
  - table@L35: Keychain membership mutate | `GET /console/api/keychains/{keychainId}/members`, `POST /console/api/keychains/{keychainId}/members`, `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}` | Given owner JWT and
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
- Relationships: policy:delegation

### I-20d0449a — `Keychain nesting bypass` (component)
- Pertinent info:
  - table@L20: Keychain nesting bypass | Insert keychain into keychain | Membership validation denies nested keychains
- Found in:
  - `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`
- Relationships: policy:delegation

### I-9ef248bf — `Keychain resolve` (component)
- Pertinent info:
  - table@L36: Keychain resolve | `GET /console/api/keychains/{keychainId}/resolve` | Given valid keychain and owner JWT, when requested, then effective permissions/scope plus lineage projection returned.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
- Relationships: policy:delegation

### I-d5934373 — `Master-key SYSADMIN governance + device-bound auth invariants` (component)
- Pertinent info:
  - table@L24: Master-key SYSADMIN governance + device-bound auth invariants | `POST /console/api/keys`, `POST /console/api/keys/{keyId}/lifecycle`, SYSADMIN-designated routes | owner-only master-key policy + device-claim parity + emer
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-d90444a7 — `Membership change` (component)
- Pertinent info:
  - table@L52: Membership change | Recompute effective snapshot atomically with mutation
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-dea0878c — `Moderation actions` (component)
- Pertinent info:
  - table@L25: Moderation actions | `POST /console/api/posts/{postId}/moderation`, `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | owner jwt + moderation transition policy
  - table@L39: Moderation actions | `POST /console/api/posts/{postId}/moderation`, `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | Given owner/admin authority, when moderation action submitted, then target state tr
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-22884db1 — `Module` (component)
- Pertinent info:
  - table@L15: Module | Primary owner | Secondary owner
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-fcd41db7 — `Observability & SRE` (component)
- Pertinent info:
  - table@L359: Observability & SRE | Logs/events/metrics/traces, alerts, SLO dashboards | Event coverage report, alert fire drills, SLI validation
- Found in:
  - `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`

### I-477983a7 — `Operational impact` (component)
- Pertinent info:
  - table@L17: Operational impact | SLO/readiness/alerts/runbooks
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`

### I-0e23dd2a — `Operations + observability` (component)
- Pertinent info:
  - table@L20: Operations + observability | Platform/SRE lead | Backend lead
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-8d168cee — `Operations + quality` (component)
- Pertinent info:
  - table@L17: Operations + quality | Platform/SRE lead | QA lead
- Found in:
  - `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`

### I-a475274f — `Owner bootstrap policy` (component)
- Pertinent info:
  - heading@L21: Owner bootstrap policy
  - table@L37: Owner bootstrap policy | `invite_code_invalid` | `403 forbidden`
  - table@L38: Owner bootstrap policy | `invite_code_missing` | `422 validation_failed`
- Found in:
  - `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`
  - `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`

### I-01b4aa4c — `Owner login` (component)
- Pertinent info:
  - table@L25: Owner login | `POST /api/auth/login` | Given valid owner credentials, when submitted, then owner JWT + refresh issued.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

### I-d63bbf8e — `Owner signup` (component)
- Pertinent info:
  - table@L24: Owner signup | `POST /console/owners` | Given valid email/password + invite code, when submitted under default policy, then owner principal is created and success envelope returned.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

### I-d1898ae6 — `Owner signup/login` (component)
- Pertinent info:
  - table@L12: Owner signup/login | `POST /console/owners`, `POST /api/auth/login` | validation + json + invite-gated owner bootstrap policy + owner auth
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-d6a5f486 — `Owner-first` (component)
- Pertinent info:
  - table@L28: Owner-first | required | optional/internal
- Found in:
  - `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`

### I-deb5b672 — `Parent depth is 3 and child requested` (component)
- Pertinent info:
  - table@L18: Parent depth is 3 and child requested | Deny (`422 validation_failed` or `403` policy deny)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-10ab83ea — `Parent lacks `keys:issue`` (component)
- Pertinent info:
  - table@L20: Parent lacks `keys:issue` | Deny (`403 forbidden`)
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-41275a53 — `Permissions` (component)
- Pertinent info:
  - table@L48: Permissions | Set-union across active members, then constrained by keychain envelope
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-8cf210df — `Policy/authorization extension` (component)
- Pertinent info:
  - table@L32: Policy/authorization extension | Auth spec + decision tables + error catalog + abuse cases | Security lead
- Found in:
  - `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`

### I-54984243 — `Positive scope tokens` (component)
- Pertinent info:
  - table@L49: Positive scope tokens | Union
- Found in:
  - `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`

### I-4e108d8c — `Post create` (component)
- Pertinent info:
  - table@L29: Post create | `POST /api/posts` | Given key has `posts:create` and allowed scope, when submitted, then post is created and visible by policy.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`

### I-fcb2dcfc — `Post create/edit/flag` (component)
- Pertinent info:
  - table@L16: Post create/edit/flag | `POST /api/posts`, `GET/PATCH /api/posts/{postId}`, `POST /api/posts/{postId}/flags` | key jwt + permission + use-key guard
- Found in:
  - `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`

### I-0a0dae5e — `Post flag` (component)
- Pertinent info:
  - table@L31: Post flag | `POST /api/posts/{postId}/flags` | Given visible post and valid reason, when submitted, then flag record is persisted.
- Found in:
  - `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
