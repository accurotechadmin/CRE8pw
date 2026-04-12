# CRE8 Instructor Guide (Days 36–40)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence and covers Days 36–40 of M2.

These lessons continue the three core curriculum objectives:
1. teach programming with practical, accessible daily progression,
2. teach how CRE8 is built through contract-first route/auth/policy implementation,
3. teach how CRE8 foundations support extension and handoff to **XtraType**.

## Instruction contract for every lesson (Days 36–40)
- Teach lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Demonstrate at least one **negative/failure path** behavior.
- End with one **proof artifact** and one **XtraType bridge** statement.
- Tie each lesson to M2 policy-core and route-surface readiness.

---

## Day 36 — Public Surface Route Baseline

## Day target
Teach implementation of public route family baseline (`/`, `/health` skeleton, `/.well-known/jwks.json`, `/ui/{route}` fallback) with envelope/security consistency.

## Components and sub-components covered
- **Contract plane**
  - public route behavior baseline
  - envelope metadata consistency on public responses
- **Runtime plane**
  - route wiring for public surface
- **Security plane**
  - ensure public routes bypass auth guards while retaining security middleware behavior
- **Quality plane**
  - public route contract tests

## Lesson objectives
- **Programming objective:** learners can explain baseline route scaffolding with contract-safe response shaping.
- **How CRE8 is made objective:** learners can describe why public surfaces are established before full auth/policy completion.
- **Extension/XtraType objective:** learners can explain how stable public surfaces support extension bootstrap and diagnostics.

## 75-minute teaching script
1. **(0–10 min)** Setup: transition from auth internals to route-surface implementation.
2. **(10–24 min)** Beginner lane: “public entry points with consistent packaging” analogy.
3. **(24–50 min)** Builder lane: route handlers, envelope behavior, and middleware expectations.
4. **(50–60 min)** Operator lane: integration problems when public baseline is delayed.
5. **(60–67 min)** Decision journal: raw public responses vs envelope-consistent public routes.
6. **(67–73 min)** Proof walkthrough: public route contract output.
7. **(73–75 min)** XtraType bridge: predictable platform entry points simplify app integration.

## Instructor notes
- Show one route that returns expected success envelope shape.
- Reinforce that “public” does not mean “unconstrained.”

## Checks for understanding
- Why keep envelope/security behavior consistent on public routes?
- What is the difference between bypassing auth guard and bypassing security controls?

## Required class artifacts
- public route inventory note
- route contract test output
- middleware behavior checklist for public surface

## Teacher caution points
- Don’t treat public routes as exempt from platform standards.
- Avoid ad hoc response structures for convenience.

---

## Day 37 — Auth Route Family Implementation

## Day target
Teach integration of auth routes (`/console/owners`, `/api/auth/login`, `/api/auth/key-login`, `/api/auth/refresh`) with canonical validation and error behavior.

## Components and sub-components covered
- **Auth/contract plane**
  - auth route orchestration and service integration
  - canonical failure mappings for invalid auth/payload paths
- **Runtime plane**
  - route-to-service wiring for bootstrap/login/refresh
- **Quality plane**
  - auth route contract tests including negative paths

## Lesson objectives
- **Programming objective:** learners can explain handler orchestration and service boundary usage in auth routes.
- **How CRE8 is made objective:** learners can describe why negative-path contract testing is mandatory in auth routes.
- **Extension/XtraType objective:** learners can explain how stable auth APIs reduce integration risk for extension clients.

## 80-minute teaching script
1. **(0–10 min)** Setup: from auth internals to route exposure.
2. **(10–26 min)** Beginner lane: “single sign-in desk serving multiple role entry points” analogy.
3. **(26–56 min)** Builder lane: owner signup/login, key-login, refresh route behavior and error mapping.
4. **(56–66 min)** Operator lane: auth support burden from inconsistent route semantics.
5. **(66–73 min)** Decision journal: implement happy-path first vs full negative-path-first contract discipline.
6. **(73–78 min)** Proof walkthrough: auth route contract suite.
7. **(78–80 min)** XtraType bridge: extension UX depends on predictable auth route behavior.

## Instructor notes
- Pair each auth route with one expected negative-path example.
- Highlight consistency between route outputs and prior service-level rules.

## Checks for understanding
- Why must auth routes include deterministic 401/422 behaviors?
- What value comes from route-level contract tests beyond unit tests?

## Required class artifacts
- auth route map
- route-to-service wiring notes
- auth contract test output

## Teacher caution points
- Don’t defer negative-path implementation for auth surfaces.
- Avoid route-specific bespoke error formats.

---

## Day 38 — Permission Allow-list Evaluator

## Day target
Teach explicit permission vocabulary enforcement and deterministic rejection of unknown permissions.

## Components and sub-components covered
- **Policy plane**
  - permission allow-list evaluator
  - known permission vocabulary checks
- **Contract plane**
  - policy deny semantics for unknown/unauthorized permission values
- **Quality plane**
  - allow/deny/unknown permission test matrix

## Lesson objectives
- **Programming objective:** learners can explain allow-list evaluation and explicit deny behavior.
- **How CRE8 is made objective:** learners can describe why CRE8 rejects unknown permission strings.
- **Extension/XtraType objective:** learners can explain how explicit permission vocabularies improve extension policy safety.

## 75-minute teaching script
1. **(0–8 min)** Setup: route auth now needs policy vocabulary discipline.
2. **(8–24 min)** Beginner lane: “approved role actions list” analogy.
3. **(24–50 min)** Builder lane: permission evaluator flow, known-vocab checks, deny outcomes.
4. **(50–60 min)** Operator lane: silent drift risks from permissive unknown permissions.
5. **(60–67 min)** Decision journal: permissive forward-compat unknown permissions vs strict allow-list rejection.
6. **(67–73 min)** Proof walkthrough: permission matrix tests.
7. **(73–75 min)** XtraType bridge: extension permissions remain predictable when vocabulary is explicit.

## Instructor notes
- Show one allowed and one unknown permission example.
- Tie permission vocabulary back to delegation and keychain constraints.

## Checks for understanding
- Why is unknown-permission rejection safer than silent acceptance?
- How does allow-list policy improve auditability?

## Required class artifacts
- permission vocabulary sheet
- allow/deny/unknown test outputs
- policy evaluation flow sketch

## Teacher caution points
- Don’t frame unknown permissions as harmless future-proofing.
- Avoid hidden fallback permissions in evaluator logic.

---

## Day 39 — Delegation Issuance Validator

## Day target
Teach issuance-time delegation constraint checks (subset scope/perms, depth, expiry, mint authority prerequisites).

## Components and sub-components covered
- **Policy plane**
  - delegation issuance validator
  - subset/depth/expiry invariants
- **Auth plane**
  - linkage to issuer capabilities (`keys:issue`) and actor constraints
- **Quality plane**
  - conformance tests for overscope/overdepth/missing-expiry/no-authority cases

## Lesson objectives
- **Programming objective:** learners can explain bounded delegation validation algorithm.
- **How CRE8 is made objective:** learners can describe why issuance validator must mirror decision-table outcomes.
- **Extension/XtraType objective:** learners can explain how bounded delegation protects extension role-propagation patterns.

## 80-minute teaching script
1. **(0–10 min)** Setup: from permission vocabulary to delegation issuance boundaries.
2. **(10–26 min)** Beginner lane: “child permissions cannot exceed parent contract” analogy.
3. **(26–56 min)** Builder lane: invariant checks, deny reasons, and deterministic validator order.
4. **(56–66 min)** Operator lane: escalation risks from weak issuance checks.
5. **(66–73 min)** Decision journal: enforce subset/depth/expiry at issuance vs patch with runtime checks later.
6. **(73–78 min)** Proof walkthrough: delegation conformance test outputs.
7. **(78–80 min)** XtraType bridge: extension delegation remains safe when issuance is bounded early.

## Instructor notes
- Walk through one valid issuance and one over-scoped denial.
- Reinforce deterministic detail-code outcomes for policy denials.

## Checks for understanding
- Why enforce delegation bounds at issuance rather than only at action time?
- What failure modes are prevented by explicit expiry requirement?

## Required class artifacts
- delegation validator flowchart
- invariants checklist
- conformance test outputs

## Teacher caution points
- Don’t allow ambiguous “soft bounds” language.
- Avoid validators that produce non-deterministic deny reasons.

---

## Day 40 — Key-Class Mint Authority Evaluator

## Day target
Teach class-based mint authority rules for owner/primary/secondary/use/keychain actors with table-driven policy behavior.

## Components and sub-components covered
- **Policy/auth plane**
  - key-class mint authority evaluator
  - actor→mint-target rule matrix
- **Contract plane**
  - deterministic allow/deny outputs by class and context
- **Quality plane**
  - mint authority matrix tests

## Lesson objectives
- **Programming objective:** learners can explain rule-matrix policy implementation vs ad hoc branching.
- **How CRE8 is made objective:** learners can describe why keychain/use classes are denied mint authority in v1.
- **Extension/XtraType objective:** learners can explain how explicit mint rules constrain extension privilege proliferation.

## 80-minute teaching script
1. **(0–10 min)** Setup: after issuance validator, enforce who can mint what.
2. **(10–26 min)** Beginner lane: “role-based issuing permissions board” analogy.
3. **(26–56 min)** Builder lane: evaluator matrix, actor class handling, and deny semantics.
4. **(56–66 min)** Operator lane: privilege creep risks from unclear mint rules.
5. **(66–73 min)** Decision journal: matrix-driven evaluator vs nested ad hoc conditional logic.
6. **(73–78 min)** Proof walkthrough: mint authority matrix results.
7. **(78–80 min)** XtraType bridge: extension governance stays bounded with explicit mint authority constraints.

## Instructor notes
- Have learners map one actor class to allowed and forbidden mint actions.
- Emphasize readability and testability of matrix-driven policy design.

## Checks for understanding
- Why is matrix-driven policy easier to verify than ad hoc if/else policy logic?
- What risk appears if `use` keys can mint descendants?

## Required class artifacts
- mint authority matrix sheet
- class-by-class decision examples
- evaluator conformance output

## Teacher caution points
- Don’t hide policy rules inside implicit code defaults.
- Avoid teaching policy behavior without an explicit decision table.

---

## Cross-day instructor notes (Days 36–40)

## Progression summary
- **Day 36:** establish public route surface baseline.
- **Day 37:** deliver auth route family contract behavior.
- **Day 38:** enforce permission vocabulary allow-list.
- **Day 39:** enforce delegation issuance invariants.
- **Day 40:** enforce key-class mint authority matrix.

## Weekly formative assessment prompts
1. Explain how Days 36–40 connect route implementation to policy conformance.
2. Describe one deterministic deny-path from each day and the risk it prevents.
3. Compare contract-first route policy behavior with ad hoc route implementations.
4. Predict how Days 36–40 prepare keychain admission/resolution and lifecycle authority work in Days 41–45.

## Instructor handoff packet (end of Day 40)
Collect and archive:
- public/auth route contract artifacts,
- permission evaluator matrix outputs,
- delegation issuance conformance outputs,
- key-class mint authority matrix outputs,
- decision journal entries with rejected alternatives,
- one-page bridge memo: “How Days 36–40 prepare Days 41–45.”

## Bridge forward (preview to Days 41–45)
Tell learners what comes next:
- keychain membership admission policy engine,
- keychain effective resolution engine,
- lifecycle authority evaluator + policy audit events,
- surface auth guard integration,
- M2 closeout and M3 entry readiness.

This maintains continuity from route+policy core toward full M2 conformance and milestone closure.
