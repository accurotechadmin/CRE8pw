# Risk Register

_Status: adopted_
_Last updated (UTC): 2026-04-22_

## Active risks
| Risk ID | Description | Likelihood | Impact | Mitigation | Owner | Trigger signal |
|---|---|---:|---:|---|---|---|
| R-001 | Cross-doc reference drift causes implementation ambiguity | Med | High | Reference lint + PR checklist + weekly audit | Architecture lead | Lint failures or broken artifact references |
| R-002 | Authorization rule drift between code and decision tables | Low | High | Contract/security regression suite + traceability checks | Security lead | Authz test regressions or policy mismatch incidents |
| R-003 | Keychain complexity introduces edge-case defects | Med | High | Invariant-focused tests + staged rollout + audit events | Backend lead | Increased keychain lifecycle/membership failure rate |
| R-004 | Operational blind spots during incident conditions | Med | Med | Enforce observability catalog and smoke evidence | Platform/SRE lead | Missing request correlation during incidents |
| R-005 | Documentation parity drift from runtime tooling | Med | Med | Maintain route/contract evidence reviews + optional automation checks + monthly command rehearsal | Platform/SRE lead | Evidence gaps or contract mismatch incidents |
| R-006 | Key hierarchy scaling assumptions become stale | Med | High | Execute `TASK-KEY-HIERARCHY-001` and track outcomes in roadmap and traceability updates | Security + Backend leads | Hierarchy incident pattern or unresolved analysis actions |
| R-007 | Key-type specification coherence drift | Med | Med | Execute `TASK-KEY-SPEC-002` and enforce per-key-type coverage in release evidence | Security lead | Ambiguous key policy behavior during review/testing |

## Review cadence
- Re-evaluate risk ratings each release cycle and after any incident.
- Re-score risks when likelihood/impact assumptions change materially.
- Add mitigations to release evidence for any risk currently High impact.
