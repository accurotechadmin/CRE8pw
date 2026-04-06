# Traceability Matrix (Docs-to-Code)

_Last updated (UTC): 2026-04-06_

| Capability | Route(s) | Middleware/Policy | Service(s) | Tests | SSOT docs |
|---|---|---|---|---|---|
| Owner login | `POST /api/auth/login` | validation + json + owner auth | `AuthService` | contract auth tests | API_Contract_Guide, Security_Reference |
| Key login | `POST /api/auth/key-login` | validation + json + key auth | `KeyLifecycleService` | contract/security tests | Authorization_and_Delegation_Spec |
| Token refresh | `POST /api/auth/refresh` | validation + json | `AuthService`/`KeyLifecycleService` | auth contract tests | API_Contract_Guide |
| Feed read | `GET /api/feed` | key jwt + device + rate | `FeedService` | gateway contract tests | UI_Parity_Contract |
| Post create/edit/flag | `/api/posts*` | key jwt + permission + use-key guard | `PostsService` | gateway contract tests | Authorization_and_Delegation_Spec |
| Comment list/create | `/api/posts/{id}/comments*` | key jwt + post/comment policy | `CommentsService` | gateway contract tests | UI_Parity_Contract |
| Console post ops | `/console/api/posts*` | owner jwt + csrf where applicable | `PostsService`,`ModerationService` | console contract tests | Operations_Reference |
| Key issue/lifecycle | `/console/api/keys*` | owner jwt + validation | `KeyLifecycleService` | security/contract tests | Authorization_and_Delegation_Spec |
| Invite create | `POST /console/api/invites` | owner jwt + validation | `KeyLifecycleService` | console contract tests | Operations_Runbook_Production |
| Health/JWKS | `/health`, `/.well-known/jwks.json` | public middleware stack | `HealthService`,`JwksService` | health smoke tests | Operations_Reference |
