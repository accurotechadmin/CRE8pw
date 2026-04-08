# Prompt for Fresh LLM Session: Build New CRE8 SSOT Canon (Production-Ready)

Use the following prompt in a brand-new LLM session.

---

You are assisting with a full SSOT-canon rebuild for CRE8. Your mission is to create a production-ready canonical documentation set under `/from_scratch/ssot_canon` that will guide the final implementation of the CRE8 platform.

## Context and constraints

- Repository contains legacy docs under `/docs` and `/docs/SSOT`, and planning artifacts under `/from_scratch`.
- New target canon must be created under `/from_scratch/ssot_canon`.
- New canon is SSOT-first: if future conflicts occur, this new canon should become authoritative.
- Keep the existing stack assumptions unless explicitly changed:
  - PHP 8.2
  - Slim 4 + slim/psr7
  - PHP-DI
  - JWT (`firebase/php-jwt`)
  - PDO + sodium
  - respect/validation
  - neomerx/cors-psr7
  - monolog
  - symfony/rate-limiter + cache
  - phpunit

## First tasks (required reading)

Read these files first (in order):

1. `from_scratch/README.md`
2. `from_scratch/PLAN_SSOT_FIRST_DOCUMENT_REBUILD.md`
3. `from_scratch/CORE_IDENTITY_AND_VALUE_PROPOSITION.md`
4. `from_scratch/TECHNICAL_FOUNDATION_AND_BUILD_PLAN.md`
5. `from_scratch/MASTER_PLAN_SSOT_CANON_SCAFFOLD_AND_STUBS.md`
6. `docs/SSOT/SSOT_INDEX.md`
7. `docs/SSOT/Architecture_Reference.md`
8. `docs/SSOT/Dependency_Reference.md`
9. `docs/SSOT/Request_Pipeline_Reference.md`
10. `docs/SSOT/API_Contract.md`
11. `docs/SSOT/Data_Model_Spec.md`
12. `docs/SSOT/Security_Controls_Spec.md`
13. `docs/SSOT/Verification_Strategy.md`
14. `docs/SSOT/Acceptance_Criteria_Matrix.md`
15. `docs/SSOT/SSOT_Automation_and_Linting.md`
16. `docs/SSOT/Production_Readiness_Gates.md`
17. `docs/SSOT/RELEASE_CHECKLIST.md`
18. `docs/SSOT/SSOT_CODEBASE_ALIGNMENT_ASSESSMENT_2026-04-06.md`

Then inspect implementation anchors:

- `composer.json`
- `public/index.php`
- `src/Bootstrap/*`
- `src/Http/Middleware/*`
- `src/Http/Routes/RouteRegistrar.php`
- `src/Security/*`
- `tests/Contract/*`
- `tests/Security/*`
- `code/composer.json`
- `code/src/Kernel/*`
- `code/src/Modules/*`

## Your output goals

### Goal A — Create canonical scaffold and stubs

Create the full directory and file scaffold under `/from_scratch/ssot_canon` exactly as defined in:

- `from_scratch/MASTER_PLAN_SSOT_CANON_SCAFFOLD_AND_STUBS.md`

Each document must include:

- title + status + last-updated metadata
- purpose, scope, normative statements
- interfaces/contracts
- failure semantics
- verification requirements
- traceability hooks
- open questions/known gaps

### Goal B — Populate high-value initial content

Do not leave docs empty. Fill each with concise but meaningful v1 draft content that is:

- technically coherent,
- aligned with code reality where possible,
- explicit about TODOs or unresolved drifts.

### Goal C — Ensure cross-link integrity

- Build a valid `SSOT_INDEX.md` reading order.
- Ensure each doc references related canonical docs.
- Create a draft `TRACEABILITY_MATRIX.md` linking capabilities to routes/policies/services/tests/docs.

### Goal D — Prepare automation readiness

Add initial content for:

- `SSOT_AUTOMATION_AND_LINTING.md`
- placeholders for lint/sync/report evidence expectations
- clear CI enforcement language for SSOT-impacting changes

## Quality bar

- Be specific, not generic.
- Prefer normative language (MUST/SHOULD/MAY) where appropriate.
- Explicitly flag mismatches between existing docs and code.
- Keep all claims traceable to either current code, tests, or prior SSOT docs.

## Required final deliverables from this run

1. Full scaffold under `/from_scratch/ssot_canon`.
2. Populated draft content in each canonical doc.
3. A short `from_scratch/ssot_canon/SCAFFOLD_BUILD_REPORT.md` summarizing:
   - files created,
   - major assumptions,
   - known unresolved conflicts,
   - next 10 highest-priority fill-in tasks.

## Execution behavior

- Do not delete existing legacy docs.
- Do not rewrite production code in this session unless absolutely necessary.
- Focus on canonical docset creation quality and consistency.
- If a fact is uncertain, mark it as a draft assumption and add it to known gaps.

Begin now by creating `/from_scratch/ssot_canon` scaffold and governance docs first.

---
