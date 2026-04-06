# UI Parity Contract

_Last updated (UTC): 2026-04-06_

## Route families
- Public auth: `/login`, `/key-login`, `/signup-owner`
- Gateway content: `/feed`, post/detail/edit/flag/comments routes
- Console governance: post list/create/moderation, key issue/lifecycle, keychains, invites

## Auth-surface behavior
- Owner routes require owner token.
- Gateway routes require key token + `X-Device-Id`.

## Required UX for error classes
- `401`: session clear + redirect to appropriate login
- `403`: forbidden panel with reason mapping
- `404`: not-found state
- `422`: field-level validation mapping
- `429`: retry guidance
- `5xx`: generic server error + request-id display

## Dangerous action UX requirements
- Explicit confirmation gating
- Optional typed confirmation for revoke-like actions
- Summary panel before submit
