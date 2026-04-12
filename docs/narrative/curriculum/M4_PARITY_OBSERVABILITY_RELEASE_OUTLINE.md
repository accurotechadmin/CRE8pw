# M4 Narrative Curriculum Outline: Parity Hardening + Observability + Rehearsals + Readiness Gates + Final Handoff (Day 70–90)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
Translate M4 delivery slices into episode-ready teaching narratives that complete the three end goals:
1. demonstrate that programming is accessible and learnable,
2. show the CRE8 build journey in a clear, easy-to-digest progression,
3. transition learners from understanding the CRE8 engine to extending it into production applications, with XtraType as the first exemplar handoff.

## Audience lanes (repeat each episode)
- **Beginner lane**: one key concept, one practical coding/ops takeaway, one plain-language summary.
- **Builder lane**: implementation details, contract parity, and system-quality constraints.
- **Operator lane**: SLO/readiness/incident implications and evidence requirements.

## Episode blueprint (repeat every day)
1. What we are hardening or validating today
2. Why it matters for production readiness
3. Implementation/rehearsal walkthrough
4. Decision journal (selected path + alternatives + rationale)
5. Proof walkthrough (tests/reports/evidence package parts)
6. User-facing translation
7. Bridge to XtraType handoff readiness

## M4 Daily Narrative Outlines

### Day 70 — Gateway UI Parity Baseline
- **Teaching focus**: parity verification as a software quality discipline.
- **Build story**: validate gateway UI parity for feed/posts/comments route-state coverage.
- **Decision journal prompts**:
  - Why establish parity baseline before optimization?
  - Alternative: jump directly to performance/readiness work; rejected due to unknown parity gaps.
- **Proof**: UI-gateway parity report + tracked gaps.

### Day 71 — Console UI Parity Baseline
- **Teaching focus**: governance UX alignment with backend policy behavior.
- **Build story**: verify console parity for posts/moderation/invites/key operations.
- **Decision journal prompts**:
  - Why tie diagnostics visibility directly to CSRF/auth guard behavior?
  - Alternative: hide low-level errors from UI; rejected for supportability.
- **Proof**: UI-console parity report + diagnostics captures.

### Day 72 — Keychain UX Parity
- **Teaching focus**: translating complex auth models into understandable user flows.
- **Build story**: parity for keychain create/mutate/resolve workflows.
- **Decision journal prompts**:
  - Why enforce policy invariants in UI-driven mutation testing?
  - Alternative: assume backend checks are sufficient; rejected for end-to-end confidence gaps.
- **Proof**: keychain UI parity checklist + tests.

### Day 73 — Error UX Hardening
- **Teaching focus**: failure handling as first-class product design.
- **Build story**: map 401/403/404/422/429/500 paths to deterministic UX with request_id visibility.
- **Decision journal prompts**:
  - Why preserve request_id in user-facing diagnostics?
  - Alternative: internal-only request_id; rejected for slower support triage.
- **Proof**: error UX acceptance report + request_id evidence.

### Day 74 — Event Coverage Finalization
- **Teaching focus**: observability event design and traceability.
- **Build story**: finalize event family emissions across route families and lifecycle actions.
- **Decision journal prompts**:
  - Why enforce correlation/redaction checks at event level?
  - Alternative: rely on log ingestion transforms; rejected for late-stage risk.
- **Proof**: event coverage matrix + trace bundle.

### Day 75 — SLI Metric Wiring Verification
- **Teaching focus**: metrics that matter for reliability.
- **Build story**: verify availability/latency/health/error-budget metric emissions and queryability.
- **Decision journal prompts**:
  - Why include route/surface/status dimensions?
  - Alternative: coarse global metrics only; rejected for weak diagnostics.
- **Proof**: metrics validation report + dashboard snapshots.

### Day 76 — Alerting and Escalation Validation
- **Teaching focus**: actionable alerts vs noisy alerts.
- **Build story**: configure and validate alert thresholds/routing and triage utility.
- **Decision journal prompts**:
  - Why test alert simulations before release?
  - Alternative: defer to live incidents; rejected for avoidable pager chaos.
- **Proof**: alert simulation records + routing proof.

### Day 77 — Performance Hardening Cycle
- **Teaching focus**: performance tuning under policy/contract constraints.
- **Build story**: tune auth/feed p95 paths without introducing regressions.
- **Decision journal prompts**:
  - Why run security/contract regression after perf tuning?
  - Alternative: perf-only validation; rejected for quality regressions.
- **Proof**: benchmark deltas + regression checks.

### Day 78 — Health Failure-Injection Validation
- **Teaching focus**: resilience engineering and degraded semantics.
- **Build story**: dependency failure-injection for db/limiter/key/dependency probes.
- **Decision journal prompts**:
  - Why validate degraded state diagnostics explicitly?
  - Alternative: test only healthy state; rejected for incident unpreparedness.
- **Proof**: failure-injection report + health contract evidence.

### Day 79 — `ops:health-smoke` Automation
- **Teaching focus**: release gates as executable checks.
- **Build story**: finalize health smoke command and CI policy integration.
- **Decision journal prompts**:
  - Why fail-closed behavior in smoke automation?
  - Alternative: warning-only smoke failures; rejected for gate integrity.
- **Proof**: CI artifact for health smoke checks.

### Day 80 — `ops:migrate-smoke` Automation
- **Teaching focus**: migration safety verification in CI.
- **Build story**: finalize migration smoke behavior and reviewer visibility.
- **Decision journal prompts**:
  - Why treat migration smoke as release-gating evidence?
  - Alternative: rely on one-time pre-release manual migration test; rejected for consistency risk.
- **Proof**: migration smoke CI artifact + verification logs.

### Day 81 — Startup Evidence Retention Hardening
- **Teaching focus**: operational evidence lifecycle.
- **Build story**: strengthen startup evidence generation and archival format/retention checks.
- **Decision journal prompts**:
  - Why archive startup evidence beyond local logs?
  - Alternative: ephemeral logs only; rejected for audit/history gaps.
- **Proof**: startup evidence samples + retention checklist.

### Day 82 — Key Rotation Rehearsal
- **Teaching focus**: cryptographic operational continuity.
- **Build story**: execute key rotation rehearsal and validate JWKS overlap continuity.
- **Decision journal prompts**:
  - Why rehearsal before production rotation?
  - Alternative: first rotation in production; rejected for outage risk.
- **Proof**: rotation dossier + continuity evidence.

### Day 83 — Rollback Rehearsal
- **Teaching focus**: recoverability and safe failure handling.
- **Build story**: rollback drill for app/data restoration with policy/security post-checks.
- **Decision journal prompts**:
  - Why validate security invariants post-rollback?
  - Alternative: functional restore check only; rejected for hidden policy drift.
- **Proof**: rollback dossier + restore verification checks.

### Day 84 — Full-Suite Pre-Gate Run
- **Teaching focus**: integrated quality confidence.
- **Build story**: execute full contract/security/abuse/integration/frontend parity suites.
- **Decision journal prompts**:
  - Why insist on full-suite before gate review?
  - Alternative: sample smoke only; rejected for release uncertainty.
- **Proof**: full-suite report + issue ledger.

### Day 85 — Acceptance Matrix Signoff
- **Teaching focus**: acceptance criteria as release control.
- **Build story**: verify changed behavior against acceptance matrix with request_id-backed triage.
- **Decision journal prompts**:
  - Why combine automated and manual acceptance walkthroughs?
  - Alternative: automation-only signoff; rejected for UX parity blind spots.
- **Proof**: acceptance signoff package + failure notes.

### Day 86 — Traceability Closeout
- **Teaching focus**: docs-to-code-to-tests integrity.
- **Build story**: finalize traceability matrix with ownership signoffs.
- **Decision journal prompts**:
  - Why require final traceability diff before release?
  - Alternative: post-release docs reconciliation; rejected for governance drift.
- **Proof**: traceability final diff + signoffs.

### Day 87 — Governance Artifact Closeout
- **Teaching focus**: decisions, risks, and gaps as living control systems.
- **Build story**: finalize ADR/decision log updates, re-score risk register, close/open gaps.
- **Decision journal prompts**:
  - Why update risk/decisions before handoff?
  - Alternative: defer governance updates to later maintenance; rejected for knowledge loss.
- **Proof**: ADR/risk/gap closeout bundle.

### Day 88 — Release Evidence Assembly
- **Teaching focus**: evidence-driven delivery.
- **Build story**: assemble release checklist and evidence template with required proofs.
- **Decision journal prompts**:
  - Why build evidence package before final gate meeting?
  - Alternative: compile during gate review; rejected for review inefficiency.
- **Proof**: draft release evidence package.

### Day 89 — Formal Gate Review (A/B/C/D)
- **Teaching focus**: go/no-go governance mechanics.
- **Build story**: execute readiness gate review, resolve blockers, document outcomes.
- **Decision journal prompts**:
  - Why allow release to remain blocked if criteria fail?
  - Alternative: conditional launch with unresolved blockers; rejected for reliability trust.
- **Proof**: gate report + remediation closure log.

### Day 90 — Final Handoff Ceremony
- **Teaching focus**: operational transfer and continuity.
- **Build story**: finalize release-candidate tag, runbooks, support paths, and ownership handoff.
- **Decision journal prompts**:
  - Why include post-handoff escalation path validation?
  - Alternative: handoff document only; rejected for operational ambiguity.
- **Proof**: final handoff dossier.

---

## M4 Final Readiness + Handoff Gate Narrative Episodes

### Gate Episode A — Parity and UX Reliability Completion
- **Narrative objective**: verify UI parity completion across gateway/console/keychain/error-state flows.
- **Must show**:
  - parity reports for core surfaces,
  - error-state diagnostics consistency,
  - request_id support visibility.
- **Teaching angle**: parity is what turns backend correctness into user trust.

### Gate Episode B — Observability and SLO Operationalization
- **Narrative objective**: verify events, metrics, dashboards, and alert routing are operationally usable.
- **Must show**:
  - event coverage and redaction compliance,
  - SLI/SLO metric availability,
  - alert simulation and escalation outcomes.
- **Teaching angle**: production confidence is measured, not assumed.

### Gate Episode C — Rehearsal and Smoke Integrity
- **Narrative objective**: verify health/migration smoke and key rotation/rollback rehearsals are proven.
- **Must show**:
  - smoke CI artifacts,
  - rotation and rollback rehearsal dossiers,
  - post-rehearsal integrity confirmations.
- **Teaching angle**: rehearsals convert “we think” into “we proved.”

### Gate Episode D — Release Gates + Final Handoff Completion
- **Narrative objective**: verify A/B/C/D readiness gates, release evidence completeness, and ownership transfer.
- **Must show**:
  - final gate pass report,
  - completed release evidence package,
  - final handoff signoffs and escalation mapping.
- **Teaching angle**: successful software delivery includes sustainable ownership transfer.

---

## Recurring segment: “Alternatives we considered”
Use this structure in every episode:
1. Option selected.
2. 1–2 alternatives considered.
3. Why alternatives were rejected (risk, complexity, drift, operability, or instructional clarity).
4. What SSOT/governance changes would be needed to revisit them.

## Recurring segment: “CRE8 Engine → XtraType Handoff”
Close each episode with one bridge sentence that ties the day’s M4 readiness work to the final XtraType handoff path.
Examples:
- Day 75 SLI wiring -> reliable annotation experience metrics for XtraType.
- Day 82 rotation rehearsal -> safer key operations for production annotation tenants.
- Day 90 ownership handoff -> template for moving from CRE8 engine to XtraType application ops.

## Instructor prep checklist (before recording each M4 episode)
- Re-read the day row in `docs/M4_DAY_70_90_DETAILED_SLICES.md`.
- Pick one beginner and one advanced takeaway.
- Prepare at least one rejected alternative and rationale.
- Pre-run proof commands and gather artifacts/screens for the episode.
- Prepare one “why CRE8 users care” explanation.
- Prepare one “how this completes XtraType handoff readiness” explanation.
