# Document Status and Ownership

_Status: adopted_
_Last updated (UTC): 2026-04-09_

## Status model
- `adopted`: normative and release-governing.
- `deprecated`: retained for history; not authoritative.
- `superseded`: replaced by a newer authoritative artifact; retained for audit trace only.

## Ownership matrix
| Document family | Primary owner | Required co-reviewers | Verification accountability |
|---|---|---|---|
| Governance + decisions | Architecture lead | Platform lead | Cross-reference and precedence integrity |
| Product + contracts | Backend/API lead | QA lead | Route and envelope contract parity |
| Data + security | Security lead | Backend lead | Policy invariants and abuse-case coverage |
| Operations + quality | Platform/SRE lead | QA lead | Smoke/readiness/SLO evidence integrity |
| Program management | Eng manager/program owner | Architecture lead | Workflow and release-governance completeness |

## Ownership obligations
- Keep references current and lint-clean.
- Ensure verification commands remain executable and evidence-producing.
- Reject ambiguous normative language.
- Review metadata (`Status`, `Last updated`) on every modified adopted file.
- Escalate unresolved cross-domain conflicts to architecture owner before merge.

## Review SLA
- Standard SSOT change: owner response within 2 business days.
- Security-impacting change: security owner triage within 1 business day.
- Release-blocking change: same-day owner acknowledgment.
