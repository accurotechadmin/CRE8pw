# CRE8 Phase 3 Boot-Up Primer Prompt (Lean Session Starter)

Use this prompt to start a new expert coding LLM session for **CRE8 Phase 3 — Canon Completion**.

This version is intentionally compact: it preserves strict sequencing, traceability, and handoff discipline while reducing cognitive load and repetition.

---

## COPY/PASTE PROMPT START

You are an expert software-engineering LLM session continuing **CRE8 Phase 3 — Canon Completion** in this repository.

### Primary charge
Pick up exactly where the previous development session ended, complete a **small contiguous batch (2–5)** unblocked Phase 3 slices from `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`, and leave the canon in a stronger, more machine-verifiable SSOT state for the next session.

Do **not** attempt full-program completion in one run.

## 1) Boot-up read sequence (mandatory, no edits before this)
Read in this order and log missing files explicitly in handoff:

1. `README.md`
2. `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` (full read; then re-read candidate slice sections)
3. `reports/PHASE3_AUTHORING_SESSION_PROMPT.md`
4. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` then referenced handoff
5. `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`
6. Optional context files if present:
   - `reports/session_handoffs/PHASE3_UNRESOLVED_EXCEPTIONS_REGISTER.md`
   - `reports/session_handoffs/PHASE3_OPEN_QUESTIONS.md`
   - `reports/session_handoffs/PHASE3_OPPORTUNITIES_BACKLOG.md`
7. Latest 3–5 `reports/session_handoffs/SESSION_HANDOFF_*.md`
8. Latest file under `reports/session_responses/` (if folder exists)
9. `reports/PHASE2_PROGRESS_BOARD.md` and `reports/session_handoffs/PHASE2_PROGRESS_BOARD.md`
10. Governance SSOT set:
    - `docs/00_governance/SSOT_INDEX.md`
    - `docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
    - `docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`
    - `docs/00_governance/CHANGE_CONTROL_POLICY.md`
    - `docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md`
    - `docs/00_governance/DEFINITION_OF_DONE.md`
    - `docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md`
11. Traceability + decision set:
    - `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`
    - `docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`
    - `docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`
    - `docs/80_traceability_decisions_and_program/ADR_INDEX.md`
    - `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`
    - `docs/80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md`
    - `docs/80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md` (if present)
12. Verification + contract set:
    - `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`
    - `docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md`
    - `docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md`
    - `docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`
    - `docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`
    - `docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md`
    - `docs/31_machine_contracts/openapi/cre8.v1.yaml`
    - `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`
13. Tooling anchors: `composer.json`, `.github/workflows/ssot_phase_gate.yml`
14. Seed canon in order:
    - `seed/seed-intro.md`
    - `seed/CRE8_SEED_CANON_INDEX.md`
    - `seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`
    - `seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md`
    - `seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`
    - `seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md`
    - `seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md`
    - `seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md`
    - `seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md`
    - `seed/CRE8_SEED_PRESERVATION_MATRIX.md`
    - `seed/CRE8_SEED_CANON_ASSESSMENT_REPORT.md`
    - `seed/CRE8_REPO_STUDY_REPORT.md`
15. For each selected slice, read full `Inputs` + `Dependencies` and dependency output docs before editing.

## 2) State check before planning
- Confirm: **Phase 3 is active**, ADR-003 is closed and cannot be used as generic deferral.
- Summarize from progress board: last completed, in-progress, blocked + blockers, next queued, open exceptions, open questions.
- Verify `composer phase2:acceptance-bundle` baseline expectation; if unknown, run it first.

## 3) Slice selection rules
- Pick **2–5** unblocked slices, contiguous in dependency graph.
- Prefer lowest unblocked milestone in this order: **M0 → M1 (in numeric order) → M2 → M3+**.
- If blocked by unfinished dependency, write `reports/session_handoffs/PHASE3_BLOCKER_<UTC>.md` and stop.
- Record chosen slices + dependency status in handoff before edits.

## 4) Authoring and SSOT conventions
- Follow each slice Deliverables + Exit Criteria exactly.
- Use deterministic normative language (RFC 2119 uppercase).
- Maintain required YAML metadata on touched `docs/*` files.
- Respect ID schemes:
  - `CRE8-<DOMAIN>-REQ-####`
  - `HOOK-<DOMAIN>-<TOPIC>`
  - `ADR-###`, `DLOG-YYYYMMDD-###`, `RISK-###`, `GAP-###`, `P3-EXC-###`
- Every behavior-level MUST/SHOULD maps to enforcing Composer dependency (or explicitly mark N/A).
- Any requirement change must update `TRACEABILITY_MATRIX.md` in same patch.
- New hooks must be registered in verification + automation/lint docs; automated hooks require script + composer entry.
- Machine artifact changes (OpenAPI/JSON Schema/route inventory) require `reports/change_impact_maps/<UTC>-<slice-id>.md`.

## 5) Verification discipline (run before commit)
Run all implemented commands from the program plan in required order, including:
- `composer validate --strict`
- all `composer docs:ssot:*` checks
- all `composer test:contract:*` checks
- `composer phase2:acceptance-bundle`
- any new commands introduced by your slices

If failures occur, classify as introduced/pre-existing/environment; repair introduced issues in-session. If irreparable pre-existing blocker, write blocker report and stop.

## 6) Handoff + continuity artifacts (required)
Always update/create:
- `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`
- `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`
- `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`
- `reports/session_responses/<UTC-YYYYMMDD-HHMM>_RESPONSE.md` (verbatim final response, saved before replying)

Create if needed:
- `reports/session_handoffs/PHASE3_OPEN_QUESTIONS.md`
- `reports/session_handoffs/PHASE3_OPPORTUNITIES_BACKLOG.md`
- ADR + decisions log updates when deferrals/decisions require them.

## 7) End-of-session response format (exact order)
1. Session summary (selected/completed/partial/blocked slices)
2. Verification commands and outcomes
3. Files changed grouped by domain
4. Requirement IDs and Hook IDs added/updated
5. Exact artifact paths updated/created
6. PR URL or branch name
7. Open questions and proposed next ADRs
8. “Next session should start with...” (3–7 prioritized next slices + dependency status)

## 8) Guardrails
- No out-of-scope edits beyond required cross-document updates.
- No TODO markers in normative docs.
- No speculative requirements without hook coverage.
- No requirement ID renames.
- No unrelated formatting churn.
- No reuse of ADR-003 for Phase 3 deferrals.

Begin now: complete boot-up reads, summarize state, propose 2–5 slices, then execute unless truly blocked.

## COPY/PASTE PROMPT END
