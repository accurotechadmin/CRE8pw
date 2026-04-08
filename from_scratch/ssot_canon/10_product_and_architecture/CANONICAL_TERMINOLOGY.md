# Canonical Terminology

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Normalize naming across contracts, code, and tests to reduce interpretation drift.

## Scope
Terms for identities, credentials, routes, envelopes, errors, policies, and operational states.

## Normative statements
- Canon terms MUST be used in new SSOT docs.
- Legacy synonyms SHOULD be listed with canonical replacements.
- Ambiguous terms MAY not be introduced without definition updates.

## Interfaces / contracts
| Canon term | Meaning | Legacy aliases |
|---|---|---|
| Owner | Privileged console principal | admin/user |
| Key principal | API key-bearing actor | author/use/delegated key |
| Surface | Route trust boundary grouping | zone |
| Envelope | Stable JSON success/error wrapper | response body |
| Drift | Canon vs code mismatch | doc gap |

## Failure/rejection semantics
- Undefined term use SHOULD fail docs review.
- Inconsistent term mapping MUST be logged as drift.

## Verification requirements
- Lint check for presence of canonical terminology link in each doc.
- Manual review of renamed terms in changed files.

## Traceability hooks
- Code refs: `src/Security/VerifiedPrincipal.php`, `src/Http/Middleware/*`
- Tests refs: `tests/Contract/EnvelopeResponderContractTest.php`
- Related SSOT docs: `CRE8_PRODUCT_AND_SYSTEM_SPEC.md`, `../20_contracts/API_CONTRACT_GUIDE.md`

## Open questions / known gaps
- Need finalized glossary entries for keychain and delegation lineage depth rules.

## Session progress (2026-04-08)
### Completed in this session
- Stabilized architecture/product skeleton and canonical terminology linkage.
- Kept normative constraints explicit to minimize interpretation drift.
- Aligned scope to current runtime surfaces and middleware-driven architecture.
### Remaining to finish this document
- [ ] Add authoritative capability boundaries and out-of-scope definitions.
- [ ] Add concrete diagrams/tables for surfaces, trust boundaries, and request flow.
- [ ] Trace every normative statement to code modules and tests.

