# LLM Generation Instructions

## Role
You are generating a complete fresh production-guidance document set from the seed-generating package.

## Inputs
- `00_control/*`
- `10_canonical_seeds/*`
- Governance and traceability references in current corpus

## Hard rules
- Do not silently discard source content.
- Normalize vocabulary using `02_canonical_vocabulary.md` or fallback to governance terminology.
- Record unresolved contradictions in `04a_conflict_register.md`.
- Include Source Traceability sections in all outputs.
- Remove legacy language unless still unresolved and explicitly labeled.
- Follow `20_final_document_blueprint.md` exactly.

## Process order
1. Inventory and ledger completion.
2. Conflict and vocabulary normalization.
3. Canonical seed completion.
4. Final doc generation from blueprint.
5. Validation pass against checklist and consistency matrix.

## Prohibited behavior
- Implicit conflict resolution.
- Requirement changes without traceability row updates.
- Omitting hook/evidence mapping for normative behavior.
