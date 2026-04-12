# CRE8 Instructor Guide (Days 46–50)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence and covers Days 46–50 of M3.

These lessons continue the three core curriculum objectives:
1. teach programming in practical, production-shaped increments,
2. teach how CRE8 is built through domain route implementation with contract and policy fidelity,
3. teach how CRE8 foundations support extension and handoff to **XtraType**.

## Instruction contract for every lesson (Days 46–50)
- Teach lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Demonstrate at least one **negative/failure path** behavior.
- End with one **proof artifact** and one **XtraType bridge** statement.
- Tie each lesson to M3 domain delivery and security/quality expectations.

---

## Day 46 — Gateway Feed Route (`GET /api/feed`)

## Day target
Teach first gateway domain route delivery with scoped reads, policy gating, and deterministic envelope behavior.

## Components and sub-components covered
- **Domain/API plane**
  - feed service + handler baseline
  - pagination/order/scoped-read expectations
- **Policy/auth plane**
  - key auth + device guard prerequisites
- **Contract plane**
  - route status behavior (`200/401/403/429`) and envelope consistency
- **Quality plane**
  - feed contract tests + ordering checks

## Lesson objectives
- **Programming objective:** learners can explain read-route composition from guard→service→envelope.
- **How CRE8 is made objective:** learners can describe why policy and scope checks precede feed logic.
- **Extension/XtraType objective:** learners can explain how extension feed features depend on scoped route guarantees.

## 80-minute teaching script
1. **(0–10 min)** Setup: transition from M2 policy-core to M3 domain routes.
2. **(10–26 min)** Beginner lane: “personalized feed with access boundaries” analogy.
3. **(26–56 min)** Builder lane: handler/service flow, scope filtering, ordering contract.
4. **(56–66 min)** Operator lane: failure modes from missing guard/policy checks.
5. **(66–73 min)** Decision journal: fetch-all-and-filter-client-side vs server-side scoped feed.
6. **(73–78 min)** Proof walkthrough: feed route test outputs.
7. **(78–80 min)** XtraType bridge: extension feeds stay safe with server-enforced scope logic.

## Instructor notes
- Show one authorized feed response and one forbidden/no-scope scenario.
- Emphasize deterministic ordering expectations for stable UX.

## Checks for understanding
- Why must scope filtering happen on the server?
- What breaks if device guard is omitted on gateway feed?

## Required class artifacts
- feed route flow diagram
- status/path behavior matrix
- feed contract/ordering outputs

## Teacher caution points
- Don’t offload policy enforcement to frontend clients.
- Avoid unstable ordering in baseline feed behavior.

---

## Day 47 — Post Create (`POST /api/posts`)

## Day target
Teach mutation-route implementation with permission checks, use-key restrictions, and transactional writes.

## Components and sub-components covered
- **Domain/API plane**
  - post-create handler/service workflow
  - content write transaction boundaries
- **Policy plane**
  - `posts:create` enforcement
  - use-key mutation restriction checks
- **Contract plane**
  - canonical allow/deny/validation response behavior
- **Quality plane**
  - post-create route tests (allow/deny/422)

## Lesson objectives
- **Programming objective:** learners can explain secure write-path orchestration.
- **How CRE8 is made objective:** learners can describe why mutation routes require layered policy checks.
- **Extension/XtraType objective:** learners can explain how extension content creation depends on trustworthy policy enforcement.

## 80-minute teaching script
1. **(0–10 min)** Setup: from read-only gateway route to first write route.
2. **(10–26 min)** Beginner lane: “you can post only if your role and context permit it” analogy.
3. **(26–56 min)** Builder lane: request validation, permission checks, transaction write, response mapping.
4. **(56–66 min)** Operator lane: abuse and data-quality risks on weakly gated writes.
5. **(66–73 min)** Decision journal: middleware-only checks vs middleware + service-layer policy defense.
6. **(73–78 min)** Proof walkthrough: post-create tests and deny-path artifacts.
7. **(78–80 min)** XtraType bridge: extension write flows inherit safer mutation controls.

## Instructor notes
- Walk one accepted create request and one denied use-key mutation.
- Tie outcomes to error/detail-code consistency.

## Checks for understanding
- Why enforce permission checks at both boundary and service layers?
- What user-facing behavior should appear on policy denial?

## Required class artifacts
- post-create policy checklist
- mutation flow diagram
- allow/deny/validation test outputs

## Teacher caution points
- Don’t treat write routes as simple CRUD without policy context.
- Avoid implicit permission assumptions in handler logic.

---

## Day 48 — Post Read/Edit (`GET/PATCH /api/posts/{postId}`)

## Day target
Teach combined visibility and edit authorization behavior with revision-aware update flows.

## Components and sub-components covered
- **Domain/API plane**
  - post detail read behavior
  - edit route with revision write
- **Policy plane**
  - visibility checks for read
  - edit authorization checks
- **Contract plane**
  - deterministic `200/403/404/422` behavior
- **Quality plane**
  - read/edit conformance + revision integrity tests

## Lesson objectives
- **Programming objective:** learners can explain combined read/write route behavior with distinct policy rules.
- **How CRE8 is made objective:** learners can describe why visibility and edit permissions are separate checks.
- **Extension/XtraType objective:** learners can explain how extension editing UX depends on reliable read/edit semantics.

## 80-minute teaching script
1. **(0–10 min)** Setup: pair read visibility with edit authorization.
2. **(10–26 min)** Beginner lane: “can view vs can modify” distinction analogy.
3. **(26–56 min)** Builder lane: route behavior, revision writes, and status mapping.
4. **(56–66 min)** Operator lane: integrity/support risks from merged or ambiguous checks.
5. **(66–73 min)** Decision journal: single shared permission gate vs separated read/edit policy gates.
6. **(73–78 min)** Proof walkthrough: read/edit + revision test outputs.
7. **(78–80 min)** XtraType bridge: extension editing features rely on this separation for trust and clarity.

## Instructor notes
- Demonstrate one case where read is allowed but edit is denied.
- Reinforce why `404` and `403` semantics must remain distinct.

## Checks for understanding
- Why separate visibility and edit policy evaluation?
- What debugging value is gained from deterministic status mapping?

## Required class artifacts
- read/edit decision map
- revision-write flow sketch
- route conformance outputs

## Teacher caution points
- Don’t collapse non-visible and forbidden states into one generic response.
- Avoid update logic that bypasses revision recording.

---

## Day 49 — Revision Transaction Hardening

## Day target
Teach atomic transaction guarantees for post edits so partial failures never leave inconsistent state.

## Components and sub-components covered
- **Data/domain plane**
  - revision transaction boundaries
  - rollback behavior on failure
- **Quality plane**
  - injected-failure transaction integrity tests
- **Ops/reliability plane**
  - consistency guarantees for audit and recovery scenarios

## Lesson objectives
- **Programming objective:** learners can explain atomic update patterns and rollback semantics.
- **How CRE8 is made objective:** learners can describe why revision integrity is a non-negotiable write-path requirement.
- **Extension/XtraType objective:** learners can explain how extension content reliability depends on atomic history writes.

## 75-minute teaching script
1. **(0–8 min)** Setup: hardening the Day 48 edit path.
2. **(8–24 min)** Beginner lane: “all-or-nothing bank transfer” analogy.
3. **(24–50 min)** Builder lane: transaction scope design, failure injection points, rollback outcomes.
4. **(50–60 min)** Operator lane: data corruption and support impacts of partial writes.
5. **(60–67 min)** Decision journal: best-effort partial persistence vs strict atomic transaction enforcement.
6. **(67–73 min)** Proof walkthrough: transaction integrity tests.
7. **(73–75 min)** XtraType bridge: extension revision confidence requires atomic guarantees.

## Instructor notes
- Force one simulated failure and inspect resulting persisted state.
- Connect atomicity to moderation/audit trust.

## Checks for understanding
- Why is partial revision persistence dangerous?
- What does successful rollback prove in this context?

## Required class artifacts
- transaction boundary map
- failure injection scenario notes
- integrity test outputs

## Teacher caution points
- Don’t assume database default behavior is sufficient without explicit tests.
- Avoid “eventual repair” narratives for core transaction paths.

---

## Day 50 — Post Flags (`POST /api/posts/{postId}/flags`)

## Day target
Teach moderation-intake route implementation with reason validation, visibility policy checks, and auditable persistence.

## Components and sub-components covered
- **Domain/API plane**
  - post-flag route and persistence flow
- **Policy/contract plane**
  - visibility checks and reason-code validation
  - deterministic response behavior for invalid/not-found/policy-deny
- **Quality plane**
  - flag route contract + audit evidence tests

## Lesson objectives
- **Programming objective:** learners can explain intake-route validation and policy-aware persistence design.
- **How CRE8 is made objective:** learners can describe why moderation-intake paths require strict reason/visibility controls.
- **Extension/XtraType objective:** learners can explain how extension moderation workflows build on stable flag intake behavior.

## 80-minute teaching script
1. **(0–10 min)** Setup: introducing moderation intake into gateway domain routes.
2. **(10–26 min)** Beginner lane: “structured report form with required reason” analogy.
3. **(26–56 min)** Builder lane: route flow, validation, policy checks, and persistence outputs.
4. **(56–66 min)** Operator lane: moderation blind spots from weak intake quality.
5. **(66–73 min)** Decision journal: free-form flag intake vs validated reason taxonomy.
6. **(73–78 min)** Proof walkthrough: flag route tests and audit artifacts.
7. **(78–80 min)** XtraType bridge: extension moderation tools depend on clean intake data and policy consistency.

## Instructor notes
- Show one accepted flag and one invalid reason case.
- Tie route behavior to moderation action pipeline introduced in later lessons.

## Checks for understanding
- Why validate flag reasons instead of accepting arbitrary text only?
- How do visibility policies affect flag eligibility?

## Required class artifacts
- flag route validation matrix
- policy + persistence flow sketch
- route/audit test outputs

## Teacher caution points
- Don’t treat moderation intake as low-stakes auxiliary behavior.
- Avoid ambiguous reason taxonomies that impede downstream moderation quality.

---

## Cross-day instructor notes (Days 46–50)

## Progression summary
- **Day 46:** implement gateway feed route baseline.
- **Day 47:** implement post-create mutation path.
- **Day 48:** implement post read/edit with revision recording.
- **Day 49:** harden revision transactions for atomic integrity.
- **Day 50:** implement post flag moderation-intake route.

## Weekly formative assessment prompts
1. Explain how Days 46–50 translate M2 policy foundations into production route behavior.
2. Describe one deterministic deny-path per day and what risk it prevents.
3. Compare read-route and write-route policy responsibilities in this slice.
4. Predict how Days 46–50 prepare comment and console domain delivery in Days 51–55.

## Instructor handoff packet (end of Day 50)
Collect and archive:
- feed route contract + ordering evidence,
- post create/read/edit policy conformance outputs,
- revision transaction integrity evidence,
- post-flag intake validation/audit outputs,
- decision journal entries with rejected alternatives,
- one-page bridge memo: “How Days 46–50 prepare Days 51–55.”

## Bridge forward (preview to Days 51–55)
Tell learners what comes next:
- comment list/create gateway routes,
- console posts route family,
- keychain list/create and membership mutation flows,
- expanded cross-surface policy validation.

This keeps continuity from first gateway domain slice into broader domain and console surface completion.
