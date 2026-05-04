---
doc_id: CRE8-SEC-CRYPTO-PROFILE
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Identity & Policy WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
normative_dependencies:
  - docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md
  - docs/40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---
# Crypto Profile

## Normative requirements
- **CRE8-SECX-REQ-0016**: Request-signature verification **MUST** use Ed25519 (`EdDSA`) implemented via `ext-sodium`; non-approved algorithms **MUST NOT** be accepted.
- **CRE8-SECX-REQ-0017**: Password/secret derivation workflows **MUST** use Argon2id with parameters `memory_cost >= 65536`, `time_cost >= 3`, and `threads >= 1`; weaker profiles **MUST NOT** be used for new material.
- **CRE8-SECX-REQ-0018**: Random nonce and key material generation **MUST** use `random_bytes` or sodium CSPRNG primitives; pseudo-random generators **MUST NOT** be used.
- **CRE8-SECX-REQ-0019**: Signature and token comparisons **MUST** use constant-time compare primitives (`sodium_memcmp` or equivalent) to prevent timing leakage.
- **CRE8-SECX-REQ-0020**: Signed request nonces **MUST** be 24 bytes minimum entropy and unique per `(principal_id, key_id, request_surface)` within the replay retention horizon.
- **CRE8-SECX-REQ-0021**: Clock skew tolerance for signed requests **MUST** be bounded to ±120 seconds unless a documented ADR exception exists; rejected skew events **MUST** emit audit evidence.
- **CRE8-SECX-REQ-0022**: Replay-cache retention horizon **MUST** be at least 10 minutes and **SHOULD** be 15 minutes for internet-exposed surfaces.
- **CRE8-SECX-REQ-0023**: Cryptographic deprecations **MUST** define introduction date, sunset date, migration path, and compatibility handling before enforcement changes ship.

## Approved primitive profile
| domain | approved primitive | parameters | runtime dependency |
|---|---|---|---|
| request signatures | Ed25519 / EdDSA | 32-byte public keys; 64-byte signatures | ext-sodium |
| token signatures | JWS EdDSA | `alg=EdDSA` only | firebase/php-jwt + ext-sodium |
| key derivation | Argon2id | memory_cost>=65536; time_cost>=3; threads>=1 | ext-sodium / PHP password APIs |
| random source | CSPRNG | OS-backed entropy | random_bytes / sodium_* |
| constant-time compare | sodium_memcmp | fixed-time compare on auth material | ext-sodium |

## Deprecation policy
1. Cryptographic profile changes **MUST** be governed by an ADR and a `DLOG-YYYYMMDD-###` entry.
2. Breaking algorithm removals **MUST** provide a minimum 90-day sunset window.
3. During migration windows, dual-acceptance mode **MUST** log per-request algorithm usage for rollout evidence.
4. Sunset completion **MUST** include verification evidence linked to `HOOK-SEC-THREAT-CONTROL-MATRIX`.

## Implementation binding
- `ext-sodium` is the authoritative cryptographic runtime.
- `firebase/php-jwt` is the authoritative JWS parsing/verification runtime.
- `vlucas/phpdotenv` carries skew/replay-horizon configuration values and MUST remain consistent with this profile.

## Change Impact Map
- `reports/change_impact_maps/20260430-1300-P3-S7.7-P3-S7.8.md`

## See also
- [Key Lifecycle and Cryptography Spec](./KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md)
- [Security Controls Spec](./SECURITY_CONTROLS_SPEC.md)
- [Security Verification Abuse Cases](./SECURITY_VERIFICATION_ABUSE_CASES.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
