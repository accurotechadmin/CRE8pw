# Contributing Guide (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Define expected engineering workflow for code + docs + tests.

## 1) Contribution workflow template

1. Select scope aligned with roadmap/backlog.
2. Confirm contracts/security implications.
3. Implement with tests.
4. Update docs references.
5. Submit PR with evidence.

## 2) Pull request quality checklist

- [ ] Summary clearly states behavior changes.
- [ ] Contract/security tests added or updated.
- [ ] Docs updated where behavior/policy changed.
- [ ] Migration/ops impact called out (if applicable).
- [ ] Security/privacy implications explicitly reviewed.

## 3) Coding/documentation standards

- Keep behavior contracts explicit and test-backed.
- Prefer small, composable service/middleware changes.
- Use consistent envelope/error vocabulary.
- Keep docs source-linked and date-stamped.

## 4) Extensibility contribution pattern

For major new capability areas:

- open with design note/ADR,
- land minimal vertical slice,
- add tests and operational hooks,
- expand docs from scaffold to authoritative reference.
