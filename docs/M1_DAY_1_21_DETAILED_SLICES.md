# CRE8 M1 Detailed Daily Slices (Day 1–21)

_Status: draft implementation planning artifact_
_Last updated (UTC): 2026-04-12_

## Scope
This document expands Milestone M1 (**Foundation and governance hardening**) into explicit daily slices and handoff expectations for Days 1–21.

## M1 outcome target
By end of Day 21, CRE8 has:
1. SSOT-governed implementation workflow operating in CI,
2. runtime/bootstrap skeleton with deterministic startup assertions,
3. canonical envelope/error plumbing,
4. authoritative middleware order wired and test-verified,
5. baseline health and observability foundations ready for M2 data/auth build-out.

## Daily detailed slices and handoff contract

| Day | Governance slices | Backend/runtime slices | Security/policy slices | QA/ops slices | End-of-day done criteria | Handoff artifacts |
|---:|---|---|---|---|---|---|
| 1 | Confirm SSOT precedence and create implementation workboard mapped to SSOT families (00→80). | Create repository runtime skeleton (`src/`, `tests/`, `scripts/`) aligned with module boundaries. | Define canonical terminology glossary file for in-code references. | Create daily evidence folder convention. | Workboard exists with owners and SSOT links; skeleton compiles/lints. | SSOT-mapped workboard export, repo structure diagram. |
| 2 | Draft coding standard + review checklist enforcing envelope-first and deterministic failure mapping. | Create app bootstrap entrypoint and minimal app factory. | Define policy that prohibits fallback/legacy branches in new implementation. | Add PR checklist stub for impact-map + evidence attachment. | Coding/review standards merged; app factory boots locally. | `CONTRIBUTING` update, bootstrap smoke output. |
| 3 | Define change classes (A/B/C) operationalization in PR template labels. | Wire dependency injection container skeleton and service registration map. | Add registration checks for mandatory security services in container. | Add CI stub job for docs lint/sync/report commands. | Container resolves core service placeholders; CI job executes docs checks. | Container resolution log, CI run URL/artifact. |
| 4 | Establish ownership routing for domain-labeled changes (governance/contracts/security/ops). | Create typed config structures (`RuntimeConfig`, `JwtPolicy`, `CorsPolicy`, `RateLimitPolicy`). | Map env contract keys to typed config fields with validation stubs. | Add config validation test harness scaffold. | Typed config contract implemented; test harness runs. | Config schema map, test harness baseline report. |
| 5 | Implement PR evidence template autopopulation prompts (non-blocking metadata assist). | Implement env loader and profile parser from configuration contract. | Enforce `APP_ENV` and issuer/CORS/DSN hardening rules in parser. | Add negative tests for env misuse (wildcard prod CORS, invalid issuer, bad DSN). | Parser accepts valid profiles and rejects unsafe ones deterministically. | Env validation report (pass/fail matrix). |
| 6 | Add governance gate: no merge when required evidence sections missing. | Implement key material source resolver (inline PEM/path mode). | Add stage/prod key path permission safety checks. | Add tests for unreadable key path, malformed PEM, unsafe permissions. | Key source resolver fail-closes on invalid key material. | Key safety test results and sample sanitized logs. |
| 7 | Run M1-week1 governance audit and fix metadata/reference drift. | Implement startup assertion runner abstraction. | Register mandatory startup assertions (dependency class presence, config safety). | Add startup assertion test suite skeleton. | Startup assertions execute before route serving. | Audit report + startup assertion list artifact. |
| 8 | Freeze Day 8–14 runtime objective checklist and reviewers. | Implement request context object with request_id lifecycle. | Ensure request_id is immutable after initial creation. | Add request_id propagation tests through middleware/response. | request_id appears in context and error envelopes consistently. | request_id propagation report + sample payloads. |
| 9 | Update traceability seed rows for startup/config/request-id capabilities. | Implement envelope responder interfaces (`success`, `error`, metadata injection). | Enforce mandatory error `request_id` and stable code fields. | Add schema-shape tests against success/error envelope JSON schemas. | Envelope responses match canonical schema contract. | Envelope contract test report. |
| 10 | Add detail-code catalog mapping checklist to review template. | Build centralized exception/error mapper to canonical code/detail mappings. | Reject unknown/unregistered detail codes at mapper boundary. | Add mapping tests for 400/401/403/404/405/409/415/422/429/500. | All mapped errors deterministic and catalog-compliant. | Error mapping matrix + test output. |
| 11 | Confirm middleware order contract captured in implementation checklist. | Implement middleware registration mechanism with explicit order constants. | Prevent runtime boot if middleware order diverges from contract. | Add middleware order assertion test and startup failure test. | Middleware order is deterministic and boot-validated. | Middleware order evidence JSON + test logs. |
| 12 | Update ownership notes for security-header/CSP policy maintenance. | Implement security headers middleware baseline. | Implement path-aware CSP behavior (`/ui*` vs non-UI), preserving stricter preset values. | Add header/CSP tests including error-envelope path preservation. | Security headers/CSP behavior is contract-complete. | Header/CSP verification report. |
| 13 | Add contract note: API/UI CSP policies must never merge permissively. | Implement CORS middleware integration with typed policy config. | Enforce local-only wildcard behavior and strict stage/prod policy. | Add CORS preflight + denied-origin tests. | CORS behavior deterministic across env profiles. | CORS behavior report with env matrix. |
| 14 | Document validation ownership and schema update expectations. | Implement request content-type and JSON object validation middleware. | Ensure malformed JSON maps to canonical 400 detail codes. | Add malformed JSON/content-type tests. | Validation middleware emits canonical failure responses. | Validation failure-path report. |
| 15 | Add policy review checkpoint for limiter tuning assumptions. | Integrate rate limiter middleware with configured global policy/interval/limit. | Ensure limiter denials include canonical detail code and retry metadata. | Add rate-limit tests for pass/deny/retry semantics. | Limiter operates and emits canonical 429 responses. | Rate limiter contract test output. |
| 16 | Add observability taxonomy ownership mapping for event families. | Implement structured event emitter abstraction and baseline events (`startup_ready`, `startup_failed`, request events). | Ensure secret/token fields are redacted in all emitted logs/events. | Add redaction and event-shape tests. | Event stream exists with required fields + redaction guarantees. | Observability event sample pack + redaction test report. |
| 17 | Update traceability matrix entries for middleware/event capabilities. | Implement base route placeholders for `/` and `/.well-known/jwks.json`. | Ensure public routes bypass auth guards but retain security/envelope behavior. | Add contract tests for placeholder public routes. | Public baseline routes return canonical responses. | Public route contract test output. |
| 18 | Add health contract owner checklist and subsystem probe responsibilities. | Implement health service scaffold with subsystem probes (`db`, `rate_limiter`, `key_material`, `http_dependency`). | Ensure degraded/down semantics are represented without leaking internals. | Add health route tests for ok/degraded/500 contract cases. | `/health` route returns contract-compliant envelope and status semantics. | Health contract verification report. |
| 19 | Prepare M1 readiness rubric for Day 21 signoff. | Implement startup evidence writer (`BOOT_EVIDENCE_PATH`) with structured JSON. | Ensure startup failure still returns startup-safe message and request_id. | Add startup success/failure evidence generation tests. | Startup evidence generation complete and deterministic. | Startup evidence samples (success/failure). |
| 20 | Execute pre-M1 closure review (open issues, unresolved assumptions, risk updates). | Stabilize runtime foundation and resolve all M1 blocker defects. | Confirm no unresolved security policy ambiguities for M1 scope. | Run full M1 verification set (unit+contract slices introduced in M1). | All M1 tests pass, and unresolveds are logged with owners if any remain. | M1 pre-close checklist + verification summary. |
| 21 | Hold milestone closeout review with required owner signoffs. | Tag and freeze M1 baseline branch point for M2 start. | Validate security and governance signoff conditions are met. | Produce M1 evidence package and handoff notes for Day 22. | M1 accepted with signed evidence and explicit M2 entry criteria. | M1 closeout dossier (evidence template + traceability diff + signoffs). |

## M1 mandatory daily evidence checklist
Every day (1–21) must attach:
1. command/test output for that day’s technical slice,
2. traceability update (or explicit no-change statement),
3. risk/gap update note (or explicit no-change statement),
4. reviewer acknowledgment.

## M1 to M2 entry criteria
M2 cannot start unless all are true:
- middleware order assertion is enforced at startup,
- envelope and error mapping tests are green,
- config/key-material safety checks are green,
- `/health` contract tests are green,
- M1 evidence package is complete and approved.
