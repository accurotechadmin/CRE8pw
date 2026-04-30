---
doc_id: CRE8-OPS-OBSERVABILITY-EVENT-CATALOG
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Security WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-20
source_seed_refs:
  - seed/CRE8_REPO_STUDY_REPORT.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md
  - docs/40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Observability Event Catalog

## Purpose
Define canonical CRE8 observability events, required schemas, retention/sensitivity classes, and correlation obligations across logging channels.

## Normative requirements
- **CRE8-OPS-REQ-0048**: Every emitted observability event **MUST** declare `{event_name, event_version, severity, channel, timestamp_utc, request_id}` fields and **MUST** validate against the catalog schema row for that event name.
- **CRE8-OPS-REQ-0049**: Each event type **MUST** declare a sampling rule (`always`, `rate:<n>`, or `error-only`) and runtime emitters **MUST NOT** use undeclared sampling behavior.
- **CRE8-OPS-REQ-0050**: Event payloads in sensitivity class `restricted` or `secret-adjacent` **MUST NOT** include raw credentials, token material, or private keys; redaction semantics **MUST** align with `ERROR_CODE_CATALOG.md` leak-prevention rules.
- **CRE8-OPS-REQ-0051**: Every event **MUST** include at least one provenance binding (`principal_id`, `keypair_id`, `delegation_id`, `post_id`, or `comment_id`) sufficient to reconstruct actor/action lineage for audits.
- **CRE8-OPS-REQ-0052**: Channel retention classes **MUST** be one of `ephemeral-7d`, `operational-30d`, or `audit-365d`; event routing **MUST** enforce the retention class specified by this catalog.

## Event catalog
| Event name | Channel | Severity | Sampling | Retention | Sensitivity | Required provenance fields |
|---|---|---|---|---|---|---|
| `authz.decision.evaluated.v1` | `security` | `INFO` | `always` | `audit-365d` | `restricted` | `principal_id`, `keypair_id`, `delegation_id` |
| `authz.decision.denied.v1` | `security` | `WARN` | `always` | `audit-365d` | `restricted` | `principal_id`, `request_id` |
| `feed.read.completed.v1` | `application` | `INFO` | `rate:10` | `operational-30d` | `internal` | `principal_id`, `post_id` |
| `comment.create.denied.v1` | `application` | `WARN` | `always` | `operational-30d` | `internal` | `principal_id`, `comment_id` |
| `migration.batch.applied.v1` | `operations` | `INFO` | `always` | `audit-365d` | `restricted` | `request_id` |
| `health.readiness.failed.v1` | `operations` | `ERROR` | `always` | `operational-30d` | `internal` | `request_id` |

## Severity and response mapping
| Severity | Operational expectation |
|---|---|
| `INFO` | Recorded for trend/capacity; no immediate pager by default. |
| `WARN` | Queued for triage in business-hours rotation unless volume threshold exceeded. |
| `ERROR` | Opens incident candidate and requires correlation lookup by request_id within runbook SLA. |

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-OBS-EVENT-CATALOG-COVERAGE` | Manual gate in Phase 3 until automated script is delivered by `P3-S11.2`; verifies schema fields, sampling declarations, and retention classes are complete for each catalog row. |
| `HOOK-CONTRACT-ERROR-SECRETS-REDACTION` | Automated verification that secret-bearing fields are redacted in error/observability outputs. |

Change Impact Map: `reports/change_impact_maps/20260430-1505-P3-S9.5-P3-S9.6.md`.

## See also
- [Migration and Seed Strategy](./MIGRATION_AND_SEED_STRATEGY.md)
- [Security Controls Spec](../40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
