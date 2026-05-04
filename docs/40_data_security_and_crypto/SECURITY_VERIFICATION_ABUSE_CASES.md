---
doc_id: CRE8-SEC-ABUSE-CASES
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Operations Quality WG
  - API Contracts WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - docs/40_data_security_and_crypto/SECURITY_THREAT_MODEL.md
  - docs/40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---
# Security Verification Abuse Cases

## Normative requirements
- **CRE8-SECX-REQ-0011**: Every `THREAT-###` entry in [`SECURITY_THREAT_MODEL.md`](SECURITY_THREAT_MODEL.md) **MUST** map to at least one abuse-case row in this document with a unique `abuse_case_id`.
- **CRE8-SECX-REQ-0012**: Every abuse-case row **MUST** include `setup`, deterministic `steps`, expected platform response, expected error code, and verification hook reference.
- **CRE8-SECX-REQ-0013**: Abuse-case rows for replay and proof-validation threats **MUST** assert nonce/timestamp/signature fail-closed behavior before authorization policy evaluation.
- **CRE8-SECX-REQ-0014**: Abuse-case rows **MUST** reference canonical error codes from [`ERROR_CODE_CATALOG.md`](ERROR_CODE_CATALOG.md); ad-hoc error identifiers **MUST NOT** be introduced.
- **CRE8-SECX-REQ-0015**: Verification evidence for every abuse-case execution **MUST** be recorded under [`docs/evidence/templates/README.md`](docs/evidence/templates/README.md) using hook-linked artifacts.
- **CRE8-SECX-REQ-0029**: Every abuse-case row **MUST** declare `mitigation_owner` and `evidence_location` fields; `mitigation_owner` **MUST** reference the accountable working group and `evidence_location` **MUST** resolve to a template or concrete artifact path under `docs/evidence/`.
- **CRE8-SECX-REQ-0030**: Every abuse-case row **MUST** map to at least one `control_id` from [`SECURITY_CONTROLS_SPEC.md`](SECURITY_CONTROLS_SPEC.md); rows lacking mapped controls **MUST** be treated as unresolved security residuals and entered in the phase exceptions register before release.

## Abuse-case matrix
| abuse_case_id | threat_id | control_id | setup | steps | expected_platform_response | expected_error_code | verification_hook | mitigation_owner | evidence_location |
|---|---|---|---|---|---|---|---|---|---|
| ABUSE-001 | THREAT-001 | SEC-CTRL-001,SEC-CTRL-004 | Active ID keypair, valid permission grant, replay cache enabled | Submit valid signed request; replay identical nonce+timestamp+signature | Request denied before policy gate evaluation; replay tuple written to security audit channel | auth.proof.replay_detected | HOOK-SEC-THREAT-CONTROL-MATRIX | Security WG | docs/evidence/templates/SECURITY_VERIFICATION_EVIDENCE_TEMPLATE.md |
| ABUSE-002 | THREAT-001 | SEC-CTRL-001,SEC-CTRL-004 | Active ID keypair, skew window ±120s | Submit request with timestamp outside accepted skew and otherwise valid signature | Request denied pre-policy; timestamp violation emitted with request correlation id | auth.proof.timestamp_invalid | HOOK-SEC-THREAT-CONTROL-MATRIX | Security WG | docs/evidence/templates/SECURITY_VERIFICATION_EVIDENCE_TEMPLATE.md |
| ABUSE-003 | THREAT-002 | SEC-CTRL-002,SEC-CTRL-005 | Owner Console response headers policy enabled | Inject unauthorized script source and inline execution attempt | Browser-side execution blocked by CSP; server emits structured deny telemetry | security.csp.violation | HOOK-SEC-THREAT-CONTROL-MATRIX | Security WG | docs/evidence/templates/SECURITY_VERIFICATION_EVIDENCE_TEMPLATE.md |
| ABUSE-004 | THREAT-003 | SEC-CTRL-003,SEC-CTRL-005 | Encrypted key storage enabled, restricted principal context | Attempt cross-principal utility-key retrieval with valid session but wrong scope | Retrieval denied; sensitive fields redacted from error payload and audit log | identity.utility.context_forbidden | HOOK-SEC-THREAT-CONTROL-MATRIX | Security WG | docs/evidence/templates/SECURITY_VERIFICATION_EVIDENCE_TEMPLATE.md |

## Implementation binding
- `ext-sodium` **MUST** provide signature validation primitives and constant-time comparison for abuse-case verification.
- `firebase/php-jwt` **MUST** enforce JWT verification pathways for request authenticity assertions.
- `monolog/monolog` **MUST** capture deterministic abuse-case verification evidence in structured logs.

## Change Impact Map
- [`reports/change_impact_maps/20260430-1300-P3-S7.7-P3-S7.8.md`](reports/change_impact_maps/20260430-1300-P3-S7.7-P3-S7.8.md)

## See also
- [Security Threat Model](./SECURITY_THREAT_MODEL.md)
- [Security Controls Spec](./SECURITY_CONTROLS_SPEC.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
