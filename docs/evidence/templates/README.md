# `docs/evidence/templates/` — Evidence Template Catalog

This directory contains reusable templates for capturing verification evidence in a consistent, reviewable format.

## Current templates

| Template | Typical scope |
|---|---|
| [`CONTRACT_SCHEMA_EXAMPLE_EVIDENCE_TEMPLATE.md`](CONTRACT_SCHEMA_EXAMPLE_EVIDENCE_TEMPLATE.md) | Schema coverage / example coverage and related contract checks |
| [`DATA_MODEL_EVIDENCE_TEMPLATE.md`](DATA_MODEL_EVIDENCE_TEMPLATE.md) | Data model verification evidence |
| [`EVENT_CATALOG_EVIDENCE_TEMPLATE.md`](EVENT_CATALOG_EVIDENCE_TEMPLATE.md) | Observability event catalog coverage |
| [`FEED_CONTRACT_EVIDENCE_TEMPLATE.md`](FEED_CONTRACT_EVIDENCE_TEMPLATE.md) | Feed behavior and contract verification |
| [`IDENTITY_POLICY_EVIDENCE_TEMPLATE.md`](IDENTITY_POLICY_EVIDENCE_TEMPLATE.md) | Identity/delegation/policy hooks |
| [`RELEASE_GATES_EVIDENCE_TEMPLATE.md`](RELEASE_GATES_EVIDENCE_TEMPLATE.md) | Release gate and operations readiness checks |
| [`SECURITY_THREAT_CONTROL_EVIDENCE_TEMPLATE.md`](SECURITY_THREAT_CONTROL_EVIDENCE_TEMPLATE.md) | Threat-to-control verification evidence |

## What each filled template should capture

- Hook ID(s)
- Command(s) executed
- UTC timestamp
- Commit SHA or branch identifier
- PASS/FAIL result
- Produced artifacts and exact file paths
- Notes for exceptions, waivers, or follow-up actions

## Template selection guidance

- Use the template that matches the dominant hook family for the change.
- For cross-domain changes, either:
  - fill multiple templates, or
  - include clearly separated sections keyed by hook family.

## Add/update process

1. Add or revise the template file in this directory.
2. Update this README table.
3. Update hook documentation in verification/automation docs if coverage changed.
4. Ensure traceability references can point to the new template and resulting evidence.

## Related references

- Evidence root: [`../README.md`](../README.md)
- Automation mapping: [`../automation/README.md`](../automation/README.md)
- Verification strategy: [`../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- Traceability matrix: [`../../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../../80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
