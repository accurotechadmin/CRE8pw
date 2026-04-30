# `docs/evidence/automation/` — Automation Evidence Linkage

This folder records **how automated verification produces evidence** in the CRE8 SSOT corpus: which scripts run, where their outputs land, and how those outputs flow back into the traceability matrix and acceptance bundles.

The folder itself is intentionally light. It is the index that points to authoritative scripts, generated artifacts, and CI surface; the generated artifacts themselves live elsewhere by policy (see `../README.md` §3).

## Where automation lives

| Concern | Location |
|---|---|
| SSOT lint, sync, report, parity, uniqueness, compat-declaration, error-code coverage, deprecation schema, review-gate, DoD-trace, roadmap-schema, seed-promotion, seed-gap, Phase 2 exceptions, PR evidence | `../../../scripts/docs_ssot_*.php` |
| Contract test runners | `../../../scripts/test_contract_*.php` |
| Phase acceptance bundles | `../../../scripts/phase1_acceptance_bundle.php`, `../../../scripts/phase2_acceptance_bundle.php` (Phase 3 superset under milestone M11) |
| CI gate | `../../../.github/workflows/ssot_phase_gate.yml` |
| Generated coverage report | `../../../reports/ssot/coverage_latest.json` |
| Per-session command outputs | `../../../reports/session_handoffs/SESSION_HANDOFF_<UTC>.md` |
| Full session response archive | `../../../reports/session_responses/<UTC>_RESPONSE.md` |

## Composer script catalog (current)

The canonical script catalog is `composer.json` `scripts:` section. Highlights in current use:

- `composer docs:ssot:lint`
- `composer docs:ssot:sync-check`
- `composer docs:ssot:report`
- `composer docs:ssot:route-parity`
- `composer docs:ssot:route-uniqueness`
- `composer docs:ssot:compat-declaration`
- `composer docs:ssot:error-code-coverage`
- `composer docs:ssot:deprecation-schema`
- `composer docs:ssot:review-gate-check`
- `composer docs:ssot:dod-trace-check`
- `composer docs:ssot:roadmap-schema-check`
- `composer docs:ssot:seed-promotion-schema`
- `composer docs:ssot:seed-gap-schema`
- `composer docs:ssot:phase2-exceptions-check`
- `composer docs:ssot:pr-evidence-check`
- `composer test:contract:auth`
- `composer test:contract:auth-reasons`
- `composer test:contract:error`
- `composer test:contract:error-secrets`
- `composer test:contract:feed`
- `composer test:contract:identity-issuance`
- `composer test:contract:identity-context`
- `composer test:contract:lifecycle`
- `composer test:contract:surface-parity`
- `composer phase1:acceptance-bundle`
- `composer phase2:acceptance-bundle`

Phase 3 milestone M11 introduces additional scripts (for example `composer docs:ssot:openapi-lint`, `composer docs:ssot:schema-coverage`, `composer docs:ssot:example-coverage`, `composer docs:ssot:glossary-check`, `composer docs:ssot:source-refs-check`, `composer test:contract:request-schema`, `composer test:contract:response-schema`, `composer phase3:final-acceptance-bundle`). Each is registered in `../../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md` when added.

## How automation produces evidence

1. Author writes or modifies a normative document (or a machine artifact, or a script).
2. CI workflow `ssot_phase_gate.yml` runs the full SSOT lint/sync/report family plus the current acceptance bundle.
3. `composer docs:ssot:report` emits `reports/ssot/coverage_latest.json` with `total_normative_requirements`, `traced_requirements`, `untraced_requirements`, `manual_only_verification_hooks` counts.
4. The session captures command outputs (verbatim PASS/FAIL summaries) in `reports/session_handoffs/SESSION_HANDOFF_<UTC>.md` and archives the full response in `reports/session_responses/<UTC>_RESPONSE.md`.
5. The traceability matrix evidence-location columns point at these artifacts.

## Status under Phase 3

Phase 3 milestone M11 is the slice family that completes automation depth: it adds new hooks, scripts, evidence templates, and `composer phase3:final-acceptance-bundle`. Until M11, automation evidence stays at the Phase 2 baseline plus any incremental hooks added by intervening slices.

## See also

- [Evidence folder README](../README.md)
- [Verification Strategy](../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [SSOT Automation and Linting](../../80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md)
- [Traceability Matrix](../../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Project root README](../../../README.md)
