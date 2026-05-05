---
doc_id: CRE8-IDPOL-PERMISSION-VOCAB
version: 1.1.0
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

| Domain | Resource | Action | Token | Scope notes | Mint / delegation notes |
|---|---|---|---|---|---|
| principal | actor | create | `principal.actor.create` | tenant | Create or register a descendant principal (Use Key, Secondary Author, etc.) under authorized lineage; consolidates fragmented `principal.create` naming from route inventory drafts.
| principal | actor | delete | `principal.actor.delete` | tenant | Tombstone/delete principals within policy (**high privilege**).
| principal | primary_author | mint | `principal.primary_author.mint` | tenant | Mint a Primary Author-capable descendant key line.
| principal | secondary_author | mint | `principal.secondary_author.mint` | tenant | Mint a Secondary Author key.
| principal | secondary_author | mint_nested_secondary | `principal.secondary_author.mint_nested_secondary` | tenant | Permit a Secondary Author to mint nested Secondaries (**off by default**).
| principal | use_key | mint | `principal.use_key.mint` | tenant | Mint a runtime Use principal for apps/friends (**non-authoring** surface).
| principal | profile | read | `principal.profile.read` | tenant/resource | Inspect principal profile metadata.
| principal | profile | update | `principal.profile.update` | tenant/resource | Update principal profile metadata.
| principal | lifecycle | suspend | `principal.lifecycle.suspend` | tenant/resource | Suspends principal lineage subject to ancestry rules.
| principal | lifecycle | resume | `principal.lifecycle.resume` | tenant/resource | Resumes suspended principal.
| principal | inventory | search | `principal.inventory.search` | tenant | Enumerate/query principals (**replaces ambiguous `principal.search`** noun).
| principal | id_keypair | issue | `principal.id_keypair.issue` | tenant/resource | Attach lineage-root ID material (HTTP:`POST /v1/keys/id`).
| principal | id_keypair | rotate | `principal.id_keypair.rotate` | resource | Rotate ID key material (**may require route-specific pairing with lifecycle endpoints**).
| principal | id_keypair | revoke | `principal.id_keypair.revoke` | resource | Revoke ID lineage anchor; operation is destructive within lifecycle policy bounds.
| principal | utility_keypair | issue | `principal.utility_keypair.issue` | resource | Mint utility/proxy credential for client apps.
| principal | utility_keypair | rotate | `principal.utility_keypair.rotate` | resource | Rotate utility key material.
| principal | utility_keypair | revoke | `principal.utility_keypair.revoke` | resource | Revoke utility key material.
| credential | key | lifecycle_suspend | `credential.key.lifecycle.suspend` | resource | Applies `suspend` to key material via **`/v1/keys/{key_id}/lifecycle/suspend`** family.
| credential | key | lifecycle_revoke | `credential.key.lifecycle.revoke` | resource | Applies `revoke` via lifecycle route family.
| credential | key | lifecycle_rotate | `credential.key.lifecycle.rotate` | resource | Applies `rotate` via lifecycle route family.
| delegation | grant | create | `delegation.grant.create` | resource | Establish bounded delegation envelopes.
| delegation | grant | revoke | `delegation.grant.revoke` | resource | Revoke active grants (**may include DELETE semantics on HTTP surface**).
| delegation | grant | inspect | `delegation.grant.inspect` | tenant/resource | Read delegation graph / metadata.
| delegation | topology | depth_set_max | `delegation.topology.depth_set_max` | tenant/resource | Caps remaining delegation hops issuable beneath actor (**draft lattice §7.3 normalization**).
| delegation | topology | expiry_set_max | `delegation.topology.expiry_set_max` | tenant/resource | Caps latest expiry descendant grants may carry.
| authz | decision | simulate | `authz.decision.simulate` | resource | Evaluate hypothetical PDP context (**paired with PDP endpoint** separation from live `decide`).
| authz | decision | invoke | `authz.decision.invoke` | resource | Caller may request centralized PDP adjudication (**HTTP authz/decide permission**).
| permission | template | create | `permission.template.create` | tenant | Persist named mint templates (**Owner/Primary ergonomics**).
| permission | template | read | `permission.template.read` | tenant | Read stored templates / presets.
| permission | template | update | `permission.template.update` | tenant | Modify template definitions.
| permission | template | delete | `permission.template.delete` | tenant | Remove templates.
| permission | template | apply | `permission.template.apply` | tenant | Permit applying template-derived bundles at issuance.
| permission | provisioning | mint_mode_curated | `permission.provisioning.mint_mode_curated` | tenant | Permit curated allow-list issuance to descendants (**meta entitlement**).
| permission | provisioning | mint_mode_full | `permission.provisioning.mint_mode_full` | tenant | Permit full-functional bounded issuance (**within envelope**) to descendants (**meta entitlement**).
| permission | provisioning | mint_meta_grant | `permission.provisioning.mint_meta_grant` | tenant | Permit configuring descendant meta-fields (delegation knobs/mint knobs).
| content | post | create | `content.post.create` | group/resource | Publish posts.
| content | post | read | `content.post.read` | group/resource | Read posts subject to targeting and visibility.
| content | post | read_own | `content.post.read_own` | resource | Read posts constrained to author's own corpus (**narrow mint preset**).
| content | post | update | `content.post.update` | resource | Mutate arbitrary in-scope posts (moderator-style when policy allows broad scope).
| content | post | update_own | `content.post.update_own` | resource | Restrict edit rights to author's own authored posts (**friend/client safe default**).
| content | post | delete | `content.post.delete` | resource | Hard delete/tombstone in scope.
| content | post | delete_own | `content.post.delete_own` | resource | Delete only author's content (**narrow mint preset**).
| content | post | pin | `content.post.pin` | resource | Featured/pinned placement (**product optional**).
| content | post | lock | `content.post.lock` | resource | Freeze thread / disable comments (**product optional**).
| content | crosspost | create | `content.crosspost.create` | group/resource | Duplicate content across scopes (**optional product**).
| content | comment | create | `content.comment.create` | resource | Attach comments/interactions where feed policy allows.
| content | comment | read | `content.comment.read` | resource | Enumerate/read comment threads (**HTTP GET comments** symmetry).
| content | comment | update | `content.comment.update` | resource | Edit existing comment bodies when policy binds author-edit vs moderator-edit obligations to this token scope.
| content | comment | delete | `content.comment.delete` | resource | Delete or tombstone comment bodies without moderator queue semantics (narrow friend/client revoke path).
| content | comment | moderate | `content.comment.moderate` | resource | Holds,visibility,interaction enforcement (**moderators**).
| content | reaction | create | `content.reaction.create` | resource | Add lightweight reactions (**optional social layer**).
| content | reaction | delete | `content.reaction.delete` | resource | Remove reactions authored by caller context.
| content | attachment | upload | `content.attachment.upload` | resource | Upload binary attachments tied to posts/comments.
| content | attachment | delete | `content.attachment.delete` | resource | Remove attachments in scope (**safe client sharing** knob).
| audience | group | manage | `audience.group.manage` | tenant/resource | Audience group CRUD plus membership mutations; aligns with [`AUDIENCE_GROUP_SPEC.md`](../50_content_audience_and_feed/AUDIENCE_GROUP_SPEC.md).
| audience | group | view | `audience.group.view` | tenant/group | Read audience metadata and enumerated membership surfaces consistent with FEED/read routes.
| audience | group_membership | add | `audience.group_membership.add` | resource | Narrow grant: add principals to curated groups (**friend lists** sharing).
| audience | group_membership | remove | `audience.group_membership.remove` | resource | Remove members from curated groups to revoke collaborator access without full group deletion.
| audience | label | assign | `audience.label.assign` | resource | Attach audience taxonomy labels/content targeting metadata.
| audience | targeting | restrict | `audience.targeting.restrict` | tenant/resource | Inverse guard capability (limit targeting dimensions delegated keys may use (**operator safety knob**)).
| feed | stream | view | `feed.stream.view` | group | Page authorized feed timelines.
| feed | stream | curate | `feed.stream.curate` | group | Ranking/curation overlays (**elevated** entitlement surface).
| feed | subscription | manage | `feed.subscription.manage` | tenant/group | Follow/unfollow/regenerate feed memberships (**nice client UX entitlement**).
| feed | snapshot | export | `feed.snapshot.export` | tenant/group | Export feed snapshots for portability/compliance (**optional**).
| notification | inbox | read | `notification.inbox.read` | tenant/resource | Read notification inbox/stream (**friendly keys** minimal surface).
| notification | preference | manage | `notification.preference.manage` | tenant/resource | Control delivery categories and interruption policies for client-connected principals.
| moderation | report | submit | `moderation.report.submit` | resource | Submit abuse/policy reports (**friends/community safety**).
| moderation | queue | resolve | `moderation.queue.resolve` | tenant/global | Trusted resolver workflow (**elevated** operator entitlement).
| moderation | actor | restrict | `moderation.actor.restrict` | tenant/resource | Apply temporary interaction restrictions ("soft bans") without invoking full principal suspension.
| moderation | content | visibility_hide | `moderation.content.visibility_hide` | resource | Restrict visibility without deleting underlying content (“hide” path for moderators/operators).
| moderation | content | visibility_restore | `moderation.content.visibility_restore` | resource | Reverse visibility restrictions issued under `moderation.content.visibility_hide` or equivalent tooling.
| owner | billing | read | `owner.billing.read` | global | Inspect billing artefacts (**tenant owner surface** optional).
| owner | billing | manage | `owner.billing.manage` | global | Modify billing artefacts (**elevated** commercial controls).
| owner | console | access | `owner.console.access` | global | Admit actor to Owner Console capabilities bundle (**paired with routing rules**).
| owner | credential | manage | `owner.credential.manage` | tenant | Manage owner-issued bootstrap/service credentials (**separate from end-user minted keys**).
| integration | webhook | manage | `integration.webhook.manage` | tenant | Register webhook endpoints/transformers.
| integration | webhook | read | `integration.webhook.read` | tenant | Inspect deliveries/logs (**least privilege integrations**).
| integration | api_rate_limit | exempt | `integration.api_rate_limit.exempt` | tenant | Bypass standard API rate envelopes (carry **`breaking`**/`security-impacting` classification when granted; Owner-only default posture).
| credential | invite | issue | `credential.invite.issue` | tenant | Create invite links/codes granting bounded onboarding (**sharing with associates** UX).
| credential | invite | revoke | `credential.invite.revoke` | tenant/resource | Invalidate outstanding invites (**safety/recall**).
| credential | device | register | `credential.device.register` | tenant | Register named devices or hardware-bound tokens tied to delegated principals (**multi-device** ergonomics).
| credential | device | revoke | `credential.device.revoke` | resource | Remote wipe device/session binding (**lost phone scenario**).
| keychain | collection | create | `keychain.collection.create` | resource | Compose multi-key aggregates (**personal power user** ergonomics).
| keychain | collection | read | `keychain.collection.read` | resource | Inspect membership/metadata.
| keychain | collection | update | `keychain.collection.update` | resource | Attach/detach constituent keys respecting lineage rules.
| keychain | collection | delete | `keychain.collection.delete` | resource | Delete aggregate + revoke derivatives.
| keychain | api_credential | issue | `keychain.api_credential.issue` | resource | Derived API credential representing union projection (**preferred canonical label over historical `api_key` noun fragmentation**—alias below preserves compatibility).
| keychain | api_credential | rotate | `keychain.api_credential.rotate` | resource | Rotate derived credential.
| keychain | api_credential | revoke | `keychain.api_credential.revoke` | resource | Revoke derived credential.
| keychain | api_credential | restrict_permissions | `keychain.api_credential.restrict_permissions` | resource | Permit subset tightening on derived credential issuance (**supply optional least privilege** sharing).
| audit | event | read | `audit.event.read` | global | Interactive audit querying (**privileged** observability consumption).
| audit | export_job | request | `audit.export_job.request` | global | Submit asynchronous CSV/NDJSON bundles (**heavy compliance** egress).
| system | health | read | `system.health.read` | global | Public health probes.
| system | version | read | `system.version.read` | global | Read semantic/API version (**bootstrap clients** minimal).
| system | diagnostics | info_read | `system.diagnostics.info_read` | global | Expanded build/config metadata (**replaces simplistic `system.info`** label drift).

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

- **2026-05-05 (v1.1.0)**: Expanded registry with route inventory, draft lattice, and mint ergonomics tokens (invite, device pairing, notifications, integrations, moderation split, keychain API credentials); introduced **`CRE8-IDPOL-REQ-0028`** (alias normalization) and **`CRE8-IDPOL-REQ-0029`** (route completeness). Captured deprecation map plus parity checklist. Change Impact Map:[`reports/change_impact_maps/20260505-0515-permission-vocabulary-expansion.md`](../../reports/change_impact_maps/20260505-0515-permission-vocabulary-expansion.md).
