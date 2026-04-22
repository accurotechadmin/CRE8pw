# Traceability Matrix (Docs-to-Code)

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `CANONICAL_TERMINOLOGY.md`

| Capability | Route(s) | Middleware/Policy | Service(s) | Tests | SSOT docs |
|---|---|---|---|---|---|
| Service banner + UI shell | `GET /`, `GET /ui/{route}` | request-id + security headers + static routing/fallback | `UiShellService` | smoke + UI parity tests | `ROUTE_INVENTORY_REFERENCE.md`, `UI_RUNTIME_CONTRACT.md` |
| Health + JWKS publishing | `GET /health`, `GET /.well-known/jwks.json` | public middleware stack | `HealthService`,`JwksService` | health smoke + contract tests | `HEALTH_ENDPOINT_CONTRACT.md`, `DEPENDENCY_BASELINE.md` |
| Owner signup/login | `POST /console/owners`, `POST /api/auth/login` | validation + json + owner auth | `AuthService` | contract auth tests | `API_CONTRACT_GUIDE.md`, `SECURITY_CONTROLS_SPEC.md` |
| Key login | `POST /api/auth/key-login` | validation + json + key auth + device policy | `KeyLifecycleService` | contract/security tests | `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `SECURITY_CONTROLS_SPEC.md` |
| Token refresh | `POST /api/auth/refresh` | validation + json + refresh replay guard | `AuthService`/`KeyLifecycleService` | auth contract tests | `API_CONTRACT_GUIDE.md`, `SECURITY_CONTROLS_SPEC.md` |
| Feed read | `GET /api/feed` | key jwt + device + rate limit | `FeedService` | gateway contract tests | `UI_RUNTIME_CONTRACT.md`, `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` |
| Post create/edit/flag | `POST /api/posts`, `GET/PATCH /api/posts/{postId}`, `POST /api/posts/{postId}/flags` | key jwt + permission + use-key guard | `PostsService` | gateway contract tests | `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `DATA_MODEL_REFERENCE.md` |
| Comment list/create | `GET/POST /api/posts/{postId}/comments` | key jwt + post/comment policy | `CommentsService` | gateway contract tests | `UI_RUNTIME_CONTRACT.md`, `ERROR_CODE_CATALOG.md` |
| Console post ops | `GET/POST /console/api/posts` | owner jwt + csrf where applicable | `PostsService`,`ModerationService` | console contract tests | `RELEASE_CHECKLIST.md`, `SECURITY_CONTROLS_SPEC.md` |
| Keychain create/list | `GET/POST /console/api/keychains` | owner jwt + validation | `KeychainService` | keychain contract tests | `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `ROUTE_INVENTORY_REFERENCE.md`, `DATA_MODEL_SPEC.md` |
| Keychain membership mutate | `GET /console/api/keychains/{keychainId}/members`, `POST /console/api/keychains/{keychainId}/members`, `DELETE /console/api/keychains/{keychainId}/members/{memberKeyId}` | owner jwt + invariants (`no nesting`, size cap, class checks) | `KeychainService` | keychain security + contract tests | `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `DATA_MODEL_REFERENCE.md`, `Endpoint_Examples_All_Routes.md` |
| Keychain effective resolve | `GET /console/api/keychains/{keychainId}/resolve` | owner jwt + lineage projection policy | `KeychainService` | keychain contract tests | `ROUTE_INVENTORY_REFERENCE.md`, `DATA_MODEL_SPEC.md` |
| Invite create | `POST /console/api/invites` | owner jwt + validation | `KeyLifecycleService` | console contract tests | `RELEASE_CHECKLIST.md`, `SECURITY_CONTROLS_SPEC.md` |
| Key issue/lifecycle | `POST /console/api/keys`, `POST /console/api/keys/{keyId}/lifecycle` | owner jwt + validation + lineage bounds | `KeyLifecycleService` | security/contract tests | `AUTHORIZATION_AND_DELEGATION_SPEC.md`, `DATA_MODEL_SPEC.md` |
| Moderation actions | `POST /console/api/posts/{postId}/moderation`, `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | owner jwt + moderation transition policy | `ModerationService` | moderation integration tests | `ACCEPTANCE_CRITERIA_MATRIX.md`, `RELEASE_CHECKLIST.md` |

Acceptance criteria for all listed capabilities are defined in `ACCEPTANCE_CRITERIA_MATRIX.md`; authorization edge decisions are defined in `AUTHORIZATION_DECISION_TABLES.md`.
Startup and environment traceability requirements are defined in `CONFIGURATION_ENVIRONMENT_CONTRACT.md` and `BOOT_AND_STARTUP_FAILURE_CONTRACT.md`.
