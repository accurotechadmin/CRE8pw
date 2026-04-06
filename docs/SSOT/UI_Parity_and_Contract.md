# UI Parity and Contract (SSOT)

_Last updated (UTC): 2026-04-06_

## Canonical source
- Contract source: `ui/endpoints_unified.json`
- Contract decisions: `UI_Endpoint_Contract_Executive_Decisions.md`

## Endpoint/UI parity summary
- Backend routes grouped public/gateway/console.
- SPA routes cover all core auth/content/moderation/key workflows.
- Dedicated UI expansion targets include `/`, `/health`, `/.well-known/jwks.json`, `/api/auth/refresh`.

## Canonical UI route states
`idle`, `loading`, `submitting`, `success`, `validation_error`, `forbidden`, `not_found`, `server_error`.

## Contract shape decisions
- Canonical machine source = top-level `pages[]`.
- `sprints[].pages[]` is compatibility/derived projection.
- Use normalized `figma_data` key.
