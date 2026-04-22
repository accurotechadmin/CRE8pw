# Change Control Policy

_Status: adopted_
_Last updated (UTC): 2026-04-22_

## Scope
Applies to all files under `/workspace/CRE8pw/docs/ssot_canon/` plus top-level planning/completion artifacts.

## Change classes
- **Class A (breaking contract):** route/schema/auth/data invariant changes.
- **Class B (behavioral):** acceptance criteria, policy decision, readiness gate changes.
- **Class C (editorial):** wording/formatting without normative impact.
- **Class D (emergency production hotfix):** urgent production defect/security hotfix where immediate mitigation is required before full SSOT synchronization can be completed.

## Approval requirements
- Class A: architecture + security + operations approvers required.
- Class B: relevant domain owner + QA reviewer.
- Class C: single maintainer review.

## Required PR payload
- Change-impact map (template in traceability folder).
- Updated traceability rows.
- Verification evidence for changed behavior.
- Decision log update when rationale changes policy/architecture.


## Class D emergency loop
1. Incident commander + on-call owner declare Class D and open a hotfix PR referencing the incident ticket.
2. Hotfix PR may merge with a temporary waiver of the normal 2-business-day owner review SLA when at least one architecture/security approver signs off and risk notes are captured in the PR.
3. The merge must include a follow-up remediation PR placeholder ID in the description before merge.
4. A remediation PR that restores full SSOT-to-runtime alignment MUST be opened within 24 hours of the hotfix merge timestamp.
5. If remediation PR is not opened within 24 hours, release manager escalates as a policy breach and blocks subsequent non-emergency merges until resolved.
6. Remediation PR must update all impacted SSOT artifacts, traceability rows, and evidence templates.
