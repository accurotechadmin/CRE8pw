# Traceability Matrix (Docs-to-Code)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

| Capability | Route(s) | Middleware/Policy | Service(s) | Tests | SSOT docs |
|---|---|---|---|---|---|
| Service banner + UI shell | `GET /`, `GET /ui/{route}` | request-id + security headers + static routing/fallback | `UiShellService` | smoke + UI parity tests | `Route_Inventory_Reference.md`, `UI_Runtime_Contract.md` |
| Health + JWKS publishing | `GET /health`, `GET /.well-known/jwks.json` | public middleware stack | `HealthService`,`JwksService` | health smoke + contract tests | `Health_Endpoint_Contract.md`, `Dependency_Reference.md` |
| Owner signup/login | `POST /console/owners`, `POST /api/auth/login` | validation + json + owner auth | `AuthService` | contract auth tests | `API_Contract_Guide.md`, `Security_Reference.md` |
| Key login | `POST /api/auth/key-login` | validation + json + key auth + device policy | `KeyLifecycleService` | contract/security tests | `Authorization_and_Delegation_Spec.md`, `Security_Reference.md` |
| Token refresh | `POST /api/auth/refresh` | validation + json + refresh replay guard | `AuthService`/`KeyLifecycleService` | auth contract tests | `API_Contract_Guide.md`, `Security_Controls_Spec.md` |
| Feed read | `GET /api/feed` | key jwt + device + rate limit | `FeedService` | gateway contract tests | `UI_Parity_Contract.md`, `Request_Pipeline_Reference.md` |
| Post create/edit/flag | `POST /api/posts`, `GET/PATCH /api/posts/{postId}`, `POST /api/posts/{postId}/flags` | key jwt + permission + use-key guard | `PostsService` | gateway contract tests | `Authorization_and_Delegation_Spec.md`, `Data_Model_Reference.md` |
| Comment list/create | `GET/POST /api/posts/{postId}/comments` | key jwt + post/comment policy | `CommentsService` | gateway contract tests | `UI_Parity_Contract.md`, `Error_Code_Catalog.md` |
| Console post ops | `GET/POST /console/api/posts` | owner jwt + csrf where applicable | `PostsService`,`ModerationService` | console contract tests | `Operations_Reference.md`, `Security_Reference.md` |
| Keychain create/list | `GET/POST /console/api/keychains` | owner jwt + validation | `KeychainService` | keychain contract tests | `Authorization_and_Delegation_Spec.md`, `Route_Inventory_Reference.md`, `Data_Model_Spec.md` |
| Keychain membership mutate | `GET/POST/DELETE /console/api/keychains/{keychainId}/members*` | owner jwt + invariants (`no nesting`, size cap, class checks) | `KeychainService` | keychain security + contract tests | `Authorization_and_Delegation_Spec.md`, `Data_Model_Reference.md`, `Endpoint_Examples_All_Routes.md` |
| Keychain effective resolve | `GET /console/api/keychains/{keychainId}/resolve` | owner jwt + lineage projection policy | `KeychainService` | keychain contract tests | `Route_Inventory_Reference.md`, `Data_Model_Spec.md` |
| Invite create | `POST /console/api/invites` | owner jwt + validation | `KeyLifecycleService` | console contract tests | `Operations_Runbook_Production.md`, `Security_Controls_Spec.md` |
| Key issue/lifecycle | `POST /console/api/keys`, `POST /console/api/keys/{keyId}/lifecycle` | owner jwt + validation + lineage bounds | `KeyLifecycleService` | security/contract tests | `Authorization_and_Delegation_Spec.md`, `Data_Model_Spec.md` |
| Moderation actions | `POST /console/api/posts/{postId}/moderation`, `POST /console/api/posts/{postId}/comments/{commentId}/moderation` | owner jwt + moderation transition policy | `ModerationService` | moderation integration tests | `Acceptance_Criteria_Matrix.md`, `Operations_Reference.md` |

Acceptance criteria for all listed capabilities are defined in `Acceptance_Criteria_Matrix.md`; authorization edge decisions are defined in `Authorization_Decision_Tables.md`.
Startup and environment traceability requirements are defined in `Configuration_Environment_Contract.md` and `Boot_and_Startup_Failure_Contract.md`.
