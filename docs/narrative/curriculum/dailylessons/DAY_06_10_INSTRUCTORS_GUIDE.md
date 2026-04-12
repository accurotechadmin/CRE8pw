# CRE8 Instructor Guide (Days 6–10)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide continues the standardized instructor sequence from Days 1–5 and covers Days 6–10 of M1 runtime/governance foundations.

These five lessons advance the same three curriculum objectives:
1. teach programming in a clear, accessible way,
2. teach exactly how CRE8 is built and why each engineering choice exists,
3. prepare learners to understand extension and handoff to **XtraType** as the first CRE8-protected application.

## Instruction contract for every lesson (Days 6–10)
- Teach in three lanes: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison (chosen option vs rejected option).
- Demonstrate at least one **failure-path** example (not just success).
- Close with one **XtraType bridge** statement.
- End with one **proof artifact** learners can inspect.

---

## Day 6 — Key Material Safety Resolver

## Day target
Teach secure key-source handling and why cryptographic material must be validated before the app can be trusted.

## Components and sub-components covered
- **Runtime foundation plane**
  - key source resolver modes (inline PEM vs file path)
  - startup integration points for key loading
- **Security plane**
  - key path safety checks (permissions/readability/integrity assumptions)
  - fail-closed behavior for malformed or unsafe key material
- **Quality plane**
  - negative-path tests for invalid key states

## Lesson objectives
- **Programming objective:** learners can explain resolver logic and validation branching.
- **How CRE8 is made objective:** learners can describe why key safety is part of startup foundations, not optional hardening.
- **Extension/XtraType objective:** learners can explain how safe key handling protects downstream applications using CRE8 auth boundaries.

## 75-minute teaching script
1. **(0–8 min)** Recap Day 5 config hardening and introduce key trust boundary.
2. **(8–24 min)** Beginner lane: “why private keys are different from normal config.”
3. **(24–48 min)** Builder lane: resolver flow (inline/path), validation checks, fail conditions.
4. **(48–58 min)** Operator lane: production incident examples caused by weak key hygiene.
5. **(58–66 min)** Decision journal: strict permission checks vs host-only trust.
6. **(66–72 min)** Proof walkthrough: negative tests and sanitized failure output.
7. **(72–75 min)** XtraType bridge: secure platform keys protect app-layer trust.

## Instructor notes
- Teach “defense-in-depth” using simple examples.
- Keep learners focused on *why strict rejection is safer* than permissive startup.

## Checks for understanding
- Why is key loading treated as security-critical startup logic?
- What is one unsafe file-permission pattern that should block startup?

## Required class artifacts
- resolver decision diagram
- key safety negative test output
- short note: “what we block and why”

## Teacher caution points
- Do not frame strict checks as “enterprise-only.”
- Avoid exposing real key material in demonstrations.

---

## Day 7 — Startup Assertion Runner

## Day target
Introduce deterministic boot assertions so CRE8 refuses to serve traffic in unsafe or incomplete states.

## Components and sub-components covered
- **Runtime foundation plane**
  - startup assertion runner abstraction
  - assertion registration model
- **Governance/quality plane**
  - mandatory assertion list and ownership
  - startup failure classification for evidence
- **Security plane (bridge)**
  - required security services as boot prerequisites

## Lesson objectives
- **Programming objective:** learners can explain assertion orchestration and fail-fast startup flow.
- **How CRE8 is made objective:** learners can describe why boot-time guarantees reduce runtime ambiguity.
- **Extension/XtraType objective:** learners can explain why extension modules must satisfy base startup contracts.

## 75-minute teaching script
1. **(0–10 min)** Story setup: “What should the app prove before accepting requests?”
2. **(10–26 min)** Beginner lane: preflight checklist metaphor.
3. **(26–50 min)** Builder lane: assertion runner lifecycle and enforcement points.
4. **(50–60 min)** Operator lane: hidden-risk outcomes when apps boot “degraded.”
5. **(60–67 min)** Decision journal: block startup vs warn-only startup.
6. **(67–73 min)** Proof walkthrough: startup assertion report and failure simulation.
7. **(73–75 min)** XtraType bridge: reliable extension depends on reliable startup baseline.

## Instructor notes
- Remind learners that “passing tests” is not equivalent to “safe startup.”
- Pair each assertion with the risk it prevents.

## Checks for understanding
- What does deterministic startup mean in practice?
- Why is warn-only startup dangerous in policy-governed systems?

## Required class artifacts
- assertion catalog list
- startup pass/fail report sample
- brief risk-to-assertion mapping notes

## Teacher caution points
- Don’t over-index on framework mechanics; focus on system guarantees.
- Ensure students see both success and blocked-startup paths.

---

## Day 8 — Request ID Context Lifecycle

## Day target
Establish request correlation as an always-on runtime primitive for debugging, support, and auditability.

## Components and sub-components covered
- **Runtime foundation plane**
  - request context model
  - request_id creation and propagation mechanics
- **Contract plane (bridge)**
  - request_id presence in error and operational responses
- **Observability plane**
  - correlation consistency between middleware/handlers/emitted events

## Lesson objectives
- **Programming objective:** learners can describe immutable request context propagation.
- **How CRE8 is made objective:** learners can explain why correlation is foundational before business routes.
- **Extension/XtraType objective:** learners can explain how request_id enables faster support for extension apps.

## 70-minute teaching script
1. **(0–8 min)** Setup: from startup assertions to per-request traceability.
2. **(8–22 min)** Beginner lane: “tracking package IDs through a delivery system” metaphor.
3. **(22–44 min)** Builder lane: request_id generation, context flow, immutability rationale.
4. **(44–54 min)** Operator lane: incident triage without correlation IDs.
5. **(54–62 min)** Decision journal: immutable request_id vs regenerating IDs by layer.
6. **(62–68 min)** Proof walkthrough: propagation tests and sample payloads/log lines.
7. **(68–70 min)** XtraType bridge: support tooling relies on shared request IDs.

## Instructor notes
- Use one failing request example and show how request_id shortens diagnosis.
- Reinforce “single request, single correlation ID.”

## Checks for understanding
- Why should request_id be immutable after creation?
- Where should request_id appear for maximum operator usefulness?

## Required class artifacts
- request flow diagram with correlation points
- propagation test output
- sample support triage note using request_id

## Teacher caution points
- Avoid introducing multiple competing correlation tokens.
- Don’t skip showing error-path correlation behavior.

---

## Day 9 — Envelope Responder Abstractions

## Day target
Build consistent response-shaping primitives so every route can conform to canonical success/error envelope contracts.

## Components and sub-components covered
- **Contract plane**
  - success envelope responder
  - error envelope responder
  - metadata injection expectations
- **Runtime foundation plane**
  - centralized response abstraction usage points
- **Quality plane**
  - envelope schema-shape validation tests

## Lesson objectives
- **Programming objective:** learners can explain why response generation should be centralized.
- **How CRE8 is made objective:** learners can describe how envelope-first behavior enforces cross-route consistency.
- **Extension/XtraType objective:** learners can explain how consistent envelopes simplify client/app integration.

## 75-minute teaching script
1. **(0–10 min)** Setup: inconsistent route JSON as a maintenance hazard.
2. **(10–24 min)** Beginner lane: “shared message template” analogy.
3. **(24–50 min)** Builder lane: success/error responders and metadata requirements.
4. **(50–60 min)** Operator lane: diagnosis and UI drift problems from ad hoc payloads.
5. **(60–67 min)** Decision journal: centralized responders vs per-handler JSON building.
6. **(67–73 min)** Proof walkthrough: schema-shape test results.
7. **(73–75 min)** XtraType bridge: predictable API envelopes reduce app-client complexity.

## Instructor notes
- Tie this lesson directly to future UI runtime contract compliance.
- Ask learners to refactor one hypothetical ad hoc response into envelope form.

## Checks for understanding
- What minimum fields distinguish success vs error envelopes?
- Why is centralized response shaping better than route-local formatting?

## Required class artifacts
- responder interface sketch
- envelope conformance test output
- one before/after response example

## Teacher caution points
- Don’t let examples drift from canonical envelope vocabulary.
- Emphasize that envelope compliance includes failure paths.

---

## Day 10 — Canonical Error Mapper

## Day target
Translate exceptions and validation/auth/policy failures into stable, catalog-driven error codes and detail codes.

## Components and sub-components covered
- **Contract plane**
  - centralized error mapper
  - canonical HTTP/code/detail-code mappings
- **Runtime foundation plane**
  - mapper integration into response lifecycle
- **Quality/ops plane**
  - deterministic mapping tests across core failure classes
  - rejection of unknown/unregistered detail codes

## Lesson objectives
- **Programming objective:** learners can explain deterministic error mapping and code taxonomy discipline.
- **How CRE8 is made objective:** learners can describe why CRE8 blocks unknown detail codes.
- **Extension/XtraType objective:** learners can explain how stable error contracts improve client behavior and support workflows.

## 80-minute teaching script
1. **(0–10 min)** Setup: why “random error strings” create long-term system cost.
2. **(10–26 min)** Beginner lane: error taxonomy as a shared dictionary.
3. **(26–54 min)** Builder lane: mapping design, categories, detail-code constraints.
4. **(54–66 min)** Operator lane: incident triage impact of unstable errors.
5. **(66–73 min)** Decision journal: auto-generated details vs catalog-governed details.
6. **(73–78 min)** Proof walkthrough: mapping matrix tests (400/401/403/404/405/409/415/422/429/500).
7. **(78–80 min)** XtraType bridge: stable platform errors make extension UX and automation predictable.

## Instructor notes
- Make students compare two error payloads and identify which is supportable.
- Reinforce that consistency is both a developer-experience and operator-experience feature.

## Checks for understanding
- Why should unknown detail codes be rejected by design?
- How do stable error mappings help frontend and support teams?

## Required class artifacts
- error mapping matrix worksheet
- deterministic mapping test output
- one-page “error contract rules” summary

## Teacher caution points
- Do not normalize vague “internal error everywhere” behavior.
- Avoid one-off exception formatting that bypasses mapper policy.

---

## Cross-day instructor notes (Days 6–10)

## Progression summary
- **Day 6:** protect cryptographic key trust boundary.
- **Day 7:** enforce deterministic startup guarantees.
- **Day 8:** establish request-level observability correlation.
- **Day 9:** standardize response envelopes.
- **Day 10:** standardize error behavior and detail-code taxonomy.

## Weekly formative assessment prompts
1. Explain how Days 6–10 move CRE8 from “scaffolded runtime” to “contract-ready runtime.”
2. Describe the relationship between request_id, envelopes, and error mapping.
3. Give one example where permissive startup/config/error behavior would create security or support risk.
4. Predict how these five days prepare middleware ordering and security-header/CSP work in Days 11–15.

## Instructor handoff packet (end of Day 10)
Collect and archive:
- all proof artifacts (resolver checks, startup assertions, request_id tests, envelope tests, error mapper tests),
- decision journal entries with rejected alternatives,
- misconceptions observed and remediation notes,
- one-page bridge memo: “How Days 6–10 prepare Days 11–15 and future XtraType parity.”

## Bridge forward (preview to Days 11–15)
Tell learners what comes next:
- middleware order enforcement,
- security headers/CSP,
- CORS/content policy wiring,
- JSON/content-type validation,
- rate limiter baseline.

This keeps continuity from runtime contracts into surface-protection and abuse-control behavior.
