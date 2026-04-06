1. **What is a Key, exactly?**
   The spec says CRE8 uses JWT, JWKS, and several kinds of Keys, but it never fully explains whether Primary/Secondary/Use/Keychain Keys are raw secrets, signed tokens, database-backed opaque codes, or some combination. It also does not define their format, expiry, rotation rules, recovery rules, or how JWKS relates to them. 

2. **What are the exact permission semantics?**
   The document gives defaults for who may mint what and who may post/comment, but it does not define the permission model precisely enough for implementation. For example: is permission inheritance additive only, can child keys ever exceed parent scope, are there explicit denies, can permissions be edited after minting, and are there hard ceilings on delegated authority? 

3. **What are the missing minting rules?**
   Some defaults are stated, but not the full matrix. For example, can a Secondary Author Key mint another Secondary Author Key? Can a Use Key ever mint anything? Can Keychains mint Keys? Can an Owner mint anything besides invitation keys and Owner-generated Primary Author Keys? 

4. **How do revocation and suspension actually work?**
   The spec mentions suspended, cancelled, individual revocation, and cascading revocation, but not their exact behavior. Does suspension instantly block access? Does cancellation permanently destroy trust? What happens to descendant keys? What happens to already-issued JWTs or cached sessions? 

5. **How do Keychains resolve conflicts and provenance?**
   The spec says a Keychain aggregates permissions from attached keys, but it does not define conflict resolution, duplicate permissions, nested keychains, cycle prevention, or action attribution. If a post/comment is made through a Keychain, is authorship attributed to the Keychain, the underlying source key, or both? 

6. **Who exactly are Admins, and how do they differ from Owners?**
   Admins appear in moderation and key control, but their role is not defined. Are Admins global platform operators, tenant-level staff, or Owner-delegated roles? How are they created? What boundaries prevent one Admin from crossing into another Owner’s domain? 

7. **What is an Audience, structurally?**
   “Audience of Posts” and “Audience group types” are central ideas, but the document does not define whether audiences are named groups, dynamic filters, snapshots, lists of keys, or something extensible. It also does not say who can create/edit/delete them.

8. **What is the exact feed behavior?**
   The spec says the active Key or Keychain determines feed/access, but not how the feed is composed. Is it chronological only? Does it merge public posts with accessible private/audience posts? What happens when a user has multiple relevant credentials? Can a user act under one credential while viewing another feed? 

9. **What are the moderation rules and lifecycle?**
   Posts can be flagged for review, but the workflow is not defined. What happens after a flag? Can comments be moderated separately? Are there soft deletes? Appeals? Audit trails? Visibility states like pending/hidden/removed? 

10. **What are the concrete API contracts?**
    The spec says there are routes for auth, content, moderation, keys, health, and JWKS, plus envelope-based responses and parity HTML pages, but it does not define endpoints, request/response schemas, status/error codes, idempotency rules, versioning, pagination, or rate limiting. 

11. **What is the underlying data model?**
    The document talks about extensibility and migrations, but not the base entities/tables or key relationships. For implementation, you still need explicit models for owners, keys, key lineage, audiences, keychains, posts, comments, moderation events, and provenance history.

12. **What are the security/privacy requirements beyond auth?**
    The spec says “strong contract and security tests,” but it does not define password policy for Owners, hashing standards, CSRF/session strategy for HTML pages, audit logging, encryption-at-rest expectations, abuse prevention, or storage/privacy policy for user-agent metadata and annotation content. XtraType especially raises privacy questions around URL capture, highlighted text, and media.

13. **What does “full HTML parity” really require?**
    The spec says every API action has parity HTML UI, but it does not say whether parity means full feature equivalence, same validation, same error handling, same auth flow, same pagination/filtering, or merely “a page exists for every endpoint.” 

14. **How extensibility is meant to work in practice**
    The document says developers can copy patterns and extend post types, audience group types, and perhaps key types, but it does not define the extension mechanism: inheritance, interfaces, registration hooks, migrations, config-driven schemas, plugin modules, or package boundaries. 

15. **What is in and out of scope for XtraType v1?**
    XtraType is named as the first use case, but many product questions remain open: how annotations are captured, whether a browser extension is required, what media types are allowed, whether annotations are private by default, whether URL canonicalization is needed, and how duplicate annotations on the same URL are handled. 

