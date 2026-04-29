# CRE8 SSOT Seed Inventory: Keypair-Centric Platform Model

_Status: authoritative seed_  
_Effective date (UTC): 2026-04-29_

## 1. Authority, role, and intent
This document is the authoritative seed inventory for the next-generation CRE8 SSOT document set. It preserves high-value CRE8 invariants and roots the architecture around mandatory ID-keypair minting at actor creation time, followed by delegated Utility-keypair minting per service/context.

This seed is written so developers can copy it into a greenfield repository and extend it quickly with new account types, post types, permission families, and integration patterns, while preserving deterministic security and policy behavior.

## 2. Platform identity and non-negotiable outcomes
CRE8 is a Credential Registry Engine: a policy-governed content and access platform built for auditable delegation, deterministic authorization, and extensibility.

Non-negotiable outcomes:
- envelope-first API behavior and stable error semantics,
- middleware/PDP-first authorization (no handler-local policy logic),
- high-assurance key lifecycle and provenance,
- parity between API actions and UI actions,
- modular architecture that supports rapid extension without security regression.

## 3. Actor model and authority chain
Core actors:
1. Owner
2. Primary Author Key bearer
3. Secondary Author Key bearer
4. Use Key bearer
5. System/API client principals using approved keys

Authority chain:
- Owner sets permissions and delegation limits for Primary Author Keys it creates.
- Primary Author Key sets permissions and delegation limits for Secondary Author and Use Keys it creates.
- Secondary Author Key sets permissions and delegation limits for Use Keys it creates.
- Each level includes explicit control of which descendant permissions may themselves be delegated.

Owner model options that implementations may choose:
- invite-driven multi-owner operation,
- single-owner api-only operation,
- username/email/password-only operation,
- hybrid operation with both API and credentialed UI entry points.

## 4. Key architecture baseline
### 4.1 Mandatory minting rule
When a Primary Author Key, Secondary Author Key, or Use Key is minted, it MUST be minted with an initial Private/Public **ID Keypair**.

### 4.2 Utility keypair model
Each ID-keypair holder may mint additional Private/Public **Utility Keypairs** for specific external services, apps, devices, or contexts.

### 4.3 Functional separation
- ID Keypairs are internal identity anchors for CRE8-native authority and lifecycle management.
- Utility Keypairs are proxy/access credentials intended for external sharing and service-specific usage.
- Both key types support rotation/revocation, with immediate enforcement.

### 4.4 Authentication proof
Gateway/API requests use public-key lookup and private-key proof (`public_key_id`, timestamp, nonce, signature), with replay protections, skew windows, and deterministic denial mapping.

## 5. Permissioning and delegation semantics
- Delegation is always bounded by permission subset, scope, depth, lifecycle, and expiry.
- No descendant may exceed ancestor-granted bounds.
- Descendants can only set permissions they were explicitly allowed to set.
- Owner accounts retain Master governance visibility and override controls within policy.
- All delegation and governance actions emit immutable provenance events.

## 6. Content, audience, and interaction model
CRE8 working-model capabilities that must be preserved:
- owner invitation of owners,
- creation and governance of Primary/Secondary Author Keys and Use Keys,
- keychains for permission aggregation,
- audience groups for reusable targeting,
- post creation with granular targeting to individual Use Keys, key collections, and audience groups,
- comment capability for Use Key bearers when explicitly permitted,
- feed per user containing authorized posts/events in reverse chronological order.

Extensibility requirement: post and interaction models MUST be modular so teams can add new post families (for example direct messaging and media/file sharing) with policy-consistent protection.

## 7. Surfaces and parity model
Required surface separation:
- Owner Console UI (owner-only governance surface, including owner API key usage).
- API Gateway UI (key-bearer surface).
- Public/bootstrap/auth surface.

CRE8.pw is a first-party API client UI that demonstrates parity with third-party clients. Every supported API action must have UI parity architecture (even if UI variants differ by role/surface).

## 8. Credential entry and runtime capability shaping
At runtime, users may provide one or more Public Utility Keys as Credential Keys and/or provide a Keychain key with aggregated permissions.

Entered credentials determine:
- UI presented,
- actions available,
- resources visible,
- allowable post/comment interactions.

## 9. Security posture baseline
The seed set must encode better-than-industry-standard defense-in-depth through layered controls where they matter most:
- strong key material handling and one-time private reveal,
- cryptographic verification and replay defense,
- hardened hashing/encryption for secrets and sensitive artifacts,
- structured revocation/rotation and compromised-key response,
- deterministic access cutoff upon revocation,
- audit/event integrity and forensic exportability.

## 10. Canon preservation strategy
This document set preserves essential behavior, security, governance, and extensibility expectations while codifying the ID-keypair-first architecture.

Migration principle:
- preserve essential invariants and capabilities,
- re-author architecture around mandatory ID-keypair-first minting,
- keep documents concise now, then mature each into full SSOT authority.

## 11. Immediate seed-to-SSOT expansion plan
This seed set should next mature into a full canonical stack including:
- terminology and actor glossary,
- permission lattice and delegation rules,
- key lifecycle and cryptographic operations spec,
- API and UI parity contract,
- data model and lineage/provenance model,
- security controls/threat model,
- extensibility playbook for new post/account/permission types,
- implementation sequencing and verification gates.

## 12. Acceptance criterion for this seed inventory
This inventory is acceptable when it fully captures:
- the inherited essential CRE8 model,
- the new ID-keypair-first architecture,
- hierarchical permission-setting rules,
- multi-surface usage modes,
- modular developer extensibility goals,
- security and trust posture expectations,
with no critical conceptual gaps for launching the next repository as the authoritative SSOT origin.
