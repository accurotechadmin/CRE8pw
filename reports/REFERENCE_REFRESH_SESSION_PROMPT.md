# Repository Reference Refresh Session Prompt (Reusable)

Use this prompt to launch a fresh LLM session that performs a full reference drift audit and updates repository reference artifacts to match the current filesystem and documentation state.

---

## COPY/PASTE PROMPT START

You are an expert repository-maintenance LLM session operating in this repo.

### Mission
Run a **full repository reference reconciliation** by comparing the **current repository state** against the **last recorded reference state**, detecting all changes, and updating every required index/inventory/reference artifact so documentation remains complete, accurate, and link-valid.

You MUST follow `REFERENCE_MAINTENANCE_SOP.md` as the governing procedure.

---

## 1) Mandatory boot sequence (read-only first)
Do not edit anything until this read sequence is complete:

1. `REFERENCE_MAINTENANCE_SOP.md` (authoritative process)
2. `FILE_INVENTORY.md` (last recorded inventory baseline)
3. `master_index.md` (global navigation baseline)
4. `README.md` (repo entry context)
5. `dev/SSOT_CANON_READING_LIST.md` (developer sequential SSOT path)
6. `docs/README.md`
7. `docs/00_governance/SSOT_INDEX.md`
8. `seed/seed-index.md`
9. `reports/README.md`
10. `reports/session_responses/README.md`
11. `reports/PHASE3_AUTHORING_SESSION_PROMPT.md`
12. `reports/PHASE4_AUTHORING_SESSION_PROMPT.md`

If any file is missing, log it explicitly in your final report.

---

## 2) Build “current state” snapshot
Create a deterministic snapshot of all tracked repository files (exclude `.git` internals). Then derive:
- total file count,
- file list by top-level scope,
- list of all files that are reference/index/inventory/readme style assets.

Treat this snapshot as the source of truth for this session.

---

## 3) Build “last recorded state” snapshot
From existing reference docs, capture the previous baseline:
- inventory timestamp/count/path list from `FILE_INVENTORY.md`,
- structural coverage claims in `master_index.md`,
- local index coverage from scope readmes/indexes.

---

## 4) Drift detection (current vs last recorded)
Compute and report all categories:
1. **Added files** not represented in prior references.
2. **Removed/missing files** still referenced by old docs.
3. **Moved/renamed files** with stale path references.
4. **Scope/classification drift** (file exists but listed in wrong section).
5. **Orphan files** not linked by any suitable parent reference/index.
6. **Broken internal links** in reference surfaces.

Your drift report must include exact file paths and impacted reference docs.

---

## 5) Required update execution order (SOP-enforced)
Apply updates in this exact order:
1. `FILE_INVENTORY.md` (full refresh first)
2. `master_index.md` (global placement + update-chain consistency)
3. all impacted local reference docs/readmes/indexes
4. continuity/traceability/parity artifacts (if impacted)

Do not skip downstream reference updates once drift is detected.

---

## 6) Quality standards for edits
- Keep changes tightly scoped to reference accuracy and navigability.
- Preserve established naming and structural conventions.
- Ensure each new file is discoverable from at least one parent index/readme.
- Remove stale references to deleted/renamed files.
- No placeholder TODO/FIXME entries.
- No speculative content unrelated to observed repository state.

---

## 7) Verification discipline (required)
Run and report at minimum:
1. inventory generation/check command(s)
2. link/path consistency checks used in-session
3. `composer validate --strict` (if available)
4. `composer docs:ssot:lint` (if available)
5. `composer docs:ssot:sync-check` (if available)
6. `composer docs:ssot:report` (if available)

If any command is unavailable or fails due to environment constraints, classify clearly as:
- introduced issue,
- pre-existing issue,
- environment limitation.

---

## 8) Deliverables (mandatory)
Before ending, ensure these are updated/created as applicable:
- `FILE_INVENTORY.md`
- `master_index.md`
- all impacted local indexes/readmes/reference docs
- a concise drift summary section in final response

If no drift is found, still report evidence and verification results.

---

## 9) Final response format (exact order)
1. Boot sequence completion summary
2. Current-state vs last-recorded drift summary
3. Files updated (grouped by scope)
4. Verification commands + outcomes
5. Residual risks or follow-up items
6. “Next refresh session should start with…” (short checklist)

Begin now: execute boot reads, build both snapshots, detect drift, apply SOP-ordered updates, verify, and report.

## COPY/PASTE PROMPT END
