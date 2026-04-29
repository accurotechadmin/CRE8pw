---
doc_id: CRE8-TRACE-SSOT-AUTOMATION
version: 1.2.0
status: provisional-normative
owner: Program Traceability WG
reviewers:
  - Docs Governance WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-13
source_seed_refs:
  - seed/CRE8_SEED_CANON_INDEX.md
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/00_governance/DEFINITION_OF_DONE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md
---

# SSOT Automation and Linting

## Purpose
Define the minimum executable automation contract that Phase 1 uses to enforce metadata completeness, link integrity, seed-to-canon mapping consistency, and traceability coverage.

## Normative requirements
- **CRE8-TRACE-REQ-0090**: The repository **MUST** define an executable `docs:ssot:lint` command contract that runs metadata, link, and placeholder-prose checks against all normative docs under `docs/`.
- **CRE8-TRACE-REQ-0091**: `docs:ssot:lint` **MUST** fail when required metadata keys are missing, when any relative markdown link is unresolved, or when prohibited scaffold text patterns are present.
- **CRE8-TRACE-REQ-0092**: The repository **MUST** define an executable `docs:ssot:sync-check` command contract that validates `SEED_PROMOTION_TRACKER.md` rows against promoted requirement IDs and `TRACEABILITY_MATRIX.md` presence.
- **CRE8-TRACE-REQ-0093**: `docs:ssot:sync-check` **MUST** fail if a row in `SEED_PROMOTION_TRACKER.md` has `promotion_status=promoted` and either `target_requirement_id` is missing in the target source doc or no matching `requirement_id` row exists in `TRACEABILITY_MATRIX.md`.
- **CRE8-TRACE-REQ-0094**: The repository **MUST** define a `docs:ssot:report` command contract that emits a machine-readable coverage summary containing, at minimum, total normative requirements, traced requirements, untraced requirements, and manual-only verification hooks.
- **CRE8-TRACE-REQ-0095**: Each automation command contract **MUST** declare deterministic exit semantics (`0=pass`, non-zero `=fail`) and **MUST** include reproducible local invocation instructions.
- **CRE8-TRACE-REQ-0096**: For each hook listed in this document, `TRACEABILITY_MATRIX.md` **MUST** reflect the current verification mode (`automated` when implemented; `manual` only when automation is unavailable) with an explicit next automation action in `notes` for manual rows.
- **CRE8-TRACE-REQ-0097**: Any PR that changes normative requirements **MUST** include evidence of running all currently-available `docs:ssot:*` commands and **MUST** document missing-automation gaps in the session handoff.
- **CRE8-TRACE-REQ-0098**: The repository **MUST** provide a CI workflow group named `ssot_phase1_gate` that hard-fails on non-zero exit from `docs:ssot:lint`, `docs:ssot:sync-check`, or `docs:ssot:report`.

## Command contracts (Phase 1 minimum)
| Command | Required checks | Output contract | Owner |
|---|---|---|---|
| `docs:ssot:lint` | Metadata key completeness; link integrity; scaffold/prohibited phrase detection. | Line-oriented failures with file path + requirement/hook context. | Docs Governance WG |
| `docs:ssot:sync-check` | Promotion tracker schema; promoted-row target existence; promoted-row traceability row existence. | Summary counts and explicit failing row IDs. | Program Traceability WG |
| `docs:ssot:report` | Trace coverage summary; manual vs automated hook split; missing evidence path summary. | JSON artifact at `reports/ssot/coverage_latest.json`. | Program Traceability WG |
| `docs:ssot:route-parity` | Route inventory method/path parity with OpenAPI operations. | Line-oriented drift failures and deterministic pass summary. | API Contracts WG |
| `docs:ssot:route-uniqueness` | Duplicate `route_id` and method/path detection in route inventory. | Duplicate failures with deterministic pass summary. | API Contracts WG |
| `docs:ssot:compat-declaration` | Presence checks for required compatibility/migration/deprecation clauses in API guide. | Missing-clause failures and deterministic pass summary. | API Contracts WG |
| `docs:ssot:error-code-coverage` | Route inventory `error_code_set` coverage against canonical error catalog code table. | Undocumented-code failures and deterministic pass summary. | API Contracts WG |
| `docs:ssot:deprecation-schema` | Route inventory deprecation schema checks (`sunset_utc` and `replacement_route_id` completeness + format). | Missing-field/format failures and deterministic pass summary. | API Contracts WG |
| `test:contract:error` | Error determinism checks for route-declared error codes and canonical 4xx/5xx status mapping. | Hook-tagged failures and deterministic pass summary. | API Contracts WG |
| `test:contract:auth-reasons` | Authorization decision reason-code mapping coverage against error catalog entries. | Missing-mapping failures and deterministic pass summary. | Identity & Policy WG |
| `ssot_phase1_gate` (CI) | Execute `docs:ssot:lint`, `docs:ssot:sync-check`, `docs:ssot:report` as merge-blocking checks. | Workflow status in CI provider; non-zero command exit fails gate. | Program Traceability WG |

## Hook registry
- **HOOK-SSOT-LINT-METADATA**: Validate metadata headers and required keys.
- **HOOK-SSOT-LINK-INTEGRITY**: Validate markdown links and anti-orphan constraints.
- **HOOK-SSOT-LINT-SCAFFOLD-TEXT**: Validate prohibited placeholder prose patterns are absent in normative docs.
- **HOOK-SSOT-SYNC-PROMOTED-TARGET**: Validate each promoted seed row maps to an existing target requirement in target doc.
- **HOOK-SSOT-SYNC-PROMOTED-TRACE**: Validate each promoted seed row maps to an existing traceability matrix row.
- **HOOK-SSOT-REPORT-COVERAGE**: Compute and publish requirement/hook coverage summary.

## Manual verification procedure (until automation exists)
1. Run `rg "^doc_id:|^version:|^status:|^owner:|^reviewers:|^last_reviewed_utc:|^next_review_due_utc:|^source_seed_refs:|^normative_dependencies:" docs` and verify each normative file has all required keys.
2. Run `rg "This scaffold file defines|structured placeholder" docs` and confirm no normative doc contains scaffold placeholder phrases.
3. For each `promotion_status=promoted` row, confirm target requirement ID existence in target doc and matching row in `TRACEABILITY_MATRIX.md`.
4. Record findings in session handoff with pass/fail and unresolved automation gaps.

## Drift policy
- Missing command implementations are permitted during Phase 1 only when manual verification evidence is included in the same PR and backlog entry remains open in `PHASE1_PROGRESS_BOARD.md`.
- Once a command is implemented, manual fallback **SHOULD** be retained only as contingency guidance for environment failures.

## See also
- [SSOT Index](../00_governance/SSOT_INDEX.md)
- [Definition of Done](../00_governance/DEFINITION_OF_DONE.md)
- [Traceability Matrix](./TRACEABILITY_MATRIX.md)
- [Seed Promotion Tracker](./SEED_PROMOTION_TRACKER.md)
- [Unresolved Seed Gap Register](./UNRESOLVED_SEED_GAP_REGISTER.md)
