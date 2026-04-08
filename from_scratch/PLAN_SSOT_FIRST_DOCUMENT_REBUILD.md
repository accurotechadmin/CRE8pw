# Plan: SSOT-First Documentation Rebuild

_Status: draft_
_Last updated (UTC): 2026-04-08_

## 0) Objective

Rebuild CRE8 documentation from scratch so that:

- a concise SSOT core defines canonical product, architecture, API, data, security, and operations truth,
- all other docs derive from (and never conflict with) that SSOT core,
- the SSOT core becomes the primary guide for future CRE8.pw development.

## 1) Layer model (build order)

### Layer A — Core SSOT Foundation (build first)
Create the minimum canonical set required to guide implementation safely:

1. `SSOT_INDEX.md` (governance, precedence, ownership, update rules)
2. `CRE8_PRODUCT_AND_SYSTEM_SPEC.md` (purpose, personas, capabilities, constraints)
3. `CANONICAL_TERMINOLOGY.md`
4. `ARCHITECTURE_AND_SURFACES.md` (public/auth/gateway/console trust boundaries)
5. `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
6. `API_CONTRACT_GUIDE.md` + machine OpenAPI contract
7. `AUTHORIZATION_AND_DELEGATION_SPEC.md`
8. `DATA_MODEL_SPEC.md`
9. `SECURITY_CONTROLS_SPEC.md`
10. `OPERATIONS_AND_STARTUP_CONTRACT.md`
11. `TRACEABILITY_MATRIX.md`

Exit criteria for Layer A:

- Every required runtime behavior maps to at least one SSOT document.
- Envelope contract, auth surfaces, and critical error semantics are explicit.
- No unresolved contradiction across Layer A docs.

### Layer B — SSOT Expansion (build second)
Add depth after Layer A stabilizes:

- Decision tables
- Error catalog
- Threat model
- Acceptance matrix
- SLO/SLI and release gates
- Verification strategy
- UI runtime and parity contracts
- IaC/infrastructure references

Exit criteria for Layer B:

- Security, operations, and QA teams can execute reviews from docs alone.
- Release-readiness criteria are machine-checkable where possible.

### Layer C — Derived Non-SSOT Reference Docs (build third)
Regenerate developer-facing references from SSOT:

- architecture overview, onboarding guides,
- implementation references,
- contributor and local-dev flow docs,
- endpoint quick references and examples,
- troubleshooting runbooks.

Rule: Layer C docs must cite Layer A/B SSOT sources and never override them.

### Layer D — Execution/History Layer (build fourth)
Maintain transient artifacts separately:

- session logs,
- implementation ledgers,
- QA evidence snapshots.

Rule: recurring stable guidance is promoted upward into Layer C or SSOT.

## 2) Governance and editorial workflow

1. SSOT docs are versioned with status tags (`draft/adopted/deprecated`).
2. Any change to route/middleware/auth/data/security policy requires same-change SSOT updates.
3. PR reviews include:
   - SSOT consistency check,
   - traceability check (doc ↔ contract ↔ code/test),
   - conflict check against existing canonical docs.
4. Monthly security/operations SSOT review; per-release API/data/UI contract review.

## 3) Practical implementation sequence for this repository

1. Establish new from-scratch workspace in repository root (`/from_scratch`).
2. Capture ethos and identity baseline (`CORE_IDENTITY_AND_VALUE_PROPOSITION.md`).
3. Draft Layer A file list and templates.
4. Populate Layer A canonical docs in dependency order:
   - terminology/spec first,
   - architecture/pipeline second,
   - API/auth/data/security/ops third,
   - traceability matrix last.
5. Run SSOT lint/sync checks and close drift issues.
6. Regenerate non-SSOT docs as derived views.

## 4) Why this order is high-leverage

- Avoids documentation sprawl before foundational decisions are explicit.
- Reduces implementation drift by anchoring design decisions to canonical contracts.
- Preserves CRE8's strongest existing qualities: modular extensibility, policy-first security, and contract-heavy verification.

## 5) Immediate next-step checkpoint

This plan completes the requested kickoff stage by defining the full rebuild path and creating a dedicated root section for from-scratch work. The next stage is to gather and formalize deeper technical details into Layer A SSOT documents.
