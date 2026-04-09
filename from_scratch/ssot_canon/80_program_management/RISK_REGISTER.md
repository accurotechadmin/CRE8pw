# Risk Register

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Active risks
| Risk ID | Description | Likelihood | Impact | Mitigation | Owner |
|---|---|---:|---:|---|---|
| R-001 | Cross-doc reference drift causes implementation ambiguity | Med | High | Reference lint + PR checklist + weekly audit | Architecture lead |
| R-002 | Authorization rule drift between code and decision tables | Low | High | Contract/security regression suite + traceability checks | Security lead |
| R-003 | Keychain complexity introduces edge-case defects | Med | High | Invariant-focused tests + staged rollout + audit events | Backend lead |
| R-004 | Operational blind spots during incident conditions | Med | Med | Enforce observability catalog and smoke evidence | Platform/SRE lead |

## Review cadence
Re-evaluate risk ratings each release cycle and after any incident.
