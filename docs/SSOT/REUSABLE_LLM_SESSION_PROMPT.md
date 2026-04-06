# Reusable Prompt — CRE8 SSOT-Driven Development Session Handoff

Copy/paste everything below into a fresh expert coding LLM session.

---

You are continuing development of the CRE8 platform from a prior session.

## Mission
Pick up where the last development session left off and execute the next highest-priority tasks to rebuild CRE8 from scratch toward production readiness, using the existing prototype codebase only as a reference.

## Core Rule (Critical)
Treat **all documents in `/docs/SSOT` as immutable Single Source Of Truth (SSOT)** for this session.
- If code conflicts with SSOT, SSOT wins.
- Do not rewrite SSOT requirements unless explicitly asked by the human.
- The closer implementation matches SSOT contracts/policies/controls, the closer CRE8 is to production-ready.

## Required initial reading order (do this first)
1. `/docs/SSOT/SSOT_INDEX.md`
2. `/docs/SSOT/CRE8_Spec.md`
3. `/docs/SSOT/Architecture_Reference.md`
4. `/docs/SSOT/Dependency_Reference.md`
5. `/docs/SSOT/Request_Pipeline_Reference.md`
6. `/docs/SSOT/Route_Inventory_Reference.md`
7. `/docs/SSOT/API_Contract_Guide.md`
8. `/docs/SSOT/openapi/cre8.v1.yaml`
9. `/docs/SSOT/SSOT_Automation_and_Linting.md`
10. `/docs/SSOT/HYBRID_REBUILD_ROADMAP_1_2_3.md`
11. `/docs/SSOT/REBUILD_STRATEGY_OPTIONS_FOR_CRE8.md`
12. `/docs/SSOT/SSOT_CODEBASE_ALIGNMENT_ASSESSMENT_2026-04-06.md`
13. `/docs/SSOT/scaffold_stubs.json`

## Working constraints
- Keep the existing stack: PHP 8.2, Slim 4, PHP-DI, PDO (MySQL/MariaDB), JWT, PHPUnit.
- Follow the hybrid implementation model:
  1) modular monolith,
  2) contract-first,
  3) policy-first domain logic.
- Keep handlers thin; place logic in use-cases/policies.
- Keep domain layer framework-agnostic.
- Any route change must synchronize runtime route registration + OpenAPI + route inventory + examples.

## First execution objective for this session
Instantiate development by creating the initial **file/folder scaffold and stubs** exactly from:
- `/docs/SSOT/scaffold_stubs.json`

### Execution steps
1. Parse `scaffold_stubs.json`.
2. Create all directories listed in `root_directories`.
3. Create all files listed in `starter_files`.
4. For non-implemented files, add minimal placeholder content:
   - namespace/class stub (for PHP),
   - clear TODO block with acceptance criteria,
   - no fake business logic.
5. Ensure composer scripts include:
   - `docs:ssot:lint`
   - `docs:ssot:sync-check`
   - `docs:ssot:report`
6. Generate a concise progress report with:
   - files created,
   - any deviations from JSON,
   - blockers.

## Priority queue after scaffolding
After scaffolding is complete, proceed in this order:
1. Implement first vertical slice: `GET /health`.
2. Implement second vertical slice: `POST /api/auth/login`.
3. Add minimal contract/security tests for both slices.
4. Add SSOT drift automation script skeletons and CI wiring.
5. Report remaining gaps against SSOT priority list.

## Output expectations (for every turn)
- Show a brief plan before edits.
- Make small, reviewable commits.
- Cite changed files with line references.
- Include executed commands and test results.
- If blocked, explain blocker and propose the smallest next step.

Now begin by reading the required docs in order, then execute the scaffold creation from `scaffold_stubs.json`.

---

