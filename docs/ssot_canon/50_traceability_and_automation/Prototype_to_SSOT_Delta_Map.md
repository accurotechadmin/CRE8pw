# Prototype to SSOT Delta Map (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-09_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Capture known prototype-to-canon deltas so unresolved implementation assumptions are tracked explicitly and either converged or promoted to formal gaps.

## Delta map
| Delta ID | Area | Prototype behavior | Canonical SSOT behavior | Resolution status | Owner |
|---|---|---|---|---|---|
| D-001 | Route contracts | Prototype route docs were partial and non-versioned | Route inventory + OpenAPI are canonical and versioned | Resolved | Architecture lead |
| D-002 | Authorization | Prototype omitted production keychain semantics | Keychain is v1 production-active with invariants and decision tables | Resolved | Security lead |
| D-003 | Verification | Prototype test guidance was ad hoc | Verification + smoke + readiness gates are mandatory | Resolved | QA lead |

## Promotion rule
If a delta remains unresolved and materially impacts behavior, create/update a corresponding risk/task register entry in the same PR.
