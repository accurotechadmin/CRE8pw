# UI Parity Contract

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Route families
- Public auth: `/login`, `/key-login`, `/signup-owner`
- Gateway content: `/feed`, `/posts/*`, `/comments/*`
- Console governance: `/console/*` routes for posts, moderation, keys, invites, and lifecycle actions

## Auth-surface behavior
- Owner routes require owner token (`typ=owner`).
- Gateway routes require key token (`typ=key`) + `X-Device-Id` where enforced.
- Unauthorized responses must preserve `request_id` for support diagnostics.

## Required UX for error classes
- `401`: session clear + redirect to appropriate login
- `403`: forbidden panel with reason mapping
- `404`: not-found state
- `422`: field-level validation mapping
- `429`: retry guidance
- `5xx`: generic server error + request-id display

## UX consistency rules
- UI field validation names map directly to `error.details[]` keys.
- Retry affordances must honor limiter metadata where present.
- Every API-backed page must include loading, empty, and failure states.
