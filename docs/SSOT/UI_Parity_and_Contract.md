# UI Parity and Contract (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Canonical source
- Contract source: `ui/endpoints_unified.json`
- Contract decisions: `UI_Endpoint_Contract_Executive_Decisions.md`
- Behavior rules: `UI_Parity_Contract.md`
- Artifact validation and design handoff rules: `UI_Contract_Artifacts_Reference.md`

## Endpoint/UI parity summary
- Backend routes are grouped by public, gateway, and console surfaces.
- SPA routes cover core auth/content/moderation/key workflows.
- Mandatory parity coverage includes `/`, `/health`, `/.well-known/jwks.json`, and auth refresh paths.

## Canonical UI route states
`idle`, `loading`, `submitting`, `success`, `validation_error`, `forbidden`, `not_found`, `server_error`.

## Contract shape decisions
- Canonical machine source = top-level `pages[]`.
- `sprints[].pages[]` is compatibility/derived projection.
- Use normalized `figma_data` key.

## Synchronization rule
When route behavior or error mapping changes, update UI contract artifacts and API/SSOT docs in the same PR.
