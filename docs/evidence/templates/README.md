# `docs/evidence/templates/` — Evidence Capture Templates

Reusable templates that authoring sessions and CI pipelines fill in to produce machine-parseable verification evidence for CRE8 hooks.

A template defines the minimum required fields for evidence of a particular hook family. Filled-in evidence MUST cite the template it conforms to.

## Current templates

| Template | Hook(s) it serves | Owner |
|---|---|---|
| [`FEED_CONTRACT_EVIDENCE_TEMPLATE.md`](./FEED_CONTRACT_EVIDENCE_TEMPLATE.md) | `HOOK-CONTRACT-FEED-ORDER-CURSOR`, `HOOK-CONTRACT-FEED-DENY-CODE-CATALOG`, `HOOK-CONTRACT-FEED-CURSOR-MULTIPAGE-MONOTONIC` | API Contracts WG |
| [`DATA_MODEL_EVIDENCE_TEMPLATE.md`](./DATA_MODEL_EVIDENCE_TEMPLATE.md) | `HOOK-DATA-MODEL-COVERAGE` | Security WG |
| [`SECURITY_THREAT_CONTROL_EVIDENCE_TEMPLATE.md`](./SECURITY_THREAT_CONTROL_EVIDENCE_TEMPLATE.md) | `HOOK-SEC-THREAT-CONTROL-MATRIX` | Security WG |
| [`EVENT_CATALOG_EVIDENCE_TEMPLATE.md`](./EVENT_CATALOG_EVIDENCE_TEMPLATE.md) | `HOOK-OBS-EVENT-CATALOG-COVERAGE` | Operations Quality WG |
| [`CONTRACT_SCHEMA_EXAMPLE_EVIDENCE_TEMPLATE.md`](./CONTRACT_SCHEMA_EXAMPLE_EVIDENCE_TEMPLATE.md) | `HOOK-CONTRACT-SCHEMA-COVERAGE`, `HOOK-CONTRACT-EXAMPLE-COVERAGE`, `HOOK-OPENAPI-LINT` | API Contracts WG |
| [`IDENTITY_POLICY_EVIDENCE_TEMPLATE.md`](./IDENTITY_POLICY_EVIDENCE_TEMPLATE.md) | `HOOK-PERMISSION-VOCAB-RESOLVE`, `HOOK-CAPABILITY-MATRIX-COMPLETE`, `HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY` | Identity & Policy WG |
| [`RELEASE_GATES_EVIDENCE_TEMPLATE.md`](./RELEASE_GATES_EVIDENCE_TEMPLATE.md) | `HOOK-RELEASE-CHECKLIST-PRESENT`, `HOOK-SLO-SLI-PRESENT` | Operations Quality WG |

## Required template structure

Every template added to this folder MUST include:

1. **YAML frontmatter** with `doc_id`, `version`, `status`, `owner`, `reviewers`, `last_reviewed_utc`, `next_review_due_utc`, `source_seed_refs`, `normative_dependencies`.
2. **Purpose** — one paragraph; binds the template to one or more hook IDs.
3. **Required evidence fields** — at minimum: hook ID, command executed, commit SHA, UTC execution timestamp, result (PASS/FAIL), artifact pointers, notes.
4. **Hook checklist** — a checkbox list of every hook the template covers.
5. **Execution record template** — a fenced block illustrating the canonical capture format for the hook(s).

## Adding a new template

When a new hook is introduced under Phase 3 (typically milestone M11) or any subsequent milestone:

1. Author the template here as `<HOOK-DOMAIN>_EVIDENCE_TEMPLATE.md`.
2. Add a row in this README's "Current templates" table.
3. Register the hook in `../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md` and (if executable) `../../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`.
4. Bind every related requirement in `../../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md` to the new hook and to the template path under the `evidence_location` column.
5. Run the full verification command list before commit.

## See also

- [Evidence folder README](../README.md)
- [Verification Strategy](../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Traceability Matrix](../../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Project root README](../../../README.md)
