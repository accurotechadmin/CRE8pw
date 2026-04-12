# CRE8 Instructor Guide (Days 16–20)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence for the 90-day CRE8 curriculum and covers Days 16–20 of M1.

These lessons continue the three curriculum objectives:
1. teach programming accessibly with practical implementation steps,
2. teach how CRE8 is built through explicit runtime/ops decisions,
3. teach how CRE8 foundations support extension and handoff to **XtraType**.

## Instruction contract for every lesson (Days 16–20)
- Teach in lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Demonstrate at least one **negative/failure path**.
- End with one **proof artifact** and one **XtraType bridge** statement.
- Connect each lesson to M1 closeout and M2 readiness.

---

## Day 16 — Structured Observability Emitter + Redaction

## Day target
Teach structured event emission and centralized redaction so logs remain useful for operations without leaking sensitive data.

## Components and sub-components covered
- **Observability plane**
  - event emitter abstraction and baseline event families
  - required event fields and correlation expectations
- **Security plane**
  - centralized redaction policy for token/secret/private-key fields
- **Quality/ops plane**
  - event-shape and redaction tests

## Lesson objectives
- **Programming objective:** learners can explain structured event contracts and centralized sanitization.
- **How CRE8 is made objective:** learners can describe why observability is implemented as a first-class runtime component.
- **Extension/XtraType objective:** learners can explain how safe telemetry supports extension troubleshooting and support workflows.

## 80-minute teaching script
1. **(0–10 min)** Setup: from request controls to traceable operations.
2. **(10–26 min)** Beginner lane: “structured receipts vs handwritten notes” analogy.
3. **(26–54 min)** Builder lane: event schema fields, emitter integration points, redaction pipeline.
4. **(54–66 min)** Operator lane: incident timelines and leakage risks.
5. **(66–73 min)** Decision journal: ad hoc logs vs structured/redacted events.
6. **(73–78 min)** Proof walkthrough: event-shape + redaction verification output.
7. **(78–80 min)** XtraType bridge: safe platform telemetry accelerates app-layer incident response.

## Instructor notes
- Show a before/after example of sensitive-field redaction.
- Emphasize correlation continuity with request_id.

## Checks for understanding
- Why centralize redaction rather than rely on developer discipline?
- Which event fields are required for reliable triage?

## Required class artifacts
- event schema checklist
- redaction test output
- sample sanitized event payloads

## Teacher caution points
- Do not print raw secrets in demos.
- Avoid loosely structured “free text only” logging examples.

---

## Day 17 — Public Route Placeholders

## Day target
Teach why placeholder routes are useful for integration sequencing, provided they still obey security and contract behavior.

## Components and sub-components covered
- **Contract plane**
  - baseline public route behavior for `/` and `/.well-known/jwks.json`
  - envelope consistency on placeholder routes
- **Runtime plane**
  - route registration and minimal handler wiring
- **Security plane**
  - public-route policy boundaries (no auth requirement, still protected response behavior)
- **Quality plane**
  - contract tests for placeholder routes

## Lesson objectives
- **Programming objective:** learners can explain minimal route scaffolding with contract-safe responses.
- **How CRE8 is made objective:** learners can describe why public surfaces are delivered early for integration confidence.
- **Extension/XtraType objective:** learners can explain how stable baseline routes simplify future app integrations.

## 70-minute teaching script
1. **(0–8 min)** Setup: why placeholders are engineering tools, not shortcuts.
2. **(8–22 min)** Beginner lane: “stub interfaces before full implementation” analogy.
3. **(22–44 min)** Builder lane: route wiring, response shape, and boundary rules.
4. **(44–54 min)** Operator lane: integration failures from delaying baseline route availability.
5. **(54–62 min)** Decision journal: delay until full feature completion vs placeholder-first with contract discipline.
6. **(62–68 min)** Proof walkthrough: placeholder route contract tests.
7. **(68–70 min)** XtraType bridge: predictable base routes support extension bootstrap workflows.

## Instructor notes
- Clarify difference between placeholder stability and feature completeness.
- Demonstrate one placeholder success response and one controlled failure.

## Checks for understanding
- Why can placeholder routes still be contract-compliant?
- What risks appear if placeholder routes bypass standard envelope/security behavior?

## Required class artifacts
- public route map
- placeholder contract test output
- “placeholder done criteria” notes

## Teacher caution points
- Don’t present placeholders as “temporary chaos.”
- Avoid bypassing shared response and security middleware.

---

## Day 18 — Health Service Scaffold

## Day target
Teach health semantics (`ok`, `degraded`, `down`) and subsystem probing as an operational contract, not a convenience endpoint.

## Components and sub-components covered
- **Ops/quality plane**
  - health service scaffold and subsystem probes (`db`, limiter, key material, dependency)
  - health response semantics and envelope behavior
- **Runtime plane**
  - health handler integration
- **Observability plane**
  - health signal usefulness for operations and release gates
- **Quality plane**
  - health route tests for normal and failure-injected states

## Lesson objectives
- **Programming objective:** learners can explain probe aggregation and status derivation.
- **How CRE8 is made objective:** learners can describe why health semantics are contract-governed in CRE8.
- **Extension/XtraType objective:** learners can explain how reliable platform health improves confidence for app-level deployments.

## 80-minute teaching script
1. **(0–10 min)** Setup: what “healthy” means in a dependency-driven system.
2. **(10–26 min)** Beginner lane: “system check dashboard” analogy.
3. **(26–56 min)** Builder lane: probe interfaces, status aggregation, response shape.
4. **(56–66 min)** Operator lane: degraded-state triage and release decision impact.
5. **(66–73 min)** Decision journal: binary health only vs graded health semantics.
6. **(73–78 min)** Proof walkthrough: health contract tests (`ok`/`degraded`/error paths).
7. **(78–80 min)** XtraType bridge: app teams inherit confidence from platform health guarantees.

## Instructor notes
- Show at least one injected dependency failure and resulting degraded output.
- Tie health semantics to future smoke checks and readiness gates.

## Checks for understanding
- Why is degraded status valuable compared to pass/fail only?
- Which subsystems should be represented in baseline health checks and why?

## Required class artifacts
- subsystem probe matrix
- health response examples by state
- health contract test output

## Teacher caution points
- Don’t expose sensitive internals in health payload examples.
- Avoid reducing health to an uptime vanity metric.

---

## Day 19 — Startup Evidence Writer

## Day target
Teach generation of auditable startup evidence so boot outcomes are reviewable and reproducible.

## Components and sub-components covered
- **Ops/governance plane**
  - startup evidence artifact generation (success/failure)
  - evidence path/retention expectations
- **Runtime plane**
  - integration of evidence writer into startup lifecycle
- **Quality plane**
  - evidence generation tests for pass/fail boot paths

## Lesson objectives
- **Programming objective:** learners can explain structured artifact generation as part of runtime flow.
- **How CRE8 is made objective:** learners can describe why startup evidence is required before milestone closeout.
- **Extension/XtraType objective:** learners can explain how evidence discipline supports trustworthy handoffs to extension teams.

## 75-minute teaching script
1. **(0–8 min)** Setup: from health signals to durable startup evidence.
2. **(8–24 min)** Beginner lane: “flight recorder” analogy.
3. **(24–50 min)** Builder lane: evidence schema, write timing, safe failure messaging.
4. **(50–60 min)** Operator lane: audit and incident reconstruction value.
5. **(60–67 min)** Decision journal: ephemeral logs only vs durable startup evidence artifacts.
6. **(67–73 min)** Proof walkthrough: startup evidence tests and sample artifacts.
7. **(73–75 min)** XtraType bridge: extension teams depend on clear boot evidence during rollout.

## Instructor notes
- Compare startup logs vs structured evidence artifacts.
- Emphasize minimal, safe, and reproducible metadata.

## Checks for understanding
- Why is startup evidence useful beyond debugging?
- What should never be included in startup evidence payloads?

## Required class artifacts
- startup evidence schema notes
- success/failure artifact samples
- evidence generation test output

## Teacher caution points
- Don’t include secrets or raw key material in evidence examples.
- Avoid non-deterministic fields without explanation.

---

## Day 20 — M1 Pre-close Stabilization + Verification Sweep

## Day target
Teach milestone pre-close discipline: stabilize, run full M1 checks, capture unresolved issues with owner accountability.

## Components and sub-components covered
- **Quality plane**
  - full M1 verification sweep across introduced runtime/security/contract slices
- **Governance plane**
  - unresolved issue tracking with owners and explicit handoff notes
- **Traceability plane**
  - update/confirm traceability state for M1 scope
- **Ops/readiness plane**
  - pre-close checklist and closeout packet preparation for Day 21

## Lesson objectives
- **Programming objective:** learners can explain integration stabilization and regression closure practices.
- **How CRE8 is made objective:** learners can describe why milestone completion requires more than “feature done.”
- **Extension/XtraType objective:** learners can explain how disciplined closeout makes future extension safer and faster.

## 80-minute teaching script
1. **(0–10 min)** Setup: why pre-close is a technical activity, not admin overhead.
2. **(10–24 min)** Beginner lane: “quality checkpoint before release train departure” analogy.
3. **(24–52 min)** Builder lane: verification sweep scope and closure criteria.
4. **(52–64 min)** Operator lane: risk of carrying unresolved ambiguity into M2.
5. **(64–71 min)** Decision journal: move fast into next milestone vs explicit stabilization and ownership tagging.
6. **(71–78 min)** Proof walkthrough: pre-close checklist and verification summary artifacts.
7. **(78–80 min)** XtraType bridge: mature closeout discipline enables reliable downstream handoff.

## Instructor notes
- Require learners to classify at least one unresolved issue with owner + next action.
- Keep focus on accountability and reproducibility.

## Checks for understanding
- Why is “all tests green” not always sufficient for milestone readiness?
- What information must exist in a credible pre-close handoff package?

## Required class artifacts
- M1 pre-close checklist
- full verification summary note
- unresolved issues ledger with owners

## Teacher caution points
- Don’t normalize undocumented carry-over risks.
- Avoid milestone closeout based only on informal verbal status.

---

## Cross-day instructor notes (Days 16–20)

## Progression summary
- **Day 16:** establish safe structured observability.
- **Day 17:** stabilize baseline public route behavior.
- **Day 18:** operationalize health semantics and probe coverage.
- **Day 19:** produce startup evidence artifacts.
- **Day 20:** execute M1 stabilization and pre-close verification.

## Weekly formative assessment prompts
1. Explain how observability, health, and evidence reinforce one another in operational readiness.
2. Describe one failure path from Days 16–20 and how CRE8 makes it diagnosable.
3. Compare ad hoc operations practices with CRE8’s evidence-driven M1 closeout model.
4. Predict how Days 16–20 reduce risk entering M2 data/auth/policy implementation.

## Instructor handoff packet (end of Day 20)
Collect and archive:
- event/redaction verification artifacts,
- public route placeholder contract outputs,
- health contract test outputs,
- startup evidence samples,
- full M1 pre-close verification summary,
- unresolved issue ledger with owners,
- one-page bridge memo: “How Days 16–20 prepare Day 21 closeout and M2 entry.”

## Bridge forward (preview to Day 21 and M2)
Tell learners what comes next:
- Day 21 milestone closeout and signoff package,
- M2 start: migrations, principal/auth schema, token families, delegation and keychain persistence, and policy/auth core buildout.

This maintains continuity from runtime/ops foundations into core data/auth/policy implementation.
