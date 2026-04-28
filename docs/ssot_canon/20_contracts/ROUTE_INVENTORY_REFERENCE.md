# Route Inventory Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-28_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Canonical, versioned inventory of CRE8 v1 routes with surface, auth context, policy expectations, and parity references.

## Inventory governance
- This file is the canonical human-readable route index.
- `docs/ssot_canon/openapi/cre8.v1.yaml` remains canonical machine contract.
- Route additions/removals must update this file, OpenAPI, endpoint examples, and UI parity artifacts in the same PR.

## Route inventory (v1)

| Route | Method | Surface | Auth context | Core policy notes | UI parity reference |
|---|---|---|---|---|---|
| `/` | GET | public | none | envelope response | `/status` |
| `/health` | GET | public | none | dependency health probes | `/health` |
| `/.well-known/jwks.json` | GET | public | none | current JWKS set | `/jwks` |
| `/ui/{route}` | GET | public | none | static SPA + fallback | `/ui/*` |
| `/console/owners` | POST | public/bootstrap | none | owner bootstrap registration (invite code required by default; open signup configurable) | `/signup-owner` |
| `/api/auth/login` | POST | public/auth | none | owner login token issuance | `/login` |
| `/api/auth/key-login` | POST | public/auth | none | key login token issuance | `/key-login` |
| `/api/auth/refresh` | POST | public/auth | refresh token | refresh family rotation/replay checks | `/session/refresh` |
| `/api/feed` | GET | gateway | key JWT + device id | scope-filtered feed served by canonical `GetFeed` query handler backed by feed-ordering projection model | `/feed` |
| `/api/posts` | POST | gateway | key JWT + device id | permission + use-key mutation guard | `/posts/new` |
| `/api/posts/{postId}` | GET | gateway | key JWT + device id | scope/visibility checks | `/posts/{postId}` |
| `/api/posts/{postId}` | PATCH | gateway | key JWT + device id | author/edit permission checks | `/posts/{postId}/edit` |
| `/api/posts/{postId}/flags` | POST | gateway | key JWT + device id | flag reason validation | `/posts/{postId}/flag` |
| `/api/posts/{postId}/comments` | GET | gateway | key JWT + device id | visibility + comment state policy | `/posts/{postId}/comments` |
| `/api/posts/{postId}/comments` | POST | gateway | key JWT + device id | comments permission + enabled toggle | `/posts/{postId}/comments/new` |
| `/console/api/posts` | GET | console | owner JWT | governance listing served by canonical `ListConsolePosts` query handler | `/console/posts` |
| `/console/api/posts` | POST | console | owner JWT (+ CSRF where applicable) | console-authored post actions | `/console/posts/new` |
| `/console/api/keychains` | GET | console | owner JWT | keychain inventory and membership counts served by canonical `ListKeychains` query handler | `/console/keychains` |
| `/console/api/keychains` | POST | console | owner JWT | create keychain key principal | `/console/keychains/new` |
| `/console/api/keychains/{keychainId}/members` | GET | console | owner JWT | list active/removed memberships served by canonical `GetKeychainMembers` query handler | `/console/keychains/{id}` |
| `/console/api/keychains/{keychainId}/members` | POST | console | owner JWT | add member key, enforce class/nesting/size invariants | `/console/keychains/{id}/add-member` |
| `/console/api/keychains/{keychainId}/members/{memberKeyId}` | DELETE | console | owner JWT | remove member; recompute effective snapshot | `/console/keychains/{id}` |
| `/console/api/keychains/{keychainId}/resolve` | GET | console | owner JWT | preview effective permissions/scope + lineage summary served by canonical `ResolveKeychainEffective` query handler backed by keychain-effective projection model | `/console/keychains/{id}/resolve` |
| `/console/api/invites` | POST | console | owner JWT | invite issuance constraints | `/console/invites/new` |
| `/console/api/keys` | POST | console | owner JWT | issue delegated key with envelope bounds | `/console/keys/new` |
| `/console/api/keys/{keyId}/lifecycle` | POST | console | owner JWT | suspend/cancel/revoke + cascade policy | `/console/keys/{keyId}/lifecycle` |
| `/console/api/posts/{postId}/moderation` | POST | console | owner JWT | moderation action transitions | `/console/moderation/posts/{postId}` |
| `/console/api/posts/{postId}/comments/{commentId}/moderation` | POST | console | owner JWT | comment moderation transitions | `/console/moderation/posts/{postId}/comments/{commentId}` |

## Notes
- Owner bootstrap is invite-gated by default. Open owner signup is a configuration-controlled mode and must remain explicitly documented in release evidence when enabled.

## Human-access note
- Console routes provide governance UX for non-technical operators while remaining API-contract equivalent to machine clients.

- Surface behavior and middleware sequencing are defined in `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`.
- Error behavior is canonical in `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`.
- Route examples are canonical in `docs/ssot_canon/20_contracts/Endpoint_Examples_All_Routes.md`.
