# CRE8 Open Questions 001 — Resolved Decisions (Prototype-Aware, SSOT-Aligned)

_Status: adopted_
Date resolved: 2026-04-06 (UTC)

Decision framing used in this artifact:
- **Primary answer** = definitive v1 decision to align implementation and docs.
- **Prototype note** = where current code differs or only partially implements the decision.
- **[Alternatives considered]** = viable options not selected.

---

## 1) Identity, credential, and token model

- **Canonical key form:** Primary/Secondary/Use/Keychain keys are **hybrid credentials**: database principal record + hashed credential secret (`api_key`) + latest delegation envelope metadata.
- **Representation parity across key types:** Primary/Secondary/Use all use the same storage primitives; class semantics differ via `key_class` and permission/scope payload. Keychain remains a distinct class of key in SSOT terms but is represented in v1 as a key-class variant over the same primitives.
- **Credential lifetime model:** Keys are long-lived or time-boxed credentials that exchange for short-lived JWT access tokens + rotatable refresh tokens.
- **JWT role:** JWTs are bearer access/session artifacts only (not canonical key material). Owner JWTs secure console routes; key JWTs secure gateway routes.
- **JWT issuance:** Owner JWT at `/api/auth/login` and refresh; key JWT at `/api/auth/key-login` and refresh.
- **Mandatory owner claims:** `iss,aud,sub,typ=owner,iat,nbf,exp,jti`.
- **Mandatory key claims:** `iss,aud,sub,typ=key,iat,nbf,exp,jti,key_class,permissions,scope,comments_enabled,delegation_envelope_id,initial_author_key_id`.
- **JWKS role:** publish active verification key set for RS256 access token verification by clients/services.
- **Signing key scope:** per-environment keypair, globally scoped inside that environment.
- **Rotation policy:** rotate signing keys on a scheduled and incident-based basis; overlap old/new keys in JWKS during grace window.
- **Token lifetime rules:** owner access 15m, key access 10m, refresh 7d family TTL with rotation and replay invalidation.
- **Key expiry:** supported and required via delegation envelope expiry.
- **One-time/limited-use/time-boxed keys:** time-boxed supported in v1; one-time and count-limited keys deferred to v1.1.
- **Lost key recovery:** owner disables/revokes key and reissues new key; no secret recovery endpoint.

Prototype note: current prototype already follows hybrid key storage, owner/key JWT split, refresh rotation/replay checks, and key expiry constraints.

[Alternatives considered]
- [Opaque API keys only (no JWT) for every call — simpler but weaker for stateless gateway scaling.]
- [Per-tenant signing keys in v1 — stronger isolation but higher operational complexity.]
- [Long-lived access JWTs with no refresh — rejected for security posture.]

## 2) Owner account model

- **First owner creation:** allowed through `/console/owners` bootstrap flow.
- **Tenancy model:** v1 is **single-tenant application space** with owner-scoped objects.
- **Owner namespace control:** multiple owners may exist, but each key lineage is owner-bound.
- **Multi-org membership:** not supported in v1.
- **Registration fields:** email + password.
- **Login identifier:** email only.
- **Password policy:** minimum 12 chars in v1; complexity enhancements deferred.
- **MFA:** optional roadmap item; not required in v1.
- **Account recovery:** out-of-band admin reset process in v1; self-service recovery deferred.
- **Owner suspension/deactivation:** supported via disabled state on principal records.
- **Owner creation by owner:** invitation-key flow is target model; direct create route remains bootstrap/admin-only in prototype phase.

[Alternatives considered]
- [Single immutable root owner only.]
- [Username+email login in v1.]
- [Mandatory MFA in v1 (deferred for delivery speed).]

## 3) Admin role and governance

- **Admin definition:** Admin is an owner-delegated moderation/governance capability set, not a separate global platform superuser in v1.
- **Scope:** tenant/application scoped.
- **Admin creation:** by Owner policy action (future explicit endpoint/role assignment).
- **Admin vs Owner:** Admin can moderate and operate within delegated scope; Owner retains governance authority over key issuance lineages and high-risk lifecycle actions.
- **Owner-only powers:** root key governance, admin delegation, tenant-wide policy controls.
- **Visibility:** scoped by owner tenancy boundary.
- **Cross-owner revocation:** forbidden.
- **Auditability:** all admin actions must be audited.
- **Super-admin:** not in v1 product model.

[Alternatives considered]
- [Global platform admins for managed SaaS operations.]
- [No admin role at all; owner-only operations.]

## 4) Key taxonomy and minting rules

- **Secondary→Secondary mint:** allowed only if parent has `keys:issue` and subset/depth/expiry constraints pass.
- **Secondary→Primary mint:** forbidden.
- **Use minting:** forbidden.
- **Keychain minting:** keychains cannot mint credentials.
- **Owner direct mint:** owner may mint primary/secondary/use directly from console.
- **System hard limits:** non-bypassable subset-of-parent perms/scope, max depth, ttl limits, use-key restrictions.
- **Child > parent permissions:** never allowed.
- **Parent depth restriction:** yes, via envelope depth and max depth policy.
- **Max lineage depth:** 3 in v1.
- **Descendant quotas:** none in v1; add quota controls later.
- **Invitation key usage:** single-use by default.
- **Invitation expiry:** required; 5m–7d bounds in v1.
- **Invitation scoping:** email-scoped in v1.

[Alternatives considered]
- [Allow secondary→primary with owner approval workflow.]
- [Unlimited depth with graph risk scoring (too complex for v1).]

## 5) Permission system semantics

- **v1 permission set:** `posts:read`, `posts:create`, `posts:edit`, `comments:create`, `keys:issue`, `keys:revoke`.
- **Permission type:** allow-list capabilities + scope filters; no explicit deny in v1.
- **Computation model:** effective perms are inherited-constrained subset at mint time.
- **Post-mint changes:** allowed by issuing replacement/re-issuance; in-place mutation minimized in v1.
- **Who can modify:** owner or permitted ancestor authority via governed issuance/lifecycle operations.
- **Retroactivity:** permission changes are non-retroactive unless cascading lifecycle action is explicitly chosen.
- **Delegating authority you lack:** forbidden.
- **Mint vs manage distinction:** `may mint X` = create child credential; `may manage permissions on X` = choose subset within constrained policy envelope.
- **Comment controls:** v1 uses `comments:create` + `comments_enabled` toggle.
- **Post controls:** v1 covers create/edit/moderation/lifecycle via existing permission + role model; finer-grained publish/visibility permissions deferred.

[Alternatives considered]
- [RBAC bundles instead of atomic permission strings.]
- [Explicit deny rules in v1 (deferred due conflict complexity).]

## 6) Resource scoping and access control

- **Scope storage:** array of scope tokens in envelope (`posts:all`, `post:{id}`, future audience tokens).
- **Multiple scopes per key:** yes.
- **Scope combination logic:** union of allows.
- **Post-type constraints:** supported as extensible future scope token (`post_type:{x}`), not mandatory in core v1.
- **Metadata/time constraints:** deferred to advanced policy layer.
- **Read-only vs read+comment:** read by `posts:read`; comment by `comments:create` + toggle.
- **Public visibility:** visible to authenticated key sessions in gateway; anonymous public-read API is not enabled by default.
- **Author override of audience grants:** allowed; updates affect future visibility checks.
- **Model changes across audience types:** reevaluate authorization on next request; no stale ACL cache authority.

[Alternatives considered]
- [Pure ACL rows instead of tokenized scope strings.]
- [Anonymous public feed by default (security tradeoff rejected for v1).]

## 7) Post model

- **Core post fields:** `id,author_id,visibility_scope,state,title,body,created_at` plus soft-delete metadata.
- **Post type registration:** code-driven extension in v1.
- **Visibility schema:** required enum (`public|private|delegated`) in core.
- **Mutability:** editable with revision records.
- **Create/update metadata:** creator/editor principal and timestamps; reason code on revisions.
- **Delete model:** soft-delete by moderation state + delete metadata in v1; hard delete is admin maintenance operation only.
- **Deleted post provenance:** retained in provenance/history.
- **Commentability:** allowed for post types implementing comment-enabled policy.
- **Attachments/media:** not in core v1.
- **Search:** not in core v1.
- **Pagination/order:** chronological cursor feed.

[Alternatives considered]
- [Immutable append-only posts.]
- [Full-text search in v1 baseline (deferred).]

## 8) Comment model

- **Comment fields:** `id,post_id,author_id,body,state,created_at` + soft-delete metadata.
- **Threading:** flat list in v1.
- **Author commenting:** any authenticated key with required permission/toggle and post eligibility.
- **Edit support:** not in v1.
- **Delete support:** moderation delete supported.
- **Moderation authority:** owner/admin moderation surface.
- **Visibility inheritance:** follows parent post visibility and comment state.
- **Media:** not in core v1 comments.
- **Versioning/history:** not required in v1.

[Alternatives considered]
- [Nested threaded comments in v1.]
- [Editable comments with history in v1.]

## 9) Audience model

- **Audience in v1 data model:** scope token abstraction (`audience:{id}`) with dedicated audience entities introduced in v1.1.
- **Audience structure:** named object with membership rules (roadmap), not just ad hoc list.
- **Create/edit/delete authority:** owner/admin scoped permissions.
- **Keychain membership in audiences:** allowed when keychain identity is introduced as first-class audience subject.
- **Nested audiences:** not in v1.
- **Snapshot vs dynamic:** dynamic membership evaluation.
- **Revoked key in audience:** immediately ineffective due credential/session checks.
- **Membership-change latency:** immediate on next request.
- **Post multi-audience support:** yes (represented as multiple scope grants).

[Alternatives considered]
- [Pure static snapshots for simpler evaluation.]
- [No audience objects; only scope strings forever.]

## 10) Keychain behavior

- **Keychain creation/storage:** key principal + credential + keychain membership mapping table (to be added; currently placeholder list behavior in prototype).
- **Allowed members:** author/use keys; no owner credentials.
- **Nested keychains:** forbidden in v1.
- **Cycle prevention:** enforce member type constraint + no-keychain-in-keychain invariant.
- **Duplicate permission merge:** set union.
- **Conflicting scope merge:** intersection for restrictive dimensions, union for positive scope tokens; explicit precedence documented per scope family.
- **Max keys per keychain:** 50 in v1 baseline.
- **Evaluation mode:** dynamic on use (not snapshot).
- **Revoked attached key effect:** immediate loss of that contribution.
- **Public/private conversion:** allowed with explicit transition and audit event.
- **Authorship attribution:** both acting keychain id and resolved source key lineage recorded.
- **Provenance rendering:** show keychain actor + resolved credential chain.

[Alternatives considered]
- [Snapshot-at-add behavior for simpler runtime (less accurate).]
- [Allow nested keychains with DAG cycle detection (complex for v1).]

## 11) Active identity and session behavior

- **Technical meaning:** active identity is the credential context selected by client/session for request authorization.
- **Storage:** client state + bearer token context; server trusts token claims each request.
- **Concurrent active identities:** one active surface context per client session at a time.
- **Feed aggregation across identities:** not in v1; feed is scoped to active identity.
- **Browse one / act another:** not within one request context; user must switch identity.
- **Cache invalidation on switch:** permission cache invalidated client-side immediately; server-side stateless by token.
- **Scope of active identity:** per device/browser session.

[Alternatives considered]
- [Global server-side active identity per user.]
- [Multi-identity merged feed in v1 (complex and ambiguous attribution).]

## 12) Feed logic

- **Primary feed content:** posts visible to active key context under scope + visibility rules.
- **Public+scoped composition:** include public and delegated/private-permitted content per active credential.
- **Duplicate handling:** de-duplicate by post id.
- **Ordering:** reverse chronological by created timestamp, then id tiebreak.
- **Filters:** scope-based filters (`public|delegated`) in v1.
- **Moderation feed:** separate console moderation workflows, not mixed into primary feed.
- **Lineage/provenance feed:** distinct from content feed.

[Alternatives considered]
- [Ranked/relevance feed.]
- [Single merged feed including moderation events.]

## 13) Revocation, suspension, cancellation, and cascading behavior

- **Suspended:** temporary disable of principal access.
- **Cancelled:** permanent disable without necessarily revoking historical records.
- **Revoked:** disable + credential revocation and trust termination.
- **Suspension reversibility:** yes.
- **Cancellation reversibility:** no in v1 policy.
- **Default revocation scope:** selected key only unless cascade explicitly requested.
- **Cascade modes:** none/self-only, descendants-only, full subtree.
- **Active session behavior:** new logins blocked immediately; existing access JWT valid until expiry unless online denylist check enabled.
- **Online revocation checks:** yes at credential login and principal-disabled checks; per-request token denylist is future enhancement.
- **Grace periods:** none for revoke/cancel; optional for suspend expiry.
- **Content visibility for revoked key outputs:** remains unless moderated/deleted.
- **Historical provenance:** always retained.
- **Descendant survival:** only when cascade not selected and policy allows.

[Alternatives considered]
- [Always-cascade revocation.]
- [Immediate JWT blacklist mandatory in v1 (operational overhead).]

## 14) Provenance and lineage

- **Lineage events:** key issue, parent-child relationships, permission/scope envelopes, lifecycle transitions, invite issuance/consumption.
- **Provenance events:** post create/edit/delete/moderate, comment create/moderate, flags, keychain-mediated actions.
- **Lineage scope:** includes revocation and permission-affecting events, not only minting.
- **Provenance scope:** includes posts, comments, moderation actions.
- **Immutability:** append-only records for audit/provenance.
- **UI graph minimum data:** actor, acted-on resource, timestamp, action, reason, parent linkage, depth.
- **Filter/export:** by owner, key, date range, action type; CSV/JSON export in admin tools.
- **Owner visibility:** full descendant activity under owner scope.
- **Keychain actions:** show both keychain and resolved member key where available.

[Alternatives considered]
- [Only key mint lineage, excluding content provenance.]
- [Mutable provenance records (rejected).]

## 15) Moderation workflow

- **Who can flag:** authenticated key principals with post visibility.
- **Flaggable resources:** posts in v1 core; comment flagging may be added in v1.1.
- **Flag reasons:** required reason code, operator-defined taxonomy.
- **Case states:** open, reviewed, actioned, dismissed.
- **Reviewers:** owner/admin moderation roles.
- **Moderator actions:** hide/lock/archive/delete post; hide/lock/delete comment.
- **Key suspension from moderation UI:** allowed as linked governance action for owners/admins with key lifecycle privileges.
- **Appeals/restore:** restore flows are v1.1; v1 uses direct corrective moderation action.
- **Author visibility:** authors may see resulting state changes; internal notes remain private.
- **Audit trail:** required for all moderation actions.
- **Moderation notes visibility:** internal only by default.

[Alternatives considered]
- [Public moderation notes.]
- [No distinct case state machine in v1.]

## 16) API surface and contracts

- **v1 endpoints:** use current grouped routes: public/auth/bootstrap + gateway `/api/*` + console `/console/api/*`.
- **Auth per route:** public bootstrap unauthenticated, gateway requires key JWT + device header, console requires owner JWT.
- **Schemas:** request/response schemas follow current envelope and field validations; formal OpenAPI to be published as next artifact.
- **Success envelope:** `{data,meta}` (+`paging` for lists).
- **Error envelope:** `{error:{code,message,details,request_id},meta}`.
- **Status codes baseline:** 200/201/204 success; 400 malformed request; 401 auth; 403 forbidden; 404 not found; 409 conflict; 422 validation; 429 rate limit; 503 dependency unavailable.
- **Pagination:** cursor-based with `limit,cursor,has_more`.
- **Sort/filter conventions:** query params per endpoint (`scope`,`limit`,`cursor` in feed v1).
- **Versioning:** envelope version header + path-stable v1 routes; future breaking changes via `/v2` route prefix.
- **Idempotency:** GET idempotent; lifecycle/moderation writes non-idempotent unless explicitly designed.
- **Rate limits:** global IP-based limiter for all surfaces with policy config.

[Alternatives considered]
- [Offset pagination only.]
- [Header-only version negotiation without route versioning.]

## 17) HTML parity requirements

- **Parity definition:** functional parity for all supported API actions, including auth requirements, validation, and major error-state handling.
- **Validation parity:** HTML must mirror core validation constraints where feasible and always reflect API validation errors.
- **Filter/pagination parity:** required for operator-critical flows (feed, lists).
- **Rendering model:** JS-driven SPA under `/ui` in v1.
- **CSRF model:** enforced for non-API console write routes; API bearer flows do not use CSRF.
- **Owner vs gateway UI architecture:** single SPA with dual-surface route guards.
- **Usability/a11y baseline:** keyboard navigable, focus-managed, explicit route-state panels, semantic labels/headings.

[Alternatives considered]
- [Server-rendered parity pages.]
- [“Page exists” parity only (insufficient).]

## 18) Data model and persistence

- **Core entities:** principals, principal_emails, credentials, token_families, delegation_envelopes, invite_receipts, posts, post_revisions, post_flags, comments, moderation_actions.
- **Key storage:** secrets hashed (api key hash), never stored plaintext beyond one-time issue display.
- **Lineage storage:** parent envelope linkage + depth + initial author key id.
- **Audience storage:** scope tokens in v1; dedicated audience tables in v1.1.
- **Keychain membership:** dedicated membership tables planned; prototype has list/placeholder semantics.
- **Audit/provenance storage:** moderation tables + structured audit event stream/logs.
- **Post body versioning:** yes via `post_revisions`.
- **Soft-delete retention:** retained indefinitely in v1 unless manual retention policy applied.
- **Indexes required:** principal lookups, credential lookup, envelope principal/parent, feed ordering (`created_at,id`), comments by post, moderation by resource/time.
- **Uniqueness rules:** owner email unique; key/invite ids unique; invite code hash unique by generated id context.

[Alternatives considered]
- [No revision table; in-place edits only.]
- [Hard-delete by default for moderation deletions.]

## 19) Security controls

- **Password hashing:** Argon2id preferred (bcrypt fallback only if unavailable).
- **Secret management:** env-provided PEM/path with strict file permission checks in stage/prod.
- **CSRF:** HMAC request-id token for applicable console HTML writes.
- **XSS/content handling:** escaped rendering in UI; sanitize/encode output and disallow raw HTML execution.
- **Abuse controls:** global rate limiting + device header validation on gateway.
- **Mandatory audit logs:** auth success/failure, key issuance/lifecycle, moderation, security middleware rejects, boot events.
- **PII stored:** owner email, invitee email; avoid unnecessary additional PII.
- **Encryption at rest:** delegated to database/storage platform; app-level crypto for secrets via hashing.
- **Retention/deletion policy:** audit and moderation history retained for governance; operational logs rotated per environment policy.
- **Stolen-key threat model:** rapid revocation, short access token TTL, refresh rotation, replay detection, scope minimization.
- **IP/device fingerprinting:** lightweight device-id header validation only; no invasive fingerprinting in v1.
- **Authz edge-case tests:** required in contract/security suites for claims/audience/type/scope and lifecycle guards.

[Alternatives considered]
- [Mandatory full-device fingerprinting.]
- [Long-lived non-rotating refresh tokens.]

## 20) Operational rules and lifecycle management

- **Boot checks required:** dependency classes, container resolvability, key readiness, profile safety, middleware order integrity.
- **Health checks required:** DB, rate limiter, key material, issuer dependency.
- **Migrations:** service-owned `CREATE TABLE IF NOT EXISTS` bootstrap in prototype; formal migration runner is roadmap.
- **Mandatory env config:** APP_ENV, DB_*, JWT_*, CORS_ALLOWED_ORIGINS, CSRF_SECRET (+ policy vars optional).
- **Observability baseline:** structured logs/audit events with request id correlation.
- **Backup/restore:** required at DB and key material layers; app docs to include runbook expansion.
- **Signing-key rotation rollout:** dual-publish in JWKS, issue new tokens with new key, retire old key after TTL grace.
- **Import/export requirements:** export lineage/provenance and key inventory for governance; controlled import deferred.

[Alternatives considered]
- [No boot-blocking checks (unsafe).]
- [Immediate single-key cutover without overlap (breaks active verifiers).]

## 21) Extensibility model

- **Official v1 extension points:** new application services, routes, middleware, audit emitter backend, policy DTOs, UI pages.
- **New post types registration:** code-level service+route+validation extension.
- **New audience types registration:** v1.1 through dedicated audience module interface.
- **New key types:** not open-ended in v1; allowed through controlled evolution of `key_class` policy.
- **Stable vs internal:** endpoint contracts + envelope + middleware order contracts are stable; internal DB/service details may evolve.
- **Required interfaces:** token signer/verifier, audit emitter, middleware contracts.
- **Custom migrations:** maintain under migration layer once introduced; prototype uses service bootstrap.
- **Custom permissions:** add as namespaced strings with corresponding enforcement in middleware/routes/services.
- **Reference examples:** posts/comments/moderation/key lifecycle modules are the primary templates.

[Alternatives considered]
- [Plugin marketplace model in v1.]
- [Fully dynamic runtime extension loading in v1.]

## 22) XtraType-specific decisions (v1)

- **Exact user flow:** authenticate (owner or key), create annotation post tied to URL + selected text + note/media metadata, view/edit/moderate via existing post workflows.
- **Capture methods:** manual form in v1; browser extension/bookmarklet in v1.1.
- **URL normalization:** required basic canonicalization (scheme/host normalization, fragment trimming policy).
- **Default privacy:** delegated/private by default.
- **Highlighted text storage:** store selected text snippet + optional range metadata.
- **Snapshots:** no full-page snapshots in v1.
- **Media types:** controlled allow-list (images + links) in v1.
- **User-agent metadata:** optional and configurable; default minimal collection.
- **Duplicate URL annotations:** allowed; grouped by normalized URL in UI.
- **Sharing model:** same audience/key sharing controls as core posts.
- **Moderation specifics:** captured content follows standard moderation policies plus URL-safety checks.

[Alternatives considered]
- [Extension-only capture at launch.]
- [Public-by-default annotations (privacy risk).]
- [Store full-page snapshots in v1 (storage/privacy overhead).]

---

## Priority execution order after decisions

1. Publish OpenAPI + JSON schema artifacts for v1 endpoints.
2. Add explicit audience and keychain schema modules.
3. Implement keychain membership/attribution tables and APIs.
4. Add admin delegation model endpoints.
5. Finalize XtraType annotation schema and canonicalization helpers.
