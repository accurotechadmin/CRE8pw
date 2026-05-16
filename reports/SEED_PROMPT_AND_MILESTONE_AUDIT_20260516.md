# Seed Prompt and Milestone Reality Audit
- Timestamp (UTC): 2026-05-16
- Scope: prompt lineage, seed-program documentation state, milestone reality check from file contents

## 1) Prompt documents discovered and what they do

### Seed-program prompts
- `dev/SEED_GENERATION_EXPERT_SESSION_PROMPT.md`
  - Purpose: reusable startup prompt for seed-generating sessions.
  - Explicitly instructs the session to use `dev/SEED_GENERATING_MILESTONES_AND_SLICES.md` as primary execution plan and cross-check with `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`.
  - Enforces `/fresh` as root for new authored/generated seed artifacts and requires continuity updates.

### SSOT implementation prompts (newer generation than phase templates)
- `dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md`
  - Purpose: canonical boot prompt for implementation/governance sessions.
  - Explicitly requires reading `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md` immediately after canon reading list.
  - Contains explicit last-updated marker `2026-05-05`.
- `dev/CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md`
  - Purpose: code-focused variant that keeps docs/seed read-only except required governance updates.
  - Contains explicit last-updated marker `2026-05-05`.
- `dev/CRE8_PERMISSIONS_AND_DELEGATION_SSOT_SESSION_PROMPT.md`
  - Purpose: authz/PDP domain-specific session driver; aligns with Phase 3/4 continuity conventions.
- `dev/CRE8_EXPERT_SESSION_COMPREHENSIVE_PRIMER_PROMPT.md`
  - Purpose: deep-read onboarding prompt via comprehensive reading list.

### Older phase-era prompts
- `reports/PHASE1_SESSION_PROMPT_TEMPLATE.md`
- `reports/PHASE2_SESSION_PROMPT_TEMPLATE.md`
- `reports/PHASE3_AUTHORING_SESSION_PROMPT.md`
- `reports/PHASE4_AUTHORING_SESSION_PROMPT.md`
- `reports/session_prompts/PHASE1_*` historical records

## 2) Most recent prompt that should have been used for milestone/slice-driven seed continuation

Based on prompt intent and cross-references, the correct current prompt for seed-doc continuation is:

1. `dev/SEED_GENERATION_EXPERT_SESSION_PROMPT.md` (seed-program execution driver)
2. plus `dev/SEED_GENERATING_MILESTONES_AND_SLICES.md` (authoritative seed-program milestone map)

And for general implementation sessions: `dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md` + `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`.

## 3) Evidence from current docs suggesting wrong-vs-right prompt usage

### Signals consistent with correct prompt usage at least part of the time
- `/fresh` mirror path exists and is actively used for continuity/control outputs (`fresh/seed-generating-docs/...`, `fresh/reports/session_handoffs/...`).
- Continuity artifacts reference seed milestone/slice IDs and anti-drift checks tied to the seed prompt contract.
- Control/governance docs in both in-place and `/fresh` locations were synchronized repeatedly.

### Signals consistent with wrong/incomplete prompt usage one or more times
- Seed roadmap M5 requires authoring ten seed docs under `/fresh/seed-generating-docs/10_seeds/10..19_*`; that directory/file family is absent.
- Seed roadmap M6 requires `20_final_document_blueprint.md` under `/fresh/seed-generating-docs/20_generation/`; absent.
- Seed roadmap M3 requires canonical vocabulary + best-practices + legacy-language controls; those files exist in root `seed-generating-docs/00_control`/`30_governance` but are absent from `/fresh` mirror set currently tracked.
- Progress continuity emphasizes M4/M6/M7/M9 governance sweeps but does not show completion artifacts for major content-authoring milestone M5 in `/fresh`.

Conclusion: correct prompt appears to have been used in some sessions, but execution has been partial and continuity-heavy; there is strong file-level evidence that earlier or intermittent sessions did not fully execute the newest seed milestone flow end-to-end.

## 4) Milestone reality status (file-content grounded, not trusting progress claims)

Status legend: `complete`, `partial`, `not_started` (based on observable required artifacts).

- M0 Session boot/continuity alignment: **partial→likely complete operationally**, evidenced by repeated handoff updates and latest-pointer maintenance.
- M1 Source control layer: **partial**, since source inventory exists (in-place + `/fresh`) but full coverage cannot be claimed solely from structure checks.
- M2 Preservation/traceability layer: **partial**, preservation ledger exists but true “all meaningful source items covered” needs row-level audit.
- M3 Normalization layer: **partial**, normalization artifacts exist in root corpus; `/fresh` portability coverage is incomplete.
- M4 Resolution layer: **partial**, conflict/decision registers exist and are updated; no evidence all conflicts closed.
- M5 Canonical seed authoring (10–19 under `/fresh/10_seeds`): **not_started or minimally started in `/fresh`** (required `/fresh` files absent).
- M6 Generation layer: **partial**, generation instructions/checklist exist in `/fresh`; final blueprint artifact in `/fresh` absent.
- M7 Validation/consistency closure: **partial**, consistency matrix exists and is updated, but depends on incomplete M5/M6 outputs.
- M8 Final corpus dry run: **not_started** (no dry-run output set evident in `/fresh`).
- M9 Release handoff/operationalization: **partial**, handoff mechanics are active but dependent on substantive milestone completion.

## 5) Practical current development status

The seed program is currently documentation-process mature (continuity, anti-drift, governance hygiene) but content-production incomplete for the core deliverable milestones (especially M5 and downstream M8).

Highest-confidence next truth actions:
1. Execute M5 slices S5.1–S5.10 in `/fresh/seed-generating-docs/10_seeds/`.
2. Complete M6 blueprint in `/fresh/seed-generating-docs/20_generation/20_final_document_blueprint.md`.
3. Re-run M7 validation after M5/M6 completion.
4. Only then claim M8 dry-run readiness.
