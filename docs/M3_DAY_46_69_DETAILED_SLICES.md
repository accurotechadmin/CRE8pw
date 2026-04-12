# CRE8 M3 Detailed Daily Slices (Day 46–69)

_Status: draft implementation planning artifact_
_Last updated (UTC): 2026-04-12_

## Scope
This document expands Milestone M3 (**gateway/console domain completion + cross-cutting security + initial frontend parity**) into explicit daily slices and handoff expectations for Days 46–69.

## M3 outcome target
By end of Day 69, CRE8 has:
1. gateway and console route families implemented to SSOT contract behavior,
2. keychain, moderation, lifecycle, and invite flows operational with auditable writes,
3. cross-cutting security controls validated against abuse-case expectations,
4. frontend runtime foundation and initial surface parity in place,
5. readiness to enter M4 hardening/operations/release-gating work.

## Daily detailed slices and handoff contract

| Day | Governance slices | Backend/domain slices | Security/policy slices | Frontend/QA/ops slices | End-of-day done criteria | Handoff artifacts |
|---:|---|---|---|---|---|---|
| 46 | Approve gateway feed acceptance package and route-specific reviewers. | Implement `GET /api/feed` handler/service with scoped query contract and pagination baseline. | Enforce key auth + device guard prerequisites before feed execution. | Add gateway feed contract tests (200/401/403/429) and ordering checks. | Feed route returns contract-compliant scoped data and stable envelope/error behavior. | Feed contract report + traceability row update. |
| 47 | Lock post-create acceptance checklist and policy references. | Implement `POST /api/posts` create flow with transactional write and metadata stamps. | Enforce `posts:create` and use-key mutation restrictions per policy. | Add tests for allow/deny/validation and emitted request_id behavior. | Post create behavior is deterministic and policy-compliant. | Post create test report + audit event samples. |
| 48 | Confirm post-read/edit route parity requirements. | Implement `GET /api/posts/{postId}` visibility + `PATCH /api/posts/{postId}` edit/revision flow. | Enforce scope visibility checks and edit authorization constraints. | Add tests for 200/403/404/422 plus revision history write verification. | Read/edit routes are contract-complete with revision integrity. | Post read/edit conformance report. |
| 49 | Freeze post revision/audit ownership and signoff responsibilities. | Harden post revision transaction boundaries and rollback behavior on partial failures. | Ensure failed edits never partially persist revisions/content state. | Add transaction integrity tests with induced failure paths. | Revision writes are atomic and failure-safe. | Transaction integrity evidence pack. |
| 50 | Confirm post-flag moderation intake policy checklist. | Implement `POST /api/posts/{postId}/flags` with reason validation and persistence. | Enforce visibility/policy constraints on flag submissions. | Add tests for valid flag, invalid reason, and not-found/policy-deny outcomes. | Flag route is operational with correct validation and audit records. | Flag route contract + audit evidence. |
| 51 | Approve comment listing behavior and state visibility matrix. | Implement `GET /api/posts/{postId}/comments` with ordering and state filters. | Enforce comment visibility and post-state constraints. | Add tests for visible/hidden/locked/deleted state handling. | Comment listing behavior aligns with policy/state rules. | Comment list conformance output. |
| 52 | Approve comment creation acceptance package. | Implement `POST /api/posts/{postId}/comments` with transactional create semantics. | Enforce `comments:create` and comments-enabled policy checks. | Add tests for allow/forbidden/validation and correlation metadata. | Comment create path is deterministic and policy-aligned. | Comment create test report. |
| 53 | Confirm console-post governance expectations and reviewer set. | Implement `GET/POST /console/api/posts` console domain handlers. | Enforce owner JWT and CSRF for applicable write flows. | Add console post contract tests including CSRF failure paths. | Console post routes pass baseline contract/security checks. | Console posts evidence bundle. |
| 54 | Lock keychain inventory/create acceptance criteria. | Implement `GET/POST /console/api/keychains` handlers and service orchestration. | Enforce keychain principal semantics and validation rules. | Add tests for create/list success + validation/auth failures. | Keychain list/create operations are contract-complete. | Keychain list/create report. |
| 55 | Confirm keychain mutation audit requirements. | Implement member list/add/remove routes for keychains with atomic snapshot recompute triggers. | Enforce no nesting, class checks, size cap, and active-member constraints. | Add mutation tests for duplicate member, oversize, invalid class, and remove semantics. | Keychain membership mutation paths are policy-conformant and atomic. | Membership mutation + snapshot evidence pack. |
| 56 | Approve keychain resolve output contract and lineage detail expectations. | Implement `GET /console/api/keychains/{keychainId}/resolve` effective permission/scope projection. | Exclude inactive/revoked members and preserve lineage references. | Add resolve tests for valid, missing, and unauthorized scenarios. | Keychain resolve behavior is deterministic and contract-compliant. | Keychain resolve test output + lineage samples. |
| 57 | Confirm invite issuance governance criteria and anti-abuse checks. | Implement `POST /console/api/invites` creation path and receipt persistence. | Enforce invite target/expiry validation and owner-only authority. | Add invite contract tests (201/401/403/422). | Invite route is production-ready at contract level. | Invite issuance report + persisted receipt samples. |
| 58 | Confirm key issuance acceptance matrix and envelope bounds references. | Implement `POST /console/api/keys` delegated key issuance flow. | Enforce subset/depth/expiry and mint authority constraints. | Add key issuance conformance tests from decision tables. | Key issuance route conforms to delegation/mint policies. | Key issuance conformance artifact. |
| 59 | Confirm lifecycle transition governance checklist and escalation notes. | Implement `POST /console/api/keys/{keyId}/lifecycle` transition handler/service. | Enforce legal transition paths and authority constraints. | Add lifecycle tests for success/conflict/forbidden/validation outcomes. | Lifecycle route is deterministic and auditable. | Lifecycle route evidence report. |
| 60 | Approve moderation transition matrix and audit retention expectations. | Implement moderation routes for posts/comments with state transition writes. | Enforce moderation authority scopes and transition validity checks. | Add moderation integration tests + audit write assertions. | Moderation flows are contract-complete with audit integrity. | Moderation integration evidence pack. |
| 61 | Confirm CSRF policy coverage matrix across console writes. | Harden CSRF middleware integration for all applicable console write routes. | Ensure malformed/missing/mismatch token cases map to canonical detail codes. | Add CSRF abuse tests across route families. | CSRF coverage is complete and deterministic. | CSRF coverage report. |
| 62 | Confirm device guard coverage matrix across gateway routes. | Harden `X-Device-Id` guard enforcement across gateway route family. | Enforce required header format and missing-header deny behavior. | Add device bypass tests for every gateway endpoint category. | Device policy enforcement is consistent across gateway surfaces. | Device guard conformance report. |
| 63 | Approve sensitive-field redaction policy and reviewer checklist. | Integrate centralized log/error redaction utility in domain handlers and middleware. | Ensure no token/secret/private-key leakage in logs/envelopes. | Add redaction verification tests with intentional sensitive inputs. | Redaction guarantees hold across all tested failure/success paths. | Redaction test artifact + sanitized log samples. |
| 64 | Confirm rate-limit tuning assumptions with platform owner. | Tune auth/gateway limiter policies and ensure deterministic retry metadata behavior. | Validate limiter interactions with auth failures and abuse traffic patterns. | Add limiter load-abuse simulations and threshold validation. | Rate limiting behavior is policy-complete for M3 scope. | Limiter simulation report. |
| 65 | Run threat-to-control mapping review for M3 implemented surfaces. | Close remaining threat-model control gaps discovered during domain completion. | Validate abuse-case coverage for replay, escalation, CSRF, rate abuse, and leakage. | Update security regression suite and execute full run. | Security regression baseline is green for M3 scope. | Threat-control closure report + suite results. |
| 66 | Confirm frontend runtime baseline acceptance criteria. | Implement SPA runtime shell, route-state primitives, and session context model. | Enforce separation between owner and key session contexts. | Add frontend runtime tests for state transitions and session persistence keys. | UI runtime foundation exists per contract expectations. | Frontend runtime baseline report. |
| 67 | Approve API client/error UX baseline acceptance slices. | Implement envelope-aware frontend API client and normalized error mapping model. | Ensure request_id extraction from envelope/header is always preserved. | Add frontend client tests for success/error parsing and diagnostics payloads. | UI API client is contract-aligned and diagnostics-ready. | Frontend API client conformance evidence. |
| 68 | Confirm initial frontend surface parity target for auth/bootstrap paths. | Implement initial frontend flows for owner login, key login, refresh handling, and baseline diagnostics panel. | Enforce route guard bindings to correct session context by surface. | Add end-to-end parity checks for auth/bootstrap states and error mappings. | Initial frontend parity for auth/bootstrap is complete. | Auth/bootstrap parity checklist and test output. |
| 69 | Conduct M3 closeout review with backend/security/frontend/platform/QA owners. | Stabilize M3 baseline and prepare M4 hardening branch. | Confirm no unresolved high-severity security/policy ambiguities in M3 scope. | Execute full M3 verification suite and compile milestone evidence package. | M3 accepted with signed evidence and explicit M4 entry criteria. | M3 closeout dossier (evidence, traceability diff, signoffs). |

## M3 mandatory daily evidence checklist
Every day (46–69) must attach:
1. route/service/security/frontend test output for the day’s slice,
2. traceability update (or explicit no-change statement),
3. risk/gap update note (or explicit no-change statement),
4. reviewer acknowledgment.

## M3 to M4 entry criteria
M4 cannot start unless all are true:
- gateway and console route families pass contract and negative-path tests,
- keychain/lifecycle/moderation/invite flows are auditable and policy-conformant,
- cross-cutting CSRF/device/redaction/rate-limit controls are validated,
- initial frontend parity (runtime + API client + auth/bootstrap flows) is complete,
- M3 evidence package is complete and approved.
