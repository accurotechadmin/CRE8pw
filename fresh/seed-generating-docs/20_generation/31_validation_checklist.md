# Validation and Completeness Checklist

- [ ] Every source document listed in inventory.
- [ ] Every source reviewed and status-classified.
- [ ] Every major source section mapped in preservation ledger.
- [ ] Canonical vocabulary applied consistently.
- [ ] Legacy terms removed or justified in register.
- [ ] Every conflict resolved or registered.
- [ ] Every final doc matches blueprint template.
- [ ] Every final doc has clear purpose and audience.
- [ ] No unexplained legacy language remains.
- [ ] Any TBD item appears in open questions register.
- [ ] Cross-domain alignment: product, architecture, data, API, UI, implementation, testing, security, operations.
- [ ] Output is implementation-ready for production code guidance.


## Slice scorecard template (mandatory per selected slice)

- preservation_gate: pass|partial|fail
- conflict_gate: pass|partial|fail
- consistency_gate: pass|partial|fail
- generation_gate: pass|partial|fail
- implementation_relevance_gate: pass|partial|fail
- scope_lock_gate: pass|partial|fail

A slice may be marked `done` only when all gates are `pass`, or an explicit waiver is recorded in governance artifacts.

## Deterministic generation closure checks (M6/S6.4-S6.5)

- [ ] Every generated document satisfies minimum section threshold: Purpose, Audience, Normative anchors, Source traceability, Conflict/decision status, Implementation implications.
- [ ] Every generated document includes at least one trace-linked source reference for each applicable major concept.
- [ ] Rerun with unchanged inputs produces stable heading/section ordering and traceability references.
- [ ] Any rerun differences are explicitly classified (source_change, conflict_disposition_change, decision_change, bugfix) and logged.
