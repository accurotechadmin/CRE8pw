# CRE8 Seed Canon Index

This index defines the authoritative seed map for the next CRE8 SSOT lifecycle. `CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md` is the root inventory. All seed documents MUST remain consistent with it.

## 1) Reading order (required)
1. `README.md`
2. `CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`
3. `CRE8_PERMISSION_AND_DELEGATION_SEED.md`
4. `CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`
5. `CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md`
6. `CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md`
7. `CRE8_API_CONTRACT_AND_ERROR_SEED.md`
8. `CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md`
9. `CRE8_SEED_PRESERVATION_MATRIX.md`

## 2) Domain ownership map
- **Root platform identity and migration rules**: `README.md`, `CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`
- **Delegation and authority lattice**: `CRE8_PERMISSION_AND_DELEGATION_SEED.md`
- **Key lifecycle and crypto posture**: `CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`
- **Surface architecture and UI/API parity**: `CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md`
- **Content targeting + feed behavior**: `CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md`
- **Envelope/error determinism**: `CRE8_API_CONTRACT_AND_ERROR_SEED.md`
- **Extension model and module seams**: `CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md`
- **Preservation and redesign accountability**: `CRE8_SEED_PRESERVATION_MATRIX.md`

## 3) Seed governance constraints
- New seed docs MUST use deterministic normative language where behavior is mandatory.
- Seed docs MUST NOT introduce assumptions that conflict with ID-keypair-first minting.
- Cross-document terminology MUST remain stable (Owner, Primary Author, Secondary Author, Use Key, ID Keypair, Utility Keypair, Keychain, Audience Group).

## 4) Maturation expectation
Each seed file should mature into full SSOT specs with decision tables, API examples, threat/abuse matrices, and verification gates while preserving policy determinism and provenance rigor.

## 5) Dependency reference requirement
All seed and SSOT documents MUST explicitly reference applicable Composer/runtime dependencies when defining behavior, controls, contracts, and verification obligations.
