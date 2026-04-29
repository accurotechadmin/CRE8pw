# CRE8

**CRE8** is a policy-governed content platform: delegated authorship under strict envelopes, owner-controlled moderation and lifecycle, and auditable, contract-first HTTP APIs. It is designed so operators can run private-by-default governance (invitation-gated owner bootstrap by default), then optionally expose a full **gateway** for key-based API clients while keeping **console** governance separate and non-interchangeable with gateway identity.

This repository is **documentation-first**: the **single source of truth (SSOT)** for product intent, architecture, API contracts, authorization, data, security, operations, and delivery governance lives under `docs/ssot_canon/`. Runtime code layout is specified (PHP, Slim, PSR-7, JWT, envelopes); implementation directories referenced by tooling are canon-defined and governed by this SSOT—treat **machine contracts and SSOT prose** as authoritative implementation directives.

---

## Table of contents

1. [What CRE8 is (quick orientation)](#what-cre8-is-quick-orientation)
2. [Repository layout at a glance](#repository-layout-at-a-glance)
3. [How to read this project (onboarding path)](#how-to-read-this-project-onboarding-path)
4. [Architecture: surfaces and boundaries](#architecture-surfaces-and-boundaries)
5. [Contracts: API, envelopes, and errors](#contracts-api-envelopes-and-errors)
6. [Authorization, delegation, and keychains](#authorization-delegation-and-keychains)
7. [Data model and security](#data-model-and-security)
8. [Operations, quality, and release](#operations-quality-and-release)
9. [Traceability, automation, and evidence](#traceability-automation-and-evidence)
10. [Decisions (ADRs) and program management](#decisions-adrs-and-program-management)
11. [Execution planning (stages, gates, slices)](#execution-planning-stages-gates-slices)
12. [Encyclopedia: SSOT canon file catalog](#encyclopedia-ssot-canon-file-catalog)
13. [Root configuration artifacts](#root-configuration-artifacts)
14. [Precedence when documents disagree](#precedence-when-documents-disagree)
15. [Contributing and change safety](#contributing-and-change-safety)

---

## What CRE8 is (quick orientation)

- **Product identity:** A standalone platform for credentialing, authentication, and authorization with production-grade governance—owners govern keys, keychains, invites, moderation, and lifecycle; delegated **keys** act on content within bounded permissions, scope, depth, and expiry. See `docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md` and `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`.
- **Human-facing overview:** Roles, adoption profiles (owner-first vs delegated platform), and why invite-gated owner signup is the default—`docs/ssot_canon/10_product_and_architecture/CRE8_HUMAN_OPERATING_MODEL.md`.
- **Technical baseline:** PHP application, JSON **envelope** on every API response path, JWT-based authentication, relational data model for principals, delegations, keychains, content, and moderation—`docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`, `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`.
- **Non-negotiable engineering promises (encoded as constraints):** No out-of-envelope authorization; contract changes stay verifiable; failure paths expose **request correlation** and stable error semantics—see foundation and `docs/01_foundation/README.md`.

---

## Repository layout at a glance

| Path | Role |
|------|------|
| `docs/ssot_canon/` | **Canonical SSOT** — governance, product, contracts, data/security, operations, traceability, ADRs, implementation guidance, program management, OpenAPI, JSON schemas, evidence templates |
| `docs/01_foundation/` | Entry narrative, reading order, repo inventory |
| `docs/02_onboarding_and_audits/` | Onboarding prompts, analyses, audits (lower precedence than SSOT for behavioral truth) |
| `docs/03_execution_planning/` | Stage-based master plans, slice ledgers, and governance execution records |
| `docs/04_instructional_notes/` | Instructor notes (educational; not normative over SSOT) |
| `composer.json` | PHP dependency and **script contracts** (`test`, `qa`, `ops:*`, optional `docs:ssot:*`) |
| `dot.env` | Example environment scaffold—align with `docs/ssot_canon/40_operations_and_quality/CONFIGURATION_ENVIRONMENT_CONTRACT.md`; **do not copy secrets to production** |
| `.htaccess` | Apache rewrite toward `public/` entrypoint for deployments using Apache |

Authoritative artifact map: `docs/01_foundation/REPOSITORY_FILE_INVENTORY.md`.

---

## How to read this project (onboarding path)

1. **Single ordered curriculum:** `docs/01_foundation/RECOMMENDED_READING_ORDER.md` — lists every canonical document in sequence, then machine-readable references.
2. **Canon index:** `docs/ssot_canon/00_governance/SSOT_INDEX.md` — folder taxonomy and machine artifact pointers.
3. **Docs tree overview:** `docs/README.md`.

For LLM or staff onboarding workflows, see `docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md` and dated analyses under the same folder (synthesis only; resolve conflicts per [Precedence](#precedence-when-documents-disagree)).

---

## Architecture: surfaces and boundaries

CRE8 is one HTTP application with **three runtime surfaces** (see `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`):

| Surface | Typical path prefix | Auth context (v1) | Purpose |
|---------|---------------------|-------------------|---------|
| **Public / bootstrap** | `/`, `/health`, `/.well-known/jwks.json`, `/ui/*`, owner signup | Unauthenticated or mixed | Service banner, health, JWKS, UI shell, `POST /console/owners` |
| **Gateway** | `/api/*` | **Key** JWT (`typ=key`, gateway audience) + **device binding** | Feed, posts, comments, flags |
| **Console** | `/console/api/*` | **Owner** JWT (`typ=owner`, console audience); CSRF where applicable | Posts, moderation, keychains, invites, key issuance and lifecycle |

**Boundary rules:** Console and gateway auth contexts are **never interchangeable**. Authorization is centralized and table-driven. Full route table with methods, policy notes, and UI parity references: `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`.

**Request pipeline:** Normative middleware order (request ID → security headers/CSP → CORS/normalization → surface auth → validation → rate limit → handler → envelope responder/error mapper) — `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`. Resource-specific `404` **detail codes** (e.g. `post_not_found`) vs router-only `route_not_found` are specified there and in the error catalog.

---

## Contracts: API, envelopes, and errors

| Artifact | Path | Purpose |
|----------|------|---------|
| **OpenAPI v1** | `docs/ssot_canon/openapi/cre8.v1.yaml` | Machine **tier-1** contract for paths, request/response shapes |
| **Success envelope schema** | `docs/ssot_canon/schemas/success-envelope.schema.json` | `{ "data", "meta" }` with required `meta.envelope_version` |
| **Error envelope schema** | `docs/ssot_canon/schemas/error-envelope.schema.json` | `{ "error", "meta" }` with `error.code`, `error.message`, `error.request_id` |
| **API contract guide** | `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md` | Envelope rules, route groups, sync obligations with OpenAPI |
| **Endpoint examples** | `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md` | Request/response samples per route |
| **Error code catalog** | `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md` | HTTP status, envelope codes, `details.code`, UI behavior |
| **UI runtime contract** | `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md` | SPA session/device keys, route states, API↔UI parity matrix |

Gateway routes that require device policy must enforce **`X-Device-Id`** consistent with JWT `device_id` claims—see API guide and authorization spec.

---

## Authorization, delegation, and keychains

| Topic | Document |
|-------|----------|
| Principals, key classes, permissions, keychain invariants, surface enforcement | `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md` |
| Deterministic decision tables (issuance, mint authority, keychain membership, lifecycle, device binding) | `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md` |
| Narrative scenarios | `docs/ssot_canon/20_contracts/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md` |
| **Master key** (SYSADMIN, owner-governed, non-gateway) | `docs/ssot_canon/30_data_and_security/MASTER_KEY_SPEC.md` |
| Canonical vocabulary (principals, envelopes, etc.) | `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md` |

**Delegation invariants (summary):** Child envelope must be a strict subset of parent permissions and scope; max delegation depth **3**; explicit expiry; lineage preserved. **Keychains** are first-class key principals in v1 with membership rules, effective permission/scope resolution, and snapshot recomputation—see ADR-003 in `docs/ssot_canon/60_decisions/ADR_INDEX.md`.

---

## Data model and security

| Topic | Document |
|-------|----------|
| Table-level schema contract | `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md` |
| Entity groups, transaction boundaries, invariants | `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md` |
| ERD (Mermaid) | `docs/ssot_canon/30_data_and_security/ERD.md` |
| Security controls and trust boundaries | `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md` |
| Threat scenarios and mitigations | `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md` |
| Abuse-case matrix and release blocking rules | `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md` |
| Security headers and path-aware CSP | `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md` |

---

## Operations, quality, and release

| Topic | Document |
|-------|----------|
| Environment variables and profile hardening (`OWNER_SIGNUP_MODE`, JWT, DB, CSRF, etc.) | `docs/ssot_canon/40_operations_and_quality/CONFIGURATION_ENVIRONMENT_CONTRACT.md` |
| Boot assertions, fail-closed startup | `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md` |
| `/health` subsystem semantics | `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md` |
| Verification commands and suite expectations | `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md` |
| Route-level Given/When/Then acceptance | `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md` |
| Migrations and seeds | `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md` |
| Operational smoke (`ops:health-smoke`, `ops:migrate-smoke`) | `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md` |
| Production readiness gates (A–D) | `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md` |
| Release checklist | `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md` |
| SLO/SLI and ownership | `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md` |
| Observability event families | `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md` |

**Composer script names** (see root `composer.json`): `test`, `test:contract`, `test:security`, `qa`, `ops:health-smoke`, `ops:migrate-smoke`, optional `docs:ssot:lint`, `docs:ssot:sync-check`, `docs:ssot:report`. These imply `src/`, `tests/`, and `scripts/` layouts when implementation is present.

---

## Traceability, automation, and evidence

| Topic | Document |
|-------|----------|
| Capability → route → policy → service → tests → SSOT rows | `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md` |
| SSOT lint/sync automation expectations | `docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md` |
| PR change-impact template | `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md` |
| Prototype vs SSOT reconciliation | `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md` |
| Evidence package guide | `docs/ssot_canon/evidence/README.md` |
| SSOT change / release evidence templates | `docs/ssot_canon/evidence/templates/` |

Artifacts under `docs/ssot_canon/evidence/` marked **historical** or `historical_record` are for audit only—not current production readiness proof. The automation report at `docs/ssot_canon/evidence/automation/ssot_report.json` is explicitly historical unless regenerated by a current pipeline.

---

## Decisions (ADRs) and program management

| Topic | Document |
|-------|----------|
| ADR index (ADR-001 … ADR-005) | `docs/ssot_canon/60_decisions/ADR_INDEX.md` |
| Decision chronology | `docs/ssot_canon/60_decisions/DECISIONS_LOG.md` |
| ADR record template | `docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md` |
| Individual records | `docs/ssot_canon/60_decisions/records/ADR-00*.md` |
| Contribution workflow, PR payload | `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md` |
| Definition of Done | `docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md` |
| Roadmap milestones (M1–M4) and tracking tasks | `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md` |
| Risk register | `docs/ssot_canon/80_program_management/RISK_REGISTER.md` |
| Analysis tasks (key hierarchy, key-type coherence, etc.) | `docs/ssot_canon/80_program_management/*_TASK.md` |

**Implementation guidance (extensibility, modules, migrations, tests, deprecation):** `docs/ssot_canon/70_implementation_guidance/` — start with `MODULE_BOUNDARIES_AND_OWNERSHIP.md` and `EXTENSIBILITY_PLAYBOOK.md`.

**Governance (ownership, change classes, templates):** `docs/ssot_canon/00_governance/` — `CHANGE_CONTROL_POLICY.md`, `DOCUMENT_STATUS_AND_OWNERSHIP.md`, `DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`.

---

## Execution planning (stages, gates, slices)

Delivery is **completion-based**, not calendar-based:

| Artifact | Purpose |
|----------|---------|
| `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md` | Stages **0–10**, universal gates **A–F**, human/ethos obligations, final closure protocol |
| `docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md` | Slice IDs (**S0-01** … **S10-08**), dependencies, deliverables, required evidence per slice |

Stages cover program initialization, runtime foundation, data/migrations, identity/auth, authorization/keychains, API surfaces, UI parity, security hardening, quality/reliability, release engineering, and launch/stabilization. Use the master plan for **why** and **when** (gates); use detailed slices for **what** and **evidence**.

---

## Encyclopedia: SSOT canon file catalog

Below is a **per-file** index of `docs/ssot_canon/`. Use it as a map; normative content is always in the file itself.

### `docs/ssot_canon/00_governance/`

| File | Summary |
|------|---------|
| `SSOT_INDEX.md` | Canon navigation, machine artifacts, precedence rule |
| `DOCUMENT_STATUS_AND_OWNERSHIP.md` | Status model, ownership matrix, review SLAs |
| `CHANGE_CONTROL_POLICY.md` | Change classes A–D, PR requirements, emergency remediation loop |
| `DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` | Required sections, MUST/SHOULD norms, traceability conventions |

### `docs/ssot_canon/10_product_and_architecture/`

| File | Summary |
|------|---------|
| `CRE8_PRODUCT_AND_SYSTEM_SPEC.md` | v1 scope, deployment profiles, constraints, out-of-scope |
| `CANONICAL_TERMINOLOGY.md` | Principal, key class, envelope, lifecycle, request ID terms |
| `ARCHITECTURE_AND_SURFACES.md` | Layers, three surfaces, enablement matrix |
| `CRE8_HUMAN_OPERATING_MODEL.md` | Human-readable model, adoption profiles, invite default |
| `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` | Middleware order, status/detail-code expectations, 404 policy |
| `DEPENDENCY_BASELINE.md` | Package families, composer scripts, runtime expectations |

### `docs/ssot_canon/20_contracts/`

| File | Summary |
|------|---------|
| `API_CONTRACT_GUIDE.md` | Machine contract pointers, envelope rules, sync policy |
| `ROUTE_INVENTORY_REFERENCE.md` | Canonical route table + UI parity references |
| `AUTHORIZATION_AND_DELEGATION_SPEC.md` | Principals, classes, permissions, keychains, device binding |
| `AUTHORIZATION_DECISION_TABLES.md` | Truth tables for issuance, mint, keychain, lifecycle, device |
| `UI_RUNTIME_CONTRACT.md` | SPA keys, states, endpoint parity matrix, diagnostics |
| `ERROR_CODE_CATALOG.md` | Codes, detail codes, UI mapping |
| `Endpoint_Examples_All_Routes.md` | Payload examples for every route |
| `USAGE_SCENARIOS_AND_PERMISSION_STORIES.md` | Scenario narratives tied to routes |

### `docs/ssot_canon/30_data_and_security/`

| File | Summary |
|------|---------|
| `DATA_MODEL_SPEC.md` | Table contracts and indexes |
| `DATA_MODEL_REFERENCE.md` | Entity groups, transactions, invariants |
| `ERD.md` | Mermaid entity-relationship diagram |
| `MASTER_KEY_SPEC.md` | Master-key SYSADMIN contract |
| `SECURITY_CONTROLS_SPEC.md` | Objectives, controls, dependency mapping |
| `SECURITY_THREAT_MODEL.md` | Threats and mitigations |
| `SECURITY_HEADERS_AND_CSP_POLICY.md` | Headers and CSP by path class |
| `SECURITY_VERIFICATION_ABUSE_CASES.md` | Abuse matrix and verification requirements |

### `docs/ssot_canon/40_operations_and_quality/`

| File | Summary |
|------|---------|
| `VERIFICATION_STRATEGY.md` | Suites, commands, release scope |
| `ACCEPTANCE_CRITERIA_MATRIX.md` | Behavioral acceptance per capability |
| `CONFIGURATION_ENVIRONMENT_CONTRACT.md` | Env vars and hardening |
| `BOOT_AND_STARTUP_FAILURE_CONTRACT.md` | Boot sequence and failure envelopes |
| `HEALTH_ENDPOINT_CONTRACT.md` | `/health` shape and probes |
| `OBSERVABILITY_EVENT_CATALOG.md` | Event families and required fields |
| `SLO_SLI_SPEC.md` | SLIs, targets, ownership |
| `Migration_Seed_Strategy.md` | Migrations, seeds, safety |
| `OPERATIONAL_SMOKE_CHECK_CONTRACT.md` | Smoke commands and evidence |
| `PRODUCTION_READINESS_GATES.md` | Gates A–D |
| `RELEASE_CHECKLIST.md` | Pre-release and evidence package |

### `docs/ssot_canon/50_traceability_and_automation/`

| File | Summary |
|------|---------|
| `TRACEABILITY_MATRIX.md` | Docs-to-capability mapping |
| `SSOT_AUTOMATION_AND_LINTING.md` | Optional automation, report expectations |
| `CHANGE_IMPACT_MAP_TEMPLATES.md` | PR impact map template |
| `Prototype_to_SSOT_Delta_Map.md` | Resolved deltas and promotion rule |

### `docs/ssot_canon/60_decisions/`

| File | Summary |
|------|---------|
| `ADR_INDEX.md` | Index of ADRs |
| `DECISIONS_LOG.md` | Chronological log |
| `DECISION_RECORD_TEMPLATE.md` | Template for new ADRs |
| `records/ADR-001-ssot-first-governance.md` | SSOT-first governance |
| `records/ADR-002-delegation-envelope-bounds.md` | Subset, depth, expiry |
| `records/ADR-003-keychain-production-principal.md` | Keychain in v1 |
| `records/ADR-004-envelope-first-api-standard.md` | Envelope standard |
| `records/ADR-005-release-gating-controls.md` | Release gating |

### `docs/ssot_canon/70_implementation_guidance/`

| File | Summary |
|------|---------|
| `MODULE_BOUNDARIES_AND_OWNERSHIP.md` | Modules and extension seams |
| `MIGRATION_AND_COMPATIBILITY_STRATEGY.md` | Rollout and compatibility |
| `EXTENSIBILITY_PLAYBOOK.md` | Safe extension patterns |
| `DEPRECATION_AND_VERSIONING_POLICY.md` | Versioning and deprecation |
| `TEST_DATA_AND_FIXTURE_STRATEGY.md` | Fixture packs |

### `docs/ssot_canon/80_program_management/`

| File | Summary |
|------|---------|
| `ROADMAP_AND_MILESTONES.md` | M1–M4, tracking tasks |
| `RISK_REGISTER.md` | Active risks and mitigations |
| `CONTRIBUTION_WORKFLOW_SSOT.md` | SSOT-first PR workflow |
| `DEFINITION_OF_DONE.md` | Done criteria and evidence |
| `KEY_HIERARCHY_SCALE_ANALYSIS_TASK.md` | Key hierarchy analysis task |
| `KEY_TYPE_SPEC_COHERENCE_TASK.md` | Key-type coherence task |
| `MASTER_KEY_HIERARCHY_ANALYSIS_TASK.md` | Master-key hierarchy analysis task |

### Machine artifacts (root of contract tree)

| File | Summary |
|------|---------|
| `openapi/cre8.v1.yaml` | OpenAPI 3.1 contract |
| `schemas/success-envelope.schema.json` | Success envelope JSON Schema |
| `schemas/error-envelope.schema.json` | Error envelope JSON Schema |

### `docs/ssot_canon/evidence/` (non-templates)

| File | Summary |
|------|---------|
| `README.md` | Evidence types; historical handling rule |
| `automation/ssot_report.json` | Automation report output location; historical snapshots are labeled `historical_record` and current status is established by regenerated live tooling output |
| `HISTORICAL_SSOT_CHANGE_EVIDENCE_2026-04-21.md` | Historical audit trail |
| `SSOT_CHANGE_EVIDENCE_2026-04-21_MASTER_RESOLUTION.md` | Dated resolution record |

**Templates:** `docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md`, `RELEASE_EVIDENCE_TEMPLATE.md`.

---

## Root configuration artifacts

| File | Role |
|------|------|
| `composer.json` | PHP `^8.2`, Slim, JWT, PDO, sodium, CORS, rate limiting, Monolog; PSR-4 `Cre8\\` → `src/`, tests under `tests/`; scripts for test/qa/ops/docs |
| `dot.env` | Example env keys aligned to the configuration contract—replace with deployment-specific **non-committed** secrets |
| `.htaccess` | Optional Apache routing to `public/`—ensure your deployment’s document root and entrypoint match this layout |

---

## Precedence when documents disagree

1. **Machine contracts:** `docs/ssot_canon/openapi/cre8.v1.yaml`, `docs/ssot_canon/schemas/*.schema.json`
2. **SSOT canon** under `docs/ssot_canon/` (contracts and security typically before operations and program docs—see `SSOT_INDEX.md`)
3. **Broader** `docs/` governance and foundation
4. **Analyses and audits** under `docs/02_onboarding_and_audits/` (synthesis; cite conflicts explicitly)

If onboarding prompts or older analyses disagree with current SSOT or OpenAPI, **follow the higher tier** and file a doc fix if the drift is unintentional.

---

## Contributing and change safety

1. Classify the change (`CHANGE_CONTROL_POLICY.md`): contract-breaking (A), behavioral (B), editorial (C), or emergency (D).
2. Update **machine + narrative** artifacts together when routes or envelopes change (`CONTRIBUTION_WORKFLOW_SSOT.md`, `API_CONTRACT_GUIDE.md`).
3. Update **traceability** and attach **evidence** using templates under `docs/ssot_canon/evidence/templates/`.
4. Meet **Definition of Done** (`DEFINITION_OF_DONE.md`): tests, security/abuse expectations, matrix rows, risk/decision updates when policy shifts.

For a full chronological reading list of every canonical document, always use **`docs/01_foundation/RECOMMENDED_READING_ORDER.md`**.

---

_Last updated (UTC): 2026-04-22 — aligned with adopted SSOT metadata and repository layout as documented in `docs/01_foundation/REPOSITORY_FILE_INVENTORY.md`._
