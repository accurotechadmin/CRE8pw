# CRE8 SSOT Seed Inventory: Keypair-Centric Platform Model

_Status: authoritative seed_  
_Effective date (UTC): 2026-04-29_

## 1. Authority, role, and usage
This document is the authoritative **seed inventory** for instantiating the keypair-centric CRE8 SSOT. It defines the complete capability and control baseline that downstream canonical artifacts (OpenAPI, schemas, contracts, data/security, operations, traceability, ADRs) MUST implement without semantic drift.

### 1.1 Normative precedence
When conflicts exist, apply this order:
1. Machine contracts: `docs/ssot_canon/openapi/cre8.v1.yaml`, envelope schemas in `docs/ssot_canon/schemas/*.json`.
2. Normative SSOT canon documents in `docs/ssot_canon/*`.
3. Foundation and execution planning documents in `docs/01_foundation/*`, `docs/03_execution_planning/*`.
4. Onboarding/audit/instructional artifacts in `docs/02_*`, `docs/04_*`.

### 1.2 Scope
This seed defines platform behavior for:
- identity/authentication/authorization,
- key lifecycle and delegation,
- audience access governance,
- post/comment access enforcement,
- deterministic denial/error semantics,
- provenance/event logging,
- verification and traceability obligations,
while preserving CRE8’s envelope-first and governance-first operating model.

---

## 2. Non-negotiable platform invariants

## 2.1 Surface boundaries
- Public/bootstrap surface remains distinct from protected surfaces.
- Gateway protected APIs (`/api/*`) and Console governance APIs (`/console/api/*`) remain non-interchangeable authentication/authorization contexts.
- Route ownership and registration remain partitioned by surface.

## 2.2 Contract invariants
- Every API response remains envelope-first.
- Error behavior remains deterministic with stable detail codes and request-correlation support.
- Resource `404` behavior remains distinct from route-template `404` behavior.

## 2.3 Authorization invariants
- PDP/middleware remains the sole policy decision authority.
- Handlers/services MUST NOT implement ad-hoc permission/delegation/device/context policy branches.
- Delegation remains bounded by permissions, scope, depth, expiry, lifecycle, and route obligations.

## 2.4 Governance/quality invariants
- No contract-shape changes without synchronized machine artifact and test updates.
- No completion claims without verifiable evidence.
- Traceability updates are mandatory for capability changes.

---

## 3. Canonical identity and key model

## 3.1 Key classes
1. **Primary Author**
2. **Secondary Author**
3. **Use**
4. **Keychain**
5. **Master (console-governed only)**

## 3.2 Credential Key (ID Key)
A Credential Key is the principal identity anchor for Primary Author, Secondary Author, or Use actors.

Required properties:
- minted as a Private/Public keypair,
- private material shown exactly once at issuance,
- public identifier used for actor identity and verification lookup,
- lineage root for descendant Utility Keys,
- supports rotate/suspend/revoke/reactivate under policy bounds,
- carries immutable provenance identity.

## 3.3 Utility Key (Access Key)
A Utility Key is an operational access keypair minted under a Credential Key for a specific context (client/service/device/automation profile).

Required properties:
- private/public keypair,
- explicit parent Credential Key reference,
- bounded permissions/scope/depth/expiry/lifecycle,
- independently rotatable/revocable,
- usage telemetry and policy events attributable to both utility key and credential root.

## 3.4 Keypair proof model
Gateway authentication uses keypair proof-based requests:
- `public_key_id`
- `timestamp`
- `nonce`
- `signature`

Server obligations:
- resolve active key by `public_key_id`,
- verify signature against stored public material,
- enforce nonce uniqueness + replay window,
- enforce timestamp skew bounds,
- normalize decision context and invoke PDP.

## 3.5 Device binding compatibility
For routes requiring device binding, keypair proof evaluation is conjunctive with device obligations:
- required device claim/header presence,
- claim/header format validation,
- deterministic mismatch denial mapping.

---

## 4. Key lifecycle and delegation semantics

## 4.1 Minting
- Owner in Console may mint Credential Keys according to governance policy.
- Authorized key actors may mint descendant keys within delegated envelope bounds.
- Every minted key has lifecycle state (`active`, `suspended`, `revoked`, etc.) and immutable lineage links.

## 4.2 Rotation
- Credential and Utility keys support independent rotation.
- Rotation produces successor linkage and explicit provenance records.
- Rotation policies MUST define descendant impact modes:
  - no-impact,
  - soft-impact (grace period),
  - hard-impact (immediate descendant disablement).

## 4.3 Suspension/revocation
- Suspension is reversible; revocation is terminal unless explicitly reissue-based policy allows replacement.
- Descendant governance supports subtree actions within delegated authority bounds.
- Owner override remains available in console governance context.

## 4.4 Descendant governance controls
Minter/governor capabilities:
- enumerate descendants by depth/type/class/status/time,
- inspect usage and policy decisions by descendant,
- rotate/suspend/revoke descendant keys,
- emergency freeze scoped subtree,
- perform context-scoped remediation.

Policy constraints:
- actions constrained by ancestry, delegation depth, and permission envelope,
- forbidden class actions deterministically denied,
- all governance mutations audit-emitted.

---

## 5. Audience Group model

## 5.1 Definition
Audience Group = named policy-governed collection of Public Use Keys used as a reusable post-access target.

## 5.2 Membership governance modes
Each group declares exactly one mode:
1. **Author-managed**: only authorized group governors can add/remove.
2. **Request-to-join**: membership requests require explicit approval.
3. **Open-join**: eligible keys are admitted automatically under policy filters.

## 5.3 Membership policy controls
- eligibility constraints (key class, lifecycle, scope qualifiers),
- anti-abuse throttles for join/create operations,
- moderation workflow hooks,
- deterministic denial detail codes,
- immutable membership change provenance.

## 5.4 Post linkage semantics
A post may attach:
- direct Public Use Keys,
- Audience Group IDs,
- Keychain entitlements.

Effective access = deterministic union of allowed principals from all attached targets, then constrained by deny-overrides, lifecycle state, and route obligations.

---

## 6. Keychain model
Keychain represents aggregated permission/scope capabilities composed from eligible source keys.

Mandatory constraints:
- no forbidden class inclusion,
- no prohibited nesting patterns,
- bounded membership cardinality,
- deterministic effective permission/scope resolution,
- lifecycle-aware member filtering,
- provenance snapshot on every resolve operation.

Keychain access cannot bypass console/gateway boundary rules or owner-only governance constraints.

---

## 7. Normative end-to-end user flows

## 7.1 Owner onboarding by invitation
1. Existing Owner A issues invitation to Person B.
2. Person B registers owner account (username, email, password).
3. Person B authenticates into Console owner context.

## 7.2 Primary Author identity establishment
1. Person B mints Primary Author Credential Key.
2. System returns private key material once and associated public identifier.
3. System emits minting provenance event.

## 7.3 Delegated handoff and operation
1. Person B delegates key material to Person C through approved transfer method.
2. Person C uses delegated authority to mint Use keys (Credential or Utility per policy).
3. Person C authors posts and grants access via keys/groups/keychains.

## 7.4 Audience-driven collaboration
1. Primary/Secondary Author creates Audience Group.
2. Group membership governed by selected mode.
3. Author targets Audience Group(s) on post creation.
4. Members with qualifying keys gain post/comment access according to effective entitlements.

---

## 8. Deterministic policy decision model

## 8.1 Decision inputs
- actor identity (owner or key principal),
- actor class/lifecycle,
- route action classification,
- delegation envelope,
- keychain effective envelope (if applicable),
- audience-group membership state (if applicable),
- device obligations (if route-required),
- resource visibility/lifecycle conditions.

## 8.2 Decision outputs
- allow with obligations,
- deny with canonical HTTP status + detail code + correlation-ready error envelope.

## 8.3 Prohibited implementation patterns
- handler-local authorization branches,
- implicit fallback allows,
- non-deterministic detail-code selection,
- bypass of middleware/PDP enforcement.

---

## 9. Error taxonomy expansion requirements
Existing deterministic catalog model is preserved and expanded for keypair/audience domains including (non-exhaustive families):
- signature invalid,
- nonce replay,
- timestamp skew,
- key lifecycle forbidden,
- descendant governance forbidden,
- audience membership forbidden,
- audience join throttled,
- keychain composition forbidden,
- keychain resolve conflict.

All new detail codes must be stable, documented, and test-covered.

---

## 10. Provenance and event logging contract

## 10.1 Event classes
Required classes include:
- key minted/rotated/suspended/revoked/reactivated,
- key exported/transferred,
- descendant governance action,
- keychain composed/resolved/changed,
- audience group created/updated/deleted,
- audience membership requested/approved/rejected/auto-admitted/removed,
- post access target attached/detached,
- authorization allow/deny decision,
- security anomaly detection.

## 10.2 Required event fields
- `event_id`, `event_type`, `event_time_utc`
- `request_id`/correlation id
- actor principal identifiers (owner id and/or public key id)
- target entity identifiers
- lineage/delegation snapshot
- decision outcome + detail code (when applicable)
- integrity linkage field(s) for tamper evidence

## 10.3 Query, retention, export
- queryable by actor, descendant tree, post, audience group, action, time,
- defined retention tiers and archival policy,
- exportable evidence bundles for incident/compliance workflows.

---

## 11. Data model inventory requirements
The canonical data model must include entities/relations for:
- owners/principals,
- credential keys,
- utility keys,
- key lineage edges,
- lifecycle transitions,
- delegation envelopes,
- keychains + members + effective snapshots,
- audience groups + membership + moderation state,
- post access attachments (key/group/keychain links),
- provenance/security events.

Integrity requirements:
- immutable lineage references,
- uniqueness constraints for key identifiers/nonces,
- lifecycle transition validity rules,
- referential integrity for descendant and access-target links.

---

## 12. API surface inventory requirements

## 12.1 Console governance families
- owner invitations and owner registration governance
- credential key mint/lifecycle management
- utility key mint/lifecycle management
- descendant tree browse/filter/actions
- audience group CRUD and governance mode controls
- audience membership workflows
- keychain compose/member manage/resolve
- provenance/usage inspection endpoints

## 12.2 Gateway families
- keypair-authenticated content read/write routes
- post/comment routes with effective entitlement enforcement
- deterministic access denials for key/group/keychain constraints

## 12.3 Compatibility/versioning
- explicit migration mode behavior for legacy vs keypair auth (if coexisting),
- deprecation policy and sunset gates,
- client capability signaling and fallback-denial behavior.

---

## 13. Security control inventory requirements
- one-time private key reveal controls,
- secure key transfer guidance and controls,
- replay defense (nonce + skew window),
- compromised-key incident workflow,
- subtree revocation/remediation workflow,
- audience-group abuse controls,
- device-binding co-enforcement on required routes,
- cryptographic material handling controls (at rest/in transit/log redaction).

---

## 14. Verification, readiness, and traceability requirements

## 14.1 Verification classes
- contract parity (OpenAPI/schema/examples),
- authorization decision-table determinism,
- cryptographic proof validation,
- replay/skew/device obligation checks,
- key lifecycle/descendant governance checks,
- keychain composition/resolve correctness,
- audience-group governance mode checks,
- provenance completeness/integrity checks,
- operational smoke and degraded-state checks.

## 14.2 Evidence requirements
Every capability change must include:
- executed command evidence,
- deterministic expected/actual outcomes,
- traceability matrix row updates,
- unresolved risk registration with owner and remediation target.

---

## 15. Canon rewrite instantiation map
This seed SHALL be instantiated into authoritative artifacts in this order:
1. OpenAPI and envelope schema parity updates.
2. Authorization/delegation spec and decision tables.
3. Error catalog updates.
4. Data model and security controls/threat model updates.
5. Operations/verification/readiness artifacts.
6. Traceability and automation artifacts.
7. ADR/program governance updates.

No lower-level artifact may contradict higher-precedence definitions from this seed and machine contracts.

---

## 16. Acceptance criterion for this seed
This seed is complete when downstream canonical artifacts can be generated with:
- no ambiguity in actor/key semantics,
- deterministic policy behavior,
- explicit governance and lifecycle controls,
- comprehensive provenance obligations,
- testable and traceable contract alignment.
