---
doc_id: CRE8-IDPOL-PERMISSION-VOCAB
version: 1.3.1
status: normative
owner: Identity & Policy WG
reviewers:
  - Platform Architecture WG
  - API Contracts WG
last_reviewed_utc: 2026-05-05
next_review_due_utc: 2026-07-30
source_seed_refs:
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
normative_dependencies:
  - docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md
---

# Permission Vocabulary

## Purpose

Define the **canonical permission token registry** for CRE8 PDP evaluation and delegation envelopes, including route-inventory reconciliation, explicit legacy-alias normalization, and candidate capabilities promoted from the non-normative brainstorm [`DRAFT_KEY_MINTING_PERMISSION_LATTICE.md`](./DRAFT_KEY_MINTING_PERMISSION_LATTICE.md); reconcile authoritative behavior here—the draft alone is never law.

**CRE8-IDPOL-REQ-0029**: Every externally declared `required_permission` token in [`ROUTE_INVENTORY_REFERENCE.md`](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md) **MUST** appear either as a `token` in §Canonical permission registry or as a `legacy_alias` in §Deprecated and legacy alias registry. Drift toward canonical successor labels **MUST** be coordinated with routes, machine contracts, and [`TRACEABILITY_MATRIX.md`](../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md) per [`CHANGE_CONTROL_POLICY.md`](../00_governance/CHANGE_CONTROL_POLICY.md).

**CRE8-IDPOL-REQ-0030**: Every **effective mint or delegation envelope** (including envelopes attached to **`principal.primary_author`**, **`principal.secondary_author`**, and **`principal.use_key`** principals) **MUST** expose a **deterministic provisioning policy surface** modeled as structured fields—not as ad hoc literals—whose allowed keys and numeric bounds **MUST** be constrained by **the intersection** of (a) the minter's held capability tokens under §Lineage issuance, navigation, provisioning policy templates, descendant caps, delegation topology, §Permission templates / provisioning meta, §Delegation grants, §Keychains, §Owner console, and sibling domains, (b) any **mandatory-lock** provisioning tokens the ancestor bound (for example **`permission.provisioning.secondary_author.issue_locked_template`**), and (c) platform invariants (**“cannot grant beyond envelope”**, **explicit deny precedence** per [`AUTHORIZATION_AND_DELEGATION_SPEC.md`](./AUTHORIZATION_AND_DELEGATION_SPEC.md)). PDP **MUST** reject issuance or delegation mutations whose policy surface would violate that intersection. Enforcement dependency: `php-di/php-di` composition and **`composer test:contract:lifecycle`** / **`composer test:contract:auth`** as extended for provisioning fixtures (**target automation**).

**CRE8-IDPOL-REQ-0031**: Operators **SHOULD NOT** overload HTTP `required_permission` route entries with provisioning-only tokens; lineage navigation, descendant caps, and template-lock semantics **SHOULD** be enforced via PDP evaluation of the **Policy Evaluation Context** ([`CANONICAL_TERMINOLOGY.md`](../10_product_and_architecture/CANONICAL_TERMINOLOGY.md); see also [`AUTHORIZATION_DECISION_TABLES.md`](./AUTHORIZATION_DECISION_TABLES.md)) and persisted envelope/policy fields keyed by identifiers registered in §Canonical permission registry **when** lineage metadata schemas are normative (`docs/40_*` data model family). When a provisioning token **is** surfaced on routes, **`CRE8-IDPOL-REQ-0029`** still applies (**token or `legacy_alias`**).

## Normative requirements

- **CRE8-IDPOL-REQ-0001**: Every permission token used by CRE8 policy evaluation **MUST** use `<segment>.<segment>.<action>` lower-case dot notation with **at least three** dot-separated segments and **MUST** be registered in §Canonical permission registry (or reachable only via §Deprecated and legacy alias registry normalization into a successor token). Enforcement dependency: `respect/validation` token-shape validation and contract coverage (`phpunit/phpunit` suites as wired).
- **CRE8-IDPOL-REQ-0002**: PDP inputs **MUST** classify each permission reference as **(a)** a canonical §Canonical permission registry token, **(b)** a documented `legacy_alias`, or **(c)** unknown. Unknown tokens **MUST** deny with **`AUTH_DENY_PERMISSION_UNKNOWN`** and **MUST NOT** apply undocumented implicit synonyms. Enforcement dependency: `slim/slim` middleware deny mapping and **`composer test:contract:auth-reasons`**.
- **CRE8-IDPOL-REQ-0028**: Policy evaluation **MUST** normalize each `legacy_alias` to exactly one documented **`successor_token`** before executing the PDP gate sequence in [`AUTHORIZATION_DECISION_TABLES.md`](./AUTHORIZATION_DECISION_TABLES.md); normalization **MUST NOT** widen granted scope versus evaluating the successor token alone. Enforcement dependency: **`composer test:contract:auth`** and **`composer test:contract:auth-reasons`** when fixtures assert alias paths (extend fixtures when routes still emit aliases).
- **CRE8-IDPOL-REQ-0003**: Grants inherited through delegation **MUST** normalize to canonical successor tokens before intersection; unresolved or unknown inherited tokens **MUST** be discarded as deny-evaluable gaps. Enforcement dependency: `php-di/php-di` policy composition and **`composer test:contract:lifecycle`** where applicable.
- **CRE8-IDPOL-REQ-0004**: Runtime permission resolution **SHOULD** treat tokens as case-sensitive canonical strings (no case folding).
- **CRE8-IDPOL-REQ-0005**: Growth of this registry **SHOULD** land in the same change set as related route/OpenAPI updates when feasible; interim drift **MUST** remain bounded by §Deprecated and legacy alias registry classifications (**`backward-compatible`**, **`conditionally-compatible`**, or **`breaking`** per [`CHANGE_CONTROL_POLICY.md`](../00_governance/CHANGE_CONTROL_POLICY.md)).
- **CRE8-IDPOL-REQ-0029**: Every Phase 1 `required_permission` value in [`ROUTE_INVENTORY_REFERENCE.md`](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md) **MUST** appear as **`token`** or **`legacy_alias`** in this document. Enforcement dependency: manual governance review plus **`composer docs:ssot:route-parity`** as applicable.

### Cross-reference: Principal capability matrix binding

Intrinsic (non-delegated-only) posture for principal taxonomy rows stays enumerated in [`PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](./PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md). **Every new canonical token participating in intrinsic `ALLOW` matrix bindings** (**CRE8-IDPOL-REQ-0006**, **CRE8-IDPOL-REQ-0007**) **MUST** receive matching matrix deltas in the same governance batch (**no orphan `ALLOW`** rows).

---

## Canonical permission registry

The tables below augment the Phase 1 registry without removing prior identifiers. **Operational permission tokens** (HTTP route `required_permission` candidates) occupy the first domains; **provisioning-policy tokens** constrain what may appear inside mint/delegation envelopes and **typically SHOULD NOT** appear on route ACL rows (**`CRE8-IDPOL-REQ-0031`**).

### Human-visible principal strata vs PDP modeling

Human product strata (**Owner**, **Primary Author**, **Secondary Author**, **Use Principal**) correspond to PDP actor classes per [`PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](./PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md): **Owner** governance maps to **`ROOT_ADMIN`**/**`TENANT_ADMIN`**, authoring keys map to **`IDENTITY_OPERATOR`** and **`DELEGATEE`** postures depending on delegated envelope, Utility agents remain **`UTILITY_AGENT`**.

| Stratum | UI mint posture (typical) | Normative PDP note |
|---|---|---|
| **Owner console** | Mints **`principal.primary_author.*`** lineage roots only | Owner **SHOULD NOT** receive direct UI affordances to mint **`principal.secondary_author`** or **`principal.use_key`** children bypassing Primaries (**product constraint**); lineage expansion for Secondaries and Uses **occurs beneath issued Primaries**. |
| **Primary Author Key** | May mint **`principal.secondary_author`**, **`principal.use_key`**, and **additional `principal.primary_author`** when envelope includes `principal.primary_author.mint` | Envelope depth, caps (**§Issuance topology caps vs delegation depth**) and forbidden-class rules still apply (**cannot grant beyond ancestor**).
| **Secondary Author Key** | May mint **`principal.use_key`** and optionally nested **`principal.secondary_author`** when `principal.secondary_author.mint_nested_secondary` is granted | Narrower provisioning surface than Primary by default (**`CRE8-IDPOL-REQ-0030`**).
| **Use Principal / Use Key** | **MUST NOT** mint Primary/Secondary/Use principals; MAY operate **`keychain.*`** aggregates | Capability matrix + envelope intersection enforce class boundaries.

---

### Principals — identity material, lifecycle, routing inventory carry-over

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| principal | actor | create | `principal.actor.create` | tenant | Create or register a descendant principal (**generic** lineage registration; aligns with **`POST /v1/principals`** inventory alias `principal.create`).
| principal | actor | delete | `principal.actor.delete` | tenant | Tombstone/delete principals (**high privilege**).
| principal | primary_author | mint | `principal.primary_author.mint` | tenant | Mint a Primary Author-capable descendant key line.
| principal | secondary_author | mint | `principal.secondary_author.mint` | tenant | Mint a Secondary Author beneath an authorized authoring principal.
| principal | secondary_author | mint_nested_secondary | `principal.secondary_author.mint_nested_secondary` | tenant | Permit Secondary Authors to mint **additional** Secondary Authors (**default deny** absent token).
| principal | use_key | mint | `principal.use_key.mint` | tenant | Mint a runtime Use Principal / Use Key (**non-authoring automation surface**).
| principal | profile | read | `principal.profile.read` | tenant/resource | Inspect principal profile metadata.
| principal | profile | update | `principal.profile.update` | tenant/resource | Update principal profile metadata.
| principal | lifecycle | suspend | `principal.lifecycle.suspend` | tenant/resource | Suspends principal lineage subject to ancestry rules.
| principal | lifecycle | resume | `principal.lifecycle.resume` | tenant/resource | Resumes suspended principal.
| principal | inventory | search | `principal.inventory.search` | tenant | Enumerate/query principals (**replaces ambiguous `principal.search`** noun).
| principal | id_keypair | issue | `principal.id_keypair.issue` | tenant/resource | Attach lineage-root ID material (HTTP `POST /v1/keys/id`).
| principal | id_keypair | rotate | `principal.id_keypair.rotate` | resource | Rotate ID key material (**paired with lifecycle routes**).
| principal | id_keypair | revoke | `principal.id_keypair.revoke` | resource | Revoke ID lineage anchor when policy permits destructive collapse.
| principal | utility_keypair | issue | `principal.utility_keypair.issue` | resource | Mint utility/proxy credential for client apps (**HTTP `/v1/keys/utility`**).
| principal | utility_keypair | rotate | `principal.utility_keypair.rotate` | resource | Rotate utility key material within authorized scope.
| principal | utility_keypair | revoke | `principal.utility_keypair.revoke` | resource | Revoke utility credentials.

---

### Principals — lineage navigation (dashboard/tree)

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| principal | lineage | tree_navigate_dashboard | `principal.lineage.tree_navigate_dashboard` | tenant | Owner / operator dashboards: expand nested lineage views for roots the actor governs (**read-only lineage navigation** minus secret-bearing surfaces).
| principal | lineage | node_profile_read | `principal.lineage.node_profile_read` | resource | Inspect non-secret lineage node attributes (titles, statuses, ancestry pointers) beneath authorized roots.
| principal | lineage | node_policy_read_masked | `principal.lineage.node_policy_read_masked` | resource | Inspect **effective provisioning policy previews** (**redacted** fields per operator policy **and** descendant privacy tiers).
| principal | lineage | node_relationship_graph_read | `principal.lineage.node_relationship_graph_read` | tenant/resource | Read DAG edges (**parent ⇄ child principal classes**) needed for accordion/tree rendering (**no private key payloads**).
| principal | lineage | node_effective_permissions_read | `principal.lineage.node_effective_permissions_read` | resource | Inspect normalized effective permission sets resolved for a lineage node (**debug/governance** without secret material).
| principal | lineage | node_grant_summary_read | `principal.lineage.node_grant_summary_read` | tenant/resource | Inspect aggregated descendant grant posture (**counts, depth usage, expiry bands**) for governance workflows.

---

### Lineage issuance — policy templates locks (per descendant class)

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| permission | provisioning | primary_author_issue_locked_template | `permission.provisioning.primary_author.issue_locked_template` | tenant/resource | Permit binding **incoming Primary Author issuance** exclusively to enumerated template IDs (**prevents curator free-hand** overrides below owner caps).
| permission | provisioning | secondary_author_issue_locked_template | `permission.provisioning.secondary_author.issue_locked_template` | tenant/resource | Lock Secondary mint paths to curated templates (**Owner → Primary ergonomics example**).
| permission | provisioning | use_key_issue_locked_template | `permission.provisioning.use_key.issue_locked_template` | tenant/resource | Lock Use Principal mint outcomes to enumerated templates (**per Secondary cap example** rides alongside numeric caps §Issuance topology caps).
| permission | provisioning | keychain_aggregate_issue_locked_template | `permission.provisioning.keychain_aggregate.issue_locked_template` | resource | Force Keychain / Keychain API credential bundles to originate from enumerated templates (**Use strata** knob).

---

### Lineage issuance — topology caps (**active counts** vs **principal-depth** ceilings)

Implementations **MUST** materialize envelope fields keyed by stable identifiers derived from these tokens (see **`CRE8-IDPOL-REQ-0030`**). **`active`** principals **exclude** revoked/tombstone states per [`DATA_MODEL_SPEC.md`](../40_data_security_and_crypto/DATA_MODEL_SPEC.md); suspended principals **SHOULD NOT** increment active counts unless product policy explicitly says otherwise (**document envelope field semantics** separately).

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| issuance | cap | primary_author_active_max_per_owner_scope | `issuance.cap.primary_author.active_max_per_owner_scope` | tenant/global | Bounds **simultaneously active Primary Author lineage roots** the Owner governance actor may sponsor (**dashboard-only mint posture** aligns with provisioning surface **`CRE8-IDPOL-REQ-0030`**).
| issuance | cap | secondary_active_max_per_primary | `issuance.cap.secondary_author.active_max_per_primary` | tenant/resource | Caps **simultaneously active Secondary Authors** spawned **directly** under **each Primary** lineage segment (counts reset only via lifecycle transitions).
| issuance | cap | use_active_max_per_secondary | `issuance.cap.use_key.active_max_per_secondary_author` | tenant/resource | Example: **≤ 2 Use Keys active per Secondary Author** (**owner-configured** ceiling).
| issuance | cap | use_active_max_per_primary | `issuance.cap.use_key.active_max_per_primary_author` | tenant/resource | Bounds Use Principals summed across descendants when policy requires aggregated throttles (**optional** choke).
| issuance | cap | nested_secondary_active_max_per_secondary | `issuance.cap.secondary_author.nested_active_max_per_secondary` | tenant/resource | Secondary→Secondary nested fan-out throttle when `principal.secondary_author.mint_nested_secondary` is honored.
| issuance | cap | nested_secondary_depth_max_below_primary | `issuance.cap.secondary_author.nested_depth_max_below_primary` | tenant/resource | Maximum Secondary-on-Secondary hop depth below a Primary lineage root (**distinct from delegation grant hops** §Delegation topology complements).
| issuance | cap | nested_secondary_depth_max_global | `issuance.cap.secondary_author.nested_depth_max_global` | tenant | Tenant-wide Secondary nesting depth (**operator safety**) intersecting descendant envelopes.

---

### Permission templates — CRUD plus promotion

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| permission | template | create | `permission.template.create` | tenant | Persist named issuance/delegation templates referenced by provisioning locks (**§Lineage issuance — policy templates locks**).
| permission | template | read | `permission.template.read` | tenant | Inspect template bodies permitted to caller (**may be masked** downstream).
| permission | template | update | `permission.template.update` | tenant | Modify template definitions subject to tenancy governance.
| permission | template | delete | `permission.template.delete` | tenant | Retire unused templates (**must not resurrect revoked principals** implicitly).
| permission | template | clone | `permission.template.clone` | tenant | Fork an existing template into a new draft while preserving source provenance references.
| permission | template | archive | `permission.template.archive` | tenant | Mark template inactive for new issuance while retaining audit/history references.
| permission | template | apply | `permission.template.apply` | tenant | Permit template application during descendant issuance (**mutually exclusive subsets** enforced by PDP intersections).
| permission | template | promote | `permission.template.promote` | tenant | Publish template revisions as tenant-default bundles (**elevated issuance governance**).

### Permission provisioning meta (mint modes plus envelope meta editors)

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| permission | provisioning | mint_mode_curated | `permission.provisioning.mint_mode_curated` | tenant/resource | Permit **curated** issuance (explicit allow subsets) respecting ancestor envelope ceilings.
| permission | provisioning | mint_mode_full | `permission.provisioning.mint_mode_full` | tenant/resource | Permit **bounded full envelope** issuance (still subset of ancestor **and** issuance caps §Lineage issuance — topology caps).
| permission | provisioning | mint_meta_grant | `permission.provisioning.mint_meta_grant` | tenant/resource | Permit editing descendant **meta-fields** (**caps**, template locks, additional mint permissions) during issuance (**high privilege subset**).

---

### Delegation topology complements (**grant hop budgets** intersect lineage depth)

Delegation hop caps remain distinct from Secondary nesting depth (**two enforcement planes** intersect per **`CRE8-IDPOL-REQ-0030`**).

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| delegation | grant | create | `delegation.grant.create` | resource | Establish bounded delegation envelopes.
| delegation | grant | revoke | `delegation.grant.revoke` | resource | Revoke active grants (**HTTP alias `delegation.revoke`** maps here).
| delegation | grant | inspect | `delegation.grant.inspect` | tenant/resource | Read delegation graph / metadata (**HTTP inspect surfaces** reuse same PDP checks).
| delegation | grant | list | `delegation.grant.list` | tenant/resource | Enumerate grants with lifecycle/scope filters for operational governance and incident response.
| delegation | topology | depth_set_max | `delegation.topology.depth_set_max` | tenant/resource | Caps **delegation-grant descendant hops** (**alias `delegation.depth.set_max`**).
| delegation | topology | expiry_set_max | `delegation.topology.expiry_set_max` | tenant/resource | Caps latest expiry for descendant grants (**alias `delegation.expiry.set_max`**).
| delegation | topology | width_set_max | `delegation.topology.width_set_max` | tenant/resource | Caps **maximum parallel active descendant grants** a principal may stand up (**orthogonal to issuance caps**).
| delegation | scope | transferable_subset_define | `delegation.scope.transferable_subset_define` | resource | Permit shaping which capability tokens survive delegation replication (**narrowing-only** invariant).

---

### Credentials — key lifecycle (HTTP-aligned)

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| credential | key | lifecycle_suspend | `credential.key.lifecycle.suspend` | resource | Applies `suspend` via `/v1/keys/{key_id}/lifecycle/suspend` (**legacy `key.lifecycle.suspend`**).
| credential | key | lifecycle_revoke | `credential.key.lifecycle.revoke` | resource | Applies `revoke` via lifecycle revoke routes (**legacy `key.lifecycle.revoke`**).
| credential | key | lifecycle_rotate | `credential.key.lifecycle.rotate` | resource | Applies `rotate` (**legacy `key.lifecycle.rotate`**).

---

### Policy decision endpoints

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| authz | decision | simulate | `authz.decision.simulate` | resource | Hypothetical PDP evaluation (**legacy `authz.simulate`**).
| authz | decision | invoke | `authz.decision.invoke` | resource | Calls live PDP endpoint (**legacy `authz.decide`** / route inventory alignment).

---

### Owner console complements — settings, lineage governance, integrations

These tokens tighten **tenant-level governance** surfaced inside Owner dashboards (distinct from PDP route ACLs **`CRE8-IDPOL-REQ-0031`**).

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| owner | settings | read | `owner.settings.read` | tenant | Inspect tenant-visible configuration payloads Owners may review before minting constrained Primaries.
| owner | settings | update | `owner.settings.update` | tenant | Mutate bounded tenant knobs governing issuance defaults (**must remain subset of ROOT/TENANT admin envelope**).
| owner | lineage | provision_policy_publish | `owner.lineage.provision_policy_publish` | tenant | Publish owner-authored provisioning bundles (often template + cap combos) destined for descendant Primaries.
| owner | api_credentials | manage | `owner.api_credentials.manage` | tenant | Manage operator integration credentials surfaced in drafts (**distinct label from credential bootstrap path** **`owner.credential.manage`** remains).
| owner | billing | read | `owner.billing.read` | global | Inspect billing artefacts (**commercial optional surface**).
| owner | billing | manage | `owner.billing.manage` | global | Modify billing artefacts (**elevated finance posture**).
| owner | console | access | `owner.console.access` | global | Admit actor to Owner Console shell routing bundle.
| owner | credential | manage | `owner.credential.manage` | tenant | Manage bootstrap / break-glass credentials separate from authoring keys issued to Primaries.

---

### Content domain

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| content | post | create | `content.post.create` | group/resource | Publish posts subject to delegated visibility.
| content | post | read | `content.post.read` | group/resource | Read posts subject to targeting and visibility.
| content | post | read_own | `content.post.read_own` | resource | Read posts constrained to author's own corpus (**narrow mint preset**).
| content | post | update | `content.post.update` | resource | Mutate arbitrary in-scope posts (moderator-style when policy allows broad scope).
| content | post | update_own | `content.post.update_own` | resource | Restrict edit rights to author's own authored posts (**friend/client safe default**).
| content | post | delete | `content.post.delete` | resource | Hard delete/tombstone in scope.
| content | post | delete_own | `content.post.delete_own` | resource | Delete only author's content (**narrow mint preset**).
| content | post | pin | `content.post.pin` | resource | Featured/pinned placement (**product optional**).
| content | post | lock | `content.post.lock` | resource | Freeze thread / disable comments (**product optional**).
| content | crosspost | create | `content.crosspost.create` | group/resource | Duplicate content across scopes (**optional product**).

---

### Content — comments, reactions, attachments, link previews

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| content | comment | create | `content.comment.create` | resource | Attach comments/interactions where feed policy allows.
| content | comment | read | `content.comment.read` | resource | Enumerate/read comment threads (**HTTP GET comments** symmetry).
| content | comment | update | `content.comment.update` | resource | Edit existing comment bodies when policy binds author-edit vs moderator-edit obligations to this token scope.
| content | comment | delete | `content.comment.delete` | resource | Delete or tombstone comment bodies (**narrow revoke path where applicable**).
| content | comment | moderate | `content.comment.moderate` | resource | Holds, visibility, interaction enforcement (**moderators**).
| content | reaction | create | `content.reaction.create` | resource | Add lightweight reactions (**optional social layer**).
| content | reaction | delete | `content.reaction.delete` | resource | Remove reactions authored by caller context.
| content | attachment | upload | `content.attachment.upload` | resource | Upload binary attachments tied to posts/comments.
| content | attachment | delete | `content.attachment.delete` | resource | Remove attachments in scope.
| content | link | preview_fetch | `content.link.preview_fetch` | resource | Server-side link preview harvesting (**supply abuse-controls at integration layer**).

---

### Audience and feed domains

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| audience | group | manage | `audience.group.manage` | tenant/resource | Audience group CRUD plus membership mutations; aligns with [`AUDIENCE_GROUP_SPEC.md`](../50_content_audience_and_feed/AUDIENCE_GROUP_SPEC.md).
| audience | group | view | `audience.group.view` | tenant/group | Read audience metadata and enumerated membership surfaces.
| audience | group_membership | add | `audience.group_membership.add` | resource | Add principals to curated groups (**narrow grant**).
| audience | group_membership | remove | `audience.group_membership.remove` | resource | Remove members from curated groups.
| audience | label | assign | `audience.label.assign` | resource | Attach audience taxonomy labels / targeting metadata.
| audience | targeting | restrict | `audience.targeting.restrict` | tenant/resource | Limit targeting dimensions delegated keys may invoke (**operator safety**).
| feed | stream | view | `feed.stream.view` | group | Page authorized feed timelines.
| feed | stream | curate | `feed.stream.curate` | group | Ranking / curation overlays (**elevated**).
| feed | subscription | manage | `feed.subscription.manage` | tenant/group | Follow/unfollow / regenerate memberships.
| feed | snapshot | export | `feed.snapshot.export` | tenant/group | Export feed snapshots (**compliance portability** optional).

---

### Notifications and moderation domains

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| notification | inbox | read | `notification.inbox.read` | tenant/resource | Read notification inbox / stream (**friendly keys minimal surface**).
| notification | preference | manage | `notification.preference.manage` | tenant/resource | Control delivery categories and interruption policies.
| moderation | report | submit | `moderation.report.submit` | resource | Submit abuse/policy reports (**community safety**).
| moderation | queue | resolve | `moderation.queue.resolve` | tenant/global | Trusted resolver workflow (**elevated**).
| moderation | actor | restrict | `moderation.actor.restrict` | tenant/resource | Temporary interaction restrictions without full suspension.
| moderation | content | visibility_hide | `moderation.content.visibility_hide` | resource | Restrict visibility without deleting underlying content.
| moderation | content | visibility_restore | `moderation.content.visibility_restore` | resource | Reverse visibility_hide outcomes.

---

### Integration, onboarding, device, and keychain domains

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| integration | webhook | manage | `integration.webhook.manage` | tenant | Register webhook endpoints/transformers.
| integration | webhook | read | `integration.webhook.read` | tenant | Inspect deliveries/logs.
| integration | webhook | rotate_secret | `integration.webhook.rotate_secret` | tenant/resource | Rotate webhook signing material without deleting endpoint metadata.
| integration | api_rate_limit | exempt | `integration.api_rate_limit.exempt` | tenant | Bypass standard API rate envelopes (**high risk**; **`security-impacting`** default posture).
| credential | invite | issue | `credential.invite.issue` | tenant | Invite links/codes for bounded onboarding.
| credential | invite | revoke | `credential.invite.revoke` | tenant/resource | Invalidate outstanding invites.
| credential | device | register | `credential.device.register` | tenant | Register devices/hardware-bound bindings.
| credential | device | revoke | `credential.device.revoke` | resource | Remote wipe / detach device binding.
| keychain | collection | create | `keychain.collection.create` | resource | Compose multi-key aggregates (**Use Principals typical**).
| keychain | collection | read | `keychain.collection.read` | resource | Inspect membership/metadata.
| keychain | collection | update | `keychain.collection.update` | resource | Attach/detach member keys respecting lineage rules.
| keychain | collection | delete | `keychain.collection.delete` | resource | Delete aggregate plus revoke derivatives.
| keychain | api_credential | issue | `keychain.api_credential.issue` | resource | Derived credential (**union projection** within policy bindings).
| keychain | api_credential | rotate | `keychain.api_credential.rotate` | resource | Rotate derived credential.
| keychain | api_credential | revoke | `keychain.api_credential.revoke` | resource | Revoke derived credential.
| keychain | api_credential | restrict_permissions | `keychain.api_credential.restrict_permissions` | resource | Subset tightening on issuance (**least privilege companion**).

---

### Audit compliance and observability domain

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| audit | event | read | `audit.event.read` | global | Interactive audit querying (**privileged** consumption).
| audit | event | integrity_verify | `audit.event.integrity_verify` | global | Verify hash/signature integrity of audit events for forensic and compliance workflows.
| audit | export_job | request | `audit.export_job.request` | global | Async CSV/NDJSON egress jobs (**heavy compliance**).
| audit | retention | configure | `audit.retention.configure` | tenant/global | Adjust retention horizons / legal hold interplay (**elevated posture**).

---

### System probes and operational maintenance hints

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| system | health | read | `system.health.read` | global | Public health probes.
| system | version | read | `system.version.read` | global | Semantic/API baseline metadata (**bootstrap minimal**).
| system | diagnostics | info_read | `system.diagnostics.info_read` | global | Expanded build/config metadata (**separate from bare version reads**).
| system | maintenance | window_schedule | `system.maintenance.window_schedule` | global | Declare maintenance announcements affecting availability semantics (**operators** typical holder).
| system | maintenance | window_cancel | `system.maintenance.window_cancel` | global | Cancel scheduled maintenance windows while preserving immutable audit history.

---

## Deprecated and legacy alias registry

| legacy_alias | successor_token | Compatibility | Routing / notes |
|---|---|---|---|
| `post.create` | `content.post.create` | **`conditionally-compatible`** whenever historic clients depended on ambiguous short noun | PDP layer must normalize aliases per **CRE8-IDPOL-REQ-0028**.
| `post.read` | `content.post.read` | **`backward-compatible`** | Route inventory modernization follows.
| `post.update` | `content.post.update` | **`backward-compatible`** |
| `post.delete` | `content.post.delete` | **`backward-compatible`** |
| `comment.create` | `content.comment.create` | **`backward-compatible`** |
| `comment.read` | `content.comment.read` | **`backward-compatible`** |
| `feed.items.read` | `feed.stream.view` | **`backward-compatible`** (**[`FEED_RANKING_AND_ORDERING_RULES.md`](../50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md)** still cites `feed.stream.*`). |
| `delegation.issue` | `delegation.grant.create` | **`backward-compatible`** |
| `delegation.revoke` | `delegation.grant.revoke` | **`backward-compatible`** |
| `delegation.depth.set_max` | `delegation.topology.depth_set_max` | **`backward-compatible`** |
| `delegation.expiry.set_max` | `delegation.topology.expiry_set_max` | **`backward-compatible`** |
| `authz.simulate` | `authz.decision.simulate` | **`backward-compatible`** |
| `authz.decide` | `authz.decision.invoke` | **`backward-compatible`** (**HTTP PDP** shim).
| `key.id.mint` | `principal.id_keypair.issue` | **`backward-compatible`** (**aligns cryptography spec** lineage obligations).
| `key.utility.mint` | `principal.utility_keypair.issue` | **`backward-compatible`** |
| `key.lifecycle.suspend` | `credential.key.lifecycle.suspend` | **`backward-compatible`** |
| `key.lifecycle.revoke` | `credential.key.lifecycle.revoke` | **`backward-compatible`** |
| `key.lifecycle.rotate` | `credential.key.lifecycle.rotate` | **`backward-compatible`** |
| `principal.create` | `principal.actor.create` | **`backward-compatible`** (**POST /principals** consolidation).
| `principal.search` | `principal.inventory.search` | **`backward-compatible`** (**draft lattice** alignment).
| `audience.group.create` | `audience.group.manage` | **`backward-compatible`** | [`AUDIENCE_GROUP_SPEC.md`](../50_content_audience_and_feed/AUDIENCE_GROUP_SPEC.md) scopes create/update/delete to `audience.group.manage`.
| `audience.group.update` | `audience.group.manage` | **`backward-compatible`** |
| `audience.group.delete` | `audience.group.manage` | **`backward-compatible`** |
| `audience.group.read` | `audience.group.view` | **`backward-compatible`** |
| `audit.export.create` | `audit.export_job.request` | **`backward-compatible`** (**async semantics** unaffected by rename).
| `system.info.read` | `system.diagnostics.info_read` | **`backward-compatible`** (**split from `system.version`** for clarity).

**Historically prohibited** tokens remain **illegal for new authoring** (**`breaking` parity if resurrected blindly**):

- `key.rotate` (**prohibited outright** ambiguous—**MUST NOT** normalize automatically; callers **MUST** specify ID vs Utility intent via explicit lifecycle + keypair tokens).
- `authz.grant` remains **prohibited** ambiguous shorthand; PDP consumers **MUST** reference **`delegation.grant.create`** when modeling grant issuance.

**Historical keychain `keychain.api_key.*` labels** (**draft §6**) **MUST** normalize as:

| legacy_alias | successor_token |
|---|---|
| `keychain.create` | `keychain.collection.create` |
| `keychain.read` | `keychain.collection.read` |
| `keychain.update` | `keychain.collection.update` |
| `keychain.delete` | `keychain.collection.delete` |
| `keychain.api_key.issue` | `keychain.api_credential.issue` |
| `keychain.api_key.rotate` | `keychain.api_credential.rotate` |
| `keychain.api_key.revoke` | `keychain.api_credential.revoke` |
| `keychain.api_key.restrict_permissions` | `keychain.api_credential.restrict_permissions` |

**Permission provisioning meta tokens (**draft lattice §7.4 shorthand**)** (**normalize**):

| legacy_alias | successor_token |
|---|---|
| `permission.grant.curate_on_mint` | `permission.provisioning.mint_mode_curated` |
| `permission.grant.full_on_mint` | `permission.provisioning.mint_mode_full` |
| `permission.grant.set_meta_on_child` | `permission.provisioning.mint_meta_grant` |

**Draft miscellaneous token label harmonization** (**optional historical strings** surfaced by external prototypes):

| legacy_alias | successor_token |
|---|---|
| `notification.read` | `notification.inbox.read` |
| `notification.manage_preferences` | `notification.preference.manage` |
| `moderation.report.create` | `moderation.report.submit` |
| `moderation.report.resolve` | `moderation.queue.resolve` |
| `moderation.user.restrict` | `moderation.actor.restrict` |
| `moderation.content.hide` | `moderation.content.visibility_hide` |
| `moderation.content.restore` | `moderation.content.visibility_restore` |
| `feed.export` | `feed.snapshot.export` |

`notification.send` has no canonical token in this revision; provisioning outbound notifications stays a system/integration concern until an operator ADR defines a guarded token plus abuse-rate controls.

Tokens ending in `_own` (for example `content.post.update_own`) are narrowing grants: PDP intersections enforce them; they MUST NOT alias the broader verbs.

**Alias candidates for v1.3.x additions** (**introduce only when migration evidence exists**):

| legacy_alias | successor_token | Compatibility | Routing / notes |
|---|---|---|---|
| `principal.lineage.permissions.read` | `principal.lineage.node_effective_permissions_read` | **`conditionally-compatible`** | Candidate for dashboard/debug payload migration only.
| `principal.lineage.grants.summary.read` | `principal.lineage.node_grant_summary_read` | **`conditionally-compatible`** | Candidate for lineage governance views; avoid auto-widening scope.
| `template.clone` | `permission.template.clone` | **`backward-compatible`** | Candidate for template tooling prototypes.
| `template.archive` | `permission.template.archive` | **`backward-compatible`** | Candidate for template lifecycle UIs.
| `delegation.grants.list` | `delegation.grant.list` | **`backward-compatible`** | Candidate where pluralized noun was used in early clients.
| `integration.webhook.secret.rotate` | `integration.webhook.rotate_secret` | **`backward-compatible`** | Candidate for webhook admin UX migrations.
| `audit.events.verify_integrity` | `audit.event.integrity_verify` | **`backward-compatible`** | Candidate for forensic tooling migration.
| `system.maintenance.cancel_window` | `system.maintenance.window_cancel` | **`backward-compatible`** | Candidate for ops console route literal cleanup.

---

## Route inventory parity checklist (automatable target)

Implementations SHOULD migrate each `CRE8-ROUTE-*` `required_permission` cell to its documented successor token and update PDP-related examples in [`docs/31_machine_contracts/openapi/cre8.v1.yaml`](../31_machine_contracts/openapi/cre8.v1.yaml) (`action` literals and related fixtures) in the same coordinated change batch (`composer docs:ssot:route-parity`, `composer docs:ssot:example-coverage`).

| route_id | Current inventory token | Canonical successor | Status |
|---|---|---|---|
| CRE8-ROUTE-0001 | system.health.read | `system.health.read` | **aligned** |
| CRE8-ROUTE-0002 | authz.decide | `authz.decision.invoke` (alias documents `authz.decide`) | **migrate successor label + fixtures** |
| CRE8-ROUTE-0003 | key.lifecycle.suspend | `credential.key.lifecycle.suspend` | **migrate** |
| CRE8-ROUTE-0004 | feed.items.read | `feed.stream.view` (alias retained) | **migrate** |
| CRE8-ROUTE-0005 | key.lifecycle.revoke | `credential.key.lifecycle.revoke` | **migrate** |
| CRE8-ROUTE-0006 | principal.create | `principal.actor.create` | **migrate** |
| CRE8-ROUTE-0007 | key.id.mint | `principal.id_keypair.issue` (alias retained) | **migrate** |
| CRE8-ROUTE-0008 | key.utility.mint | `principal.utility_keypair.issue` (alias retained) | **migrate** |
| CRE8-ROUTE-0009 | key.lifecycle.rotate | `credential.key.lifecycle.rotate` | **migrate** |
| CRE8-ROUTE-0010 | delegation.issue | `delegation.grant.create` (alias retained) | **migrate** |
| CRE8-ROUTE-0011 | delegation.revoke | `delegation.grant.revoke` (alias retained) | **migrate** |
| CRE8-ROUTE-0012 | audience.group.read | `audience.group.view` (alias retained) | **migrate** |
| CRE8-ROUTE-0013 | audience.group.create | `audience.group.manage` (alias aggregated) | **migrate** |
| CRE8-ROUTE-0014 | audience.group.update | `audience.group.manage` (alias aggregated) | **migrate** |
| CRE8-ROUTE-0015 | audience.group.delete | `audience.group.manage` (alias aggregated) | **migrate** |
| CRE8-ROUTE-0016 | post.create | `content.post.create` (alias retained) | **migrate** |
| CRE8-ROUTE-0017 | post.read | `content.post.read` (alias retained) | **migrate** |
| CRE8-ROUTE-0018 | post.update | `content.post.update` (alias retained) | **migrate** |
| CRE8-ROUTE-0019 | post.delete | `content.post.delete` (alias retained) | **migrate** |
| CRE8-ROUTE-0020 | comment.create | `content.comment.create` (alias retained) | **migrate** |
| CRE8-ROUTE-0021 | comment.read | `content.comment.read` (alias retained) | **migrate** |
| CRE8-ROUTE-0022 | audit.export.create | `audit.export_job.request` (alias retained) | **migrate** |
| CRE8-ROUTE-0023 | system.version.read | `system.version.read` | **aligned** |
| CRE8-ROUTE-0024 | system.info.read | `system.diagnostics.info_read` | **migrate** |

### v1.3.x token route-parity planning (policy-context-only vs route-level)

| Token | Intended exposure | Route-level plan |
|---|---|---|
| `principal.lineage.node_effective_permissions_read` | **Policy context + dashboard read models** | **Policy-context-only (now)**; MAY move to route-level when lineage diagnostics endpoint family is canonized. |
| `principal.lineage.node_grant_summary_read` | **Policy context + dashboard read models** | **Policy-context-only (now)**; MAY move to route-level with delegation observability endpoints. |
| `permission.template.clone` | **Route-level candidate** | SHOULD become route-level `required_permission` when template cloning endpoint is promoted. |
| `permission.template.archive` | **Route-level candidate** | SHOULD become route-level `required_permission` when template archive endpoint is promoted. |
| `delegation.grant.list` | **Route-level candidate** | SHOULD become route-level `required_permission` for grant-list APIs and export helpers. |
| `integration.webhook.rotate_secret` | **Route-level candidate** | SHOULD become route-level `required_permission` for webhook secret rotation endpoint(s). |
| `audit.event.integrity_verify` | **Route-level candidate** | MAY stay policy-context-only unless audit integrity verification receives API surface; if surfaced, MUST declare route IDs + OpenAPI examples in same batch. |
| `system.maintenance.window_cancel` | **Route-level candidate** | SHOULD become route-level `required_permission` for maintenance-window cancellation endpoint(s). |

---

## Verification hooks

- **HOOK-PERMISSION-VOCAB-RESOLVE**: Lint script presence + deterministic registry growth guard (**extend** automation to traverse route inventory uniqueness vs registry—future enhancement).
- **HOOK-PERMISSION-ALIAS-NORMALIZATION** (**proposed automation** map alias→successor in PDP fixtures (**`composer test:contract:auth`** extensions**)).

## See also

- [Draft lattice (non normative)](./DRAFT_KEY_MINTING_PERMISSION_LATTICE.md)
- [`ROUTE_INVENTORY_REFERENCE.md`](../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [`PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](./PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md)
- [`KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md`](./KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md)
- [`REFERENCE_MAINTENANCE_SOP.md`](../../REFERENCE_MAINTENANCE_SOP.md)

## Change history

- **2026-05-05 (v1.3.1)**: Added alias candidates for newly introduced v1.3.x tokens (only where migration need is plausible) and added a focused route-parity planning table classifying those tokens as policy-context-only vs route-level candidates.
- **2026-05-05 (v1.3.0)**: Expanded canonical registry for governance-operability closure by adding lineage effective-permission/grant-summary read tokens, template clone/archive actions, delegation grant listing, webhook secret rotation, audit-event integrity verification, and maintenance-window cancellation.

- **2026-05-05 (v1.2.0)**: Restructured registry into operational vs provisioning strata; documented Owner dashboard mint posture (**Primary issuance only**) with lineage navigation tokens, template-lock / issuance-cap knobs, delegation width + transferable subsets, Owner settings API credentials complements, **`content.link.preview_fetch`**, **`audit.retention.configure`**, **`system.maintenance.window_schedule`**, and issuance cap **`issuance.cap.primary_author.active_max_per_owner_scope`**; introduced **`CRE8-IDPOL-REQ-0030`** (**provisioning envelope intersection**) and **`CRE8-IDPOL-REQ-0031`** (routing guidance for provisioning-only tokens). Change Impact Map: [`reports/change_impact_maps/20260505-0435-permission-vocabulary-lineage-provisioning-expansion.md`](../../reports/change_impact_maps/20260505-0435-permission-vocabulary-lineage-provisioning-expansion.md).

- **2026-05-05 (v1.1.0)**: Expanded registry with route inventory, draft lattice, and mint ergonomics tokens (invite, device pairing, notifications, integrations, moderation split, keychain API credentials); introduced **`CRE8-IDPOL-REQ-0028`** (alias normalization) and **`CRE8-IDPOL-REQ-0029`** (route completeness). Captured deprecation map plus parity checklist. Change Impact Map:[`reports/change_impact_maps/20260505-0515-permission-vocabulary-expansion.md`](../../reports/change_impact_maps/20260505-0515-permission-vocabulary-expansion.md).
