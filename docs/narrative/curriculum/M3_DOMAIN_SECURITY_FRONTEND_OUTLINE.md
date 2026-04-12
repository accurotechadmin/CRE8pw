# M3 Narrative Curriculum Outline: Domain Routes + Security Hardening + Initial Frontend Parity (Day 46–69)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
Translate M3 delivery slices into episode-ready teaching narratives that continue the three end goals:
1. make programming approachable and accessible,
2. make the CRE8 build journey easy to digest,
3. guide learners from core CRE8 understanding to extending CRE8 into their own apps, with XtraType as the first full handoff exemplar.

## Audience lanes (repeat each episode)
- **Beginner lane**: one core concept, one concrete coding takeaway, one “why this matters” summary.
- **Builder lane**: implementation details, contracts, authorization/security invariants.
- **Operator lane**: verification evidence, failure modes, and readiness implications.

## Episode blueprint (repeat every day)
1. What we are building today
2. Why it matters in the CRE8 architecture and user experience
3. Implementation walkthrough
4. Decision journal (choice, alternatives, rationale)
5. Proof walkthrough (tests/reports/evidence)
6. User-facing translation
7. Bridge to XtraType extension path

## M3 Daily Narrative Outlines

### Day 46 — Gateway Feed Route (`GET /api/feed`)
- **Teaching focus**: route-to-policy coupling and scoped reads.
- **Build story**: implement feed handler/service with scope filtering and pagination baseline.
- **Decision journal prompts**:
  - Why enforce auth/device prerequisites before feed execution?
  - Alternative: filter in frontend only; rejected due to server-side policy guarantees.
- **Proof**: feed contract tests (200/401/403/429) + ordering checks.

### Day 47 — Post Create (`POST /api/posts`)
- **Teaching focus**: write-path authorization and transactional boundaries.
- **Build story**: create flow with policy checks and metadata stamps.
- **Decision journal prompts**:
  - Why enforce `posts:create` and use-key constraints at service boundary?
  - Alternative: rely on route middleware only; rejected due to defense-in-depth goals.
- **Proof**: allow/deny/validation tests + audit/event samples.

### Day 48 — Post Read/Edit (`GET/PATCH /api/posts/{postId}`)
- **Teaching focus**: combining visibility policy with revision semantics.
- **Build story**: post detail visibility checks plus revision-writing edit flow.
- **Decision journal prompts**:
  - Why keep read and edit policy checks explicit and separate?
  - Alternative: shared permissive check; rejected for least-privilege correctness.
- **Proof**: 200/403/404/422 tests + revision integrity checks.

### Day 49 — Revision Transaction Hardening
- **Teaching focus**: atomicity and rollback behavior.
- **Build story**: harden revision transaction boundaries for partial-failure safety.
- **Decision journal prompts**:
  - Why induce failure-path tests intentionally?
  - Alternative: rely on happy-path coverage; rejected due to hidden data corruption risk.
- **Proof**: transaction integrity tests under injected failures.

### Day 50 — Post Flags (`POST /api/posts/{postId}/flags`)
- **Teaching focus**: moderation-intake patterns.
- **Build story**: reason validation, persistence, and policy enforcement for flags.
- **Decision journal prompts**:
  - Why validate reason taxonomy explicitly?
  - Alternative: free-text only with no guardrails; rejected for moderation consistency.
- **Proof**: valid/invalid/not-found/policy-deny tests.

### Day 51 — Comment Listing (`GET /api/posts/{postId}/comments`)
- **Teaching focus**: state-aware reads and ordering logic.
- **Build story**: comment list with state filters and policy visibility checks.
- **Decision journal prompts**:
  - Why test hidden/locked/deleted permutations?
  - Alternative: basic active-only listing; rejected for lifecycle coverage gaps.
- **Proof**: state matrix + ordering tests.

### Day 52 — Comment Create (`POST /api/posts/{postId}/comments`)
- **Teaching focus**: policy-driven mutation checks.
- **Build story**: transactional comment create with `comments:create` and post-state checks.
- **Decision journal prompts**:
  - Why check comments-enabled policy in backend every time?
  - Alternative: UI-only disable controls; rejected for trust-boundary reasons.
- **Proof**: allow/forbidden/validation tests.

### Day 53 — Console Posts (`GET/POST /console/api/posts`)
- **Teaching focus**: console surface behavior and owner context.
- **Build story**: owner-console post handlers with CSRF-aware write behavior.
- **Decision journal prompts**:
  - Why insist on owner JWT + CSRF on console writes?
  - Alternative: JWT only; rejected due to browser attack surface.
- **Proof**: console post contract + CSRF negative-path tests.

### Day 54 — Keychain Inventory/Create (`GET/POST /console/api/keychains`)
- **Teaching focus**: keychain as first-class principal in v1.
- **Build story**: keychain listing and creation orchestration.
- **Decision journal prompts**:
  - Why expose keychain management via console only?
  - Alternative: gateway self-managed keychains; rejected for governance separation.
- **Proof**: list/create contract tests.

### Day 55 — Keychain Membership Mutations
- **Teaching focus**: policy invariants under mutation.
- **Build story**: member add/remove routes with atomic snapshot recompute triggers.
- **Decision journal prompts**:
  - Why enforce no-nesting/size cap/class checks on every mutation?
  - Alternative: periodic batch validation; rejected for immediate safety guarantees.
- **Proof**: duplicate/oversize/invalid-class/remove semantics tests.

### Day 56 — Keychain Resolve (`GET /console/api/keychains/{keychainId}/resolve`)
- **Teaching focus**: effective-permission projection and lineage transparency.
- **Build story**: resolve route excluding inactive members while preserving lineage context.
- **Decision journal prompts**:
  - Why include lineage projection in resolve output?
  - Alternative: return final effective set only; rejected for audit explainability.
- **Proof**: valid/missing/unauthorized resolve tests.

### Day 57 — Invites (`POST /console/api/invites`)
- **Teaching focus**: controlled onboarding primitives.
- **Build story**: invite issuance path with receipt persistence and validation.
- **Decision journal prompts**:
  - Why owner-only invite authority in v1?
  - Alternative: delegated invite issuance; rejected for governance simplicity in initial release.
- **Proof**: 201/401/403/422 tests + invite receipt samples.

### Day 58 — Key Issuance (`POST /console/api/keys`)
- **Teaching focus**: delegation and mint authority in practice.
- **Build story**: delegated key issuance with subset/depth/expiry and mint-authority checks.
- **Decision journal prompts**:
  - Why test issuance against both delegation and mint matrices?
  - Alternative: merge all checks into one opaque gate; rejected for debuggability.
- **Proof**: decision-table conformance tests.

### Day 59 — Key Lifecycle (`POST /console/api/keys/{keyId}/lifecycle`)
- **Teaching focus**: controlled state transitions.
- **Build story**: lifecycle transition route with legal-path and authority validation.
- **Decision journal prompts**:
  - Why enforce conflict/forbidden/validation semantics distinctly?
  - Alternative: generalized failure response; rejected for operator clarity.
- **Proof**: success/conflict/forbidden/validation test pack.

### Day 60 — Moderation Routes
- **Teaching focus**: governance actions as auditable domain operations.
- **Build story**: moderation transitions for posts/comments with scoped authority checks.
- **Decision journal prompts**:
  - Why require audit integrity checks alongside functional tests?
  - Alternative: log-only moderation tracking; rejected for accountability rigor.
- **Proof**: moderation integration tests + audit assertions.

### Day 61 — CSRF Hardening Coverage
- **Teaching focus**: browser threat mitigation across write surfaces.
- **Build story**: enforce CSRF coverage on all applicable console writes.
- **Decision journal prompts**:
  - Why test missing/malformed/mismatch token variants?
  - Alternative: single invalid-token test; rejected for incomplete threat coverage.
- **Proof**: CSRF abuse test report.

### Day 62 — Device Guard Hardening
- **Teaching focus**: route-family policy enforcement consistency.
- **Build story**: enforce required `X-Device-Id` across gateway routes.
- **Decision journal prompts**:
  - Why fail on missing/invalid device header uniformly?
  - Alternative: endpoint-specific optionality; rejected for policy drift risk.
- **Proof**: device bypass/format conformance tests.

### Day 63 — Redaction Hardening
- **Teaching focus**: preventing sensitive-data leakage.
- **Build story**: centralized redaction utility applied across handlers/middleware/errors.
- **Decision journal prompts**:
  - Why central utility vs ad hoc redaction calls?
  - Alternative: route-local masking; rejected for inconsistency/leak risk.
- **Proof**: redaction verification suite + sanitized log samples.

### Day 64 — Rate-Limit Tuning
- **Teaching focus**: balancing abuse protection and usability.
- **Build story**: auth/gateway limiter tuning + deterministic retry metadata behavior.
- **Decision journal prompts**:
  - Why tune by endpoint sensitivity rather than one global threshold?
  - Alternative: uniform limits for all; rejected for poor operational fit.
- **Proof**: limiter load simulation and threshold validation report.

### Day 65 — Threat-to-Control Closure
- **Teaching focus**: closing the loop between threat models and implementation.
- **Build story**: validate replay/escalation/CSRF/rate/leakage controls against implemented routes.
- **Decision journal prompts**:
  - Why maintain explicit threat-control traceability?
  - Alternative: rely on broad security smoke tests; rejected for coverage ambiguity.
- **Proof**: updated security regression suite + closure artifact.

### Day 66 — Frontend Runtime Foundation
- **Teaching focus**: frontend state architecture.
- **Build story**: SPA runtime shell, route-state primitives, session context split.
- **Decision journal prompts**:
  - Why separate owner and key session contexts?
  - Alternative: single mixed session model; rejected for security/context confusion.
- **Proof**: frontend runtime baseline tests.

### Day 67 — Envelope-Aware API Client
- **Teaching focus**: resilient client-side contract handling.
- **Build story**: API client parsing success/error envelopes with normalized errors and request_id capture.
- **Decision journal prompts**:
  - Why normalize errors client-side?
  - Alternative: route-specific ad hoc parsing; rejected for UX inconsistency.
- **Proof**: frontend parsing/diagnostics tests.

### Day 68 — Initial Frontend Auth/Bootstrap Parity
- **Teaching focus**: route-state UX and session flow reliability.
- **Build story**: owner login, key login, refresh handling, diagnostics panel baseline.
- **Decision journal prompts**:
  - Why deliver diagnostics panel this early?
  - Alternative: polish UI first; rejected because supportability is part of parity.
- **Proof**: auth/bootstrap parity checks (automated + walkthrough evidence).

### Day 69 — M3 Milestone Closeout
- **Teaching focus**: cross-domain integration signoff.
- **Build story**: consolidate backend/security/frontend outcomes, execute full verification suite, package M3 evidence.
- **Decision journal prompts**:
  - Why require explicit high-severity ambiguity check before M4?
  - Alternative: defer unresolved issues into hardening milestone; rejected for schedule/risk compounding.
- **Proof**: M3 closeout dossier.

---

## M3→M4 Gate Narrative Episodes

### Gate Episode A — Domain Route Completion Integrity
- **Narrative objective**: verify gateway and console route families are contract-complete with negative-path confidence.
- **Must show**:
  - route contract pass across gateway/console families,
  - policy and lifecycle edge-case coverage,
  - auditable write-path evidence.
- **Teaching angle**: feature completion means behavior + failure semantics + auditability.

### Gate Episode B — Security Hardening Readiness
- **Narrative objective**: verify cross-cutting controls (CSRF/device/redaction/rate/threat controls) are hardened and tested.
- **Must show**:
  - CSRF/device guard suites,
  - redaction guarantees,
  - threat-control closure report.
- **Teaching angle**: hardening is implementation work, not post-release cleanup.

### Gate Episode C — Initial Frontend Parity Readiness
- **Narrative objective**: verify runtime shell + API client + auth/bootstrap flows are parity-ready for M4 expansion.
- **Must show**:
  - frontend runtime/session tests,
  - envelope/error/request_id handling evidence,
  - auth/bootstrap UX parity checks.
- **Teaching angle**: UI reliability is contract comprehension made visible.

### Gate Episode D — Evidence Completeness + M4 Entry
- **Narrative objective**: verify milestone evidence is complete and the M4 hardening path is unblocked.
- **Must show**:
  - M3 evidence package completeness,
  - traceability/risk/gap updates,
  - explicit M4 entry checklist walkthrough.
- **Teaching angle**: milestone transitions are governance events, not just calendar dates.

---

## Recurring segment: “Alternatives we considered”
Use this structure in every episode:
1. Option selected.
2. 1–2 alternatives considered.
3. Why alternatives were rejected (security, contract drift, complexity, operability, or teaching clarity).
4. What SSOT/governance updates would be required to revisit alternatives.

## Recurring segment: “CRE8 Engine → XtraType Handoff”
Close each episode with one bridge sentence showing how the day’s M3 work enables future app-level extension.
Examples:
- Day 56 keychain resolution transparency -> clearer permission introspection for team annotation workflows.
- Day 63 redaction hardening -> safer annotation diagnostics in production.
- Day 67 normalized envelope client -> faster feature delivery for XtraType-specific frontend modules.

## Instructor prep checklist (before recording each M3 episode)
- Re-read the day row in `docs/M3_DAY_46_69_DETAILED_SLICES.md`.
- Select one beginner concept and one advanced concept.
- Pre-select at least one rejected alternative with rationale.
- Pre-run the day’s proof commands and collect artifacts/screens.
- Prepare one “why CRE8 users should care today” explanation.
- Prepare one “how this supports XtraType handoff” explanation.
