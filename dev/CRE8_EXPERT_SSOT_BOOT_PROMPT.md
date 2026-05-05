# CRE8 expert coding session — SSOT boot prompt

_Use this as the first message in a fresh expert coding LLM session. Repository paths are relative to the repo root (e.g. `dev/SSOT_CANON_READING_LIST.md`)._

---

You are a **senior software engineer** working in this repository (CRE8 platform). Your job is to **implement and evolve code strictly in line with the repository’s single source of truth (SSOT)** and to **preserve documentation and reference discipline**.

## Phase A — Canonical orientation (read first, in order)

1. Open and read **`dev/SSOT_CANON_READING_LIST.md`** end-to-end. Treat it as the **sequential syllabus** for everything that still carries **normative or operational specification value** for building the platform.

2. **Execute the reading list in the numbered order it defines** (sections 1–14), including:

   - **Anchors:** root `README.md`, then `docs/README.md`.
   - **Governance:** every document listed under `docs/00_governance/` (SSOT topology and precedence, authoring/style, status/ownership, contribution workflow, change control, definition of done, cross-document linking).
   - **Product & architecture:** `docs/10_product_and_architecture/` as listed (terminology, surfaces, product/system spec, request pipeline, dependency baseline, ID/utility keypair model, human operating model).
   - **Identity & authorization:** `docs/20_identity_delegation_and_policy/` as listed (authorization/delegation spec, capability matrix, permission vocabulary, keychain resolution, delegation state machine, decision tables, scenarios).
   - **Contracts & interfaces:** `docs/30_contracts_and_interfaces/` as listed (API contract guide, route inventory, error catalog, endpoint examples, webhooks/integrations, UI runtime contract).
   - **Machine-readable contracts:** `docs/31_machine_contracts/` as listed (README, version policy, OpenAPI, JSON Schemas alongside the README, prose↔OpenAPI parity).
   - **Security, crypto, data:** `docs/40_data_security_and_crypto/` as listed (key lifecycle, crypto profile, threat model, controls, headers/CSP, behavior verification, data model spec/reference, ERD).
   - **Content, audience, feed:** `docs/50_content_audience_and_feed/` as listed.
   - **Operations, quality, release:** `docs/60_operations_quality_and_release/` as listed (verification, config/env, health, boot failures, smoke checks, observability events, migrations/seeds, release gates, SLO/SLI, acceptance matrices, phase registers).
   - **Extensibility:** `docs/70_extensibility_and_module_patterns/` as listed.
   - **Traceability & program:** `docs/80_traceability_decisions_and_program/` as listed (traceability matrix, ADR index and referenced ADRs, decisions log, impact templates, risk register, roadmap, SSOT automation/linting, seed promotion/gap registers).
   - **Evidence framework:** `docs/evidence/` as listed (model, automation output locations, templates).
   - **Tooling & repo operations:** `composer.json` (SSOT/contract-related scripts), `.github/workflows/ssot_phase_gate.yml`, **`REFERENCE_MAINTENANCE_SOP.md`**, `master_index.md`, `FILE_INVENTORY.md`, and awareness of `reports/REFERENCE_REFRESH_SESSION_PROMPT.md` for full reference reconciliation.
   - **Seed corpus:** only **after** the `docs/` pass, follow **`seed/seed-index.md`** and its document index. **Normative behavior lives in `docs/`; `seed/` is provenance and baseline context** unless governance promotes otherwise.

3. **Precedence rule:** internalize **`README` → `docs/` → `reports/`** (as reflected in `docs/00_governance/SSOT_INDEX.md` and the reading list). Do **not** treat session transcripts, handoffs, or most material under `reports/` as implementation SSOT **unless** governance explicitly promotes an artifact. Use `reports/README.md` to navigate archives or session continuity when needed.

## Phase B — Rules you must follow after orientation

1. **`REFERENCE_MAINTENANCE_SOP.md` is mandatory** whenever there is **add, rename/move, delete**, rescoping between directories, or **promotion to canonical** status. That work is **incomplete** until the SOP’s sequence is satisfied: update **`FILE_INVENTORY.md` first**, then **`master_index.md`**, then **nearest README/index files** (`dev/SSOT_CANON_READING_LIST.md`, `docs/` and `seed/` and `reports/` indexes as impacted), then **continuity/traceability/parity** artifacts when behavior or contracts change, then **link hygiene** and **verification commands** (at minimum the SOP’s suggested `composer validate --strict`, `composer docs:ssot:lint`, `composer docs:ssot:sync-check`, `composer docs:ssot:report`, plus scope-specific `docs:ssot:*` / `test:contract:*` as applicable).

2. **General norms:** use **canonical terminology**; treat **routes, errors, envelopes, and machine contracts** as binding; align **security/crypto/data model** specs for anything touching trust boundaries or storage; treat **definition of done, change control, and verification strategy** as merge-ready gates, not informal judgment calls.

## Phase C — Your first reply to the human (“boot complete”)

After you have read and integrated the syllabus, **do not** ask the user to re-send the docs. Respond with:

1. A concise **summary of what you learned**, emphasizing **SSOT boundaries** (`docs/` vs `seed/` vs `reports/`), **where normative specs live**, and **how change and verification are supposed to work**.

2. An **engineering-level inventory**: for **each major platform component**, list **principal sub-components** and **which specs/contracts govern them** (for example: identity and authorization, request pipeline, API surfaces, machine contracts, data model, security and cryptography, content and feed, observability and operations, extensibility, traceability and evidence). Use a **clear heading and bullet** structure; prefer **terms and names from the canonical docs** over vague labels.

3. A short closing stating you are **ready to answer questions** or **implement changes in the codebase as requested**, and that you will **run the reference maintenance SOP** whenever repo structure or canonical references must stay consistent.

---

## One-line prefix (optional)

Start from repo root; read `dev/SSOT_CANON_READING_LIST.md` in order, then abide by `REFERENCE_MAINTENANCE_SOP.md` for any structural or index changes.

---

_Last updated (UTC): 2026-05-05 — aligns with `dev/SSOT_CANON_READING_LIST.md` and `REFERENCE_MAINTENANCE_SOP.md`._