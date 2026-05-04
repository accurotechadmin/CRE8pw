---
doc_id: CRE8-SEC-CONTROLS-SPEC
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Operations Quality WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md
  - docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md
  - docs/40_data_security_and_crypto/SECURITY_THREAT_MODEL.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---
# Security Controls Spec

## Normative requirements
- **CRE8-SECX-REQ-0001**: Security controls **MUST** be grouped by family (`identity`, `transport`, `data`, `runtime`, `audit`) with an owner and verification hook per control row.
- **CRE8-SECX-REQ-0002**: All inbound authenticated routes **MUST** validate signature/timestamp/nonce before policy evaluation.
- **CRE8-SECX-REQ-0003**: Secret-bearing configuration values **MUST** load from environment only and **MUST NOT** be persisted to logs.
- **CRE8-SECX-REQ-0004**: High-risk state transitions (`revoke`, `rotate`, `delegate`) **MUST** emit structured security audit events.

- **CRE8-SECX-REQ-0021**: Each control row **MUST** declare at least one mapped `threat_id` from `SECURITY_THREAT_MODEL.md`; controls without mapped threats are prohibited in normative state.
- **CRE8-SECX-REQ-0022**: Control verification evidence **MUST** identify a deterministic verification hook and evidence path in `VERIFICATION_STRATEGY.md` for each mapped threat/control pair.
- **CRE8-SECX-REQ-0027**: Every transport or runtime control that can produce externally visible deny/error outcomes **MUST** declare cross-links to canonical API error semantics in `ERROR_CODE_CATALOG.md` and to observability event names in `OBSERVABILITY_EVENT_CATALOG.md`; missing linkages **MUST** block control promotion or modification.

## Control matrix
| control_id | family | control | owner | verification_hook_id | mapped_threat_ids |
|---|---|---|---|---|---|
| SEC-CTRL-001 | identity | key lineage and lifecycle checks | Security WG | HOOK-SEC-THREAT-CONTROL-MATRIX | THREAT-001,THREAT-003 |
| SEC-CTRL-002 | transport | TLS-only ingress and strict security headers | Security WG | HOOK-SEC-THREAT-CONTROL-MATRIX | THREAT-002 |
| SEC-CTRL-003 | data | encrypted-at-rest sensitive fields | Security WG | HOOK-SEC-THREAT-CONTROL-MATRIX | THREAT-003 |
| SEC-CTRL-004 | runtime | deny-by-default on validation/policy failures | Security WG | HOOK-SEC-THREAT-CONTROL-MATRIX | THREAT-001 |
| SEC-CTRL-005 | audit | immutable event trail for privileged actions | Operations Quality WG | HOOK-SEC-THREAT-CONTROL-MATRIX | THREAT-001,THREAT-002,THREAT-003 |

## Implementation binding
- `ext-sodium`, `firebase/php-jwt`, and `monolog/monolog` provide enforcement surfaces for cryptography, token validation, and structured audit logging.

## Change Impact Map
- `reports/change_impact_maps/20260430-0740-P3-S7.4-P3-S7.5-P3-S7.6.md`

## See also
- [Security Threat Model](./SECURITY_THREAT_MODEL.md)
- [Security Headers and CSP Policy](./SECURITY_HEADERS_AND_CSP_POLICY.md)
- [Key Lifecycle and Cryptography Spec](./KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [Observability Event Catalog](../60_operations_quality_and_release/OBSERVABILITY_EVENT_CATALOG.md)
