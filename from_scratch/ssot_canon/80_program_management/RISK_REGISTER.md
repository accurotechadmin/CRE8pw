# Risk Register

_Status: adopted_
_Last updated (UTC): 2026-04-09_

## Active risks
| Risk ID | Description | Likelihood | Impact | Mitigation | Owner | Trigger signal |
|---|---|---:|---:|---|---|---|
| R-001 | Cross-doc reference drift causes implementation ambiguity | Med | High | Reference lint + PR checklist + weekly audit | Architecture lead | Lint failures or broken artifact references |
| R-002 | Authorization rule drift between code and decision tables | Low | High | Contract/security regression suite + traceability checks | Security lead | Authz test regressions or policy mismatch incidents |
| R-003 | Keychain complexity introduces edge-case defects | Med | High | Invariant-focused tests + staged rollout + audit events | Backend lead | Increased keychain lifecycle/membership failure rate |
| R-004 | Operational blind spots during incident conditions | Med | Med | Enforce observability catalog and smoke evidence | Platform/SRE lead | Missing request correlation during incidents |
| R-005 | SSOT automation parity drift from runtime tooling | Med | Med | Maintain docs:ssot scripts + CI gate + monthly command rehearsal | Platform/SRE lead | Docs command failures or script removal |

## Review cadence
- Re-evaluate risk ratings each release cycle and after any incident.
- Re-score risks when likelihood/impact assumptions change materially.
- Add mitigations to release evidence for any risk currently High impact.
