## 1) Identity, credential, and token model

The spec defines multiple key types and mentions JWT/JWKS, but not the exact credential architecture. 

* What is the canonical form of each key type: opaque secret, signed token, database record, or hybrid?
* Are Primary Author Keys, Secondary Author Keys, Use Keys, and Keychain Keys all represented the same way?
* Are keys long-lived credentials, short-lived bearer tokens, or credentials that exchange for JWTs?
* What is the exact role of JWTs in the system?
* When is a JWT issued, by whom, and with what claims?
* Which claims are mandatory for each surface?
* What is the exact role of JWKS?
* Are signing keys global, per environment, per tenant, or rotated on a schedule?
* What are token lifetimes, refresh rules, and re-authentication rules?
* Can keys expire automatically?
* Can keys be one-time-use, limited-use, or time-boxed?
* What recovery path exists if a key is lost?

## 2) Owner account model

The spec says Owners register through the UI Console and can mint invitation keys and author keys, but important account details are not defined. 

* How is the first Owner created?
* Is CRE8 single-tenant or multi-tenant?
* Does each Owner control only their own namespace, or can multiple Owners manage the same application space?
* Can an Owner belong to multiple organizations/projects?
* What fields are required for Owner registration?
* What login identifiers are supported: email, username, both?
* What password policy is required?
* Is MFA required, optional, or not supported?
* What account recovery flow is supported?
* Can Owners be suspended or deactivated?
* Can one Owner create another Owner directly, or only through invitation keys?

## 3) Admin role and governance

Admins are mentioned in moderation and key control, but their authority is not defined. 

* What is an Admin in this system?
* Is Admin a global platform role, tenant role, or Owner-delegated role?
* Who can create Admins?
* What can Admins do that Owners cannot?
* What can Owners do that Admins cannot?
* Can Admins see all data or only scoped data?
* Can Admins revoke keys across Owner boundaries?
* Are Admin actions fully audited?
* Is there a super-admin role distinct from regular admin?

## 4) Key taxonomy and minting rules

The spec names the key types and some defaults, but the full minting matrix is incomplete. 

* Can a Secondary Author Key mint another Secondary Author Key?
* Can a Secondary Author Key mint a Primary Author Key?
* Can a Use Key mint anything at all?
* Can a Keychain Key mint anything?
* Can an Owner mint Use Keys directly?
* Can an Owner mint Secondary Author Keys directly?
* Are there system-level restrictions that overrides cannot bypass?
* Can a child key ever receive permissions the parent does not have?
* Can a parent key restrict downstream delegation depth?
* Is there a maximum lineage depth?
* Are there quotas on number of descendant keys?
* Are invitation keys single-use or multi-use?
* Do invitation keys expire?
* Can invitation keys be scoped to a specific email/domain/person?

## 5) Permission system semantics

The spec gives examples of permissions but not the formal model. 

* What is the complete list of permissions in v1?
* Are permissions simple booleans, scopes, resource filters, or role bundles?
* Is the model allow-only, or does it also support explicit deny?
* How are inherited permissions computed?
* Can permissions be modified after minting?
* If yes, who may modify them?
* Are permission changes retroactive to descendants?
* Can a minter delegate permission to manage permissions they do not themselves possess?
* What is the difference between “may mint X” and “may manage permissions on X”?
* Are comments controlled by a single permission, or by separate view/comment/edit/delete comment permissions?
* Are post permissions separate for create, edit, delete, publish, visibility change, and moderation?

## 6) Resource scoping and access control

The spec says Use Keys may access all posts, a specific post, or an audience of posts, but not how that scope is represented or enforced. 

* How is access scope stored on a key?
* Can one key have multiple scopes at once?
* If a key has both specific-post access and audience access, how are they combined?
* Can access be limited by post type?
* Can access be limited by time range, tag, or metadata?
* Can access be read-only versus read-plus-comment?
* Are public posts visible to all anonymous users, all key holders, or all authenticated users?
* Can authors override an existing granted audience later?
* What happens when a post moves from one audience model to another?

## 7) Post model

Posts are central, but the base post contract is still undefined. 

* What fields exist on every post in core CRE8?
* Are post types registered through code, config, or database metadata?
* Is there a required schema for post visibility?
* Are posts immutable, versioned, or freely editable?
* What metadata is captured on create and update?
* Is there soft delete, hard delete, or both?
* Can a deleted post still appear in provenance history?
* Can comments exist on all post types?
* Can posts have attachments/media in core?
* Are posts searchable?
* Are posts paginated chronologically, by rank, or by another strategy?

## 8) Comment model

The spec says Use Keys may comment if allowed, but comment behavior is underspecified. 

* What fields exist on a comment?
* Are threaded comments supported?
* Can Authors comment on their own posts through author keys only, or also through use keys?
* Can comments be edited?
* Can comments be deleted?
* Who can moderate or hide comments?
* Are comments subject to the same audience visibility as the parent post?
* Can comments contain media?
* Is comment history/versioning required?

## 9) Audience model

Audiences are important to access control and extensibility, but the structure is not defined. 

* What is an Audience in the data model?
* Is an Audience a named object, a list of keys, a rule, or a custom pluggable type?
* Who may create audiences?
* Who may edit or delete them?
* Can audiences contain keychains as members?
* Can audiences be nested?
* Are audiences snapshots or dynamic groups?
* What happens when a key is revoked but still belongs to an audience?
* Are audience membership changes immediate?
* Can posts belong to multiple audiences?

## 10) Keychain behavior

The spec says keychains aggregate permissions from attached keys, but many operational details are open. 

* How is a Keychain Key created and stored?
* Can a keychain contain any key type, or only Use/Author keys?
* Can a keychain contain another keychain?
* If not, how is nesting prevented?
* How are duplicate permissions merged?
* How are conflicting scopes resolved?
* What is the maximum number of keys per keychain?
* Does the keychain snapshot permissions at add-time, or evaluate them dynamically on use?
* If an attached key is revoked, does the keychain lose that power immediately?
* Can a public keychain be converted to private or vice versa?
* How is authorship attributed when acting through a keychain?
* How is provenance displayed for actions taken through a keychain?

## 11) Active identity and session behavior

The spec says the active key or keychain drives feed and grants, but not the UX or API rules. 

* What does it mean to “set active Key or active Keychain” technically?
* Is active identity stored in session, token, database, or client state?
* Can a user have more than one active identity at once?
* Can the feed aggregate across multiple credentials, or only one active credential?
* Can a user browse with one identity and perform actions with another?
* How does switching active identity affect cached permissions?
* Is active identity per device, per browser, or global?

## 12) Feed logic

Feed behavior is referenced, but not specified. 

* What content appears in the primary feed?
* Does the feed include public posts plus scoped posts, or only scoped posts?
* How are duplicate posts handled when accessible via multiple paths?
* How is feed ordering determined?
* Are there visibility filters by post type or audience?
* Is there a separate moderation feed?
* Is there a lineage/provenance activity feed distinct from content feed?

## 13) Revocation, suspension, cancellation, and cascading behavior

The spec mentions these terms but does not define system behavior. 

* What is the exact difference between suspended, cancelled, and revoked?
* Is suspension reversible?
* Is cancellation irreversible?
* Does revocation affect only the selected key or also descendants by default?
* What cascade options must the API support?
* What happens to active sessions and already-issued JWTs after revocation?
* Is revocation checked online on every request?
* Are there grace periods?
* Can posts/comments created by a revoked key remain visible?
* Can a revoked key’s historical actions still appear in provenance?
* Can a descendant survive if an ancestor is revoked?

## 14) Provenance and lineage

The spec promises powerful visibility into lineage and provenance, but the event model is not defined. 

* What events must be captured for lineage?
* What events must be captured for provenance?
* Is lineage only about key minting, or also permission edits and revocations?
* Is provenance only about posts, or also comments and moderation actions?
* Are provenance records immutable?
* What data must be shown in the UI graphs?
* What filtering and export options are required?
* Can Owners view only what they created, or all descendant activity forever?
* How is provenance represented for actions taken via keychains?

## 15) Moderation workflow

The spec says users can flag posts for Owner/Admin review, but the workflow is not yet operationally defined. 

* Who can flag content?
* Can both posts and comments be flagged?
* What reasons can be selected when flagging?
* What states exist for a moderation case?
* Who can review a case?
* What actions can moderators take?
* Can moderators suspend keys from the moderation workflow directly?
* Is there an appeals or restore flow?
* Are moderation actions visible to content authors?
* Is a moderation audit trail required?
* Are moderation notes internal only?

## 16) API surface and contracts

The technical foundation names route groups, middleware, and response envelopes, but not the concrete contracts. 

* What are the exact v1 endpoints?
* What authentication method applies to each endpoint?
* What request and response schemas are required for each route?
* What is the standard response envelope shape?
* What is the standard error envelope shape?
* What HTTP status codes will be used in each common scenario?
* What pagination format will be used?
* What sorting and filtering conventions will be used?
* How will API versioning be handled?
* Which endpoints are idempotent?
* What rate limiting rules apply per surface?

## 17) HTML parity requirements

The spec says every API action has parity HTML pages, but “parity” is not yet measurable. 

* Does parity mean complete feature equivalence, or only basic access?
* Must every API validation rule be mirrored in HTML flows?
* Must HTML pages expose all filters, pagination, and edge-case actions?
* Are HTML pages server-rendered, progressively enhanced, or JS-driven?
* How is CSRF handled for the HTML surface?
* Are Owner UI and gateway parity pages separate applications or one app?
* What usability/accessibility baseline is required for the HTML interface?

## 18) Data model and persistence

The spec emphasizes extensibility and migrations, but the base schema is not defined. 

* What are the core tables/entities in v1?
* How are keys stored securely?
* How are lineage relationships stored?
* How are audiences stored?
* How are keychain memberships stored?
* How are provenance and audit events stored?
* Are post bodies versioned?
* Are soft-deleted records retained forever?
* What indexes are required for access checks and feed queries?
* What uniqueness rules apply to keys and invitations?

## 19) Security controls

The spec says the system is secure and includes strong tests, but the required controls are still open. 

* What password hashing algorithm and parameters will be used?
* What secret management approach will be used for signing keys and app secrets?
* What CSRF protections are required for HTML pages?
* What XSS/content sanitization rules apply to posts and comments?
* What rate limiting and abuse protections are required?
* What audit logs are mandatory?
* What personally identifiable information is stored?
* What encryption-at-rest requirements apply?
* What retention and deletion policies apply to logs and content?
* What threat model is assumed for stolen keys?
* Is IP/device fingerprinting used at all?
* What test coverage is required for authz edge cases?

## 20) Operational rules and lifecycle management

The system needs administrative rules beyond pure feature definitions. 

* What boot checks must pass before startup?
* What health checks are required?
* How are migrations run and rolled back?
* What environment configuration is mandatory?
* What observability is required: logs, metrics, traces?
* Are there backup and restore requirements?
* What is the rollout strategy for signing key rotation?
* Are there import/export requirements for keys, audiences, or provenance?

## 21) Extensibility model

The spec says developers can copy patterns and extend the platform, but the extension contract is still informal. 

* What parts of CRE8 are officially extensible in v1?
* How are new post types registered?
* How are new audience types registered?
* Can developers define new key types safely?
* What extension points are stable API versus internal-only?
* What interfaces or abstract classes must custom modules implement?
* How are custom migrations organized?
* How are custom permissions introduced?
* What examples will ship as reference implementations?

## 22) XtraType-specific open questions

The first use case is named, but its implementation boundaries are still open. 

* What is the exact XtraType v1 user flow?
* How is a URL annotation created: browser extension, bookmarklet, manual form, API client?
* Is URL normalization/canonicalization required?
* Are annotations private by default?
* How are highlighted text snippets stored?
* Are full-page snapshots stored, or only selected text?
* What media types are allowed?
* Is user-agent metadata always collected, optional, or configurable?
* How are duplicate annotations on the same URL handled?
* Can annotations be shared to audiences or individual keys the same way as other posts?
* Are there any content moderation rules specific to captured web content?

# Recommended decisions to make first

These are the ones I would resolve before writing core implementation code:

1. **Exact key/token architecture**
2. **Formal permission and delegation rules**
3. **Full minting matrix**
4. **Revocation/suspension/cascade semantics**
5. **Audience data model**
6. **Keychain evaluation and attribution rules**
7. **Base post/comment schema**
8. **v1 API contracts**
9. **Owner/Admin governance model**
10. **Security baseline requirements** 

# Execute: Create the next artifact

Convert this into a **decision log template** with columns like:

* Question
* Decision owner
* Proposed answer
* Alternatives considered
* Final decision
* Impacted components
* Priority