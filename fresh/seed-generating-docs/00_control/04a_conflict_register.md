# Conflict Register

| conflict_id | source_a | source_b | conflicting_statements | proposed_interpretation | confidence | human_review_required | status | decision_ref | notes |
|---|---|---|---|---|---|---|---|---|---|
| CONF-001 |  |  |  |  | low\|medium\|high | yes\|no | open\|in_review\|resolved\|deferred |  |  |
| CONF-002 | dev/SEED_GENERATING_MILESTONES_AND_SLICES.md (`/fresh` output contract) | Required artifact list in reusable session prompt block (paths under `seed-generating-docs/...`) | Session protocol mandates `/fresh` for all newly authored/generated docs, while required artifact paths are listed in non-`/fresh` form. | Treat non-`/fresh` required artifact list as legacy/in-place governance continuity artifacts, while creating net-new authored/generated seed corpus docs under `/fresh/seed-generating-docs/...`. | high | no | resolved | DEC-002 | Resolution is consistent with “legacy in-place governance/continuity artifacts may still be updated when explicitly required” in milestones doc. |
