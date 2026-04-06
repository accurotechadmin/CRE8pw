# UI Contract Artifacts Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define exact UI contract artifacts, expected schema validation behavior, design handoff minimums, and evidence requirements for endpoint-to-UI parity.

## Canonical artifacts
- `ui/endpoints_unified.json` (canonical machine source uses top-level `pages[]`)
- `schemas/ui-page-contract.schema.json` (page-object schema)
- `UI_Parity_and_Contract.md` (behavioral parity binding)
- `UI_Parity_Contract.md` (route-family auth/error UX rules)
- `UI_Endpoint_Contract_Executive_Decisions.md` (executive decisions + rollout intent)
- `UI_Runtime_Contract.md` (SPA runtime behavior baseline for parity implementation)

## Contract object minimums per page
Each `pages[]` entry must include:
- `page_id`, `sprint`, `url`, `method`, `persona`, `purpose`
- `required_fields`, `api_calls`, `success_ux`, `error_ux`, `figma_data`

Optional but strongly recommended:
- `friendly_ui_description`
- `acceptance_criteria`
- `route_states` override

## Route-state baseline
Default route states are:
`idle`, `loading`, `submitting`, `success`, `validation_error`, `forbidden`, `not_found`, `server_error`.

## Design handoff minimums
For every production-bound page contract item, design handoff must include:
- canonical Figma node references in `figma_data`,
- validation and error-state mock variants,
- loading and empty state behavior,
- request-id display/diagnostics placement for failure states,
- accessibility notes for keyboard/focus and semantic labels.

## UI/API parity evidence requirements
A parity-complete page requires all of:
1. API call wiring proven against declared endpoint and method.
2. Envelope success and error parsing consistent with contract.
3. Error class mapping (`401/403/404/422/429/5xx`) verified.
4. Request ID visibility verified in failure diagnostics.
5. Auth-surface policy behavior verified (owner vs key + device/CSRF rules).

## Drift prevention rules
- Any API route or error mapping change must update UI contract artifacts in same PR.
- Any `page_id` removal requires migration note and replacement mapping.
- Legacy `sprints[].pages[]` projection must never be hand-edited when canonical `pages[]` is source.

## Related SSOT docs
- `UI_Parity_and_Contract.md`
- `UI_Parity_Contract.md`
- `API_Contract_Guide.md`
- `Error_Code_Catalog.md`
- `Verification_Strategy.md`
