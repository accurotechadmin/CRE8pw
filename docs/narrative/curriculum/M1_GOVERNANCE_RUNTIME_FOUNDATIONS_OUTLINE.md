# M1 Narrative Curriculum Outline: Governance + Runtime Foundations (Day 1–21)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
Translate M1 delivery slices into episode-ready teaching narratives that satisfy the three end goals:
1. make programming accessible,
2. explain how CRE8 is built day by day,
3. prepare learners to eventually extend CRE8 into production applications (with XtraType as the first handoff example).

## Audience levels (for each episode)
- **Beginner lane**: plain-language concept, one coding idea, one practical takeaway.
- **Builder lane**: implementation details, policy constraints, and tests/evidence.
- **Operator lane**: release/governance implications and what would break if skipped.

## Episode blueprint (repeat every day)
1. **What we are building today** (2–4 minutes)
2. **Why this matters in CRE8** (policy/contract/security context)
3. **Live build walkthrough** (step-by-step)
4. **Decision journal** (what we chose, alternatives considered, why)
5. **Proof of completion** (tests/logs/artifacts for the day)
6. **User-facing translation** (how this helps a future CRE8 user)
7. **Bridge to XtraType** (how today’s foundation later supports app-level customization)

## M1 Daily Narrative Outlines

### Day 1 — SSOT Workboard + Runtime Skeleton
- **Teaching focus**: How to start a project with structure before writing feature code.
- **Build story**: map SSOT domains to implementation workboard and create `src/tests/scripts` skeleton.
- **Decision journal prompts**:
  - Why docs-first instead of coding routes immediately?
  - Alternative: start with `/api/feed` early; rejected due to governance drift risk.
- **Proof**: workboard export + structure diagram + lint/compile baseline.

### Day 2 — Coding Standards + App Factory Bootstrap
- **Teaching focus**: standards as force multipliers for teams.
- **Build story**: contributor checklist, deterministic error/envelope standards, minimal app factory boot.
- **Decision journal prompts**:
  - Why enforce canonical naming now?
  - Alternative: defer standards; rejected because early inconsistency compounds.
- **Proof**: standards doc + bootstrap smoke output.

### Day 3 — DI Container Skeleton + CI Docs Checks
- **Teaching focus**: dependency injection and why CI should fail fast.
- **Build story**: service registration map, mandatory security service checks, docs lint/sync/report CI stub.
- **Decision journal prompts**:
  - Why containerized service boundaries over ad hoc instantiation?
  - Alternative: manual construction in handlers; rejected for testability/traceability limits.
- **Proof**: container resolution log + CI artifact.

### Day 4 — Typed Config Contracts
- **Teaching focus**: configuration as code and safety.
- **Build story**: typed runtime/JWT/CORS/rate config structures linked to env contract.
- **Decision journal prompts**:
  - Why strict typed config early?
  - Alternative: free-form env reads; rejected due to runtime ambiguity.
- **Proof**: config map + validation harness baseline.

### Day 5 — Env Loader + Hardening Rules
- **Teaching focus**: validating inputs before runtime begins.
- **Build story**: profile parser, `APP_ENV` rules, issuer/CORS/DSN safety checks.
- **Decision journal prompts**:
  - Why fail closed on unsafe env combinations?
  - Alternative: warn-only mode; rejected for production safety.
- **Proof**: pass/fail env matrix report.

### Day 6 — Key Material Safety Resolver
- **Teaching focus**: secure key handling fundamentals.
- **Build story**: inline/path key source resolver with stage/prod path-permission checks.
- **Decision journal prompts**:
  - Why strict file permission checks?
  - Alternative: rely on host hardening only; rejected as insufficient defense-in-depth.
- **Proof**: key safety test results + sanitized logs.

### Day 7 — Startup Assertion Runner
- **Teaching focus**: deterministic boot behavior.
- **Build story**: mandatory startup assertions before serving traffic.
- **Decision journal prompts**:
  - Why block startup on missing assertions?
  - Alternative: boot degraded and log warning; rejected due to hidden failure risk.
- **Proof**: startup assertion artifact + audit report.

### Day 8 — Request ID Context Lifecycle
- **Teaching focus**: observability and debuggability basics.
- **Build story**: immutable request context and request_id propagation.
- **Decision journal prompts**:
  - Why immutable request_id?
  - Alternative: regenerate per layer; rejected due to trace fragmentation.
- **Proof**: propagation tests + sample payloads.

### Day 9 — Envelope Responder Abstractions
- **Teaching focus**: API consistency through shared response contracts.
- **Build story**: `success/error` responders with required metadata and schema tests.
- **Decision journal prompts**:
  - Why centralized envelope responders?
  - Alternative: per-handler JSON responses; rejected for drift risk.
- **Proof**: schema-shape tests against envelope schemas.

### Day 10 — Canonical Error Mapper
- **Teaching focus**: turning exceptions into user-understandable outcomes.
- **Build story**: stable code/detail mapping with unknown-code rejection.
- **Decision journal prompts**:
  - Why deny unknown detail codes?
  - Alternative: auto-generate detail codes; rejected for taxonomy instability.
- **Proof**: error mapping matrix tests.

### Day 11 — Middleware Order Enforcement
- **Teaching focus**: request pipeline design and ordering guarantees.
- **Build story**: explicit middleware order constants + boot-time order assertion.
- **Decision journal prompts**:
  - Why enforce order at boot rather than relying on conventions?
  - Alternative: document order only; rejected due to regression risk.
- **Proof**: order evidence JSON + startup failure tests.

### Day 12 — Security Headers + CSP
- **Teaching focus**: browser-facing security controls.
- **Build story**: path-aware CSP (`/ui*` vs non-UI) and preserved headers on error paths.
- **Decision journal prompts**:
  - Why path-aware policy over one global header set?
  - Alternative: uniform permissive CSP; rejected for security posture.
- **Proof**: header/CSP verification report.

### Day 13 — CORS + Content Policy Wiring
- **Teaching focus**: cross-origin policy tradeoffs.
- **Build story**: strict stage/prod origin behavior, local-only wildcard support.
- **Decision journal prompts**:
  - Why deny broad wildcard in prod?
  - Alternative: wildcard for convenience; rejected due to abuse surface.
- **Proof**: CORS env matrix report.

### Day 14 — JSON/Content-Type Validation Middleware
- **Teaching focus**: input contracts and safe parsing.
- **Build story**: enforce JSON object expectations and canonical malformed-json failures.
- **Decision journal prompts**:
  - Why strict content-type and object-shape entry guards?
  - Alternative: permissive parsing; rejected due to undefined behavior.
- **Proof**: malformed JSON/content-type tests.

### Day 15 — Rate Limiter Baseline
- **Teaching focus**: protecting systems from accidental and malicious overload.
- **Build story**: global limiter integration and retry metadata behavior.
- **Decision journal prompts**:
  - Why include retry metadata?
  - Alternative: bare 429 responses; rejected for poor client ergonomics.
- **Proof**: rate limiter contract tests.

### Day 16 — Observability Event Emitter + Redaction
- **Teaching focus**: structured logs vs ad hoc logging.
- **Build story**: baseline startup/request events with mandatory secret/token redaction.
- **Decision journal prompts**:
  - Why enforce redaction centrally?
  - Alternative: rely on developer discipline; rejected as brittle.
- **Proof**: event sample pack + redaction tests.

### Day 17 — Public Route Placeholders
- **Teaching focus**: scaffolding end-to-end request flow before full features.
- **Build story**: baseline `/` and JWKS route placeholders that still honor envelope/security behavior.
- **Decision journal prompts**:
  - Why add placeholders now?
  - Alternative: delay until full auth complete; rejected due to integration sequencing needs.
- **Proof**: public route contract tests.

### Day 18 — Health Service Scaffold
- **Teaching focus**: what “healthy” means in distributed dependencies.
- **Build story**: subsystem probes (`db`, limiter, key material, dependency) and degraded semantics.
- **Decision journal prompts**:
  - Why expose degraded vs only pass/fail?
  - Alternative: binary health only; rejected due to triage limitations.
- **Proof**: health contract verification report.

### Day 19 — Startup Evidence Writer
- **Teaching focus**: operational evidence as part of engineering quality.
- **Build story**: structured startup evidence output and fail-safe messaging.
- **Decision journal prompts**:
  - Why evidence artifacts in development?
  - Alternative: evidence only at release; rejected because history gaps appear.
- **Proof**: success/failure evidence samples.

### Day 20 — Pre-close Stabilization and Audit
- **Teaching focus**: finishing well, not just coding quickly.
- **Build story**: resolve blockers, run full M1 verification set, capture unresolved owner-tagged items.
- **Decision journal prompts**:
  - Why explicit unresolved-owner tagging?
  - Alternative: informal TODO list; rejected for accountability loss.
- **Proof**: M1 verification summary + pre-close checklist.

### Day 21 — M1 Milestone Closeout
- **Teaching focus**: milestone governance and quality gates.
- **Build story**: owner signoffs, baseline tag freeze, M2 entry package handoff.
- **Decision journal prompts**:
  - Why signoff ceremony in an engineering workflow?
  - Alternative: auto-progress on passing tests only; rejected due to governance requirements.
- **Proof**: M1 closeout dossier (evidence template + traceability diff + signoffs).

---

## M1→M2 Entry Gate Narrative Episodes

### Gate Episode A — Middleware + Envelope Integrity
- **Narrative objective**: prove API runtime behavior is deterministic before data/auth expansion.
- **Must show**:
  - middleware-order assertion enforcement,
  - envelope + error mapper green tests,
  - canonical failure mapping demonstration.
- **Teaching angle**: pipeline correctness prevents hidden security and UX regressions.

### Gate Episode B — Config + Key Safety Integrity
- **Narrative objective**: prove runtime configuration cannot silently enter unsafe states.
- **Must show**:
  - env hardening checks,
  - key-material safety checks and fail-closed behavior.
- **Teaching angle**: secure defaults are a programming skill, not just a security specialty.

### Gate Episode C — Health + Operational Baseline
- **Narrative objective**: prove health contract behavior and observability basics are in place.
- **Must show**:
  - `/health` ok/degraded behavior,
  - startup evidence generation path,
  - correlation/request_id traceability.
- **Teaching angle**: operations is part of development from Day 1.

### Gate Episode D — Evidence Completeness + M2 Readiness
- **Narrative objective**: prove M1 can be audited and handed off safely.
- **Must show**:
  - complete M1 evidence package,
  - traceability updates,
  - explicit M2 entry criteria checklist walkthrough.
- **Teaching angle**: “done” means reproducible, reviewable, and extensible.

---

## Recurring segment: "Alternatives we considered"
Use this format every episode:
1. Option chosen.
2. 1–2 rejected alternatives.
3. Why rejected (risk, complexity, contract drift, security, or teachability).
4. What would have to change in SSOT/governance to revisit a rejected option.

## Recurring segment: "From CRE8 Engine to XtraType"
Close each episode with one sentence linking the day’s foundation to future product-level customization.
Examples:
- Day 9 envelope consistency -> easier XtraType annotation API client behavior.
- Day 16 event+redaction discipline -> safer annotation telemetry.
- Day 18 health semantics -> better uptime confidence for production annotation workflows.

## Instructor preparation checklist (before recording each day)
- Re-read that day’s row in M1 detailed slices.
- Pre-select one beginner concept and one advanced concept.
- Pre-select at least one rejected alternative and rationale.
- Pre-run the proof commands to avoid dead-air troubleshooting.
- Capture one "what users of CRE8 gain from this day" explanation.
- Capture one "how this enables future XtraType extension" explanation.
