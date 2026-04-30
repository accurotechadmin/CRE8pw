# Phase 1 Manual Hook Automation Backlog
- Last updated (UTC): 2026-04-30T04:30:00Z
- Owner/session: Phase 3 M0 batch / cursor cloud agent
- Renamed-target note: This backlog is the canonical "manual hook automation backlog" across Phase 1, Phase 2, and Phase 3. The filename retains the historical Phase 1 prefix; rename to `PHASE_MANUAL_HOOK_BACKLOG.md` is scheduled by Phase 3 slice `P3-S2.3`.

## Objective
Track residual manual verification hooks with deterministic automation targets needed to reduce program-wide verification risk.

Gate-critical manual hooks are closed for Phase 1 acceptance scope. The following **non-gate residual manual hooks remain open** and are tracked for automation under Phase 3 milestone M11 (`P3-S11.1`, `P3-S11.2`).

| hook_id | source requirement(s) | owner | priority | current mode | target automation hook | target command/script | notes |
|---|---|---|---|---|---|---|---|
| HOOK-SSOT-LINT-METADATA | CRE8-GOV-REQ-0005 | Program Traceability WG | Medium | manual | HOOK-SSOT-LINT-METADATA | composer docs:ssot:lint | Transition matrix row mode to automated for this requirement binding so verification mode matches implemented command. |
| HOOK-SSOT-PRECEDENCE-CHECK | CRE8-GOV-REQ-0002, CRE8-GOV-REQ-0004 | Docs Governance WG | Medium | manual | HOOK-SSOT-PRECEDENCE-CHECK | composer docs:ssot:precedence-check (planned, P3-S11.2) | Detect explicit contradictions between `README.md` and updated normative docs before merge. |
| HOOK-TRACE-ADR-INDEX-UNIQUE | CRE8-TRACE-REQ-0030, CRE8-TRACE-REQ-0031, CRE8-TRACE-REQ-0032, CRE8-TRACE-REQ-0034 | Architecture Governance WG | Medium | manual | HOOK-TRACE-ADR-INDEX-UNIQUE | composer docs:ssot:adr-index-check (planned, P3-S11.2) | Validate ADR ID uniqueness, format, and ordering in `ADR_INDEX.md`. |
| HOOK-TRACE-ADR-INDEX-STATUS | CRE8-TRACE-REQ-0033 | Architecture Governance WG | Medium | manual | HOOK-TRACE-ADR-INDEX-STATUS | composer docs:ssot:adr-index-check (planned, P3-S11.2) | Validate status taxonomy in `ADR_INDEX.md`. |
| HOOK-TRACE-ADR-INDEX-BACKLINK | CRE8-TRACE-REQ-0036 | Architecture Governance WG | Medium | manual | HOOK-TRACE-ADR-INDEX-BACKLINK | composer docs:ssot:adr-index-check (planned, P3-S11.2) | Validate that every indexed ADR backlinks to at least one requirement or risk. |
| HOOK-TRACE-DECISION-APPENDONLY | CRE8-TRACE-REQ-0040, CRE8-TRACE-REQ-0055 | Architecture Governance WG | High | manual | HOOK-TRACE-DECISION-APPENDONLY | composer docs:ssot:decisions-log-check (planned, P3-S11.2) | Stable hash for historical rows in `DECISIONS_LOG.md`; detect non-tail edits. |
| HOOK-TRACE-DECISION-EVENT-TYPE | CRE8-TRACE-REQ-0041, CRE8-TRACE-REQ-0042, CRE8-TRACE-REQ-0045 | Architecture Governance WG | Medium | manual | HOOK-TRACE-DECISION-EVENT-TYPE | composer docs:ssot:decisions-log-check (planned, P3-S11.2) | Validate event-type taxonomy and required fields per event type. |
| HOOK-TRACE-DECISION-ADR-LINK | CRE8-TRACE-REQ-0035, CRE8-TRACE-REQ-0043 | Architecture Governance WG | Medium | manual | HOOK-TRACE-DECISION-ADR-LINK | composer docs:ssot:decisions-log-check (planned, P3-S11.2) | Validate ADR references resolve and target file exists. |
| HOOK-TRACE-MATRIX-COVERAGE | CRE8-TRACE-REQ-0044, RISK-002 | Program Traceability WG | High | manual | HOOK-TRACE-MATRIX-COVERAGE | composer docs:ssot:matrix-coverage-check (planned, P3-S11.2) | Merge gate requiring traceability row + hook link for every new requirement. |
| HOOK-TRACE-RISK-SCORE | CRE8-TRACE-REQ-0051, CRE8-TRACE-REQ-0052 | Security WG | Medium | manual | HOOK-TRACE-RISK-SCORE | composer docs:ssot:risk-register-check (planned, P3-S11.2) | Validate Likelihood × Impact = Severity Score and severity-class mapping. |
| HOOK-TRACE-RISK-HIGHCRIT-FIELDS | CRE8-TRACE-REQ-0053 | Security WG | High | manual | HOOK-TRACE-RISK-HIGHCRIT-FIELDS | composer docs:ssot:risk-register-check (planned, P3-S11.2) | Validate due date / escalation / verification fields for high and critical RISK rows. |
| HOOK-TRACE-RISK-LINKAGE | CRE8-TRACE-REQ-0050, CRE8-TRACE-REQ-0054 | Security WG | Medium | manual | HOOK-TRACE-RISK-LINKAGE | composer docs:ssot:risk-register-check (planned, P3-S11.2) | Validate requirement IDs and evidence paths resolve. |
