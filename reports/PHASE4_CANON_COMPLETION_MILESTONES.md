# Phase 4 Plan — Canonical Spec Corpus (`docs/`) Completion Program

## Purpose
This plan defines the final content-completion phase for the canonical SSOT corpus under `docs/`, focused on:
- full normative completeness,
- robust cross-document consistency,
- explicit requirement-to-contract-to-evidence traceability,
- and elimination of unresolved semantic gaps prior to the final organization/cleanup pass.

This phase intentionally prioritizes *content completeness and consistency* over editorial polish.

---

## Target End State (Definition of 100% for this phase)
A document set is considered complete for this phase when all of the following are true:

1. **Normative closure**
   - Every MUST/SHALL statement has explicit scope, actor, trigger, and expected outcome.
   - No ambiguous placeholders remain in canonical prose.

2. **Cross-reference closure**
   - All internal links resolve to existing anchors/files.
   - Conceptual dependencies are bidirectionally linked where needed (spec ↔ tables ↔ contracts ↔ operations).

3. **Contract parity closure**
   - Prose route/contracts align with `docs/31_machine_contracts/openapi/cre8.v1.yaml` and JSON schemas.
   - Error semantics and auth semantics are consistent across guides/catalogs/tables.

4. **Traceability closure**
   - Requirements map cleanly into `TRACEABILITY_MATRIX`, evidence templates, and verification strategy.
   - No orphaned requirements or unreferenced normative sections.

5. **Operational closure**
   - Runbooks/gates/checklists are consistent with security, data, and identity constraints.
   - Phase exception registers are either resolved or explicitly bounded.

---

## Canonical Mental Model (Intended Finalized Outcome)
The corpus behaves like an integrated layered system:

- **Governance foundation (`00_`)** defines authoring and control rules.
- **Product/architecture (`10_`)** defines domain boundaries and system surfaces.
- **Identity/policy (`20_`)** defines principal semantics and authorization/delegation behavior.
- **Interface contracts (`30_` + `31_`)** define route-level behavior and machine-checked schema surface.
- **Security/data (`40_`)** defines threat controls, cryptographic profile, and data constraints.
- **Content/feed (`50_`)** defines audience selection, ranking, interaction semantics.
- **Operations/release (`60_`)** defines runtime guarantees, health/smoke, SLO, readiness.
- **Extensibility (`70_`)** defines extension boundaries without violating policy/data guarantees.
- **Program/traceability (`80_`)** defines how decisions and requirements are verified and maintained.
- **Evidence (`docs/evidence`)** provides structured proof artifacts for acceptance and audits.

The end state is a closed SSOT loop where each normative statement is:
`defined -> constrained -> exposed via contract -> verified -> evidenced -> governed`.

---

## Milestones and Slices

## M1 — Normative Semantics Hardening (Foundational Closure)
**Outcome:** Canonical prose is unambiguous, actor-scoped, and implementation-verifiable.

### Slices
- **P4-S1.1** Build corpus-wide normative statement inventory (`MUST/SHALL/REQUIRED`) with source anchors.
- **P4-S1.2** Normalize actor vocabulary (system, issuer, principal, moderator, integration provider, operator).
- **P4-S1.3** Resolve modal inconsistency (MUST vs should vs may) per `DOCUMENT_TEMPLATE_AND_STYLE_GUIDE`.
- **P4-S1.4** Add trigger/precondition/result triads to weak normative clauses.
- **P4-S1.5** Remove or convert residual placeholder language into explicit bounded exceptions.
- **P4-S1.6** Reconcile duplicated normative clauses across `10_`, `20_`, `30_`, `40_`, `60_` with single-source anchors.

---

## M2 — Identity/Auth/Delegation Consistency Closure
**Outcome:** Identity and policy semantics are internally consistent and contract-linked.

### Slices
- **P4-S2.1** Align principal taxonomy between `PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX` and authorization specs.
- **P4-S2.2** Reconcile permission vocabulary terms across policy docs, route docs, and error catalog.
- **P4-S2.3** Validate delegation state transitions against explicit deny/allow outcomes and failure paths.
- **P4-S2.4** Ensure keychain composition and keypair lifecycle terms are semantically aligned with crypto specs.
- **P4-S2.5** Add explicit precedence rules for conflicting policy signals (direct permission, delegated capability, scope constraints).
- **P4-S2.6** Cross-link identity decision tables to route examples and machine-response schemas.

---

## M3 — Contract and Schema Parity Completion
**Outcome:** Prose interface docs and machine contracts are equivalent in behavioral meaning.

### Slices
- **P4-S3.1** Route-by-route parity check: `ROUTE_INVENTORY_REFERENCE` ↔ OpenAPI paths/operations.
- **P4-S3.2** Validate request/response examples against JSON schemas and OpenAPI examples.
- **P4-S3.3** Ensure error code catalog deterministically maps to envelope schema and endpoint contexts.
- **P4-S3.4** Reconcile authz-decision and lifecycle response semantics between prose and schema artifacts.
- **P4-S3.5** Tighten contract version policy with explicit backward-compatibility and deprecation triggers.
- **P4-S3.6** Add missing cross-links from `API_CONTRACT_GUIDE` and endpoint examples into machine contract sources.

---

## M4 — Security/Data/Crypto Integrity Closure
**Outcome:** Security and data constraints are fully propagated to contracts and operations.

### Slices
- **P4-S4.1** Map threat scenarios to control statements with explicit verification hooks.
- **P4-S4.2** Ensure key lifecycle controls have corresponding operational controls and failure handling.
- **P4-S4.3** Reconcile data model spec/reference/ERD identifiers and cardinality semantics.
- **P4-S4.4** Validate security headers/CSP policy requirements against runtime contract docs.
- **P4-S4.5** Add explicit cross-links from security controls to relevant API error behaviors and observability events.
- **P4-S4.6** Close abuse-case residuals by adding mitigation ownership and evidence location fields.

---

## M5 — Feed/Content/Audience Behavioral Closure
**Outcome:** Audience targeting and feed behavior are complete, deterministic, and policy-compatible.

### Slices
- **P4-S5.1** Validate audience group semantics against principal/permission vocabulary.
- **P4-S5.2** Reconcile ranking/ordering rules with documented operational constraints and SLO expectations.
- **P4-S5.3** Ensure interaction/comment policy includes all moderation and authorization branches.
- **P4-S5.4** Add failure/error semantics for feed-generation edge cases.
- **P4-S5.5** Cross-link content/feed rules with route examples and contract schema examples.

---

## M6 — Operations/Quality/Release Closure
**Outcome:** Operational contracts and gates are fully synchronized with all normative dependencies.

### Slices
- **P4-S6.1** Reconcile startup/health/smoke contracts with declared dependency baseline and config contract.
- **P4-S6.2** Ensure observability event catalog covers all critical policy/security/contract decision points.
- **P4-S6.3** Align production readiness gates with security and traceability requirements.
- **P4-S6.4** Normalize release checklist items to explicit pass/fail evidence artifacts.
- **P4-S6.5** Resolve or bound all remaining entries in phase exception registers.
- **P4-S6.6** Verify migration/seed strategy assumptions are consistent with current canonical data/contract model.

---

## M7 — Extensibility Boundary Closure
**Outcome:** Extension mechanisms are complete and cannot violate core guarantees.

### Slices
- **P4-S7.1** Enforce extension boundary constraints against identity, security, and data invariants.
- **P4-S7.2** Ensure post/principal extension specs define required validation and rollback behavior.
- **P4-S7.3** Reconcile integration provider pattern obligations with observability and incident response expectations.
- **P4-S7.4** Add explicit “non-overridable core controls” section across extension docs.
- **P4-S7.5** Cross-link extensibility docs to route/webhook contracts and permission vocabulary.

---

## M8 — Traceability and Evidence Closure (Program Lock)
**Outcome:** Every normative requirement is traceable, verifiable, and evidence-addressable.

### Slices
- **P4-S8.1** Refresh requirement inventory from canonical docs only and detect orphans/duplicates.
- **P4-S8.2** Complete matrix links: requirement ↔ source anchor ↔ verification artifact ↔ evidence template.
- **P4-S8.3** Reconcile ADR implications with current normative corpus and mark superseded decisions.
- **P4-S8.4** Update risk register mapping to unresolved requirement or verification gaps.
- **P4-S8.5** Ensure seed promotion tracker reflects current closure state and excludes stale exceptions.
- **P4-S8.6** Produce completion evidence bundle index for final editorial/organization phase handoff.

---

## Execution Sequence and Gating
- **Order:** M1 → M2/M3/M4 in parallel lanes → M5/M6/M7 → M8.
- **Hard gates:**
  1. M1 must complete before formal parity sign-off in M3.
  2. M2 must complete before M5 and M7 final lock.
  3. M4 must complete before M6 gate finalization.
  4. M8 is final and requires all upstream lanes closed.

---

## Deliverables at Phase Exit
1. Updated canonical documents with resolved gaps and normalized language.
2. Closed cross-reference graph across `docs/`.
3. Parity-confirmed prose/machine contract set.
4. Updated traceability matrix and risk register deltas.
5. Evidence bundle index ready for final organization and cleanup pass.

