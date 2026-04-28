# Repository File Inventory

_Last updated (UTC): 2026-04-28_

## Purpose
Quick index of the repository document set and root-level configuration artifacts used for SSOT-first implementation.

## Root configuration artifacts
- `dot.env` — Environment template/reference values aligned to runtime config contract.
- `../../composer.json` — Dependency baseline and command contracts (`test`, `qa`, `ops:*`; optional `docs:ssot:*` when tooling exists).

## Foundational docs
- `docs/01_foundation/README.md`
- `docs/01_foundation/CORE_IDENTITY_AND_VALUE_PROPOSITION.md`
- `docs/01_foundation/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`
- `docs/01_foundation/RECOMMENDED_READING_ORDER.md`
- `docs/01_foundation/REPOSITORY_FILE_INVENTORY.md`
- `docs/02_onboarding_and_audits/LLM_ONBOARDING_MASTER_PROMPT.md`
- `docs/02_onboarding_and_audits/HIGH_LEVEL_REPORT_2026-04-09.md`
- `docs/02_onboarding_and_audits/ONBOARDING_ANALYSIS_2026-04-12.md`
- `docs/02_onboarding_and_audits/FULL_REPOSITORY_DOCUMENT_AUDIT_2026-04-22.md`

## SSOT canon families
- `docs/ssot_canon/00_governance/*`
- `docs/ssot_canon/10_product_and_architecture/*` (includes `CRE8_HUMAN_OPERATING_MODEL.md`)
- `docs/ssot_canon/20_contracts/*` (includes `USAGE_SCENARIOS_AND_PERMISSION_STORIES.md`)
- `docs/ssot_canon/30_data_and_security/*`
- `docs/ssot_canon/40_operations_and_quality/*`
- `docs/ssot_canon/50_traceability_and_automation/*`
- `docs/ssot_canon/60_decisions/*`
- `docs/ssot_canon/70_implementation_guidance/*` (includes `EXTENSIBILITY_PLAYBOOK.md`)
- `docs/ssot_canon/80_program_management/*`
- `docs/ssot_canon/openapi/cre8.v1.yaml`
- `docs/ssot_canon/schemas/success-envelope.schema.json`
- `docs/ssot_canon/schemas/error-envelope.schema.json`
- `docs/ssot_canon/evidence/*`

## Implementation planning + execution artifacts (current)
- `docs/03_execution_planning/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`
- `docs/03_execution_planning/DEVELOPMENT_EXECUTION_DETAILED_SLICES.md`
- `docs/03_execution_planning/ARCHITECTURE_ADDITIONS_AND_UPGRADES_IMPLEMENTATION_MASTER_PLAN.md`
- `docs/03_execution_planning/ARCHITECTURE_ADDITIONS_AND_UPGRADES_EXHAUSTIVE_SLICES.md`
- `docs/03_execution_planning/ARCHITECTURE_UPGRADE_GOVERNANCE_APPROVAL_RECORD.md`
- `docs/03_execution_planning/ARCHITECTURE_UPGRADE_EPIC_BACKLOG.md`

## Runtime scaffold directories (U0-04 baseline)
- `src/Application/Http/Middleware/`
- `src/Application/Http/Controller/Gateway/`
- `src/Application/Http/Controller/Console/`
- `src/Application/Policy/`
- `src/Application/Auth/`
- `src/Application/Domain/`
- `src/Application/Command/`
- `src/Application/Query/`
- `src/Application/Projection/`
- `src/Application/Audit/`
- `src/Infrastructure/Persistence/`
- `src/Infrastructure/Observability/`
- `config/`
- `database/migrations/`
- `database/seeds/`
- `tests/Contract/`
- `tests/Security/`
- `tests/Integration/`
- `tests/Unit/`

## Status declaration
Current repository state is SSOT-driven with architecture-upgrade planning artifacts and runtime scaffold directories in place for implementation slices.
