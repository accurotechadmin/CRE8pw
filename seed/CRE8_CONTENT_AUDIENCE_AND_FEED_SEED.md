# CRE8 Content, Audience, and Feed Seed

CRE8 content behavior MUST remain policy-governed, key-aware, and deterministic across Owner Console and API Gateway surfaces.

## 1) Content primitives that MUST be preserved
- Posts MUST support granular targeting to individual Use Keys, key collections, and Audience Groups.
- Audience Groups MUST be reusable policy artifacts for repeatable access targeting.
- Keychains MUST support aggregated access paths where owner-governed keychain policy allows.
- Comments MUST be available to Use Key bearers only when explicitly permitted by policy (`comments:create` or successor token).

## 2) Authorization and visibility semantics
- Read and interaction visibility MUST be computed from effective permissions + scope + lifecycle status + delegation lineage.
- Revoked/suspended/cancelled credentials MUST lose access immediately.
- Descendant keys MUST NOT gain visibility beyond ancestor-granted envelopes.

## 3) Feed contract baseline
- Each authenticated principal experience MUST expose a feed containing authorized posts/events only.
- Feed ordering MUST be reverse chronological (newest first) with deterministic tie-breaking.
- Feed generation logic MUST remain surface-parity consistent: equivalent credentials produce equivalent resource visibility via UI and API.

## 4) Extensibility requirements
- New content families (for example direct messages or media/file objects) MUST plug into the same policy and provenance model.
- New interaction types MUST NOT bypass PDP-first authorization and MUST preserve envelope/error determinism.
- Any extension MUST emit immutable provenance/audit events for creation, mutation, and moderation/lifecycle actions.

## Dependency anchoring for content, audience, and feed
Content/audience/feed APIs SHOULD use `slim/slim` route families with `slim/psr7` responses. Visibility inputs SHOULD be schema-validated via `respect/validation`; feed and permission reads/writes SHOULD use `ext-pdo` prepared statements and transaction scopes; feed abuse throttling SHOULD use `symfony/rate-limiter`; moderation and visibility decisions SHOULD emit structured provenance-ready logs via `monolog/monolog`.
