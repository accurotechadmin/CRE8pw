# Production Readiness Gates

_Last updated (UTC): 2026-04-06_

## Gate A: Build/runtime integrity
- Dependencies installable in CI/CD.
- App boots with no startup exceptions.
- `/health` returns subsystem pass.

## Gate B: Contract/security quality
- Contract tests pass.
- Security tests pass.
- No undocumented API or envelope changes.

## Gate C: UX parity
- All declared endpoint/UI mappings implemented.
- Error-state mappings validated for 401/403/404/422/429/5xx.

## Gate D: Operational readiness
- Rollback rehearse completed.
- Key rotation playbook rehearsed.
- Incident response contacts and escalation matrix confirmed.

## Gate E: Documentation integrity
- SSOT docs updated in same release PR.
- Traceability matrix updated.
- Release checklist fully signed.
