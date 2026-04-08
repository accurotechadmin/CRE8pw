# SSOT Canon Index (From-Scratch)

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define the authoritative reading order and precedence for the new CRE8 SSOT canon under `/from_scratch/ssot_canon`.

## Scope
Applies to all files under this canon tree. Legacy docs under `/docs` remain historical references until migrated.

## Normative statements
- This index MUST be treated as the canonical entrypoint for SSOT interpretation.
- If this canon conflicts with legacy docs, this canon MUST win after adoption gate approval.
- SSOT-impacting PRs MUST update affected canon docs in the same PR.
- New canonical documents SHOULD be added to this index before merge.

## Interfaces / contracts
### Reading order
1. `00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md`
2. `00_governance/CHANGE_CONTROL_POLICY.md`
3. `00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`
4. `10_product_and_architecture/*`
5. `20_contracts/*`
6. `30_data_and_security/*`
7. `40_operations_and_quality/*`
8. `50_traceability_and_automation/*`
9. `openapi/cre8.v1.yaml`
10. `schemas/*.json`

### Canon set inventory
- Governance: `00_governance/*.md`
- Product/architecture: `10_product_and_architecture/*.md`
- Contracts: `20_contracts/*.md`
- Data/security: `30_data_and_security/*.md`
- Operations/quality: `40_operations_and_quality/*.md`
- Traceability/automation: `50_traceability_and_automation/*.md`

## Failure/rejection semantics
- Missing SSOT updates for contract changes MUST block merge.
- Broken cross-links SHOULD fail docs lint.
- Ambiguous precedence between canon and legacy docs MUST be logged in `KNOWN_GAPS_TRACKER.md`.

## Verification requirements
- Run `composer docs:ssot:lint`, `composer docs:ssot:sync-check`, and `composer docs:ssot:report` (target contract; currently only scaffolded in `code/composer.json`).
- Validate that each listed file exists and has required metadata sections.

## Traceability hooks
- Code refs: `composer.json`, `code/composer.json`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php`
- Related SSOT docs: `CHANGE_CONTROL_POLICY.md`, `../50_traceability_and_automation/TRACEABILITY_MATRIX.md`, `../50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- Adoption moment for “canon wins conflicts” is pending explicit owner approval.
- Root project lacks SSOT script commands required by canon policy.
