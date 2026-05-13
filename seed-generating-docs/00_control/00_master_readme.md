# Seed-Generating Docs — Master README / Operating Manual

## Purpose
Create a complete, consistent, normalized, implementation-ready seed-generating corpus that enables deterministic regeneration of fresh production-guidance docs.

## Canon relationship model
- Original intent source: `/seed`
- Current evolved corpus: `docs/`, `reports/`, `dev/`
- This package: normalized seed-generating control+knowledge layers
- Final output: fresh production-guidance documents under target blueprint

## Non-loss rule (hard)
No substantive content may be dropped unless explicitly classified as: `deprecated`, `duplicate`, `obsolete`, or `superseded`, with rationale and traceability.

## Required output format
- Markdown only.
- Frontmatter required for normative outputs.
- Requirement IDs + Hook IDs + source traceability required where applicable.

## Generation workflow
1. Build full source inventory (`01_source_inventory.md`).
2. Build preservation ledger (`02_content_preservation_ledger.md`).
3. Normalize vocabulary/style/conflict rules.
4. Build canonical seeds (`10_*` through `19_*`).
5. Generate final set from blueprint (`20_final_document_blueprint.md`).
6. Validate with checklist and consistency matrix.

## Review and validation
- Every source doc inventoried.
- Every meaningful source section mapped.
- Every conflict resolved or registered.
- Every final doc passes template and traceability checks.

## Deterministic session start checklist
- [ ] Read this file fully.
- [ ] Read `30_llm_generation_instructions.md` fully.
- [ ] Confirm no-loss rule.
- [ ] Confirm conflict logging protocol.
- [ ] Confirm final output folder and naming.
