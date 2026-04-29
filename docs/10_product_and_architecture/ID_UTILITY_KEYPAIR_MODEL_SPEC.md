---
doc_id: CRE8-ARCH-IDENTITY-FOUNDATIONS
version: 1.0.0
status: provisional-normative
owner: Platform Architecture WG
reviewers:
  - Identity & Policy WG
  - Security WG
last_reviewed_utc: 2026-04-29
next_review_due_utc: 2026-05-20
source_seed_refs:
  - seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md
  - docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# ID / Utility Keypair Model Specification

## Purpose
Define deterministic, promotable identity-foundation requirements for ID-keypair-first issuance and utility-key context compartmentalization.

## Normative requirements
- **CRE8-ARCH-REQ-0001**: Every minted principal **MUST** be issued one lineage-root ID keypair before any utility keypair is created.
- **CRE8-ARCH-REQ-0002**: Utility keypairs **MUST** be context-scoped and **MUST NOT** be reused across distinct trust contexts (`service`, `app`, `device`, `tenant`, or equivalent policy-defined boundary).
- **CRE8-ARCH-REQ-0003**: Authorization-sensitive operations **MUST** resolve effective authority from ID-lineage provenance plus utility-key scope constraints, and **MUST** deny when lineage resolution is missing or ambiguous.
- **CRE8-ARCH-REQ-0004**: Utility-key scope broadening **MUST** be implemented as issuance of a new utility keypair; in-place widening of an existing utility-key scope is prohibited.
- **CRE8-ARCH-REQ-0005**: Key lifecycle transitions (`activate`, `suspend`, `revoke`, `rotate`, `expire`) **MUST** preserve immutable provenance links between ID and utility keypairs for audit export.

## Requirement-to-seed promotion notes
- `CRE8-ARCH-REQ-0001` promotes seed obligation `#id-keypair-first-principal-model`.
- `CRE8-ARCH-REQ-0002` and `CRE8-ARCH-REQ-0004` promote seed obligation `#utility-key-context-compartmentalization`.

## Verification hooks
- **HOOK-IDENTITY-ID-FIRST-ISSUANCE**: Manual/automated check that issuance flows cannot mint utility credentials before ID keypair creation.
- **HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION**: Manual/automated check that utility credentials are unique per context boundary.
- **Next automation candidate**: Add fixture-driven lifecycle tests under `test:security` for prohibited in-place utility-scope widening.

## See also
- [README.md](../../README.md)
- [Authorization and Delegation Spec](../20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [Key Lifecycle and Rotation Policy](../40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md)
- [Seed Promotion Tracker](../80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md)
