# Document Status and Ownership

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define owner roles, lifecycle states, and review cadence for each canonical SSOT artifact.

## Scope
All markdown, OpenAPI, and schema artifacts under `/from_scratch/ssot_canon`.

## Normative statements
- Every canonical file MUST have a status line and last-updated date.
- Every canonical file MUST have a primary owner role and at least one backup owner role.
- Status transitions (`draft -> adopted -> deprecated`) MUST be recorded in PR description.
- Security-sensitive docs SHOULD be co-owned by architecture and security leads.

## Interfaces / contracts
| Area | Primary owner role | Backup owner role | Review cadence |
|---|---|---|---|
| Governance | Architecture lead | QA lead | Monthly |
| API/OpenAPI | API contract owner | Backend lead | Per release |
| Security | Security lead | Platform lead | Monthly + incident-triggered |
| Data model | Data owner | Backend lead | Per schema change |
| Operations | SRE/platform lead | Backend lead | Per release |
| Traceability | QA lead | Architecture lead | Weekly drift review |
| ADR/decisions | Architecture lead | Security lead | Per major decision |
| Program management | Product/PM lead | Architecture lead | Bi-weekly |
| Evidence artifacts | QA lead | Platform/SRE lead | Per release |

## Failure/rejection semantics
- Ownerless documents MUST be treated as non-mergeable.
- Stale metadata (>30 days without review on hot contracts) SHOULD trigger warning status.

## Verification requirements
- Docs lint MUST check for status/date/owner table entries.
- Release checklist MUST include owner signoff for modified canon docs.

## Traceability hooks
- Code refs: `docs/SSOT/SSOT_INDEX.md`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php` (automation anchor)
- Related SSOT docs: `SSOT_INDEX.md`, `CHANGE_CONTROL_POLICY.md`, `../40_operations_and_quality/RELEASE_CHECKLIST.md`

## Open questions / known gaps
- Named individuals are intentionally omitted pending team assignment.

## Session progress (2026-04-08)
### Completed in this session
- Finalized mandatory section structure (Purpose, Scope, Normative statements, Interfaces, Failure semantics, Verification, Traceability).
- Confirmed cross-link dependency on canonical terminology and SSOT index.
- Prepared this document for owner assignment and lifecycle-state locking.
### Remaining to finish this document
- [ ] Define and approve owner + reviewer roles with escalation timelines.
- [ ] Attach CI/lint enforcement rules that validate this document's governance constraints.
- [ ] Resolve open questions and promote status from draft to approved.

