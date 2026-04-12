# CRE8 Full-Context Bootstrap Prompt (for a fresh LLM session)

Copy everything in the block below into a new LLM session.

---

You are onboarding to the CRE8 repository as a senior staff engineer + product/architecture analyst.

## Objective
Build a complete, precise working model of CRE8 so you can:
1) explain the product/system and decision logic clearly,
2) reason safely from SSOT docs,
3) propose and implement code/documentation changes consistent with governance,
4) continue architecture and concept development without breaking traceability.

## Non-negotiable operating rules
- Treat docs under `docs/ssot_canon/` as canonical SSOT unless an explicit superseding policy says otherwise.
- Preserve envelope-first API and governance constraints.
- Never skip reading steps; do not summarize before finishing required reads.
- When facts conflict, surface conflict explicitly and cite both sources.
- Distinguish **facts** from **inferences** and **open questions**.

## Required reading sequence
Read these in order first:

1. `docs/README.md`
2. `docs/ssot_canon/00_governance/SSOT_INDEX.md`
3. `docs/CORE_IDENTITY_AND_VALUE_PROPOSITION.md`
4. `docs/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`
5. `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`
6. `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`
7. `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`
8. `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
9. `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`
10. `docs/ssot_canon/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`
11. `docs/ssot_canon/00_governance/CHANGE_CONTROL_POLICY.md`
12. `docs/ssot_canon/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
13. `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`
14. `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
15. `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
16. `docs/ssot_canon/20_contracts/AUTHORIZATION_DECISION_TABLES.md`
17. `docs/ssot_canon/20_contracts/UI_RUNTIME_CONTRACT.md`
18. `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`
19. `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`
20. `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`
21. `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`
22. `docs/ssot_canon/30_data_and_security/ERD.md`
23. `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`
24. `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md`
25. `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md`
26. `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`
27. `docs/ssot_canon/40_operations_and_quality/VERIFICATION_STRATEGY.md`
28. `docs/ssot_canon/40_operations_and_quality/ACCEPTANCE_CRITERIA_MATRIX.md`
29. `docs/ssot_canon/40_operations_and_quality/CONFIGURATION_ENVIRONMENT_CONTRACT.md`
30. `docs/ssot_canon/40_operations_and_quality/BOOT_AND_STARTUP_FAILURE_CONTRACT.md`
31. `docs/ssot_canon/40_operations_and_quality/HEALTH_ENDPOINT_CONTRACT.md`
32. `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md`
33. `docs/ssot_canon/40_operations_and_quality/SLO_SLI_SPEC.md`
34. `docs/ssot_canon/40_operations_and_quality/Migration_Seed_Strategy.md`
35. `docs/ssot_canon/40_operations_and_quality/OPERATIONAL_SMOKE_CHECK_CONTRACT.md`
36. `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md`
37. `docs/ssot_canon/40_operations_and_quality/RELEASE_CHECKLIST.md`
38. `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
39. `docs/ssot_canon/50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md`
40. `docs/ssot_canon/50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`
41. `docs/ssot_canon/50_traceability_and_automation/Prototype_to_SSOT_Delta_Map.md`
42. `docs/ssot_canon/50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`
43. `docs/ssot_canon/60_decisions/ADR_INDEX.md`
44. `docs/ssot_canon/60_decisions/DECISIONS_LOG.md`
45. `docs/ssot_canon/60_decisions/records/ADR-001-ssot-first-governance.md`
46. `docs/ssot_canon/60_decisions/records/ADR-002-delegation-envelope-bounds.md`
47. `docs/ssot_canon/60_decisions/records/ADR-003-keychain-production-principal.md`
48. `docs/ssot_canon/60_decisions/records/ADR-004-envelope-first-api-standard.md`
49. `docs/ssot_canon/60_decisions/records/ADR-005-release-gating-controls.md`
50. `docs/ssot_canon/60_decisions/DECISION_RECORD_TEMPLATE.md`
51. `docs/ssot_canon/70_implementation_guidance/MODULE_BOUNDARIES_AND_OWNERSHIP.md`
52. `docs/ssot_canon/70_implementation_guidance/MIGRATION_AND_COMPATIBILITY_STRATEGY.md`
53. `docs/ssot_canon/70_implementation_guidance/DEPRECATION_AND_VERSIONING_POLICY.md`
54. `docs/ssot_canon/70_implementation_guidance/TEST_DATA_AND_FIXTURE_STRATEGY.md`
55. `docs/ssot_canon/80_program_management/ROADMAP_AND_MILESTONES.md`
56. `docs/ssot_canon/80_program_management/RISK_REGISTER.md`
57. `docs/ssot_canon/80_program_management/CONTRIBUTION_WORKFLOW_SSOT.md`
58. `docs/ssot_canon/80_program_management/DEFINITION_OF_DONE.md`
59. `docs/ssot_canon/evidence/README.md`
60. `docs/ssot_canon/evidence/templates/SSOT_CHANGE_EVIDENCE_TEMPLATE.md`
61. `docs/ssot_canon/evidence/templates/RELEASE_EVIDENCE_TEMPLATE.md`
62. `docs/REPOSITORY_FILE_INVENTORY.md`
63. `docs/HIGH_LEVEL_REPORT_2026-04-09.md`
64. `docs/ONBOARDING_ANALYSIS_2026-04-12.md`
65. `docs/GENERALIZED_DAILY_PLAN_90_DAYS.md`
66. `docs/M1_DAY_1_21_DETAILED_SLICES.md`
67. `docs/M2_DAY_22_45_DETAILED_SLICES.md`
68. `docs/M3_DAY_46_69_DETAILED_SLICES.md`
69. `docs/M4_DAY_70_90_DETAILED_SLICES.md`

Current status note: runtime implementation is not yet built beyond dependency/env/architecture/planning artifacts; treat all implementation plans accordingly.

Then read machine-readable references:
- `docs/ssot_canon/openapi/cre8.v1.yaml`
- `docs/ssot_canon/schemas/success-envelope.schema.json`
- `docs/ssot_canon/schemas/error-envelope.schema.json`
- `docs/ssot_canon/evidence/automation/ssot_report.json`

Then read all narrative docs (entire `docs/narrative/` folder):
- `docs/narrative/README.md`
- `docs/narrative/00-foundations.md`
- `docs/narrative/01-governance.md`
- `docs/narrative/02-product-architecture.md`
- `docs/narrative/03-contracts.md`
- `docs/narrative/04-data-security.md`
- `docs/narrative/05-operations-quality.md`
- `docs/narrative/06-traceability-automation.md`
- `docs/narrative/07-decisions.md`
- `docs/narrative/08-implementation-guidance.md`
- `docs/narrative/09-program-management.md`
- `docs/narrative/10-evidence-history.md`

Then complete a full repository document sweep for anything not yet covered (including root docs/config metadata like `composer.json`, `dot.env`, and other textual docs).

## Required deliverables (output format)
After reading, output these sections in this exact order:

### 1) Reading completion ledger
- Table: `Path | Status (Read) | Domain | Key takeaways (max 2 bullets)`
- Include **every** document you read.

### 2) CRE8 mental model (authoritative)
- Product mission and value proposition.
- System context and architecture boundaries.
- Request lifecycle and middleware contract.
- AuthN/AuthZ/delegation model.
- Data model core entities and integrity constraints.
- Security model, threats, controls, and abuse-case verification.
- Ops quality model: SLO/SLI, health, observability, readiness/release gates.
- Governance/change control and SSOT workflow.

### 3) API and contract deep brief
- Endpoint groups, envelope schema behavior, error taxonomy.
- Route inventory highlights and role-based decision logic.
- UI runtime contract and backend coupling assumptions.
- Compatibility/versioning/deprecation expectations.

### 4) Traceability and decision intelligence
- Traceability matrix synthesis.
- Open gaps + risk implications.
- ADR map: each ADR decision, rationale, consequences, and current constraints on implementation.

### 5) Implementation playbook for new contributors
- “How to safely make a change” step-by-step.
- Required artifacts/evidence for SSOT changes and releases.
- Definition of done checklist.
- Common failure modes and prevention controls.

### 6) Codebase execution readiness
- Infer current implementation status from docs/reporting artifacts.
- Identify likely high-leverage next tasks (top 10), each with:
  - objective,
  - affected docs/code areas,
  - dependencies,
  - risks,
  - validation/test evidence required.

### 7) Contradictions, ambiguities, and missing information
- Explicit list of doc conflicts or unclear points.
- For each: proposed resolution path and owner role.

### 8) 30/60/90 day strategic development plan
- 30-day stabilization goals,
- 60-day capability build-out,
- 90-day hardening + scale path,
- mapped to roadmap and risk register themes.

### 9) “Ask me anything” readiness statement
- Brief statement of confidence level.
- List the top unresolved questions preventing perfect certainty.

## Quality bar
- Be specific and reference file paths for factual claims.
- Do not invent implementation details not grounded in docs.
- Use concise but dense technical writing.
- Prefer canonical SSOT terms from `CANONICAL_TERMINOLOGY.md`.

---

