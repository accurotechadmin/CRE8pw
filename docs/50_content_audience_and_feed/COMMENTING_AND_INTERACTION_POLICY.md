---
doc_id: CRE8-FEED-INTERACTION-POLICY
version: 1.1.0
status: provisional-normative
owner: Product Policy WG
reviewers:
  - API Contracts WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - README.md
normative_dependencies:
  - docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md
  - docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
change_impact_map: reports/change_impact_maps/20260430-0900-P3-S1.4-P3-S1.6.md
---

# Commenting And Interaction Policy

## Purpose
Define deterministic authorization, lifecycle, and error-contract rules for comment and interaction behaviors on feed content.

## Normative requirements
- **CRE8-FEED-REQ-0016**: Comment creation and interaction actions (`comment.create`, `comment.reply`, `comment.react`) **MUST** be authorized using the same deterministic policy evaluation order defined for other delegated actions.
- **CRE8-FEED-REQ-0017**: Interaction authorization **MUST** enforce audience scope boundary checks against the target item visibility scope before mutation is accepted.
- **CRE8-FEED-REQ-0018**: If target item or acting credential lifecycle state is not active, the platform **MUST** deny the interaction and **MUST** return a deterministic deny code from the canonical error catalog.
- **CRE8-FEED-REQ-0019**: Interaction denies caused by permission, scope, delegation depth, or grant expiry **MUST** map one-to-one to existing `AUTH_*` deny codes and **MUST NOT** introduce ad hoc route-local deny codes.
- **CRE8-FEED-REQ-0020**: Accepted interaction mutations **MUST** emit immutable provenance events with actor principal, effective credential, target item, action, and UTC timestamp fields.
- **CRE8-FEED-REQ-0021**: Phase 1 machine contract examples **MUST** include at least one interaction-scoped authorization request and one deterministic interaction deny example to prevent prose↔machine drift.
- **CRE8-FEED-REQ-0022**: Every interaction deny example bound to `AUTH_PERMISSION_DENIED`, `AUTH_SCOPE_DENIED`, `AUTH_DEPTH_EXCEEDED`, `AUTH_GRANT_EXPIRED`, or `AUTH_LIFECYCLE_BLOCKED` **MUST** include an `error` payload with canonical `code`, deterministic `category`, `request_id` prefix (`req-feed-`, `req-authz-`, or `req-interact-`), and ISO-8601 `timestamp_utc` to preserve executable payload-shape parity.

- **CRE8-FEED-REQ-0035**: Comment lifecycle **MUST** implement deterministic states `visible`, `edited`, `hidden_by_moderation`, `soft_deleted`, and `hard_deleted` with explicit allowed transitions.
- **CRE8-FEED-REQ-0036**: Comment edits **MUST** preserve immutable edit history entries containing prior body hash, editor principal, edit reason, and `edited_at_utc`.
- **CRE8-FEED-REQ-0037**: `soft_deleted` comments **MUST** be hidden from default client views while remaining retrievable for moderators and audit hooks according to authorization policy.

- **CRE8-FEED-REQ-0043**: The interaction policy engine **MUST** evaluate branches in deterministic order for each request: credential authenticity, credential lifecycle, target-content lifecycle, permission grant, audience scope, and moderation lock; the first failing branch **MUST** terminate evaluation and return its canonical deny code.
- **CRE8-FEED-REQ-0044**: For comment create/reply actions on moderated or deleted targets, the platform **MUST** return `LIFECYCLE_COMMENT_TARGET_UNAVAILABLE`; for hidden-by-policy audience mismatches it **MUST** return `AUTH_SCOPE_DENIED`.
- **CRE8-FEED-REQ-0045**: Moderator actions (`comment.hide`, `comment.restore`, `comment.delete`) **MUST** require `comment.moderate`, **MUST** record moderation reason code, and **MUST** emit provenance events linked to the affected comment lifecycle transition.

## Deterministic deny mapping baseline
| Interaction deny condition | Required code |
|---|---|
| Permission missing | `AUTH_PERMISSION_DENIED` |
| Scope boundary denied | `AUTH_SCOPE_DENIED` |
| Delegation depth exceeded | `AUTH_DEPTH_EXCEEDED` |
| Delegated grant expired | `AUTH_GRANT_EXPIRED` |
| Lifecycle blocked/suspended | `AUTH_LIFECYCLE_BLOCKED` |

## Interaction branch-to-deny mapping
| Branch failure | Required deny code |
|---|---|
| Credential authenticity/signature invalid | `AUTHN_SIGNATURE_INVALID` |
| Credential lifecycle not active | `AUTH_LIFECYCLE_BLOCKED` |
| Target comment/content unavailable by lifecycle | `LIFECYCLE_COMMENT_TARGET_UNAVAILABLE` |
| Required permission missing | `AUTH_PERMISSION_DENIED` |
| Audience scope mismatch | `AUTH_SCOPE_DENIED` |
| Moderation lock active | `AUTH_LIFECYCLE_BLOCKED` |

## Verification hooks
- **HOOK-FEED-INTERACTION-DENY-MAPPING** (automated): Execute `composer test:contract:feed` to enforce deterministic one-to-one deny-condition to canonical code mapping and deny-example payload-shape semantics (`error.code`, `error.category`, `request_id` prefix, `timestamp_utc`) in OpenAPI fixtures.
- **HOOK-CONTRACT-POLICY-ORDER** (automated): Reuse existing authorization ordering test hook for interaction actions.
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE** (automated): Ensure interaction deny examples only use catalog-declared codes.

## See also
- [Content Model and Targeting Spec](./CONTENT_MODEL_AND_TARGETING_SPEC.md)
- [Feed Ranking and Ordering Rules](./FEED_RANKING_AND_ORDERING_RULES.md)
- [Authorization and Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [OpenAPI Baseline](../31_machine_contracts/openapi/cre8.v1.yaml)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)


Change impact map: `reports/change_impact_maps/20260430-0900-P3-S1.4-P3-S1.6.md`.

Change Impact Map: `reports/change_impact_maps/20260430-0900-P3-S1.4-P3-S1.6.md`.
