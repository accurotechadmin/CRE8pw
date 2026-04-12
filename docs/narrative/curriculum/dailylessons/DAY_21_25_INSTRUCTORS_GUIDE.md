# CRE8 Instructor Guide (Days 21–25)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence and covers Days 21–25, bridging M1 closeout into early M2 data/auth/policy implementation.

These five lessons continue the three curriculum objectives:
1. teach programming in accessible, practical steps,
2. teach exactly how CRE8 is built from governance through implementation,
3. teach how CRE8 foundations support extension and handoff to **XtraType**.

## Instruction contract for every lesson (Days 21–25)
- Teach lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Demonstrate at least one **negative/failure path** behavior.
- End with one **proof artifact** and one **XtraType bridge** statement.
- Tie each lesson to milestone readiness (M1 closeout and M2 progression).

---

## Day 21 — M1 Milestone Closeout and M2 Entry Readiness

## Day target
Teach formal milestone closure: evidence completeness, signoff discipline, and explicit entry criteria before moving into M2.

## Components and sub-components covered
- **Governance plane**
  - milestone closeout protocol
  - owner/reviewer signoff expectations
- **Traceability plane**
  - closeout traceability diff and completeness checks
- **Ops/readiness plane**
  - M1 evidence bundle finalization
  - M2 entry criteria verification

## Lesson objectives
- **Programming objective:** learners can explain why stabilization and closure are part of engineering, not admin overhead.
- **How CRE8 is made objective:** learners can describe what “done” means at milestone level in CRE8.
- **Extension/XtraType objective:** learners can explain how disciplined closure creates reliable handoff to extension teams.

## 75-minute teaching script
1. **(0–10 min)** Setup: what changes from Day 20 pre-close to Day 21 formal closeout.
2. **(10–24 min)** Beginner lane: “project checkpoint gate” analogy.
3. **(24–50 min)** Builder lane: closeout checklist, signoff payload, and entry gate criteria.
4. **(50–60 min)** Operator lane: risks of entering M2 with ambiguous closure.
5. **(60–67 min)** Decision journal: implicit progression vs explicit milestone gate.
6. **(67–73 min)** Proof walkthrough: M1 closeout artifact set.
7. **(73–75 min)** XtraType bridge: formal handoff habits scale to app-level delivery.

## Instructor notes
- Have learners classify one artifact as “required for closeout” vs “nice to have.”
- Reinforce that milestone boundaries reduce compounding technical risk.

## Checks for understanding
- Why is passing tests insufficient without evidence and signoff?
- Which M1 entry criteria must be true before starting M2?

## Required class artifacts
- M1 closeout checklist
- signoff matrix snapshot
- M2 entry gate confirmation notes

## Teacher caution points
- Do not treat closeout as optional ceremony.
- Avoid vague “looks good” handoffs with no artifact trail.

---

## Day 22 — Migration Runner Foundation

## Day target
Teach deterministic schema evolution workflows so all database changes are repeatable, reviewable, and safe.

## Components and sub-components covered
- **Data plane**
  - migration runner scaffold
  - migration naming/versioning conventions
- **Ops/quality plane**
  - migration safety prechecks
  - migration smoke baseline
- **Governance plane**
  - ownership and approval expectations for schema changes

## Lesson objectives
- **Programming objective:** learners can explain migration execution flow and idempotent design principles.
- **How CRE8 is made objective:** learners can describe why migration infrastructure comes before feature table implementation.
- **Extension/XtraType objective:** learners can explain how extension apps benefit from deterministic schema lifecycle controls.

## 80-minute teaching script
1. **(0–10 min)** Setup: M2 kickoff and why data foundations are first.
2. **(10–26 min)** Beginner lane: “versioned blueprint updates” analogy.
3. **(26–56 min)** Builder lane: migration runner architecture, command flow, and prechecks.
4. **(56–66 min)** Operator lane: rollback/recovery implications of unsafe migrations.
5. **(66–73 min)** Decision journal: manual SQL scripts vs migration framework.
6. **(73–78 min)** Proof walkthrough: migration smoke baseline output.
7. **(78–80 min)** XtraType bridge: predictable data evolution supports app-level continuity.

## Instructor notes
- Show how a migration runner supports repeatable onboarding/dev environments.
- Tie migration discipline to future release gates and smoke checks.

## Checks for understanding
- Why should migration safety checks happen before execution?
- What makes a migration workflow reproducible across environments?

## Required class artifacts
- migration runner flow diagram
- naming/versioning convention notes
- migration smoke baseline output

## Teacher caution points
- Avoid framing migrations as one-off scripts.
- Don’t skip failure-mode thinking (partial apply, ordering errors).

---

## Day 23 — Principals, Emails, Credentials Schema Core

## Day target
Teach identity-domain relational modeling and schema constraints that enforce principal and credential integrity.

## Components and sub-components covered
- **Data plane**
  - `principals` table (`owner|key`, key class constraints)
  - `principal_emails` uniqueness and linkage
  - `credentials` typing and lifecycle fields
- **Policy/security plane**
  - schema-level enforcement of identity domain invariants
- **Quality plane**
  - schema integrity tests (FK/index/constraint checks)

## Lesson objectives
- **Programming objective:** learners can explain core relational identity modeling and constraint strategy.
- **How CRE8 is made objective:** learners can describe why schema constraints complement application-level validation.
- **Extension/XtraType objective:** learners can explain why extension identity features depend on stable principal/credential primitives.

## 80-minute teaching script
1. **(0–10 min)** Setup: first domain schema in M2.
2. **(10–26 min)** Beginner lane: “identity card + credential ledger” analogy.
3. **(26–56 min)** Builder lane: table design, keys, indexes, and domain constraints.
4. **(56–66 min)** Operator lane: identity drift and auth errors from weak schema integrity.
5. **(66–73 min)** Decision journal: app-only checks vs dual-layer (app + schema) enforcement.
6. **(73–78 min)** Proof walkthrough: schema integrity test outputs.
7. **(78–80 min)** XtraType bridge: app-level onboarding/auth builds on this stable identity base.

## Instructor notes
- Ask learners to identify one invariant best enforced in schema and why.
- Clarify relationship between principal type and key class.

## Checks for understanding
- Why enforce identity constraints in DB and application layers?
- What failure does unique normalized email protection prevent?

## Required class artifacts
- ER-style identity table sketch
- constraint/index checklist
- integrity verification outputs

## Teacher caution points
- Don’t reduce identity modeling to “just users table.”
- Avoid skipping index rationale for high-frequency lookups.

---

## Day 24 — Token Families and Refresh Lifecycle Persistence

## Day target
Teach refresh-token family modeling for replay resistance and deterministic session lifecycle control.

## Components and sub-components covered
- **Data plane**
  - `token_families` schema and state columns
  - rotation/revocation persistence transitions
- **Security plane**
  - replay-protection model linkage
- **Quality plane**
  - transition tests for create/rotate/revoke/replay scenarios

## Lesson objectives
- **Programming objective:** learners can explain stateful token-family transitions and transactional update logic.
- **How CRE8 is made objective:** learners can describe why CRE8 uses family-based refresh controls.
- **Extension/XtraType objective:** learners can explain how replay-safe session management protects extension user sessions.

## 75-minute teaching script
1. **(0–8 min)** Setup: from identity records to session continuity/security.
2. **(8–24 min)** Beginner lane: “single active ticket chain” analogy.
3. **(24–50 min)** Builder lane: family state model, rotation flow, replay invalidation behavior.
4. **(50–60 min)** Operator lane: abuse patterns and session incident handling.
5. **(60–67 min)** Decision journal: stateless refresh model vs stateful token families.
6. **(67–73 min)** Proof walkthrough: token family transition test matrix.
7. **(73–75 min)** XtraType bridge: stronger session controls improve app trust and supportability.

## Instructor notes
- Show first-refresh success and replayed-refresh deny as paired examples.
- Reinforce that replay controls are a design requirement, not optional hardening.

## Checks for understanding
- Why is state tracking needed for refresh replay prevention?
- What should happen to family state when replay is detected?

## Required class artifacts
- token family lifecycle diagram
- transition test report
- replay scenario notes

## Teacher caution points
- Don’t oversimplify refresh logic to “issue new token and move on.”
- Avoid unclear state transition semantics.

---

## Day 25 — Delegation Envelopes Persistence and Invariants

## Day target
Teach delegation bounds as data invariants (subset/depth/expiry/lifecycle) and why lineage fields matter for policy correctness.

## Components and sub-components covered
- **Data plane**
  - `delegation_envelopes` schema
  - depth, status, expiry, lineage fields
- **Policy plane**
  - persistence support for delegation decision-table constraints
- **Quality plane**
  - tests for invalid depth/status and envelope-bound violations

## Lesson objectives
- **Programming objective:** learners can explain delegation data modeling and invariant-oriented schema design.
- **How CRE8 is made objective:** learners can describe why delegation constraints are encoded in storage and not only policy code.
- **Extension/XtraType objective:** learners can explain how bounded delegation enables safer app-level authorization extension.

## 80-minute teaching script
1. **(0–10 min)** Setup: from identity/session core to delegated authority.
2. **(10–26 min)** Beginner lane: “permission envelope nested inside parent envelope” analogy.
3. **(26–56 min)** Builder lane: schema columns, lineage semantics, invariant enforcement points.
4. **(56–66 min)** Operator lane: escalation risk from weak delegation data constraints.
5. **(66–73 min)** Decision journal: policy-only delegation checks vs schema + policy dual enforcement.
6. **(73–78 min)** Proof walkthrough: depth/status/invariant conformance tests.
7. **(78–80 min)** XtraType bridge: delegated app operations stay safe when lineage and bounds are preserved.

## Instructor notes
- Use one allowed and one over-scoped example to illustrate boundary logic.
- Tie schema fields directly to later decision-table checks.

## Checks for understanding
- Why track parent and initial-author lineage in delegation records?
- What practical risk appears if depth constraints are not enforced?

## Required class artifacts
- delegation envelope field map
- invariant checklist
- conformance test outputs

## Teacher caution points
- Don’t treat delegation as only a runtime concern.
- Avoid ambiguous examples where parent/child scope boundaries are unclear.

---

## Cross-day instructor notes (Days 21–25)

## Progression summary
- **Day 21:** complete M1 with formal evidence and signoff.
- **Day 22:** stand up migration infrastructure.
- **Day 23:** implement identity/credential schema core.
- **Day 24:** implement replay-safe token family persistence.
- **Day 25:** implement delegation envelope invariants.

## Weekly formative assessment prompts
1. Explain how formal milestone closure reduces risk at M1→M2 transition.
2. Describe how migrations, identity schema, token families, and delegation envelopes build a coherent auth foundation.
3. Compare policy-only enforcement vs schema + policy dual enforcement for security-critical domains.
4. Predict how Days 21–25 prepare keychain schema and content domain work in Days 26–30.

## Instructor handoff packet (end of Day 25)
Collect and archive:
- M1 closeout and M2 entry artifacts,
- migration runner and smoke evidence,
- principals/credentials schema integrity outputs,
- token family transition test outputs,
- delegation envelope conformance evidence,
- decision journal entries with rejected alternatives,
- one-page bridge memo: “How Days 21–25 prepare Days 26–30.”

## Bridge forward (preview to Days 26–30)
Tell learners what comes next:
- keychain memberships and effective snapshots schema,
- content tables (`posts`, `post_revisions`, `post_flags`, `comments`),
- moderation/invite schema,
- deterministic seed strategy,
- JWT key loader integration.

This keeps continuity from milestone transition into full M2 schema and auth foundation execution.
