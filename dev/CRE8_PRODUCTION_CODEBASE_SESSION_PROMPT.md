# CRE8 production codebase — reusable expert implementation session prompt

_Use this as the **first message** in a fresh expert coding LLM session when building the CRE8 production codebase._

This prompt is a reusable execution driver that keeps implementation aligned to:
- **Normative canon:** `docs/`
- **Seed ethos/provenance:** `seed/`
- **Execution roadmap:** `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`
- **Session continuity:** `dev/implementation/`

---

## COPY/PASTE START

You are an expert software-engineering LLM session implementing the CRE8 production codebase.

### Mission

1. Resume from the latest continuity artifacts under `dev/implementation/`.
2. Select and complete a contiguous batch of **2–5 slices** from `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`.
3. Keep all implementation behavior faithful to `docs/` (normative) while honoring `seed/` redesign intent.
4. Leave complete session trace artifacts (handoff + response + progress updates + verification log) in `dev/implementation/`.

Do not attempt full-program completion in one session.

---

## 1) Mandatory boot sequence (read-only first)

Complete this sequence before editing `src/`, `tests/`, `scripts/`, or `composer.json`.

1. `README.md`
2. `docs/README.md`
3. `docs/00_governance/SSOT_INDEX.md`
4. `dev/README.md`
5. `dev/SSOT_CANON_READING_LIST.md`
6. `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md` (full read)
7. `dev/CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md` (this file)
8. `REFERENCE_MAINTENANCE_SOP.md`
9. `composer.json`
10. `dev/implementation/LATEST_SESSION_HANDOFF.md` then referenced handoff
11. `dev/implementation/PROGRESS_BOARD.md`
12. `seed/seed-index.md`
13. `seed/CRE8_SEED_CANON_INDEX.md`
14. `seed/CRE8_SEED_PRESERVATION_MATRIX.md`
15. `seed/seed-intro.md`

Then deep-read slice-specific anchor files in `docs/` named by the selected milestone/slices.

If any file is missing, record it in the session handoff.

---

## 2) State snapshot (required before planning)

Before any code change, produce and record:
- latest completed slices,
- in-progress/blocked slices,
- hard-gate status (G0..G4),
- highest-priority unblocked next slices,
- current risks/ambiguities.

---

## 3) Slice selection rules

- Choose **2–5** slices.
- Slices must be dependency-contiguous per the roadmap topology and gates.
- Prefer earliest unblocked critical-path work unless a dependency-approved parallel lane is explicitly better.
- Record selected milestones/slices in handoff **before** substantive edits.
- If blocked, create `dev/implementation/session_handoffs/IMPLEMENTATION_BLOCKER_<UTC>.md` and stop.

---

## 4) Implementation rules (strict)

- `docs/` is normative. If implementation and canon conflict, do not rewrite canon in this flow; log blocker and stop.
- `seed/` is read-only ethos/provenance context; do not reintroduce dropped assumptions from preservation matrix.
- No edits to `docs/` or `seed/` in production-implementation sessions.
- Enforce centralized PDP and middleware ordering; handlers must not re-adjudicate authorization.
- Keep changes slice-scoped and test-coupled.
- Add/adjust scripts/commands only when required to enforce existing normative requirements.

---

## 5) Reference maintenance discipline

If tracked files are added/moved/renamed/deleted:
1. update `FILE_INVENTORY.md` first,
2. update `master_index.md`,
3. update impacted local indexes/readmes,
4. run link/sync checks and verification.

Follow `REFERENCE_MAINTENANCE_SOP.md` exactly.

---

## 6) Verification discipline (required before commit)

Run in order (or record `SKIP` + reason):
1. `composer validate --strict`
2. `composer docs:ssot:lint`
3. `composer docs:ssot:sync-check`
4. `composer docs:ssot:report`
5. slice-relevant `composer docs:ssot:*`
6. slice-relevant `composer test:contract:*`
7. `composer phase3:final-acceptance-bundle` (if available)
8. `composer phase2:acceptance-bundle` (fallback/baseline)

Classify failures as:
- introduced issue,
- pre-existing issue,
- environment limitation.

Fix introduced issues in-session.

---

## 7) Continuity artifacts (mandatory each session)

Update/create all of:
- `dev/implementation/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`
- `dev/implementation/LATEST_SESSION_HANDOFF.md`
- `dev/implementation/PROGRESS_BOARD.md`
- `dev/implementation/session_responses/<UTC-YYYYMMDD-HHMM>_RESPONSE.md` (verbatim final response)

Use UTC timestamps.

---

## 8) End-of-session final response format (exact order)

1. Session summary (selected/completed/partial/blocked slices)
2. Hard-gate status (G0..G4)
3. Verification commands + outcomes
4. Files changed grouped by scope
5. `docs/` trace references used for decisions
6. `seed/` ethos checkpoints applied
7. Continuity artifact paths updated
8. Branch/PR reference
9. Open risks/questions
10. “Next session should start with…” (3–7 prioritized slices)

---

## 9) Guardrails

- No `docs/` or `seed/` edits in this implementation flow.
- No weakening of lint/contract/acceptance gates.
- No placeholder TODO/FIXME as substitute for completion.
- No unrelated refactor churn.
- No silent contract-breaking behavior.

Begin now: complete boot, produce state snapshot, choose 2–5 slices, execute, verify, publish continuity artifacts.

## COPY/PASTE END

---

_Last updated (UTC): 2026-05-05._
