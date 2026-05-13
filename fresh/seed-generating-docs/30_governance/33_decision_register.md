# Decision Register

| decision_id | date_utc | context | decision | rationale | impacted_docs | impacted_requirements | conflict_refs | adr_ref | owner | status |
|---|---|---|---|---|---|---|---|---|---|---|
| DEC-001 |  |  |  |  |  |  |  |  |  | proposed\|approved\|retired |
| DEC-002 | 2026-05-13 | Reconcile `/fresh` output contract with required in-place artifact update list during seed-program execution. | Interpret `/fresh` contract as mandatory for net-new authored/generated seed corpus artifacts; continue explicit updates to listed continuity/governance files outside `/fresh` when required by protocol. | Preserves deterministic exportability while avoiding continuity drift in mandated control artifacts. | dev/SEED_GENERATING_MILESTONES_AND_SLICES.md; seed-generating-docs/00_control/04a_conflict_register.md; reports/session_handoffs/LATEST_SESSION_HANDOFF.md | M0 startup sequence; M1/M2/M7 required artifact update rules; scope-lock gate | CONF-002 | none | Seed-generating program operator | approved |
