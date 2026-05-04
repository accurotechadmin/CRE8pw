---
doc_id: CRE8-SEC-THREAT-MODEL
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Operations Quality WG
  - Identity & Policy WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
  - seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md
normative_dependencies:
  - docs/40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md
  - docs/40_data_security_and_crypto/SECURITY_HEADERS_AND_CSP_POLICY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---
# Security Threat Model

## Normative requirements
- **CRE8-SECX-REQ-0008**: Threat model entries **MUST** include `threat_id`, `surface`, `attack_path`, `impact`, and `mapped_controls`.
- **CRE8-SECX-REQ-0009**: Every threat with high or critical impact **MUST** map to at least one preventive control and one detective control.
- **CRE8-SECX-REQ-0010**: Threat-model updates **MUST** include explicit change-log entries whenever new public routes or principal types are introduced.
- **CRE8-SECX-REQ-0023**: Every threat row **MUST** resolve to one or more `control_id` values in [`SECURITY_CONTROLS_SPEC.md`](SECURITY_CONTROLS_SPEC.md) and one operational verification hook row in [`VERIFICATION_STRATEGY.md`](VERIFICATION_STRATEGY.md); unresolved threat-control-hook chains MUST block merge.
- **CRE8-SECX-REQ-0024**: Threats that include lifecycle attack paths **MUST** map to lifecycle operational controls and lifecycle contract verification (`composer test:contract:lifecycle`) evidence before release gate finalization.

## Threat table
| threat_id | surface | attack_path | impact | mapped_controls |
|---|---|---|---|---|
| THREAT-001 | partner_gateway | replay of signed request with stale nonce | high | SEC-CTRL-001, SEC-CTRL-004, SEC-CTRL-005 |
| THREAT-002 | owner_console | CSP bypass via injected script source | high | SEC-CTRL-002, SEC-CTRL-005 |
| THREAT-003 | persistence | unauthorized key material disclosure | critical | SEC-CTRL-003, SEC-CTRL-005 |

## Implementation binding
- `firebase/php-jwt`, `ext-sodium`, and `monolog/monolog` are REQUIRED dependency surfaces for threat mitigation evidence capture.

## Change Impact Map
- [`reports/change_impact_maps/20260430-0740-P3-S7.4-P3-S7.5-P3-S7.6.md`](reports/change_impact_maps/20260430-0740-P3-S7.4-P3-S7.5-P3-S7.6.md)

## See also
- [Security Controls Spec](./SECURITY_CONTROLS_SPEC.md)
- [Security Verification Abuse Cases](./SECURITY_VERIFICATION_ABUSE_CASES.md)
