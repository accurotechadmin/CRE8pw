# CRE8 Instructor Guide (Days 11–15)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## Purpose
This guide extends the standardized instructor sequence for the 90-day CRE8 curriculum and covers Days 11–15 of M1.

These lessons continue the three core curriculum objectives:
1. teach programming in practical, beginner-accessible steps,
2. teach exactly how CRE8 is engineered in production-oriented sequence,
3. teach how CRE8 is intended to be extended and handed off (with **XtraType** as the first official CRE8-protected application).

## Instruction contract for every lesson (Days 11–15)
- Teach in lane order: **Beginner → Builder → Operator**.
- Include one explicit **decision journal** comparison.
- Show at least one **negative/failure path** behavior.
- End with one concrete **proof artifact** and one **XtraType bridge** statement.
- Tie each day to downstream milestone readiness (M2/M3/M4).

---

## Day 11 — Middleware Order Enforcement

## Day target
Teach why deterministic middleware order is a contract-level behavior and how to enforce that order at boot.

## Components and sub-components covered
- **Runtime foundation plane**
  - middleware registration constants/order map
  - boot-time order assertion
- **Contract plane**
  - request pipeline sequence expectations
  - failure mapping consistency dependence on order
- **Quality plane**
  - middleware-order tests and startup failure simulation

## Lesson objectives
- **Programming objective:** learners can explain chain-of-responsibility ordering and side effects.
- **How CRE8 is made objective:** learners can describe why CRE8 enforces middleware order at startup.
- **Extension/XtraType objective:** learners can explain how extension routes remain safe only when pipeline order is stable.

## 75-minute teaching script
1. **(0–10 min)** Setup: recap Days 6–10 and introduce pipeline determinism.
2. **(10–24 min)** Beginner lane: “assembly line order” metaphor.
3. **(24–48 min)** Builder lane: order constants, registration, and assertion logic.
4. **(48–58 min)** Operator lane: security/QA regression risks when order drifts.
5. **(58–66 min)** Decision journal: documented order only vs enforced order.
6. **(66–72 min)** Proof walkthrough: order test + startup fail case.
7. **(72–75 min)** XtraType bridge: extensions inherit core pipeline guarantees.

## Instructor notes
- Make learners trace one request through each middleware stage.
- Highlight that order is part of external behavior, not internal preference.

## Checks for understanding
- Why is boot-time order assertion stronger than team convention?
- What can break if auth and validation middleware are swapped?

## Required class artifacts
- middleware order diagram
- order assertion test output
- startup failure evidence snippet

## Teacher caution points
- Don’t present middleware order as “easy to change later.”
- Avoid skipping negative-order examples.

---

## Day 12 — Security Headers + CSP Baseline

## Day target
Teach path-aware browser security controls and why headers must remain consistent even on error responses.

## Components and sub-components covered
- **Security plane**
  - security header baseline policy
  - CSP policy by path context (`/ui*` vs non-UI)
- **Contract plane**
  - header behavior on success and error envelopes
- **Quality plane**
  - header/CSP verification tests across route categories

## Lesson objectives
- **Programming objective:** learners can explain middleware-based response hardening.
- **How CRE8 is made objective:** learners can describe why CSP is path-aware in CRE8.
- **Extension/XtraType objective:** learners can explain how secure defaults protect extension UI surfaces.

## 75-minute teaching script
1. **(0–8 min)** Setup: from pipeline order to policy payloads on responses.
2. **(8–24 min)** Beginner lane: “default locks on every door” metaphor.
3. **(24–50 min)** Builder lane: header set, CSP branching strategy, error-path preservation.
4. **(50–60 min)** Operator lane: attack surface increase from permissive/inconsistent headers.
5. **(60–67 min)** Decision journal: single permissive CSP vs path-aware CSP.
6. **(67–73 min)** Proof walkthrough: header/CSP tests (success + error paths).
7. **(73–75 min)** XtraType bridge: stronger platform headers reduce app-level security debt.

## Instructor notes
- Show one public route and one UI route with differing CSP intent.
- Emphasize that failure responses also need security headers.

## Checks for understanding
- Why preserve security headers on error paths?
- Why is path-aware CSP preferred over one broad policy?

## Required class artifacts
- header policy checklist
- CSP path matrix
- header verification test output

## Teacher caution points
- Avoid oversimplified “CSP on/off” framing.
- Do not ignore browser-facing threat context.

---

## Day 13 — CORS + Content Policy Wiring

## Day target
Teach safe cross-origin behavior and profile-specific CORS enforcement to prevent permissive production exposure.

## Components and sub-components covered
- **Security plane**
  - CORS middleware integration
  - origin allow-list policy by environment profile
- **Runtime/config plane**
  - typed CORS config consumption
  - local-vs-stage/prod policy handling
- **Quality plane**
  - preflight and denied-origin negative-path tests

## Lesson objectives
- **Programming objective:** learners can explain preflight handling and explicit origin checks.
- **How CRE8 is made objective:** learners can describe why wildcard behavior is constrained to local development.
- **Extension/XtraType objective:** learners can explain how extension frontends rely on predictable cross-origin policy.

## 70-minute teaching script
1. **(0–8 min)** Setup: browser-origin controls in real APIs.
2. **(8–22 min)** Beginner lane: “guest list at the door” analogy.
3. **(22–44 min)** Builder lane: CORS config, preflight flow, allowed/denied outcomes.
4. **(44–54 min)** Operator lane: incident scenarios from permissive production CORS.
5. **(54–62 min)** Decision journal: convenience wildcard vs profile-constrained allow-list.
6. **(62–68 min)** Proof walkthrough: CORS env matrix tests.
7. **(68–70 min)** XtraType bridge: stable CORS policy supports safe UI/API integration.

## Instructor notes
- Walk through one request that passes locally but fails in production profile (and why).
- Tie policy choices back to previously taught env hardening.

## Checks for understanding
- Why is `*` dangerous in stage/prod contexts?
- What distinguishes preflight validation from actual request authorization?

## Required class artifacts
- CORS profile matrix
- preflight pass/deny test output
- “CORS anti-patterns” class note

## Teacher caution points
- Don’t conflate CORS with authentication.
- Avoid teaching permissive defaults as acceptable shortcuts.

---

## Day 14 — JSON/Content-Type Validation Middleware

## Day target
Teach strict input boundary validation so malformed or incompatible payloads fail deterministically with canonical errors.

## Components and sub-components covered
- **Contract plane**
  - JSON/content-type entry constraints
  - canonical malformed input failure behavior
- **Runtime foundation plane**
  - validation middleware primitives
  - reusable request validators
- **Quality plane**
  - malformed JSON and content-type negative tests

## Lesson objectives
- **Programming objective:** learners can explain boundary validation before business logic execution.
- **How CRE8 is made objective:** learners can describe why CRE8 treats malformed payload handling as contract behavior.
- **Extension/XtraType objective:** learners can explain how strict input contracts reduce downstream extension ambiguity.

## 75-minute teaching script
1. **(0–10 min)** Setup: “garbage in, guaranteed confusion out.”
2. **(10–24 min)** Beginner lane: input contract analogy (correct form format required).
3. **(24–50 min)** Builder lane: content-type checks, parse guards, canonical 400/422 mapping expectations.
4. **(50–60 min)** Operator lane: support burden when parse failures are inconsistent.
5. **(60–67 min)** Decision journal: permissive parsing vs strict request boundary checks.
6. **(67–73 min)** Proof walkthrough: malformed JSON/content-type tests.
7. **(73–75 min)** XtraType bridge: predictable validation behavior improves client development speed.

## Instructor notes
- Demonstrate one malformed payload and one wrong content-type case.
- Reinforce that validation boundary is a security and reliability control.

## Checks for understanding
- Why validate content-type before parsing body semantics?
- What is the benefit of deterministic error response for malformed input?

## Required class artifacts
- validation flow sketch
- malformed request test output
- canonical input-failure examples

## Teacher caution points
- Don’t blur validation and authorization responsibilities.
- Avoid ad hoc parser behavior that bypasses middleware guardrails.

---

## Day 15 — Rate Limiter Baseline

## Day target
Teach abuse-control fundamentals and deterministic 429 behavior with retry metadata.

## Components and sub-components covered
- **Security/abuse-control plane**
  - baseline limiter policy integration
  - route-surface limiting considerations
- **Contract plane**
  - canonical 429 responses
  - retry metadata semantics
- **Quality/ops plane**
  - allow/deny/retry behavior tests
  - limiter evidence for later readiness gates

## Lesson objectives
- **Programming objective:** learners can explain limit window/counter behavior and retry signaling.
- **How CRE8 is made objective:** learners can describe how rate limiting complements auth and validation in the request pipeline.
- **Extension/XtraType objective:** learners can explain how limiter policy protects extension apps from abuse and overload.

## 80-minute teaching script
1. **(0–10 min)** Setup: from input correctness to traffic-shaping controls.
2. **(10–24 min)** Beginner lane: “venue capacity and queue control” metaphor.
3. **(24–54 min)** Builder lane: limiter config wiring, decision points, 429 payload + metadata.
4. **(54–66 min)** Operator lane: abuse/flood patterns and observability implications.
5. **(66–73 min)** Decision journal: bare 429 vs 429 with retry guidance.
6. **(73–78 min)** Proof walkthrough: pass/deny/retry tests.
7. **(78–80 min)** XtraType bridge: controlled traffic improves end-user reliability for app extensions.

## Instructor notes
- Compare user experience with and without retry guidance.
- Emphasize that rate limiting is not only anti-abuse; it preserves service quality.

## Checks for understanding
- Why include retry metadata in limiter denials?
- How does rate limiting interact with earlier middleware layers?

## Required class artifacts
- limiter policy sheet
- 429 response examples
- limiter contract test output

## Teacher caution points
- Don’t treat rate limiting as optional “post-launch” hardening.
- Avoid one-size-fits-all thresholds without context explanation.

---

## Cross-day instructor notes (Days 11–15)

## Progression summary
- **Day 11:** enforce deterministic pipeline behavior.
- **Day 12:** harden browser-facing response security.
- **Day 13:** enforce safe cross-origin policy by profile.
- **Day 14:** enforce strict input boundary behavior.
- **Day 15:** add baseline abuse controls and retry semantics.

## Weekly formative assessment prompts
1. Explain how pipeline order, headers, CORS, validation, and rate limiting form a layered defense model.
2. Describe one failure scenario prevented by each day’s primary component.
3. Compare “convenience-first” vs “contract-first” decisions made during Days 11–15.
4. Predict how Days 11–15 prepare event emitter and health-contract work in Days 16–20.

## Instructor handoff packet (end of Day 15)
Collect and archive:
- middleware order evidence,
- header/CSP verification outputs,
- CORS matrix and preflight tests,
- validation middleware failure-path outputs,
- limiter behavior evidence,
- decision journal and rejected alternatives,
- one-page bridge memo: “How Days 11–15 prepare Days 16–20 and M1 closeout.”

## Bridge forward (preview to Days 16–20)
Tell learners what comes next:
- structured observability event emitter + redaction,
- baseline public route placeholders,
- health service scaffold,
- startup evidence writer,
- M1 pre-close stabilization and milestone review.

This preserves continuity from request-protection controls into operational readiness and milestone closure.
