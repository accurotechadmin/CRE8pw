# CRE8 Next-Model Base Inventory (ID/Utility Keypair-Centric)

_Status: draft working inventory for replacement docset authoring_  
_Date (UTC): 2026-04-29_

## 1) Purpose and scope
This inventory is the **primary base model** for authoring a fresh SSOT-aligned CRE8 document set that preserves all critical canon constraints while shifting the core identity and access model to:

- **Credential (ID) Keys**: minted as Private/Public keypairs and representing durable principal identity.
- **Utility (Access) Keys**: additional Private/Public keypairs minted under a Credential Key for service/context-specific access.
- **Audience Groups**: reusable collections of Public Use Keys for post-level access control.
- **Keychains**: compositional aggregated-permission keys derived from other keys.

This inventory intentionally preserves the current system’s non-negotiables (envelope-first contracts, separated auth contexts, PDP determinism, traceability/evidence governance) and remaps them to the new keypair-first model.

---

## 2) Canon invariants that must remain unchanged

### 2.1 SSOT authority and precedence
- OpenAPI + envelope schemas are top authority for interface behavior.
- SSOT canon (`docs/ssot_canon/*`) remains normative over execution/onboarding narratives.
- Any conflict must be resolved by precedence with explicit logged rationale.

### 2.2 Runtime architecture invariants
- Surface split remains strict:
  - Public/bootstrap routes
  - Gateway routes (`/api/*`)
  - Console routes (`/console/api/*`)
- Gateway and Console auth contexts remain non-interchangeable.
- Route registration remains partitioned by surface.

### 2.3 Contract and error invariants
- Envelope-first response semantics remain mandatory for success and error.
- Deterministic policy denies, stable detail codes, and correlation-ready failures remain mandatory.
- Resource-specific `404` semantics remain distinct from route/template misses.

### 2.4 Authorization invariants
- PDP (policy decision path) remains canonical enforcement point.
- No ad-hoc permission logic in handlers.
- Delegation bounds (permission/scope/depth/expiry) remain hard constraints.
- Existing use-key restrictions and owner-only governance constraints remain preserved unless explicitly changed in synchronized decision tables.

### 2.5 Governance and evidence invariants
- Verification-gated delivery remains required.
- Traceability updates required alongside behavior changes.
- Operational readiness and security-abuse verification remain release gates.

---

## 3) New key model (central replacement)

## 3.1 Key taxonomy
1. **Credential Key (ID Key)**
   - First minted key for `primary_author`, `secondary_author`, or `use` principal identity.
   - Has Private/Public keypair.
   - Serves as durable lineage root for descendant Utility Keys and policy provenance.
   - Private/Public components rotatable with continuity controls.

2. **Utility Key (Access Key)**
   - Additional keypairs minted by Credential Keys for specific contexts/services/devices/clients.
   - Treated as operational access credentials.
   - Shorter lifecycle and higher turnover expected.
   - Fully linked to parent Credential Key lineage for governance and blast-radius control.

3. **Keychain Key**
   - Aggregated-permission key derived by combining existing authorized keys (subject to constraints).
   - Must preserve current anti-nesting and class-safety invariants unless canon explicitly revises them.

4. **Master/SYSADMIN key domain**
   - Remains console-governed with explicit restrictions and deny semantics.
   - Must never become gateway-usable.

## 3.2 Keypair representation strategy
- Prefer asymmetric request signing model:
  - Request includes public key id + nonce + timestamp + signature.
  - Server verifies signature against stored public material.
  - Replay prevention enforced via nonce/timestamp windows.
- Transitional compatibility path can coexist for migration if explicitly versioned.

## 3.3 Rotation model
- Both Credential and Utility keypairs support rotate/suspend/revoke.
- Rotation must preserve principal lineage/audit continuity.
- Revocation must propagate deterministically to descendants according to policy mode (hard/soft inheritance rules to be specified in new authorization tables).

---

## 4) Normative lifecycle/use-case model (to be encoded in new canon)

1. **Owner invitation and owner registration**
   - Owner A invites Owner B.
   - Owner B registers with username/email/password and enters console owner context.

2. **Primary Author Credential Key minting**
   - Owner B mints Primary Author Credential Keypair (private shown once + first public).

3. **Credential sharing/delegation onboarding**
   - Owner B can transfer key material to Person C through secure channel patterns (email utility optional but must include explicit security posture and provenance capture).

4. **Use Credential/Utility minting by delegated actors**
   - Person C uses delegated authority to mint Use keys (Credential and/or Utility forms per policy).

5. **Post authoring with audience assignment**
   - Person C creates post and grants access via:
     - direct Public Use Keys,
     - Audience Group(s),
     - Keychain-derived entitlements.

6. **Comment/read access enforcement**
   - Access to post/comments enforced by resolved entitlements from direct keys + audience groups + keychains under canonical PDP evaluation.

---

## 5) Audience Groups model (new core domain)

## 5.1 Definition
Audience Group = named collection of Public Use Keys used as reusable ACL target for posts.

## 5.2 Group governance modes
Each group declares a membership policy mode:
- **Author-managed**: only group owner/author can add/remove members.
- **Request-to-join**: external keys request membership; author/moderator approves.
- **Open-join**: eligible keys auto-join based on policy constraints.

## 5.3 Group policy controls
- Membership eligibility filters (key class, lifecycle state, scope constraints).
- Rate limits/abuse controls on join requests.
- Optional moderator/secondary-author delegated management.
- Full audit trail on membership mutation.

## 5.4 Post linkage
- Posts can target one or more Audience Groups.
- Effective access = union of explicit key ACL + linked group members + applicable keychain resolution, constrained by deny-overrides and lifecycle checks.

---

## 6) Keychains in the new model
- Preserve concept as aggregated permission mechanism.
- Reconcile with Credential vs Utility distinction:
  - Keychains should aggregate Utility entitlements by default.
  - Credential Keys may be included only if explicitly allowed by policy.
- Keep explicit guardrails:
  - no forbidden class composition,
  - bounded membership cardinality,
  - deterministic effective-permission resolution.
- Add provenance snapshots for each keychain resolution outcome.

---

## 7) Descendant governance and minter controls

Key minters must be able to:
- List descendant keys by depth/type/class/lifecycle.
- View usage telemetry and access events by descendant key.
- Suspend/revoke/rotate descendant keys within delegation bounds.
- Apply emergency freeze to a subtree (Credential + attached Utility keys).
- Execute scoped remediation (e.g., rotate Utility keys for one service context only).

Required constraints:
- Actions bounded by lineage depth and permission envelope.
- Owner override paths remain console-governed.
- All destructive actions produce immutable provenance records.

---

## 8) Provenance and event logging model (expanded)

## 8.1 Event classes
- Key minted (credential/utility/keychain)
- Key shared/exported
- Key rotated/suspended/revoked/reactivated
- Audience group created/updated/deleted
- Group join requested/approved/rejected/auto-admitted
- Post ACL changed (direct keys/groups/keychains)
- Access decisions (allow/deny with rule-family evidence)
- Security anomalies (signature failure, replay detected, device mismatch, impossible lineage)

## 8.2 Event envelope requirements
Every event should include at minimum:
- event_id, event_type, timestamp_utc
- request_id/correlation_id
- actor_public_key_id (or owner principal id)
- target entity id(s)
- lineage snapshot and delegation envelope snapshot
- decision outcome + detail code
- provenance hash/chain pointer (if chain integrity strategy adopted)

## 8.3 Queryability and retention
- High-cardinality search by actor/descendant/post/group/time.
- Retention + archival policy with tamper-evidence guarantees.
- Exportable evidence bundles for compliance/incident review.

---

## 9) Capability inventory remap from existing canon

## 9.1 Foundation/governance docs to carry forward
- Core identity and value proposition (reworded for keypair identity).
- Technical foundation/dependency baseline (Composer stack unchanged unless explicitly revised).
- SSOT governance, change control, doc templates.

## 9.2 Product/architecture docs to carry forward
- Architecture and surfaces model.
- Middleware pipeline and fail-closed ordering.
- BFF-by-surface/CQRS-lite orchestration boundaries.

## 9.3 Contract docs to rewrite around keypairs
- API contract guide + route inventory.
- Authorization/delegation spec + decision tables.
- Error catalog with new cryptographic and audience-group codes.
- Endpoint examples and usage scenarios updated with Credential/Utility flows.

## 9.4 Data/security docs to evolve
- Data model spec/reference/ERD for:
  - Credential keys,
  - Utility keys,
  - keypair metadata,
  - audience groups and memberships,
  - key lineage graph,
  - provenance events.
- Security controls and threat model updates for key distribution, replay, credential leakage, group abuse, and descendant compromise.

## 9.5 Operations/quality docs to evolve
- Verification strategy extended with signature, nonce/replay, rotation, descendant governance, and audience-group authorization tests.
- Health contracts include cryptographic verifier and provenance pipeline health checks.
- SLO/SLI updates for authorization latency and key-event ingestion reliability.

## 9.6 Traceability/automation docs to evolve
- Traceability matrix rows for all new capabilities and controls.
- SSOT automation checks expanded to validate keypair contract parity and audience-group rule tables.

## 9.7 Decisions/program docs to evolve
- ADRs for keypair-first identity, credential-vs-utility split, audience-group policy modes, descendant governance semantics, and event integrity strategy.
- Workflow and definition-of-done criteria updated for cryptographic compatibility evidence.

---

## 10) Required API/domain additions in the new docset

## 10.1 Console governance route families (expected)
- Credential key mint/rotate/revoke/suspend/resume
- Utility key mint/rotate/revoke/suspend/resume
- Descendant tree inspect/filter/manage
- Audience group CRUD + mode config + moderation
- Group membership requests/approvals/auto-join controls
- Keychain compose/resolve/audit

## 10.2 Gateway route impacts
- Auth proof format for keypair-based requests
- Post create/edit ACL extensions for key ids/group ids/keychain ids
- Comment/read authorization based on resolved effective audience entitlements

## 10.3 Compatibility and versioning
- Explicit migration policy:
  - legacy key support window,
  - dual-mode auth behavior,
  - deprecation and sunset dates,
  - client upgrade requirements.

---

## 11) Security control inventory for new model
- One-time private key reveal with secure handling UX.
- Optional secure handoff workflow replacing plain-text sharing patterns.
- Mandatory replay protections (nonce + timestamp bounds).
- Key compromise response workflows (subtree revocation + rapid reissue).
- Audience group abuse controls (spam joins, malicious mass-add, privilege creep).
- Device-binding compatibility with keypair auth where required by route policy.

---

## 12) Verification and evidence inventory (must be in new docs)
- Contract parity tests (OpenAPI + schemas + examples).
- PDP decision-table determinism tests for all actor/key/group scenarios.
- Cryptographic verification tests (valid/invalid signatures, key rotation transitions).
- Replay and timestamp skew tests.
- Descendant governance permission-boundary tests.
- Keychain resolution correctness tests.
- Audience group membership mode tests.
- End-to-end provenance completeness tests.
- Operational smoke tests for health/degraded/fail states.

---

## 13) Known design decisions to formalize in new ADRs
1. Credential vs Utility key semantic split and lifecycle.
2. Whether Utility keys may mint further Utility keys and under what depth limits.
3. Whether rotation of Credential key invalidates all attached Utility keys immediately or by policy mode.
4. Audience group open-join anti-abuse controls and moderation semantics.
5. Keychain composition boundaries with Credential keys.
6. Provenance integrity implementation (hash-chain, signed logs, or external attestations).

---

## 14) Authoring checklist for the fresh docset
1. Update machine artifacts first (OpenAPI + envelope/schema dependencies).
2. Rewrite authorization spec + decision tables with keypair + audience-group + descendant governance paths.
3. Update error catalog with new detail-code families.
4. Update data/security docs and threat controls.
5. Update operations/verification/acceptance docs.
6. Update traceability matrix and impact maps.
7. Add ADRs and migration/versioning policy.
8. Attach evidence templates and validation outputs.

---

## 15) Deliverable intent
This inventory is the **base model** for generating the new canonical CRE8 documentation set around:
- ID (Credential) Private/Public keypairs,
- Utility (Access) Private/Public keypairs,
- Audience Groups,
- Keychains,
- Descendant key governance,
- Comprehensive provenance/event logging,
while retaining all existing CRE8 governance, contract, and operational rigor.
