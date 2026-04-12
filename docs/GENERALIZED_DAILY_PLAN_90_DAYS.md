# CRE8 Generalized Daily Delivery Plan (Day 1–90)

_Status: draft proposal aligned to current SSOT canon_
_Last updated (UTC): 2026-04-12_

## Planning assumptions
- Current repository state is documentation-first; production code implementation has not started.
- `docs/ssot_canon/` is treated as authoritative SSOT.
- Delivery target is full backend + frontend operational integrity by Day 90.
- No emergency/fallback/legacy tracks are planned; build is straightforward, deterministic, and extension-friendly.

## Milestone spine
- **M1 Foundation and governance hardening:** Day 1–21
- **M2 Core runtime + auth + contract surfaces:** Day 22–45
- **M3 Domain services + UI parity + security hardening:** Day 46–69
- **M4 Operations integrity + release-readiness + handoff:** Day 70–90

## Daily generalized map

| Day | Primary layer | Generalized work slice | End-of-day handoff/proof |
|---:|---|---|---|
| 1 | Governance | Establish implementation workspace, module skeletons, and SSOT reference links by module. | Repo structure map + traceability seed updated. |
| 2 | Governance | Create implementation backlog mapped to SSOT sections (00→80). | SSOT-to-backlog matrix artifact. |
| 3 | Governance | Define coding standards and naming conventions aligned with canonical terminology. | Contributing/coding standards doc + reviewer checklist. |
| 4 | Governance | Set PR templates for change-impact map and evidence attachment. | PR template files + sample completed payload. |
| 5 | Governance | Wire SSOT automation scripts into CI skeleton (`docs:ssot:*`). | CI run showing lint/sync/report pass. |
| 6 | Governance | Define owner/reviewer routing automation for domain-labeled changes. | CODEOWNERS/review policy mapping proof. |
| 7 | Governance | Validate document metadata hygiene and reference consistency guardrails. | Metadata audit report committed. |
| 8 | Runtime foundation | Initialize Slim runtime bootstrap and DI container boundaries. | Booting app skeleton + container wiring test output. |
| 9 | Runtime foundation | Implement typed runtime config loader from env contract. | Config parse/validation tests (positive/negative). |
| 10 | Runtime foundation | Add startup assertion framework per boot contract. | Boot assertion report + fail-closed test proof. |
| 11 | Runtime foundation | Implement request-id generation and propagation utility. | Request-id propagation test and sample logs. |
| 12 | Runtime foundation | Implement canonical envelope responder abstractions. | Envelope unit tests against schema examples. |
| 13 | Runtime foundation | Implement centralized error mapping to canonical catalog. | Error mapping table tests (detail-code parity). |
| 14 | Runtime foundation | Register middleware pipeline in authoritative order. | Middleware-order test + startup evidence snapshot. |
| 15 | Runtime foundation | Add security headers/CSP middleware with path-aware policy behavior. | Header/CSP contract tests passing. |
| 16 | Runtime foundation | Add CORS/content-type normalization middleware behavior. | CORS/content-type negative-path tests. |
| 17 | Runtime foundation | Add validation middleware primitives and reusable validators. | Validation middleware tests + fixtures. |
| 18 | Runtime foundation | Add rate-limit middleware baseline with policy config wiring. | 429 behavior tests + retry metadata proof. |
| 19 | Runtime foundation | Build structured observability emitter contract. | Event-family smoke output + schema assertions. |
| 20 | Runtime foundation | Implement minimal health probe scaffold (`db`, limiter, key, http dep). | `/health` contract test baseline pass. |
| 21 | Milestone gate | M1 review: governance + runtime foundation conformity audit. | M1 evidence bundle and signoff. |
| 22 | Data foundation | Create migration system and baseline migration layout. | Migration runner + empty baseline migration proof. |
| 23 | Data foundation | Implement `principals`, `principal_emails`, `credentials` tables. | Migration + schema verification output. |
| 24 | Data foundation | Implement `token_families` and refresh family constraints. | Token family schema + integrity tests. |
| 25 | Data foundation | Implement `delegation_envelopes` schema/invariants. | Delegation schema tests (depth/status indexes). |
| 26 | Data foundation | Implement keychain tables (`memberships`, `effective_snapshots`). | Keychain schema + uniqueness/index tests. |
| 27 | Data foundation | Implement content tables (`posts`, `post_revisions`, `post_flags`, `comments`). | Content schema migration proof. |
| 28 | Data foundation | Implement `moderation_actions` and `invite_receipts`. | Migration evidence + FK constraint tests. |
| 29 | Data foundation | Seed strategy scaffolding with deterministic fixture packs. | Seed scripts + fixture integrity checks. |
| 30 | Auth foundation | Implement JWT key material loader and safety checks. | Key source/path safety tests across env profiles. |
| 31 | Auth foundation | Implement token signer/verifier claim validation (issuer/audience/type/timing). | JWT claim tests (allow/deny matrix). |
| 32 | Auth foundation | Implement owner credential auth service primitives. | Owner auth unit tests. |
| 33 | Auth foundation | Implement key credential auth service primitives. | Key auth unit tests. |
| 34 | Auth foundation | Implement refresh rotation/replay invalidation behavior. | Replay abuse-case tests passing. |
| 35 | Auth foundation | Implement lifecycle status checks in auth gate. | Suspended/revoked/cancelled deny tests. |
| 36 | Surface/auth | Implement public routes: `/`, `/health`, `/.well-known/jwks.json`, `/ui/{route}` placeholders. | Public route contract tests pass. |
| 37 | Surface/auth | Implement bootstrap/auth routes: owner signup/login/key-login/refresh. | Auth route contract + error-path tests. |
| 38 | AuthZ policy | Implement permission allow-list and scope evaluator engine. | Policy evaluator test suite. |
| 39 | AuthZ policy | Implement delegation issuance validator (subset/depth/expiry). | Decision-table conformance tests (issuance). |
| 40 | AuthZ policy | Implement key class mint authority rules. | Mint authority matrix tests. |
| 41 | AuthZ policy | Implement keychain membership admission rule engine. | Membership rule tests (no nesting/class checks). |
| 42 | AuthZ policy | Implement keychain effective resolution (union/intersection + envelope constrain). | Effective resolution deterministic tests. |
| 43 | AuthZ policy | Implement lifecycle authority evaluator and audit events. | Lifecycle decision tests + event assertions. |
| 44 | Surface/auth | Wire surface-specific auth guards (console owner, gateway key + device). | Guard integration tests by route family. |
| 45 | Milestone gate | M2 review: runtime+data+auth+policy core complete and traceable. | M2 evidence bundle and signoff. |
| 46 | Gateway domain | Implement `GET /api/feed` service/handler with scope filtering skeleton. | Feed contract + policy tests baseline. |
| 47 | Gateway domain | Implement `POST /api/posts` create flow with permission checks. | Post create tests (allow/deny/422). |
| 48 | Gateway domain | Implement `GET /api/posts/{postId}` visibility and state checks. | Post read tests (200/404/403 behavior). |
| 49 | Gateway domain | Implement `PATCH /api/posts/{postId}` revision write transaction. | Post edit + revision atomicity tests. |
| 50 | Gateway domain | Implement `POST /api/posts/{postId}/flags` flow and validation. | Flag route contract + audit proof. |
| 51 | Gateway domain | Implement `GET /api/posts/{postId}/comments` policy-aware list. | Comment list tests and ordering checks. |
| 52 | Gateway domain | Implement `POST /api/posts/{postId}/comments` create policy flow. | Comment create allow/deny tests. |
| 53 | Console domain | Implement `GET/POST /console/api/posts`. | Console post route tests + CSRF checks. |
| 54 | Console domain | Implement `GET/POST /console/api/keychains`. | Keychain list/create contract tests. |
| 55 | Console domain | Implement keychain member list/add/remove routes. | Membership mutation + snapshot recompute tests. |
| 56 | Console domain | Implement keychain resolve route with lineage projection. | Resolve contract tests + lineage assertions. |
| 57 | Console domain | Implement `POST /console/api/invites`. | Invite issuance tests (valid/invalid). |
| 58 | Console domain | Implement `POST /console/api/keys` issuance flow. | Key issuance conformance tests. |
| 59 | Console domain | Implement `POST /console/api/keys/{keyId}/lifecycle`. | Lifecycle transition tests (409/403/422). |
| 60 | Console domain | Implement moderation routes for posts/comments. | Moderation transaction + audit tests. |
| 61 | Cross-cutting security | Implement CSRF middleware on applicable console writes. | CSRF abuse tests pass. |
| 62 | Cross-cutting security | Implement device header guard strictness for gateway routes. | Device-header bypass tests pass. |
| 63 | Cross-cutting security | Implement log redaction controls for tokens/secrets. | Redaction verification tests pass. |
| 64 | Cross-cutting security | Harden rate limiting strategy for auth + gateway sensitivity. | Abuse/flood simulation report. |
| 65 | Cross-cutting security | Complete threat-model to control mapping checks in tests. | Threat-control traceability artifact updated. |
| 66 | Frontend foundation | Build UI runtime shell and session model per contract keys. | UI runtime state model test proof. |
| 67 | Frontend foundation | Implement envelope-aware API client and normalized error model. | Frontend contract tests + request_id rendering. |
| 68 | Frontend surfaces | Implement auth/bootstrap UI flows and diagnostics panel baseline. | UI flow demos + parity checklist update. |
| 69 | Milestone gate | M3 review: domain surfaces + security hardening + initial UI parity complete. | M3 evidence bundle and signoff. |
| 70 | UI parity | Implement gateway UI surfaces (feed/posts/comments) against contract states. | UI-gateway parity tests. |
| 71 | UI parity | Implement console UI surfaces for posts/moderation/invites. | UI-console parity tests. |
| 72 | UI parity | Implement keychain management/resolution UI flows. | Keychain UI parity + diagnostics proofs. |
| 73 | UI parity | Implement error-state UX mapping for 401/403/404/422/429/5xx. | Error UX acceptance report. |
| 74 | Observability/ops | Finalize event family emissions across all route families. | Event coverage matrix + sample traces. |
| 75 | Observability/ops | Wire SLI metrics emission for availability/latency/health/error budget. | Metrics validation and dashboard snapshots. |
| 76 | Observability/ops | Configure alerts and ownership routing per SLO/SLI spec. | Alert routing test records. |
| 77 | Reliability | Run performance tuning cycle for auth/feed latency targets. | p95 benchmark report with deltas. |
| 78 | Reliability | Validate `/health` degraded/down semantics under injected failures. | Failure injection logs and contract confirmations. |
| 79 | Operations | Implement and validate `ops:health-smoke` automation in CI. | Smoke command CI artifact. |
| 80 | Operations | Implement and validate `ops:migrate-smoke` automation in CI. | Migration smoke CI artifact. |
| 81 | Operations | Build startup evidence generation and archival path handling. | Boot evidence JSON samples per profile. |
| 82 | Operations | Execute key rotation rehearsal and JWKS overlap validation. | Rotation rehearsal evidence package. |
| 83 | Operations | Execute rollback rehearsal and restore validation. | Rollback drill evidence package. |
| 84 | Quality gate | Run full contract/security/abuse suite and close all failing gaps. | Full QA runbook artifact (all green). |
| 85 | Quality gate | Execute acceptance criteria matrix walkthrough (automated + manual). | Acceptance signoff report with request IDs. |
| 86 | Governance closeout | Update traceability matrix to implementation-complete state. | Traceability diff + owner signoff. |
| 87 | Governance closeout | Update decisions/risk/gaps based on implemented reality. | ADR/risk/gap updates merged. |
| 88 | Release readiness | Assemble release checklist and release evidence template draft. | Draft release evidence package. |
| 89 | Release readiness | Final pre-release gate review (A/B/C/D) and remediation sweep. | Gate-by-gate pass report. |
| 90 | Milestone gate | M4 final: production-readiness closeout and handoff package. | Final release evidence + handoff dossier. |

## Required cross-day discipline (applies daily)
1. Keep SSOT and implementation synchronized on same-day basis when behavior changes.
2. Maintain traceability and evidence artifacts incrementally (not batch-at-end).
3. Ensure each day ends with machine-verifiable proof (tests/logs/reports) tied to the day’s slice.
4. Avoid introducing fallback/legacy branches; keep deterministic happy and explicit deny paths only.
5. Preserve envelope-first API behavior and stable error/detail-code mapping throughout.
