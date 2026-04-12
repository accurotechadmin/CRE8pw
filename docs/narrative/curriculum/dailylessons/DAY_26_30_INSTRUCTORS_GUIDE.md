# CRE8 Instructor Guide (Days 26–30)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence and covers Days 26–30 of M2.

These lessons continue the three core curriculum objectives:
1. teach programming in practical, beginner-friendly steps,
2. teach how CRE8 is built through explicit architecture/data/security decisions,
3. teach how CRE8 foundations support extension and handoff to **XtraType**.

## Instruction contract for every lesson (Days 26–30)
- Teach lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Demonstrate at least one **negative/failure path** behavior.
- End with one **proof artifact** and one **XtraType bridge** statement.
- Tie each lesson to M2 readiness and later domain route implementation.

---

## Day 26 — Keychain Membership and Effective Snapshot Schema

## Day target
Teach keychain data modeling for safe authority aggregation and deterministic effective-state persistence.

## Components and sub-components covered
- **Data plane**
  - `keychain_memberships` schema (active/removed, uniqueness, references)
  - `keychain_effective_snapshots` schema (effective permissions/scope persistence)
- **Policy plane**
  - no-nesting, class constraints, membership-size assumptions
  - snapshot recomputation expectations after mutation
- **Quality plane**
  - schema invariants and transition-path tests

## Lesson objectives
- **Programming objective:** learners can explain relational patterns for membership + derived-state snapshots.
- **How CRE8 is made objective:** learners can describe why keychains are modeled as production-active v1 principals.
- **Extension/XtraType objective:** learners can explain how safe keychain aggregation enables controlled app-level delegation patterns.

## 80-minute teaching script
1. **(0–10 min)** Setup: from delegation envelopes (Day 25) to grouped authority.
2. **(10–26 min)** Beginner lane: “team permissions board + computed summary” analogy.
3. **(26–56 min)** Builder lane: table fields, active uniqueness, snapshot semantics, mutation coupling.
4. **(56–66 min)** Operator lane: risks from stale/ambiguous effective state.
5. **(66–73 min)** Decision journal: on-demand compute only vs persisted effective snapshots.
6. **(73–78 min)** Proof walkthrough: keychain schema conformance tests.
7. **(78–80 min)** XtraType bridge: group-role safety for extension workflows relies on these invariants.

## Instructor notes
- Show one membership add/remove sequence and expected snapshot update.
- Tie table-level constraints to later policy decision tables.

## Checks for understanding
- Why store effective snapshots rather than compute every request?
- What does active membership uniqueness prevent?

## Required class artifacts
- keychain schema relationship diagram
- membership invariant checklist
- snapshot conformance test output

## Teacher caution points
- Don’t allow nested-keychain examples as valid v1 behavior.
- Avoid vague “eventual consistency” claims without explicit policy.

---

## Day 27 — Content Domain Tables (`posts`, `post_revisions`, `post_flags`, `comments`)

## Day target
Teach content-domain schema design for mutable records with revision history and moderation intake surfaces.

## Components and sub-components covered
- **Data plane**
  - posts table and lifecycle/state fields
  - post revision ledger design
  - post flags intake records
  - comments lifecycle fields and ordering indexes
- **Policy/contract plane**
  - state and visibility implications for upcoming route behavior
- **Quality plane**
  - migration + integrity checks for content schema

## Lesson objectives
- **Programming objective:** learners can explain transactional content modeling with history preservation.
- **How CRE8 is made objective:** learners can describe why revisions and flags are first-class tables.
- **Extension/XtraType objective:** learners can explain how app-level content features depend on stable content/audit structures.

## 80-minute teaching script
1. **(0–10 min)** Setup: transition from auth-core schema to content domain.
2. **(10–26 min)** Beginner lane: “draft, publish, revise” lifecycle analogy.
3. **(26–56 min)** Builder lane: posts/comments tables, revision ledger, flag records, indexing choices.
4. **(56–66 min)** Operator lane: investigation value of revision/flag trails.
5. **(66–73 min)** Decision journal: overwrite-in-place vs revision-preserving design.
6. **(73–78 min)** Proof walkthrough: content migration verification outputs.
7. **(78–80 min)** XtraType bridge: future content extensions inherit safer lifecycle and audit primitives.

## Instructor notes
- Contrast “single mutable row only” with revision-history approach.
- Show one query pattern enabled by indexes.

## Checks for understanding
- Why keep revision history separate from current post state?
- What operational question can be answered by flag records?

## Required class artifacts
- content table map
- lifecycle state checklist
- migration/integrity outputs

## Teacher caution points
- Don’t treat content history as optional in governance-driven systems.
- Avoid unbounded free-form states without enumerated constraints.

---

## Day 28 — Moderation Actions + Invite Receipts Schema

## Day target
Teach governance action persistence and invitation lifecycle tracking for controlled onboarding and moderation auditability.

## Components and sub-components covered
- **Data plane**
  - `moderation_actions` table design
  - `invite_receipts` table design
- **Governance/security plane**
  - action attribution and reason codes
  - invite expiry/usage integrity expectations
- **Quality plane**
  - FK/constraint verification for moderation/invite paths

## Lesson objectives
- **Programming objective:** learners can explain event-ledger style table design for governance actions.
- **How CRE8 is made objective:** learners can describe why moderation and invites need dedicated persistence surfaces.
- **Extension/XtraType objective:** learners can explain how extension onboarding/moderation features depend on auditable core records.

## 75-minute teaching script
1. **(0–8 min)** Setup: completing M2 schema surfaces for governance flows.
2. **(8–24 min)** Beginner lane: “official action log + expiring invitation ticket” analogy.
3. **(24–50 min)** Builder lane: schema fields, actor attribution, expiry semantics, constraint wiring.
4. **(50–60 min)** Operator lane: accountability risks without dedicated ledgers.
5. **(60–67 min)** Decision journal: embed moderation/invite metadata in content tables vs dedicated ledgers.
6. **(67–73 min)** Proof walkthrough: moderation/invite schema validation tests.
7. **(73–75 min)** XtraType bridge: app governance features rely on trustworthy core ledgers.

## Instructor notes
- Use one moderation event and one invite lifecycle example.
- Reinforce actor/reason/timestamp triad for auditability.

## Checks for understanding
- Why keep moderation actions in their own table?
- What misuse scenario is reduced by invite expiry enforcement?

## Required class artifacts
- moderation/invite schema map
- lifecycle/expiry checklist
- schema verification outputs

## Teacher caution points
- Don’t reduce moderation persistence to a simple status toggle.
- Avoid invite models with no expiry/use tracking.

---

## Day 29 — Deterministic Seed Strategy and Fixture Packs

## Day target
Teach reproducible seed orchestration so environments can be recreated safely and consistently for development, testing, and onboarding.

## Components and sub-components covered
- **Data/quality plane**
  - seed orchestration flow
  - fixture pack taxonomy and ordering
  - idempotency expectations
- **Governance plane**
  - seed safety rules (no bypass of lifecycle/policy invariants)
- **Ops plane**
  - replayability and environment bootstrap reliability

## Lesson objectives
- **Programming objective:** learners can explain deterministic seed pipelines and idempotent data setup.
- **How CRE8 is made objective:** learners can describe why seed behavior must be policy-safe and repeatable.
- **Extension/XtraType objective:** learners can explain how deterministic seeds accelerate extension development and testing.

## 75-minute teaching script
1. **(0–8 min)** Setup: from schema completion to reproducible data initialization.
2. **(8–24 min)** Beginner lane: “starter kit that always assembles the same way” analogy.
3. **(24–50 min)** Builder lane: fixture layering, dependency ordering, idempotent safeguards.
4. **(50–60 min)** Operator lane: environment drift risks from non-deterministic seeding.
5. **(60–67 min)** Decision journal: ad hoc manual inserts vs deterministic seed orchestration.
6. **(67–73 min)** Proof walkthrough: idempotency and fixture consistency checks.
7. **(73–75 min)** XtraType bridge: stable fixture packs speed app-level experimentation.

## Instructor notes
- Demonstrate rerunning seed process and verifying unchanged expected state.
- Tie seed design to CI and onboarding workflows.

## Checks for understanding
- What makes a seed process idempotent?
- Why should seed data respect lifecycle and policy constraints?

## Required class artifacts
- seed pipeline diagram
- fixture taxonomy notes
- idempotency test output

## Teacher caution points
- Don’t present seed scripts as one-time throwaway tools.
- Avoid hidden ordering dependencies without documentation.

---

## Day 30 — JWT Key Loader Integration

## Day target
Teach integration of JWT key loading into runtime config and environment profiles with fail-closed safety behavior.

## Components and sub-components covered
- **Runtime/security plane**
  - JWT key loader integration (inline/path modes)
  - profile-specific hardening rules (stage/prod strictness)
- **Config plane**
  - typed config linkage for key source and validation
- **Quality plane**
  - invalid-input and profile matrix tests

## Lesson objectives
- **Programming objective:** learners can explain secure runtime key-loading integration patterns.
- **How CRE8 is made objective:** learners can describe why key loading is tightly coupled to env/profile safety checks.
- **Extension/XtraType objective:** learners can explain how secure key handling protects downstream auth flows for extension apps.

## 80-minute teaching script
1. **(0–10 min)** Setup: moving from schema core into auth-runtime enforcement.
2. **(10–26 min)** Beginner lane: “trusted key source validation before issuing badges” analogy.
3. **(26–56 min)** Builder lane: loader integration points, validation matrix, fail-closed behavior.
4. **(56–66 min)** Operator lane: profile misconfiguration and key-path risk implications.
5. **(66–73 min)** Decision journal: permissive fallback key loading vs strict profile-aware validation.
6. **(73–78 min)** Proof walkthrough: key-loading profile matrix outputs.
7. **(78–80 min)** XtraType bridge: secure platform auth primitives are prerequisites for protected app extensions.

## Instructor notes
- Compare local-dev flexibility with stage/prod strict safety.
- Link this lesson back to Day 6 key safety concepts, now in M2 runtime context.

## Checks for understanding
- Why should profile-specific rules alter key loading behavior?
- What failure should occur when key material is malformed or unsafe in production profile?

## Required class artifacts
- JWT key loader integration map
- profile safety matrix
- key-loading validation outputs

## Teacher caution points
- Don’t teach permissive production fallback behavior.
- Avoid examples that normalize weak key-path permission handling.

---

## Cross-day instructor notes (Days 26–30)

## Progression summary
- **Day 26:** implement keychain schema and effective-state persistence.
- **Day 27:** implement content domain schema with revision/flag/comment structures.
- **Day 28:** implement moderation and invite governance ledgers.
- **Day 29:** implement deterministic seeds and fixture packs.
- **Day 30:** integrate secure JWT key loader behavior.

## Weekly formative assessment prompts
1. Explain how Days 26–30 complete the schema foundation for upcoming auth and route implementation.
2. Describe one invariant from each day and the risk it prevents.
3. Compare ad hoc data practices with CRE8’s deterministic migration+seed model.
4. Predict how Days 26–30 prepare claims validation/auth service work in Days 31–35.

## Instructor handoff packet (end of Day 30)
Collect and archive:
- keychain schema and snapshot evidence,
- content domain migration/integrity outputs,
- moderation/invite schema validation outputs,
- seed idempotency/fixture consistency outputs,
- JWT key loader profile matrix evidence,
- decision journal entries with rejected alternatives,
- one-page bridge memo: “How Days 26–30 prepare Days 31–35.”

## Bridge forward (preview to Days 31–35)
Tell learners what comes next:
- JWT claim validation engine,
- owner auth service,
- key auth service,
- refresh rotation + replay invalidation,
- shared lifecycle status resolver.

This maintains continuity from schema completeness into runtime auth and policy-core implementation.
