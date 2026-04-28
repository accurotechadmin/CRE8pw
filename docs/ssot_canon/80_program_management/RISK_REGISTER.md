# Risk Register

_Status: adopted_
_Last updated (UTC): 2026-04-28_

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
| R-008 | PDP migration introduces deny/allow drift versus canonical authorization decision tables during mixed-mode rollout. | Med | High | Enforce UA shadow-mode decision comparison, run contract/security regression suites per rollout stage, and block enforcement expansion on unresolved drift deltas. | Security lead | Shadow-mode mismatch rate above release threshold or unresolved UA regression defects |
| R-009 | Gateway/console boundary drift allows auth-context interchangeability during BFF surface split. | Low | High | Enforce per-surface non-interchangeability smoke tests, token-type/audience confusion regression suite, and release-gate signoff on boundary evidence. | Security + Platform/SRE leads | Any successful cross-surface token replay or boundary smoke failure |
| R-010 | CQRS-lite projection freshness/consistency defects expose stale authorization or content state to runtime decisions. | Med | High | Enforce sync-first projection default, projector idempotency/replay tests, projection lag health checks, and staged async rollout with rollback guardrails. | Backend + Platform/SRE leads | Projection lag threshold breach, replay/idempotency failure, or stale-read incident |

## Review cadence
- Re-evaluate risk ratings each release cycle and after any incident.
- Re-score risks when likelihood/impact assumptions change materially.
- Add mitigations to release evidence for any risk currently High impact.
