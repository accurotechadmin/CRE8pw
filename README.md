# CRE8 — Canonical Project SSOT

CRE8 is a policy-governed credential and content platform with deterministic delegation, auditable authority lineage, and contract-first interface behavior. This `README.md` is the **current top-level SSOT anchor** for the repository and establishes mandatory platform direction, documentation governance expectations, and implementation-aligned architectural commitments.

CRE8 uses a two-layer key architecture:
- **ID Keypairs** as identity anchors and lineage roots,
- **Utility Keypairs** as scoped operational credentials for concrete contexts (service/app/device/tenant/use-case).

All platform behavior, documentation growth, and implementation planning must remain consistent with this separation.

---

## Table of Contents

1. [Platform Purpose and Scope](#platform-purpose-and-scope)
2. [Normative Architecture Commitments](#normative-architecture-commitments)
3. [Authority, Delegation, and Governance Model](#authority-delegation-and-governance-model)
4. [Surfaces and Boundary Contracts](#surfaces-and-boundary-contracts)
5. [Contract and Error Determinism](#contract-and-error-determinism)
6. [Security, Trust, and Lifecycle Expectations](#security-trust-and-lifecycle-expectations)
7. [Repository Structure and Canon Ownership](#repository-structure-and-canon-ownership)
8. [Documentation Program Scaffold (Current Required Map)](#documentation-program-scaffold-current-required-map)
9. [Reports Policy for LLM/Automation Output](#reports-policy-for-llmautomation-output)
10. [SSOT Precedence and Change Control Rules](#ssot-precedence-and-change-control-rules)
11. [Execution Expectations for the Next Growth Phases](#execution-expectations-for-the-next-growth-phases)

---

## Platform Purpose and Scope

CRE8 exists to provide a reliable platform for credentialed identity, delegated authority, and governed interaction with protected content and workflows. The system is designed so authority is explicit, bounded, and auditable at every step: issuance, delegation, use, moderation, rotation, revocation, and evidence export.

The immediate scope of this repository is documentation-driven platform maturation: turning seed truths into a robust, enforceable, machine-verifiable SSOT set that can safely direct implementation and operations. The long-range scope is a mature documentation corpus of 100+ tightly integrated artifacts spanning policy, contracts, data, security, observability, release, and program governance.

---

## Normative Architecture Commitments

The following commitments are mandatory and non-optional:

1. **ID-Keypair-first issuance model**
   - Minted principals receive an initial ID Keypair.
   - ID key lineage is the canonical authority root for descendant capabilities.

2. **Utility key compartmentalization model**
   - Utility Keypairs are context-scoped credentials.
   - New contexts should be served by new utility keys rather than broadening existing credentials.

3. **Deterministic policy and contract behavior**
   - Policy decisions must be reproducible from explicit input/state.
   - API success/error semantics must remain envelope-stable and machine-checkable.

4. **Auditability and provenance continuity**
   - Governance, lifecycle, and content actions must produce traceable records.
   - Revocation/rotation intent and impact must be inspectable and explainable.

5. **Documentation-to-implementation binding**
   - SSOT statements are implementation directives once marked normative.
   - Dependency and interface requirements must be explicit where behavior is specified.

---

## Authority, Delegation, and Governance Model

CRE8 authority is hierarchical and bounded. Owners define policy envelopes and delegation limits for principals they mint. Descendants may delegate only within inherited limits and never exceed ancestor grants. Effective permission evaluation must account for granted permissions, explicit denies, scope boundaries, delegation depth constraints, lifecycle state, and expiry.

Keychain composition and aggregated capability views are first-class governance concerns. Any composed capability must preserve provenance and remain derivable from constituent grants. The system must prioritize safe failure behavior and deterministic deny outcomes when ambiguity or policy conflict is encountered.

---

## Surfaces and Boundary Contracts

CRE8 is a multi-surface platform with strict boundary semantics:

- **Owner Console surface** for governance, lifecycle, moderation, and administrative control.
- **API/Gateway surface** for operational client activity under delegated credentials.
- **Public/bootstrap surface** for service entry and setup prerequisites.

Boundary rule: authentication and authorization contexts are not interchangeable across surfaces unless explicitly specified by canonical contract. Cross-surface parity is mandatory for supported capabilities; functional divergence must be documented, justified, and test-gated.

---

## Contract and Error Determinism

CRE8 interfaces are contract-first. Each route and operation must be backed by explicit request/response contracts, deterministic status and envelope behavior, and stable error coding semantics. Detail-level deny reasons must be machine-parseable and useful for both operator diagnostics and client handling logic.

Machine artifacts (OpenAPI + JSON Schema) are required contract companions and must remain synchronized with prose specs. Contract changes require impact analysis and verification updates before acceptance.

---

## Security, Trust, and Lifecycle Expectations

Security posture is layered and lifecycle-aware. Core expectations include proof-oriented request validation, anti-replay controls, secure key material handling, immediate enforcement for revoke/rotate transitions, and immutable governance/provenance event trails.

Lifecycle governance is part of platform correctness, not an optional operations enhancement. Issuance, activation, suspension, expiry, revocation, and rekey/rotation flows must be explicitly defined and testable, with verifiable propagation of access impact.

---

## Repository Structure and Canon Ownership

| Path | Purpose |
|---|---|
| `README.md` | Root SSOT anchor and project direction contract |
| `seed/` | Seed canon baseline used to mature full SSOT documents |
| `docs/` | Structured SSOT corpus scaffold for mature normative artifacts |
| `reports/` | Required destination for LLM/automation session reports and narrative outputs |
| `composer.json` | Dependency and runtime contract baseline for implementation-binding specs |
| `dot.env` | Environment scaffold reference |
| `.htaccess` | Deployment routing scaffold for Apache environments |

---

## Documentation Program Scaffold (Current Required Map)

```text
docs/
  00_governance/
  10_product_and_architecture/
  20_identity_delegation_and_policy/
  30_contracts_and_interfaces/
  31_machine_contracts/
  40_data_security_and_crypto/
  50_content_audience_and_feed/
  60_operations_quality_and_release/
  70_extensibility_and_module_patterns/
  80_traceability_decisions_and_program/
  evidence/
```

This structure is mandatory for the current documentation maturation plan. New canonical SSOT artifacts should be added within the correct domain folder and wired into governance/index/traceability documents as the set grows.

---

## Reports Policy for LLM/Automation Output

All LLM-generated reports, working analyses, and session response artifacts must be placed under `reports/` unless a governance document explicitly requires a different destination. Do not create ad hoc report files in SSOT domain directories.

SSOT domain folders under `docs/` should remain reserved for canonical artifacts, templates, machine contracts, and formal evidence documents. This separation protects canon integrity, improves discoverability, and reduces accidental precedence confusion.

---

## SSOT Precedence and Change Control Rules

Until superseded by more granular governance docs, precedence is:

1. `README.md` (root project-level SSOT direction and constraints),
2. mature canonical documents under `docs/`,
3. seed baseline documents under `seed/` where mature canon detail is not yet authored,
4. generated session/report outputs under `reports/` (informational, non-normative unless promoted).

Any normative change must include: scope statement, impacted artifacts, compatibility notes, required verification updates, and explicit traceability consequences.

---

## Execution Expectations for the Next Growth Phases

### Phase 1 — Canon hardening
- Upgrade scaffold docs from descriptive placeholders to normative requirements.
- Establish cross-document links, ownership metadata, and review workflow.
- Define verification hooks for each major behavioral contract.

### Phase 2 — Machine contract lock-in
- Author and validate OpenAPI and JSON Schema artifacts.
- Enforce prose ↔ machine-contract synchronization checks.
- Require change-impact maps for all interface-affecting modifications.

### Phase 3 — Operational readiness integration
- Formalize security verification, abuse-case execution, and release gates.
- Align observability events and SLO/SLI definitions with acceptance criteria.
- Produce evidence templates and automation pathways for repeatable audits.

### Phase 4 — Scaled domain expansion
- Expand into richer capability families while preserving delegation determinism.
- Add extension patterns for post types, principal classes, and integrations.
- Maintain strict precedence, governance discipline, and policy coherence as document count scales beyond 100.

This README is intentionally authoritative and action-directing. As the project evolves, updates to this file must remain precise, deterministic, and consistent with implemented platform intent.
