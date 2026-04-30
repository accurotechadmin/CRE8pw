# CRE8 Phase 3 Authoring Program Plan

- Document location: `reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`
- Status: planning artifact (non-normative under SSOT precedence; will be promoted into `docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md` once accepted)
- Author session: GPT-Composer working session, 2026-04-30 UTC
- Scope: end-to-end slice plan to take the CRE8 SSOT corpus from “Phase 2 (machine-contract lock-in) in flight, ~65% requirements untraced, ~37 scaffold docs” to “100% authored, internally consistent, production-codebase ready”.
- Naming convention used here: program is **Phase 3 — Canon Completion**, divided into **Milestones M0–M12**. Each milestone contains one or more **slices** prefixed `P3-S<milestone>.<slice>`. Each slice has explicit deliverables, exit criteria, dependencies, hooks, and traceability targets so that fresh LLM sessions can pick up any slice without prior context.

---

## 0. Mission and acceptance bar

### 0.1 Mission

Convert the CRE8 SSOT corpus into a complete, internally consistent, machine-verifiable specification that an implementation team (or coding LLM) can use without making invariant decisions of its own. Every behavior the platform exposes must be authored, traced, and verified before any production code is written.

### 0.2 Acceptance bar (Phase 3 done means all of these are simultaneously true)

1. **Zero scaffold prose** in `docs/`, `seed/`, `reports/`. The lint check `HOOK-SSOT-DOD-PLACEHOLDER-BLOCK` passes against the entire tree, not just `status=normative` docs.
2. **Zero untraced requirements**. `reports/ssot/coverage_latest.json` reports `untraced_requirements == 0` and `manual_only_verification_hooks == 0` (or a deterministically justified residual set ≤ 3, each with an open ADR).
3. **Zero internal contradictions**. The cross-document inconsistencies catalogued in `reports/REPO_FULL_STUDY_2026-04-29.md` and the Phase 3 entry audit (`reports/PHASE3_ENTRY_AUDIT_*.md` produced in M0) are resolved or formally waived under an ADR.
4. **All 7 SSOT domains have full content**: governance, product/architecture, identity/policy, contracts/interfaces, data/security/crypto, content/audience/feed, ops/release, extensibility, traceability/program. No domain has more than one `D`-grade (scaffold) document at exit.
5. **All declared API surface is fully specified**: every route in `ROUTE_INVENTORY_REFERENCE.md` has matching OpenAPI operation, request/response JSON Schemas with strict `additionalProperties` where applicable, prose contract details, deny-mapping examples, and a parity-table row.
6. **Implementation-binding section** present in every SSOT doc that specifies behavior, naming the Composer dependency that enforces it (per `seed-intro.md` §14).
7. **Production-readiness gates authored**: SLO/SLI, threat model, observability event catalog, release checklist, migration strategy, configuration contract, boot/startup contract, smoke contract, and acceptance criteria matrix all `status=normative` with executable hooks.
8. **`composer phase3:final-acceptance-bundle`** exists, is wired into CI, and passes; it is a superset of `phase2:acceptance-bundle` plus the additional Phase 3 hooks added by M11.
9. **A single, ratified Phase 3 acceptance memo** (`reports/PHASE3_ACCEPTANCE_MEMO.md`) records the freeze decision, ADR linkage, and unresolved-residual set (if any).

### 0.3 ADR-003 carry-over rule

ADR-003 (the Phase 1 freeze waiver) MUST NOT be reused by Phase 3 to defer correctness blockers. Phase 3 may only defer breadth via new ADRs that explicitly reference and bound the deferred scope.

### 0.4 Sequencing principle

Slices are ordered so each downstream slice can rely on the upstream slice as `normative` at the time of authoring. Cross-slice dependencies are explicit; no hidden ordering constraints. Any slice may be retried independently as long as its predecessors are still satisfied.

---

## 1. Program-wide conventions every slice MUST follow

### 1.1 Document standards

- YAML metadata header per `docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` (`doc_id`, `version`, `status`, `owner`, `reviewers`, `last_reviewed_utc`, `next_review_due_utc`, `source_seed_refs`, `normative_dependencies`).
- Requirement IDs use `CRE8-<DOMAIN>-REQ-####`. Hooks use `HOOK-<DOMAIN>-<TOPIC>`. ADRs `ADR-###`. Decision events `DLOG-YYYYMMDD-###`. Risks `RISK-###`. Gaps `GAP-###`. Exceptions `P3-EXC-###`.
- All MUST/SHOULD/MAY statements use RFC 2119 capitalization.
- Every doc ends with a `See also` block containing at least two governance/lateral links.
- Every behavioral statement that binds to a runtime dependency MUST cite the Composer package (`slim/slim`, `slim/psr7`, `php-di/php-di`, `firebase/php-jwt`, `ext-sodium`, `ext-pdo`, `respect/validation`, `vlucas/phpdotenv`, `guzzlehttp/guzzle`, `neomerx/cors-psr7`, `monolog/monolog`, `symfony/rate-limiter`, `symfony/cache`, `phpunit/phpunit`).
- New tables (decision tables, schema tables, capability matrices) MUST be machine-parseable: header row, pipe-delimited, each row complete, no merged cells.

### 1.2 Traceability standards

- Each new requirement is added to `docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md` in the same PR as the source change.
- Each new hook is added to `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md` and to `docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md` (if executable).
- Each new normative doc is added to `docs/00_governance/SSOT_INDEX.md` topology and (if it changes program scope) to `docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md`.

### 1.3 Verification standards

- Every requirement MUST point at an executable hook **or** an explicitly declared manual hook with a registered automation candidate.
- Every machine artifact change MUST be accompanied by a Change Impact Map (`docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md`).
- Every PR MUST add or update an evidence template under `docs/evidence/templates/` if a new hook category is introduced.
- `composer phase2:acceptance-bundle` MUST stay green throughout Phase 3. The eventual `composer phase3:final-acceptance-bundle` adds checks on top.

### 1.4 Scaffold prohibition

The phrase “This scaffold file defines the authoritative scope, boundaries, and eventual normative obligations for” MUST be removed from every doc by end of M2. After M2, a CI lint blocks PRs that reintroduce it anywhere in `docs/` or `reports/`.

---

## 2. Milestone overview

| Milestone | Title | Slices | Outputs |
|---|---|---|---|
| **M0** | Phase 3 entry audit and program ratification | 4 | Entry audit, ADR-004 program charter, scaffold inventory, repo hygiene |
| **M1** | Tier-1 correctness blockers (must fix before any new authoring) | 9 | Auth gate reconciliation, schema/example reconciliation, OpenAPI structural fixes, hook/ID drift, CI rename, scripts cleanup, dot.env sanitization, doc-id ↔ filename, traceability backfill kickoff |
| **M2** | Governance and traceability completion | 5 | README normative metadata, scaffold READMEs replaced, full trace matrix backfill, automated scaffold-prose lint, glossary lint integration |
| **M3** | Product and architecture canon (`docs/10_*`) | 6 | CANONICAL_TERMINOLOGY, ARCHITECTURE_AND_SURFACES, REQUEST_PIPELINE, DEPENDENCY_BASELINE, CRE8_PRODUCT_AND_SYSTEM_SPEC, CRE8_HUMAN_OPERATING_MODEL |
| **M4** | Identity, delegation, and policy depth (`docs/20_*`) | 5 | Permission vocabulary, principal/capability matrix, keychain composition, usage scenarios, delegation state machine |
| **M5** | Contracts and interfaces depth (`docs/30_*`) | 5 | Endpoint examples, webhook/integration contract, full route inventory expansion, error catalog expansion, prose↔OpenAPI parity expansion |
| **M6** | Machine contracts depth (`docs/31_*`) | 4 | Schema completeness pass, route × schema coverage, contract version policy, schema test fixtures |
| **M7** | Data, security, and cryptography (`docs/40_*`) | 7 | DATA_MODEL_SPEC, DATA_MODEL_REFERENCE, ERD, SECURITY_CONTROLS, SECURITY_HEADERS_AND_CSP, SECURITY_THREAT_MODEL, SECURITY_VERIFICATION_ABUSE_CASES, crypto profile addition |
| **M8** | Content, audience, and feed (`docs/50_*`) | 2 | AUDIENCE_GROUP_SPEC, content lifecycle/moderation expansion in existing docs |
| **M9** | Operations, quality, and release (`docs/60_*`) | 10 | HEALTH endpoint, BOOT/STARTUP, CONFIGURATION/ENV, OPERATIONAL_SMOKE, MIGRATION/SEED, OBSERVABILITY_EVENT_CATALOG, RELEASE_CHECKLIST, PRODUCTION_READINESS_GATES, SLO/SLI, ACCEPTANCE_CRITERIA_MATRIX |
| **M10** | Extensibility and module patterns (`docs/70_*`) | 4 | EXTENSIBILITY_PLAYBOOK, INTEGRATION_PROVIDER_PATTERN, POST_TYPE_EXTENSION_SPEC, PRINCIPAL_TYPE_EXTENSION_SPEC |
| **M11** | Verification, evidence, and final acceptance bundle | 5 | New hooks, evidence templates, CI rewire, `composer phase3:final-acceptance-bundle`, drift-test pack |
| **M12** | Phase 3 freeze and implementation handoff | 3 | Implementation handoff package, Phase 3 acceptance memo, archive/cleanup |

Total: **69 slices** across 13 milestones.

---

## 3. Detailed milestones and slices

Each slice has the same shape:

- **Slice ID** and **Title**
- **Objective** (one paragraph)
- **Inputs** (must already exist before starting)
- **Deliverables** (files to create or change)
- **New requirement IDs / hooks** (target IDs)
- **Exit criteria** (deterministic, verifiable)
- **Verification commands** (must pass at end of slice)
- **Dependencies** (slice IDs that must be done first)

---

### M0 — Phase 3 entry audit and program ratification

#### P3-S0.1 Capture entry-state audit
- **Objective**: Record the exact state of the corpus at Phase 3 entry so Phase 3 progress is measurable.
- **Inputs**: Current `reports/ssot/coverage_latest.json`; `reports/REPO_FULL_STUDY_2026-04-29.md`; this plan.
- **Deliverables**:
  - `reports/PHASE3_ENTRY_AUDIT_<UTC>.md` with: full file inventory by maturity grade (A/B/C/D), trace coverage snapshot (`total_normative_requirements`, `traced_requirements`, `untraced_requirements`), full conflict catalogue, scaffold list.
- **Exit criteria**: Audit doc lists every file under `docs/`, `seed/`, `reports/`, with grade and untraced-requirement count snapshot.
- **Verification**: `composer docs:ssot:report` run captured; coverage JSON archived alongside the audit.
- **Dependencies**: none.

#### P3-S0.2 Author ADR-004 — Phase 3 program charter
- **Objective**: Bind Phase 3 scope, sequencing, and acceptance bar to ADR governance so it cannot drift.
- **Deliverables**:
  - `docs/80_traceability_decisions_and_program/records/ADR-004-phase3-program-charter.md`: scope, mandate, prohibition on reusing ADR-003 for Phase 3 deferrals, exit criteria, named slice owners.
  - Update `docs/80_traceability_decisions_and_program/ADR_INDEX.md`.
  - Append `DLOG-<date>-004` to `docs/80_traceability_decisions_and_program/DECISIONS_LOG.md`.
- **Exit criteria**: ADR-004 status `accepted`; index and log reflect it; ADR-004 references this plan as a normative dependency target.
- **Verification**: `composer docs:ssot:lint && composer docs:ssot:sync-check` PASS.
- **Dependencies**: P3-S0.1.

#### P3-S0.3 Author Phase 3 progress board
- **Deliverables**:
  - `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`: lanes per milestone, slice rows with status `not_started`, owner, due date, hook IDs, decision_ref `ADR-004`.
  - `reports/session_handoffs/PHASE3_UNRESOLVED_EXCEPTIONS_REGISTER.md`: empty initial state with schema mirroring Phase 2 register but using `P3-EXC-###`.
- **Exit criteria**: Phase 3 board exists and is referenced from `LATEST_SESSION_HANDOFF.md`.
- **Dependencies**: P3-S0.2.

#### P3-S0.4 Repo hygiene baseline
- **Objective**: Reduce noise so every later session reads only live state.
- **Deliverables**:
  - Move `reports/session_handoffs/SESSION_HANDOFF_2026042*.md` (Phase 1 history) and Phase 2 handoffs older than 7 days to `reports/session_handoffs/archive/<YYYY-MM>/` while preserving git history.
  - Update `LATEST_SESSION_HANDOFF.md` policy: only the most recent N=10 stay at top level.
  - Update `seed/CRE8_REPO_STUDY_REPORT.md` to drop the obsolete claim that no root README exists (lines 220–222).
- **Exit criteria**: top-level `session_handoffs/` contains only live boards, latest pointer, manual-hook backlog, and the most recent 10 timestamped handoffs.
- **Dependencies**: P3-S0.3.

---

### M1 — Tier-1 correctness blockers

These slices fix the contradictions identified in the entry audit. They must complete before any new authoring begins so downstream authors cannot inherit the conflicts.

#### P3-S1.1 Reconcile authorization gate order
- **Objective**: Eliminate the conflict between `AUTHORIZATION_AND_DELEGATION_SPEC.md` (`CRE8-AUTH-REQ-0001`) and `AUTHORIZATION_DECISION_TABLES.md` (`CRE8-AUTH-REQ-0010`).
- **Deliverables**:
  - One canonical 7-gate sequence agreed (recommendation: `lifecycle, credential validity (signature/nonce/timestamp), explicit deny, scope match, permission match, delegation depth, expiry`).
  - Update both specs and any prose using the prior order.
  - Update `docs/31_machine_contracts/openapi/cre8.v1.yaml` `evaluated_gate` semantics and the OpenAPI `AuthDecisionAllow` example (`evaluated_gate: 7`).
  - Update `docs/31_machine_contracts/schemas/authz-decision-response.schema.json` (`evaluated_gate` 1..7 with mapping).
  - Author ADR-005 capturing the chosen sequence and rationale; supersede no prior ADR.
  - Change Impact Map under `reports/change_impact_maps/` (new folder if needed).
- **Exit criteria**:
  - `composer test:contract:auth` PASS with the new order;
  - `composer docs:ssot:route-parity` PASS;
  - one and only one normative description of the gate order exists in the corpus.
- **Dependencies**: M0.

#### P3-S1.2 Reconcile policy-decision schema with OpenAPI examples
- **Objective**: Make `policy-decision.schema.json` accept every example in `cre8.v1.yaml` while keeping `additionalProperties: false`.
- **Deliverables**:
  - Extend `request_context` properties to include: `target_item_id`, `ancestor_chain_ref`, `lifecycle_state` (enum `active|suspended|revoked|rotated|expired`), `grant_expiry_utc` (date-time), `identity_event_ref`, `utility_context_ref`, `surface` (existing), `tenant_id` (existing).
  - Add patterns for `ancestor_chain_ref` (`^[a-z0-9_-]+(>[a-z0-9_-]+)+$`) and `request_id` references where applicable.
  - Validate every example in OpenAPI against the schema (write an executable validator into `scripts/test_contract_request_schema.php` and add to `composer.json` as `test:contract:request-schema`).
- **Exit criteria**: New script PASS; OpenAPI examples valid against schema with strict additionalProperties.
- **Dependencies**: P3-S1.1.

#### P3-S1.3 Fix OpenAPI structural defect
- **Objective**: Remove the invalid nesting where `examples:` lives under `schema.$ref` for `/v1/authz/decide` request body.
- **Deliverables**:
  - Refactor `paths./v1/authz/decide.requestBody.content.application/json` so `examples:` is a sibling of `schema:`.
  - Run a Spectral/OpenAPI 3.1 lint (add `composer docs:ssot:openapi-lint` script using a minimal local validator if Spectral not available).
- **Exit criteria**: openapi-lint PASS; no other 3.1 structural errors remain.
- **Dependencies**: P3-S1.2.

#### P3-S1.4 Resolve hook-ID and casing drift
- **Deliverables**:
  - Rename `HOOK-CONTRACT-ERROR-SECRETS-REDaction` → `HOOK-CONTRACT-ERROR-SECRETS-REDACTION` in every file (`docs/`, `scripts/`, `reports/`).
  - Either register or rename `HOOK-SSOT-SYNC-CHECK`, `HOOK-SSOT-REPORT`, `HOOK-TRACE-MATRIX-COVERAGE`, `HOOK-TRACE-MATRIX-ID-VALIDATION` so every reference resolves.
  - Update `ADR-001-placeholder.md` and `ADR-002-placeholder.md` to use the canonical names.
- **Exit criteria**: a Grep for unregistered hook IDs returns nothing.
- **Dependencies**: M0.

#### P3-S1.5 Resolve doc-id / filename / matrix mismatches
- **Deliverables**:
  - Either rename files or update `doc_id`s so they match: `UI_RUNTIME_CONTRACT.md` ↔ `CRE8-CONTRACTS-SURFACE-PARITY` (recommend `doc_id` → `CRE8-CONTRACTS-UI-RUNTIME`).
  - `FEED_RANKING_AND_ORDERING_RULES.md` ↔ `CRE8-FEED-AUDIENCE-CONTRACT` (recommend `doc_id` → `CRE8-FEED-RANKING-ORDERING`).
  - Update `TRACEABILITY_MATRIX.md` row for `CONTRIBUTION_WORKFLOW_SSOT.md` from `CRE8-GOV-CONTRIBUTION-WORKFLOW` to actual `CRE8-GOV-CONTRIB-WORKFLOW`.
  - Update every cross-link site.
- **Exit criteria**: filename → `doc_id` is a 1:1 mapping for all `docs/`; sync-check PASS.
- **Dependencies**: M0.

#### P3-S1.6 Repair stale references
- **Deliverables**:
  - In `docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md`, replace `seed/cre8core-ownerauthORIGINAL.md` with the actual seed source(s) (`seed/CRE8_CONTENT_AUDIENCE_AND_FEED_SEED.md` and `seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md`).
  - Audit every doc’s `source_seed_refs` block for non-existent files; commit a fix.
- **Exit criteria**: a script `composer docs:ssot:source-refs-check` validates every `source_seed_refs` path resolves; PASS.
- **Dependencies**: M0.

#### P3-S1.7 Repair `composer.json` ↔ scripts drift
- **Deliverables**:
  - Either delete `ops:health-smoke` / `ops:migrate-smoke` from `composer.json` or implement minimal `scripts/health_smoke.php` and `scripts/migrate_smoke.php` that emit JSON diagnostics.
  - Either delete the obsolete `scripts/phase1_acceptance_bundle.php` or keep it and clearly mark it deprecated; align `composer.json`.
- **Exit criteria**: `composer validate --strict` PASS; every script entry resolves to an existing file.
- **Dependencies**: M0.

#### P3-S1.8 Repair CI workflow drift
- **Deliverables**:
  - Decide canonical CI workflow filename. Recommendation: keep `ssot_phase_gate.yml` and update `paths:` filter to reference itself instead of `ssot_phase1_gate.yml`.
  - Update `VERIFICATION_STRATEGY.md` `CRE8-OPS-REQ-0005` to match the canonical workflow group name.
  - Add `composer phase2:acceptance-bundle` step ordering check.
- **Exit criteria**: CI runs on changes to the workflow file itself; reference name in spec equals filename.
- **Dependencies**: M0.

#### P3-S1.9 Sanitize `dot.env`
- **Deliverables**:
  - Replace `DB_PASS=K$WdQAw9YABu` with `DB_PASS=__REPLACE_ME__` (or similar non-realistic placeholder).
  - Replace JWT key paths with `__REPLACE_ME__` placeholders.
  - Replace any other realistic values that look like deployed secrets.
  - Add `dot.env` to a documented “example only” notice at the top.
- **Exit criteria**: a Grep for `^[A-Z_]+=[^_]` against `dot.env` returns only structural literals (`mysql:host=…`, `*`, etc.) — no realistic secrets.
- **Dependencies**: M0.

---

### M2 — Governance and traceability completion

#### P3-S2.1 Replace scaffold READMEs
- **Deliverables**:
  - Author real content for `docs/README.md`, `docs/evidence/README.md`, `docs/evidence/automation/README.md`, `reports/README.md` (one paragraph stating purpose, then a structured index of immediate child docs/folders, then `See also`).
  - Add minimal frontmatter where the SSOT framework requires it.
- **Exit criteria**: Grep for the scaffold opener phrase against `docs/README.md` etc. returns nothing.
- **Dependencies**: M1.

#### P3-S2.2 Promote `README.md` (root) to versioned, framework-aligned form
- **Deliverables**:
  - Add a top “Document control” block (non-YAML, since root README is outside `docs/`): `version`, `status: normative`, `owner`, `last_reviewed_utc`, `next_review_due_utc`, link to ADR-004 and Phase 3 progress board.
  - No content changes beyond housekeeping; existing prose remains.
- **Exit criteria**: README contains the control block and is referenced as a normative source by `SSOT_INDEX.md`.
- **Dependencies**: P3-S2.1.

#### P3-S2.3 Backfill the Traceability Matrix
- **Objective**: Drive `untraced_requirements` to 0.
- **Deliverables**:
  - Enumerate every requirement ID in `docs/` and `seed/` (use a script `scripts/docs_ssot_requirement_inventory.php`).
  - Insert one matrix row per requirement: source doc, hook, owner, status, evidence path, related ADR/risk if any.
  - For requirements that no executable hook covers yet, register a manual-mode row + corresponding entry in `reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md` (rename to `PHASE_MANUAL_HOOK_BACKLOG.md` if desired).
- **Exit criteria**: `composer docs:ssot:report` returns `untraced_requirements: 0`.
- **Dependencies**: M1.

#### P3-S2.4 Add scaffold-prose lint
- **Deliverables**:
  - Implement `scripts/docs_ssot_scaffold_block.php` returning non-zero if the canonical scaffold opener phrase is found in any `docs/**/*.md`, `reports/README.md`, `reports/session_handoffs/PHASE*_PROGRESS_BOARD.md`, `reports/PHASE*.md`, or `seed/**/*.md`.
  - Wire into `composer docs:ssot:lint` and CI.
- **Exit criteria**: lint PASS at start of M3 (after M3+ slices remove the remaining scaffolds, the lint stays green).
- **Dependencies**: P3-S2.3.

#### P3-S2.5 Add a glossary lint hook
- **Deliverables**:
  - `scripts/docs_ssot_glossary_check.php`: every domain-bearing capitalized term that appears in a normative doc must be defined in `docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md` or be on a small allowlist (HTTP method names, JSON, etc.).
  - Hook `HOOK-SSOT-GLOSSARY-COVERAGE` registered in `VERIFICATION_STRATEGY.md`.
- **Exit criteria**: hook is registered (initially `next_automation_candidate=Implemented as docs:ssot:glossary-check`); hook is allowed to soft-fail until M3.1 is done.
- **Dependencies**: P3-S2.3.

---

### M3 — Product and architecture canon (`docs/10_*`)

#### P3-S3.1 `CANONICAL_TERMINOLOGY.md` (full glossary)
- **Objective**: One authoritative glossary that every other doc binds to.
- **Deliverables**:
  - Define every term used as a noun in normative prose: Owner, Primary Author, Secondary Author, Use Key, ID Keypair, Utility Keypair, Keychain, Audience Group, Surface, Owner Console, API Gateway, Public/bootstrap surface, PDP, Policy Decision Point, Provenance Event, Lifecycle State, Delegation Depth, Scope, Tenant, Group, Resource, Deny, Allow, Decision Reason Code, Cursor, Feed Item, Moderation State, etc.
  - For each: canonical definition (≤ 3 sentences), allowed aliases, prohibited aliases, doc references where the term is canonically defined further.
  - Add `HOOK-GLOSSARY-COMPLETENESS` and integrate with P3-S2.5.
- **Exit criteria**: glossary lint PASS hard; ≥ 50 terms.
- **Dependencies**: M2.

#### P3-S3.2 `ARCHITECTURE_AND_SURFACES.md`
- **Deliverables**:
  - Define the three surfaces with strict request/response/auth-context boundaries: Owner Console, API Gateway, Public/Bootstrap.
  - Surface boundary table: who can call what, allowed credential types, forbidden cross-surface contexts.
  - Diagrams allowed in markdown (mermaid).
  - Component-level diagram of: HTTP front, middleware chain, PDP service, identity service, content service, feed service, audit/event sink, persistence.
- **Requirement IDs**: `CRE8-ARCH-REQ-0010..0030` range.
- **Exit criteria**: every cross-surface rule referenced in `seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md` and `UI_RUNTIME_CONTRACT.md` is canonically restated here.
- **Dependencies**: P3-S3.1.

#### P3-S3.3 `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- **Deliverables**:
  - Authoritative middleware order: error envelope → CORS → request-id correlation → rate-limit → body parse → schema validate → authn (proof) → PDP authorize → handler → response envelope → audit write.
  - Inject `slim/slim` middleware ordering, and `php-di/php-di` composition root rules.
  - Forbid handler-local authorization branching (mirrors seed assertion).
  - Define how rejections at each stage map to error catalog codes.
- **Exit criteria**: every error code in `ERROR_CODE_CATALOG.md` is reachable from at least one named middleware stage.
- **Dependencies**: P3-S3.2.

#### P3-S3.4 `DEPENDENCY_BASELINE.md`
- **Deliverables**:
  - For each Composer dependency from `composer.json`, declare: responsibility, normative usage, prohibited alternatives, related requirement IDs.
  - Encode the seed `seed-intro.md §14` mandate as MUST clauses.
- **Exit criteria**: every dependency in `composer.json` (including `php`, `ext-pdo`, `ext-sodium`) has a row.
- **Dependencies**: P3-S3.1.

#### P3-S3.5 `CRE8_PRODUCT_AND_SYSTEM_SPEC.md`
- **Deliverables**:
  - Top-level product capabilities, system-level invariants, non-functional targets (briefly; SLOs are in `docs/60_*`), and ownership.
  - Bind product capabilities to capability IDs (`CAP-OWNER-*` etc.) used by `UI_RUNTIME_CONTRACT.md`.
- **Exit criteria**: every `CAP-*` ID in `UI_RUNTIME_CONTRACT.md` resolves to a row here.
- **Dependencies**: P3-S3.2.

#### P3-S3.6 `CRE8_HUMAN_OPERATING_MODEL.md`
- **Deliverables**:
  - Working-group ownership (already present in matrix), incident response on-call expectations, role responsibilities, escalation paths.
  - Tie to `DOCUMENT_STATUS_AND_OWNERSHIP.md` matrix.
- **Exit criteria**: every WG referenced anywhere in `docs/` is described here once.
- **Dependencies**: P3-S3.1.

---

### M4 — Identity, delegation, and policy depth (`docs/20_*`)

#### P3-S4.1 New: `PERMISSION_VOCABULARY.md`
- **Objective**: Canonical permission token namespace.
- **Deliverables**:
  - File: `docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md`.
  - Token namespace `<domain>.<resource>.<action>`; explicit list of every token currently used in `ROUTE_INVENTORY_REFERENCE.md` (`system.health.read`, `authz.decide`, `key.lifecycle.suspend`, `key.lifecycle.revoke`, `feed.items.read`, plus interaction tokens `comment.create`, `comment.reply`, `comment.react`, plus admin/audience tokens needed for completeness).
  - Token attributes: `delegateable_by_default` (yes/no), `requires_owner_grant` (yes/no), `lifecycle_sensitive` (yes/no).
- **Exit criteria**: every permission referenced anywhere resolves to one row here.
- **Dependencies**: M3.

#### P3-S4.2 `PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`
- **Deliverables**:
  - Principals: Owner, Primary Author, Secondary Author, Use, System/API client.
  - Resources: principal, key, delegation, audience group, post, comment, feed item, system.
  - Actions: create, read, update, suspend, revoke, rotate, delegate, decide.
  - Conditions: lifecycle state, scope type, ancestor lineage.
  - Cell values: allow / conditionally allow (with conditions) / deny.
  - Bind every cell to a permission token from P3-S4.1.
- **Exit criteria**: matrix is complete (no empty cells); every allow cell has a token.
- **Dependencies**: P3-S4.1.

#### P3-S4.3 `KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md`
- **Deliverables**:
  - Keychain composition algorithm: aggregation rules, deny-precedence, deduplication.
  - Provenance preservation: aggregated capability MUST be reproducible from constituent grants.
  - Resolution sequence under PDP at request time.
  - Conflict resolution rules.
- **Exit criteria**: an example walkthrough with multi-grant keychain reproduces a deterministic effective scope.
- **Dependencies**: P3-S4.2.

#### P3-S4.4 `USAGE_SCENARIOS_AND_PERMISSION_STORIES.md`
- **Deliverables**:
  - At least 12 end-to-end scenarios:
    - Owner mints Primary Author with bounded delegation.
    - Primary Author mints Use Key under a Utility context.
    - Use Key reads feed within audience group.
    - Use Key attempts comment.create on non-eligible group → deny.
    - Suspend cascade across descendants.
    - Revoke cascade across descendants.
    - Cross-surface attempt with Owner-Console-only capability via API → deny.
    - Identity transition (re-issuance) and replay-safe utility context binding.
    - Multi-ancestor lifecycle expiry deny.
    - Audience-group-targeted post visibility.
    - Keychain composition allowing aggregated read access.
    - Webhook integration request authorization.
  - Each scenario lists: precondition, request, gate path (1..7), expected outcome, expected error code or success envelope.
- **Exit criteria**: each scenario has a fixture in `composer test:contract:auth` or `composer test:contract:lifecycle`.
- **Dependencies**: P3-S4.3.

#### P3-S4.5 New: `DELEGATION_STATE_MACHINE.md`
- **Deliverables**:
  - States: `proposed, granted, active, suspended, revoked, rotated, expired, retired`.
  - Events: grant, accept, suspend, resume, revoke, rotate, expire.
  - Guard conditions per transition.
  - Cascade impact on descendants.
  - Failure semantics (which deny code each illegal transition produces).
- **Exit criteria**: state diagram and transition table; matched by lifecycle hook coverage.
- **Dependencies**: P3-S4.4.

---

### M5 — Contracts and interfaces depth (`docs/30_*`)

#### P3-S5.1 `Endpoint_Examples_All_Routes.md`
- **Deliverables**:
  - For every active route in `ROUTE_INVENTORY_REFERENCE.md`, include: example success request, example success response (rendered from OpenAPI examples), one example deny per declared `error_code_set` entry, expected `request_id` prefix.
  - Cross-link each example to the OpenAPI fixture name and the error catalog code.
- **Exit criteria**: parity check `composer docs:ssot:example-coverage` (new) PASS.
- **Dependencies**: M4.

#### P3-S5.2 `WEBHOOK_AND_INTEGRATION_CONTRACT.md`
- **Deliverables**:
  - Outbound webhook: signing scheme, retry/backoff policy, payload shape (success/error envelope), event taxonomy bound to `OBSERVABILITY_EVENT_CATALOG.md` (M9).
  - Inbound integration: JWKS resolution, `guzzlehttp/guzzle` config, replay defenses.
  - Failure semantics, dead-letter handling, idempotency.
- **Exit criteria**: webhook signing scheme is testable via fixture; doc cites `firebase/php-jwt` and `guzzlehttp/guzzle`.
- **Dependencies**: M4.

#### P3-S5.3 Route inventory expansion
- **Objective**: Specify the rest of the production surface.
- **Deliverables**:
  - Add routes (minimum):
    - `POST /v1/principals` (Owner mint Primary Author).
    - `POST /v1/keys/id` (mint ID keypair atomically with principal).
    - `POST /v1/keys/utility` (mint utility keypair from ID lineage).
    - `POST /v1/keys/{key_id}/lifecycle/rotate`.
    - `POST /v1/delegations` (issue delegation).
    - `DELETE /v1/delegations/{delegation_id}` (revoke).
    - `GET /v1/audience-groups`, `POST /v1/audience-groups`, `PATCH /v1/audience-groups/{id}`, `DELETE /v1/audience-groups/{id}`.
    - `POST /v1/posts`, `GET /v1/posts/{id}`, `PATCH /v1/posts/{id}`, `DELETE /v1/posts/{id}`.
    - `POST /v1/posts/{id}/comments`, `GET /v1/posts/{id}/comments`.
    - `POST /v1/audit/exports` (Owner-Console-only — declared `ui_only` if no API parity).
    - `GET /v1/system/version`, `GET /v1/system/info`.
  - Each route: full inventory row, OpenAPI operation, schemas, examples, parity-table row.
- **Exit criteria**: inventory length grows from 5 to ≥ 20; all parity checks PASS.
- **Dependencies**: P3-S5.1, M4.

#### P3-S5.4 `ERROR_CODE_CATALOG.md` expansion
- **Deliverables**:
  - Add codes for the new routes: `INPUT_VALIDATION_FAILED`, `INPUT_FIELD_MISSING`, `INPUT_FIELD_INVALID`, `LIFECYCLE_TRANSITION_INVALID`, `LIFECYCLE_ALREADY_TERMINAL`, `RESOURCE_NOT_FOUND`, `RESOURCE_CONFLICT`, `RATE_LIMITED`, `INTEGRATION_UPSTREAM_UNAVAILABLE`, `INTEGRATION_INVALID_SIGNATURE`, etc.
  - Each code: category, default HTTP status, description, redaction rules, example payload.
  - Update `HOOK-CONTRACT-ERROR-CODE-COVERAGE` rules to require all new codes resolve.
- **Exit criteria**: every error in OpenAPI examples resolves to a catalog row.
- **Dependencies**: P3-S5.3.

#### P3-S5.5 `PROSE_OPENAPI_PARITY_TABLE.md` expansion and route family coverage
- **Deliverables**:
  - Add parity rows for every new route from P3-S5.3.
  - Update Route Family Coverage Policy to include new families (`principal_management`, `delegation_management`, `audience_management`, `post_management`, `comment_interaction`, `audit_export`, `integration_webhook`, `system_meta`).
  - Each family row gets owner, decision_ref, phase3_due_date_utc.
- **Exit criteria**: parity check PASS; coverage policy enumerates every family that appears in inventory.
- **Dependencies**: P3-S5.4.

---

### M6 — Machine contracts depth (`docs/31_*`)

#### P3-S6.1 Schema completeness pass
- **Deliverables**:
  - For every new route, add a request schema and response schema under `docs/31_machine_contracts/schemas/`.
  - All schemas use `additionalProperties: false` for envelopes; `data` objects use either explicit closure or `unevaluatedProperties: false`.
- **Exit criteria**: every operation has request and response schemas linked from OpenAPI.
- **Dependencies**: P3-S5.5.

#### P3-S6.2 Cross-route schema coverage check
- **Deliverables**:
  - `scripts/docs_ssot_schema_coverage.php`: every route in inventory has a request schema (if it has a body) and a success/error response schema.
- **Exit criteria**: hook `HOOK-CONTRACT-SCHEMA-COVERAGE` PASS.
- **Dependencies**: P3-S6.1.

#### P3-S6.3 Contract version policy
- **Deliverables**:
  - Add a `CONTRACT_VERSION_POLICY.md` (under `docs/31_machine_contracts/`): semantic-version rules for additive vs. breaking changes; rules for `feed_metadata_schema_version`, `contract_version` in envelopes; deprecation/sunset windows; client compatibility expectations.
- **Exit criteria**: policy referenced from `API_CONTRACT_GUIDE.md` and `PROSE_OPENAPI_PARITY_TABLE.md`.
- **Dependencies**: P3-S6.1.

#### P3-S6.4 Schema test fixtures
- **Deliverables**:
  - `tests/contract/fixtures/` (or `scripts/fixtures/`): one valid + one negative fixture per schema.
  - Wire into `composer test:contract:request-schema` and `composer test:contract:response-schema` (new).
- **Exit criteria**: every schema has both a positive and a negative fixture and they execute under the contract test runner.
- **Dependencies**: P3-S6.2.

---

### M7 — Data, security, and cryptography (`docs/40_*`)

#### P3-S7.1 `DATA_MODEL_SPEC.md`
- **Deliverables**:
  - Entities: Principal, IdKeypair, UtilityKeypair, Delegation, Permission, AudienceGroup, AudienceGroupMember, Post, Comment, FeedItem, LifecycleEvent, AuditEvent, ProvenanceEvent, ConfigSecret, RateLimitState.
  - Per entity: fields, types (mapped to PostgreSQL/MySQL types), constraints, indices, FK relationships, sensitivity classification.
  - Append-only event tables called out explicitly.
- **Exit criteria**: every entity referenced in any spec has a row here.
- **Dependencies**: M3.

#### P3-S7.2 `DATA_MODEL_REFERENCE.md`
- **Deliverables**:
  - Quick-reference tables: PK/UK/FK list, sensitivity classification index, which entities feed which API responses.
- **Dependencies**: P3-S7.1.

#### P3-S7.3 `ERD.md`
- **Deliverables**:
  - Mermaid ERD diagram or equivalent ascii ERD covering all entities from P3-S7.1.
- **Dependencies**: P3-S7.1.

#### P3-S7.4 `SECURITY_CONTROLS_SPEC.md`
- **Deliverables**:
  - Control families: identification, authentication, authorization, audit, cryptography, data-at-rest, data-in-transit, secret management, session, anti-replay, rate limiting, input validation, output redaction, supply chain.
  - For each: control statement (MUST), enforcement mechanism, dependency (`ext-sodium`, `firebase/php-jwt`, `symfony/rate-limiter`, etc.), evidence path, related threat IDs.
- **Dependencies**: M3.

#### P3-S7.5 `SECURITY_HEADERS_AND_CSP_POLICY.md`
- **Deliverables**:
  - HSTS, X-Content-Type-Options, X-Frame-Options, Referrer-Policy, CSP, Permissions-Policy, COOP/COEP for the Owner Console.
  - Declaration of which surface gets which set.
- **Dependencies**: P3-S7.4.

#### P3-S7.6 `SECURITY_THREAT_MODEL.md`
- **Deliverables**:
  - STRIDE-per-surface and per-data-flow threat catalogue.
  - Each threat: ID `THREAT-###`, surface, asset impacted, severity, mapped controls, mapped abuse cases.
- **Dependencies**: P3-S7.4.

#### P3-S7.7 `SECURITY_VERIFICATION_ABUSE_CASES.md`
- **Deliverables**:
  - For each threat in P3-S7.6, an abuse case with: setup, steps, expected platform response, expected error code, hook ID for executable verification.
- **Dependencies**: P3-S7.6.

#### P3-S7.8 New: `CRYPTO_PROFILE.md`
- **Deliverables**:
  - Approved algorithms: signature (Ed25519 via `ext-sodium`), key derivation (Argon2id parameters), random source (`random_bytes`/`sodium_*`), constant-time compare, JWS algs allowed (`EdDSA`).
  - Key sizes; nonce size and uniqueness window; clock-skew tolerance; replay-cache retention horizon.
  - Deprecation policy.
- **Exit criteria**: every cryptographic primitive used anywhere is parameterized here.
- **Dependencies**: P3-S7.4.

---

### M8 — Content, audience, and feed (`docs/50_*`)

#### P3-S8.1 `AUDIENCE_GROUP_SPEC.md`
- **Deliverables**:
  - Audience group entity, membership semantics, lifecycle, owner authority over group, scope-type bindings, max-size bounds, enumeration semantics.
  - Bind to `data_model.AudienceGroup` from M7.
- **Dependencies**: M7.

#### P3-S8.2 Content lifecycle and moderation expansion
- **Deliverables**:
  - Extend `CONTENT_MODEL_AND_TARGETING_SPEC.md` with: post lifecycle states, moderation transitions, retention rules.
  - Extend `COMMENTING_AND_INTERACTION_POLICY.md` with: comment moderation, edit-history rules, soft-delete semantics.
  - Extend `FEED_RANKING_AND_ORDERING_RULES.md` with: per-tenant ordering invariants, rate-limited refresh policy.
- **Dependencies**: P3-S8.1.

---

### M9 — Operations, quality, and release (`docs/60_*`)

This milestone is broad. Each scaffold becomes a real spec.

#### P3-S9.1 `HEALTH_ENDPOINT_CONTRACT.md`
- **Deliverables**: definitions for `/v1/system/health` (liveness vs. readiness payloads), required components, redaction rules, dependency-checks (DB, JWT key file presence, rate limiter cache reachability).
- **Dependencies**: M3.

#### P3-S9.2 `BOOT_AND_STARTUP_FAILURE_CONTRACT.md`
- **Deliverables**: required env validation (binds `vlucas/phpdotenv`), exit codes, fail-closed semantics, restart guidance, log channel for boot.
- **Dependencies**: M3.

#### P3-S9.3 `CONFIGURATION_ENVIRONMENT_CONTRACT.md`
- **Deliverables**: every env var declared; required vs. optional; validation regex; binding to runtime behavior; secret-handling rules; mapping to `dot.env` placeholders.
- **Dependencies**: P3-S1.9, M3.

#### P3-S9.4 `OPERATIONAL_SMOKE_CHECK_CONTRACT.md`
- **Deliverables**: smoke command suite (`ops:health-smoke`, `ops:migrate-smoke`); pass/fail expectations; runtime targets; on-call invocation guidance.
- **Dependencies**: P3-S1.7, P3-S9.1.

#### P3-S9.5 `MIGRATION_AND_SEED_STRATEGY.md`
- **Deliverables**: PHP migration runner expectations (e.g., `phinx`-style or homegrown), forward-only policy, transactional safety (`ext-pdo`), seed data policy, blue/green migration considerations.
- **Dependencies**: M7.

#### P3-S9.6 `OBSERVABILITY_EVENT_CATALOG.md`
- **Deliverables**: every event the system emits across `monolog/monolog` channels: name, schema, severity, sampling rule, retention class, sensitivity, correlation field requirements. Bind to provenance entities.
- **Dependencies**: M7.

#### P3-S9.7 `RELEASE_CHECKLIST.md`
- **Deliverables**: ordered checklist with explicit gate hooks; tied to `phase3:final-acceptance-bundle`.
- **Dependencies**: P3-S9.6.

#### P3-S9.8 `PRODUCTION_READINESS_GATES.md`
- **Deliverables**: gating criteria (test coverage thresholds, no critical risks open, threat-control matrix complete, schema coverage 100%, etc.). Bind to risk register.
- **Dependencies**: P3-S9.6.

#### P3-S9.9 `SLO_SLI_SPEC.md`
- **Deliverables**: SLIs (latency, error rate, availability, lifecycle propagation latency, audit completeness ratio); SLO targets per surface; error budget policy; alerting linkage.
- **Dependencies**: P3-S9.6.

#### P3-S9.10 `ACCEPTANCE_CRITERIA_MATRIX.md`
- **Deliverables**: cross-cutting matrix that aligns release gates, SLOs, contract tests, security verification, and DoD into one view per release type (canary, GA, rollback).
- **Dependencies**: P3-S9.7, P3-S9.8.

---

### M10 — Extensibility and module patterns (`docs/70_*`)

#### P3-S10.1 `EXTENSIBILITY_PLAYBOOK.md`
- **Deliverables**: how to add a new module without violating invariants — required interfaces, registration via `php-di/php-di`, route binding via `slim/slim`, schema declaration, hook registration, documentation/traceability obligations.
- **Dependencies**: M3, M4.

#### P3-S10.2 `INTEGRATION_PROVIDER_PATTERN.md`
- **Deliverables**: pattern for outbound integrations (signing, retry, dead-letter), pattern for inbound integrations (JWKS, webhook validation), test seam expectations.
- **Dependencies**: P3-S10.1.

#### P3-S10.3 `POST_TYPE_EXTENSION_SPEC.md`
- **Deliverables**: how to add a new post family (e.g., DM, media share); inheritance of audience/feed/PDP/lifecycle obligations; sample manifest.
- **Dependencies**: P3-S10.1, M8.

#### P3-S10.4 `PRINCIPAL_TYPE_EXTENSION_SPEC.md`
- **Deliverables**: how to add a new principal type; obligations to extend permission vocabulary, capability matrix, lifecycle state machine; sample manifest.
- **Dependencies**: P3-S10.1, M4.

---

### M11 — Verification, evidence, and final acceptance bundle

#### P3-S11.1 New hooks and templates
- **Deliverables**:
  - Register in `VERIFICATION_STRATEGY.md`: `HOOK-DATA-MODEL-COVERAGE`, `HOOK-SEC-THREAT-CONTROL-MATRIX`, `HOOK-OBS-EVENT-CATALOG-COVERAGE`, `HOOK-CONTRACT-SCHEMA-COVERAGE`, `HOOK-CONTRACT-EXAMPLE-COVERAGE`, `HOOK-OPENAPI-LINT`, `HOOK-GLOSSARY-COMPLETENESS`, `HOOK-SOURCE-REFS-INTEGRITY`, `HOOK-PERMISSION-VOCAB-RESOLVE`, `HOOK-CAPABILITY-MATRIX-COMPLETE`, `HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY`, `HOOK-RELEASE-CHECKLIST-PRESENT`, `HOOK-SLO-SLI-PRESENT`.
  - One evidence template per new hook category in `docs/evidence/templates/`.
- **Dependencies**: M3..M10.

#### P3-S11.2 Implement scripts for new hooks
- **Deliverables**:
  - `scripts/docs_ssot_data_model_coverage.php`, `scripts/docs_ssot_threat_control_matrix.php`, `scripts/docs_ssot_event_catalog_coverage.php`, `scripts/docs_ssot_schema_coverage.php`, `scripts/docs_ssot_example_coverage.php`, `scripts/docs_ssot_openapi_lint.php`, `scripts/docs_ssot_glossary_check.php`, `scripts/docs_ssot_source_refs_check.php`, `scripts/docs_ssot_permission_vocab_resolve.php`, `scripts/docs_ssot_capability_matrix_complete.php`, `scripts/docs_ssot_delegation_sm_consistency.php`.
  - Wire into `composer.json`.
- **Dependencies**: P3-S11.1.

#### P3-S11.3 Author `composer phase3:final-acceptance-bundle`
- **Deliverables**:
  - `scripts/phase3_acceptance_bundle.php`: runs full Phase 2 bundle plus all M11 hooks plus runs `composer test:contract:*` and the new request/response schema fixture runners.
  - Add to `composer.json`.
  - Update `docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md` to reference Phase 3 supersession path or author a peer doc `PHASE3_ACCEPTANCE_CRITERIA.md`.
- **Dependencies**: P3-S11.2.

#### P3-S11.4 CI rewire
- **Deliverables**:
  - Update `.github/workflows/ssot_phase_gate.yml`: run `composer phase3:final-acceptance-bundle` as the merge-blocking step.
  - Update CI `paths:` to match the file’s actual name.
  - Add a job that asserts `untraced_requirements == 0` in the freshly-emitted `coverage_latest.json`.
- **Dependencies**: P3-S11.3.

#### P3-S11.5 Drift-test pack
- **Deliverables**:
  - `scripts/docs_ssot_phase3_drift_pack.php`: runs every consistency check in one shot (cross-doc IDs, hook IDs, schema/example, glossary, source refs, parity).
  - Document in `SSOT_AUTOMATION_AND_LINTING.md`.
- **Dependencies**: P3-S11.4.

---

### M12 — Phase 3 freeze and implementation handoff

#### P3-S12.1 Implementation handoff package
- **Deliverables**:
  - `reports/PHASE3_IMPLEMENTATION_HANDOFF.md`: enumerated mapping from doc set → expected `src/` modules; explicit expectations for `tests/Contract/`, `tests/Security/`, `tests/Lifecycle/`, etc.
  - `docs/00_governance/SSOT_INDEX.md`: reflect new docs.
  - `seed/`: mark seed canon `frozen-as-historical` with a note pointing to `docs/` for live canon (do not delete; preserve as origin trace).
- **Dependencies**: M11.

#### P3-S12.2 Phase 3 acceptance memo
- **Deliverables**:
  - `reports/PHASE3_ACCEPTANCE_MEMO.md` with: gate dispositions, evidence bundle, ADR-004 closure event, residual risks (if any), explicit go/no-go for implementation start.
  - Append `DLOG-<date>-005` decision event for Phase 3 closure.
- **Exit criteria**: `composer phase3:final-acceptance-bundle` PASS; coverage 0 untraced; memo `status=normative`.
- **Dependencies**: P3-S12.1.

#### P3-S12.3 Archive and cleanup
- **Deliverables**:
  - Archive Phase 1/2 boards under `reports/session_handoffs/archive/`.
  - Strip residual `placeholder` filename suffix on ADR-001/002 (rename to `ADR-001-requirement-id-normalization.md`, `ADR-002-traceability-matrix-minimum-schema.md`).
  - Update every cross-link.
- **Dependencies**: P3-S12.2.

---

## 4. Risk register additions for Phase 3

Add these to `docs/80_traceability_decisions_and_program/RISK_REGISTER.md` at M0:

| Risk ID | Title | Severity | Owner | Mitigation |
|---|---|---|---|---|
| RISK-010 | Authoring drift between concurrent slices | high | Program Traceability WG | Slices ordered with hard predecessors; one slice in progress per author at a time. |
| RISK-011 | Schema/example desynchronization | high | API Contracts WG | `HOOK-CONTRACT-SCHEMA-COVERAGE` + `HOOK-CONTRACT-EXAMPLE-COVERAGE` enforced at CI. |
| RISK-012 | Glossary churn invalidating downstream prose | medium | Docs Governance WG | Glossary lint runs on every PR; term changes require change-impact map. |
| RISK-013 | Threat model lags route additions | high | Security WG | Each new route slice MUST add or extend a threat row. |
| RISK-014 | Trace coverage regression while adding requirements | high | Program Traceability WG | CI fails on `untraced_requirements > 0`. |

---

## 5. Slice dependency graph (summary)

- M0 → everything.
- M1 → M2..M12.
- M2 → M3..M12.
- M3 → M4..M11.
- M4 → M5, M8, M10.
- M5 → M6.
- M6 → M11.
- M7 → M8, M9, M11.
- M8 → M9 (events), M10 (post types).
- M9 → M11.
- M10 → M11.
- M11 → M12.

Authoring sessions MAY parallelize within a milestone if slice dependencies allow.

---

## 6. Definition of Done for the program

Phase 3 is closed when **all** of the following hold:

1. `composer phase3:final-acceptance-bundle` PASS in CI on `main`.
2. `coverage_latest.json` reports `untraced_requirements: 0`, `manual_only_verification_hooks: 0` (or ≤ 3 with active ADR backing).
3. `HOOK-SSOT-DOD-PLACEHOLDER-BLOCK` clean.
4. Every doc in `docs/` has full YAML frontmatter and a registered owner.
5. Every route in `ROUTE_INVENTORY_REFERENCE.md` has full schema + example + parity row + error mapping.
6. Every `THREAT-###` has at least one mapped control and one abuse case.
7. `PHASE3_ACCEPTANCE_MEMO.md` is `status=normative` and references this plan + ADR-004.
8. `seed/` is marked frozen and `docs/` is the live canon.
9. The implementation handoff package can be handed to an implementation team and they can author `src/` and `tests/` against the spec without making invariant decisions.

---

## 7. Companion artifact

A reusable session prompt accompanies this plan (`reports/PHASE3_AUTHORING_SESSION_PROMPT.md`) so any fresh expert coding LLM session can pick up any slice and execute it to the same standard.
