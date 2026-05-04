---
doc_id: CRE8-ARCH-CANONICAL-TERMINOLOGY
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - Identity & Policy WG
  - API Contracts WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_SEED_CANON_INDEX.md
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md
normative_dependencies:
  - README.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Canonical Terminology

## Normative requirements

- **CRE8-ARCH-REQ-0001**: Normative and provisional-normative documents in this repository **MUST** use term spellings and meanings defined in this glossary.
- **CRE8-ARCH-REQ-0002**: Authors **MUST NOT** use prohibited aliases listed in this glossary in normative requirements.
- **CRE8-ARCH-REQ-0003**: New domain nouns introduced in normative content **MUST** be added to this glossary before merge; enforcement is automated by `HOOK-SSOT-GLOSSARY-COVERAGE` via `composer docs:ssot:glossary-check` (dependency enforcement: none; this is documentation governance behavior).
- **CRE8-ARCH-REQ-0004**: Authorization outcomes **MUST** use canonical terms `Allow`, `Deny`, and `Decision Reason Code` exactly as defined here; runtime enforcement is performed by `slim/slim` middleware order plus `firebase/php-jwt` and `respect/validation` for authn/authz inputs.
- **CRE8-ARCH-REQ-0005**: Credential lifecycle and lineage terms (`ID Keypair`, `Utility Keypair`, `Lineage Root`, `Lifecycle State`) **MUST** be interpreted consistently with cryptographic controls enforced by `ext-sodium` and persistence semantics enforced by `ext-pdo`.

## Canonical term registry

| Term | Canonical definition | Allowed aliases | Prohibited aliases | Primary references |
|---|---|---|---|---|
| `Owner` | Root governance principal that issues Primary Author credentials and sets ancestor delegation bounds. | Account Owner | Super Admin | `AUTHORIZATION_AND_DELEGATION_SPEC.md` |
| `Primary Author` | Delegable authoring principal minted by an Owner with bounded permissions and lineage. | Primary | Primary Key | Master Author | `AUTHORIZATION_AND_DELEGATION_SPEC.md` |
| `Secondary Author` | Delegable authoring principal minted beneath a Primary Author with narrower envelope limits. | Secondary | Secondary Key | Sub-admin | `AUTHORIZATION_AND_DELEGATION_SPEC.md` |
| `Use Principal` | Non-authoring runtime principal used for operational activity under bounded grants. | Use Key Principal | Use Key | Service User | `AUTHORIZATION_AND_DELEGATION_SPEC.md` |
| `ID Keypair` | Identity-anchor keypair minted atomically at principal creation and used as lineage root. | Identity Keypair | ID Key | Utility-only Key | `ID_UTILITY_KEYPAIR_MODEL_SPEC.md` |
| `Utility Keypair` | Context-scoped operational keypair derived from lineage and never used as identity root. | Utility Key | Operational Keypair | Master Key | `ID_UTILITY_KEYPAIR_MODEL_SPEC.md` |
| `Lineage Root` | First immutable identity anchor from which descendant utility credentials derive. | Root ID Keypair | Root Anchor | Parent Secret | `KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md` |
| `Delegation Envelope` | Immutable bound set (permissions, scope, depth, lifecycle, expiry) applied to descendants. | Envelope | Delegation Bounds | Grant Blob | `AUTHORIZATION_AND_DELEGATION_SPEC.md` |
| `Delegation Depth` | Maximum descendant hop count allowed from grantor to grantee chain. | Depth | Hop Limit | Nesting Level | `AUTHORIZATION_DECISION_TABLES.md` |
| `Scope` | Resource/action boundary attached to a grant and enforced at authorization time. | Permission Scope | Policy Scope | Blanket Access | `AUTHORIZATION_DECISION_TABLES.md` |
| `Tenant` | Multi-tenant isolation boundary for identity, policy, content, and audit data. | Tenant Boundary | Workspace | Global Realm | `DATA_MODEL_SPEC.md` |
| `Resource` | Target object family acted upon by a permission token. | Target Resource | Resource Family | Object Any | `PERMISSION_VOCABULARY.md` |
| `Permission Token` | Stable verb+resource identifier used for policy and delegation checks. | Permission | Capability Token | Freeform Right | `PERMISSION_VOCABULARY.md` |
| `Explicit Deny` | Deterministic policy outcome that overrides allows for matching scope. | Deny Rule | Hard Deny | Soft Reject | `AUTHORIZATION_DECISION_TABLES.md` |
| `Allow` | Deterministic policy outcome permitting operation after all gates pass. | Permit | Authorized | Maybe Allow | `AUTHORIZATION_DECISION_TABLES.md` |
| `Deny` | Deterministic policy outcome that rejects operation with mapped reason code. | Rejected | Blocked | Error-ish | `AUTHORIZATION_DECISION_TABLES.md` |
| `Decision Reason Code` | Stable internal reason identifier that maps one-to-one to public error codes. | Reason Code | Policy Reason | Text Reason | `ERROR_CODE_CATALOG.md` |
| `Policy Decision Point` | Centralized authorization adjudicator invoked before handlers execute business logic. | PDP | Authorization Engine | Handler Policy | `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` |
| `Policy Evaluation Context` | Normalized input object used by PDP to evaluate grants and constraints. | Eval Context | Decision Context | Request Bag | `AUTHORIZATION_DECISION_TABLES.md` |
| `Lifecycle State` | Enumerated principal/key state controlling issuance, usage, and revocation behavior. | State | Key State | Status Flag | `KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md` |
| `Revocation` | Immediate transition that invalidates credential usage and descendant-derived access. | Revoke | Invalidate | Disable Later | `KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md` |
| `Rotation` | Controlled key replacement process preserving lineage provenance and bounded continuity. | Key Rotation | Rotate | Reissue Same Secret | `KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md` |
| `Provenance Event` | Immutable audit record emitted for security-significant mutation or decision. | Audit Event | Provenance Record | Mutable Log | `PROVENANCE_APPEND_ONLY_MODEL.md` |
| `Correlation ID` | Stable request-level identifier propagated across responses and provenance events. | request_id | Correlation Token | Trace Guess | `API_CONTRACT_GUIDE.md` |
| `Request Proof` | Signature bundle (`public_key_id`, nonce, timestamp, signature) verifying caller possession. | Proof Header Set | Signed Request | Token-only Auth | `API_AUTHENTICATION_AND_SIGNATURE_PROFILE.md` |
| `Nonce` | Single-use random value preventing replay for a bounded validity window. | Replay Nonce | Unique Token | Reusable Token | `API_AUTHENTICATION_AND_SIGNATURE_PROFILE.md` |
| `Clock Skew Window` | Maximum tolerated timestamp drift for signed requests before deny. | Skew Window | Timestamp Tolerance | Unlimited Drift | `API_AUTHENTICATION_AND_SIGNATURE_PROFILE.md` |
| `Owner Console` | Governance surface for owner lifecycle, moderation, and policy administration. | Console Surface | Admin UI | Public UI | `UI_RUNTIME_CONTRACT.md` |
| `API Gateway` | Programmatic surface for authenticated delegated client operations. | API Surface | Gateway Surface | Console API | `API_CONTRACT_GUIDE.md` |
| `Public/Bootstrap Surface` | Unauthenticated or bootstrap endpoints for readiness and initial setup preconditions. | Bootstrap Surface | Public Surface | Anonymous Full API | `ROUTE_INVENTORY_REFERENCE.md` |
| `Surface Boundary` | Non-interchangeability rule for authn/authz contexts across declared surfaces. | Boundary Rule | Surface Constraint | Shared Session Everywhere | `ARCHITECTURE_AND_SURFACES.md` |
| `Route ID` | Stable route identifier mapped to method/path and contract operation. | route_id | Endpoint ID | URL Nickname | `ROUTE_INVENTORY_REFERENCE.md` |
| `Contract Version` | Version identifier carried in response metadata and change governance process. | API Version | contract_version | Implicit Version | `API_CONTRACT_GUIDE.md` |
| `Error Envelope` | `{error, meta}` response shape with deterministic required fields. | Error Payload | Failure Envelope | Raw Error | `ERROR_CODE_CATALOG.md` |
| `Success Envelope` | `{data, meta}` response shape with deterministic required fields. | Success Payload | Data Envelope | Arbitrary Body | `API_CONTRACT_GUIDE.md` |
| `Audience Group` | Managed set of principals used for visibility and delivery targeting controls. | Group Audience | Audience Set | ACL Bucket | `AUDIENCE_GROUP_SPEC.md` |
| `Keychain` | Aggregated capability construct composed from multiple grants with provenance retention. | Capability Chain | Chain | Permission Soup | `KEYCHAIN_COMPOSITION_RULES.md` |
| `Feed Item` | A returned content unit in authorized newest-first feed results. | Timeline Item | Feed Entry | Post Blob | `FEED_RANKING_AND_ORDERING_RULES.md` |
| `Cursor` | Opaque pagination token encoding deterministic continuation position. | Feed Cursor | Pagination Cursor | Page Number | `FEED_RANKING_AND_ORDERING_RULES.md` |
| `Moderation State` | Enumerated state controlling visibility/interaction outcomes under policy. | Moderation Status | Review State | Hidden Flag | `COMMENTING_AND_INTERACTION_POLICY.md` |
| `Comment Interaction` | Policy-gated reply/engagement action bound to post visibility and permissions. | Comment Action | Interaction | Free Comment | `COMMENTING_AND_INTERACTION_POLICY.md` |
| `Visibility Rule` | Canonical predicate controlling whether principal can view content item. | Visibility Predicate | Access Rule | Soft Privacy | `CONTENT_VISIBILITY_POLICY.md` |
| `Rate Limit` | Deterministic request-budget policy enforced per identity/surface window. | Throttle Rule | Limiter | Best-effort Limit | `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` |
| `Cache Key` | Deterministic key used for policy or rate state storage in shared cache backend. | Cache Identifier | State Key | Random Cache Name | `DEPENDENCY_BASELINE.md` |
| `Migration` | Ordered forward-only schema evolution unit for persistent stores. | DB Migration | Schema Migration | Hotfix SQL | `MIGRATION_AND_SEED_STRATEGY.md` |
| `Health Check` | Deterministic readiness/liveness contract for operational monitoring. | Health Probe | Readiness Check | Ping Only | `HEALTH_ENDPOINT_CONTRACT.md` |
| `Extension Module` | Optional capability package that MUST preserve core invariants and hook contracts. | Module | Extension | Plugin Anything | `EXTENSIBILITY_PLAYBOOK.md` |
| `Provider Adapter` | Integration seam for external systems under canonical contracts and provenance. | Integration Provider | Adapter | Direct Third-party Call | `INTEGRATION_PROVIDER_PATTERN.md` |
| `Manual Hook` | Verification hook executed by documented procedure when automation is unavailable. | Manual Verification Hook | Human Hook | Ad-hoc Check | `VERIFICATION_STRATEGY.md` |
| `Automated Hook` | Verification hook executed by deterministic command/script with hard exit semantics. | Automated Verification Hook | CI Hook | Soft Check | `SSOT_AUTOMATION_AND_LINTING.md` |
| `Evidence Artifact` | Versioned file proving hook execution or review outcome for a requirement. | Evidence File | Verification Artifact | Screenshot Proof Only | `docs/evidence/templates/README.md` |
| `Change Impact Map` | Required impact analysis artifact for machine-contract and cross-doc semantic changes. | Impact Map | CIM | Informal Note | `CHANGE_IMPACT_MAP_TEMPLATES.md` |
| `Decision Record` | ADR or decisions-log event documenting bounded architecture/program decisions. | ADR Entry | Decision Event | Discussion Thread | `ADR_INDEX.md` |
| `Risk Register Entry` | Tracked risk item with owner, due date, and mitigation state. | Risk Entry | Risk Row | Untracked Concern | `UNRESOLVED_SEED_GAP_REGISTER.md` |
| `Exception` | Explicitly approved deferral item with owner/due/decision reference in register. | Program Exception | Deferral Row | Silent Debt | `PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md` |
| `SSOT` | Single source of truth corpus that governs implementation and verification behavior. | Canon | Authoritative Spec | Suggestion Docs | `SSOT_INDEX.md` |

## Canonical actor vocabulary (Phase 4 normalization)

| Actor | Canonical meaning | Required usage boundary | Prohibited aliases |
|---|---|---|---|
| `System` | Server-side CRE8 runtime that enforces contracts and emits deterministic envelopes/events. | MUST be used for normative behavior executed by application code or middleware pipeline. | Platform, Backend Service |
| `Issuer` | Principal authorized to mint or delegate credentials/capabilities to another principal. | MUST be used for issuance/delegation actions and provenance lineage statements. | Grantor, Admin Issuer |
| `Principal` | Authenticated identity subject represented in policy evaluation and capability matrices. | MUST be used for actor identity in authorization, lifecycle, and audience policy semantics. | User, Account Actor |
| `Moderator` | Principal acting under moderation permissions and moderation-state transitions. | MUST be used for moderation outcomes, holds, review, and interaction controls. | Reviewer, Content Admin |
| `Integration Provider` | External or modular integration component bound by webhook/provider contracts. | MUST be used for third-party or extension integration obligations and retry/signature semantics. | Provider Adapter (actor), Third-party Service |
| `Operator` | Human or automation actor executing operational runbooks, release gates, and verification hooks. | MUST be used for deployment/operations/verification actions outside request-serving runtime. | DevOps, SRE User |

## See also
- [SSOT Index](../00_governance/SSOT_INDEX.md)
- [Document Template and Style Guide](../00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)
- [Traceability Matrix](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
