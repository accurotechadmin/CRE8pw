# Reference Maintenance SOP

_Last updated (UTC): 2026-05-05_

## Objective
Define mandatory procedures so every new, moved, renamed, or removed repository file is reflected in all applicable indexes, inventories, and reference documents with accurate links.

## Scope
This SOP governs updates to:
- Root references: `FILE_INVENTORY.md`, `master_index.md`, `README.md`
- Canon indexes/readmes under `docs/`
- Seed indexes under `seed/`
- Report indexes and continuity references under `reports/`
- Any reference/log artifacts that track coverage, parity, traceability, or session continuity

## Governing pattern (inspired by Phase 3/Phase 4 session prompts)
This SOP adopts the same safety pattern used in:
- `reports/PHASE3_AUTHORING_SESSION_PROMPT.md`
- `reports/PHASE4_AUTHORING_SESSION_PROMPT.md`

Key inherited conventions:
1. Mandatory read/scan sequence before edits.
2. Deterministic update order with explicit dependency checks.
3. Continuity artifacts must be updated in the same session as the change.
4. Verification commands must run before completion.
5. Any missing/blocked dependency is logged explicitly.

## Mandatory trigger events
Run this SOP whenever any file is:
- added,
- renamed/moved,
- deleted,
- re-scoped to another directory,
- promoted from draft/reference to canonical status.

## Required update sequence

### Step 1 — Build/refresh complete file inventory
- Update `FILE_INVENTORY.md` first.
- Ensure every repository file (excluding `.git` internals) is represented exactly once.

### Step 2 — Update global operational index
- Update `master_index.md` with:
  - correct location,
  - role/classification,
  - any new sub-component grouping,
  - updated mandatory update chain if process changed.

### Step 3 — Update nearest local index/readme files
For any changed file, update all relevant local references, including but not limited to:
- `docs/README.md`
- `docs/00_governance/SSOT_INDEX.md`
- `seed/seed-index.md`
- `reports/README.md`
- `reports/session_responses/README.md`

### Step 4 — Update continuity, traceability, or parity artifacts (when applicable)
If change impacts behavior/requirements/contracts, update same-session:
- traceability matrix,
- decision log/ADR indexes,
- parity tables,
- change-impact maps,
- session handoff references.

### Step 5 — Link validation and stale-link cleanup
- Remove/replace old paths in all references.
- Verify links resolve to existing files.
- Confirm no orphaned reference entries remain.

## Reference ownership matrix
- **Global inventory owner:** contributor making structural change.
- **Global index owner:** contributor making structural change.
- **Local index owner:** contributor touching that local scope.
- **Continuity artifact owner:** active session contributor before handoff/merge.

No structural change is complete unless all four ownership obligations are satisfied.

## Completion checklist (must pass)
- [ ] `FILE_INVENTORY.md` updated first.
- [ ] `master_index.md` updated with correct granular placement.
- [ ] All impacted local indexes/readmes updated.
- [ ] All stale paths removed/replaced.
- [ ] Relevant continuity/traceability/parity artifacts updated.
- [ ] Verification commands executed and documented.

## Suggested verification commands
- `composer validate --strict`
- `composer docs:ssot:lint`
- `composer docs:ssot:sync-check`
- `composer docs:ssot:report`
- plus any scope-specific `composer docs:ssot:*` or `composer test:contract:*` commands.

## Non-compliance policy
If any trigger event occurs without full SOP completion:
1. mark the change as incomplete,
2. create immediate remediation follow-up in the active handoff/report lane,
3. block final acceptance until references are corrected.

