# `dev/` — Development planning and onboarding

_Last updated (UTC): 2026-05-06 (permissions SSOT session driver added)_

## Purpose

The **`dev/`** directory holds **development-facing** artifacts: onboarding, expert-session prompts, the SSOT syllabus for implementers, and **phased implementation plans**. It does **not** replace **`docs/`** for normative requirements; authoritative product and platform behavior specifications remain under `docs/` per **`docs/00_governance/SSOT_INDEX.md`**.

## Contents

| Document | Role |
|---|---|
| [`SSOT_CANON_READING_LIST.md`](./SSOT_CANON_READING_LIST.md) | Sequential developer reading path across all SSOT domains and tooling |
| [`SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`](./SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md) | Primary phased milestones (**M0**–**M12** plus **M6b** security-program lane) and delivery slices keyed to the reading list; includes full **§ → milestone** mapping, **seed** alignment rules, and **REFERENCE_MAINTENANCE_SOP** obligations |
| [`CRE8_EXPERT_SSOT_BOOT_PROMPT.md`](./CRE8_EXPERT_SSOT_BOOT_PROMPT.md) | Paste-first message for coding LLM sessions (canon-first boot) |
| [`CRE8_PERMISSIONS_AND_DELEGATION_SSOT_SESSION_PROMPT.md`](./CRE8_PERMISSIONS_AND_DELEGATION_SSOT_SESSION_PROMPT.md) | Paste-first **permissions, delegation, and PDP** SSOT session driver: orientation, coordinated doc/contract batches, Phase handoffs; pair with production driver when work spans `docs/` and `src/` |
| [`CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md`](./CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md) | Paste-first **production codebase** session driver: read **`docs/`**/**`seed/`** only, implement under **`src/`**/**`tests/`**, logs under **`dev/implementation/`**, slice batches from the milestones doc |
| **`dev/implementation/`** | Production build continuity: [`LATEST_SESSION_HANDOFF.md`](./implementation/LATEST_SESSION_HANDOFF.md), [`PROGRESS_BOARD.md`](./implementation/PROGRESS_BOARD.md), `session_handoffs/`, `session_responses/` |
| [`DRAFT_KEY_MINTING_PERMISSION_LATTICE.md`](../docs/20_identity_delegation_and_policy/DRAFT_KEY_MINTING_PERMISSION_LATTICE.md) | **Draft** (non-normative): permission templates, minting hierarchy, candidate tokens pending promotion into [`PERMISSION_VOCABULARY.md`](../docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md) |

## Parent references

- Repository root onboarding: [`../README.md`](../README.md)
- Canonical spec hub: [`../docs/README.md`](../docs/README.md)
- Reference maintenance procedures: [`../REFERENCE_MAINTENANCE_SOP.md`](../REFERENCE_MAINTENANCE_SOP.md)
