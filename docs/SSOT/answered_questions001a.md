# CRE8 Open Questions 001A — Executive Resolutions

_Status: adopted_
Date resolved: 2026-04-06 (UTC)

This file captures definitive answers for the 15 consolidated open questions.

---

1. **What is a Key, exactly?**

**Answer:** A key is a database-backed principal credential represented by: (a) principal record, (b) hashed secret credential, and (c) delegation envelope (permissions/scope/depth/expiry). Keys authenticate to obtain short-lived JWT access tokens and rotatable refresh tokens.

[Alternatives considered]
- [Pure opaque API-key auth without JWT sessions.]
- [JWT-as-key model where key itself is a long-lived token.]

2. **What are the exact permission semantics?**

**Answer:** v1 uses allow-list permission strings with scope constraints. Delegation is subset-only: child permissions/scope can never exceed parent envelope. No explicit deny in v1. Post-mint change is primarily by re-issuance and lifecycle controls.

[Alternatives considered]
- [Role bundles only (RBAC-first).]
- [Allow + deny policy graph in v1.]

3. **What are the missing minting rules?**

**Answer:** Owner may mint primary/secondary/use. Secondary may mint secondary/use only when parent allows (`keys:issue`) and all guardrails pass. Use keys and keychains cannot mint. Secondary cannot mint primary. Max depth is 3.

[Alternatives considered]
- [Allow secondary-to-primary with owner approval.]
- [No secondary minting at all.]

4. **How do revocation and suspension actually work?**

**Answer:** Suspend = reversible disable. Cancel = permanent disable. Revoke = disable plus credential revocation and trust termination. Cascade is explicit option (self/descendants/full subtree). Active JWTs naturally expire quickly; new auth is blocked immediately.

[Alternatives considered]
- [Always-cascade revoke.]
- [Immediate JWT blacklist required for all revoked keys in v1.]

5. **How do Keychains resolve conflicts and provenance?**

**Answer:** Keychains aggregate attached keys dynamically at use time. No nested keychains in v1. Duplicate perms union; restrictive scope dimensions intersect. Actions record keychain actor plus resolved source-key lineage.

[Alternatives considered]
- [Snapshot permissions at add-time.]
- [Nested keychains with cycle detection.]

6. **Who exactly are Admins, and how do they differ from Owners?**

**Answer:** Admin is an owner-delegated tenant-scoped governance role. Owners keep ultimate governance (admin delegation, root key controls, policy control). Admin cannot cross owner boundaries.

[Alternatives considered]
- [Global platform admin role in core product.]
- [No admin role, owner-only governance.]

7. **What is an Audience, structurally?**

**Answer:** v1 treats audience as scope-token abstraction with planned named audience entities. Audience membership is dynamic, owner-governed, and supports post sharing to one or multiple audiences.

[Alternatives considered]
- [Only static key lists.]
- [Rule-based audiences only, no named objects.]

8. **What is the exact feed behavior?**

**Answer:** Feed is per active identity and ordered reverse-chronologically with cursor pagination and de-duplication. It includes content visible under active scope plus allowed public items.

[Alternatives considered]
- [Merged multi-identity feed.]
- [Ranking/relevance feed default in v1.]

9. **What are the moderation rules and lifecycle?**

**Answer:** Keys can flag posts; owners/admins moderate posts/comments. Supported actions: post `hide|lock|archive|delete`, comment `hide|lock|delete`. Every moderation decision is auditable with reason metadata.

[Alternatives considered]
- [Flag-only moderation with no direct state transitions.]
- [Public moderation note visibility.]

10. **What are the concrete API contracts?**

**Answer:** v1 contracts are grouped public/auth, gateway, console routes with envelope responses. Authn/authz, status codes, pagination, and validation semantics are standardized around existing route/middleware model and should be formalized in OpenAPI as next artifact.

[Alternatives considered]
- [GraphQL-first API.]
- [No common envelope contract.]

11. **What is the underlying data model?**

**Answer:** Core entities: principals, credentials, emails, refresh families, delegation envelopes, invites, posts, post revisions, post flags, comments, moderation actions, plus audit event stream.

[Alternatives considered]
- [Single-table JSON blob model for all entities.]
- [No revision/event persistence in core.]

12. **What are the security/privacy requirements beyond auth?**

**Answer:** Argon2id password hashing, hashed API keys, key material hardening, CSRF protections where applicable, CORS policying, rate limiting, device header checks, structured audit logs, short TTLs, refresh replay detection, and conservative PII retention.

[Alternatives considered]
- [Long-lived bearer tokens with no rotation.]
- [Collect rich device fingerprinting by default.]

13. **What does “full HTML parity” really require?**

**Answer:** Functional parity: every supported API action must have usable HTML flow with equivalent auth context, validation behavior, and error-state handling—not just endpoint existence.

[Alternatives considered]
- [Basic link/page parity only.]
- [API-only parity with no UX-state equivalence.]

14. **How extensibility is meant to work in practice**

**Answer:** Extension is pattern-based and code-first in v1: add service + route + validation + docs/tests following established module structure. Stable extension surfaces include middleware contracts, audit interface, and envelope/API contracts.

[Alternatives considered]
- [Dynamic plugin runtime in v1.]
- [Config-only extensibility with no code module pattern.]

15. **What is in and out of scope for XtraType v1?**

**Answer:** In scope: manual annotation creation (URL + selected text + notes/media metadata), delegated visibility, standard moderation, and feed/listing integration. Out of scope: mandatory browser extension, full-page snapshots, and advanced dedupe/semantic clustering.

[Alternatives considered]
- [Extension-required launch.]
- [Public-by-default annotations.]
- [Full webpage archive storage in v1.]
