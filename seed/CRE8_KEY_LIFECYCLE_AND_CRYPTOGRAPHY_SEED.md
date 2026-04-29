# CRE8 Key Lifecycle and Cryptography Seed

Every Primary Author, Secondary Author, and Use Key begins with an ID keypair at mint time. That ID keypair becomes the lineage anchor for additional Utility keypairs created for distinct contexts such as third-party apps, services, devices, or tenant-specific workflows. Utility keys are proxy credentials that can be isolated, rotated, and revoked without collapsing the entire identity tree unless policy requires descendant impact.

Security requirements include one-time private material reveal, robust hashing/encryption for sensitive storage paths, proof-based request verification (public key id + nonce/timestamp/signature), replay/skew defense, and immediate revocation enforcement. All key lifecycle transitions and governance actions must produce immutable event records suitable for audit and incident response.

## Dependency anchoring for lifecycle + cryptography
Lifecycle endpoints SHOULD be mounted through `slim/slim` with immutable `slim/psr7` response handling. Key proofs and token assertions SHOULD use `firebase/php-jwt`; secret hashing/random generation/constant-time compare SHOULD use `ext-sodium`; lifecycle and audit writes SHOULD be transactionally committed via `ext-pdo`; anti-abuse controls SHOULD apply `symfony/rate-limiter` (cache-backed by `symfony/cache`).
