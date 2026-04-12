# CRE8 Instructor Guide (Days 31–35)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence and covers Days 31–35 of M2.

These lessons continue the three core curriculum objectives:
1. teach programming in approachable, practical increments,
2. teach how CRE8 is built via explicit auth/security/runtime decisions,
3. teach how CRE8 foundations enable extension and handoff to **XtraType**.

## Instruction contract for every lesson (Days 31–35)
- Teach lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Demonstrate at least one **negative/failure path** behavior.
- End with one **proof artifact** and one **XtraType bridge** statement.
- Tie each lesson to M2 auth/policy-core readiness.

---

## Day 31 — JWT Claim Validation Engine

## Day target
Teach robust token claim validation (issuer/audience/type/timing) as a deterministic gate for all auth flows.

## Components and sub-components covered
- **Security/auth plane**
  - token signer/verifier foundations
  - claim validation matrix (issuer, audience, type, exp/nbf/iat timing)
- **Contract plane**
  - canonical accept/deny outcomes for claim violations
- **Quality plane**
  - allow/deny matrix tests for claim scenarios

## Lesson objectives
- **Programming objective:** learners can explain claim parsing/validation order and denial semantics.
- **How CRE8 is made objective:** learners can describe why strict claim vocabulary is required in CRE8.
- **Extension/XtraType objective:** learners can explain how stable token validation protects extension auth integrations.

## 80-minute teaching script
1. **(0–10 min)** Setup: from key loader integration (Day 30) to token trust evaluation.
2. **(10–26 min)** Beginner lane: “ticket checks at entry gate” analogy.
3. **(26–56 min)** Builder lane: claim checks, rejection paths, and deterministic outcomes.
4. **(56–66 min)** Operator lane: auth incidents caused by partial claim enforcement.
5. **(66–73 min)** Decision journal: permissive claim checks vs strict full matrix validation.
6. **(73–78 min)** Proof walkthrough: claim allow/deny test matrix.
7. **(78–80 min)** XtraType bridge: extension apps depend on predictable token gate behavior.

## Instructor notes
- Show one valid token and multiple invalid claim variants.
- Emphasize order of checks and clear deny reasons.

## Checks for understanding
- Why validate audience and token type separately?
- What operational risk appears with partial claim checking?

## Required class artifacts
- claim validation matrix sheet
- allow/deny test outputs
- claim failure mapping notes

## Teacher caution points
- Don’t blur “malformed token” and “policy denial” semantics.
- Avoid ad hoc exceptions that bypass claim engine.

---

## Day 32 — Owner Auth Service Primitives

## Day target
Teach owner authentication primitives and canonical failure mapping for owner login surfaces.

## Components and sub-components covered
- **Auth plane**
  - owner credential verification path
  - token issuance entrypoint for owner context
- **Contract plane**
  - canonical 401/422 behavior for auth and payload failures
- **Quality plane**
  - owner auth unit + contract-shape tests

## Lesson objectives
- **Programming objective:** learners can explain credential verification and service-level auth orchestration.
- **How CRE8 is made objective:** learners can describe why owner auth semantics must be deterministic and auditable.
- **Extension/XtraType objective:** learners can explain why extension admin capabilities rely on stable owner auth behavior.

## 75-minute teaching script
1. **(0–8 min)** Setup: claim validation now applied to owner auth path.
2. **(8–24 min)** Beginner lane: “administrator gate with strict identity checks” analogy.
3. **(24–50 min)** Builder lane: owner auth service flow, error mapping, response contract shape.
4. **(50–60 min)** Operator lane: support implications of unstable auth failure semantics.
5. **(60–67 min)** Decision journal: generic login failure only vs canonical mapped detail behavior.
6. **(67–73 min)** Proof walkthrough: owner auth tests.
7. **(73–75 min)** XtraType bridge: stable admin auth underpins extension governance features.

## Instructor notes
- Show both invalid credentials and malformed request examples.
- Connect service outcomes to error catalog discipline.

## Checks for understanding
- Why keep owner auth flows distinct from key auth?
- What is gained by stable auth error mapping?

## Required class artifacts
- owner auth flow diagram
- 401/422 scenario table
- owner auth test outputs

## Teacher caution points
- Don’t overgeneralize owner and key principal behavior.
- Avoid opaque error responses that reduce supportability.

---

## Day 33 — Key Auth Service Primitives

## Day target
Teach key principal authentication with lifecycle-aware deny behavior.

## Components and sub-components covered
- **Auth/policy plane**
  - key credential verification path
  - lifecycle-state checks in key auth entrypoint
- **Contract plane**
  - key auth success/failure semantics by status
- **Quality plane**
  - key auth tests across active/suspended/revoked/cancelled states

## Lesson objectives
- **Programming objective:** learners can explain actor-specific auth branching and lifecycle coupling.
- **How CRE8 is made objective:** learners can describe why key auth enforces lifecycle conditions before downstream operations.
- **Extension/XtraType objective:** learners can explain how extension runtime safety depends on lifecycle-aware key auth.

## 80-minute teaching script
1. **(0–10 min)** Setup: contrast owner auth and key auth responsibilities.
2. **(10–26 min)** Beginner lane: “member badge valid only while account is active” analogy.
3. **(26–56 min)** Builder lane: key auth flow + lifecycle gate integration.
4. **(56–66 min)** Operator lane: abuse and drift risks if inactive keys still authenticate.
5. **(66–73 min)** Decision journal: lifecycle checks in auth path vs deferred checks in handlers only.
6. **(73–78 min)** Proof walkthrough: lifecycle-state auth tests.
7. **(78–80 min)** XtraType bridge: extension flows inherit safer key behavior via lifecycle-aware auth.

## Instructor notes
- Use a status matrix to compare auth outcomes.
- Reinforce “inactive means deny early” principle.

## Checks for understanding
- Why enforce lifecycle checks at auth entry instead of later only?
- What difference should users/operators observe across key statuses?

## Required class artifacts
- key auth status matrix
- lifecycle deny-path outputs
- key auth test report

## Teacher caution points
- Don’t collapse all auth failures into one generic reason.
- Avoid inconsistent lifecycle semantics across services.

---

## Day 34 — Refresh Rotation + Replay Invalidation

## Day target
Teach replay-resistant refresh flow with transactional rotation and deterministic invalidation behavior.

## Components and sub-components covered
- **Auth/security plane**
  - refresh token rotation flow
  - replay detection and invalidation strategy
- **Data plane**
  - token family state transitions during refresh
- **Quality plane**
  - first-pass success / replay deny tests

## Lesson objectives
- **Programming objective:** learners can explain transactional refresh lifecycle and replay handling.
- **How CRE8 is made objective:** learners can describe why replay invalidation is mandatory in CRE8 auth model.
- **Extension/XtraType objective:** learners can explain how replay-safe session renewal protects extension user trust.

## 80-minute teaching script
1. **(0–10 min)** Setup: session renewal risks after initial auth.
2. **(10–26 min)** Beginner lane: “single-use pass renewal” analogy.
3. **(26–56 min)** Builder lane: rotation sequence, family updates, replay detection outcomes.
4. **(56–66 min)** Operator lane: account/session abuse patterns and mitigation value.
5. **(66–73 min)** Decision journal: accept duplicate refresh as no-op vs explicit replay invalidation.
6. **(73–78 min)** Proof walkthrough: replay test cases (first allow, second deny).
7. **(78–80 min)** XtraType bridge: secure session renewal patterns extend directly to app-facing auth flows.

## Instructor notes
- Walk through timeline of refresh attempt #1 and replay attempt #2.
- Highlight transactional boundaries and failure rollback expectations.

## Checks for understanding
- Why is replay invalidation stronger than silent duplicate handling?
- What state transitions are required for secure refresh rotation?

## Required class artifacts
- refresh sequence diagram
- replay scenario matrix
- rotation/replay test outputs

## Teacher caution points
- Don’t describe refresh as stateless when replay controls require state.
- Avoid unclear response semantics for replay denials.

---

## Day 35 — Shared Lifecycle Status Resolver

## Day target
Teach central lifecycle status resolution so auth and policy components apply status rules consistently.

## Components and sub-components covered
- **Policy/auth plane**
  - shared lifecycle resolver abstraction
  - status semantics (`active`, `suspended`, `cancelled`, `revoked`)
- **Runtime plane**
  - resolver integration points in auth and guard flows
- **Quality plane**
  - status-path conformance tests

## Lesson objectives
- **Programming objective:** learners can explain why lifecycle logic should be centralized and reused.
- **How CRE8 is made objective:** learners can describe how CRE8 prevents status-rule drift across services.
- **Extension/XtraType objective:** learners can explain how shared lifecycle resolution improves extension reliability and maintainability.

## 75-minute teaching script
1. **(0–8 min)** Setup: consolidate lifecycle logic after owner/key/refresh flows.
2. **(8–24 min)** Beginner lane: “single source of truth for account status” analogy.
3. **(24–50 min)** Builder lane: resolver contract, call sites, and decision outputs.
4. **(50–60 min)** Operator lane: inconsistencies caused by duplicated status checks.
5. **(60–67 min)** Decision journal: distributed status checks vs centralized resolver.
6. **(67–73 min)** Proof walkthrough: status-path tests.
7. **(73–75 min)** XtraType bridge: extension modules benefit from one canonical lifecycle interpreter.

## Instructor notes
- Ask learners to refactor a duplicate status check into resolver usage.
- Link resolver behavior to future authorization guard integration.

## Checks for understanding
- Why centralize lifecycle logic instead of repeating checks per route?
- What risk appears when two services interpret status values differently?

## Required class artifacts
- lifecycle resolver interface sketch
- status-path conformance outputs
- duplicated-vs-centralized comparison note

## Teacher caution points
- Don’t permit route-local lifecycle shortcuts.
- Avoid ambiguous status definitions without explicit semantics.

---

## Cross-day instructor notes (Days 31–35)

## Progression summary
- **Day 31:** establish strict JWT claim validation.
- **Day 32:** implement owner auth primitives.
- **Day 33:** implement lifecycle-aware key auth primitives.
- **Day 34:** implement replay-resistant refresh rotation.
- **Day 35:** centralize lifecycle status resolution.

## Weekly formative assessment prompts
1. Explain how Days 31–35 transform schema foundations into operational auth behavior.
2. Describe one deterministic deny-path from each day and why it matters.
3. Compare centralized lifecycle resolution with duplicated status checks.
4. Predict how Days 31–35 prepare public/auth route implementation in Days 36–40.

## Instructor handoff packet (end of Day 35)
Collect and archive:
- claim matrix validation outputs,
- owner auth test outputs,
- key lifecycle auth test outputs,
- refresh replay rotation evidence,
- lifecycle resolver conformance outputs,
- decision journal entries with rejected alternatives,
- one-page bridge memo: “How Days 31–35 prepare Days 36–40.”

## Bridge forward (preview to Days 36–40)
Tell learners what comes next:
- public routes (`/`, `/health`, `/.well-known/jwks.json`, `/ui/{route}`) baseline,
- auth route family (`/console/owners`, `/api/auth/login`, `/api/auth/key-login`, `/api/auth/refresh`),
- permission allow-list evaluator,
- delegation issuance validator,
- key-class mint authority evaluator.

This keeps continuity from auth-core internals into route-surface behavior and policy decision-table conformance.
