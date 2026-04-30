---
doc_id: CRE8-FEED-CONTENT-MODEL
version: 1.0.0
status: provisional-normative
owner: Product Policy WG
reviewers:
  - API Contracts WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-20
source_seed_refs:
  - seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md
normative_dependencies:
  - docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md
---

# Content Model and Targeting Spec

## Purpose
Define deterministic content-targeting semantics, feed-read eligibility constraints, and required machine-contract fields for feed-facing payloads.

## Normative requirements
- **CRE8-FEED-REQ-0010**: Every content item exposed via feed contracts **MUST** include immutable `item_id`, canonical publication timestamp `published_utc`, and an explicit `visibility_scope` value.
- **CRE8-FEED-REQ-0011**: `visibility_scope` **MUST** be represented as `<scope_type>:<scope_value>` and **MUST** only use approved scope types: `group`, `tenant`, `resource`, or `global`.
- **CRE8-FEED-REQ-0012**: Feed eligibility evaluation **MUST** execute authorization checks before item inclusion and **MUST** deny by default when scope parsing or policy state resolution is ambiguous.
- **CRE8-FEED-REQ-0013**: Feed response `meta` **MUST** include cursor fields (`next_cursor`, `cursor_basis`) whenever pagination is supported for the route.
- **CRE8-FEED-REQ-0014**: `cursor_basis` **MUST** be stable and reproducible from ordering inputs; Phase 1 baseline **MUST** use `published_utc_desc__item_id_asc`.
- **CRE8-FEED-REQ-0015**: Route-level contract examples **SHOULD** include at least one deny variant for permission and one deny variant for scope/lifecycle/expiry constraints.

## Verification hooks

- **CRE8-FEED-REQ-0031**: Content lifecycle **MUST** implement deterministic states `draft`, `published`, `flagged`, `restricted`, `soft_deleted`, and `hard_deleted`; transitions outside the approved transition table **MUST** be rejected.
- **CRE8-FEED-REQ-0032**: Moderation actions (`flag`, `restrict`, `restore`, `delete`) **MUST** record moderator principal, reason code, and UTC timestamp in immutable audit history for each affected content item.
- **CRE8-FEED-REQ-0033**: `soft_deleted` content **MUST** be excluded from default feed retrieval while preserving audit metadata and reference integrity for policy/compliance review.
- **CRE8-FEED-REQ-0034**: Retention rules **MUST** define minimum retention windows for moderation and deletion artifacts; purge before minimum retention **MUST NOT** occur unless an explicit legal hold override is recorded.
- **HOOK-FEED-CONTRACT-CURSOR-SCHEMA**: Validate feed success schema contains required cursor metadata keys and approved ordering-basis enum.
- **HOOK-FEED-CONTRACT-DENY-EXAMPLES**: Validate feed route OpenAPI examples include deterministic deny reason-code variants.
- **Next automation candidate**: Add `composer test:contract:feed` fixture test for cursor monotonicity and deny-on-ambiguous-scope behavior.

## See also
- [Feed Ranking and Ordering Rules](./FEED_RANKING_AND_ORDERING_RULES.md)
- [Authorization and Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Commenting and Interaction Policy](./COMMENTING_AND_INTERACTION_POLICY.md)
- [OpenAPI Contract](../31_machine_contracts/openapi/cre8.v1.yaml)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)

Change Impact Map: `reports/change_impact_maps/20260430-1335-P3-S8.1-P3-S8.2.md`.
