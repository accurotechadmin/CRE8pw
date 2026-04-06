# CRE8 SSOT Index

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Purpose
This folder is the authoritative, production-oriented source of truth for CRE8 behavior, contracts, controls, and release readiness.

## Governance
- **Canonical over non-SSOT docs:** when content conflicts, SSOT docs win.
- **Versioning:** each SSOT file carries a last-updated timestamp and semantic status (`draft|adopted|deprecated`).
- **Change control:** any route, middleware, schema, claim, permission, or operational policy change must update affected SSOT docs in the same PR.
- **Review cadence:** security and operations docs reviewed monthly; API/data/UI contract docs reviewed each release.

## Reading order (production path)
1. `CRE8_Spec.md`
2. `Architecture_Reference.md`
3. `Dependency_Reference.md`
4. `Request_Pipeline_Reference.md`
5. `API_Contract_Guide.md`
6. `openapi/cre8.v1.yaml`
7. `Error_Code_Catalog.md`
8. `Authorization_and_Delegation_Spec.md`
9. `Data_Model_Reference.md`
10. `Data_Model_Spec.md`
11. `ERD.md`
12. `Security_Reference.md`
13. `Security_Controls_Spec.md`
14. `SECURITY_THREAT_MODEL.md`
15. `UI_Parity_and_Contract.md`
16. `UI_Parity_Contract.md`
17. `Operations_Reference.md`
18. `Operations_Runbook_Production.md`
19. `Observability_Event_Catalog.md`
20. `Verification_Strategy.md`
21. `Production_Readiness_Gates.md`
22. `RELEASE_CHECKLIST.md`
23. `SLO_SLI_SPEC.md`
24. `Architecture_Diagrams.md`
25. `Traceability_Matrix.md`
26. `ADR_Curated.md`

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
