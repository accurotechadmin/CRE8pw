# CRE8

**CRE8** is a policy-governed credential and content platform built around an **ID-Keypair + Utility-Keypair** architecture. It enables deterministic delegation, auditable governance, and dual-surface operation (Owner Console + API Gateway) while preserving strict contract-first behavior.

This repository currently serves as a **documentation-seed SSOT foundation**. The `/seed` canon is authoritative for present-state truths and defines how the full mature SSOT corpus will be expanded over time.

---

## Table of contents

1. [What CRE8 is (current iteration)](#what-cre8-is-current-iteration)
2. [What changed from legacy CRE8](#what-changed-from-legacy-cre8)
3. [Current repository layout](#current-repository-layout)
4. [How to read this repository now](#how-to-read-this-repository-now)
5. [Core architecture and invariants](#core-architecture-and-invariants)
6. [Contracts, security, and operations commitments](#contracts-security-and-operations-commitments)
7. [Proposed robust documentation scaffolding (target map)](#proposed-robust-documentation-scaffolding-target-map)
8. [Document precedence and governance](#document-precedence-and-governance)
9. [Build-forward plan for 100+ docs](#build-forward-plan-for-100-docs)

---

## What CRE8 is (current iteration)

CRE8 is a **Credential Registry Engine** designed to support:
- hierarchical, bounded delegation (Owner → Primary Author → Secondary Author → Use Key contexts),
- deterministic permission envelopes and policy decisioning,
- strong provenance and lifecycle governance,
- first-party and third-party client interoperability via stable API contracts,
- content, audience, and feed behaviors that remain policy-consistent across surfaces.

The current architecture separates:
- **ID Keypairs** as the internal identity anchor and lineage root, and
- **Utility Keypairs** as context-scoped operational credentials (service/app/device/tenant specific).

This split is central to revocation safety, blast-radius control, and long-term extensibility.

---

## What changed from legacy CRE8

`OLD_README.md` reflects a prior SSOT framing tied to an earlier single-key model and a previously broader docs tree. The current seed canon preserves the governance ethos while introducing a non-negotiable redesign:

- all minted delegated principals must begin with an **ID Keypair**,
- utility access is handled through one or more **Utility Keypairs**,
- delegation remains bounded and subset-constrained at every depth,
- contracts and deny semantics remain deterministic,
- dual-surface parity remains mandatory (Console/API/Gateway behavior coherence).

In short: same rigor, stronger key architecture.

---

## Current repository layout

| Path | Role |
|---|---|
| `README.md` | This current root orientation and scaffolding roadmap |
| `OLD_README.md` | Legacy README from previous CRE8 iteration (reference only) |
| `seed/` | Authoritative seed canon and maturity reports for current iteration |
| `composer.json` | PHP/runtime dependency contract baseline |
| `dot.env` | Environment scaffold sample |
| `.htaccess` | Apache routing entry configuration |

---

## How to read this repository now

Recommended reading order for the current model:
1. `README.md`
2. `seed/seed-intro.md`
3. `seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`
4. `seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md`
5. `seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`
6. `seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md`
7. `seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md`
8. `seed/CRE8_API_CONTRACT_AND_ERROR_SEED.md`
9. `seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md`
10. `seed/CRE8_SEED_PRESERVATION_MATRIX.md`
11. `seed/CRE8_SEED_CANON_ASSESSMENT_REPORT.md`
12. `seed/CRE8_REPO_STUDY_REPORT.md`

Reference indices:
- `seed/seed-index.md`
- `seed/CRE8_SEED_CANON_INDEX.md`

---

## Core architecture and invariants

### 1) Identity and delegation
- Minted principals receive initial ID keypairs.
- Descendant permissions must always be strict subsets of ancestor grants.
- Delegation constraints include permission family, scope, depth, lifecycle, and expiry.

### 2) Utility key compartmentalization
- Utility keypairs are context-specific and intentionally numerous.
- Rotation/revocation should limit impact to the targeted context, not global identity lineage.

### 3) Surfaces and parity
- Owner Console governs lifecycle, policy, moderation, and administrative operations.
- API/Gateway supports operational client behavior for permitted key holders.
- UI/API parity is a contract requirement, not an optional quality goal.

### 4) Deterministic policy and envelopes
- Policy Decision Point (PDP)-first enforcement.
- Stable success/error envelope contracts.
- Deterministic deny mapping and auditable request/provenance traces.

---

## Contracts, security, and operations commitments

The seed canon requires future SSOT maturity documents to remain implementation-binding to the dependency bedrock in `composer.json`, including routing/middleware, JWT verification, validation, cryptography, data access, observability, and test tooling.

Key standing commitments:
- proof-based request verification (`public_key_id`, timestamp, nonce, signature),
- replay/skew defense and constant-time comparisons,
- lifecycle immediacy for revoke/rotate actions,
- immutable provenance events for key/policy/content actions,
- verification and release gates expressed as explicit evidence-bearing checklists.

---

## Proposed robust documentation scaffolding (target map)

The following is the proposed root for the mature SSOT document program we will instantiate next.

```text
docs/
  README.md

  00_governance/
    SSOT_INDEX.md
    DOCUMENT_STATUS_AND_OWNERSHIP.md
    CHANGE_CONTROL_POLICY.md
    DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md
    CONTRIBUTION_WORKFLOW_SSOT.md
    DEFINITION_OF_DONE.md

  10_product_and_architecture/
    CRE8_PRODUCT_AND_SYSTEM_SPEC.md
    CRE8_HUMAN_OPERATING_MODEL.md
    CANONICAL_TERMINOLOGY.md
    ARCHITECTURE_AND_SURFACES.md
    ID_UTILITY_KEYPAIR_MODEL_SPEC.md
    REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md
    DEPENDENCY_BASELINE.md

  20_identity_delegation_and_policy/
    AUTHORIZATION_AND_DELEGATION_SPEC.md
    AUTHORIZATION_DECISION_TABLES.md
    KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md
    PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md
    USAGE_SCENARIOS_AND_PERMISSION_STORIES.md

  30_contracts_and_interfaces/
    API_CONTRACT_GUIDE.md
    ROUTE_INVENTORY_REFERENCE.md
    ERROR_CODE_CATALOG.md
    UI_RUNTIME_CONTRACT.md
    Endpoint_Examples_All_Routes.md
    WEBHOOK_AND_INTEGRATION_CONTRACT.md

  31_machine_contracts/
    openapi/
      cre8.v1.yaml
    schemas/
      success-envelope.schema.json
      error-envelope.schema.json
      policy-decision.schema.json

  40_data_security_and_crypto/
    DATA_MODEL_SPEC.md
    DATA_MODEL_REFERENCE.md
    ERD.md
    KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md
    SECURITY_CONTROLS_SPEC.md
    SECURITY_THREAT_MODEL.md
    SECURITY_HEADERS_AND_CSP_POLICY.md
    SECURITY_VERIFICATION_ABUSE_CASES.md

  50_content_audience_and_feed/
    CONTENT_MODEL_AND_TARGETING_SPEC.md
    AUDIENCE_GROUP_SPEC.md
    FEED_RANKING_AND_ORDERING_RULES.md
    COMMENTING_AND_INTERACTION_POLICY.md

  60_operations_quality_and_release/
    CONFIGURATION_ENVIRONMENT_CONTRACT.md
    BOOT_AND_STARTUP_FAILURE_CONTRACT.md
    HEALTH_ENDPOINT_CONTRACT.md
    OBSERVABILITY_EVENT_CATALOG.md
    SLO_SLI_SPEC.md
    VERIFICATION_STRATEGY.md
    ACCEPTANCE_CRITERIA_MATRIX.md
    MIGRATION_AND_SEED_STRATEGY.md
    OPERATIONAL_SMOKE_CHECK_CONTRACT.md
    PRODUCTION_READINESS_GATES.md
    RELEASE_CHECKLIST.md

  70_extensibility_and_module_patterns/
    MODULE_BOUNDARIES_AND_OWNERSHIP.md
    EXTENSIBILITY_PLAYBOOK.md
    POST_TYPE_EXTENSION_SPEC.md
    PRINCIPAL_TYPE_EXTENSION_SPEC.md
    INTEGRATION_PROVIDER_PATTERN.md

  80_traceability_decisions_and_program/
    TRACEABILITY_MATRIX.md
    SSOT_AUTOMATION_AND_LINTING.md
    CHANGE_IMPACT_MAP_TEMPLATES.md
    ADR_INDEX.md
    DECISIONS_LOG.md
    DECISION_RECORD_TEMPLATE.md
    records/
      ADR-001-*.md
      ADR-002-*.md
      ...
    ROADMAP_AND_MILESTONES.md
    RISK_REGISTER.md

  evidence/
    README.md
    templates/
    automation/
```

This structure intentionally mirrors proven organization patterns from `OLD_README.md` while recentering around the ID/Utility keypair model and current seed truths.

---

## Document precedence and governance

When documents disagree, apply this precedence:
1. Current mature SSOT canon (once instantiated under `docs/`),
2. Seed canon (`seed/`) until mature SSOT replacement exists,
3. Legacy references (`OLD_README.md`) for historical context only.

Normative behavior must always favor the newest authoritative document set that is explicitly designated as SSOT.

---

## Build-forward plan for 100+ docs

Phase progression:
1. **Scaffold phase**: establish folder map, templates, ownership, and indexing docs.
2. **Core canon phase**: author product, policy, contract, and security pillar docs.
3. **Machine-contract phase**: lock OpenAPI/schema artifacts and sync checks.
4. **Operational-hardening phase**: verification, observability, abuse testing, release governance.
5. **Expansion phase**: domain deep-dives (integrations, moderation workflows, developer SDK guidance, compliance/export, incident playbooks).

Success criteria for each phase:
- deterministic language (MUST/SHOULD clarity),
- explicit cross-references and traceability rows,
- implementation-binding dependency mapping,
- test/evidence obligations that can be executed and audited.

CRE8’s documentation program is intentionally designed to scale to 100+ artifacts **without sacrificing coherence** by using layered indexing, strict ownership, and contract-first discipline.
