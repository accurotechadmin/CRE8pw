# CRE8 Seed Canon README

_Status: authoritative seed overview_  
_Last updated (UTC): 2026-04-29_

## 1) Why this seed canon exists
This seed canon is the launchpad for the canonical CRE8 SSOT repository. It preserves the essential CRE8 ethos: deterministic governance, safe delegation, dual-surface operation, and auditable trust.

This document set is not a scratchpad. It is the SSOT seed canon that captures required CRE8 invariants and intentional redesigns. The primary redesign is the **ID-keypair-first architecture** for delegated principals.

---

## 2) Core CRE8 identity (new iteration)
CRE8 is a **Credential Registry Engine**: a policy-governed platform for identity, delegated authority, access control, and protected content interactions. It is engineered to be both highly secure and highly practical: powerful enough for deep governance, simple enough for broad PHP developer adoption, and mostly invisible to end users as it embeds into products built on top of it.

The new iteration keeps CRE8’s original strengths (deterministic policy behavior, strong provenance, contract discipline) while modernizing the key model so identity and external utility access are explicitly separated and lifecycle-governed.

---

## 3) Non-negotiable architectural shift: ID keypairs first
### 3.1 Mandatory issuance model
When any of these are minted, they MUST receive an initial private/public **ID Keypair**:
- Primary Author Key
- Secondary Author Key
- Use Key

### 3.2 Utility keypair expansion
ID-key holders may mint additional private/public **Utility Keypairs** per service, app, device, tenant, or usage context. Utility keys are intentionally context-scoped proxy credentials.

### 3.3 Internal vs external role separation
- **ID Keys**: internal CRE8 identity anchor and lineage root.
- **Utility Keys**: externalized credential keys used with third-party services/contexts.

This separation allows compartmentalization, safer revocation boundaries, and clearer operational governance.

---

## 4) Delegation and permission authority chain
CRE8 permissioning is hierarchical and bounded:
1. **Owner** sets permissions and delegation bounds for Primary Author Keys it creates.
2. **Primary Author** sets permissions and delegation bounds for Secondary Author and Use Keys it creates.
3. **Secondary Author** sets permissions and delegation bounds for Use Keys it creates.

Each tier also controls which permissions descendants are allowed (or forbidden) to further delegate. Descendants can never exceed ancestor-granted envelopes (permission subset, scope, depth, lifecycle, expiry, and policy constraints).

Owners retain Master-governance visibility and control over keys generated under their authority.

---

## 5) Operating modes (deployment flexibility)
CRE8 supports multiple valid operator choices without architectural fracture:
- **Invite-based multi-owner mode**: owners can invite additional owners.
- **Single-owner API-only mode**: no owner signup, operator remains sole owner, integrations run via API credentials.
- **Traditional account mode**: username/email/password-centric usage as desired.
- **Hybrid mode**: both account-based and key/API-based access patterns.

These are policy/configuration choices, not forks of platform identity.

---

## 6) Dual-surface platform model (kept and strengthened)
CRE8 remains a dual-surface application platform:
- **Owner Console UI**: owner-only governance experience.
- **API Gateway UI**: key-bearer operational experience.
- **Public/bootstrap/auth surface**: controlled entry and setup flows.

The CRE8.pw site functions as a first-party API client example. Third-party applications can interact by sending API requests with required proof inputs and credential shape. The model requires **UI/API parity architecture** so every API action has a corresponding UI path.

---

## 7) Working model capabilities to preserve
The new canon must preserve these concrete platform behaviors:
- owner invitation of owners,
- creation/lifecycle governance for Primary Author, Secondary Author, and Use keys,
- keychain composition for aggregated permissions,
- audience groups for reusable access targeting,
- posts with granular targeting (individual keys, collections, audience groups, keychain-linked access paths),
- comments by Use-key bearers when allowed,
- user feed containing all accessible posts/events in newest-first order.

The platform should continue to feel coherent whether accessed through first-party UI or third-party clients.

---

## 8) Credential entry, UI shaping, and runtime behavior
At session/runtime entry, users may provide:
- one or multiple Public Utility Keys as credential keys,
- optionally a Keychain key that aggregates capabilities.

Entered credentials deterministically control:
- what UI is presented,
- what actions are available,
- what resources/interactions are visible,
- what posting/commenting operations are authorized.

When users require access to a new context (another user domain, another service, another integration), they should receive new Utility keypairs scoped to that context.

---

## 9) Security and trust posture
CRE8’s trust model is built on layered controls where they matter most:
- one-time private key reveal patterns,
- hardened hashing/encryption for sensitive material,
- proof-based request verification (`public_key_id`, timestamp, nonce, signature),
- replay and skew defenses,
- deterministic deny semantics,
- rapid revoke/rotate with immediate enforcement impact,
- immutable provenance events for lifecycle and policy actions,
- auditable evidence/export pathways for compliance and incident response.

All keys can be revoked/rotated by authorized private-key bearers (or by owner authority where policy allows), cutting access for affected keys immediately.

---

## 10) Extensibility promise (developer-first)
The new CRE8 seed is explicitly designed for extension by PHP developers:
- new post types,
- new account/principal types,
- new permission families,
- new audience/governance workflows,
- new integration channels.

Planned growth examples include direct messaging, file/image/media sharing, and richer content workflows—without breaking policy determinism, security boundaries, or provenance integrity.

---

## 11) Canon preservation strategy
The migration strategy is:
1. Preserve every essential CRE8 invariant.
2. Express all requirements under the ID-keypair-first architecture.
3. Remove or rewrite assumptions that conflict with bounded delegation and modernized governance boundaries.
4. Produce a coherent, portable seed canon that serves as SSOT origin.

`CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md` is the root seed anchor. Supporting seed files decompose the model into permissions, lifecycle/crypto, surfaces/parity, extensibility, and indexing.

---

## 12) What this README obligates future authoring to do
Any future seed-canon document updates MUST:
- remain consistent with ID-keypair-first minting,
- preserve bounded hierarchical delegation,
- preserve dual-surface and UI/API parity principles,
- preserve deterministic contracts, error behavior, and PDP-first policy enforcement,
- preserve audit/provenance and lifecycle governance rigor,
- improve extensibility without weakening security invariants.

When this seed set is complete enough, it MUST be matured into full production-grade SSOT documentation and implementation guidance.


## 13) Seed document map (navigation)
- `CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`: root architectural inventory and acceptance baseline.
- `CRE8_PERMISSION_AND_DELEGATION_SEED.md`: bounded hierarchical authority and policy rules.
- `CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`: lifecycle security and cryptographic controls.
- `CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md`: dual-surface architecture and UI/API parity rules.
- `CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md`: content targeting, audience model, comments, and feed behavior.
- `CRE8_API_CONTRACT_AND_ERROR_SEED.md`: envelope-first contract and deterministic deny/error mapping.
- `CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md`: extension seams and module pattern guardrails.
- `CRE8_SEED_PRESERVATION_MATRIX.md`: preservation and redesign accountability matrix.

---

## 14) Dependency bedrock policy (implementation-binding)
All future SSOT and implementation docs MUST treat the Composer dependencies as architectural bedrock (not optional utilities). Documentation for each subsystem MUST name the dependency and responsibility directly:
- `slim/slim`: route groups per surface, middleware order, and centralized error pipeline.
- `slim/psr7`: immutable PSR-7 request/response primitives and upload handling.
- `php-di/php-di`: composition root for services/repositories/middleware.
- `firebase/php-jwt`: token mint/verify, `iss`/`aud`/`exp`/`typ` checks, and JWKS-compatible key validation.
- `ext-pdo`: prepared statements and transaction-scoped policy/audit writes.
- `ext-sodium`: Argon2id hashing, CSPRNG bytes, and constant-time comparisons.
- `respect/validation`: composable request validators and deterministic 422 mapping.
- `vlucas/phpdotenv`: startup env loading, required key assertions, typed parsing.
- `guzzlehttp/guzzle`: outbound integrations (JWKS/webhook/service calls) with retry/timeout policy.
- `neomerx/cors-psr7`: CORS policy enforcement without ad-hoc header logic.
- `monolog/monolog`: structured app/security/audit channels with correlation processors.
- `symfony/rate-limiter` + `symfony/cache`: policy buckets, burst control, and limiter-state persistence.
- `phpunit/phpunit`: contract/middleware/security/lifecycle regression suites.

Every domain document MUST be updated to reference these dependencies where behavior is specified.
