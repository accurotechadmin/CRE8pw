# Acceptance Criteria Matrix (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

## Purpose
Provide explicit, route-level Given/When/Then criteria (including negative and edge conditions) to reduce interpretation drift between backend, frontend, QA, and operations.

## Usage contract
- This matrix is normative for QA acceptance and release signoff.
- OpenAPI remains normative for request/response shape; this matrix is normative for behavioral intent.
- For conflicts, update both this matrix and OpenAPI-related artifacts in the same PR.

## Route acceptance matrix

| Capability | Route(s) | Positive acceptance (Given/When/Then) | Negative/edge acceptance | Evidence required |
|---|---|---|---|---|
| Service reachability | `GET /` | Given service is healthy, when route is requested, then success envelope is returned with `meta.envelope_version`. | If responder fails, return `500 internal_error` with `request_id`. | Contract test + health smoke output |
| Deep health | `GET /health` | Given dependencies are healthy, when requested, then all subsystem checks pass. | If any dependency fails, response indicates degraded/fail status and preserves correlation metadata. | Ops smoke + dashboard evidence |
| JWKS publishing | `GET /.well-known/jwks.json` | Given active signer set exists, when requested, then JWKS contains active verification keys. | During key rotation, overlapping key set is present until TTL drain completes. | Rotation rehearsal log + contract check |
| UI shell fallback | `GET /ui/{route}` | Given a valid SPA route request, when requested, then UI shell/static asset response is returned for client-side routing. | Unknown static assets return `404`; route fallback must not leak API-only security headers/cookies. | Browser parity check + security header verification |
| Owner signup | `POST /console/owners` | Given valid email/password, when submitted, then owner principal is created and success envelope returned. | Duplicate owner/email emits `409 conflict`; invalid payload emits `422 validation_failed`. | Contract tests for 201/409/422 |
| Owner login | `POST /api/auth/login` | Given valid owner credentials, when submitted, then owner JWT + refresh issued. | Invalid credentials -> `401 auth_invalid`; malformed payload -> `422`. | Auth contract + security tests |
| Key login | `POST /api/auth/key-login` | Given valid key credentials and policy compliance, when submitted, then key JWT + refresh issued. | Revoked/suspended/expired key or policy violation returns `401/403` as applicable; device claim/header mismatch on protected route returns `401 auth_invalid` (`token_device_mismatch`). | Contract + security regression suite |
| Refresh | `POST /api/auth/refresh` | Given valid refresh token family state, when submitted, then access token rotates and family state updates atomically. | Replay/invalid refresh returns `401 auth_invalid`; invalid body returns `422`. | Refresh replay security tests |
| Feed read | `GET /api/feed` | Given key JWT and required headers, when requested, then feed returns scoped content in stable order. | Missing/invalid auth -> `401`; disallowed scope -> `403`; limiter exceeded -> `429`. | Gateway contract + rate-limit tests |
| Post create | `POST /api/posts` | Given key has `posts:create` and allowed scope, when submitted, then post is created and visible by policy. | Use-key mutation restriction or missing permission -> `403`; invalid payload -> `422`. | Gateway contract + authz tests |
| Post read/edit | `GET/PATCH /api/posts/{postId}` | Given post visible to key, when requested/edited by authorized actor, then success envelope returned and revisions recorded. | Non-visible/non-existent -> `404`; unauthorized edit -> `403`; invalid edit payload -> `422`. | Contract + post revision verification |
| Post flag | `POST /api/posts/{postId}/flags` | Given visible post and valid reason, when submitted, then flag record is persisted. | Invalid reason/payload -> `422`; non-visible post -> `404` or policy outcome. | Contract + moderation audit checks |
| Comment list/create | `GET/POST /api/posts/{postId}/comments` | Given post visibility and comments policy, when requested/submitted, then comment list/create succeeds per permissions. | Disabled comments or missing permission -> `403`; invalid payload -> `422`. | Contract + policy mapping tests |
| Console posts | `GET/POST /console/api/posts` | Given owner JWT (+CSRF for writes), when requested, then governance listing/create actions succeed. | Missing owner JWT -> `401`; invalid CSRF -> `403`; invalid payload -> `422`. | Console contract + CSRF tests |
| Keychain list/create | `GET/POST /console/api/keychains` | Given owner JWT, when requested, then keychain inventory/create succeeds with keychain principal semantics. | Invalid creation payload -> `422`; auth failure -> `401/403`. | Keychain contract tests |
| Keychain membership mutate | `GET /console/api/keychains/{keychainId}/members`, `POST /console/api/keychains/{keychainId}/members`, `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}` | Given owner JWT and valid member class, when mutating membership, then effective snapshot recomputation is triggered and auditable. | Duplicate member -> `409`; nested keychain attempt -> `422/403`; oversized membership (>50) blocked. | Keychain invariants tests + audit events |
| Keychain resolve | `GET /console/api/keychains/{keychainId}/resolve` | Given valid keychain and owner JWT, when requested, then effective permissions/scope plus lineage projection returned. | Missing keychain -> `404`; unauthorized -> `401/403`. | Contract + lineage tests |
| Invite issue | `POST /console/api/invites` | Given owner JWT and valid target constraints, when submitted, then invite receipt persisted with expiry. | Invalid expiry/target -> `422`; unauthorized -> `401/403`. | Console contract tests |
| Key issue/lifecycle | `POST /console/api/keys` + `POST /console/api/keys/{keyId}/lifecycle` | Given owner JWT and envelope bounds, when issuing/lifecycle actioning, then invariants and lineage are preserved atomically. | Over-scoped child or invalid transition -> `403/409/422`. | Security + contract lifecycle tests |
| Moderation actions | `POST /console/api/posts/{postId}/moderation`, `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | Given owner/admin authority, when moderation action submitted, then target state transition and audit event are written together. | Invalid transition -> `409/422`; unauthorized -> `403`. | Moderation integration tests |

## Required negative-path baseline per route
At minimum for each route family, tests must cover: unauthorized, forbidden (where applicable), validation failure, and internal error envelope behavior.

## Manual UAT checklist linkage
Manual QA must execute route-family scenarios in `VERIFICATION_STRATEGY.md` and log request IDs for all failing paths.

## Related SSOT docs
- `openapi/cre8.v1.yaml`
- `ERROR_CODE_CATALOG.md`
- `VERIFICATION_STRATEGY.md`
- `TRACEABILITY_MATRIX.md`
