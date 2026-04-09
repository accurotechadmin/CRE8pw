# From-Scratch Docset Maturation Plan (Repository-Wide Second-Pass)

## Purpose
This plan identifies high-value topics from the **rest of the repository** (outside `/from_scratch`) that should be incorporated into the `/from_scratch` SSOT canon to make it standalone, mature, and production-ready.

## Review Scope and Method
- Reviewed canonical/legacy SSOT documents under `docs/SSOT/`.
- Reviewed non-SSOT operational and implementation docs under `docs/` and `docs/dev/`.
- Reviewed runtime source-of-truth implementation in `src/`, UI contracts in `ui/` and `public/ui/`, automation scripts in `scripts/`, and validation expectations in `tests/`.
- Compared findings against existing `/from_scratch/ssot_canon` coverage and identified additive topics that improve build-from-scratch guidance.

## Key Findings: Valuable Topics to Pull into `/from_scratch`

### 1) Architecture and System Narrative Consolidation
**Why this matters:** `/from_scratch` has architecture components, but still lacks some concise executive artifacts that help new teams align quickly.

**Source topics to integrate**
- C4/context + component + request/token/key lifecycle sequence diagrams. (`docs/SSOT/Architecture_Diagrams.md`)
- Runtime composition/layers/trust surfaces/extension seams summary framing. (`docs/SSOT/Architecture_Reference.md`)
- Product-level architecture summary and one-sentence architecture statement. (`docs/SSOT/CRE8_Architecture_High_Level_Summary.md`)

**Plan**
- Add a new doc under `10_product_and_architecture`: `ARCHITECTURE_DIAGRAMS_AND_SEQUENCES.md`.
- Expand `ARCHITECTURE_AND_SURFACES.md` with a short “executive architecture synopsis” section.

---

### 2) API Contract Governance Hardening
**Why this matters:** The runtime and tests enforce strict envelope and routing behavior that should be explicit in SSOT authoring guardrails.

**Source topics to integrate**
- API contract precedence and stability rules. (`docs/SSOT/API_Contract.md`)
- Envelope invariants and version header behavior from tests. (`tests/Contract/EnvelopeResponderContractTest.php`)
- Route coverage and required endpoints from route contracts and registrar implementation. (`tests/Contract/RouteRegistrarContractsTest.php`, `src/Http/Routes/RouteRegistrar.php`)

**Plan**
- Add `API_CONTRACT_PRECEDENCE_AND_STABILITY.md` under `20_contracts/`.
- Add a section to `API_CONTRACT_GUIDE.md` with explicit envelope invariants:
  - `meta.envelope_version`, `meta.timestamp_utc`, request-id propagation.
  - Error envelope detail code mapping expectations.

---

### 3) Middleware and Request-Pipeline Contract Accuracy
**Why this matters:** Existing drift history shows middleware order and error-stage handling are easy to misdocument.

**Source topics to integrate**
- Global middleware order including `ErrorHandler` position and class map lock. (`src/Http/Middleware/MiddlewareOrder.php`, `tests/Contract/MiddlewareRegistryContractsTest.php`)
- Standard rejection mappings and detail codes from production-depth tests. (`tests/Contract/MiddlewareProductionDepthContractTest.php`)
- Request-pipeline summary doc for human-readable flow. (`docs/SSOT/Request_Pipeline_Reference.md`, `docs/request_lifecycle.md`)

**Plan**
- Expand `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` with:
  - authoritative order table (name, class, purpose, failure behavior).
  - rejection/detail-code map and emitted audit event names.
  - “contract lock rules” section tied to test + automation checks.

---

### 4) Security Posture and Runtime Hardening Completeness
**Why this matters:** Production-readiness requires key path safety, environment profile constraints, and token policy details to be explicit.

**Source topics to integrate**
- Boot safety assertions for CORS wildcard/prod, HTTPS issuer requirements, key permission checks. (`src/Bootstrap/BootChecks.php`)
- Runtime config policy knobs and defaults (rate-limit, JWT TTLs, CORS local wildcard policy). (`src/Config/RuntimeConfig.php`, `tests/Contract/RuntimeConfigPoliciesContractTest.php`)
- Security behavior from middleware and token verification tests (aud/type constraints, malformed token handling). (`tests/Contract/MiddlewareProductionDepthContractTest.php`, `tests/Security/JwtTokenSecurityTest.php`)

**Plan**
- Expand `SECURITY_CONTROLS_SPEC.md` and `CONFIGURATION_ENVIRONMENT_CONTRACT.md` with:
  - profile-specific disallowed settings matrix.
  - key material source and file permission policy.
  - token audience/type validation truth table.

---

### 5) Delegation and Key Lifecycle Deepening
**Why this matters:** The key lifecycle service contains critical operational semantics (subset, depth, TTL inheritance, replay handling) that should be first-class SSOT guidance.

**Source topics to integrate**
- Delegation depth cap (`MAX_DEPTH=3`), subset rules for permissions/scope, use-key constraints, parent expiry inheritance. (`src/Application/Auth/KeyLifecycleService.php`)
- Refresh token rotation/replay behavior for console/gateway surfaces. (`src/Application/Auth/AuthService.php`, `src/Application/Auth/KeyLifecycleService.php`)
- Drift warning about keychain routes and nomenclature mismatches. (`docs/SSOT/SSOT_CODEBASE_ALIGNMENT_ASSESSMENT_2026-04-06.md`)

**Plan**
- Add `DELEGATION_AND_REFRESH_TOKEN_STATE_MACHINE.md` under `20_contracts/` or `30_data_and_security/`.
- Add explicit state-transition tables and forbidden transition cases.

---

### 6) UI Runtime + Endpoint Parity Canonicalization
**Why this matters:** Current from-scratch set has UI runtime contract material, but the repository includes richer parity/state artifacts and decision rationale.

**Source topics to integrate**
- Unified endpoint/UI schema and route-state model from `ui/endpoints_unified.json`.
- SPA route and capability guard logic from `public/ui/app.js`.
- UI parity + endpoint decision docs. (`docs/SSOT/UI_Parity_Contract.md`, `docs/SSOT/UI_Endpoint_Contract_Executive_Decisions.md`, `docs/endpoints_ui_inventory.md`)

**Plan**
- Add `UI_PARITY_EXECUTIVE_DECISIONS.md` under `20_contracts/`.
- Expand `UI_RUNTIME_CONTRACT.md` with:
  - canonical route-state machine (`idle/loading/submitting/success/validation_error/forbidden/not_found/server_error`).
  - endpoint-to-screen parity checklist with evidence requirements.

---

### 7) Operations, Infra, and Runbook Closure
**Why this matters:** A standalone production-ready SSOT must describe deploy/rollback/key rotation/SLO ownership and infrastructure controls.

**Source topics to integrate**
- Production runbook procedures for deploy, rollback, rotation, and alert ownership. (`docs/SSOT/Operations_Runbook_Production.md`)
- Infra/IaC baseline and environment tiers. (`docs/SSOT/Infrastructure_IaC_Reference.md`)
- Boot evidence and operational smoke script contracts. (`src/Bootstrap/BootChecks.php`, `scripts/health_smoke.php`, `scripts/migrate_smoke.php`)

**Plan**
- Add `OPERATIONS_RUNBOOK_PRODUCTION.md` and `INFRASTRUCTURE_IAC_BASELINE.md` to `40_operations_and_quality/`.
- Extend `OPERATIONAL_SMOKE_CHECK_CONTRACT.md` with exact script invocation + expected pass/fail signals.

---

### 8) Automation and Evidence Contract Strengthening
**Why this matters:** SSOT maturity depends on automated drift detection and reproducible evidence.

**Source topics to integrate**
- SSOT lint, sync-check, and report scripts + output contract. (`scripts/docs_ssot_lint.php`, `scripts/docs_ssot_sync_check.php`, `scripts/docs_ssot_report.php`)
- Composer command contract and required scripts. (`composer.json`, `tests/Contract/ComposerScriptsContractTest.php`)

**Plan**
- Expand `SSOT_AUTOMATION_AND_LINTING.md` with mandatory CI gates:
  - `docs:ssot:lint`, `docs:ssot:sync-check`, `docs:ssot:report`.
- Add machine-readable “evidence schema” section defining required report fields and file paths.

---

### 9) Data Model and Lifecycle Edge Cases
**Why this matters:** Some useful table/lifecycle semantics are clearer in non-from_scratch docs and source implementation.

**Source topics to integrate**
- Refresh family token storage/rotation semantics and replay-revocation behavior. (`src/Application/Auth/AuthService.php`)
- Key and delegation persistence semantics from service inserts/queries. (`src/Application/Auth/KeyLifecycleService.php`)
- Table-level concise references from data model stub docs. (`docs/data_model_stub.md`)

**Plan**
- Expand `DATA_MODEL_REFERENCE.md` with “runtime-enforced invariants” appendix per table.
- Add SQL-level uniqueness/index assumptions where implied by runtime behavior and tests.

---

### 10) Governance and Decision Hygiene
**Why this matters:** Mature SSOT needs clear decision lineage and promotion workflow from dev artifacts.

**Source topics to integrate**
- Curated ADR inclusion/exclusion heuristics. (`docs/SSOT/ADR_Curated.md`)
- Dev-artifact promotion process. (`docs/dev/README.md`, `docs/dev/SESSION_LEDGER.md`, `docs/dev/DECISIONS.md`)

**Plan**
- Expand `60_decisions/ADR_INDEX.md` with curation policy.
- Add `DEV_ARTIFACT_PROMOTION_POLICY.md` under `80_program_management/`.

## Proposed New / Expanded Components (Backlog)

### Add New Documents
1. `from_scratch/ssot_canon/10_product_and_architecture/ARCHITECTURE_DIAGRAMS_AND_SEQUENCES.md`
2. `from_scratch/ssot_canon/20_contracts/API_CONTRACT_PRECEDENCE_AND_STABILITY.md`
3. `from_scratch/ssot_canon/20_contracts/UI_PARITY_EXECUTIVE_DECISIONS.md`
4. `from_scratch/ssot_canon/30_data_and_security/DELEGATION_AND_REFRESH_TOKEN_STATE_MACHINE.md`
5. `from_scratch/ssot_canon/40_operations_and_quality/OPERATIONS_RUNBOOK_PRODUCTION.md`
6. `from_scratch/ssot_canon/40_operations_and_quality/INFRASTRUCTURE_IAC_BASELINE.md`
7. `from_scratch/ssot_canon/80_program_management/DEV_ARTIFACT_PROMOTION_POLICY.md`

### Expand Existing Documents
- `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- `SECURITY_CONTROLS_SPEC.md`
- `CONFIGURATION_ENVIRONMENT_CONTRACT.md`
- `UI_RUNTIME_CONTRACT.md`
- `SSOT_AUTOMATION_AND_LINTING.md`
- `DATA_MODEL_REFERENCE.md`
- `ADR_INDEX.md`
- `OPERATIONAL_SMOKE_CHECK_CONTRACT.md`

## Execution Plan (Phased)

### Phase 1 — Contract and Security Accuracy (highest leverage)
- Update middleware contract + rejection code mapping.
- Update security/config profile safety matrices.
- Add delegation/refresh state machine.

**Exit criteria**
- Every rejection path in middleware tests has a corresponding SSOT entry.
- Runtime config and boot profile constraints are documented in one canonical matrix.

### Phase 2 — Operations and Automation Maturity
- Add production runbook + IaC baseline docs.
- Strengthen automation/evidence contracts with exact script/command outputs.

**Exit criteria**
- Operator can execute deploy/rollback/key rotation from docs alone.
- CI checks and expected evidence artifact schema are explicitly documented.

### Phase 3 — Architecture and UI Parity Refinement
- Add architecture sequences doc.
- Integrate UI executive decisions and parity audit checklist.

**Exit criteria**
- A new engineer can derive full endpoint↔UI behavior and route-state requirements from `/from_scratch` only.

### Phase 4 — Governance and Ongoing SSOT Hygiene
- Add ADR curation and dev-artifact promotion policy.
- Align roadmap/risk and completion gates to new canon maturity standards.

**Exit criteria**
- Document promotion and decision logging process are deterministic and auditable.

## Acceptance Criteria for “Standalone Production-Ready SSOT”
1. `/from_scratch` fully covers architecture, contracts, security, data, operations, automation, and governance with no dependency on legacy docs for critical decisions.
2. Every implementation-critical behavior in source/tests has a canonical contract location.
3. Automation and drift checks are documented and executable using repository scripts/composer commands.
4. Change-impact and traceability artifacts can be updated deterministically from the from-scratch canon alone.
