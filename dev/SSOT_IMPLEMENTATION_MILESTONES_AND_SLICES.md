# CRE8 SSOT implementation milestones & slices (execution SSOT for production build-out)

_Last updated (UTC): 2026-05-13_

## Why this roadmap exists

This is the **delivery execution plan** for turning the CRE8 SSOT corpus into a fully production-ready application.

It now also defines the **required coupling** with the seed-generating program so implementation work is continuously fed by mature, traceable, and contradiction-managed seed guidance.

This plan is **subordinate** to normative behavior in `docs/` and uses `seed/` + `seed-generating-docs/` as provenance, normalization, and pre-implementation design inputs.

## Source-of-truth precedence

1. `docs/` normative canon (binding).
2. `docs/31_machine_contracts/` machine artifacts and parity tables (binding for interfaces).
3. `seed-generating-docs/` control + seed corpus (advisory until promoted, but mandatory for seed-program process discipline).
4. `seed/` provenance and redesign intent (advisory unless promoted).
5. `reports/` execution evidence and continuity artifacts (informational unless promoted).

If sources disagree, follow `docs/` unless governance records an exception (ADR/decision path).

## Execution design principles

1. **Build thin verticals early**: every milestone must end in runnable, testable behavior.
2. **No hidden contract drift**: all route behavior goes through route-inventory ↔ OpenAPI ↔ schema ↔ tests parity.
3. **PDP is centralized**: handlers MUST consume authorization outcomes, not recompute them.
4. **Security is shift-left + shift-right**: controls are implemented early and continuously validated in runtime evidence.
5. **Evidence-driven release**: production promotion requires explicit RG evidence and trace closure.
6. **Seed-to-build continuity**: implementation decisions that rely on seed-derived guidance must be traceable back through seed-generating control artifacts.
7. **Parallel where safe**: observability, docs parity, and CI hardening run alongside feature lanes.

---

## Seed-program coupling contract (new mandatory overlay)

This section governs how this implementation roadmap consumes outcomes from the seed-generating mission.

### SC-1: Upstream seed readiness checks
Before beginning any milestone slice that introduces/changes behavior, confirm:
- relevant domain seed docs (10–19 family) exist and are materially authored,
- related terms are normalized in canonical vocabulary,
- unresolved contradictions are either non-blocking or explicitly waived.

### SC-2: Traceability handshake
For behavior-changing slices, maintain a visible chain:
`implementation requirement -> docs requirement/contract -> seed concept source -> preservation ledger row`.

### SC-3: Conflict propagation discipline
If implementation uncovers new contradictions:
- log in seed conflict register and implementation decision/risk artifacts,
- avoid silent local interpretation in code/tests without recorded rationale.

### SC-4: Promotion readiness signal
Before milestone-level “done” status on contract-heavy milestones (M5, M7, M8, M9, M10), confirm whether impacted seed guidance is ready for promotion to normative docs or still advisory.

### SC-5: Session continuity parity
Every implementation session touching coupled slices must update continuity artifacts so a follow-on session can identify:
- what seed artifacts were relied on,
- whether reliance was blocked by unresolved seed gaps,
- which next seed slices should be prioritized.

---

## Milestone topology (critical path + parallel lanes)

### Critical path (must complete in order)
`M0 -> M1 -> M2 -> M3 -> M4 -> M6 -> M7 -> M5 -> M8 -> M9 -> M11 -> M10`

### Parallel lanes (can start earlier with dependency checks)
- `M5` may start after stable route skeleton from M3 and mature during M7/M8.
- `M6b` runs from M6 onward and must be complete before M10.
- `M12` starts after first end-to-end authz route families in M8 and closes before M10.
- **Seed lane alignment:** seed milestones M1–M7 (from `dev/SEED_GENERATING_MILESTONES_AND_SLICES.md`) should be kept at least one batch ahead of implementation milestones M5+.

### Why this is better than a simple linear plan
- preserves hard dependency safety for identity, authz, and contracts,
- shortens time-to-feedback by letting parity/security/observability run in parallel,
- avoids big-bang integration near release,
- ensures implementation is informed by mature seed artifacts rather than ad hoc interpretation.

---

## Hard gates (non-negotiable)

### Gate G0 — Program boot
Required before implementation velocity work:
- governance conventions adopted,
- trace and hook discipline active,
- CI commands runnable locally and in pipeline,
- seed-program coupling checks SC-1..SC-2 understood by team.

### Gate G1 — Architecture lock
Required before broad endpoint expansion:
- middleware ordering fixed,
- envelope/error middleware stable,
- no handler-level PDP recomputation,
- architecture-related seed guidance mapped to implementation assumptions.

### Gate G2 — Contract lock
Required before branch promotion for API families:
- route inventory parity,
- OpenAPI lint/pass,
- schema closure and example validation pass,
- seed-derived contract decisions trace-linked or promoted.

### Gate G3 — Security lock
Required before production-candidate cut:
- crypto lifecycle behavior verified,
- threat/control and abuse-case coverage implemented,
- security headers and deny semantics verified,
- security seed guidance and unresolved conflicts reviewed for blockers.

### Gate G4 — Release lock
Required before production launch:
- operational gates (RG-01..RG-05) complete,
- traceability closure at required threshold,
- decisions/risks/evidence artifacts complete and link-valid,
- seed-program artifacts demonstrate no unresolved critical ambiguity impacting released behavior.

---

## Milestones and slices

Each milestone includes: objective, dependencies, required outputs, and verifications.

## M0 — Canon onboarding and operational readiness

**Objective:** Ensure every engineer can execute using SSOT precedence and mandatory toolchain.

**Dependencies:** none.

**Slices:**
- **S0.1** Read-path completion (`README`, governance index, core architecture docs, seed index/preservation matrix).
- **S0.2** Local verification rehearsal (`composer validate --strict`, `docs:ssot:*` baseline suite).
- **S0.3** Team operating contract (ownership, review lanes, handoff/reporting rules).
- **S0.4** Seed-coupling onboarding (SC-1..SC-5 walkthrough).

**Outputs:** onboarding checklist, team-read confirmation, command baseline snapshot, coupling-readiness note.

**Verification:** `composer validate --strict`, `composer docs:ssot:lint`, `composer docs:ssot:sync-check`, `composer docs:ssot:report`.

## M1 — Governance, change control, and reference hygiene

**Objective:** Prevent uncontrolled scope drift before feature growth.

**Dependencies:** M0.

**Slices:**
- **S1.1** PR change-class rubric enforced.
- **S1.2** Template/metadata/style conformance for normative edits.
- **S1.3** Mandatory reference update chain (`FILE_INVENTORY` → `master_index` → local indexes).
- **S1.4** Change-impact map requirement for contract/security behavior changes.
- **S1.5** Seed-dependency declaration in PR/session artifacts when relevant.

**Outputs:** governance checklist embedded in contribution flow; no orphan docs/paths; explicit seed dependency signaling.

**Verification:** `composer docs:ssot:lint`, `composer docs:ssot:sync-check`.

## M2 — Verification backbone and CI enforceability

**Objective:** Make verification mandatory, deterministic, and branch-gating.

**Dependencies:** M1.

**Slices:**
- **S2.1** Requirement ↔ hook ↔ evidence trace conventions active.
- **S2.2** Composer command registry complete for active checks.
- **S2.3** Acceptance-bundle baseline and failure classification discipline.
- **S2.4** CI gate policy for SSOT + contracts + smoke suites.
- **S2.5** Seed-coupling trace check integrated into review/CI checklist.

**Outputs:** reliable pre-merge gate; known pass/fail taxonomy (introduced/pre-existing/environment); coupling-trace visibility.

**Verification:** `composer phase2:acceptance-bundle` and/or `composer phase3:final-acceptance-bundle` as available.

## M3 — Runtime architecture spine

**Objective:** Establish composition root, module boundaries, middleware order, and surface topology.

**Dependencies:** M2.

**Slices:**
- **S3.1** DI/module boundaries aligned with baseline architecture.
- **S3.2** Request pipeline contract implemented end-to-end.
- **S3.3** Envelope/error normalization and correlation semantics.
- **S3.4** Canon terminology enforcement across runtime and docs parity points.
- **S3.5** Architecture assumptions cross-checked against seed architecture/domain seeds.

**Outputs:** stable platform skeleton for all downstream route families.

**Verification:** auth contract ordering tests, route uniqueness/parity prechecks.

## M4 — Data plane and migration discipline

**Objective:** Implement schema/model truth with forward-only migration safety.

**Dependencies:** M3.

**Slices:**
- **S4.1** Data model entities, constraints, and relationships.
- **S4.2** Classification/sensitivity handling and storage guardrails.
- **S4.3** Environment-aware seed/migration strategy and rollback posture.
- **S4.4** Data assumptions reconciled with seed data/workflow guidance.

**Outputs:** migration-safe, testable persistence layer aligned to ERD/specs.

**Verification:** migration smoke + data-model coverage checks.

## M5 — Machine contract substrate (parallel-capable after M3)

**Objective:** Keep implementation in lockstep with route inventory, OpenAPI, schemas, and examples.

**Dependencies:** M3 (start), M7/M8 (completion hardening).

**Slices:**
- **S5.1** Route inventory ↔ OpenAPI operation parity.
- **S5.2** Schema closure and envelope compatibility.
- **S5.3** Example validity and negative-case coverage.
- **S5.4** Versioning/deprecation policy enforcement.
- **S5.5** Seed-to-contract mapping for each major route family.

**Outputs:** contract-first API surface with no undocumented behaviors.

**Verification:** `docs:ssot:route-parity`, `docs:ssot:openapi-lint`, `docs:ssot:schema-coverage`, example coverage checks.

## M6 — Cryptography and key lifecycle implementation

**Objective:** Operationalize crypto profile and lifecycle semantics in runtime.

**Dependencies:** M4.

**Slices:**
- **S6.1** Crypto primitives/profile compliance.
- **S6.2** Key issuance/suspend/revoke/rotate behavior and evidence.
- **S6.3** Transport security headers/CSP across surfaces.
- **S6.4** Crypto/lifecycle seed guidance reconciliation and decision capture.

**Outputs:** enforceable cryptographic trust and lifecycle guarantees.

**Verification:** lifecycle and issuance contract suites; security header integration tests.

## M6b — Security program lane (parallel from M6)

**Objective:** Convert threat model/control specs/abuse cases into executable security assurance.

**Dependencies:** M6.

**Slices:**
- **S6b.1** Threat-to-control mapping implementation.
- **S6b.2** Abuse-case regression suites.
- **S6b.3** Security observability/error linkage.
- **S6b.4** Seed conflict review for security-significant contradictions.

**Outputs:** measurable control efficacy and abuse resistance.

**Verification:** threat-control matrix checks, abuse regression tests, event/error parity checks.

## M7 — Identity, authorization, delegation, keychain core

**Objective:** Build deterministic PDP-driven permission system and delegation semantics.

**Dependencies:** M6 + M6b.

**Slices:**
- **S7.1** Principal taxonomy + permission vocabulary enforcement.
- **S7.2** Auth proof validation and route auth-model support.
- **S7.3** PDP seven-gate decision order and deny precedence.
- **S7.4** Keychain resolution semantics.
- **S7.5** Delegation state transitions and cascade behavior.
- **S7.6** Seed-auth guidance parity and unresolved-gap escalation.

**Outputs:** deterministic authorization core with testable reason codes.

**Verification:** auth/auth-reason suites; permission vocab and delegation consistency checks.

## M8 — HTTP API families and behavior completion

**Objective:** Deliver complete documented route behavior with deterministic envelopes and errors.

**Dependencies:** M7 + matured M5.

**Slices:**
- **S8.1** Authz + identity route families.
- **S8.2** Lifecycle route families.
- **S8.3** Feed and interaction route families.
- **S8.4** Error/redaction consistency across all families.
- **S8.5** UI/runtime parity obligations.
- **S8.6** Seed-to-API behavior parity audit (including examples).

**Outputs:** complete route surface ready for production qualification.

**Verification:** contract suites (`auth`, `identity-*`, `lifecycle`, `feed`, `error-*`, `surface-parity`).

## M9 — Content, audience, feed, and moderation determinism

**Objective:** Implement content model and feed logic consistent with audience and moderation rules.

**Dependencies:** M4 + M7 + M8 baseline.

**Slices:**
- **S9.1** Audience group lifecycle and access semantics.
- **S9.2** Content targeting and visibility states.
- **S9.3** Deterministic feed ranking/pagination/tie-break rules.
- **S9.4** Commenting/moderation/provenance/audit behavior.
- **S9.5** Seed behavioral assumptions validated against implemented outcomes.

**Outputs:** policy-consistent social/content plane with deterministic outputs.

**Verification:** feed and interaction contract/integration suites.

## M11 — Operations, observability, reliability, and release readiness

**Objective:** Make the platform operable, diagnosable, and production-releasable.

**Dependencies:** M3 start; closes after M8/M9.

**Slices:**
- **S11.1** Health/live/ready and boot-failure behavior.
- **S11.2** Configuration/environment and secret hygiene.
- **S11.3** Event catalog bootstrap on critical flows.
- **S11.4** Full observability completion (security + decision events).
- **S11.5** Smoke workflows, migration ops, and staged release rehearsal.
- **S11.6** SLO/SLI instrumentation and readiness gate evidence.
- **S11.7** Operational runbooks cross-checked against seed operations guidance.

**Outputs:** production operations baseline with measurable reliability posture.

**Verification:** ops smoke, event coverage checks, acceptance bundle, release checklist evidence.

## M12 — Extensibility and integrations

**Objective:** Enable safe extension/plugin/integration surfaces without violating core invariants.

**Dependencies:** M7 + M8.

**Slices:**
- **S12.1** Extension seam contracts and invariants.
- **S12.2** Post-type extension lifecycle and rollback.
- **S12.3** Principal-type extension obligations (matrix + delegation fixtures).
- **S12.4** Outbound integration provider guarantees.
- **S12.5** Inbound webhook verification/idempotency/schema enforcement.
- **S12.6** Seed extensibility constraints reconciled with implementation seams.

**Outputs:** controlled extensibility model fit for ecosystem growth.

**Verification:** extension validators, integration harnesses, invariant regression suites.

## M10 — Program lock, evidence closure, launch decision

**Objective:** Close traceability and governance so release is auditable and defensible.

**Dependencies:** completion of M6b, M9, M11, M12.

**Slices:**
- **S10.1** Seed-gap and promotion reconciliation.
- **S10.2** Traceability closure and untraced requirement resolution.
- **S10.3** ADR/decision/risk register finalization.
- **S10.4** Evidence bundle completion for release gates.
- **S10.5** Final acceptance run and launch sign-off packet.
- **S10.6** Seed-program maturity attestation for production-codebase transition.

**Outputs:** final production go/no-go packet with full trace and governance closure.

**Verification:** final acceptance bundle, SSOT report assertions, release checklist RG evidence.

---

## Definition of “production-ready complete” (must all be true)

1. All normative route behaviors are implemented and contract-tested.
2. No unresolved critical drift between prose contracts, OpenAPI, schemas, and examples.
3. Security controls and abuse-case regressions pass with observable evidence.
4. Operational health/startup/config/observability contracts are passing in deployment-like environment.
5. Traceability matrix closure meets enforced threshold and evidence references resolve.
6. Governance artifacts (ADR/decisions/risks/impact maps) are current and linked.
7. Release-gate artifacts (`RG-01..RG-05`) are complete and approved.
8. Seed-derived implementation assumptions are either promoted, explicitly waived, or closed as non-impacting.

---

## Suggested cadence and batching

- Execute in **2–5 slice batches**.
- Each batch must end with:
  - updated continuity artifacts,
  - verification command log,
  - explicit introduced/pre-existing/environment failure classification,
  - next-batch dependency statement,
  - seed-coupling delta summary (new dependencies, resolved gaps, remaining blockers).

Recommended batch shapes:
- **Foundation batch:** M0+M1+M2 thin closure.
- **Core runtime batch:** M3+M4+M6.
- **Auth core batch:** M6b+M7.
- **API closure batch:** M5+M8+M9.
- **Ops and launch batch:** M11+M12+M10.

---

## Change-management note

If this roadmap is changed, update in order:
1. `FILE_INVENTORY.md` (if file set changed),
2. `master_index.md`,
3. `dev/README.md` and any impacted local indexes,
4. continuity artifacts in `reports/` if sequencing or release expectations changed,
5. seed-program prompt/docs if coupling expectations changed.

Follow `REFERENCE_MAINTENANCE_SOP.md` for every structural/reference change.
