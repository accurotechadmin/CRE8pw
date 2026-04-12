# CRE8 Instructor Guide (Days 41–45)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence and covers Days 41–45 of M2.

These lessons continue the three core curriculum objectives:
1. teach programming in approachable, practical daily steps,
2. teach how CRE8 is built through policy-conformance and integration discipline,
3. teach how CRE8 foundations support extension and handoff to **XtraType**.

## Instruction contract for every lesson (Days 41–45)
- Teach lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Demonstrate at least one **negative/failure path** behavior.
- End with one **proof artifact** and one **XtraType bridge** statement.
- Tie each lesson to M2 closeout and M3 entry readiness.

---

## Day 41 — Keychain Membership Admission Policy Engine

## Day target
Teach policy-safe keychain admission checks (class constraints, no nesting, size limits, active-member rules) with deterministic outcomes.

## Components and sub-components covered
- **Policy plane**
  - keychain membership admission evaluator
  - no-nesting and class-eligibility checks
  - membership size constraints
- **Data/auth plane**
  - member status dependencies (active vs suspended/revoked/cancelled)
- **Quality plane**
  - admission conformance tests

## Lesson objectives
- **Programming objective:** learners can explain admission-rule evaluation order and deterministic deny logic.
- **How CRE8 is made objective:** learners can describe why keychain membership constraints are enforced at policy boundaries.
- **Extension/XtraType objective:** learners can explain how bounded keychain composition protects extension role models.

## 80-minute teaching script
1. **(0–10 min)** Setup: from mint/delegation rules into keychain governance.
2. **(10–26 min)** Beginner lane: “team roster rules with eligibility checks” analogy.
3. **(26–56 min)** Builder lane: admission engine logic, class filters, nesting/size/status constraints.
4. **(56–66 min)** Operator lane: privilege and complexity risks without strict admission rules.
5. **(66–73 min)** Decision journal: permissive membership + post-facto cleanup vs strict admission gate.
6. **(73–78 min)** Proof walkthrough: admission rule test matrix.
7. **(78–80 min)** XtraType bridge: extension group-authority workflows stay safe with strict admission constraints.

## Instructor notes
- Show one accepted member case and one rejected nested-keychain case.
- Emphasize that admission is a policy checkpoint, not only a data write.

## Checks for understanding
- Why are nested keychains disallowed in v1?
- What risk appears if inactive members remain admissible?

## Required class artifacts
- keychain admission rule sheet
- admission deny-reason examples
- conformance test outputs

## Teacher caution points
- Don’t describe keychain admission as purely UI validation.
- Avoid vague “we can clean it up later” governance framing.

---

## Day 42 — Keychain Effective Resolution Engine

## Day target
Teach deterministic effective permissions/scope resolution (union/intersection + envelope constraints + inactive exclusion).

## Components and sub-components covered
- **Policy plane**
  - effective permission union logic
  - scope merge rules (positive union / restrictive intersection)
  - envelope constraint application
- **Data plane**
  - snapshot recompute triggers and deterministic output expectations
- **Quality plane**
  - mixed-state/member resolution tests

## Lesson objectives
- **Programming objective:** learners can explain deterministic aggregation algorithms with constraint overlays.
- **How CRE8 is made objective:** learners can describe why effective-state computation must be explicit and testable.
- **Extension/XtraType objective:** learners can explain how extension authorization behavior depends on predictable effective resolution.

## 80-minute teaching script
1. **(0–10 min)** Setup: after admission, compute actual effective authority.
2. **(10–26 min)** Beginner lane: “combine team capabilities, then apply team charter limits” analogy.
3. **(26–56 min)** Builder lane: merge logic, inactive exclusion, envelope constrain sequence.
4. **(56–66 min)** Operator lane: debugging and security risks from opaque aggregation.
5. **(66–73 min)** Decision journal: implicit aggregate behavior vs explicit resolution engine with tests.
6. **(73–78 min)** Proof walkthrough: deterministic resolution test outputs.
7. **(78–80 min)** XtraType bridge: extension policy confidence requires repeatable resolution outputs.

## Instructor notes
- Work one full sample from member set to final effective output.
- Highlight why order/algorithm must be documented and stable.

## Checks for understanding
- Why apply keychain envelope constraints after member aggregation?
- How does inactive-member exclusion affect effective safety?

## Required class artifacts
- effective resolution algorithm diagram
- sample input/output resolution worksheet
- resolution conformance outputs

## Teacher caution points
- Don’t hand-wave scope merge semantics.
- Avoid ambiguous rules that vary per developer interpretation.

---

## Day 43 — Lifecycle Authority Evaluator + Policy Audit Events

## Day target
Teach actor/action lifecycle authority decisions and audit-event emission for policy-relevant transitions.

## Components and sub-components covered
- **Policy/auth plane**
  - lifecycle authority evaluator by actor/action/context
  - owner vs key/admin authority distinctions
- **Observability plane**
  - policy decision event emission
  - auditable decision records
- **Quality plane**
  - authority conformance tests + event assertion checks

## Lesson objectives
- **Programming objective:** learners can explain rule-based authority checks and decision event coupling.
- **How CRE8 is made objective:** learners can describe why lifecycle actions require both enforcement and auditable traces.
- **Extension/XtraType objective:** learners can explain how extension governance workflows rely on trustworthy authority logs.

## 80-minute teaching script
1. **(0–10 min)** Setup: move from static policy rules to lifecycle action governance.
2. **(10–26 min)** Beginner lane: “who is allowed to change account state and why” analogy.
3. **(26–56 min)** Builder lane: evaluator logic by actor/action and audit event outputs.
4. **(56–66 min)** Operator lane: forensic blind spots without policy decision events.
5. **(66–73 min)** Decision journal: enforce-only authority checks vs enforce + audit event emission.
6. **(73–78 min)** Proof walkthrough: authority matrix tests and event assertions.
7. **(78–80 min)** XtraType bridge: extension lifecycle operations stay governable with authority+audit coupling.

## Instructor notes
- Show one allowed owner action and one denied key action.
- Tie event fields to earlier request_id/observability lessons.

## Checks for understanding
- Why are audit events required in addition to allow/deny decisions?
- What actor/action combinations should always deny?

## Required class artifacts
- lifecycle authority matrix
- policy event sample payloads
- conformance + event assertion outputs

## Teacher caution points
- Don’t reduce policy audits to generic log lines.
- Avoid missing-deny-path examples.

---

## Day 44 — Surface Auth Guard Integration

## Day target
Teach end-to-end integration of console owner guard and gateway key+device guard with deterministic status behavior.

## Components and sub-components covered
- **Runtime/auth plane**
  - console surface guard integration
  - gateway surface guard integration (`token type/audience/surface` + device requirements)
- **Contract plane**
  - 401/403/422/429 surface behavior expectations
- **Quality plane**
  - integration tests by surface and route family

## Lesson objectives
- **Programming objective:** learners can explain surface-specific guard composition and pre-handler enforcement.
- **How CRE8 is made objective:** learners can describe why surface binding checks occur before route handlers.
- **Extension/XtraType objective:** learners can explain how extension routes stay safe by inheriting surface guard architecture.

## 80-minute teaching script
1. **(0–10 min)** Setup: policy engines now wired into route surfaces.
2. **(10–26 min)** Beginner lane: “separate entrances with distinct access rules” analogy.
3. **(26–56 min)** Builder lane: guard wiring, binding checks, device policy integration.
4. **(56–66 min)** Operator lane: cross-surface leakage risks without strict guard boundaries.
5. **(66–73 min)** Decision journal: handler-level auth checks only vs middleware guard enforcement.
6. **(73–78 min)** Proof walkthrough: surface integration test suite output.
7. **(78–80 min)** XtraType bridge: extension APIs remain bounded by inherited surface guard contracts.

## Instructor notes
- Compare one console route and one gateway route deny path.
- Reinforce early-deny behavior before business logic execution.

## Checks for understanding
- Why bind token audience/type to route surface?
- What security gap appears if device guard is inconsistently applied?

## Required class artifacts
- surface guard map
- status-code behavior matrix by surface
- integration test outputs

## Teacher caution points
- Don’t mix console and gateway guard assumptions.
- Avoid handler-level auth shortcuts that bypass middleware guarantees.

---

## Day 45 — M2 Milestone Closeout and M3 Entry Readiness

## Day target
Teach M2 closeout discipline: evidence packaging, unresolved ambiguity checks, and explicit M3 entry conditions.

## Components and sub-components covered
- **Governance/traceability plane**
  - M2 evidence package completion
  - traceability and decision/risk update checks
- **Quality plane**
  - full M2 verification sweep
  - conformance status confirmation across data/auth/policy/route guards
- **Program readiness plane**
  - M3 entry criteria review and signoff

## Lesson objectives
- **Programming objective:** learners can explain integration closeout and regression confidence expectations.
- **How CRE8 is made objective:** learners can describe why M2 closure requires evidence and policy clarity, not just implementation progress.
- **Extension/XtraType objective:** learners can explain how milestone-close rigor reduces extension instability downstream.

## 80-minute teaching script
1. **(0–10 min)** Setup: from M2 implementation slices to milestone closure.
2. **(10–24 min)** Beginner lane: “stage gate before entering next construction phase” analogy.
3. **(24–52 min)** Builder lane: closeout artifact checklist and verification sweep interpretation.
4. **(52–64 min)** Operator lane: consequences of carrying unresolved policy ambiguity into M3.
5. **(64–71 min)** Decision journal: move forward on momentum vs explicit closeout/signoff discipline.
6. **(71–78 min)** Proof walkthrough: M2 closeout dossier structure.
7. **(78–80 min)** XtraType bridge: disciplined milestone exits improve extension delivery reliability.

## Instructor notes
- Require one explicit “resolved vs unresolved” review table from learners.
- Tie closeout quality to upcoming domain-route acceleration in M3.

## Checks for understanding
- Why is explicit M3 entry criteria confirmation required?
- What must be present in a credible M2 closeout package?

## Required class artifacts
- M2 closeout checklist
- full verification summary
- M3 entry criteria confirmation notes

## Teacher caution points
- Don’t normalize handoff without artifact completeness.
- Avoid “we’ll fix policy drift in the next milestone” assumptions.

---

## Cross-day instructor notes (Days 41–45)

## Progression summary
- **Day 41:** enforce keychain admission policy constraints.
- **Day 42:** implement deterministic effective resolution.
- **Day 43:** implement lifecycle authority decisions + audit events.
- **Day 44:** integrate surface-specific auth guards.
- **Day 45:** complete M2 closeout and M3 entry readiness.

## Weekly formative assessment prompts
1. Explain how Days 41–45 complete M2 policy and guard integration.
2. Describe one deterministic deny-path per day and why it matters for safety.
3. Compare policy-table conformance with ad hoc policy implementation practices.
4. Predict how Days 41–45 prepare gateway/console domain route work in Days 46–50.

## Instructor handoff packet (end of Day 45)
Collect and archive:
- keychain admission and resolution conformance outputs,
- lifecycle authority + policy event evidence,
- surface guard integration results,
- M2 closeout verification artifacts,
- decision journal entries with rejected alternatives,
- one-page bridge memo: “How Days 41–45 prepare M3 Days 46–50.”

## Bridge forward (preview to Days 46–50)
Tell learners what comes next:
- gateway feed route,
- gateway post create/read/edit foundations,
- revision transaction hardening,
- post-flag flow,
- start of full domain route delivery.

This maintains continuity from policy-core completion into M3 domain implementation momentum.
