# Plan: SSOT-First Document Rebuild

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Goal
Produce a cohesive SSOT canon that enables implementation teams to build CRE8 from scratch with low ambiguity and high verification rigor.

## Phases
1. **Canon scaffold**: establish governance/index and machine contracts.
2. **Core contract set**: product/system spec, API/route/auth/data/security docs.
3. **Operational hardening**: verification, readiness gates, smoke contracts, SLOs.
4. **Traceability and governance**: matrices, decision logs, change control, evidence templates.

## Work breakdown
- Baseline interfaces: `openapi/cre8.v1.yaml`, envelope schemas.
- Canonical route behavior: `ROUTE_INVENTORY_REFERENCE.md` + `ACCEPTANCE_CRITERIA_MATRIX.md`.
- Security and authorization baseline: delegation/keychain/lifecycle controls.
- Data model baseline: entity contracts and invariants.
- Program controls: DoD, risk register, roadmap, contribution workflow.

## Exit criteria
- No generic placeholders in normative sections.
- Every route family has positive + negative acceptance criteria.
- Every policy-critical decision appears in decision tables and traceability matrix.
- Release checklist and evidence templates are executable by on-call teams.
