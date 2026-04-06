# Traceability Matrix (Docs-to-Code)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

| Capability | Route(s) | Middleware/Policy | Service(s) | Tests | SSOT docs |
|---|---|---|---|---|---|
| Owner login | `POST /api/auth/login` | validation + json + owner auth | `AuthService` | contract auth tests | `API_Contract_Guide.md`, `Security_Reference.md` |
| Key login | `POST /api/auth/key-login` | validation + json + key auth + device policy | `KeyLifecycleService` | contract/security tests | `Authorization_and_Delegation_Spec.md`, `Security_Reference.md` |
| Token refresh | `POST /api/auth/refresh` | validation + json | `AuthService`/`KeyLifecycleService` | auth contract tests | `API_Contract_Guide.md`, `Security_Controls_Spec.md` |
| Feed read | `GET /api/feed` | key jwt + device + rate limit | `FeedService` | gateway contract tests | `UI_Parity_Contract.md`, `Request_Pipeline_Reference.md` |
| Post create/edit/flag | `/api/posts*` | key jwt + permission + use-key guard | `PostsService` | gateway contract tests | `Authorization_and_Delegation_Spec.md`, `Data_Model_Reference.md` |
| Comment list/create | `/api/posts/{id}/comments*` | key jwt + post/comment policy | `CommentsService` | gateway contract tests | `UI_Parity_Contract.md`, `Error_Code_Catalog.md` |
| Console post ops | `/console/api/posts*` | owner jwt + csrf where applicable | `PostsService`,`ModerationService` | console contract tests | `Operations_Reference.md`, `Security_Reference.md` |
| Key issue/lifecycle | `/console/api/keys*` | owner jwt + validation | `KeyLifecycleService` | security/contract tests | `Authorization_and_Delegation_Spec.md`, `Data_Model_Spec.md` |
| Keychain create/list | `/console/api/keychains` | owner jwt + validation | `KeychainService` | keychain contract tests | `Authorization_and_Delegation_Spec.md`, `Route_Inventory_Reference.md`, `Data_Model_Spec.md` |
| Keychain membership mutate | `/console/api/keychains/{id}/members*` | owner jwt + invariants (`no nesting`, size cap, class checks) | `KeychainService` | keychain security + contract tests | `Authorization_and_Delegation_Spec.md`, `Data_Model_Reference.md`, `Endpoint_Examples_All_Routes.md` |
| Keychain effective resolve | `GET /console/api/keychains/{id}/resolve` | owner jwt + lineage projection policy | `KeychainService` | keychain contract tests | `Route_Inventory_Reference.md`, `Data_Model_Spec.md` |
| Invite create | `POST /console/api/invites` | owner jwt + validation | `KeyLifecycleService` | console contract tests | `Operations_Runbook_Production.md`, `Security_Controls_Spec.md` |
| Health/JWKS | `/health`, `/.well-known/jwks.json` | public middleware stack | `HealthService`,`JwksService` | health smoke tests | `Operations_Reference.md`, `Dependency_Reference.md` |


Acceptance criteria for all listed capabilities are defined in `Acceptance_Criteria_Matrix.md`; authorization edge decisions are defined in `Authorization_Decision_Tables.md`.
Startup and environment traceability requirements are defined in `Configuration_Environment_Contract.md` and `Boot_and_Startup_Failure_Contract.md`.
