# CRE8 Instructor Guide (Days 1–5)

_Status: draft narrative/teaching artifact_
_Last updated (UTC): 2026-04-12_

## How to use this guide
This guide standardizes instruction for the first five lessons of the CRE8 curriculum so any instructor can run a high-quality class while preserving the three program goals:
1. teach programming accessibly,
2. teach how CRE8 is made (day-by-day engineering journey),
3. prepare learners to understand, extend, and hand off CRE8 to application layers such as **XtraType**.

Each day includes:
- learning objectives across the three lanes (Beginner / Builder / Operator),
- components and sub-components covered,
- a timed teaching script,
- live-build teaching notes,
- checks-for-understanding,
- proof/evidence expectations,
- bridge notes to future milestones and XtraType.

---

## Program-wide lesson operating standard (apply every day)

### A) The three required objective threads
In every lesson, the instructor must explicitly address:
1. **Programming thread** — one coding concept learners can practice immediately.
2. **CRE8 build thread** — one concrete explanation of how this day advances platform construction.
3. **Platform extension thread** — one explicit statement showing how this foundation supports future extension and XtraType handoff.

### B) Audience lanes (always teach in this order)
1. **Beginner lane (plain language first):** core concept + metaphor + one immediate takeaway.
2. **Builder lane (implementation):** constraints, contracts, and exact engineering choices.
3. **Operator lane (quality/release):** what fails operationally if this work is skipped.

### C) Daily lesson blueprint (repeat every class)
1. What we are building today (2–4 min)
2. Why this matters in CRE8 (policy/contract/security context)
3. Live build walkthrough
4. Decision journal (chosen approach vs alternatives)
5. Proof of completion (tests/logs/artifacts)
6. User-facing translation
7. Bridge to XtraType

### D) Instructor delivery guardrails
- Use consistent terminology from canonical docs (SSOT, envelope, surface, traceability, evidence).
- Always show one failure path, not only happy path.
- Require learners to explain *why* a decision was chosen (not only *what* was coded).
- End every class with one “extendability checkpoint” question.

---

## CRE8 component map (orientation for instructors)

Use this map repeatedly so students understand where each day fits in the whole 90-day architecture.

1. **Governance and SSOT control plane**
   - reading order, ownership, change control, evidence discipline.
2. **Runtime foundation plane**
   - bootstrap, DI boundaries, middleware, config, request lifecycle.
3. **Contract plane**
   - OpenAPI/envelopes, route inventory, error mapping, UI runtime contract.
4. **Policy and security plane**
   - authn/authz/delegation/keychains, CSRF/CORS/rate/device controls.
5. **Data plane**
   - schema, migrations, seeds, transaction invariants.
6. **Ops and quality plane**
   - verification strategy, health/smoke, SLO/SLI, readiness gates.
7. **Traceability and handoff plane**
   - docs↔code↔tests mapping, ADRs, risk/gap updates, release evidence.

For Days 1–5, most activity sits in (1) + (2), while intentionally preparing (3)–(7).

---

## Day 1 — SSOT Workboard + Runtime Skeleton

## Day target
Establish project structure and governance mapping **before** feature coding so implementation can remain deterministic and auditable.

## Components and sub-components covered
- **Governance plane**
  - SSOT precedence awareness
  - workboard mapping to SSOT sections (00→80)
- **Runtime foundation plane**
  - initial repo skeleton (`src/`, `tests/`, `scripts/`)
  - baseline compile/lint sanity
- **Traceability plane (intro)**
  - first traceability seed entries

## Lesson objectives
- **Programming:** learners can explain why scaffolding and modular layout reduce future complexity.
- **How CRE8 is made:** learners can map one implementation task to one SSOT domain.
- **CRE8 extension/XtraType:** learners can explain why extension safety depends on predictable base structure.

## 70-minute teaching script
1. **(0–8 min) Story setup:** “Why not start with `/api/feed` today?”
2. **(8–20 min) Beginner lane:** project skeleton metaphor (blueprint before building rooms).
3. **(20–38 min) Builder lane:** create/inspect skeleton folders; explain module intent.
4. **(38–48 min) Operator lane:** what governance drift looks like in real teams.
5. **(48–58 min) Decision journal:** chosen path vs “start coding routes immediately.”
6. **(58–66 min) Proof review:** workboard export + structure diagram.
7. **(66–70 min) XtraType bridge:** “A stable base lets app teams extend safely.”

## Instructor notes
- Emphasize that “docs-first” is not anti-coding; it is anti-chaos.
- Ask one learner to trace a hypothetical future feature to an SSOT area.
- Capture one class artifact: “Today’s structure map.”

## Checks for understanding
- Can students name at least 3 SSOT families and where code for each likely lives?
- Can students explain one risk of skipping structure and governance mapping?

## Required class artifacts
- SSOT-mapped workboard snapshot
- repo structure diagram
- initial lint/compile output note

## Teacher’s caution points
- Avoid over-deep architecture lectures on Day 1.
- Keep jargon minimal; define SSOT every time it appears.

---

## Day 2 — Coding Standards + App Factory Bootstrap

## Day target
Turn “team preference” into enforceable, shared coding rules and prove minimal runtime boot path.

## Components and sub-components covered
- **Governance plane**
  - coding/review standards
  - deterministic envelope and error conventions (policy statement level)
- **Runtime foundation plane**
  - app factory bootstrap entrypoint
- **Traceability plane**
  - PR checklist seed for evidence + impact mapping

## Lesson objectives
- **Programming:** learners can explain why coding standards improve readability and defect prevention.
- **How CRE8 is made:** learners can describe why bootstrap exists before feature routes.
- **CRE8 extension/XtraType:** learners can explain why app extension needs stable style and startup conventions.

## 70-minute teaching script
1. **(0–10 min) Recap + setup:** from structure to executable baseline.
2. **(10–24 min) Beginner lane:** standardization analogy (shared grammar in language).
3. **(24–42 min) Builder lane:** walkthrough of standards checklist + app factory flow.
4. **(42–52 min) Operator lane:** regression risk when standards are deferred.
5. **(52–60 min) Decision journal:** “defer standards vs enforce now.”
6. **(60–67 min) Proof review:** standards doc + bootstrap smoke output.
7. **(67–70 min) XtraType bridge:** downstream maintainers inherit your conventions.

## Instructor notes
- Show one “bad” naming example and refactor it live.
- Keep focus on *determinism* and *consistency*, not personal style debates.

## Checks for understanding
- Can students state two things a standards doc should define on day 2?
- Can students explain what an app factory centralizes?

## Required class artifacts
- coding standards checklist
- bootstrap smoke run note
- reviewer checklist seed

## Teacher’s caution points
- Don’t let class drift into framework wars.
- Tie every rule back to maintenance, testing, or onboarding cost.

---

## Day 3 — DI Container Skeleton + CI Docs Checks

## Day target
Introduce dependency injection boundaries and fail-fast CI checks that enforce SSOT hygiene.

## Components and sub-components covered
- **Runtime foundation plane**
  - DI container/service registration map
  - mandatory security-service registration checks
- **Governance + traceability plane**
  - CI stubs for docs lint/sync/report
  - early automation as merge guardrail
- **Ops/quality plane (intro)**
  - fail-fast philosophy

## Lesson objectives
- **Programming:** learners can explain inversion of control and why constructors should not manually wire everything.
- **How CRE8 is made:** learners can describe why CI enforces documentation synchronization.
- **CRE8 extension/XtraType:** learners can explain how clear service boundaries accelerate app-specific feature additions.

## 75-minute teaching script
1. **(0–12 min) Concept intro:** what DI solves.
2. **(12–28 min) Beginner lane:** dependency metaphor (power strip vs hardwired appliances).
3. **(28–48 min) Builder lane:** service registration map and boundary rules.
4. **(48–58 min) Operator lane:** CI fail-fast and governance drift prevention.
5. **(58–66 min) Decision journal:** manual object creation vs DI container.
6. **(66–72 min) Proof review:** container resolution + CI artifacts.
7. **(72–75 min) XtraType bridge:** DI allows extension modules without rewriting the core.

## Instructor notes
- Emphasize testability gains: mockable boundaries are easier to verify.
- Explain that docs checks are engineering controls, not paperwork.

## Checks for understanding
- Can students identify one service that should be container-managed?
- Can students explain one failure mode CI docs checks prevent?

## Required class artifacts
- service registration map
- container resolution log
- CI docs-check artifact snapshot

## Teacher’s caution points
- Keep DI examples concrete; avoid abstract over-theory.
- Show at least one “what breaks without DI” example.

---

## Day 4 — Typed Config Contracts

## Day target
Model configuration as typed, validated application input rather than ad hoc string reads.

## Components and sub-components covered
- **Runtime foundation plane**
  - typed config structures (`RuntimeConfig`, `JwtPolicy`, `CorsPolicy`, `RateLimitPolicy`)
  - env-to-typed-field mapping
- **Policy/security plane (prelude)**
  - explicit configuration invariants for auth/cors/rate behavior
- **Quality plane**
  - config validation harness baseline

## Lesson objectives
- **Programming:** learners can explain the difference between typed config and free-form environment usage.
- **How CRE8 is made:** learners can show how runtime safety starts in config parsing.
- **CRE8 extension/XtraType:** learners can explain why extension teams need explicit config contracts to avoid production surprises.

## 75-minute teaching script
1. **(0–10 min) Recap + motivation:** “configuration bugs are code bugs.”
2. **(10–24 min) Beginner lane:** typed contracts analogy (form fields with validation).
3. **(24–50 min) Builder lane:** build/inspect typed structures and mapping logic.
4. **(50–60 min) Operator lane:** production incidents caused by weak config hygiene.
5. **(60–68 min) Decision journal:** typed strict parser vs loose runtime reads.
6. **(68–73 min) Proof review:** validation harness baseline.
7. **(73–75 min) XtraType bridge:** extension apps inherit config safety patterns.

## Instructor notes
- Show one malformed config example and expected deterministic failure.
- Reinforce “make invalid states unrepresentable.”

## Checks for understanding
- Can students name two benefits of typed config in security-sensitive systems?
- Can students identify one config area that should fail fast?

## Required class artifacts
- typed config map
- validation harness baseline output
- short “invalid config examples” worksheet

## Teacher’s caution points
- Avoid turning this into only syntax teaching.
- Keep linking config decisions to runtime correctness and security posture.

---

## Day 5 — Env Loader + Hardening Rules

## Day target
Implement fail-closed environment parsing and enforce profile-specific safety rules.

## Components and sub-components covered
- **Runtime foundation plane**
  - env loader + profile parser
  - APP_ENV profile branching logic
- **Policy/security plane**
  - issuer/CORS/DSN hardening checks
  - unsafe combination rejection
- **Quality/ops plane**
  - positive/negative env matrix tests

## Lesson objectives
- **Programming:** learners can describe parser/validator flow and explicit error pathways.
- **How CRE8 is made:** learners can explain why CRE8 rejects unsafe env states before serving traffic.
- **CRE8 extension/XtraType:** learners can explain how strong env contracts reduce deployment risk for CRE8-protected apps.

## 80-minute teaching script
1. **(0–10 min) Context setup:** from typed structures to real env loading.
2. **(10–24 min) Beginner lane:** “allow-list vs warn-only” safety mindset.
3. **(24–52 min) Builder lane:** profile parser flow + hardening rule examples.
4. **(52–64 min) Operator lane:** fail-closed behavior and incident prevention.
5. **(64–72 min) Decision journal:** warn-only parser vs fail-closed parser.
6. **(72–78 min) Proof review:** pass/fail env matrix output.
7. **(78–80 min) XtraType bridge:** safe deployment starts before code runs.

## Instructor notes
- Explicitly compare local convenience vs production safety.
- Show one “unsafe but tempting” config and why CRE8 blocks it.

## Checks for understanding
- Can students explain why fail-closed is chosen for stage/prod?
- Can students define one example of an unsafe env combination?

## Required class artifacts
- env validation matrix (pass/fail)
- parser decision flow diagram
- “unsafe config anti-patterns” class notes

## Teacher’s caution points
- Avoid framing strict checks as optional.
- Reinforce that deterministic denial is a feature, not friction.

---

## Cross-day instructor notes (Days 1–5)

## Progression summary
- **Day 1:** establish governance and structure.
- **Day 2:** standardize coding behavior and boot baseline.
- **Day 3:** enforce service boundaries and CI hygiene.
- **Day 4:** type and validate configuration contracts.
- **Day 5:** operationalize fail-closed env hardening.

## Weekly formative assessment prompts
1. Explain, in your own words, how SSOT governance changes daily coding behavior.
2. Describe how app factory + DI + typed config fit together.
3. Give one real scenario where fail-closed env parsing prevents production harm.
4. Predict how these five days help the upcoming auth and policy work in M2.

## Instructor handoff packet (end of Day 5)
Collect and archive:
- lesson artifacts from Days 1–5,
- decision-journal notes and rejected alternatives,
- learner misconceptions observed,
- improvement notes for pacing,
- a one-page bridge memo: “How Days 1–5 prepare M2 and XtraType handoff.”

## Bridge forward (preview to Days 6–10)
Tell learners what comes next:
- key material safety,
- startup assertions,
- request-id lifecycle,
- envelope responder,
- canonical error mapping.

This preserves continuity between foundation work and visible API behavior.
