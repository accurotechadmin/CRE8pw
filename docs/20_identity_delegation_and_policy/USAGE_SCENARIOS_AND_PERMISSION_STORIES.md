---
doc_id: CRE8-IDPOL-USAGE-SCENARIOS
version: 1.0.0
status: normative
owner: Identity & Policy WG
reviewers:
  - API Contracts WG
  - Security WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - slim/slim
  - slim/psr7
  - php-di/php-di
  - firebase/php-jwt
  - ext-sodium
  - ext-pdo
  - phpunit/phpunit
---

# Usage Scenarios And Permission Stories

## Purpose

This document defines deterministic end-to-end authorization and lifecycle stories. PDP evaluation MUST execute the 7-gate sequence from [`AUTHORIZATION_AND_DELEGATION_SPEC.md`](AUTHORIZATION_AND_DELEGATION_SPEC.md) and handlers MUST NOT remap authorization outcomes (`slim/slim`, `php-di/php-di`).

## Scenario contract format

Each scenario MUST define precondition, request, gate path (1..7), expected outcome, and expected success/error envelope (`slim/psr7`). Fixtures MUST remain executable through `composer test:contract:auth` or `composer test:contract:lifecycle` (`phpunit/phpunit`).

## Canonical scenarios

| Scenario ID | Scenario | Preconditions | Request fixture/evidence | Gate path | Expected outcome | Expected envelope/code |
|---|---|---|---|---|---|---|
| SCN-001 | Owner mints Primary Author with bounded delegation | Owner active; delegation depth budget >=1 | `req-ident-issue-rt-001` | 1->2->3->4->5->6->7 | ALLOW | success `{data,meta}` |
| SCN-002 | Primary Author mints Use Key under Utility context | Primary active; utility context unique | `req-ident-ctx-rt-001` | 1->2->3->4->5->6->7 | ALLOW | success `{data,meta}` |
| SCN-003 | Use Key reads feed within audience group | Use principal active; group visibility includes principal | `req-feed-001` | 1->2->3->4->5->6->7 | ALLOW | success `{data,meta}` |
| SCN-004 | Use Key comment.create on non-eligible group | Group policy deny for actor | `AuthDecisionRequestCommentCreate` + `req-interact-001` | 1->2->3->4->5->6 | DENY | `AUTH_SCOPE_DENIED` or `AUTH_LIFECYCLE_BLOCKED` |
| SCN-005 | Suspend cascade blocks descendants | Ancestor transitioned to suspended | `ErrorDescendantLifecycleBlockedSecondary` (`req-desc-life-002`) | 1->2->3 | DENY | `AUTH_LIFECYCLE_BLOCKED` |
| SCN-006 | Revoke cascade blocks descendants | Ancestor transitioned to revoked | `ErrorDescendantLifecycleBlocked` (`req-desc-life-001`) | 1->2->3 | DENY | `AUTH_LIFECYCLE_BLOCKED` |
| SCN-007 | Owner-Console-only capability called via API | Capability marked `owner_console_only` | `AuthDecisionRequestScopeDeny` | 1->2->3->4->5 | DENY | `AUTH_PERMISSION_DENIED` |
| SCN-008 | Identity transition with replay-safe utility context binding | Identity re-issued; utility context references runtime issuance fixture | `AuthDecisionRequestIdentityTransitionAllow` | 1->2->3->4->5->6->7 | ALLOW | success `{data,meta}` |
| SCN-009 | Multi-ancestor lifecycle expiry deny | Ancestor chain contains expired grant | `AuthDecisionRequestMultiAncestorExpired` + `ErrorMultiAncestorGrantExpired` | 1->2->3->4 | DENY | `AUTH_GRANT_EXPIRED` |
| SCN-010 | Audience-group-targeted post visibility | Post audience label matches group entitlement | `req-feed-005` | 1->2->3->4->5->6->7 | ALLOW | success `{data,meta}` |
| SCN-011 | Keychain composition aggregates read access | Multiple grants union to effective read scope with deny precedence preserved | `AuthDecisionRequestMultiAncestorLifecycle` (allow-path counterpart) | 1->2->3->4->5->6->7 | ALLOW or DENY deterministic by deny precedence | success OR deterministic deny code |
| SCN-012 | Webhook integration authorization | Integration principal signed request and valid audience | `AuthDecisionRequestScopeDeny` deny-path and authz allow fixture namespace | 1->2->3->4->5->6->7 | ALLOW when signature+scope valid; DENY otherwise | success or `AUTH_SCOPE_DENIED` |

## Normative requirements

- **CRE8-IDPOL-REQ-0015**: The 12 scenarios in this document MUST remain represented by executable fixtures consumed by at least one of `composer test:contract:auth` or `composer test:contract:lifecycle` (`phpunit/phpunit`).
- **CRE8-IDPOL-REQ-0016**: Scenario gate-path notation MUST align to the canonical 7-gate PDP order and MUST fail closed on missing gates (`slim/slim`).
- **CRE8-IDPOL-REQ-0017**: Any scenario involving lifecycle-state propagation MUST map denies to `AUTH_LIFECYCLE_BLOCKED` and use descendant request-id namespace `req-desc-life-*` (`ext-pdo`, `phpunit/phpunit`).
- **CRE8-IDPOL-REQ-0018**: Identity transition scenarios MUST reference replay-safe issuance/context fixtures (`req-ident-issue-rt-*`, `req-ident-ctx-rt-*`) in request context (`ext-sodium`, `firebase/php-jwt`).

## Change history

- 2026-04-30 (v1.0.0): Authored normative scenario corpus/state machine for P3-S4.4/P3-S4.5. Change Impact Map: [[`reports/change_impact_maps/20260430-1030-P3-S4.4-P3-S4.5.md`](reports/change_impact_maps/20260430-1030-P3-S4.4-P3-S4.5.md)](../../reports/change_impact_maps/20260430-1030-P3-S4.4-P3-S4.5.md).
