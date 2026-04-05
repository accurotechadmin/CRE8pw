# Frontend SPA Guide

_Last updated (UTC): 2026-04-05_

## UI architecture

- `public/ui/index.html`: app shell, skip link, flash region, view root, response inspector.
- `public/ui/styles.css`: utility and component-level styles, focus-visible treatment, state chips, table/panel styles.
- `public/ui/state.js`: localStorage-backed owner/key sessions + generated persisted device ID.
- `public/ui/api-client.js`: fetch wrapper with auth header injection, device header option, envelope parsing, normalized error throws.
- `public/ui/app.js`: router, dynamic route matching, all view renderers/forms/guards, flash/inspector/state panels.

## Route inventory

Implemented navigable routes include auth, gateway content, and console moderation/key-management flows:

- `/login`, `/key-login`, `/signup-owner`
- `/feed`, `/posts/new`, `/posts/{postId}`, `/posts/{postId}/edit`, `/posts/{postId}/flag`, `/posts/{postId}/comments`, `/posts/{postId}/comments/new`
- `/console/posts`, `/console/posts/new`, `/console/posts/{postId}/moderation`, `/console/posts/{postId}/comments/{commentId}/moderation`
- `/console/keys/new`, `/console/keys/{keyId}/lifecycle`, `/console/keychains`, `/console/invites/new`

## UX state model

The UI exposes explicit route states and standardized panels for:

`idle`, `loading`, `submitting`, `success`, `validation_error`, `forbidden`, `not_found`, `server_error`.

## Access/guarding behavior

- Owner routes require owner session token for console API calls.
- Gateway routes require key token and auto-send `X-Device-Id`.
- Write forms pre-check expected permission/state constraints to reduce avoidable forbidden requests.
- Dangerous actions (moderation/lifecycle/invite) use shared confirmation mechanics.
