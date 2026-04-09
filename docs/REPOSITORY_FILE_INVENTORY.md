# Repository File Inventory

## `dot.env`
- **Description:** Environment variable template/reference
- **Things mentioned (concise): APP_ENV; DB_DSN; DB_USER; DB_PASS; JWT_ISSUER; JWT_AUDIENCE_CONSOLE; JWT_AUDIENCE_GATEWAY; JWT_PRIVATE_KEY; JWT_PUBLIC_KEY; CORS_ALLOWED_ORIGINS; CSRF_SECRET; RATE_LIMIT_GLOBAL_LIMIT

## `composer.json`
- **Description:** JSON config/schema
- **Things mentioned (concise): name; description; type; license; require; require-dev; autoload; autoload-dev; config; scripts

## `docs/HIGH_LEVEL_REPORT_2026-04-09.md`
- **Description:** From-Scratch Documentation High-Level Report (2026-04-09)
- **Things mentioned (concise): From-Scratch Documentation High-Level Report (2026-04-09); Executive summary; What it is; Structural shape; Core themes; Maturity signal; Practical interpretation

## `docs/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`
- **Description:** Technical Foundation And Build Plan
- **Things mentioned (concise): Technical Foundation And Build Plan; Runtime and stack assumptions; Build principles; Implementation milestones; Engineering quality bars

## `docs/README.md`
- **Description:** CRE8 From-Scratch SSOT Canon
- **Things mentioned (concise): CRE8 From-Scratch SSOT Canon; Purpose; Canon scope; Authoritative reading path; Finality and change policy; Non-negotiable rules; Definition of quality

## `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md`
- **Description:** ADR-001: SSOT-first contract governance model
- **Things mentioned (concise): ADR-001: SSOT-first contract governance model; Context; Decision; Consequences; Verification implications

## `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md`
- **Description:** ADR-004: Envelope-first API response standard
- **Things mentioned (concise): ADR-004: Envelope-first API response standard; Context; Decision; Consequences; Verification implications

## `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md`
- **Description:** ADR-003: Keychain as production-active v1 principal class
- **Things mentioned (concise): ADR-003: Keychain as production-active v1 principal class; Context; Decision; Consequences; Verification implications

## `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md`
- **Description:** ADR-002: Delegation envelope bounds (subset/depth/expiry)
- **Things mentioned (concise): ADR-002: Delegation envelope bounds (subset/depth/expiry); Context; Decision; Consequences; Verification implications

## `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md`
- **Description:** ADR-005: Release gating via verification + smoke + readiness controls
- **Things mentioned (concise): ADR-005: Release gating via verification + smoke + readiness controls; Context; Decision; Consequences; Verification implications

## `docs/ssot_canon/60_decisions/DECISIONS_LOG.md`
- **Description:** Decisions Log
- **Things mentioned (concise): Decisions Log; Chronological entries; Update rule

## `docs/ssot_canon/60_decisions/ADR_INDEX.md`
- **Description:** ADR Index
- **Things mentioned (concise): ADR Index; Purpose; Current indexed records; Index contract

## `docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md`
- **Description:** Decision Record Template
- **Things mentioned (concise): Decision Record Template; Required fields; Quality bar

## `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md`
- **Description:** Production Readiness Gates
- **Things mentioned (concise): Production Readiness Gates; Gate A: Build/runtime integrity; Gate B: Contract/security quality; Gate C: UX parity; Gate D: Operational readiness; Exit criteria

## `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md`
- **Description:** Migration Seed Strategy (SSOT)
- **Things mentioned (concise): Migration Seed Strategy (SSOT); Purpose; Strategy; Required migration artifacts; Required seed artifacts; Safety rules; Command contract; Verification linkage

## `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`
- **Description:** Operational Smoke Check Contract (SSOT)
- **Things mentioned (concise): Operational Smoke Check Contract (SSOT); Purpose; Canonical smoke commands; Health smoke contract; Migration smoke contract; Evidence requirements; Reconciliation rule; Release gate linkage; Related SSOT docs

## `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
- **Description:** Acceptance Criteria Matrix (SSOT)
- **Things mentioned (concise): Acceptance Criteria Matrix (SSOT); Purpose; Usage contract; Route acceptance matrix; Required negative-path baseline per route; Manual UAT checklist linkage; Related SSOT docs

## `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`
- **Description:** Verification Strategy (SSOT)
- **Things mentioned (concise): Verification Strategy (SSOT); Automated suites; Required commands; Release verification scope; Acceptance criteria enforcement; Stable QA script (manual)

## `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md`
- **Description:** Release Checklist
- **Things mentioned (concise): Release Checklist; Pre-release requirements; Security and operations gates; Evidence package

## `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md`
- **Description:** Observability Event Catalog
- **Things mentioned (concise): Observability Event Catalog; Event families; Canonical event naming guidance; Required event fields; Logging requirements; Correlation requirements

## `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md`
- **Description:** Boot and Startup Failure Contract (SSOT)
- **Things mentioned (concise): Boot and Startup Failure Contract (SSOT); Purpose; Startup sequence contract; Mandatory boot assertions; Startup success behavior; Startup failure behavior; Non-negotiable fail-closed rule; Related SSOT docs

## `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md`
- **Description:** Health Endpoint Contract (SSOT)
- **Things mentioned (concise): Health Endpoint Contract (SSOT); Purpose; Route and surface; Response contract; Service-state semantics; HTTP status guidance; Failure reason examples; Smoke-check expectations; Related SSOT docs

## `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`
- **Description:** SLO/SLI Spec
- **Things mentioned (concise): SLO/SLI Spec; SLI definitions; Initial SLO targets; Measurement windows; Instrumentation ownership matrix; Alerting guidance; Accountability rules

## `docs/ssot_canon/40_operations_and_quality/CONFIGURATION_ENVIRONMENT_CONTRACT.md`
- **Description:** Configuration and Environment Contract (SSOT)
- **Things mentioned (concise): Configuration and Environment Contract (SSOT); Purpose; Required environment variables; Optional policy variables (with defaults); Profile hardening constraints; Key material source rules; Runtime mapping contract; Related SSOT docs

## `docs/ssot_canon/80_program_management/RISK_REGISTER.md`
- **Description:** Risk Register
- **Things mentioned (concise): Risk Register; Active risks; Review cadence

## `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md`
- **Description:** Roadmap and Milestones
- **Things mentioned (concise): Roadmap and Milestones; Milestones; Exit criteria by milestone; Milestone deliverables (minimum); Tracking rule

## `docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md`
- **Description:** Definition of Done
- **Things mentioned (concise): Definition of Done; Done means all are true; Required evidence checklist; Not-done examples

## `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md`
- **Description:** Contribution Workflow (SSOT)
- **Things mentioned (concise): Contribution Workflow (SSOT); Workflow; Required PR payload; Review policy; SLA and escalation

## `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`
- **Description:** Document Status and Ownership
- **Things mentioned (concise): Document Status and Ownership; Status model; Ownership matrix; Ownership obligations; Review SLA

## `docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
- **Description:** Document Template and Style Guide
- **Things mentioned (concise): Document Template and Style Guide; Required sections for adopted docs; Writing standards; Traceability conventions

## `docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md`
- **Description:** Change Control Policy
- **Things mentioned (concise): Change Control Policy; Scope; Change classes; Approval requirements; Required PR payload

## `docs/ssot_canon/00_governance/SSOT_INDEX.md`
- **Description:** SSOT Index
- **Things mentioned (concise): SSOT Index; Canon status; Canon navigation; Machine artifacts; Usage rule

## `docs/ssot_canon/schemas/success-envelope.schema.json`
- **Description:** JSON config/schema
- **Things mentioned (concise): $schema; $id; title; type; required; additionalProperties; properties

## `docs/ssot_canon/schemas/error-envelope.schema.json`
- **Description:** JSON config/schema
- **Things mentioned (concise): $schema; $id; title; type; required; additionalProperties; properties

## `docs/ssot_canon/70_implementation_guidance/MIGRATION_AND_COMPATIBILITY_STRATEGY.md`
- **Description:** Migration and Compatibility Strategy
- **Things mentioned (concise): Migration and Compatibility Strategy; Migration principles; Required migration artifacts; Compatibility checklist

## `docs/ssot_canon/70_implementation_guidance/DEPRECATION_AND_VERSIONING_POLICY.md`
- **Description:** Deprecation and Versioning Policy
- **Things mentioned (concise): Deprecation and Versioning Policy; Versioning model; Deprecation process; Guardrails

## `docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md`
- **Description:** Test Data and Fixture Strategy
- **Things mentioned (concise): Test Data and Fixture Strategy; Fixture principles; Required fixture packs; Maintenance policy

## `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`
- **Description:** Module Boundaries and Ownership
- **Things mentioned (concise): Module Boundaries and Ownership; Core modules; Ownership model; Boundary rules

## `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
- **Description:** Endpoint Examples (All Routes)
- **Things mentioned (concise): Endpoint Examples (All Routes); Purpose; Envelope conventions used in examples; Public + auth surfaces; `GET /`; `GET /health`; `GET /.well-known/jwks.json`; `POST /console/owners`; `POST /api/auth/login`; `POST /api/auth/key-login`

## `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
- **Description:** Route Inventory Reference (SSOT)
- **Things mentioned (concise): Route Inventory Reference (SSOT); Purpose; Inventory governance; Route inventory (v1); Notes

## `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`
- **Description:** Authorization Decision Tables (SSOT)
- **Things mentioned (concise): Authorization Decision Tables (SSOT); Purpose; Delegation issuance decision table; Key class mint authority table (v1); Keychain membership admission table; Keychain effective permission/scope resolution; Lifecycle action authority table; Runtime decision order (authoritative); Error mapping expectations; Related SSOT docs

## `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`
- **Description:** Error Code Catalog (SSOT)
- **Things mentioned (concise): Error Code Catalog (SSOT); Envelope-level canonical codes; Canonical middleware/handler detail-code registry (v1 baseline); Mapping requirements

## `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
- **Description:** UI Runtime Contract (SSOT Appendix)
- **Things mentioned (concise): UI Runtime Contract (SSOT Appendix); Purpose; Session and device persistence contract; API client behavior contract; Route-state runtime model; Diagnostics UX minimums; Security/UX guardrails; Accessibility/runtime baseline; Related SSOT docs

## `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- **Description:** Authorization and Delegation Spec
- **Things mentioned (concise): Authorization and Delegation Spec; Scope; Principals; Key classes; Permission model (v1 allow-list); Delegation invariants; Keychain invariants (v1 production); Surface enforcement model; Lifecycle authority; Related SSOT docs

## `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`
- **Description:** API Contract Guide (SSOT)
- **Things mentioned (concise): API Contract Guide (SSOT); Canonical machine contract; Envelope contract; Route groups; Endpoint examples; Acceptance criteria linkage; Synchronization rule; Backward compatibility

## `docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md`
- **Description:** SSOT Automation and Linting (SSOT)
- **Things mentioned (concise): SSOT Automation and Linting (SSOT); Purpose; Required automation checks; PR policy integration; Minimal command contract; Evidence output requirements; Ownership; Related SSOT docs

## `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
- **Description:** Traceability Matrix (Docs-to-Code)
- **Things mentioned (concise): Traceability Matrix (Docs-to-Code)

## `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`
- **Description:** Prototype to SSOT Delta Map (SSOT)
- **Things mentioned (concise): Prototype to SSOT Delta Map (SSOT); Purpose; Delta map; Promotion rule

## `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`
- **Description:** Change Impact Map Templates (SSOT)
- **Things mentioned (concise): Change Impact Map Templates (SSOT); Purpose; Minimal template; Rule

## `docs/ssot_canon/50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`
- **Description:** Known Gaps Tracker (SSOT)
- **Things mentioned (concise): Known Gaps Tracker (SSOT); Purpose; Open gaps; Recently resolved in this SSOT cycle; Triage rules; Review cadence

## `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`
- **Description:** Canonical Terminology
- **Things mentioned (concise): Canonical Terminology; Principal terms; Security terms; Contract terms

## `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`
- **Description:** Dependency Baseline
- **Things mentioned (concise): Dependency Baseline; Baseline dependency families; Dependency governance rules; Runtime expectations; Canonical package baseline (root `composer.json`); Script contract baseline

## `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- **Description:** Request Pipeline and Middleware Contract
- **Things mentioned (concise): Request Pipeline and Middleware Contract; Authoritative middleware order; Contract rules; Failure mapping baseline

## `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`
- **Description:** Architecture and Surfaces
- **Things mentioned (concise): Architecture and Surfaces; Architectural model; Layering; Boundary rules

## `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`
- **Description:** CRE8 Product and System Spec
- **Things mentioned (concise): CRE8 Product and System Spec; Product scope; System capabilities (v1); Core system constraints; Out-of-scope (v1)

## `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`
- **Description:** Security Verification and Abuse Cases (SSOT)
- **Things mentioned (concise): Security Verification and Abuse Cases (SSOT); Purpose; Abuse-case matrix (minimum required); Security test-pack requirements; Incident-response verification hooks; Release gate linkage; Related SSOT docs

## `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md`
- **Description:** Security Threat Model
- **Things mentioned (concise): Security Threat Model; Threat scenarios; Mitigations; Dependency linkage

## `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`
- **Description:** Data Model Spec (Production)
- **Things mentioned (concise): Data Model Spec (Production); Table contracts; principals; principal_emails; credentials; token_families; delegation_envelopes; keychain_memberships; keychain_effective_snapshots; invite_receipts

## `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`
- **Description:** Security Controls Spec
- **Things mentioned (concise): Security Controls Spec; Control objectives; Trust boundaries; Control baseline; Dependency mapping; Verification linkage

## `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md`
- **Description:** Security Headers and CSP Policy (SSOT)
- **Things mentioned (concise): Security Headers and CSP Policy (SSOT); Purpose; Required default security headers; Path-aware CSP contract; Enforcement requirements; Verification requirements; Related SSOT docs

## `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`
- **Description:** Data Model Reference (SSOT)
- **Things mentioned (concise): Data Model Reference (SSOT); Storage strategy; Core entity groups; Lifecycle invariants; Transaction boundaries (required); Related SSOT docs

## `docs/ssot_canon/30_data_and_security/ERD.md`
- **Description:** ERD (Text + Mermaid)
- **Things mentioned (concise): ERD (Text + Mermaid); Notes

## `docs/ssot_canon/openapi/cre8.v1.yaml`
- **Description:** YAML contract/specification
- **Things mentioned (concise): openapi; info; servers; security; paths; components

## `docs/ssot_canon/evidence/README.md`
- **Description:** Evidence Package Guide
- **Things mentioned (concise): Evidence Package Guide; Purpose; Required evidence types; Storage convention

## `docs/ssot_canon/evidence/automation/ssot_report.json`
- **Description:** JSON config/schema
- **Things mentioned (concise): generated_at_utc; status; checks

## `docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md`
- **Description:** SSOT Change Evidence Template
- **Things mentioned (concise): SSOT Change Evidence Template; Change metadata; Documents/artifacts changed; Verification evidence; Traceability; Reviewer signoff

## `docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md`
- **Description:** Release Evidence Template
- **Things mentioned (concise): Release Evidence Template; Release metadata; Verification command results; Contract and behavior deltas; Operational signoff

## `docs/CORE_IDENTITY_AND_VALUE_PROPOSITION.md`
- **Description:** Core Identity And Value Proposition
- **Things mentioned (concise): Core Identity And Value Proposition; Product identity; Primary value propositions; Intended user/actor model; Product promises encoded as engineering constraints
