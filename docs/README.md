# CRE8 From-Scratch SSOT Canon

_Status: adopted (production baseline)_
_Last updated (UTC): 2026-04-22_

## Purpose
This folder is the standalone source-of-truth canon for operating and extending CRE8 in production. It is intended to be sufficient on its own for architecture, contracts, data/security controls, verification, operations, and delivery governance.

## Canon scope
- Product and system intent, boundaries, and architectural constraints.
- API/UI/runtime contracts, authorization model, error model, and route behavior.
- Data model, security controls, threat/abuse verification, and operational controls.
- Traceability, decision governance, implementation guidance, and program controls.

## Authoritative reading path
1. `CORE_IDENTITY_AND_VALUE_PROPOSITION.md`
2. `TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`
3. `ssot_canon/00_governance/SSOT_INDEX.md`
4. `ssot_canon/10_product_and_architecture/*`
5. `ssot_canon/20_contracts/*`
6. `ssot_canon/30_data_and_security/*`
7. `ssot_canon/40_operations_and_quality/*`
8. `ssot_canon/50_traceability_and_automation/*`
9. `ssot_canon/60_decisions/*`
10. `ssot_canon/70_implementation_guidance/*`
11. `ssot_canon/80_program_management/*`

## Implementation planning and onboarding artifacts (current)
Use these after canonical SSOT reading for execution sequencing and handoff discipline:
- `RECOMMENDED_READING_ORDER.md`
- `REPOSITORY_FILE_INVENTORY.md`
- `LLM_ONBOARDING_MASTER_PROMPT.md`
- `ONBOARDING_ANALYSIS_2026-04-12.md`
- `FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md`
- `DEVELOPMENT_EXECUTION_MASTER_PLAN.md`
- `DEVELOPMENT_EXECUTION_DETAILED_SLICES.md`
- `INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md`
- `INSTRUCTOR_FOLLOWUP_LECTURE_EXTENDING_CRE8.md`

## Current implementation status declaration
As of 2026-04-22, the repository is documentation-first with architecture/contracts/governance canon in place; the canon reflects production-governing architecture, contracts, and controls currently enforced for CRE8 operations.

## Finality and change policy
- This canon is production-governing documentation, not a draft work area.
- Changes are allowed only through SSOT-governed PR workflow with traceability and evidence.
- Historical scaffolding/completion artifacts are intentionally excluded from this folder.

## Non-negotiable rules
- OpenAPI + envelope schemas are machine source-of-truth for interface shape.
- Route inventory + acceptance criteria are source-of-truth for behavior intent.
- Data model, authorization, and security controls must remain mutually consistent.
- Any behavior change requires traceability updates in the same PR.
- Release-impacting changes require verification and evidence artifacts.

## Definition of quality
A canon document is acceptable only when it is:
- normative and implementation-direct,
- testable with explicit verification hooks,
- traceable to routes/services/tests/operations controls,
- internally consistent with the rest of this folder.
