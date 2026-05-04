---
doc_id: CRE8-FEED-AUDIENCE-GROUP-SPEC
version: 1.0.0
status: provisional-normative
owner: Product Policy WG
reviewers:
  - Identity & Policy WG
  - API Contracts WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md
  - docs/40_data_security_and_crypto/DATA_MODEL_REFERENCE.md
  - docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
change_impact_map: reports/change_impact_maps/20260430-1335-P3-S8.1-P3-S8.2.md
---

# Audience Group Spec

## Purpose
Define deterministic audience-group entity semantics, ownership authority, membership lifecycle, and enumeration behavior.

## Normative requirements
- **CRE8-FEED-REQ-0023**: `AudienceGroup` records **MUST** include immutable `group_id`, `tenant_id`, `scope_type`, `created_by_principal_id`, `created_at_utc`, and mutable `status` (`active`, `suspended`, `deleted`) fields aligned to the canonical data model.
- **CRE8-FEED-REQ-0024**: `scope_type` **MUST** be one of `tenant`, `workspace`, `project`, or `custom`; values outside this set **MUST** be rejected with `VALIDATION_FAILED`.
- **CRE8-FEED-REQ-0025**: Audience-group membership rows **MUST** bind `group_id` + `member_principal_id` + `membership_state` (`active`, `pending`, `revoked`) with UTC lifecycle stamps and **MUST NOT** permit duplicate active memberships for the same pair.
- **CRE8-FEED-REQ-0026**: Only principals with owner authority over the target scope **MUST** be permitted to create, suspend, delete, or mutate membership for audience groups in that scope.
- **CRE8-FEED-REQ-0027**: Membership changes **MUST** apply to authorization decisions no later than the next request evaluation cycle and **MUST NOT** rely on client refresh acknowledgments.
- **CRE8-FEED-REQ-0028**: Audience-group hard size limits **MUST** be deterministic per `scope_type`; when a limit is reached, new membership inserts **MUST** be denied with `POLICY_LIMIT_EXCEEDED`.
- **CRE8-FEED-REQ-0029**: Group enumeration endpoints **MUST** return stable ordering by `created_at_utc DESC, group_id ASC` and **MUST** include pagination cursors that reproduce the same order across retries.
- **CRE8-FEED-REQ-0030**: Groups in `deleted` state **MUST NOT** be eligible for new membership changes and **MUST** be excluded from default enumeration unless explicit `include_deleted=true` is provided.
- **CRE8-FEED-REQ-0031**: When the system evaluates audience-targeted visibility, the authorization service **MUST** require `audience.group.view` for read/enumeration paths and **MUST** require `audience.group.manage` for create/update/delete/membership mutation paths; requests missing required token grants **MUST** be denied with `AUTH_PERMISSION_DENIED`.
- **CRE8-FEED-REQ-0032**: When a membership row references a `member_principal_id` that is `suspended`, `revoked`, or `expired`, the authorization service **MUST** treat membership as non-effective for feed visibility and **MUST** return deny semantics consistent with canonical lifecycle enforcement.

## Verification hooks
- **HOOK-CONTRACT-FEED-METADATA-STABILITY** (automated): Enforce stable feed and audience metadata fields and deterministic ordering/pagination semantics.
- **HOOK-AUTH-LIFECYCLE-ENFORCEMENT** (automated): Validate lifecycle-state enforcement for group and membership mutation actions.
- **HOOK-CAPABILITY-MATRIX-COMPLETE** (automated): Ensure owner-authority constraints remain aligned with principal capability matrix.
- **HOOK-PERMISSION-VOCAB-RESOLVE** (automated): Ensure audience-group operations use registered permission tokens and deterministic unknown-token deny behavior.
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE** (automated): Validate use of canonical deny/error codes for audience-group flows.

## See also
- [Content Model and Targeting Spec](./CONTENT_MODEL_AND_TARGETING_SPEC.md)
- [Authorization and Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [Data Model Spec](../40_data_security_and_crypto/DATA_MODEL_SPEC.md)
- [Data Model Reference](../40_data_security_and_crypto/DATA_MODEL_REFERENCE.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)

Change Impact Map: [`reports/change_impact_maps/20260430-1335-P3-S8.1-P3-S8.2.md`](reports/change_impact_maps/20260430-1335-P3-S8.1-P3-S8.2.md).
