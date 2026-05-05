---
doc_id: CRE8-IDPOL-DRAFT-PERM-LATTICE
version: 0.1.0
status: draft-brainstorm
owner: (TBD)
reviewers: []
last_reviewed_utc: (TBD)
normative_dependencies: []
note: >-
  Brainstorm only. Not canon. Strip rows, rename tokens, then promote via
  CHANGE_CONTROL_POLICY into PERMISSION_VOCABULARY, route inventory, and
  capability matrix.
---

# Draft: Key-minting permission lattice, templates, and exhaustive token list

## 1. Purpose

This document captures a **proposed** model for how permissions are **provisioned top-down** at each minting tier, including **named templates**, **full-power vs curated** grants, **Secondary nested-mint** toggles, and **Keychain** credentials. It also lists **every candidate permission token** the authors could imagine needing, so the program can **delete** what CRE8 will not ship and **promote** the remainder into canonical docs (`PERMISSION_VOCABULARY.md`, `ROUTE_INVENTORY_REFERENCE.md`, `PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`, etc.).

**Relationship to current canon:** Today, `PERMISSION_VOCABULARY.md` has a **small** registered set; `ROUTE_INVENTORY_REFERENCE.md` uses **additional** `required_permission` strings that are not all aligned with that vocabulary. This draft assumes those will be **reconciled** into one registry.

---

## 2. Core concepts

### 2.1 Effective envelope (bounded inheritance)

Every child key inherits an **effective permission set** that is always a **subset** (or equal set) of its minter’s effective envelope, intersected with whatever the minter chose to grant, subject to **delegation rules** (“you cannot grant what you do not hold” and “you cannot grant downstream-admin powers unless explicitly allowed”).

### 2.2 Full vs curated grant at mint time

When a minter creates a child key, they choose:

| Mode | Meaning |
|------|--------|
| **Full functional** | Grant **every** permission the minter is allowed to pass to that principal class at this depth—subject only to lattice rules (e.g. Secondary still cannot mint Primary). |
| **Curated** | Explicit allow-list of permissions from the minter’s envelope; everything else **deny** for that key. |

The same choice applies when saving a **template** (see §3).

### 2.3 Meta-permissions (permissions about permissions)

High levels configure not only **content/API** capabilities but also **what the child may configure** on *its* descendants—for example: whether a Primary may grant “mint Secondary” or “mint nested Secondary,” whether they may save templates, and maximum delegation depth.

---

## 3. Named permission templates

| Concept | Description |
|--------|-------------|
| **Template** | A **named**, reusable allow-list (and optional keyed toggles like `secondary_may_mint_secondary`) stored under an owner/tenant scope. |
| **Save template** | Persist current “curated” selection + meta toggles under `template_name`. |
| **Apply template** | At mint time, populate the child grant from template, then apply **intersection** with minter envelope (never expand beyond minter). |

**Candidate permissions** for template management appear in §8 (administration / templates).

---

## 4. Minting hierarchy (behavioral rules — draft)

The following restates the product intent; normative wording would later live in `AUTHORIZATION_AND_DELEGATION_SPEC`–class docs.

### 4.1 Owner → Primary Author Key

- Owner may mint Primary Author Keys.
- For each mint: **full functional** *or* **curated** permissions.
- Owner may optionally **save** the configuration as a **named template** for future Primary mints.
- Owner sets both **direct capabilities** and **meta** fields (what this Primary may assign when *they* mint).

### 4.2 Primary Author Key → Primary Author Key

- A Primary Author Key bearer may mint **another** Primary Author Key **only if** their envelope includes the corresponding mint permission (see §7.1).
- Same **full** vs **curated** behavior and **template** usage as Owner→Primary, but capped by Primary’s envelope.

### 4.3 Primary Author Key → Secondary Author Key

- Secondary Author Keys **must not** mint Primary Author Keys.
- **Default:** Secondary may **not** mint other Secondary Author Keys; they may mint **Use Keys** only—**unless** their grant lacks `mint.use` (or equivalent).
- **Optional (curated at Primary mint time):** Primary may grant `secondary_may_mint_secondary` (or equivalent token) so a Secondary can mint further Secondaries, still within envelope bounds.

### 4.4 Secondary Author Key → Use Key

- Same default: may mint Use Keys if holding mint permission; envelope bounded.

### 4.5 Secondary Author Key → Secondary Author Key (conditional)

- Only if `secondary_may_mint_secondary` (or equivalent) is **true** on that Secondary’s grant and lifecycle allows.

### 4.6 Use Key → no key minting

- Use Keys **must not** mint Primary, Secondary, or Use keys.
- Use Keys **may** create and manage **Keychains** and **Keychain API Keys** (credentials aggregating multiple keys), with **subset** or **full inherited** permission projection (see §6).

### 4.7 Keychain API Key

- Not a “minted principal” in the same class as Primary/Secondary/Use, but a **derived credential** with:
  - **Union** of inherited permissions from member keys (intersected with policy), **then**
  - optional **curated removal** of permissions on the Keychain API Key itself.

---

## 5. Who may assign what (summary matrix — draft)

Rows = **actor doing the provisioning**; columns = **child type being provisioned**. Cells describe **what categories** they may set if their envelope includes the right tokens.

| Provisioning actor | Primary Author child | Secondary Author child | Use Key child | Utility keypair (context) | Keychain / Keychain API |
|--------------------|----------------------|-------------------------|---------------|----------------------------|-------------------------|
| Owner | All §7 categories allowed by policy | All (if Owner mints Secondaries in your deployment model) | All | Yes | Typically via policy; may be Owner-only in some modes |
| Primary Author | If `mint.primary_author` | If `mint.secondary_author` | If `mint.use` | Yes (ID holder) | If keychain permissions granted |
| Secondary Author | **No** | Only if `secondary_may_mint_secondary` | If `mint.use` | Yes (ID holder) | If keychain permissions granted |
| Use Key | **No** | **No** | **No** | **No** (utility issuance is ID-holder) | Yes (if granted) |

*Exact tokens in §7—replace “If” clauses with final vocabulary.*

---

## 6. Keychain and Keychain API Key (draft tokens)

| Token (proposed) | Description |
|------------------|-------------|
| `keychain.create` | Create a keychain owned by this Use principal. |
| `keychain.read` | View keychain metadata and membership. |
| `keychain.update` | Add/remove member keys (subject to policy on which keys may be linked). |
| `keychain.delete` | Delete keychain and revoke derived credentials. |
| `keychain.api_key.issue` | Issue a Keychain API Key credential. |
| `keychain.api_key.rotate` | Rotate Keychain API Key material. |
| `keychain.api_key.revoke` | Revoke Keychain API Key. |
| `keychain.api_key.restrict_permissions` | Allowed to **subset** the union when issuing/restricting the Keychain API Key (if absent, only “full inherited union” or **no** API key—product choice). |

**Policy note:** Member keys’ permissions **union** ∩ envelope ∩ keychain policy still must respect **deny precedence** and **lifecycle** everywhere.

---

## 7. Exhaustive candidate permission registry

**Format:** `domain.resource.action` (lowercase segments). Rows marked **[route]** exist in `ROUTE_INVENTORY_REFERENCE.md` today under a slightly different string—reconcile when promoting.

**_columns you can use when pruning:_** _Keep = Y/N; Owner→Primary = assignable?; Notes._

### 7.1 Principal minting and class governance

| Token | Description |
|-------|-------------|
| `principal.primary_author.mint` | Mint a Primary Author Key (Owner or Primary, per deployment). |
| `principal.secondary_author.mint` | Mint a Secondary Author Key. |
| `principal.use_key.mint` | Mint a Use Key. |
| `principal.secondary_author.mint_nested_secondary` | Allow a Secondary Author Key to mint **another** Secondary Author Key (off by default). |
| `principal.profile.read` | Read principal profile/metadata for principals in scope. |
| `principal.profile.update` | Update principal profile/metadata. |
| `principal.lifecycle.suspend` | Suspend a principal (administrative). |
| `principal.lifecycle.resume` | Resume a suspended principal. |
| `principal.search` | Search/list principals within tenant/policy scope. |
| `principal.create` | **[route]** `POST /v1/principals` — consolidate naming vs `principal.*.mint`. |
| `principal.delete` | Tombstone/delete principal (high privilege; may be Owner-only). |

### 7.2 ID and Utility keypairs (align with current vocabulary)

| Token | Description |
|-------|-------------|
| `principal.id_keypair.issue` | Issue ID keypair (canon). |
| `principal.id_keypair.rotate` | Rotate ID keypair (canon). |
| `principal.id_keypair.revoke` | Revoke ID keypair (canon). |
| `principal.utility_keypair.issue` | Issue utility keypair (canon). |
| `principal.utility_keypair.rotate` | Rotate utility keypair (canon). |
| `principal.utility_keypair.revoke` | Revoke utility keypair (canon). |
| `key.id.mint` | **[route]** alias of ID issuance path—merge with `principal.id_keypair.issue`. |
| `key.utility.mint` | **[route]** alias of utility issuance—merge with `principal.utility_keypair.issue`. |
| `key.lifecycle.suspend` | **[route]** — merge with vocabulary-style lifecycle tokens or keep as composite operation. |
| `key.lifecycle.revoke` | **[route]** |
| `key.lifecycle.rotate` | **[route]** |

### 7.3 Delegation grants and authz simulation

| Token | Description |
|-------|-------------|
| `delegation.grant.create` | Create a scoped delegation grant (canon). |
| `delegation.grant.revoke` | Revoke delegation grant (canon). |
| `delegation.grant.inspect` | Inspect delegation chain (canon). |
| `delegation.issue` | **[route]** `POST /v1/delegations` — merge with `delegation.grant.create`. |
| `delegation.revoke` | **[route]** — merge with `delegation.grant.revoke`. |
| `delegation.depth.set_max` | Configure maximum remaining delegation depth for subtree. |
| `delegation.expiry.set_max` | Set latest expiry ceiling for grants this principal may issue. |
| `authz.decide` | **[route]** Invoke PDP decision endpoint (`POST /v1/authz/decide`). |
| `authz.simulate` | Run hypothetical decision (if product separates from `decide`). |

### 7.4 Permission templates and provisioning administration

| Token | Description |
|-------|-------------|
| `permission.template.create` | Create named template from current curated selection. |
| `permission.template.read` | Read template definitions. |
| `permission.template.update` | Update template. |
| `permission.template.delete` | Delete template. |
| `permission.template.apply` | Apply template when minting (may be implicit to mint if simpler). |
| `permission.grant.curate_on_mint` | Meta: allowed to use “curated” mode when minting descendants. |
| `permission.grant.full_on_mint` | Meta: allowed to use “full functional” mode (still bounded by lattice). |
| `permission.grant.set_meta_on_child` | Meta: allowed to set **meta-permissions** on minted child (who they may delegate to). |

### 7.5 Content — posts

| Token | Description |
|-------|-------------|
| `content.post.create` | Create post (canon). |
| `content.post.read` | Read posts visible per policy (may split scope). |
| `content.post.read_own` | Read only posts authored by self. |
| `content.post.update` | Update post (canon). |
| `content.post.update_own` | Update only own posts. |
| `content.post.delete` | Delete/tombstone post (canon). |
| `content.post.delete_own` | Delete only own posts. |
| `content.post.pin` | Pin/featured placement (if product supports). |
| `content.post.lock` | Lock thread / prevent comments. |
| `content.crosspost.create` | Cross-post to another scope (if supported). |
| `post.create` | **[route]** — merge with `content.post.create`. |
| `post.read` | **[route]** |
| `post.update` | **[route]** |
| `post.delete` | **[route]** |

### 7.6 Content — comments

| Token | Description |
|-------|-------------|
| `content.comment.create` | Create comment (canon). |
| `content.comment.read` | Read comments. |
| `content.comment.update` | Edit own or moderated comments (split if needed). |
| `content.comment.delete` | Delete comments. |
| `content.comment.moderate` | Moderate comments (canon). |
| `comment.create` | **[route]** |
| `comment.read` | **[route]** |

### 7.7 Content — reactions / attachments (optional product)

| Token | Description |
|-------|-------------|
| `content.reaction.create` | Add reaction. |
| `content.reaction.delete` | Remove reaction. |
| `content.attachment.upload` | Upload attachment to post/comment. |
| `content.attachment.delete` | Delete attachment. |
| `content.link.preview_fetch` | Fetch link previews (server-side). |

### 7.8 Audience and targeting

| Token | Description |
|-------|-------------|
| `audience.group.view` | View audience metadata (canon). |
| `audience.group.manage` | Create/update audience groups (canon). |
| `audience.group.create` | **[route]** — may merge into `manage`. |
| `audience.group.read` | **[route]** — merge with `view`. |
| `audience.group.update` | **[route]** |
| `audience.group.delete` | **[route]** |
| `audience.group.membership.add` | Add members to group. |
| `audience.group.membership.remove` | Remove members. |
| `audience.label.assign` | Assign audience labels/tags to content. |
| `audience.targeting.restrict` | Restrict which targeting dimensions a key may use. |

### 7.9 Feed and discovery

| Token | Description |
|-------|-------------|
| `feed.stream.view` | View feed timeline (canon). |
| `feed.stream.curate` | Curate/rank feed (canon). |
| `feed.items.read` | **[route]** `GET /v1/feed/items` — merge with `feed.stream.view`. |
| `feed.subscription.manage` | Follow/unfollow sources (if modeled). |
| `feed.export` | Export feed slice for compliance. |

### 7.10 Notifications (optional)

| Token | Description |
|-------|-------------|
| `notification.read` | Read notifications. |
| `notification.manage_preferences` | Manage notification preferences. |
| `notification.send` | Send notifications to others (usually system-only). |

### 7.11 Moderation and safety

| Token | Description |
|-------|-------------|
| `moderation.report.create` | File abuse/report. |
| `moderation.report.resolve` | Triage reports. |
| `moderation.user.restrict` | Rate-limit or restrict actors in scope. |
| `moderation.content.hide` | Hide content without delete. |
| `moderation.content.restore` | Restore hidden content. |

### 7.12 Owner Console / governance UI (optional explicit tokens)

| Token | Description |
|-------|-------------|
| `owner.console.access` | Access Owner Console surface. |
| `owner.settings.read` | Read tenant/platform settings. |
| `owner.settings.update` | Change settings. |
| `owner.billing.read` | Read billing (if applicable). |
| `owner.billing.manage` | Manage billing. |
| `owner.api_credentials.manage` | Manage operator API credentials. |

### 7.13 Developer / integration

| Token | Description |
|-------|-------------|
| `integration.webhook.manage` | Register webhooks. |
| `integration.webhook.read` | List/delivery logs. |
| `integration.api_rate_limit.exempt` | Exempt from standard rate limits (dangerous). |

### 7.14 Audit and compliance

| Token | Description |
|-------|-------------|
| `audit.event.read` | Read audit events (canon). |
| `audit.export.create` | **[route]** Request audit export job. |
| `audit.retention.configure` | Set retention (high privilege). |

### 7.15 System and health

| Token | Description |
|-------|-------------|
| `system.health.read` | Health check (canon / route). |
| `system.version.read` | **[route]** Version metadata. |
| `system.info.read` | **[route]** Build/info. |
| `system.maintenance.window.schedule` | Schedule maintenance (platform ops). |

### 7.16 Keychain (see §6)

(Repeated here for one flat index.) `keychain.create`, `keychain.read`, `keychain.update`, `keychain.delete`, `keychain.api_key.issue`, `keychain.api_key.rotate`, `keychain.api_key.revoke`, `keychain.api_key.restrict_permissions`.

---

## 8. Per-level “typical knobs” checklist (for UX + policy engine)

When minting a child, the minter may configure:

1. **Capability bundle:** full vs curated (allow-list from §7).
2. **Delegation knobs:** `delegation.depth.set_max`, `delegation.expiry.set_max`, whether child may `delegation.grant.create` / `revoke` / `inspect`.
3. **Minting knobs:** which of `principal.*.mint` tokens the child receives (and `principal.secondary_author.mint_nested_secondary` for Secondaries).
4. **Template rights:** `permission.template.*` subset.
5. **Keychain knobs (for Use keys):** §6 tokens.
6. **Surface restrictions:** e.g. Owner-Console-only vs API-only (if expressed as permissions rather than route flags).

---

## 9. Consolidation checklist (before canon promotion)

1. **Deduplicate** §7: pick **one** token per capability (remove `[route]` aliases or mark deprecated).
2. **Align** every `CRE8-ROUTE-*` `required_permission` with the surviving registry.
3. **Update** `PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md` for new tokens (especially mint + template + keychain).
4. **Add** decision tables for nested Secondary mint and Keychain permission projection.
5. **Add** provenance events for template CRUD and “grant mode” at mint (full vs curated).

## 10. Change log

| Date (UTC) | Change |
|------------|--------|
| 2026-05-05 | Initial brainstorm draft. |
