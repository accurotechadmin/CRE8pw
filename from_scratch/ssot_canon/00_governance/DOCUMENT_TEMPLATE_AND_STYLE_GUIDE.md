# Document Template and Style Guide

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide enforceable structure and writing conventions for canonical SSOT documents.

## Scope
All markdown files in this canon.

## Normative statements
- Canon docs MUST include the standard section skeleton.
- Normative behavior MUST use RFC-style keywords (MUST/SHOULD/MAY).
- Claims SHOULD cite implementation anchors and tests where possible.
- Uncertain facts MUST be labeled as draft assumptions.

## Interfaces / contracts
### Required skeleton
1. Title
2. Status/date metadata
3. Canonical terminology reference
4. Purpose / Scope
5. Normative statements
6. Interfaces/contracts
7. Failure semantics
8. Verification requirements
9. Traceability hooks
10. Open questions/known gaps

### Style rules
- Keep sections concise and implementation-oriented.
- Prefer tables for matrices, route mappings, and owner assignments.
- Use relative links within the canon tree.

## Failure/rejection semantics
- Missing required sections SHOULD fail lint.
- Non-normative or ambiguous policy language MAY be rejected during review.

## Verification requirements
- Linter MUST detect section heading presence and metadata format.
- Peer review MUST validate that each changed doc has explicit verification hooks.

## Traceability hooks
- Code refs: `docs/SSOT/SSOT_Automation_and_Linting.md`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php`
- Related SSOT docs: `SSOT_INDEX.md`, `CHANGE_CONTROL_POLICY.md`, `../50_traceability_and_automation/SSOT_AUTOMATION_AND_LINTING.md`

## Open questions / known gaps
- Formal markdown lint config is not yet present; rules are policy-only in v1.
