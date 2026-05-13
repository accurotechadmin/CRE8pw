# Scope Lock Register

| entry_id | date_utc | artifact | scope_check_type | finding | status | action | refs |
|---|---|---|---|---|---|---|---|
| SLR-2026-05-13-01 | 2026-05-13 | seed-generating-docs startup sequence | ethos_coverage | Selected slices are governance/process-only and do not alter product behavior; all locked ethos domains remain unchanged. | pass | Continue with in-scope documentation normalization. | dev/SEED_GENERATING_MILESTONES_AND_SLICES.md |
| SLR-2026-05-13-02 | 2026-05-13 | seed-generating-docs startup sequence | dependency_baseline_coverage | Selected slices do not add/replace dependency families; locked baseline remains authoritative. | pass | Keep dependency references normalized to locked baseline in future seed updates. | dev/SEED_GENERATING_MILESTONES_AND_SLICES.md |
| SLR-2026-05-13-03 | 2026-05-13 | /fresh export contract | expansion_risk_scan | Pre-existing gap: `/fresh/seed-generating-docs` did not exist before this session. | resolved | Created `/fresh/seed-generating-docs` root subtree for export-ready outputs. | fresh/seed-generating-docs |
