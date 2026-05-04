---
doc_id: CRE8-EXT-INTEGRATION-PATTERN
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - API Contracts WG
  - Security Engineering WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-20
source_seed_refs:
  - seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md
normative_dependencies:
  - docs/70_extensibility_and_module_patterns/EXTENSIBILITY_PLAYBOOK.md
  - docs/30_contracts_and_interfaces/WEBHOOK_AND_INTEGRATION_CONTRACT.md
  - docs/40_data_security_and_crypto/CRYPTO_PROFILE.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Integration Provider Pattern

## Purpose
Define deterministic outbound and inbound integration patterns for CRE8 extension providers, including signing, retries, dead-letter handling, webhook/JWKS validation, and verification seams.

## Normative requirements
- **CRE8-EXT-REQ-0012**: Every outbound integration provider **MUST** publish a compatibility declaration that names transport protocol, signature profile, retry class, dead-letter destination, and contract version before traffic is enabled.
- **CRE8-EXT-REQ-0013**: Outbound request signing **MUST** use the active profile declared in `CRYPTO_PROFILE.md` and **MUST NOT** permit unsigned delivery when the target route is classified `authenticated` in the webhook contract.
- **CRE8-EXT-REQ-0014**: Retry behavior **MUST** use bounded exponential backoff with deterministic max-attempt and max-age limits; terminal failure **MUST** emit a dead-letter event containing request id, provider id, error class, and replay disposition.
- **CRE8-EXT-REQ-0015**: Inbound integrations **MUST** validate signature/JWKS material before payload parsing and **MUST** fail closed with canonical deny/error mapping on validation failure.
- **CRE8-EXT-REQ-0016**: Every provider integration **MUST** define executable seam tests for: successful delivery, retryable failure, non-retryable failure, replay rejection, and signature-key rotation.
- **CRE8-EXT-REQ-0031**: Provider manifests **MUST** define observability ownership, alert thresholds, and incident-escalation contacts for signature failures, retry saturation, dead-letter growth, and replay rejections; unresolved ownership or threshold definitions **MUST** block production enablement.

## Outbound provider pattern
| Stage | Required control | Failure semantics |
|---|---|---|
| Prepare | Resolve provider manifest + contract version + idempotency key | Missing manifest or version mismatch MUST hard-fail before dispatch. |
| Sign | Apply profile-selected signature/JWT headers and timestamp window | Signature generation failure MUST route to non-retryable dead-letter. |
| Dispatch | Execute request with bounded timeout and deterministic retry class | Timeout/5xx/network failures MUST enter retry queue. |
| Retry | Exponential backoff with jitter and max-attempt/max-age limits | On limit exceeded, MUST emit terminal dead-letter event. |
| Finalize | Persist outcome and observability event | Outcome persistence failure MUST be retried as infrastructure error class. |

## Inbound provider pattern
1. Validate provider identity, key id, and signature/JWKS material.
2. Enforce replay window and nonce/idempotency controls.
3. Parse and schema-validate payload only after trust validation passes.
4. Execute route handler under canonical middleware/PDP order.
5. Emit deterministic response envelope and observability event.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-CONTRACT-COMPAT-DECLARATION` | Verifies compatibility declaration presence and version semantics for provider manifests and contracts. |
| `HOOK-EXT-SEAM-COMPATIBILITY` | Verifies integration seam tests cover success/failure/replay/rotation paths. |
| `HOOK-OBS-EVENT-CATALOG-COVERAGE` | Verifies required provider observability events, alert thresholds, and owner mappings are present. |

## See also
- [Extensibility Playbook](./EXTENSIBILITY_PLAYBOOK.md)
- [Webhook and Integration Contract](../30_contracts_and_interfaces/WEBHOOK_AND_INTEGRATION_CONTRACT.md)
- [Crypto Profile](../40_data_security_and_crypto/CRYPTO_PROFILE.md)


Change Impact Map: `reports/change_impact_maps/20260430-1317-P3-S10.2-P3-S10.3-P3-S10.4.md`.
