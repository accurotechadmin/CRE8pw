# CRE8 Development Execution Detailed Slices (End-to-End)

_Status: adopted execution companion_
_Last updated (UTC): 2026-04-22_
_Primary source: `docs/DEVELOPMENT_EXECUTION_MASTER_PLAN.md`_

## Purpose
This document is the execution-detail companion to `DEVELOPMENT_EXECUTION_MASTER_PLAN.md`.  
It translates the stage model (Stage 0–10) into complete, implementation-ready delivery slices with explicit dependencies, deliverables, and validation evidence.

## Usage contract
1. Use this document for day-to-day execution sequencing.
2. Use the master plan for gates, objectives, and final completion rules.
3. Do not skip slice dependencies.
4. Do not mark a slice complete without listed evidence.
5. If a slice changes contracts/security/data/operations behavior, update SSOT artifacts in the same PR.

---

## Stage 0 — Program initialization and delivery operating system

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S0-01 | Establish implementation directory skeleton and ownership boundaries. | none | `src/`, `tests/`, `scripts/`, `ui/`, `infra/` scaffold + ownership map | Repo structure artifact + owner signoff |
| S0-02 | Build SSOT-to-backlog decomposition with requirement IDs. | S0-01 | SSOT requirement matrix and tracked implementation backlog | Traceability seed + mapping completeness check |
| S0-03 | Define coding standards and review policy aligned to SSOT terminology. | S0-01 | Contributing standard and reviewer checklist | Review checklist published + sample review pass |
| S0-04 | Wire CI baseline for docs/schema/static/test skeleton checks. | S0-01 | CI workflow with required baseline jobs | Green CI run artifact |
| S0-05 | Integrate evidence templates and PR payload enforcement. | S0-02,S0-04 | PR template + evidence template requirements | PR validation gate passing proof |
| S0-06 | Enable docs sync/lint/report automation commands. | S0-04 | `docs:ssot:*` automation scripts and CI wiring | Lint/sync/report outputs archived |
| S0-07 | Finalize implementation-era ADR logging workflow. | S0-03 | ADR intake/update process | Recorded dry-run ADR update |

---

## Stage 1 — Runtime and platform foundation

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S1-01 | Implement app bootstrap lifecycle and fail-closed startup scaffolding. | S0-04 | Runtime bootstrap and startup assertion runner | Startup success/failure tests |
| S1-02 | Implement typed environment/config parser with profile hardening. | S1-01 | Config loader + validation rules | Env positive/negative test matrix |
| S1-03 | Implement key source resolver and key material safety checks. | S1-02 | Key resolution module and safety assertions | Key path/permission verification tests |
| S1-04 | Implement request-id propagation primitives. | S1-01 | Request context + request ID injection | Request ID propagation tests |
| S1-05 | Implement canonical envelope responder and centralized error mapper. | S1-04 | Success/error envelope responders and detail-code mapper | Schema contract tests + detail-code mapping tests |
| S1-06 | Implement middleware ordering and registration guardrails. | S1-05 | Middleware stack registration with order assertion | Middleware order lock test |
| S1-07 | Implement security headers/CSP middleware. | S1-06 | Header/CSP middleware with path-aware policy | Header/CSP contract tests |
| S1-08 | Implement CORS/content normalization middleware. | S1-06 | CORS and content-type middleware | Preflight/deny-path tests |
| S1-09 | Implement validation middleware primitives. | S1-06 | JSON/content/shape validation middleware | 400/422 negative-path tests |
| S1-10 | Implement rate limiter middleware integration. | S1-06 | Rate-limiter policy integration | 429 behavior + retry metadata tests |
| S1-11 | Implement observability emitter baseline and redaction. | S1-04,S1-05 | Structured event emitter + redaction rules | Event-shape and redaction tests |
| S1-12 | Implement `/health` baseline service with subsystem probes. | S1-02,S1-03,S1-10 | Health probe service and endpoint | health ok/degraded/down verification |
| S1-13 | Implement startup evidence output contract (`BOOT_EVIDENCE_PATH`). | S1-01,S1-06 | Startup evidence writer | Startup evidence artifact samples |

---

## Stage 2 — Data platform and migration backbone

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S2-01 | Implement migration engine and migration command framework. | S0-04 | Migration runner + ordering/checksum controls | Migration runner smoke output |
| S2-02 | Implement rollback framework and rollback safety checks. | S2-01 | Rollback command path + safety guards | Rollback rehearsal output |
| S2-03 | Implement identity/auth tables (`principals`, `principal_emails`, `credentials`). | S2-01 | Schema migrations for identity core | Schema verification + FK/index checks |
| S2-04 | Implement token family and delegation envelope tables/invariants. | S2-03 | `token_families`, `delegation_envelopes` schema | Replay/depth/status integrity tests |
| S2-05 | Implement keychain membership and effective snapshot tables. | S2-04 | Keychain schema + uniqueness/index contracts | Keychain schema invariant tests |
| S2-06 | Implement content/moderation/invite schema set. | S2-03 | Posts/comments/revisions/flags/moderation/invites schema | Data integrity and FK tests |
| S2-07 | Implement deterministic seed strategy and fixture packs. | S2-01,S2-06 | Seed scripts + fixture packs | Fixture determinism report |
| S2-08 | Implement migration smoke operations (`ops:migrate-smoke`). | S2-01,S2-02,S2-07 | Migration smoke command | CI smoke artifact |

---

## Stage 3 — Identity, authentication, and token lifecycle

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S3-01 | Implement owner credential verification flow. | S2-03,S1-05 | Owner auth service | Owner allow/deny tests |
| S3-02 | Implement key credential verification flow. | S2-03,S1-05 | Key auth service | Key allow/deny tests |
| S3-03 | Implement JWT signer/verifier with claim policy checks. | S1-03,S3-01,S3-02 | JWT service with issuer/audience/type/timing checks | JWT claim conformance tests |
| S3-04 | Implement auth endpoints (`/console/owners`, login, key-login). | S3-01,S3-02,S3-03 | Auth route handlers + request validation | Auth contract tests |
| S3-05 | Implement refresh token family rotation/replay invalidation. | S2-04,S3-03 | Refresh lifecycle service | Replay invalidation test suite |
| S3-06 | Implement lifecycle-aware auth denial states. | S2-04,S3-03 | Suspended/revoked/cancelled checks | Lifecycle deny-path tests |
| S3-07 | Implement JWKS publication and key overlap handling. | S3-03 | JWKS route and rotation overlap logic | JWKS and rotation rehearsal evidence |

---

## Stage 4 — Authorization, delegation, and keychain policy engine

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S4-01 | Implement permission vocabulary and allow-list evaluator. | S3-03 | Policy evaluator core | Permission matrix tests |
| S4-02 | Implement scope evaluation engine. | S4-01 | Scope evaluator module | Scope allow/deny tests |
| S4-03 | Implement delegation issuance validator (subset/depth/expiry). | S4-01,S4-02,S2-04 | Delegation validator | Delegation decision-table conformance |
| S4-04 | Implement key class mint authority rules. | S4-03 | Mint authority policy module | Key-class mint matrix tests |
| S4-05 | Implement keychain membership admission rules. | S4-01,S2-05 | Keychain membership policy | No-nesting/class/status tests |
| S4-06 | Implement keychain effective permission/scope resolution. | S4-05 | Effective resolver + snapshot recompute | Resolution deterministic tests |
| S4-07 | Implement lifecycle authority transitions and cascade policy. | S4-04,S4-06 | Lifecycle decision engine | Lifecycle authority tests |
| S4-08 | Emit auditable policy decision events for all privileged paths. | S4-01,S1-11 | Policy audit event integration | Event coverage report |

---

## Stage 5 — API surface implementation (gateway + console)

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S5-01 | Implement public/platform routes (`/`, `/health`, `/.well-known/jwks.json`, `/ui/{route}`). | S1-12,S3-07 | Public route handlers | Public route contract tests |
| S5-02 | Implement gateway feed and post create/read routes. | S4-03,S4-08 | Feed/posts handlers + service layer | Gateway contract tests |
| S5-03 | Implement gateway post edit/flag routes. | S5-02,S4-03 | Edit/flag handlers | Edit/flag negative-path tests |
| S5-04 | Implement gateway comment list/create routes. | S5-02,S4-03 | Comment handlers | Comment policy tests |
| S5-05 | Implement console post list/create routes. | S3-04,S4-08 | Console post handlers | Console contract tests |
| S5-06 | Implement console keychain list/create/member/resolve routes. | S4-05,S4-06 | Keychain handlers | Keychain contract + security tests |
| S5-07 | Implement invite and key issuance routes. | S4-04,S4-07 | Invite/key issuance handlers | Invite/key issuance tests |
| S5-08 | Implement key lifecycle transition route. | S4-07 | Lifecycle transition handler | Lifecycle transition matrix tests |
| S5-09 | Implement post/comment moderation routes. | S4-07 | Moderation handlers | Moderation transition tests |
| S5-10 | Complete route-level error taxonomy parity and detail-code alignment. | S5-01..S5-09 | Error mapping coverage updates | Error taxonomy drift report |

---

## Stage 6 — Frontend/UI platform and contract parity

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S6-01 | Implement UI runtime shell and route state model. | S5-01 | UI shell + state machine | UI runtime state tests |
| S6-02 | Implement envelope-aware API client + normalized error model. | S6-01,S5-10 | UI API client and diagnostics model | Client contract tests |
| S6-03 | Implement auth/bootstrap UI flows. | S6-02,S3-04 | Owner/key login and refresh UI | Auth journey E2E tests |
| S6-04 | Implement gateway UI flows (feed/posts/comments/flags). | S6-02,S5-02,S5-04 | Gateway UI routes | Gateway UI parity report |
| S6-05 | Implement console UI flows (posts/moderation/invites/keys). | S6-02,S5-05,S5-07,S5-09 | Console UI routes | Console UI parity report |
| S6-06 | Implement keychain management/resolution UI flows. | S6-05,S5-06 | Keychain UI routes | Keychain UI parity tests |
| S6-07 | Implement error/degraded-state UX mapping for required status families. | S6-02 | Error-state UX system | 401/403/404/422/429/5xx UI checks |
| S6-08 | Implement accessibility and diagnostics minimums (request_id visibility). | S6-01,S6-07 | A11y and diagnostics controls | Accessibility checks + diagnostics screenshots |

---

## Stage 7 — Security hardening and abuse-case closure

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S7-01 | Complete CSP/header policy hardening verification. | S1-07,S6-08 | Header/CSP enforcement pack | Header/CSP abuse tests |
| S7-02 | Complete CSRF controls for applicable console writes. | S5-05,S5-09 | CSRF middleware + route integration | CSRF abuse-case tests |
| S7-03 | Complete device-binding guard strictness for gateway routes. | S3-03,S5-02 | Device guard enforcement | Device mismatch/missing tests |
| S7-04 | Harden rate limiting profiles by endpoint sensitivity. | S1-10,S5-* | Policy-tiered limiter configuration | Flood simulation report |
| S7-05 | Harden secrets handling and sensitive log redaction. | S1-11 | Redaction policy + filters | Redaction verification suite |
| S7-06 | Complete threat-to-test traceability and abuse matrix closure. | S7-01..S7-05 | Updated abuse-case coverage map | 100% abuse-case regression evidence |

---

## Stage 8 — Quality engineering, test architecture, and reliability

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S8-01 | Complete full test pyramid (unit/component/integration/contract/E2E/security). | S5-10,S6-08,S7-06 | Complete automated test suites | CI suite dashboard |
| S8-02 | Implement OpenAPI/runtime and schema conformance automation. | S8-01 | Contract conformance automation | OpenAPI/envelope drift report |
| S8-03 | Execute performance baseline and regression profiling. | S5-10,S6-04 | Performance harness + thresholds | p95/p99 benchmark report |
| S8-04 | Execute dependency-failure/chaos scenarios. | S1-12,S8-01 | Failure injection harness | Degraded/down behavior evidence |
| S8-05 | Stabilize flaky tests and enforce deterministic execution controls. | S8-01 | Isolation/retry/fixture controls | Flake-rate trend report |
| S8-06 | Close acceptance criteria matrix coverage for all routes. | S8-01,S8-02 | Acceptance matrix evidence pack | Acceptance signoff report |

---

## Stage 9 — Operations, release engineering, and production readiness

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S9-01 | Implement CI/CD release packaging and promotion workflow. | S8-01 | Release pipeline | Release pipeline dry run |
| S9-02 | Operationalize smoke automation (`ops:health-smoke`, `ops:migrate-smoke`, startup evidence). | S1-13,S2-08,S8-01 | Smoke automation jobs | Smoke CI artifacts |
| S9-03 | Validate cross-environment configuration parity and secret readiness. | S1-02,S3-03 | Env parity checklist + secret readiness controls | Environment parity report |
| S9-04 | Rehearse key rotation and JWKS overlap in operational context. | S3-07,S9-03 | Rotation runbook + rehearsal | Rotation evidence package |
| S9-05 | Rehearse rollback and data restore operations. | S2-02,S9-01 | Rollback/restore runbooks | Rollback drill evidence |
| S9-06 | Complete SLO/SLI dashboards and alert routing validation. | S8-03 | SLI dashboards + alert policies | Alert fire-drill report |
| S9-07 | Assemble production readiness gates and release evidence package. | S9-01..S9-06 | Completed gate evidence and release template | Gate approval record |

---

## Stage 10 — Launch, stabilization, and continuous evolution

| Slice ID | Slice objective | Depends on | Required deliverables | Required validation/evidence |
|---|---|---|---|---|
| S10-01 | Execute controlled launch window with progressive exposure policy. | S9-07 | Launch plan and exposure controls | Launch go/no-go checklist |
| S10-02 | Run post-launch reliability/security/latency review loop. | S10-01 | Early-life operations review cadence | 24h/72h post-launch reports |
| S10-03 | Close critical defects and document remediation evidence. | S10-02 | Defect remediation backlog and fixes | Regression evidence |
| S10-04 | Re-baseline risks, traceability, and decisions from production learnings. | S10-02,S10-03 | Updated risk register + traceability diff + ADR/log updates | Governance update signoff |
| S10-05 | Transition to continuous-delivery cadence with no SSOT drift. | S10-04 | Steady-state delivery workflow | Drift audit pass + release cadence report |

---

## Cross-stage non-negotiables
1. Every slice completion requires machine-verifiable evidence.
2. Any contract/security/data/operations change requires same-PR SSOT synchronization.
3. Any unresolved assumption must be recorded in `RISK_REGISTER.md` with owner and target date.
4. Gate progression is blocked by missing evidence, unresolved critical defects, or SSOT drift.
5. Emergency changes must follow Class D process in `CHANGE_CONTROL_POLICY.md` and include remediation PR linkage.

## Completion rule
Execution is complete only when all slices `S0-01` through `S10-05` are complete and all gates defined in `DEVELOPMENT_EXECUTION_MASTER_PLAN.md` are passed with attached evidence.

