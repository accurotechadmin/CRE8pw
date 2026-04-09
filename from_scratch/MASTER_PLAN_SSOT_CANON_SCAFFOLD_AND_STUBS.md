# Master Plan: SSOT Canon Scaffold and Stub Replacement

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Objective
Replace all non-actionable scaffold text with implementation-grade guidance and align every section with machine artifacts and enforceable checks.

## Replacement priorities
1. Governance/index and ownership metadata.
2. Product/architecture/system contracts.
3. Route, authz, and data model contract surfaces.
4. Operations/readiness/verification controls.
5. Program and evidence governance.

## Anti-regression controls
- Lint rule: reject placeholder language in adopted docs.
- Link check: reject unresolved cross-document references.
- Evidence check: PRs touching SSOT must include change-impact map.

## Completion target
Every adopted document must have:
- clear ownership,
- actionable normative section,
- explicit verification mechanism,
- cross-reference integrity.
