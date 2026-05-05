# Master Index (Operational)

_Last updated (UTC): 2026-05-05_

## Purpose
This index is the operational map for all canonical specs, machine contracts, seeds, reports, evidence, and update-control references in this repository.

## 1) Global navigation anchors
- Repository onboarding: `README.md`
- Expert coding LLM boot prompt (paste-first session message): `dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md`
- Sequential SSOT canon reading list (developers): `dev/SSOT_CANON_READING_LIST.md`
- Full file inventory: `FILE_INVENTORY.md`
- This operations index: `master_index.md`
- Reference maintenance SOP: `REFERENCE_MAINTENANCE_SOP.md`
- Reference refresh executor prompt: `reports/REFERENCE_REFRESH_SESSION_PROMPT.md`

## 2) Canonical SSOT corpus (`docs/`)
- Canon root map: `docs/README.md`
- Governance and process controls: `docs/00_governance/`
  - Primary index: `docs/00_governance/SSOT_INDEX.md`
  - Change-control + contribution controls:
    - `CHANGE_CONTROL_POLICY.md`
    - `CONTRIBUTION_WORKFLOW_SSOT.md`
    - `CROSS_DOCUMENT_LINKING_POLICY.md`
    - `DEFINITION_OF_DONE.md`
    - `DOCUMENT_STATUS_AND_OWNERSHIP.md`
    - `DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
- Domain specs:
  - Product/architecture: `docs/10_product_and_architecture/`
  - Identity/delegation/policy: `docs/20_identity_delegation_and_policy/`
  - Contracts/interfaces: `docs/30_contracts_and_interfaces/`
  - Machine contracts + schemas + OpenAPI: `docs/31_machine_contracts/`
  - Data/security/crypto: `docs/40_data_security_and_crypto/`
  - Content/audience/feed: `docs/50_content_audience_and_feed/`
  - Operations/quality/release: `docs/60_operations_quality_and_release/`
  - Extensibility/module patterns: `docs/70_extensibility_and_module_patterns/`
  - Traceability/decisions/program: `docs/80_traceability_decisions_and_program/`
- Evidence registry and templates:
  - `docs/evidence/README.md`
  - `docs/evidence/templates/`
  - `docs/evidence/automation/README.md`

## 3) Seed provenance corpus (`seed/`)
- Seed introduction and seed index:
  - `seed/seed-intro.md`
  - `seed/seed-index.md`
  - `seed/CRE8_SEED_CANON_INDEX.md`
- Seed domain sources: all `seed/CRE8_*_SEED.md` files
- Seed preservation and assessment:
  - `seed/CRE8_SEED_PRESERVATION_MATRIX.md`
  - `seed/CRE8_SEED_CANON_ASSESSMENT_REPORT.md`
  - `seed/CRE8_REPO_STUDY_REPORT.md`

## 4) Reports, continuity, and session artifacts (`reports/`)
- Reports root index: `reports/README.md`
- Program-level phase references:
  - `PHASE1_*`, `PHASE2_*`, `PHASE3_*`, `PHASE4_*`
- Session continuity controls:
  - `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
  - `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`
  - `reports/session_handoffs/PHASE4_PROGRESS_BOARD.md`
- Session transcript/evidence archives:
  - `reports/session_responses/README.md`
  - `reports/session_prompts/`
  - `reports/change_impact_maps/`
  - `reports/phase4/`

## 5) Automation and verification references
- Package command registry: `composer.json`
- CI gate workflow: `.github/workflows/ssot_phase_gate.yml`
- SSOT + verification script corpus: `scripts/`

## 6) Mandatory update chain (when repo content changes)
When adding/renaming/removing documentation, schema, report, seed, or workflow files, update in this order:
1. `FILE_INVENTORY.md` (full file list accuracy)
2. `master_index.md` (navigation + role-level placement)
3. `REFERENCE_MAINTENANCE_SOP.md` (if process or ownership scope changes)
4. Relevant local indexes/readmes (examples):
   - `dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md` (when LLM/developer boot artifacts change)
   - `dev/SSOT_CANON_READING_LIST.md` (when SSOT developer reading scope changes)
   - `docs/README.md`
   - `docs/00_governance/SSOT_INDEX.md`
   - `reports/README.md`
   - `reports/session_responses/README.md`
   - `seed/seed-index.md`
5. Any impacted traceability or parity records (if requirement/contract behavior changed)

## 7) Quality gates for references
Before merge, verify:
- every new file is linked by at least one parent index/readme,
- every moved/renamed file has no stale links,
- inventory totals and paths are exact,
- continuity docs still point to existing files,
- machine-contract changes include corresponding parity/impact references.
