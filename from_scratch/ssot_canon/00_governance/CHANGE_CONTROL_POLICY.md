# Change Control Policy

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Specify how SSOT and implementation changes are synchronized to prevent behavioral drift.

## Scope
Applies to route, middleware, auth, data, security, startup, observability, and verification changes.

## Normative statements
- Any SSOT-impacting code change MUST include same-PR canon updates.
- Any canon change that alters runtime behavior MUST include planned code/test impact notes.
- Contract changes MUST update OpenAPI, route inventory, error catalog, and traceability matrix together.
- Drift accepted temporarily MAY be merged only with explicit entry in `KNOWN_GAPS_TRACKER.md` including exit date.

## Interfaces / contracts
### Change classes
- Class A: contract surface (routes/envelopes/errors/auth claims)
- Class B: security controls and middleware order
- Class C: data schema/invariants
- Class D: operations/release criteria

### Required artifacts per class
- A: `API_CONTRACT_GUIDE.md`, `ROUTE_INVENTORY_REFERENCE.md`, `ERROR_CODE_CATALOG.md`, `openapi/cre8.v1.yaml`
- B: `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`, `SECURITY_CONTROLS_SPEC.md`
- C: `DATA_MODEL_SPEC.md`, `DATA_MODEL_REFERENCE.md`, `ERD.md`
- D: `VERIFICATION_STRATEGY.md`, `PRODUCTION_READINESS_GATES.md`, `RELEASE_CHECKLIST.md`

## Failure/rejection semantics
- Missing synchronized artifacts MUST fail review.
- Conflicting normative statements across docs MUST block adoption until resolved.

## Verification requirements
- Execute SSOT lint/sync/report checks.
- Confirm impacted tests under `tests/Contract` and `tests/Security` are added/updated.

## Traceability hooks
- Code refs: `src/Http/Routes/RouteRegistrar.php`, `src/Http/Middleware/MiddlewareOrder.php`
- Tests refs: `tests/Contract/RouteRegistrarContractsTest.php`, `tests/Contract/MiddlewareRegistryContractsTest.php`
- Related SSOT docs: `SSOT_INDEX.md`, `../50_traceability_and_automation/CHANGE_IMPACT_MAP_TEMPLATES.md`, `../50_traceability_and_automation/KNOWN_GAPS_TRACKER.md`

## Open questions / known gaps
- CI policy file for automatic gate enforcement is not yet defined in repo root.

## Session progress (2026-04-08)
### Completed in this session
- Finalized mandatory section structure (Purpose, Scope, Normative statements, Interfaces, Failure semantics, Verification, Traceability).
- Confirmed cross-link dependency on canonical terminology and SSOT index.
- Prepared this document for owner assignment and lifecycle-state locking.
### Remaining to finish this document
- [ ] Define and approve owner + reviewer roles with escalation timelines.
- [ ] Attach CI/lint enforcement rules that validate this document's governance constraints.
- [ ] Resolve open questions and promote status from draft to approved.

