# `docs/` — CRE8 Canonical SSOT Corpus

This directory holds the **canonical, normative documentation set** for the CRE8 platform. Mature artifacts here are authoritative implementation directives; provisional artifacts are authoritative for bounded implementation while gaps are tracked openly.

For platform background, key architecture, and program status, read `../README.md` first. This file is the navigation and governance entry point for everything under `docs/`.

---

## 1. Governance entry point

The single canonical entry into the governance and topology of `docs/` is:

- **`00_governance/SSOT_INDEX.md`** — declares precedence, required SSOT map, link topology, and verification hooks.

Every contributor (human or LLM) MUST read `SSOT_INDEX.md` before authoring or modifying anything under `docs/`.

---

## 2. Domain map

The corpus is partitioned into domain folders. Numeric prefixes establish the canonical reading and authoring order.

| Folder | Owner WG | Purpose |
|---|---|---|
| `00_governance/` | Docs Governance WG | SSOT topology, document template, status/ownership, contribution workflow, change control, definition of done, cross-document linking policy. |
| `10_product_and_architecture/` | Platform Architecture WG | Product/system spec, canonical terminology, human operating model, dependency baseline, ID/Utility keypair model, request pipeline and middleware contract, architecture and surfaces. |
| `20_identity_delegation_and_policy/` | Identity & Policy WG | Authorization and delegation spec, decision tables, principal types and capability matrix, keychain composition, usage scenarios, delegation state machine. |
| `30_contracts_and_interfaces/` | API Contracts WG | API contract guide, route inventory, error code catalog, UI runtime contract (cross-surface parity), endpoint examples, webhook and integration contract. |
| `31_machine_contracts/` | API Contracts WG | OpenAPI 3.1 contract (`openapi/cre8.v1.yaml`), JSON Schemas (`schemas/`), and prose↔OpenAPI parity table. Reviewed jointly with Delivery Operations WG and Security WG. |
| `40_data_security_and_crypto/` | Security WG | Key lifecycle and cryptography spec, security controls, security headers and CSP, threat model, abuse cases, data model and ERD. |
| `50_content_audience_and_feed/` | Product Policy WG | Content model and targeting, audience group spec, commenting and interaction policy, feed ranking and ordering rules. |
| `60_operations_quality_and_release/` | Operations Quality WG | Verification strategy, Phase 2/3 acceptance criteria, Phase 2 unresolved exceptions register, health endpoint contract, boot/startup, configuration/environment, operational smoke, migration/seed, observability event catalog, release checklist, production readiness gates, SLO/SLI, acceptance criteria matrix. |
| `70_extensibility_and_module_patterns/` | Platform Architecture WG | Module boundaries and ownership, extensibility playbook, integration provider pattern, post type extension spec, principal type extension spec. |
| `80_traceability_decisions_and_program/` | Program Traceability WG | Traceability matrix, SSOT automation and linting, change impact map templates, decision record template, ADR index, decisions log, risk register, roadmap and milestones, seed promotion tracker, unresolved seed gap register, ADR records. |
| `evidence/` | Operations Quality WG | Evidence templates and automation linkage. |

Each domain has a default owner team and required reviewer teams declared in `00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`.

---

## 3. Document status taxonomy

Every document in `docs/` declares one of the following statuses in its YAML frontmatter (`status:`):

| Status | Meaning |
|---|---|
| `draft` | Exploratory; not approved for implementation direction. |
| `provisional-normative` | Approved for bounded implementation with identified follow-up gaps. Authoritative until promoted to `normative`. |
| `normative` | Approved as authoritative implementation direction. |
| `deprecated` | Retained for history; not valid for new implementation guidance. |

Promotion rules (no document moves to `normative` without recorded review completion) are in `00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`.

---

## 4. Required document conventions

Every document under `docs/` MUST:

- Carry a YAML frontmatter header with the schema in `00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`: `doc_id`, `version`, `status`, `owner`, `reviewers`, `last_reviewed_utc`, `next_review_due_utc`, `source_seed_refs`, `normative_dependencies`.
- Use canonical ID schemes: `CRE8-<DOMAIN>-REQ-####` for requirements, `HOOK-<DOMAIN>-<TOPIC>` (ALL CAPS) for verification hooks.
- Use RFC 2119 keywords (`MUST`, `SHOULD`, `MAY`) in uppercase for normative statements.
- Cite the Composer dependency that enforces each behavioral requirement (see `../README.md` §7).
- Include a `See also` section with at least two repository-relative links, including one governance or traceability link.
- Avoid the prohibited scaffold opener phrase (the program-wide scaffold lint is enforced under Phase 3 M2).

---

## 5. Current maturity at a glance (informational)

The Phase 3 — Canon Completion program (`../reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`) is the live authoring effort that takes every domain folder to fully authored, internally consistent, and machine-verifiable. The current per-folder maturity profile (informational; consult the latest progress board and coverage JSON for live state):

| Folder | Maturity | Notes |
|---|---|---|
| `00_governance/` | Strong | All documents hardened; canonical entry point. |
| `10_product_and_architecture/` | Mixed | `ID_UTILITY_KEYPAIR_MODEL_SPEC.md` is hardened; remaining docs filled under Phase 3 M3. |
| `20_identity_delegation_and_policy/` | Mixed | Authorization spec + decision tables hardened; capability matrix, keychain, scenarios, state machine added under Phase 3 M4. |
| `30_contracts_and_interfaces/` | Strong | API guide, route inventory, error catalog, UI runtime contract are hardened; broader endpoint examples and webhook contract under Phase 3 M5. |
| `31_machine_contracts/` | Strong | OpenAPI baseline + schemas + parity table all hardened. Schema completeness pass and version policy under Phase 3 M6. |
| `40_data_security_and_crypto/` | Thin | Only `KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md` is hardened today. Threat model, controls, headers/CSP, abuse cases, data model, ERD, crypto profile authored under Phase 3 M7. |
| `50_content_audience_and_feed/` | Mixed | Content model, commenting policy, feed ordering hardened; audience group spec authored under Phase 3 M8. |
| `60_operations_quality_and_release/` | Mixed | Verification strategy + Phase 2 acceptance docs hardened; ops/release docs authored under Phase 3 M9. |
| `70_extensibility_and_module_patterns/` | Mixed | Module boundaries hardened; remaining extensibility docs under Phase 3 M10. |
| `80_traceability_decisions_and_program/` | Strong | Traceability, automation/linting, ADR index, decisions log, risk register, roadmap, seed-promotion, gap register, ADR records all hardened. |
| `evidence/` | Mixed | Feed contract evidence template is hardened; broader evidence templates authored under Phase 3 M11. |

The authoritative live state is in `../reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` (when present) and `../reports/ssot/coverage_latest.json`.

---

## 6. Verification posture for `docs/` changes

Every PR that touches `docs/` is gated by `.github/workflows/ssot_phase_gate.yml`. Locally, contributors run the verification command list documented in `../README.md` §14 and in `60_operations_quality_and_release/VERIFICATION_STRATEGY.md`. The Phase 3 program plan’s milestone M11 introduces additional hooks and the eventual `composer phase3:final-acceptance-bundle` superset.

Coverage is exposed via `composer docs:ssot:report` → `../reports/ssot/coverage_latest.json`. Phase 3 drives `untraced_requirements` to `0`.

---

## 7. How to navigate quickly

- **First time here?** Read `00_governance/SSOT_INDEX.md`, then `../README.md`, then `00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`.
- **Contributing a contract change?** Read `30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`, `30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`, `31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`. A Change Impact Map under `../reports/change_impact_maps/` is required.
- **Promoting a requirement from a seed file?** Read `80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md` and `80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`.
- **Running an authoring session?** Use `../reports/PHASE3_AUTHORING_SESSION_PROMPT.md`.
- **Checking program status?** Read `../reports/session_handoffs/LATEST_SESSION_HANDOFF.md`, then the progress board it references.

---

## 8. See also

- [Project root README](../README.md)
- [Phase 3 program plan](../reports/PHASE3_AUTHORING_PROGRAM_PLAN.md)
- [Phase 3 session prompt](../reports/PHASE3_AUTHORING_SESSION_PROMPT.md)
- [SSOT Index](./00_governance/SSOT_INDEX.md)
- [Traceability Matrix](./80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md)
- [Verification Strategy](./60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
- [Seed canon entry](../seed/seed-intro.md)
