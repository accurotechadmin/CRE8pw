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
## Deterministic rerun protocol
- Pin execution context at startup: record UTC timestamp, active handoff path, selected slices, and scope-lock expectation rows before authoring begins.
- For each touched concept, maintain chain: `source -> normalized_concept -> target_seed_section -> implementation_implication` in the preservation ledger.
- Treat `/fresh` as the net-new artifact root; if protocol requires in-place continuity/governance updates, mirror equivalent export artifacts under `/fresh` when practical.
- Run scope-lock checks after each slice and record findings in `30_governance/36_scope_lock_register.md` (including explicit `scope_expansion_candidate` entries when detected).
- End each run by executing `31_validation_checklist.md` with PASS/PARTIAL/FAIL evidence and updating latest handoff pointers.

## Deterministic output contract
- Every generated document must declare: purpose, audience, canonical dependency anchors, source traceability rows, unresolved-conflict references, and implementation implications.
- If ambiguity remains after conflict processing, preserve both interpretations and mark status `deferred` with explicit reviewer action; do not collapse meaning implicitly.
- Generation is not implementation-ready unless preservation, conflict, consistency, and scope-lock gates are all explicitly reported.

## Minimum content thresholds (M6/S6.4)
- For each generated final document, include at least one concrete requirement statement per applicable CRE8 ethos domain, plus explicit dependency-baseline anchors where relevant.
- Each generated document must include at minimum: `Purpose`, `Audience`, `Normative anchors`, `Source traceability`, `Conflict/decision status`, and `Implementation implications` sections.
- A generated document fails threshold if any required section is missing, placeholder-only, or lacks at least one trace-linked source reference.

## Idempotency checks (M6/S6.5)
- Re-running generation with the same inputs, slice set, and scope-lock assumptions must preserve section ordering, heading identifiers, and traceability row references.
- Any rerun delta must be classifiable as one of: `source_change`, `conflict_disposition_change`, `decision_change`, or `bugfix`; otherwise mark as drift and block completion.
- Record rerun hash inputs (active handoff file, selected slices, source inventory revision markers) in session handoff notes to support deterministic replay audits.
