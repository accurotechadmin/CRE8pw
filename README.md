# CRE8 SSOT Repository

CRE8 is a **Single Source of Truth (SSOT) repository** for a credentialed identity, delegation, policy, contract, security, and operations platform. This repo is intentionally documentation-first: it captures the architecture, rules, contracts, and verification hooks required to build and operate CRE8 consistently.

If you are starting fresh, read this file, then [`dev/SSOT_CANON_READING_LIST.md`](dev/SSOT_CANON_READING_LIST.md) for the full sequential canon path, or use the shorter ladder via [`docs/README.md`](docs/README.md) and [`docs/00_governance/SSOT_INDEX.md`](docs/00_governance/SSOT_INDEX.md). For a **fresh expert coding LLM session**, use [`dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md`](dev/CRE8_EXPERT_SSOT_BOOT_PROMPT.md) as the first message so the model reads the canon list and follows reference maintenance rules before building.

---

## What this repository is for

- Define **normative requirements** using stable IDs and explicit governance.
- Keep prose, machine contracts, and verification hooks synchronized.
- Provide durable traceability from requirements → hooks → evidence.
- Preserve session continuity for multi-session authoring through committed handoffs and response archives.

---

## Repository map

| Path | Role | Notes |
|---|---|---|
| `dev/` | Developer orientation | SSOT canon reading list, expert LLM boot prompt, and related developer entry artifacts. |
| `docs/` | Canonical SSOT corpus | Domain-organized normative/provisional documentation. |
| `seed/` | Seed canon | Origin references and baseline source material. |
| `reports/` | Program records and session artifacts | Non-normative by default unless explicitly promoted. |
| `scripts/` | Verification and lint tooling | SSOT checks, parity checks, coverage generation, acceptance bundles. |
| `tests/` | Contract fixtures | Request/response fixtures used by contract checks. |
| [`composer.json`](composer.json) | Tool/runtime manifest | Composer scripts are the authoritative command catalog. |
| `dot.env` | Environment scaffold | Placeholder file only; never commit secrets. |
| [`REFERENCE_MAINTENANCE_SOP.md`](REFERENCE_MAINTENANCE_SOP.md) | Reference maintenance procedure | Inventory, indexes, and link hygiene when the repo tree changes. |
| [`reports/REFERENCE_REFRESH_SESSION_PROMPT.md`](reports/REFERENCE_REFRESH_SESSION_PROMPT.md) | Reference refresh prompt | Structured executor prompt aligned with the maintenance SOP. |
| [`FILE_INVENTORY.md`](FILE_INVENTORY.md) | Tracked-file inventory | Complete path list of all version-controlled files. |
| [`master_index.md`](master_index.md) | Operational index | Global map of docs, seeds, reports, and the mandatory update chain. |

---

## Canonical reading order

For the **complete sequential path** through every developer-relevant SSOT document (including all domains, machine contracts, evidence, and tooling), use [`dev/SSOT_CANON_READING_LIST.md`](dev/SSOT_CANON_READING_LIST.md).

Short ladder:

1. [`docs/README.md`](docs/README.md)
2. [`docs/00_governance/SSOT_INDEX.md`](docs/00_governance/SSOT_INDEX.md)
3. [`docs/00_governance/CHANGE_CONTROL_POLICY.md`](docs/00_governance/CHANGE_CONTROL_POLICY.md)
4. [`docs/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`](docs/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md)
5. [`docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md`](docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
6. [`docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`](docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
7. [`docs/31_machine_contracts/README.md`](docs/31_machine_contracts/README.md)
8. [`docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md`](docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md)
9. [`docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
10. [`docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)

---

## How SSOT governance works

- [`docs/00_governance/SSOT_INDEX.md`](docs/00_governance/SSOT_INDEX.md) defines topology and precedence.
- [`docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`](docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md) defines document format and conventions.
- [`docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`](docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md) defines ownership and promotion expectations.
- [`docs/00_governance/CHANGE_CONTROL_POLICY.md`](docs/00_governance/CHANGE_CONTROL_POLICY.md) defines how normative change is proposed and accepted.

**Practical rule:** if a statement affects behavior, it should be represented in canonical docs, linked in traceability, and backed by verification hooks/evidence.

---

## Machine-contract and schema surface

The machine-contract set is under `docs/31_machine_contracts/`:

- OpenAPI: [`docs/31_machine_contracts/openapi/cre8.v1.yaml`](docs/31_machine_contracts/openapi/cre8.v1.yaml)
- JSON Schemas: `docs/31_machine_contracts/schemas/*.schema.json`
- Prose parity matrix: [`docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`](docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md)

Prose and machine artifacts are expected to remain aligned.

---

## Verification workflow

Primary scripts live in `scripts/` and are invoked via Composer script aliases in [`composer.json`](composer.json).

Common lifecycle:

1. Author or update canonical docs.
2. Run lint/sync/report/parity checks.
3. Run relevant contract checks.
4. Update evidence and traceability references.
5. Record session artifacts in `reports/`.

See:

- [`docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [`docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`](docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md)
- [`docs/evidence/automation/README.md`](docs/evidence/automation/README.md)

---

## Program and session records

`reports/` stores execution records, handoffs, response archives, and generated SSOT metrics.

- Start at [`reports/README.md`](reports/README.md).
- Latest session pointer: [`reports/session_handoffs/LATEST_SESSION_HANDOFF.md`](reports/session_handoffs/LATEST_SESSION_HANDOFF.md).
- Full response archive index context: [`reports/session_responses/README.md`](reports/session_responses/README.md).

---

## Contribution expectations

- Keep changes scoped and traceable.
- Preserve stable requirement/hook IDs unless governance explicitly approves migration.
- Update cross-links when moving or adding canonical references.
- Keep machine artifacts and prose artifacts in parity.
- Never commit secrets.

---

## Quick start (documentation maintenance)

```bash
composer --version
composer run docs:ssot:lint
composer run docs:ssot:sync-check
composer run docs:ssot:report
```

Then inspect:

- [`reports/ssot/coverage_latest.json`](reports/ssot/coverage_latest.json)
- related traceability and evidence documents.

---

## README index in this repository

- Root: [`README.md`](README.md) (this file)
- Developer SSOT reading list: [`dev/SSOT_CANON_READING_LIST.md`](dev/SSOT_CANON_READING_LIST.md)
- Docs root: [`docs/README.md`](docs/README.md)
- Machine contracts: [`docs/31_machine_contracts/README.md`](docs/31_machine_contracts/README.md)
- Evidence root: [`docs/evidence/README.md`](docs/evidence/README.md)
- Evidence automation: [`docs/evidence/automation/README.md`](docs/evidence/automation/README.md)
- Evidence templates: [`docs/evidence/templates/README.md`](docs/evidence/templates/README.md)
- Reports root: [`reports/README.md`](reports/README.md)
- Session response archive: [`reports/session_responses/README.md`](reports/session_responses/README.md)

