# CRE8 Repository Study Report

Generated: 2026-04-29 (UTC)

This report summarizes the complete current repository contents and how the documents fit together.

## Repository composition

The repository is documentation-heavy with one runtime manifest (`composer.json`) and one environment template (`dot.env`). It currently contains no PHP source files under `src/` and no tests under `tests/`; instead, it defines a seed-canon specification baseline for a future SSOT and implementation.

## Canonical architecture understanding

The repo consistently defines CRE8 as a **Credential Registry Engine** centered on:

- deterministic policy decisioning,
- immutable provenance,
- bounded hierarchical delegation,
- dual-surface UI/API parity,
- mandatory **ID-keypair-first** issuance for delegated principal classes,
- context-scoped **Utility keypairs** for external use.

### Core authority lattice

The authority chain is explicit and repeated across documents:

1. Owner -> Primary Author
2. Primary Author -> Secondary Author and Use
3. Secondary Author -> Use

Delegation is always bounded by ancestor envelopes (permission subset, scope, depth, lifecycle, expiry), and descendants cannot exceed those envelopes.

### Security posture baseline

The canon repeatedly requires:

- proof-based request signing (`public_key_id`, timestamp, nonce, signature),
- replay and skew defenses,
- one-time private-key reveal patterns,
- immediate revocation effect,
- deterministic deny behavior,
- immutable, correlation-friendly audit/provenance events.

## Document-by-document findings

### `README.md`

Acts as the umbrella seed-canon constitution:

- defines the non-negotiable architectural shift to ID-keypair-first issuance,
- reaffirms dual surfaces (Owner Console, API Gateway, public/bootstrap/auth),
- preserves capability set (invites, keychains, audience groups, targeted posts/comments, feed),
- sets obligations for future document updates,
- maps supporting files and positions `CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md` as root anchor.

### `CRE8_SEED_CANON_INDEX.md`

Defines governance of the seed set:

- required reading order,
- domain ownership map by document,
- strict terminology and deterministic normative language constraints,
- maturation expectation toward fuller SSOT artifacts.

### `CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`

The foundational model inventory:

- explicit non-negotiable outcomes,
- actor model and operation modes,
- mandatory minting and ID-vs-Utility role split,
- permissioning/delegation semantics,
- content/audience/feed capabilities,
- parity and credential-entry shaping,
- seed-to-SSOT expansion checklist and acceptance criteria.

### `CRE8_PERMISSION_AND_DELEGATION_SEED.md`

Concise delegation contract:

- bounded hierarchy,
- explicit pass-through delegation constraints,
- composable policy module requirement,
- PDP/middleware as sole authority,
- provenance requirements for delegation mutations.

### `CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`

Lifecycle + crypto intent:

- ID keypair as lineage anchor,
- Utility keys as isolated context proxies,
- crypto verification and sensitive-storage expectations,
- immediate revocation and immutable lifecycle events.

### `CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md`

Surface and client model:

- three operational surfaces,
- deployment mode flexibility,
- CRE8.pw as reference first-party client,
- parity intent across first-party and third-party channels.

### `CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md`

Content semantics baseline:

- preserved content primitives (targeting, audience groups, keychains, policy-gated comments),
- authorization/visibility rules tied to effective permissions + lineage + lifecycle,
- immediate access loss on revoked/suspended credentials,
- feed contract (authorized-only, newest-first, deterministic tie-breaking),
- extension obligations preserving PDP/provenance invariants.

### `CRE8_API_CONTRACT_AND_ERROR_SEED.md`

Contract and denial determinism:

- success/error envelope invariants,
- versioned contract evolution,
- deterministic PDP->HTTP/error-code mapping,
- prohibition on handler-level remapping,
- protected-surface boundary rules,
- parity and correlation ID traceability obligations.

### `CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md`

Extension guardrails:

- module/interface driven extension preference,
- no invariant regression while extending,
- examples (direct messaging, media/file, integrations),
- mandatory inheritance of delegation/audience/feed semantics.

### `CRE8_SEED_PRESERVATION_MATRIX.md`

Preservation-accountability matrix:

- explicit preserved concepts,
- mandatory redesign concepts,
- dropped assumptions,
- concrete follow-up authoring tasks.

### `CRE8_SEED_CANON_ASSESSMENT_REPORT.md`

Most detailed meta-analysis in repo:

- states seed is strong but not yet production-grade SSOT,
- identifies missing formal artifacts (state machines, route inventory, error catalog, data model, threat model, release gates),
- proposes prioritized closure roadmap with staged implementation plan,
- includes risk register with mitigations and evidence expectations,
- lists immediate first 10 authoring steps.

## Runtime/tooling signals

### `composer.json`

Indicates intended PHP implementation stack:

- PHP 8.5 baseline (Composer `^8.5.5`, platform `8.5.5`),
- Slim framework + PSR-7,
- DI (`php-di`), JWT (`firebase/php-jwt`), validation, dotenv,
- CORS, logging, rate-limiting/cache,
- PHPUnit in dev dependencies,
- scripts include QA, test subsets, ops smoke, and docs SSOT lint/sync/report hooks.

This suggests a planned transition from pure-seed docs to enforceable documentation and runtime checks.

### `dot.env`

Environment template with security-sensitive placeholders and policy hints:

- DB connection variables,
- JWT issuer/audience and key path structure,
- CORS rules by environment,
- CSRF secret minimum length,
- optional rate limit and token TTL overrides,
- owner signup mode policy switch.

## Cross-document consistency observations

Strongly consistent themes:

- ID-keypair-first is universal across core docs,
- bounded delegation and PDP-first enforcement are consistently mandatory,
- parity and deterministic behavior recur throughout,
- provenance and auditability are treated as first-class requirements.

Notable maturity gaps acknowledged by the repo itself:

- no explicit permission token registry yet,
- no formal lifecycle state machines or transition tables,
- no full route inventory and error-code catalog,
- no concrete crypto suite parameters,
- no formalized data/provenance schema definitions,
- no release-gate evidence model implemented yet.

## Overall conclusion

The repository currently functions as a **high-quality strategic specification seed**, not an implementation repo. It provides a clear canonical direction, strong invariants, and a credible path to production SSOT maturity. The next logical step is to convert these normative requirements into explicit, testable artifacts and then bind runtime code and CI gates to those artifacts.

## Dependency-grounded architecture directives (new alignment)

Following further review, the repository direction should explicitly bind each functional domain to installed dependencies:

- Surface routing/error pipeline: `slim/slim` + `slim/psr7`.
- Composition root and module wiring: `php-di/php-di`.
- Key/JWT verification and claims enforcement: `firebase/php-jwt`.
- Credential hashing/randomness/constant-time compare: `ext-sodium`.
- Policy/provenance persistence: `ext-pdo` with transactional writes.
- Request schema enforcement and deterministic 422 details: `respect/validation`.
- Startup env validation and typed configuration: `vlucas/phpdotenv`.
- Outbound integration (JWKS/webhooks): `guzzlehttp/guzzle`.
- CORS enforcement: `neomerx/cors-psr7`.
- Structured application/security/provenance logging: `monolog/monolog`.
- Abuse throttling and limiter state: `symfony/rate-limiter` + `symfony/cache`.
- Contract/lifecycle/security regression evidence: `phpunit/phpunit`.

Each SSOT document should carry explicit dependency references so architectural intent and implementation mechanics remain intrinsically linked.

## Repository caveat verification notes

During direct filesystem review, the canonical seed overview is present as `seed/seed-intro.md` (titled "CRE8 Seed Canon README"). A repository-root `README.md` file is not currently present in this checkout, so references to `README.md` in seed navigation docs should be interpreted as pointing to `seed/seed-intro.md` unless/until a root README is added.
