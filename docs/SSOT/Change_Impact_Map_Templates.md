# Change Impact Map Templates (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Operational templates for determining mandatory companion updates when SSOT-controlled behavior changes.

## How to use
1. Select a change type row below.
2. Update every listed companion artifact in the same PR.
3. Record evidence links in PR description and release checklist.

## Change impact matrix

| Change type | Primary trigger examples | Required companion SSOT updates | Required verification updates |
|---|---|---|---|
| **Auth claim change** | JWT claim added/removed/renamed; `typ/aud/iss` semantics changed; lineage claim behavior changed | `Security_Reference.md`, `Security_Controls_Spec.md`, `Authorization_and_Delegation_Spec.md`, `API_Contract_Guide.md`, `Endpoint_Examples_All_Routes.md`, `Error_Code_Catalog.md`, `Traceability_Matrix.md` | Security tests, auth contract tests, refresh/login regression paths, claim-validation negative tests |
| **Middleware order or policy change** | Middleware reorder, insertion/removal, CORS/CSRF/rate-limit behavior adjustments | `Request_Pipeline_Reference.md`, `Security_Reference.md`, `Operations_Reference.md`, `Error_Code_Catalog.md`, `Observability_Event_Catalog.md`, `Traceability_Matrix.md` | Middleware behavior tests, contract tests for affected routes, 401/403/422/429 regression checks |
| **Data schema/model change** | New table/column/index; enum change; retention change; lifecycle state change | `Data_Model_Spec.md`, `Data_Model_Reference.md`, `ERD.md`, `Authorization_and_Delegation_Spec.md` (if auth-related), `Traceability_Matrix.md` | Migration smoke tests, data integrity checks, lifecycle regression tests |
| **Error code/detail code change** | Add/remove/rename `error.code` or detail codes; mapping semantics changed | `Error_Code_Catalog.md`, `API_Contract_Guide.md`, `Endpoint_Examples_All_Routes.md`, `UI_Parity_Contract.md`, `UI_Parity_and_Contract.md`, `Observability_Event_Catalog.md` | Contract tests for envelope shape, UI error mapping checks, observability emission assertions |

## PR checklist template (copy/paste)
- [ ] Change type selected and mapped in this document.
- [ ] All listed companion SSOT docs updated.
- [ ] OpenAPI/schemas updated where applicable.
- [ ] Verification updates added and executed.
- [ ] Traceability and release checklist updated.

## Ownership
- Document owner: architecture + QA leads.
- Enforcement point: PR review and release gate validation.
