# CRE8 SSOT Index

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
This folder is the authoritative, production-oriented source of truth for CRE8 behavior, contracts, controls, and release readiness.

## Governance
- **Canonical over non-SSOT docs:** when content conflicts, SSOT docs win.
- **Versioning:** each SSOT file carries a last-updated timestamp and semantic status (`draft|adopted|deprecated`).
- **Change control:** any route, middleware, schema, claim, permission, or operational policy change must update affected SSOT docs in the same PR.
- **Review cadence:** security and operations docs reviewed monthly; API/data/UI contract docs reviewed each release.

## Reading order (production path)
1. `CRE8_Spec.md`
2. `Canonical_Terminology_Dictionary.md`
3. `Architecture_Reference.md`
4. `Dependency_Reference.md`
5. `Change_Impact_Map_Templates.md`
6. `Known_Gaps_Tracker.md`
7. `Configuration_Environment_Contract.md`
8. `Boot_and_Startup_Failure_Contract.md`
9. `Request_Pipeline_Reference.md`
10. `Route_Inventory_Reference.md`
11. `API_Contract_Guide.md`
12. `openapi/cre8.v1.yaml`
13. `Health_Endpoint_Contract.md`
14. `Error_Code_Catalog.md`
15. `Authorization_and_Delegation_Spec.md`
16. `Data_Model_Reference.md`
17. `Data_Model_Spec.md`
18. `ERD.md`
19. `Migration_Seed_Strategy.md`
20. `Local_Dev_Seed_and_Bootstrap_Policy.md`
21. `Security_Reference.md`
22. `Security_Controls_Spec.md`
23. `Security_Headers_and_CSP_Policy.md`
24. `SECURITY_THREAT_MODEL.md`
25. `Security_Verification_Abuse_Cases.md`
26. `UI_Parity_and_Contract.md`
27. `UI_Parity_Contract.md`
28. `UI_Contract_Artifacts_Reference.md`
29. `UI_Runtime_Contract.md`
30. `Acceptance_Criteria_Matrix.md`
31. `Authorization_Decision_Tables.md`
32. `Operations_Reference.md`
33. `Infrastructure_IaC_Reference.md`
34. `Operations_Runbook_Production.md`
35. `Operational_Smoke_Check_Contract.md`
36. `Observability_Event_Catalog.md`
37. `Verification_Strategy.md`
38. `Production_Readiness_Gates.md`
39. `RELEASE_CHECKLIST.md`
40. `SLO_SLI_SPEC.md`
41. `SSOT_Automation_and_Linting.md`
42. `Architecture_Diagrams.md`
43. `Traceability_Matrix.md`
44. `Prototype_to_SSOT_Delta_Map.md`
45. `ADR_Curated.md`

## Supersedes map
- `docs/architecture_overview.md` → `Architecture_Reference.md`
- `docs/request_lifecycle.md` → `Request_Pipeline_Reference.md`
- `docs/security_model.md` → `Security_Reference.md`
- `docs/deployment_operations.md` + `docs/observability_runbook.md` → `Operations_Reference.md`
- `docs/api_reference_stub.md` → `API_Contract_Guide.md` + `openapi/cre8.v1.yaml`
- `docs/data_model_stub.md` → `Data_Model_Reference.md` + `Data_Model_Spec.md`
- `docs/endpoints_ui_inventory.md` + `docs/frontend_spa_guide.md` + `ui/endpoints_unified.json` decisions → `UI_Parity_and_Contract.md`
- `docs/testing_strategy.md` + stable QA guidance → `Verification_Strategy.md`

## Ownership
- Platform architecture: backend maintainers
- API contract + schemas: backend + QA leads
- Security docs: security owner
- UI parity docs: frontend owner
- Operations docs: platform/SRE owner

## Appendix artifacts
- `CRE8_Architecture_High_Level_Summary.md` (orientation summary)
- `UI_Endpoint_Contract_Executive_Decisions.md` (decision log for UI contract expansion)
- `answered_questions001.md`, `answered_questions001a.md` (resolved question archives)
- `Known_Gaps_Tracker.md` (short unresolved SSOT-level decision tracker)
- `SSOT_Automation_and_Linting.md` (CI-grade SSOT drift prevention requirements)
- `UI_Runtime_Contract.md` (no-build SPA implementation contract)
- `Prototype_to_SSOT_Delta_Map.md` (prototype reconciliation register)
- `HYBRID_REBUILD_ROADMAP_1_2_3.md` (execution roadmap for hybrid rebuild staging)
- `REBUILD_STRATEGY_OPTIONS_FOR_CRE8.md` (rebuild option set and comparative strategy matrix)
- `SSOT_CODEBASE_ALIGNMENT_ASSESSMENT_2026-04-06.md` (snapshot SSOT-to-codebase drift assessment)
- `scaffold_stubs.json` (initial scaffold + stub structure source for rebuild execution)
- `REUSABLE_LLM_SESSION_PROMPT.md` (copy/paste prompt for expert LLM session handoff continuity)
