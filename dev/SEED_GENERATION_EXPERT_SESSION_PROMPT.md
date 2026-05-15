# Reusable Prompt — Expert Coding LLM Session for Seed-Generating Program

Copy/paste this prompt into a fresh expert coding LLM session.

---

You are entering the CRE8 repository to continue the seed-generating documentation program.

## Mission (what “success” means)
Build and mature the **seed-generating documentation system** so that it can reliably produce a complete, production-usable guidance corpus for CRE8.

Your objective is not just to fill templates; it is to:
- preserve source meaning with auditable traceability,
- resolve or explicitly register contradictions,
- normalize vocabulary/style/decision logic,
- and deliver a deterministic generation workflow that can be re-run by future sessions with minimal ambiguity.

Primary execution plan:
- `dev/SEED_GENERATING_MILESTONES_AND_SLICES.md`

Program-level alignment and production relevance cross-check:
- `dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`

## Foundational scope lock (must be enforced before and during all work)
You MUST treat the following CRE8 product brief as foundational scope. Your mission is to normalize, preserve, and operationalize this scope — not to expand beyond it without explicit governance disposition.

### Locked CRE8 ethos (intrinsic requirements)
- CRE8 is a modular credentialing/authentication/authorization foundation for PHP apps (full platform, hybrid owner+API-key, or API-only adoption modes).
- Runtime model is dual-surface: Owner HTML UI Console + API Gateway key-based access.
- Principal/key chain includes Owner, Primary Author, Secondary Author, Use keys with hierarchical mint/delegation controls.
- Content/audience/access model includes post visibility controls, audience targeting, comments permissions, and active-key(active-keychain)-driven feed/access behavior.
- Keychain model supports aggregate permissions, personal/public usage modes, and lifecycle parity with regular keys.
- Owner/admin operations include lineage/provenance visibility and suspend/cancel/revoke/cascade controls.
- Interface doctrine includes parity HTML interfaces for API actions where canon requires parity.
- Extensibility is deliberate: downstream apps extend post/audience/key/domain patterns without rewriting platform foundations.
- XtraType-style annotation workflow is a first-use-case anchor for extensibility reasoning.

### Locked dependency baseline (runtime + verification)
- `slim/slim` (HTTP kernel/routing/middleware composition)
- `slim/psr7` (PSR-7 request/response primitives)
- `php-di/php-di` (DI container/service wiring)
- `firebase/php-jwt` (JWT issuance/verification + JWKS compatibility)
- `ext-pdo` (prepared SQL + transactions + migration-safe persistence)
- `ext-sodium` (Argon2id, secure random, constant-time compare)
- `respect/validation` (composable payload validation and 422 mapping)
- `vlucas/phpdotenv` (startup env loading + required key validation)
- `guzzlehttp/guzzle` (outbound HTTP/webhook/JWKS integrations where applicable)
- `neomerx/cors-psr7` (policy-based CORS enforcement)
- `monolog/monolog` (structured app/security/audit logging)
- `symfony/rate-limiter` (traffic bucket/rate policy enforcement)
- `symfony/cache` (cache/limiter persistence)
- `phpunit/phpunit` (unit/integration/contract/regression tests)

### Scope expansion prohibition
- Do NOT introduce net-new product domains, principal types, key families, interface surfaces, or dependency families outside the locked scope.
- If you detect a potential expansion need, log it as a blocked `scope_expansion_candidate` in conflict/decision artifacts and continue only with in-scope work.

## Fresh-output location contract (mandatory)
All newly authored seed documents and generated final corpus documents MUST be created under the repository-root folder:
- `/fresh`

Operational rules:
- Do not create new authored/generated documents outside `/fresh` unless the file is explicitly a required continuity/governance artifact listed in this prompt.
- Mirror stable structure under `/fresh` (for example `/fresh/seed-generating-docs/...`) so the full output can be copied to a new repository intact.
- Treat `/fresh` as the export-ready artifact root for this program.

## Required control documents (runtime instructions)
- `seed-generating-docs/00_control/00_master_readme.md`
- `seed-generating-docs/00_control/01_source_inventory.md`
- `seed-generating-docs/00_control/02_content_preservation_ledger.md`
- `seed-generating-docs/00_control/02_canonical_vocabulary.md`
- `seed-generating-docs/00_control/03_document_style_standard.md`
- `seed-generating-docs/00_control/04_conflict_resolution_rules.md`
- `seed-generating-docs/00_control/04a_conflict_register.md`
- `seed-generating-docs/00_control/05_best_practices_registry.md`
- `seed-generating-docs/20_generation/30_llm_generation_instructions.md`
- `seed-generating-docs/20_generation/31_validation_checklist.md`

## Required startup sequence (before implementation)
1. Read onboarding and governance canon in order.
2. Read session continuity artifacts.
3. Read milestone execution plans.
4. Determine where prior session stopped and which next slices are eligible.
5. Run scope-lock startup checks.
6. Publish startup output (mandatory) including authority, selected slices, risk watchlist, and scope-lock summary.

## Session execution contract (must be explicit in every response)
For each work batch, the model must report all of the following headings:
1. `Startup summary`
2. `Slice plan (1–3 slices)`
3. `Files to touch (with /fresh paths for new authored/generated docs)`
4. `Progress log (as-you-go)`
5. `Validation and gate results`
6. `Continuity updates`
7. `Next-session resume pointer`

If any heading cannot be satisfied, the session is `partial` and blockers must be explicit.

## Evidence and scoring model (hard requirement)
Every selected slice must include a compact scorecard:
- `preservation_gate`: pass|partial|fail
- `conflict_gate`: pass|partial|fail
- `consistency_gate`: pass|partial|fail
- `generation_gate`: pass|partial|fail
- `implementation_relevance_gate`: pass|partial|fail
- `scope_lock_gate`: pass|partial|fail

A slice cannot be marked `done` unless all required gates are `pass`, or an explicit waiver entry exists in governance artifacts.

## Required artifacts to update during work
- `seed-generating-docs/00_control/01_source_inventory.md`
- `seed-generating-docs/00_control/02_content_preservation_ledger.md`
- `seed-generating-docs/00_control/04a_conflict_register.md` (if needed)
- `seed-generating-docs/30_governance/32_open_questions.md` (if needed)
- `seed-generating-docs/30_governance/33_decision_register.md` (if decisions made)
- `seed-generating-docs/30_governance/34_legacy_language_register.md` (as terms are normalized)
- `seed-generating-docs/30_governance/35_consistency_matrix.md`
- `seed-generating-docs/30_governance/36_scope_lock_register.md`
- `dev/implementation/PROGRESS_BOARD.md`
- `reports/session_handoffs/LATEST_SESSION_HANDOFF.md`

## Program anti-drift checks (run each session)
- Verify `fresh/reports/session_handoffs/LATEST_SESSION_HANDOFF.md` points to an existing concrete handoff file.
- Verify `/fresh/seed-generating-docs` mirrors any touched seed-generating governance files when export portability is claimed.
- Verify milestone/slice labels in handoff notes match `dev/SEED_GENERATING_MILESTONES_AND_SLICES.md` exactly.
- Verify no new placeholder-only rows were added to conflict/decision/consistency/scope-lock registers.

## Prohibited behavior
- Do not skip startup sequence.
- Do not produce untracked content transformations.
- Do not leave continuity records stale.
- Do not claim completion for slices without updating milestone artifacts.
- Do not mark generated guidance as implementation-ready if traceability/conflict status is incomplete.

---
