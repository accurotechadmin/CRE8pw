# CRE8 Technical Foundation Assessment and Pristine Rebuild Plan

_Status: draft_
_Last updated (UTC): 2026-04-08_

## 1) Objective of this document

This document provides a technical reset plan that:

1. Identifies which existing documentation is most mature and implementation-useful.
2. Evaluates strengths and weaknesses of the current implementation approaches in this repository.
3. Defines granular functional, technical, and architectural goals for CRE8.
4. Maps components, sub-components, and dependencies.
5. Recommends a streamlined “best possible” implementation approach for a new CRE8 iteration.

---

## 2) Documentation maturity assessment (what is most reliable to build from)

### 2.1 Tier A — Most mature, implementation-driving

These documents are currently the strongest foundation for rebuild guidance:

- `docs/SSOT/SSOT_INDEX.md`
  - Establishes governance, precedence, ownership, and canonical reading order.
  - Explicitly states SSOT precedence over non-SSOT docs and same-PR update expectations for contract changes.
- `docs/SSOT/Architecture_Reference.md`
  - Gives practical layer model and trust-surface structure.
- `docs/SSOT/Dependency_Reference.md`
  - Defines dependency baseline and package-level role boundaries.
- `docs/SSOT/Verification_Strategy.md`
  - Defines required command-level verification behavior and QA scope.
- `docs/SSOT/REBUILD_STRATEGY_OPTIONS_FOR_CRE8.md`
  - Evaluates alternatives and recommends a staged hybrid path (modular monolith + contract-first + policy extraction).
- `docs/SSOT/SSOT_CODEBASE_ALIGNMENT_ASSESSMENT_2026-04-06.md`
  - Identifies concrete implementation drifts (e.g., route and middleware documentation mismatches) and priorities.

### 2.2 Tier B — Mature strategic narrative with strong product clarity

- `docs/SSOT/CRE8_Spec.md`
  - Strong product/ethos narrative and concept framing.
  - Useful as guiding product model, but requires mapping into tighter technical acceptance criteria in canonical implementation docs.

### 2.3 Tier C — Useful but secondary (derived/explanatory)

- non-SSOT docs under `docs/*.md`
  - Strong onboarding references, but explicitly not canonical where conflict exists.

**Conclusion:** Build the new iteration from **Tier A SSOT**, use Tier B for intent, and regenerate Tier C from updated canon.

---

## 3) Current repository approaches: strengths and weaknesses

## 3.1 Approach A — Active runtime under root (`src/`, `public/`)

### What is good

- Strong runtime hardening via startup assertions and dependency/key/profile safety checks.
- Explicit middleware contract and per-surface policy distinctions (console vs gateway).
- Centralized route registration with extensive behavior coverage.
- Rich dependency set aligned with security, observability, and operations requirements.
- Existing contract/security test culture and operational smoke commands.

### What is weak

- Route orchestration file has grown very large and mixes transport, validation, and orchestration concerns in one locus.
- Some drift exists between SSOT contracts and implementation (documented in SSOT alignment assessment).
- Architecture is modular in intent but still heavily service-centric and route-centric in execution, creating scaling pressure for future extension.

## 3.2 Approach B — Rebuild scaffold under `code/`

### What is good

- Establishes module-oriented boundaries (`Kernel` + `Modules/*`) and use-case/handler/provider separation.
- Already includes SSOT automation scripts (`docs:ssot:lint`, `sync-check`, `report`) and a lean scaffold contract set.
- Encourages policy extraction and cleaner dependency direction.

### What is weak

- Still early-stage scaffold: many placeholders and TODOs.
- Current bootstrap uses in-memory/demo credentials in app wiring, which is useful for scaffold tests but not production shape.
- Incomplete DI/container and infra wiring means architecture value is mostly structural, not yet operational.

## 3.3 Approach C — Strategy alternatives in docs

### What is good

- Alternative options are clearly enumerated with tradeoffs.
- Recommended hybrid (1+2+3) is practical and aligned with known drift risks.

### What is weak

- Option space is broad; without explicit decision gates and phase exits, teams can mix patterns inconsistently.
- Plugin/kernel approach (Option 4) is attractive but likely premature before stable modular core contracts exist.

---

## 4) Granular goals for the new CRE8 iteration

## 4.1 Functional goals

1. **Identity and access surfaces**
   - Owner account bootstrap and authentication.
   - Key-based authentication (author/use/delegated access).
   - Refresh lifecycle and replay-safe token family behavior.
2. **Delegation and lifecycle**
   - Key issuance, scope/permission constraints, lifecycle transitions.
   - Delegation lineage and policy-limited inheritance.
3. **Content and moderation**
   - Post/comment creation and controlled read/update flows.
   - Moderation transitions and reasoned state changes.
   - Revision/provenance behavior where specified.
4. **Keychain capabilities**
   - Keychain listing + membership mutation + effective-resolution behavior (or explicitly defer with versioned deprecation).
5. **Operational endpoints**
   - deterministic `/`, `/health`, and JWKS behavior.
6. **UI/runtime parity contract**
   - no-build web UI behavior remains contract-checked where applicable.

## 4.2 Technical and architectural goals

1. **SSOT contract lock**
   - Runtime behavior must be mechanically checked against OpenAPI, route inventory, and error catalog.
2. **Modular monolith boundaries**
   - `Kernel` stable core + explicit domain modules.
3. **Ports/adapters discipline**
   - Domain logic must not depend directly on framework or storage internals.
4. **Policy extraction**
   - High-risk decision logic lives in pure policy units with exhaustive tests.
5. **Fail-closed startup and environment governance**
   - Keep and formalize existing hardened startup rules.
6. **Observability and audit consistency**
   - Structured events and redaction guarantees.
7. **Release confidence**
   - Verification strategy and smoke checks as release gates.

---

## 5) Component map (system decomposition)

## 5.1 Kernel (cross-module core)

- Boot and startup (`AppFactory`, `BootChecks`, `ContainerFactory`)
- Runtime config and environment validation
- HTTP envelope and request context primitives
- Middleware pipeline assembly
- Common observability interfaces (audit/log/tracing context)

## 5.2 Domain modules

### Auth module
- Owner login/registration/refresh use cases
- Key login and token issuance surfaces
- Credential policies

### Delegation module
- Delegation envelope rules
- Parent/child scope and depth constraints
- Keychain membership and resolution policies

### Content module
- Post lifecycle and visibility
- Comment behavior and permissions
- Revision/provenance controls

### Moderation module
- Moderation decision policies
- Action constraints and reason taxonomy

### Health/Operations module
- health probes (DB, limiter, key material, dependencies)
- operational readiness signals

## 5.3 Infrastructure adapters

- PDO repositories + transaction boundaries
- JWT signer/verifier + key material resolver
- Rate-limiter/cache adapter
- Outbound HTTP adapter (for integration dependencies)
- Logging/audit adapter

## 5.4 Interface layer

- HTTP handlers per route capability
- Request validators / DTO mappers
- Response envelope serializers
- UI runtime static contract mappings

---

## 6) Dependency baseline and responsibility map

## 6.1 Runtime and framework
- `slim/slim`: routing + middleware orchestration
- `slim/psr7`: HTTP request/response primitives
- `php-di/php-di`: module wiring / dependency composition

## 6.2 Security and auth
- `firebase/php-jwt`: JWT encode/decode + claim enforcement support
- `ext-sodium`: Argon2id/crypto-safe primitives

## 6.3 Data and validation
- `ext-pdo`: persistence and transactions
- `respect/validation`: request contract validation

## 6.4 Ops and reliability
- `vlucas/phpdotenv`: env loading
- `neomerx/cors-psr7`: CORS policy enforcement
- `symfony/rate-limiter` + `symfony/cache`: throttling and state persistence
- `monolog/monolog`: structured logging/audit channels
- `guzzlehttp/guzzle`: outbound dependency calls

## 6.5 Quality gates
- `phpunit/phpunit`: unit/contract/security/integration verification
- SSOT scripts (`docs:ssot:lint`, `docs:ssot:sync-check`, `docs:ssot:report`) as anti-drift controls

---

## 7) Relationship map (high-level)

```text
SSOT Canon
  ├─ Product + terminology + architecture + API/data/security/ops contracts
  ├─ Traceability + acceptance + verification
  └─ Automation (lint/sync/report)
       ↓ constrains
Kernel + Modules (Modular Monolith)
  ├─ Kernel (boot/config/envelope/pipeline/observability)
  ├─ Auth
  ├─ Delegation
  ├─ Content
  ├─ Moderation
  └─ Health/Ops
       ↓ exposed through
HTTP Surface Contracts
  ├─ Public
  ├─ Gateway
  └─ Console
       ↓ validated by
Contract + Security + Integration + Smoke suites
```

---

## 8) Recommended pristine implementation approach

### 8.1 Chosen approach

Adopt the hybrid path as the default implementation strategy:

1. **Modular monolith backbone** (clear module boundaries, one deployable unit).
2. **Contract-first runtime enforcement** (OpenAPI + route inventory + error catalog sync in CI).
3. **Policy-first domain extraction** (pure policy units for high-risk auth/delegation/content decisions).

### 8.2 Explicit design constraints (non-negotiable)

1. SSOT and code changes ship together for any behavior/policy modifications.
2. No direct DB/framework coupling inside policy/domain core.
3. Route handlers stay thin (validate → invoke use case → map envelope).
4. Every surface-sensitive behavior has at least one contract test and one security-oriented edge test.
5. Release gates require passing SSOT sync checks and smoke checks.

### 8.3 Implementation phases (streamlined)

## Phase 0 — Canon lock and drift closure
- Freeze baseline SSOT docs for v1 scope.
- Close known drifts (keychain route mismatch, middleware order mismatch, script contract mismatch, naming mismatches).

## Phase 1 — Kernel hardening
- Implement stable `Kernel` boot/config/container/pipeline primitives.
- Port startup safety/profile checks and deterministic error envelope behavior.

## Phase 2 — Auth + Delegation spine
- Implement owner/key auth + refresh with strict policy units.
- Implement key lifecycle and delegation/keychain policy core.

## Phase 3 — Content + Moderation
- Implement content, comments, moderation, and revision flows with policy checks.

## Phase 4 — Contract enforcement and operationalization
- Wire route/OpenAPI/error-code diffs into CI.
- Enforce verification commands and smoke evidence in release workflow.

## Phase 5 — Extension readiness
- Publish extension boundary contracts and compatibility policy.
- Add reference extension/module skeleton for downstream builders.

---

## 9) Immediate execution backlog (next tactical steps)

1. Create v1 “Canonical Core SSOT Set” checklist with status per doc.
2. Produce “Drift Closure Patch Plan” with one issue per documented drift.
3. Define module boundary rules in an architecture testable format.
4. Draft route-to-use-case map for each trust surface.
5. Draft security abuse-case matrix tied to policy classes.

---

## 10) Success criteria for this new iteration

1. **No SSOT/runtime drift** at release time (automated checks pass).
2. **All critical flows policy-tested** (auth, refresh, delegation, moderation).
3. **Module boundaries enforced** via architecture tests and review rules.
4. **Operational readiness repeatable** via smoke contracts and release checklist evidence.
5. **Developer extension path clear** with documented stable extension points.

This is the technical master plan for building the next CRE8 iteration as a streamlined, high-integrity, and extensible platform.

## Session progress (2026-04-08)
### Completed in this session
- Reviewed document scope and retained scaffold sections needed for full authoring.
- Kept this file aligned with SSOT-first canon structure.
### Remaining to finish this document
- [ ] Expand domain-specific canonical content beyond scaffold level.
- [ ] Resolve open questions and convert to approved status.
- [ ] Link normative statements to code/tests and verification evidence.

