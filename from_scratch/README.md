# CRE8 From-Scratch SSOT Canon

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Purpose
This folder is the implementation-first, specification-grade canon for rebuilding CRE8 coherently from zero while preserving proven contracts from the legacy SSOT set.

## What this canon governs
- Product behavior and architecture boundaries.
- API/UI/runtime contracts and data/security invariants.
- Delivery controls: verification, release gates, traceability, and program governance.

## Required reading path
1. `PLAN_SSOT_FIRST_DOCUMENT_REBUILD.md`
2. `TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`
3. `ssot_canon/00_governance/SSOT_INDEX.md`
4. `ssot_canon/10_product_and_architecture/*`
5. `ssot_canon/20_contracts/*`
6. `ssot_canon/30_data_and_security/*`
7. `ssot_canon/40_operations_and_quality/*`
8. `ssot_canon/50_traceability_and_automation/*`
9. `ssot_canon/60_decisions/*`
10. `ssot_canon/70_implementation_guidance/*`
11. `ssot_canon/80_program_management/*`

## Non-negotiable rules
- OpenAPI + envelope schemas are machine source-of-truth for interface shape.
- Route inventory + acceptance criteria are source-of-truth for behavior.
- Data model, authorization, and security controls must remain mutually consistent.
- Any behavior change requires traceability update in the same PR.

## Definition of quality for this canon
A document is considered production-grade only when it is:
- specific enough to implement without guessing,
- testable with explicit commands/evidence,
- traceable to code and operations controls,
- internally link-consistent within this folder.
