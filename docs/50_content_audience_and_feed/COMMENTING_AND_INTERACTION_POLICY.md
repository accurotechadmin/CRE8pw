---
doc_id: CRE8-FEED-INTERACTION-POLICY
version: 1.0.0
status: provisional-normative
owner: Product Policy WG
reviewers:
  - API Contracts WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-29
source_seed_refs:
  - seed/cre8core-ownerauthORIGINAL.md
  - README.md
normative_dependencies:
  - docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md
  - docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/31_machine_contracts/openapi/cre8.v1.yaml
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

## Deterministic deny mapping baseline
| Interaction deny condition | Required code |
|---|---|
| Permission missing | `AUTH_PERMISSION_DENIED` |
| Scope boundary denied | `AUTH_SCOPE_DENIED` |
| Delegation depth exceeded | `AUTH_DEPTH_EXCEEDED` |
| Delegated grant expired | `AUTH_GRANT_EXPIRED` |
| Lifecycle blocked/suspended | `AUTH_LIFECYCLE_BLOCKED` |

## Verification hooks
- **HOOK-FEED-INTERACTION-DENY-MAPPING** (manual, Phase 1): Confirm each interaction deny condition maps to one canonical code in route-facing examples and contract tests.
- **HOOK-CONTRACT-POLICY-ORDER** (automated): Reuse existing authorization ordering test hook for interaction actions.
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE** (automated): Ensure interaction deny examples only use catalog-declared codes.

## Manual verification procedure (until dedicated automation exists)
1. Run `composer docs:ssot:lint` and confirm metadata/header/link checks pass.
2. Run `composer docs:ssot:route-parity` and confirm route inventory parity remains valid.
3. Run `composer test:contract:error-secrets` and confirm interaction deny examples remain redaction-safe.
4. Inspect `docs/31_machine_contracts/openapi/cre8.v1.yaml` examples for interaction-scoped request/deny fixtures (`comment.create`).

## Next automation hook candidate
- Add `composer test:contract:feed` scenario for interaction decisions (`comment.create`) covering allow + each deny mapping listed above.

## See also
- [Content Model and Targeting Spec](./CONTENT_MODEL_AND_TARGETING_SPEC.md)
- [Feed Ranking and Ordering Rules](./FEED_RANKING_AND_ORDERING_RULES.md)
- [Authorization and Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [OpenAPI Baseline](../31_machine_contracts/openapi/cre8.v1.yaml)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
