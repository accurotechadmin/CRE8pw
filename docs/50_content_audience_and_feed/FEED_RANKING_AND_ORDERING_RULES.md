---
doc_id: CRE8-FEED-RANKING-ORDERING
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
  - docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
  - docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md
change_impact_map: reports/change_impact_maps/20260430-0900-P3-S1.4-P3-S1.6.md
---

# Feed Ranking and Ordering Rules

## Purpose
Define deterministic feed authorization and ordering behavior for CRE8 audience-targeted content.

## Normative requirements
- **CRE8-FEED-REQ-0001**: Feed inclusion **MUST** be authorization-gated; items are eligible only when requester principal/key is within effective audience targeting policy at evaluation time.
- **CRE8-FEED-REQ-0002**: Eligible feed items **MUST** be ordered newest-first by canonical content timestamp, with deterministic tie-breaker on immutable `content_id` ascending.
- **CRE8-FEED-REQ-0003**: Authorization revocation or audience-policy change **MUST** remove newly ineligible items from subsequent feed responses with no grace bypass unless an explicit emergency policy exception exists.
- **CRE8-FEED-REQ-0004**: Feed response metadata **MUST** expose `ordering_basis` and pagination cursor semantics so clients can reproduce deterministic ordering.

- **CRE8-FEED-REQ-0038**: Feed ordering **MUST** execute within tenant-isolated datasets; cross-tenant ordering or cursor reuse **MUST NOT** occur.
- **CRE8-FEED-REQ-0039**: Refresh requests **MUST** be rate-limited per principal and per tenant using deterministic windows; throttled refresh responses **MUST** return canonical error code and retry guidance fields.
- **CRE8-FEED-REQ-0040**: Ordering recomputation **MUST** remain stable under pagination so that replaying the same cursor during the same consistency window yields identical item order and metadata.

## Verification hooks
- **HOOK-FEED-AUTH-ORDER**: Validate authorized-only inclusion and deterministic newest-first ordering semantics.
- **Next automation candidate**: Add contract snapshots for mixed-visibility fixtures under `test:contract` to verify ordering and revocation behavior.

## See also
- [Content Model and Targeting Spec](./CONTENT_MODEL_AND_TARGETING_SPEC.md)
- [Authorization and Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Commenting and Interaction Policy](./COMMENTING_AND_INTERACTION_POLICY.md)


Change impact map: `reports/change_impact_maps/20260430-0900-P3-S1.4-P3-S1.6.md`.

Change Impact Map: `reports/change_impact_maps/20260430-0900-P3-S1.4-P3-S1.6.md`.
