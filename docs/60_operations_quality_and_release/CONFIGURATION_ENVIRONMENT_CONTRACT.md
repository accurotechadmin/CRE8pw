---
doc_id: CRE8-OPS-CONFIGURATION-ENVIRONMENT-CONTRACT
version: 1.0.0
status: normative
owner: Operations Quality WG
reviewers:
  - Security WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-15
source_seed_refs:
  - seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md
  - seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md
normative_dependencies:
  - dot.env
  - docs/60_operations_quality_and_release/BOOT_AND_STARTUP_FAILURE_CONTRACT.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
---

# Configuration Environment Contract

## Normative requirements
- **CRE8-OPS-REQ-0033**: Environment variable names and descriptions **MUST** be declared in `dot.env` using example-only values and **MUST NOT** include live secrets.
- **CRE8-OPS-REQ-0034**: Required variables for startup, auth proof verification, persistence, and observability **MUST** be validated at boot with deterministic fail-closed behavior.
- **CRE8-OPS-REQ-0035**: Configuration parsing **MUST** apply explicit type coercion and bounds checks for booleans, integers, durations, and URLs.
- **CRE8-OPS-REQ-0036**: Secret-bearing variables **MUST** be redacted in errors, logs, and diagnostics.
- **CRE8-OPS-REQ-0037**: Configuration contract changes **MUST** be reflected in both this document and `dot.env` in the same patch set.

## Implementation-binding dependencies
- `vlucas/phpdotenv` **MUST** provide environment loading and required-variable assertions.
- `respect/validation` **MUST** provide deterministic type and bounds validation for configuration values.
- `monolog/monolog` **MUST** provide redacted structured diagnostics.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-SSOT-LINT-METADATA` | Ensures metadata/schema consistency for configuration contract updates. |
| `HOOK-CONTRACT-ERROR-SECRETS-REDACTION` | Guards against secret leakage in contract examples and deterministic error output. |

Change Impact Map: [`reports/change_impact_maps/20260430-1246-P3-S9.1-P3-S9.4.md`](reports/change_impact_maps/20260430-1246-P3-S9.1-P3-S9.4.md).

## See also
- [Boot and Startup Failure Contract](./BOOT_AND_STARTUP_FAILURE_CONTRACT.md)
- [Health Endpoint Contract](./HEALTH_ENDPOINT_CONTRACT.md)
- [Phase 2 Acceptance Criteria](./PHASE2_ACCEPTANCE_CRITERIA.md)
