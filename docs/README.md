# `docs/` — CRE8 Canonical Documentation Hub

This directory contains the canonical SSOT corpus for CRE8. It is organized by numbered domains so contributors can navigate from governance → architecture → policy → contracts → security → operations → extensibility → traceability.

## Purpose

- Provide authoritative, implementation-guiding documentation.
- Maintain consistent requirement vocabulary and IDs.
- Keep prose requirements and machine contracts synchronized.
- Centralize governance and change-control references.

## Start here

1. [`../dev/SSOT_CANON_READING_LIST.md`](../dev/SSOT_CANON_READING_LIST.md) — full sequential SSOT path for developers (all domains and tooling).
2. [`../dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md`](../dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md) — optional paste-first message for expert coding LLM sessions (orients models to the reading list and reference maintenance).
3. [`00_governance/SSOT_INDEX.md`](00_governance/SSOT_INDEX.md)
4. [`00_governance/CHANGE_CONTROL_POLICY.md`](00_governance/CHANGE_CONTROL_POLICY.md)
5. [`00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`](00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)

Items 3–5 define how every other document is authored, interpreted, and promoted.

## Domain structure

| Folder | Primary focus |
|---|---|
| `00_governance/` | SSOT index, style, ownership, contribution workflow, change control, DoD |
| `10_product_and_architecture/` | Product model, architectural boundaries, terminology, dependency baseline |
| `20_identity_delegation_and_policy/` | Principals, permissions, authorization/delegation behavior |
| `30_contracts_and_interfaces/` | Route and API contracts, error catalog, UI/runtime expectations |
| `31_machine_contracts/` | OpenAPI and JSON Schema machine artifacts + parity table |
| `40_data_security_and_crypto/` | Lifecycle/crypto, controls, threat model, security data model |
| `50_content_audience_and_feed/` | Content model, audience targeting, feed policy |
| `60_operations_quality_and_release/` | Verification strategy, quality/release gates, operational contracts |
| `70_extensibility_and_module_patterns/` | Extensibility boundaries and extension specs |
| `80_traceability_decisions_and_program/` | Traceability matrix, ADRs, risk and roadmap artifacts |
| `evidence/` | Evidence guidance, templates, and automation linkage |

## Core authoring rules

- Use repository-relative links for internal references.
- Preserve requirement and hook ID stability.
- Update traceability/evidence references for behavioral changes.
- Keep machine artifacts and prose aligned where applicable.

## Recommended update workflow

1. Edit the target domain docs.
2. Update dependent links and governance references if impacted.
3. Run SSOT verification scripts from [`composer.json`](composer.json).
4. Validate coverage output in [`reports/ssot/coverage_latest.json`](reports/ssot/coverage_latest.json).
5. Record evidence and session artifacts under `reports/` as required.

## High-value cross references

- Developer canon reading list: [`../dev/SSOT_CANON_READING_LIST.md`](../dev/SSOT_CANON_READING_LIST.md)
- Expert LLM boot prompt: [`../dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md`](../dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md)
- Root orientation: [`../README.md`](../README.md)
- Machine contracts guide: [`31_machine_contracts/README.md`](31_machine_contracts/README.md)
- Evidence guidance: [`evidence/README.md`](evidence/README.md)
- Verification strategy: [`60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- Traceability matrix: [`80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
