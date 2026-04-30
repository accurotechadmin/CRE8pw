# CRE8 — Canonical Project SSOT

CRE8 is a **Credential Registry Engine**: a policy-governed PHP 8.5 / Slim 4 platform for credentialed identity, bounded delegated authority, and governed interaction with protected content (posts, comments, audience-targeted feeds). Authority is explicit, hierarchical, monotonically bounded, and auditable at every step — issuance, delegation, use, moderation, rotation, revocation, and evidence export.

This `README.md` is the **root project-level SSOT anchor**. It establishes mandatory platform direction, documentation governance, repository topology, and program execution status. Everything in this file is binding on subordinate documents under `docs/`, `seed/`, and `reports/`, subject to the precedence rules in §10.

CRE8 uses a deliberate two-class key architecture:

- **ID Keypairs** — internal identity anchors and lineage roots. Every minted Primary Author, Secondary Author, and Use principal MUST receive an ID Keypair atomically at mint.
- **Utility Keypairs** — context-scoped operational credentials (per service / app / device / tenant / use-case) derived from an ID Keypair’s lineage. New contexts MUST be served by new utility keys, not by widening existing ones.

Every behavior the platform exposes — authorization, lifecycle, content visibility, error mapping, observability, release gating — must remain consistent with this separation and with the bounded delegation model described below.

---

## Table of Contents

1. [Platform Purpose and Scope](#1-platform-purpose-and-scope)
2. [Normative Architecture Commitments](#2-normative-architecture-commitments)
3. [Authority, Delegation, and Governance Model](#3-authority-delegation-and-governance-model)
4. [Surfaces and Boundary Contracts](#4-surfaces-and-boundary-contracts)
5. [Contract and Error Determinism](#5-contract-and-error-determinism)
6. [Security, Trust, and Lifecycle Expectations](#6-security-trust-and-lifecycle-expectations)
7. [Implementation Stack and Dependency Bedrock](#7-implementation-stack-and-dependency-bedrock)
8. [Repository Structure and Canon Ownership](#8-repository-structure-and-canon-ownership)
9. [Documentation Program Map (Required Topology)](#9-documentation-program-map-required-topology)
10. [SSOT Precedence and Change Control Rules](#10-ssot-precedence-and-change-control-rules)
11. [Reports Policy for Session and Automation Output](#11-reports-policy-for-session-and-automation-output)
12. [Program Phases — Status and Forward Plan](#12-program-phases--status-and-forward-plan)
13. [How to Contribute and How to Resume Work](#13-how-to-contribute-and-how-to-resume-work)
14. [Verification and CI Posture](#14-verification-and-ci-posture)
15. [Authoritative Entry Points](#15-authoritative-entry-points)

---

## 1. Platform Purpose and Scope

CRE8 exists to provide a reliable platform for credentialed identity, delegated authority, and governed interaction with protected content and workflows. The system is engineered so authority is explicit, bounded, and auditable across its full lifecycle.

The repository is currently **documentation-first**. There is no `src/` or `tests/` tree. The intent is that the SSOT corpus reaches a state of completeness sufficient to drive a production codebase without requiring the implementation team (human or LLM) to make architectural decisions on behalf of the spec. The current authoring program (Phase 3 — Canon Completion, see §12) is what closes that gap.

When the SSOT corpus is finalized under Phase 3, the platform exposes:

- a **Public/bootstrap surface** for service entry and setup prerequisites,
- an **API/Gateway surface** for operational client activity under delegated credentials,
- an **Owner Console surface** for governance, lifecycle, moderation, and administrative control,
- a deterministic policy decision engine, immutable provenance, lifecycle-aware credential governance, and a developer-first extension model.

---

## 2. Normative Architecture Commitments

The following commitments are mandatory and non-optional. Subordinate documents express these as `CRE8-<DOMAIN>-REQ-####` requirements; this section is the canonical statement of intent.

1. **ID-Keypair-first issuance.** Every minted principal (Owner, Primary Author, Secondary Author, Use) receives an ID Keypair as the lineage root for descendant capabilities. Mint operations fail closed if ID-keypair creation does not commit atomically.
2. **Utility-keypair compartmentalization.** Utility Keypairs are context-scoped credentials. In-place scope widening is prohibited; new contexts are served by issuing new utility keys.
3. **Deterministic policy and contract behavior.** Authorization decisions and API success/error behavior must be reproducible from explicit input/state and bound to stable, versioned envelopes.
4. **Bounded hierarchical delegation.** Owner → Primary Author → (Secondary Author and Use) → Use. Descendants never exceed ancestor envelopes (permission subset, scope, depth, lifecycle, expiry). PDP/middleware is the sole authorization authority; handlers MUST NOT remap.
5. **Auditability and provenance continuity.** Governance, lifecycle, and content-significant actions emit immutable provenance events with correlation IDs. Revocation/rotation impact is inspectable and explainable.
6. **Documentation-to-implementation binding.** SSOT statements are implementation directives once marked normative. Behavioral requirements MUST cite the Composer dependency that enforces them (see §7) where one applies.

---

## 3. Authority, Delegation, and Governance Model

CRE8 authority is hierarchical and bounded:

- **Owner** sets permissions and delegation envelopes for **Primary Author Keys** it creates.
- **Primary Author** sets permissions and delegation envelopes for **Secondary Author** and **Use Keys** it creates.
- **Secondary Author** sets permissions and delegation envelopes for **Use Keys** it creates.
- Each tier explicitly controls which descendant permissions are themselves further delegateable.

Effective permission evaluation always accounts for granted permissions, explicit denies, scope boundaries, delegation depth, lifecycle state, and expiry. **Deny is the default outcome under ambiguity** — the system fails closed.

Keychain composition (aggregating capabilities across multiple grants) is a first-class governance concern. Aggregated capabilities MUST preserve provenance and remain derivable from constituent grants.

Authoritative behavior for delegation lives in:

- `docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md`
- `docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md`
- `docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md`

---

## 4. Surfaces and Boundary Contracts

CRE8 is a multi-surface platform with strict boundary semantics:

- **Owner Console** — owner-only governance, lifecycle, moderation, and administrative actions.
- **API/Gateway** — operational client activity under delegated credentials.
- **Public/bootstrap** — service entry, setup prerequisites, and unauthenticated endpoints.

Boundary rule: authentication and authorization contexts are **not interchangeable across surfaces** unless explicitly specified by canonical contract. Cross-surface parity is mandatory for supported capabilities; documented exceptions (`ui_only`, `api_only`) MUST carry justification, owner, and review-due metadata. See `docs/30_contracts_and_interfaces/UI_RUNTIME_CONTRACT.md`.

---

## 5. Contract and Error Determinism

CRE8 interfaces are contract-first:

- Success responses use the stable envelope `{data, meta}` with required `meta.request_id`, `meta.timestamp_utc`, `meta.contract_version`.
- Error responses use the stable envelope `{error, meta}` with required `error.code`, `error.message`, `error.category`, `error.request_id`, `error.timestamp_utc`, optional `error.details[]`.
- Error codes are stable, uppercase snake-case strings with bounded categories: `AUTHN_*`, `AUTH_DENY_*`, `INPUT_*`, `LIFECYCLE_*`, `SYSTEM_*`.
- Authorization denies map one-to-one to deterministic codes (`AUTH_PERMISSION_DENIED`, `AUTH_SCOPE_DENIED`, `AUTH_EXPLICIT_DENY`, `AUTH_DEPTH_EXCEEDED`, `AUTH_GRANT_EXPIRED`, `AUTH_LIFECYCLE_BLOCKED`, etc.).
- Machine artifacts (OpenAPI 3.1 + JSON Schema 2020-12) are required contract companions and MUST stay synchronized with prose specs. CI enforces parity via `composer docs:ssot:route-parity`.

Authoritative artifacts:

- `docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`
- `docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`
- `docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md`
- `docs/31_machine_contracts/openapi/cre8.v1.yaml`
- `docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`
- `docs/31_machine_contracts/schemas/*.schema.json`

---

## 6. Security, Trust, and Lifecycle Expectations

Security posture is layered and lifecycle-aware:

- Proof-oriented request validation: `public_key_id` + `nonce` + `timestamp` + `signature`.
- Anti-replay (nonce uniqueness within a configured window) and clock-skew controls.
- One-time private-key reveal at issuance; subsequent retrieval attempts deny deterministically.
- Immediate enforcement for `suspend` / `revoke` / `rotate` transitions, propagating to descendant utility credentials when ancestor policy requires.
- Immutable governance/provenance events on every security-significant mutation, transactionally committed alongside the state change.

Lifecycle states for keys: `issued`, `active`, `suspended`, `rotated`, `revoked`, `expired`. Each transition emits an audit event with actor, prior state, next state, scope, and timestamp.

Authoritative artifact today: `docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md`. Threat model, controls spec, headers/CSP policy, abuse cases, and crypto-profile documents are scheduled for completion under Phase 3 milestone M7.

---

## 7. Implementation Stack and Dependency Bedrock

The runtime is **PHP 8.5** (Composer constraint `^8.5.5`, platform pin `8.5.5`) under **Slim 4**. The seed canon (`seed/seed-intro.md` §14) declares the Composer dependency set as architectural bedrock, not optional utilities. Every SSOT document that specifies behavior MUST cite the dependency that enforces it.

| Concern | Dependency |
|---|---|
| Surface routing, middleware order, error pipeline | `slim/slim` |
| Immutable PSR-7 request/response primitives | `slim/psr7` |
| Composition root for services, repositories, middleware | `php-di/php-di` |
| Token mint/verify, `iss`/`aud`/`exp`/`typ`, JWKS validation | `firebase/php-jwt` |
| Argon2id hashing, CSPRNG, constant-time compare, signing | `ext-sodium` |
| Prepared statements, transactional policy/audit writes | `ext-pdo` |
| Composable request validators, deterministic 422 mapping | `respect/validation` |
| Startup env loading, required-key assertions, typed parsing | `vlucas/phpdotenv` |
| Outbound integrations (JWKS, webhook, service calls) | `guzzlehttp/guzzle` |
| CORS policy enforcement | `neomerx/cors-psr7` |
| Structured app/security/audit channels with correlation | `monolog/monolog` |
| Policy buckets, burst control, limiter-state persistence | `symfony/rate-limiter` + `symfony/cache` |
| Contract/middleware/security/lifecycle regression suites | `phpunit/phpunit` |

`composer.json` is the runtime contract baseline. `dot.env` is the environment-template scaffold. `.htaccess` defines deployment routing for Apache environments.

---

## 8. Repository Structure and Canon Ownership

| Path | Purpose | Canon role |
|---|---|---|
| `README.md` | Root project-level SSOT direction and constraints | Normative anchor (this file) |
| `docs/` | Domain-partitioned canonical documentation | Normative once promoted |
| `seed/` | Seed-canon baseline (origin truths) | Authoritative until superseded by `docs/` |
| `reports/` | Session reports, audits, plans, progress boards, archived responses | Informational unless explicitly promoted |
| `scripts/` | PHP tooling for SSOT lint/sync/report and contract tests | Implementation of verification hooks |
| `.github/workflows/` | CI gates, including `ssot_phase_gate.yml` | Enforces SSOT discipline |
| `composer.json` | PHP 8.5 dependency baseline + script catalog | Runtime contract baseline |
| `dot.env` | Environment-template example only — never use real secrets | Configuration scaffold |
| `.htaccess` | Apache deployment routing scaffold | Deployment hint |

There is no `src/` or `tests/` directory yet. Both are introduced after Phase 3 (Canon Completion) closes; see §12.

---

## 9. Documentation Program Map (Required Topology)

```text
docs/
  00_governance/
  10_product_and_architecture/
  20_identity_delegation_and_policy/
  30_contracts_and_interfaces/
  31_machine_contracts/
    openapi/
    schemas/
  40_data_security_and_crypto/
  50_content_audience_and_feed/
  60_operations_quality_and_release/
  70_extensibility_and_module_patterns/
  80_traceability_decisions_and_program/
    records/
  evidence/
    automation/
    templates/
seed/
reports/
  session_handoffs/
  session_prompts/
  session_responses/
  ssot/
```

This structure is mandatory. New canonical SSOT artifacts MUST be added inside the correct domain folder and wired into governance/index/traceability documents in the same change set. The primary governance entry point is `docs/00_governance/SSOT_INDEX.md`.

---

## 10. SSOT Precedence and Change Control Rules

Until superseded by more granular governance documents, precedence is:

1. **`README.md`** — root project-level SSOT direction and constraints (this file).
2. **Mature canonical documents under `docs/`** — `status: normative`.
3. **Provisional documents under `docs/`** — `status: provisional-normative`, authoritative for bounded implementation.
4. **Seed documents under `seed/`** — fallback when mature canon detail is not yet authored.
5. **`reports/` outputs** — informational/non-normative unless explicitly promoted by governance-controlled change.

Every normative change MUST include scope statement, impacted requirement IDs, compatibility classification (`compatible`, `conditionally-compatible`, `breaking`), migration notes, required verification updates, and traceability consequences. See `docs/00_governance/CHANGE_CONTROL_POLICY.md`, `docs/00_governance/DEFINITION_OF_DONE.md`, and `docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`.

---

## 11. Reports Policy for Session and Automation Output

All LLM-generated reports, working analyses, and session response artifacts go under `reports/`. SSOT domain folders under `docs/` are reserved for canonical artifacts, templates, machine contracts, and evidence documents.

Within `reports/`:

- `reports/session_handoffs/` — structured per-session handoffs and progress boards (Phase 1, Phase 2, Phase 3).
- `reports/session_prompts/` — verbatim prompt records and historical execution prompts.
- `reports/session_responses/` — full final response archives from authoring sessions.
- `reports/ssot/` — machine-generated SSOT coverage reports (e.g., `coverage_latest.json`).
- `reports/change_impact_maps/` — Phase 3-required change-impact maps for machine-artifact changes (created on demand).

---

## 12. Program Phases — Status and Forward Plan

The historical Phase 3 ("operational readiness integration") and Phase 4 ("scaled domain expansion") originally listed in this file have been **consolidated into a single Phase 3 — Canon Completion** that subsumes both. The canonical plan is `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`. ADR-004 (when authored under M0) ratifies the consolidation.

### Phase 1 — Canon hardening (closed by ADR-003, 2026-04-29)

- Upgraded scaffold docs to normative requirements where applicable.
- Established cross-document links, ownership metadata, and review workflow.
- Defined verification hooks for major behavioral contracts.
- Closed via ADR-003 with explicit residual-breadth waiver for Slice 6/7 items moved into Phase 2.

Authoritative artifacts: `reports/PHASE1_CANON_HARDENING_ROADMAP.md`, `reports/PHASE1_ACCEPTANCE_REVIEW_DRAFT.md`, `reports/PHASE1_COMPLETION_AUDIT_20260429-1133.md`, `docs/80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md`.

### Phase 2 — Machine-contract lock-in (active, ~99%)

- OpenAPI 3.1 baseline and JSON Schema 2020-12 set established for the initial route family (`/v1/system/health`, `/v1/authz/decide`, `/v1/keys/{key_id}/lifecycle/suspend`, `/v1/keys/{key_id}/lifecycle/revoke`, `/v1/feed/items`).
- Prose↔OpenAPI parity table (`docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`) and `composer phase2:acceptance-bundle` enforced in CI.
- Residual manual hooks burned down; deferred Slice 6/7 breadth decomposed in `reports/session_handoffs/PHASE2_PROGRESS_BOARD.md` under ADR-003.

ADR-003 carry-over rule: **ADR-003 MUST NOT be reused as a generic deferral mechanism for Phase 3 work.** New deferrals require a new ADR.

### Phase 3 — Canon Completion (consolidated; supersedes prior Phase 3 + Phase 4)

Phase 3 takes the SSOT corpus from its current state to **fully authored, internally consistent, machine-verifiable**, sufficient to drive production codebase authoring. The plan is in `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` and contains **13 milestones (M0..M12) and 69 slices**:

| Milestone | Title |
|---|---|
| M0 | Phase 3 entry audit and program ratification |
| M1 | Tier-1 correctness blockers (auth gate, schema/example, OpenAPI structural, hook/ID drift, CI rename, scripts, doc-id/filename, stale refs, `dot.env` sanitization) |
| M2 | Governance and traceability completion (scaffold READMEs replaced, traceability matrix backfill, scaffold-prose lint, glossary lint integration) |
| M3 | Product and architecture canon (`docs/10_*` — glossary, surfaces, request pipeline, dependency baseline, system spec, operating model) |
| M4 | Identity, delegation, and policy depth (`docs/20_*` — permission vocabulary, capability matrix, keychain, scenarios, delegation state machine) |
| M5 | Contracts and interfaces depth (`docs/30_*` — endpoint examples, webhooks, route inventory expansion, error catalog expansion, parity expansion) |
| M6 | Machine contracts depth (`docs/31_*` — schema completeness, coverage check, version policy, fixtures) |
| M7 | Data, security, and cryptography (`docs/40_*` — data model, ERD, controls, headers/CSP, threat model, abuse cases, crypto profile) |
| M8 | Content, audience, and feed (`docs/50_*` — audience groups, content/feed/comment lifecycle expansion) |
| M9 | Operations, quality, and release (`docs/60_*` — health, boot, config, smoke, migration, observability, release, readiness, SLO/SLI, acceptance matrix) |
| M10 | Extensibility and module patterns (`docs/70_*` — playbook, integration provider, post type, principal type) |
| M11 | Verification, evidence, and final acceptance bundle (new hooks, scripts, `composer phase3:final-acceptance-bundle`, CI rewire, drift pack) |
| M12 | Phase 3 freeze and implementation handoff (handoff package, acceptance memo, archive) |

Phase 3 is closed when the Definition of Done in `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` §6 holds: `composer phase3:final-acceptance-bundle` PASS in CI; `coverage_latest.json` reports `untraced_requirements: 0`; no scaffold prose remains; every route in `ROUTE_INVENTORY_REFERENCE.md` has full schema + example + parity row + error mapping; every `THREAT-###` has at least one mapped control and one abuse case; the Phase 3 acceptance memo is `status: normative`.

### Implementation Phase (post-Phase 3)

Once Phase 3 closes, the implementation phase begins. It introduces `src/` (PSR-4 `Cre8\\` namespace) and `tests/` (PHPUnit), authored against the now-complete SSOT. The implementation handoff package (slice P3-S12.1) details the doc-to-module mapping.

---

## 13. How to Contribute and How to Resume Work

CRE8 authoring is currently driven by reusable LLM session prompts. Pick the prompt that matches the active phase:

- **Phase 3 — Canon Completion** (active going forward): `reports/PHASE3_AUTHORING_SESSION_PROMPT.md`. Copy the block between `COPY/PASTE PROMPT START` and `COPY/PASTE PROMPT END` into a fresh expert-coding LLM session. The prompt instructs the session to read state, pick 2–5 contiguous unblocked slices from the program plan, execute them, and leave handoff + progress board + archived response artifacts.
- Phase 1 (closed) and Phase 2 (active) prompt templates remain at `reports/PHASE1_SESSION_PROMPT_TEMPLATE.md` and `reports/PHASE2_SESSION_PROMPT_TEMPLATE.md` for historical context and for any residual Phase 2 work.

Every authoring session MUST:

1. Use whatever git branch the operator’s session uses (`main` is fine), or any descriptive feature branch; no fixed branch naming pattern is required by this repository’s prompts.
2. Update the SSOT discoverability artifacts: `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`, the relevant progress board, and a new `reports/session_responses/<UTC>_RESPONSE.md` archived response.
3. Run the full verification command list in §14 before commit.
4. Use a PR when your workflow expects one—title includes program-plan slice IDs and the body lists files changed by domain, requirement/hook IDs added, and verification outcomes. Skip if you pushed directly to `main` without a PR model.

Repository git config is preserved (`user.name` / `user.email`); do not override unless the operator explicitly says so. Branches and PRs are created normally; cloud agents are responsible for `git add` / `git commit` / `git push` on every iteration loop.

---

## 14. Verification and CI Posture

The CI workflow `.github/workflows/ssot_phase_gate.yml` runs on PRs and pushes to `main` whenever `docs/`, `reports/`, `scripts/docs_ssot_*.php`, or `composer.json` changes. The workflow uses PHP 8.5 to align with the Composer platform pin in `composer.json`. It executes the SSOT lint/sync/report family plus `composer phase2:acceptance-bundle` (which transitions to `composer phase3:final-acceptance-bundle` under Phase 3 milestone M11).

The minimum local verification command set every authoring session must run before commit (when implemented at the time):

1. `composer validate --strict`
2. `composer docs:ssot:lint`
3. `composer docs:ssot:sync-check`
4. `composer docs:ssot:report`
5. `composer docs:ssot:route-parity`
6. `composer docs:ssot:route-uniqueness`
7. `composer docs:ssot:compat-declaration`
8. `composer docs:ssot:error-code-coverage`
9. `composer docs:ssot:deprecation-schema`
10. `composer docs:ssot:review-gate-check`
11. `composer docs:ssot:dod-trace-check`
12. `composer docs:ssot:roadmap-schema-check`
13. `composer docs:ssot:seed-promotion-schema`
14. `composer docs:ssot:seed-gap-schema`
15. `composer docs:ssot:phase2-exceptions-check`
16. `composer test:contract:auth`
17. `composer test:contract:auth-reasons`
18. `composer test:contract:error`
19. `composer test:contract:error-secrets`
20. `composer test:contract:feed`
21. `composer test:contract:identity-issuance`
22. `composer test:contract:identity-context`
23. `composer test:contract:lifecycle`
24. `composer test:contract:surface-parity`
25. `composer phase2:acceptance-bundle`

The current SSOT coverage snapshot is at `reports/ssot/coverage_latest.json`. Phase 3 drives `untraced_requirements` to `0`.

---

## 15. Authoritative Entry Points

For a new contributor or a fresh authoring session, read in this order:

1. **This file (`README.md`)**
2. `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md` — the authoring program (milestones, slices, dependencies, exit criteria, definition of done).
3. `reports/PHASE3_AUTHORING_SESSION_PROMPT.md` — the reusable session prompt to drive each authoring session.
4. `docs/00_governance/SSOT_INDEX.md` — governance topology and precedence model.
5. `docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` — required metadata header and authoring conventions.
6. `docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md` — change classes, review gates, and approvals.
7. `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md` — requirement → hook → owner → evidence linkage.
8. `docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`, `ROUTE_INVENTORY_REFERENCE.md`, and `ERROR_CODE_CATALOG.md` for the contract surface.
9. `docs/31_machine_contracts/openapi/cre8.v1.yaml` and `PROSE_OPENAPI_PARITY_TABLE.md` for the machine contract.
10. `seed/seed-intro.md` and `seed/CRE8_SEED_CANON_INDEX.md` for the seed-canon origin truths.
11. `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` and the progress board it points to, for the current state of work.

This README is intentionally authoritative and action-directing. Updates to this file are governed by `docs/00_governance/CHANGE_CONTROL_POLICY.md` and require a Change Impact Map when normative semantics change.
