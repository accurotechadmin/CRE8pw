# CRE8 M2 Detailed Daily Slices (Day 22–45)

_Status: draft implementation planning artifact_
_Last updated (UTC): 2026-04-12_

## Scope
This document expands Milestone M2 (**data/auth/policy core + route/auth guard foundations**) into explicit daily slices and handoff expectations for Days 22–45.

## M2 outcome target
By end of Day 45, CRE8 has:
1. production-aligned schema baseline and deterministic migration/seed workflows,
2. owner/key auth foundations with JWT and refresh-family protections,
3. authorization/delegation/keychain decision engines conforming to SSOT tables,
4. public/auth route family implemented to envelope/error contracts,
5. surface-specific auth guards ready for full domain route build-out in M3.

## Daily detailed slices and handoff contract

| Day | Governance slices | Data/backend slices | Security/policy slices | QA/ops slices | End-of-day done criteria | Handoff artifacts |
|---:|---|---|---|---|---|---|
| 22 | Confirm migration naming/versioning conventions and owner signoff flow. | Implement migration runner and baseline migration framework. | Enforce migration safety prechecks (no destructive unguarded operations). | Add migration smoke scaffold command behavior. | Migrations can execute deterministically in clean environment. | Migration framework report + smoke baseline output. |
| 23 | Map schema backlog to SSOT data model entities and dependencies. | Implement `principals`, `principal_emails`, `credentials` tables with indexes/FKs. | Enforce principal type/key-class domain constraints at schema layer. | Add schema integrity tests for constraints/indexes. | Principal/auth base tables are migration-complete and validated. | Schema diff + integrity test output. |
| 24 | Update traceability rows for token lifecycle capability. | Implement `token_families` table and transactional repository primitives. | Enforce single-family active token progression semantics. | Add tests for token family creation/rotation/revocation transitions. | Token family persistence semantics are deterministic. | Token family transition test report. |
| 25 | Align delegation schema checklist with decision-table requirements. | Implement `delegation_envelopes` table, indexes, and model constraints. | Encode depth<=3 and lifecycle status validity checks. | Add schema/service tests for invalid depth/status handling. | Delegation persistence supports policy invariants. | Delegation schema validation report. |
| 26 | Approve keychain schema acceptance checklist for v1 production-active behavior. | Implement `keychain_memberships` and `keychain_effective_snapshots` tables. | Enforce uniqueness and no-invalid-member references via constraints/guards. | Add keychain schema tests (unique active membership, status transitions). | Keychain schema supports atomic membership and snapshot workflows. | Keychain schema conformance output. |
| 27 | Confirm content-domain prerequisite schema ordering for M3. | Implement `posts`, `post_revisions`, `post_flags`, `comments` tables. | Enforce state enum/domain constraints for posts/comments. | Add migration verification tests for content tables. | Content schema is ready for M3 route implementation. | Content schema migration report. |
| 28 | Confirm moderation/invite schema owner responsibilities. | Implement `moderation_actions` and `invite_receipts` tables. | Enforce moderation/invite integrity constraints and required timestamps. | Add schema tests for FK and lifecycle column behavior. | Moderation/invite schema surfaces are migration-complete. | Moderation/invite schema validation artifact. |
| 29 | Approve fixture taxonomy and deterministic seed governance policy. | Implement seed orchestration and baseline fixture packs for principals/keys/posts. | Ensure seeds never bypass lifecycle/permission invariants. | Add seed idempotency and fixture consistency checks. | Seed pipeline is deterministic and replay-safe. | Seed execution and idempotency report. |
| 30 | Validate key material governance checklist against configuration contract. | Implement JWT key loader service (inline/path modes) integrated with runtime config. | Enforce strict key format and path safety validations in stage/prod. | Add key-loading tests across env profiles and invalid inputs. | Key loader is production-safe and fail-closed. | Key loading matrix + test evidence. |
| 31 | Confirm token claim vocabulary and reviewer checklist. | Implement JWT signer/verifier with issuer/audience/type/timing claims. | Enforce claim rejection rules for invalid audience/type/expiry. | Add JWT claim allow/deny matrix tests. | JWT service validates canonical claims deterministically. | Claim matrix report + signed token fixtures. |
| 32 | Define owner auth acceptance slices and evidence requirements. | Implement owner credential verification and auth service entrypoint. | Ensure password/auth errors map to canonical 401/422 semantics. | Add owner auth unit tests and contract-shape tests. | Owner auth core flow is service-complete. | Owner auth test report. |
| 33 | Define key auth acceptance slices and evidence requirements. | Implement key credential verification and auth service entrypoint. | Enforce key lifecycle checks in key auth path. | Add key auth tests for active/suspended/revoked/cancelled states. | Key auth core flow is service-complete. | Key auth lifecycle test evidence. |
| 34 | Approve refresh replay protection acceptance checklist. | Implement refresh token rotation, family update, and replay invalidation logic. | Deny replayed/invalid refresh with canonical auth_invalid behavior. | Add refresh replay abuse-case tests (first pass, second deny). | Refresh flow is replay-safe and transactionally consistent. | Refresh replay verification report. |
| 35 | Confirm lifecycle authority baseline for auth-layer gate behavior. | Implement lifecycle status resolver shared by auth guards/services. | Block inactive principals before policy evaluation. | Add lifecycle resolver tests for every status path. | Lifecycle checks are centralized and reusable. | Lifecycle resolver test summary. |
| 36 | Approve public-surface route acceptance test matrix. | Implement public routes: `/`, `/health` (skeleton), `/.well-known/jwks.json`, `/ui/{route}` fallback baseline. | Ensure public routes retain envelope/security behavior without auth guards. | Add contract tests for public route responses and envelope metadata. | Public surface contract baseline is operational. | Public route contract bundle. |
| 37 | Approve auth-route acceptance test matrix. | Implement `/console/owners`, `/api/auth/login`, `/api/auth/key-login`, `/api/auth/refresh`. | Ensure validation/auth failures map to canonical detail codes. | Add auth route contract tests including negative paths. | Auth route family is contract-complete for baseline behavior. | Auth route contract report. |
| 38 | Freeze permission vocabulary and scope schema guidance. | Implement permission allow-list evaluator (`posts:read`, etc.). | Reject unknown permission strings deterministically. | Add policy evaluator tests for allow/deny/unknown permissions. | Permission evaluator aligns with SSOT allow-list. | Permission evaluator evidence. |
| 39 | Validate delegation issuance decision-table implementation checklist. | Implement delegation issuance validator (subset perms/scope, depth, expiry). | Enforce deterministic deny outcomes per decision tables. | Add conformance tests for over-scope/over-depth/missing-expiry/no-keys:issue. | Delegation issuance logic passes decision-table conformance. | Delegation conformance report. |
| 40 | Validate key class mint authority decision-table checklist. | Implement key-class mint authority evaluator for owner/primary/secondary/use/keychain actors. | Deny disallowed mint paths including keychain-issued credentials. | Add mint authority matrix tests. | Mint authority behavior is deterministic and table-compliant. | Mint authority matrix evidence. |
| 41 | Validate keychain admission/resolution policy checklist. | Implement keychain membership admission evaluator and snapshot recompute orchestration contract. | Enforce no nested keychains and size cap<=50. | Add admission tests (class constraints, size limits, inactive member exclusion). | Keychain admission policy engine is conformance-ready. | Keychain admission test report. |
| 42 | Confirm scope merge semantics documentation and reviewer training note. | Implement effective scope/permission resolution engine (union + restrictive intersections + envelope constrain). | Exclude inactive/revoked members from effective computation. | Add deterministic resolution tests with mixed member states/scopes. | Effective resolution engine matches SSOT semantics. | Effective resolution proof pack. |
| 43 | Approve lifecycle-action authority matrix for implementation. | Implement lifecycle action authority evaluator and auditable policy decision emitter. | Enforce actor/action constraints (owner vs key vs admin scopes). | Add authority decision tests + audit event assertion checks. | Lifecycle authority logic is decision-table compliant. | Lifecycle authority conformance report. |
| 44 | Confirm surface guard policy package and reviewer matrix. | Implement console owner guard and gateway key+device guard integration middleware. | Enforce token type/audience/surface binding before route handlers. | Add integration tests by surface for 401/403/422/429 behavior. | Surface auth guards are integrated and deterministic. | Guard integration test suite output. |
| 45 | Conduct milestone closeout with owners (backend/security/platform/QA). | Stabilize M2 baseline tag and prepare M3 entry branch. | Confirm no unresolved policy ambiguities remain in M2 scope. | Execute full M2 verification suite and compile evidence package. | M2 accepted with signed evidence and explicit M3 entry criteria. | M2 closeout dossier (evidence, traceability diff, signoffs). |

## M2 mandatory daily evidence checklist
Every day (22–45) must attach:
1. migration/service/policy test output for the day’s slice,
2. traceability update (or explicit no-change statement),
3. risk/gap update note (or explicit no-change statement),
4. reviewer acknowledgment.

## M2 to M3 entry criteria
M3 cannot start unless all are true:
- migration + seed workflows are deterministic and smoke-verified,
- JWT/auth/refresh/lifecycle checks are green,
- delegation/mint/keychain/lifecycle authority decision-table conformance tests are green,
- public/auth routes and surface auth guards pass contract/integration tests,
- M2 evidence package is complete and approved.
