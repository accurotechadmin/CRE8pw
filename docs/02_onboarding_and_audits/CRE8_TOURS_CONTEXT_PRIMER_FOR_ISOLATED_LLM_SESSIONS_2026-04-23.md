# CRE8 TOUR Companion Primer for Isolated LLM Sessions (2026-04-23)

_Status: analysis artifact_
_Date (UTC): 2026-04-23_

## Why this primer exists
This primer is meant to be sent **alongside**:
1. `CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.md`
2. `CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.json`

Those two TOUR files are rich extraction/index artifacts, but by themselves they do not fully explain:
- what CRE8 is,
- which sources are authoritative,
- how to interpret extracted terms safely,
- how to avoid over-claiming runtime readiness.

This document provides that missing context for a new LLM session that cannot see the whole repository.

---

## 1) What CRE8 is (in one page)

### Product concept
CRE8 is a governance-first platform for **delegated authorship and controlled execution** under strict accountability:
- ownership and delegation boundaries are explicit,
- authorization is policy-driven and non-interchangeable across surfaces,
- API behavior is envelope-first and contract-first,
- traceability and release evidence are first-class requirements.

### Architectural stance
CRE8 is intentionally designed around:
- **SSOT-first governance** (canonical docs and machine contracts drive implementation),
- **bounded delegation** (subset/depth/expiry constraints),
- **deterministic contracts** (OpenAPI + success/error envelopes + error catalog),
- **operations/readiness gating** (verification, smoke, health, readiness evidence),
- **human-operability** (runbooks, diagnostics, contributor workflows, explicit owner accountability).

### Current repository maturity posture (important)
This repository snapshot is primarily **documentation-first** and **implementation-light**. In practical terms:
- architecture/contracts/governance material is mature and extensive,
- runtime code/test evidence may be absent or incomplete in this snapshot,
- “docs complete” must not be confused with “production-ready runtime complete.”

---

## 2) What the two TOUR files are

## A) TOUR Markdown (`...INVENTORY...md`)
Human-readable extraction report with three practical layers:
1. **Document extraction index** (per-source topics/vocabulary/components samples),
2. **Centralized inventory list** (ID-based terms/concepts/decisions/routes/components),
3. **Detailed source mapping** (evidence snippets and originating source docs).

Use it when you want readability and quick navigation by humans.

## B) TOUR JSON (`...INVENTORY...json`)
Machine-consumable version of the same conceptual dataset, intended for analysis/automation.

Key structures:
- `document_extractions`: per-file extracted topics/vocabulary/components/decisions/purposes,
- `central_inventory`: normalized item records with evidence and source references,
- metadata/policy fields for extraction scope and downstream filtering.

Use it when you need deterministic processing, transformation, ranking, or tool-assisted reasoning.

## Relationship between them
- They represent the **same extraction universe** in two different formats:
  - Markdown = narrative/navigation interface,
  - JSON = programmatic interface.
- If they disagree, treat JSON as the machine-traceable baseline and verify against canonical SSOT sources.

---

## 3) Authority and precedence (critical for correct reasoning)
When using TOUR outputs in an isolated session, apply this precedence model:

1. **Machine contracts/schemas** (OpenAPI, envelope schemas)
2. **SSOT canon docs** (`docs/ssot_canon/...`)
3. **Governance/process docs** (`docs/...` outside SSOT canon)
4. **Analysis/synthesis artifacts** (including onboarding analyses and TOUR artifacts)

Interpretation rule:
- TOUR artifacts are **evidence indexes**, not normative policy by themselves.
- Never let extracted frequency or centrality override canonical contract text.

---

## 4) How to conceptualize CRE8 + TOUR together

Think in a three-layer model:

### Layer 1 — Normative system definition (truth)
- contracts, security/data/ops specs, ADRs, governance rules.
- this defines what is allowed/required.

### Layer 2 — Inventory/intelligence overlay (map)
- TOUR md/json extraction surfaces concepts, relationships, and evidence locations across docs.
- this helps discovery, synthesis, and impact analysis.

### Layer 3 — Execution/readiness reality (proof)
- runtime code/tests/smoke/release evidence prove whether the normative system is actually implemented.
- absent proof, treat claims as planned/target state rather than observed runtime behavior.

In short:
- **SSOT says what should be true**,
- **TOUR helps you find and connect that truth**,
- **evidence says what is currently true in runtime**.

---

## 5) Safe usage guide for an isolated LLM session

If you only have the two TOUR files + this primer, follow this workflow:

1. **Classify each claim** as one of:
   - fact directly supported by extracted evidence,
   - inference from multiple signals,
   - open question requiring canonical source confirmation.
2. **Tag each source by tier** (machine contract, SSOT canon, governance/analysis).
3. **Prioritize route/auth/delegation/security statements** only when supported by high-tier references.
4. **Avoid runtime certainty claims** unless explicit runtime evidence is present in provided artifacts.
5. **Surface conflicts explicitly** rather than averaging them.
6. **Carry uncertainty forward** when extracted snippets are ambiguous.

Recommended output style for isolated sessions:
- “Facts / Inferences / Open Questions” sections,
- explicit caveat that TOUR is an index layer, not contract authority.

---

## 6) Common interpretation pitfalls

1. **Pitfall:** treating extracted terms as canonical definitions.
   - **Fix:** look for governing SSOT/contract source first.

2. **Pitfall:** inferring production readiness from rich documentation.
   - **Fix:** separate SSOT maturity from runtime/release maturity.

3. **Pitfall:** assuming all relationships are semantic decisions.
   - **Fix:** some links are lexical/structural extraction artifacts.

4. **Pitfall:** over-weighting historical artifacts.
   - **Fix:** check status/time context and supersession signals.

5. **Pitfall:** conflating console and gateway auth contexts.
   - **Fix:** maintain strict surface-boundary reasoning.

---

## 7) Minimal glossary for external readers

- **SSOT:** Single Source of Truth canonical documentation set.
- **Envelope-first API:** standard success/error wrapper semantics for responses.
- **Delegation envelope:** bounded permission/expiry/depth constraints passed from delegator to delegate.
- **Readiness gates:** required quality/ops/security evidence before release progression.
- **Traceability:** ability to map requirements/contracts/decisions to implementation and evidence.
- **TOUR inventory:** cross-document extraction artifact for concepts/decisions/components/purposes/relationships.

---

## 8) Suggested prompt to give the next LLM session

Use this starter framing:

> You have three files: the CRE8 TOUR markdown inventory, the equivalent TOUR JSON inventory, and a primer.
> Build a structured understanding of CRE8 by separating facts/inferences/open questions.
> Treat TOUR artifacts as index/intelligence layers, not authority.
> Use precedence: machine contracts > SSOT canon > governance docs > analysis artifacts.
> Do not claim runtime readiness without explicit runtime evidence.
> Produce: (1) system model, (2) auth/delegation model, (3) API/error model, (4) risks/unknowns.

---

## 9) What this primer does **not** replace
This primer does not replace canonical CRE8 source docs and machine contracts.
It is a context bridge for constrained sessions only.
When full repository access is available, always defer to canonical sources and current evidence artifacts.
