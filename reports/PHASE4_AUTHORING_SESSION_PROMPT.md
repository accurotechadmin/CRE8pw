# CRE8 Phase 4 Session Driver Prompt (Reusable Canon Completion Executor)

Use this prompt to start **fresh expert coding LLM sessions** for **CRE8 Phase 4 — Canonical Docs Completion**.

This prompt is designed for repeated copy/paste use so each new session can reliably:
- resume from prior handoff,
- select and complete a small contiguous slice batch,
- run the expected verification discipline,
- and leave deterministic continuity artifacts for the next session.

---

## COPY/PASTE PROMPT START

You are an expert software-engineering LLM session continuing **CRE8 Phase 4 — Canonical Spec Corpus Completion** in this repository.

### Mission
Pick up exactly where the previous session ended and complete a **small contiguous batch (2–5)** unblocked Phase 4 slices from:
- `reports/PHASE4_CANON_COMPLETION_MILESTONES.md`

while preserving strict SSOT consistency, traceability discipline, and continuity handoff quality.

Do **not** attempt full-program completion in one run.

---

## 1) Mandatory boot sequence (read-only first; no edits before completion)
Read in this order. If any file is missing, log that explicitly in handoff artifacts.

1. `README.md`
2. `reports/PHASE4_CANON_COMPLETION_MILESTONES.md` (full read)
3. `reports/PHASE4_AUTHORING_SESSION_PROMPT.md`
4. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` then referenced handoff target
5. `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` (baseline continuity context)
6. Latest 5 handoffs: `reports/session_handoffs/SESSION_HANDOFF_*.md`
7. Latest 3 responses: `reports/session_responses/*_RESPONSE.md`
8. Governance canon:
   - `docs/00_governance/SSOT_INDEX.md`
   - `docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
   - `docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`
   - `docs/00_governance/CHANGE_CONTROL_POLICY.md`
   - `docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md`
   - `docs/00_governance/DEFINITION_OF_DONE.md`
   - `docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md`
9. Canon domains in full (Phase 4 core scope):
   - `docs/10_product_and_architecture/*`
   - `docs/20_identity_delegation_and_policy/*`
   - `docs/30_contracts_and_interfaces/*`
   - `docs/31_machine_contracts/*`
   - `docs/40_data_security_and_crypto/*`
   - `docs/50_content_audience_and_feed/*`
   - `docs/60_operations_quality_and_release/*`
   - `docs/70_extensibility_and_module_patterns/*`
   - `docs/80_traceability_decisions_and_program/*`
   - `docs/evidence/**/*`
10. Seed/source context:
   - `seed/seed-intro.md`
   - `seed/CRE8_SEED_CANON_INDEX.md`
   - `seed/CRE8_SEED_PRESERVATION_MATRIX.md`
   - `seed/CRE8_SEED_CANON_ASSESSMENT_REPORT.md`
11. Tooling anchors:
   - `composer.json`
   - `scripts/` (all `docs_ssot_*`, contract tests, acceptance bundles)

After boot sequence, produce a compact “state snapshot” before making edits.

---

## 2) State snapshot (required before slice selection)
Summarize:
- last completed slices,
- in-progress slices,
- blocked slices and blocker causes,
- open questions/exceptions,
- highest-priority unblocked next slices,
- risk of cross-document drift if delayed.

Then confirm Phase 4 gating model from milestones doc:
- sequence: `M1 -> M2/M3/M4 -> M5/M6/M7 -> M8`
- hard gate constraints must be enforced.

---

## 3) Slice selection policy
- Choose **2–5** slices only.
- Slices must be contiguous in dependency logic and scoped to one coherent lane when possible.
- Prefer earliest unblocked milestone first.
- If a dependency is missing/blocked, create a blocker report and stop execution.
- Record selected slices and dependency checks in handoff *before* editing.

---

## 4) Authoring conventions (strict)
- Use deterministic RFC 2119 modal language (`MUST`, `SHOULD`, `MAY`) consistently.
- Eliminate ambiguous normative prose (actor, trigger, precondition, outcome all explicit).
- No unresolved placeholders in normative sections.
- Preserve/extend cross-links bidirectionally where required.
- Keep requirement identifiers stable; no renames unless explicitly authorized.
- Any requirement-level change must update traceability artifacts in same patch.
- Any contract/schema/prose behavior delta must update parity tables and impact maps.
- Maintain metadata/frontmatter conventions where already required by corpus policy.

---

## 5) Required artifact updates when relevant
If your slices touch these concerns, update corresponding artifacts in the **same session**:
- Traceability and decisions:
  - `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`
  - `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`
  - `docs/80_traceability_decisions_and_program/RISK_REGISTER.md`
  - relevant ADR records or ADR index
- Contract parity:
  - `docs/31_machine_contracts/openapi/cre8.v1.yaml`
  - `docs/31_machine_contracts/schemas/*`
  - `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`
  - `docs/30_contracts_and_interfaces/*`
- Verification/evidence:
  - `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`
  - `docs/evidence/templates/*` (if evidence model changes)
- Change impact map:
  - `reports/change_impact_maps/<UTC>-<slice-or-batch>.md` for machine-contract or behavior-surface changes.

---

## 6) Verification discipline (run before commit)
Run, at minimum, in this order (or document why any command is unavailable):
1. `composer validate --strict`
2. `composer docs:ssot:lint`
3. `composer docs:ssot:sync-check`
4. `composer docs:ssot:report`
5. Relevant `composer docs:ssot:*` checks for touched slices
6. Relevant `composer test:contract:*` suites for touched behavior
7. `composer phase3:acceptance-bundle` (if present)
8. `composer phase2:acceptance-bundle` (fallback baseline if phase3 bundle absent)

If failures occur:
- classify: introduced vs pre-existing vs environment,
- fix introduced failures in-session,
- for unresolved blockers, create blocker report and stop.

---

## 7) Continuity artifacts (mandatory every session)
Always update/create:
- `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`
- `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
- `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` (until dedicated Phase 4 board exists)
- `reports/session_responses/<UTC-YYYYMMDD-HHMM>_RESPONSE.md` (verbatim final response)

If absent, create Phase 4 tracking artifacts:
- `reports/session_handoffs/PHASE4_PROGRESS_BOARD.md`
- `reports/session_handoffs/PHASE4_UNRESOLVED_EXCEPTIONS_REGISTER.md`
- `reports/session_handoffs/PHASE4_OPEN_QUESTIONS.md`

---

## 8) End-of-session response format (exact order)
1. Session summary (selected/completed/partial/blocked slices)
2. Phase gate status (M1..M8 + active dependencies)
3. Verification commands + outcomes
4. Files changed grouped by domain
5. Requirements/hooks/IDs added or updated
6. Traceability/evidence artifacts updated
7. Handoff artifact paths
8. Branch/PR reference
9. Open questions and next ADR suggestions
10. “Next session should start with…” (3–7 prioritized slices + dependencies)

---

## 9) Guardrails
- No out-of-scope edits beyond necessary cross-document closure.
- No TODO/FIXME placeholders in canonical docs.
- No speculative normative additions without verification/evidence mapping.
- No requirement ID churn.
- No silent breaking contract changes.
- No large formatting-only churn.

Begin now: finish boot sequence, produce state snapshot, pick 2–5 slices, execute, verify, and publish continuity artifacts.

## COPY/PASTE PROMPT END
