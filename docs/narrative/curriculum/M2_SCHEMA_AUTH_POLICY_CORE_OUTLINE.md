# M2 Narrative Curriculum Outline: Schema + Auth + Policy Core (Day 22–45)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
Translate M2 delivery slices into episode-ready teaching narratives that continue the three end goals:
1. programming is accessible to everyone,
2. the CRE8 build process is understandable and traceable,
3. learners can progress from CRE8 platform understanding to platform extension, with XtraType as the first handoff exemplar.

## Audience lanes (repeat each episode)
- **Beginner lane**: core concept in plain language + one concrete coding takeaway.
- **Builder lane**: implementation details + contract/policy invariants.
- **Operator lane**: verification/evidence implications and failure risks.

## Episode blueprint (repeat every day)
1. What we are building today
2. Why this matters in CRE8 system behavior
3. Step-by-step implementation walkthrough
4. Decision journal (choice + alternatives + why)
5. Proof artifact walkthrough (tests/reports)
6. User-facing value translation
7. Bridge to XtraType extensibility

## M2 Daily Narrative Outlines

### Day 22 — Migration Runner Foundation
- **Teaching focus**: schema evolution and repeatable database change workflows.
- **Build story**: migration runner, naming conventions, safety prechecks, smoke command scaffold.
- **Decision journal prompts**:
  - Why deterministic migrations before feature tables?
  - Alternative: manual SQL migrations; rejected for auditability/repeatability concerns.
- **Proof**: migration framework report + smoke baseline.

### Day 23 — Principals/Credentials Core Tables
- **Teaching focus**: identity modeling fundamentals.
- **Build story**: `principals`, `principal_emails`, `credentials` with indexes/FKs and domain constraints.
- **Decision journal prompts**:
  - Why enforce principal/key-class constraints at schema layer too?
  - Alternative: app-only validation; rejected due to integrity drift risk.
- **Proof**: schema integrity tests + migration diff artifact.

### Day 24 — Token Families and Refresh Lifecycles
- **Teaching focus**: session continuity vs replay safety.
- **Build story**: `token_families` schema and transactional rotation/revocation semantics.
- **Decision journal prompts**:
  - Why family-based refresh model?
  - Alternative: stateless refresh-only JWT; rejected for replay controls.
- **Proof**: transition tests for create/rotate/revoke flows.

### Day 25 — Delegation Envelope Persistence
- **Teaching focus**: permissions-as-data with invariant encoding.
- **Build story**: `delegation_envelopes` schema with depth/status constraints.
- **Decision journal prompts**:
  - Why store delegation lineage metadata explicitly?
  - Alternative: compute lineage transiently; rejected for audit clarity.
- **Proof**: invalid depth/status rejection tests.

### Day 26 — Keychain Membership + Snapshot Tables
- **Teaching focus**: aggregating authority safely.
- **Build story**: `keychain_memberships`, `keychain_effective_snapshots`, uniqueness/integrity constraints.
- **Decision journal prompts**:
  - Why snapshot recompute architecture?
  - Alternative: on-demand compute only; rejected for deterministic auditing needs.
- **Proof**: keychain schema conformance output.

### Day 27 — Content Domain Tables
- **Teaching focus**: relational modeling for mutable content.
- **Build story**: `posts`, `post_revisions`, `post_flags`, `comments` with state constraints.
- **Decision journal prompts**:
  - Why keep revision history first-class?
  - Alternative: overwrite-in-place; rejected for traceability/lifecycle requirements.
- **Proof**: content schema migration report.

### Day 28 — Moderation + Invites Tables
- **Teaching focus**: governance data structures.
- **Build story**: `moderation_actions`, `invite_receipts` and lifecycle timestamps.
- **Decision journal prompts**:
  - Why separate moderation action ledger?
  - Alternative: embed moderation flags in posts only; rejected for audit granularity.
- **Proof**: moderation/invite schema validation artifact.

### Day 29 — Seeds and Fixture Governance
- **Teaching focus**: reproducible environments for learning/testing.
- **Build story**: deterministic seed orchestration and fixture packs.
- **Decision journal prompts**:
  - Why idempotent seeds?
  - Alternative: one-time seeding scripts; rejected for CI/replay reliability.
- **Proof**: seed idempotency report.

### Day 30 — JWT Key Loader Integration
- **Teaching focus**: cryptographic key sourcing safety.
- **Build story**: runtime-integrated key loader (inline/path) with environment profile safety.
- **Decision journal prompts**:
  - Why strict stage/prod validation behavior?
  - Alternative: allow permissive fallback for convenience; rejected for security posture.
- **Proof**: key-loading matrix and invalid-input tests.

### Day 31 — JWT Claim Validation Engine
- **Teaching focus**: token validation logic and deny-by-default semantics.
- **Build story**: signer/verifier for issuer/audience/type/timing claims.
- **Decision journal prompts**:
  - Why enforce strict claim vocabulary?
  - Alternative: partial claim checks; rejected for auth drift risk.
- **Proof**: claim allow/deny matrix tests.

### Day 32 — Owner Auth Service
- **Teaching focus**: credential verification and failure mapping.
- **Build story**: owner auth primitives and canonical 401/422 semantics.
- **Decision journal prompts**:
  - Why map auth failures with stable detail-codes?
  - Alternative: generic login failure only; rejected for diagnostics quality.
- **Proof**: owner auth unit + contract-shape tests.

### Day 33 — Key Auth Service
- **Teaching focus**: actor-specific authentication pathways.
- **Build story**: key login service with lifecycle state checks.
- **Decision journal prompts**:
  - Why lifecycle checks inside auth path?
  - Alternative: defer to later policy layer only; rejected for early deny efficiency/safety.
- **Proof**: lifecycle-path auth tests.

### Day 34 — Refresh Rotation + Replay Invalidation
- **Teaching focus**: abuse-resistant refresh flows.
- **Build story**: refresh rotation transaction and replay deny behavior.
- **Decision journal prompts**:
  - Why invalidate family on replay?
  - Alternative: ignore second refresh as no-op; rejected for active abuse detection.
- **Proof**: first-pass/second-deny replay tests.

### Day 35 — Shared Lifecycle Resolver
- **Teaching focus**: centralizing cross-cutting policy checks.
- **Build story**: reusable lifecycle status resolver for auth guards/services.
- **Decision journal prompts**:
  - Why central resolver instead of route-local checks?
  - Alternative: duplicate checks in each handler; rejected due to inconsistency risk.
- **Proof**: lifecycle resolver status-path tests.

### Day 36 — Public Surface Routes
- **Teaching focus**: unauthenticated surfaces with consistent contracts.
- **Build story**: `/`, `/health` skeleton, JWKS, UI fallback baseline.
- **Decision journal prompts**:
  - Why enforce envelope/security behavior on public routes too?
  - Alternative: special-case public raw responses; rejected for parity drift.
- **Proof**: public route contract tests.

### Day 37 — Auth Route Family
- **Teaching focus**: auth API orchestration.
- **Build story**: owner signup/login, key-login, refresh route handlers with canonical errors.
- **Decision journal prompts**:
  - Why contract tests for negative paths first?
  - Alternative: add negative paths later; rejected due to security-critical behavior.
- **Proof**: auth route contract report.

### Day 38 — Permission Allow-list Evaluator
- **Teaching focus**: explicit authorization vocabularies.
- **Build story**: permission evaluator (`posts:read`, etc.) rejecting unknown strings.
- **Decision journal prompts**:
  - Why reject unknown permission strings?
  - Alternative: tolerate unknown for forward-compat; rejected due to hidden privilege ambiguity.
- **Proof**: allow/deny/unknown permission tests.

### Day 39 — Delegation Issuance Validator
- **Teaching focus**: bounded delegation algorithms.
- **Build story**: enforce subset/depth/expiry constraints from decision tables.
- **Decision journal prompts**:
  - Why strict subset enforcement?
  - Alternative: inherited broad permissions then filter in handlers; rejected for escalation risk.
- **Proof**: over-scope/over-depth/no-expiry conformance tests.

### Day 40 — Key-Class Mint Authority
- **Teaching focus**: role-based issuance boundaries.
- **Build story**: mint-authority matrix for owner/primary/secondary/use/keychain actors.
- **Decision journal prompts**:
  - Why matrix-driven issuance policy?
  - Alternative: nested if/else policy code; rejected for QA transparency concerns.
- **Proof**: mint authority matrix evidence.

### Day 41 — Keychain Admission Policy
- **Teaching focus**: membership policy safeguards.
- **Build story**: no-nesting, class checks, size cap, active-member constraints.
- **Decision journal prompts**:
  - Why ban nested keychains in v1?
  - Alternative: allow recursive chains; rejected for complexity and risk.
- **Proof**: admission rule conformance tests.

### Day 42 — Effective Resolution Engine
- **Teaching focus**: merging permissions/scopes deterministically.
- **Build story**: union/intersection rules + envelope constrain + inactive exclusion.
- **Decision journal prompts**:
  - Why separate positive union and restrictive intersections?
  - Alternative: global union only; rejected for restrictive-scope correctness.
- **Proof**: deterministic resolution proof pack.

### Day 43 — Lifecycle Authority Evaluator + Audit Events
- **Teaching focus**: who can change lifecycle state and why.
- **Build story**: action authority rules with auditable policy decisions.
- **Decision journal prompts**:
  - Why emit audit events for policy decisions?
  - Alternative: rely on route logs only; rejected for forensic completeness.
- **Proof**: authority conformance + event assertion tests.

### Day 44 — Surface Auth Guards Integration
- **Teaching focus**: policy enforcement at route-surface boundaries.
- **Build story**: owner console guard + key/device gateway guard integration.
- **Decision journal prompts**:
  - Why enforce token type/audience/surface binding before handlers?
  - Alternative: parse in handler; rejected for boundary leak risk.
- **Proof**: integration tests for 401/403/422/429 by surface.

### Day 45 — M2 Milestone Closeout
- **Teaching focus**: milestone closure and safe handoff mechanics.
- **Build story**: stabilize M2 baseline, full suite run, evidence package, M3 entry declaration.
- **Decision journal prompts**:
  - Why require explicit “no unresolved policy ambiguities” confirmation?
  - Alternative: carry ambiguities into next milestone; rejected for compounding risk.
- **Proof**: M2 closeout dossier.

---

## M2→M3 Gate Narrative Episodes

### Gate Episode A — Data Foundation Integrity
- **Narrative objective**: verify migration + seed system is deterministic and safe.
- **Must show**:
  - migration/seed smoke success,
  - schema invariants for principals/delegation/keychain/content domains,
  - replay-safe seed behavior.
- **Teaching angle**: a stable data foundation enables predictable feature development.

### Gate Episode B — AuthN Core Reliability
- **Narrative objective**: verify JWT/auth/refresh/lifecycle checks are complete and abuse-resistant.
- **Must show**:
  - key loader and claim validation,
  - owner/key auth route behavior,
  - refresh replay denial evidence.
- **Teaching angle**: robust auth is a sequence of small, testable constraints.

### Gate Episode C — AuthZ Policy Conformance
- **Narrative objective**: verify delegation/mint/keychain/lifecycle decision-table compliance.
- **Must show**:
  - issuance bounds tests,
  - mint authority matrix tests,
  - keychain admission/resolution tests,
  - lifecycle authority outcomes.
- **Teaching angle**: table-driven policy turns complex rules into teachable, verifiable logic.

### Gate Episode D — Surface Guard + Contract Readiness
- **Narrative objective**: verify public/auth routes and surface guards are integration-ready for M3 domain routes.
- **Must show**:
  - public/auth route contract pass,
  - console/gateway guard integration pass,
  - M2 evidence completeness and entry checklist signoff.
- **Teaching angle**: feature velocity depends on trusted contracts and guardrails.

---

## Recurring segment: “Alternatives we considered”
Use this structure in every episode:
1. Option selected.
2. 1–2 alternatives considered.
3. Why alternatives were rejected (security, contract drift, complexity, operability, or teaching clarity).
4. What SSOT/governance updates would be required to revisit them.

## Recurring segment: “CRE8 Engine → XtraType Handoff”
Close each episode with a single bridge sentence showing how the day’s M2 work helps future app-specific development.
Examples:
- Day 24 token family integrity -> safer long-lived sessions for annotation workflows.
- Day 38 permission allow-list -> clear capability modeling for XtraType roles.
- Day 42 effective scope resolution -> predictable collaborative annotation boundaries.

## Instructor prep checklist (before recording each M2 episode)
- Re-read the specific day row in `docs/M2_DAY_22_45_DETAILED_SLICES.md`.
- Pick one beginner concept and one advanced concept for the day.
- Pre-select one rejected alternative and clear rationale.
- Pre-run day proof commands and gather artifacts/screens.
- Prepare one “why CRE8 users should care” explanation.
- Prepare one “how this helps XtraType extension” explanation.
