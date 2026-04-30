# `docs/evidence/` — CRE8 Verification Evidence

This folder is the canonical home of **verification evidence templates** and **automation linkage** for the CRE8 SSOT corpus. It is a peer of the other `docs/` domain folders; it is owned by Operations Quality WG with reviewers from Program Traceability WG and Docs Governance WG.

Evidence here proves that the verification hooks declared in `../60_operations_quality_and_release/VERIFICATION_STRATEGY.md` were exercised and that the result was deterministic. Evidence is also referenced by every traceability-matrix row that has `verification_mode=automated` or `verification_mode=manual`.

---

## 1. Layout

```text
evidence/
  README.md                           ← this file
  templates/
    README.md                         ← templates index
    FEED_CONTRACT_EVIDENCE_TEMPLATE.md  ← feed contract evidence capture template
  automation/
    README.md                         ← automation evidence index
```

`templates/` holds reusable evidence capture templates. `automation/` holds links and notes about automated evidence pipelines (CI artifacts, generated coverage JSON, machine-contract test outputs).

---

## 2. What evidence MUST contain

Every evidence artifact captured for a CRE8 verification hook MUST include, at minimum:

- **Hook ID** — the `HOOK-...` identifier the artifact proves.
- **Command executed** — the exact `composer ...` or shell command run.
- **Commit SHA** — the repository state under which the command ran.
- **UTC execution timestamp** — `YYYY-MM-DDTHH:MM:SSZ`.
- **Result** — `PASS` or `FAIL`.
- **Artifact pointers** — paths or URLs for logs, snapshots, CI runs, or generated reports.
- **Notes** — deterministic notes only; no speculation.

Any evidence that omits any required field is non-conformant and must not be cited from the traceability matrix.

---

## 3. Where evidence files live

| Class of evidence | Location |
|---|---|
| Reusable templates | `docs/evidence/templates/` |
| Automation metadata and linkage | `docs/evidence/automation/` |
| Latest SSOT coverage report (machine-generated) | `reports/ssot/coverage_latest.json` |
| Per-session command outputs and pass/fail summaries | `reports/session_handoffs/SESSION_HANDOFF_<UTC>.md` |
| Full session response archive | `reports/session_responses/<UTC>_RESPONSE.md` |
| Change Impact Maps for machine-artifact changes | `reports/change_impact_maps/<UTC>-<slice-id>.md` |

---

## 4. Hook-to-evidence mapping (current baseline)

The authoritative mapping is in `../60_operations_quality_and_release/VERIFICATION_STRATEGY.md` and `../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`. Notable bindings today:

- `HOOK-CONTRACT-FEED-ORDER-CURSOR`, `HOOK-CONTRACT-FEED-DENY-CODE-CATALOG`, `HOOK-CONTRACT-FEED-CURSOR-MULTIPAGE-MONOTONIC` → `templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md`.
- `HOOK-SSOT-LINT-METADATA`, `HOOK-SSOT-LINK-INTEGRITY`, `HOOK-SSOT-REPORT-COVERAGE`, etc. → `reports/ssot/coverage_latest.json`.
- Phase 2 acceptance bundle hook (`HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE`) → `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`.
- Phase 3 will introduce additional hooks under milestone M11 (`HOOK-DATA-MODEL-COVERAGE`, `HOOK-SEC-THREAT-CONTROL-MATRIX`, `HOOK-OBS-EVENT-CATALOG-COVERAGE`, `HOOK-CONTRACT-SCHEMA-COVERAGE`, `HOOK-CONTRACT-EXAMPLE-COVERAGE`, `HOOK-OPENAPI-LINT`, `HOOK-GLOSSARY-COMPLETENESS`, `HOOK-SOURCE-REFS-INTEGRITY`, `HOOK-PERMISSION-VOCAB-RESOLVE`, `HOOK-CAPABILITY-MATRIX-COMPLETE`, `HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY`, `HOOK-RELEASE-CHECKLIST-PRESENT`, `HOOK-SLO-SLI-PRESENT`), each with a matching evidence template added to `templates/` in the same slice.

---

## 5. How to add new evidence

When introducing a new hook:

1. Author a new template under `templates/` named `<HOOK-DOMAIN>_EVIDENCE_TEMPLATE.md`. Keep the schema small and machine-parseable.
2. Register the hook in `../60_operations_quality_and_release/VERIFICATION_STRATEGY.md` and (if executable) `../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`.
3. Bind every related requirement in `../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md` to the new hook with an evidence path that points either to the template or to the generated artifact location.
4. Update `../60_operations_quality_and_release/VERIFICATION_STRATEGY.md` Phase 1 / Phase 2 / Phase 3 hook tables.
5. Run the full verification command list (see project root README §14) before commit.

---

## 6. Status under Phase 3

Phase 3 milestone M11 ("Verification, evidence, and final acceptance bundle") is the slice family where the bulk of new evidence templates and the `composer phase3:final-acceptance-bundle` superset are added. Until M11, evidence templates beyond the feed contract template are added on demand alongside the slices that introduce new hooks.

---

## 7. See also

- [Project root README](../../README.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [SSOT Automation and Linting](../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md)
- [Change Impact Map Templates](../80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md)
- [Feed Contract Evidence Template](./templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md)
