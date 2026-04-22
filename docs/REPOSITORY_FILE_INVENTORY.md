# Repository File Inventory

_Last updated (UTC): 2026-04-22_

## Purpose
Quick index of the repository document set and root-level configuration artifacts used for SSOT-first implementation.

## Root configuration artifacts
- `dot.env` — Environment template/reference values aligned to runtime config contract.
- `composer.json` — Dependency baseline and command contracts (`test`, `qa`, `ops:*`; optional `docs:ssot:*` when tooling exists).
- `.htaccess` — Runtime entry/rewrite behavior for root vs `public/` serving.

## Foundational docs
- `docs/README.md`
- `docs/CORE_IDENTITY_AND_VALUE_PROPOSITION.md`
- `docs/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`
- `docs/RECOMMENDED_READING_ORDER.md`
- `docs/REPOSITORY_FILE_INVENTORY.md`
- `docs/LLM_ONBOARDING_MASTER_PROMPT.md`
- `docs/HIGH_LEVEL_REPORT_2026-04-09.md`
- `docs/ONBOARDING_ANALYSIS_2026-04-12.md`
- `docs/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md`

## SSOT canon families
- `docs/ssot_canon/00_governance/*`
- `docs/ssot_canon/10_product_and_architecture/*`
- `docs/ssot_canon/20_contracts/*`
- `docs/ssot_canon/30_data_and_security/*`
- `docs/ssot_canon/40_operations_and_quality/*`
- `docs/ssot_canon/50_traceability_and_automation/*`
- `docs/ssot_canon/60_decisions/*`
- `docs/ssot_canon/70_implementation_guidance/*`
- `docs/ssot_canon/80_program_management/*`
- `docs/ssot_canon/openapi/cre8.v1.yaml`
- `docs/ssot_canon/schemas/success-envelope.schema.json`
- `docs/ssot_canon/schemas/error-envelope.schema.json`
- `docs/ssot_canon/evidence/*`

## Narrative synthesis set
Narrative documents under docs/narrative/ (historical, not present) are not present in this repository snapshot and are not part of the active canon index.

## Implementation planning + execution artifacts (current)
- `docs/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`
- `docs/M1_DAY_1_21_DETAILED_SLICES.md`
- `docs/M2_DAY_22_45_DETAILED_SLICES.md`
- `docs/M3_DAY_46_69_DETAILED_SLICES.md`
- `docs/M4_RELEASE_READINESS_DETAILED_SLICES.md`

## Status declaration
Current repository state is documentation-first: canonical SSOT, planning, and governance artifacts are present; runtime implementation remains to be built against these contracts.
