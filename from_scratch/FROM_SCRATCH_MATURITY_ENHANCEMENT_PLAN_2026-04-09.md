# From-Scratch SSOT Maturity Enhancement Plan (2026-04-09)

_Status: proposed_
_Last updated (UTC): 2026-04-09_

## Objective
Evolve `/from_scratch` into a standalone, production-ready sole SSOT canon for rebuilding CRE8, by promoting high-value missing content from the rest of the repository and tightening doc↔code↔operations traceability.

## Scope of this review
Reviewed non-`/from_scratch` repository material, including:
- runtime code (`src/`, `public/ui/`, `scripts/`, `tests/`),
- legacy/parallel docs (`docs/`, `docs/SSOT/`, `docs/dev/`),
- scaffold code/docs (`code/`, `code/docs/SSOT/`),
- study artifacts and inventory docs.

---

## A. High-value topics to bring into `/from_scratch`

### A1) Infrastructure and IaC contract is missing in the from-scratch canon
**Source value found:** canonical deployment topology, environment tiering, IaC, backup/restore, and rollback controls are documented in legacy SSOT but not present as a first-class from-scratch document.

**Action:** add `from_scratch/ssot_canon/40_operations_and_quality/INFRASTRUCTURE_IAC_CONTRACT.md` that refines and adopts the strongest parts of legacy `Infrastructure_IaC_Reference.md` into from-scratch naming/metadata.

### A2) Production runbook is under-specified in from-scratch
**Source value found:** explicit deploy/rollback/key-rotation operational procedures exist in legacy SSOT and should become normative in from-scratch.

**Action:** add `from_scratch/ssot_canon/40_operations_and_quality/OPERATIONS_RUNBOOK_PRODUCTION.md`, linked to readiness gates, release checklist, and smoke contracts.

### A3) Local bootstrap/seed policy should be explicit
**Source value found:** local-only seeding and guardrails are clearly specified in legacy SSOT.

**Action:** add `from_scratch/ssot_canon/40_operations_and_quality/LOCAL_DEV_BOOTSTRAP_AND_SEED_POLICY.md` and cross-link to migration strategy, environment contract, and verification strategy.

### A4) Architecture diagrams should be canonized (text + diagrams)
**Source value found:** sequence/context/component diagrams exist and improve implementation clarity.

**Action:** add `from_scratch/ssot_canon/10_product_and_architecture/ARCHITECTURE_DIAGRAMS.md` (Mermaid + text fallback) linked from architecture/surfaces.

### A5) UI contract artifact governance should be elevated
**Source value found:** robust UI contract-artifact rules exist (artifact list, schema expectations, parity evidence).

**Action:** add `from_scratch/ssot_canon/20_contracts/UI_CONTRACT_ARTIFACTS_REFERENCE.md`, and add/verify machine schema reference for UI page contract if retained.

---

## B. Drift and consistency gaps found (fix in next update wave)

### B1) Middleware order mismatch risk (docs vs runtime)
- Runtime global order is concretely defined in `src/Http/Middleware/MiddlewareOrder.php`, including `ErrorHandler` first and explicit `CSRF` stage.
- From-scratch request pipeline contract currently expresses a higher-level order that can be interpreted differently.

**Action:** update `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` to include:
1) exact canonical runtime order (source-of-truth labels),
2) stage intent,
3) rejection-code responsibilities per stage.

### B2) Route pattern normalization gap (`/ui/{route}` vs runtime pattern)
- Runtime route registration uses `/ui[/{route:.*}]`.
- Human contracts currently normalize as `/ui/{route}`.

**Action:** add explicit normalization rule in route inventory and API contract guide, documenting canonical human form and implementation regex form to avoid false drift alarms.

### B3) Traceability matrix service naming drift
- `TRACEABILITY_MATRIX.md` includes some service names that are conceptual/planned and not directly present in current runtime tree (e.g., `UiShellService`, `KeychainService`).

**Action:** update matrix rows to include `implementation_status` and `code_reference` columns:
- `implemented` (runtime class exists),
- `planned` (target module/service name in roadmap),
- `in_migration` (moved between `src/` and `code/src/`).

### B4) Dual-code-tree governance ambiguity (`src/` vs `code/src/`)
- Repo currently contains both runtime tree and scaffold tree.

**Action:** add `from_scratch/ssot_canon/70_implementation_guidance/CODEBASE_TRANSITION_AND_CANONICAL_RUNTIME_PATH.md` defining:
- authoritative runtime path now,
- scaffold status,
- migration path and acceptance gates for switching authority.

---

## C. Verification and operations maturity upgrades

### C1) Promote blocked-environment QA policy to canonical from-scratch guidance
**Source value found:** dev QA matrix documents concrete blocked conditions and rerun scripts.

**Action:** extend `VERIFICATION_STRATEGY.md` with a “blocked execution evidence protocol”:
- how to classify blocked checks,
- minimum evidence required,
- rerun criteria and expiry window.

### C2) Make automation spec executable against current scripts
- Existing scripts currently implement link-lint + route sync + report generation.
- From-scratch automation doc lists additional checkers (error-code sync, UI parity sync, timestamps, startup/config sync).

**Action:** add an implementation status table in `SSOT_AUTOMATION_AND_LINTING.md`:
- `implemented now` checks,
- `planned` checks with owner + target milestone,
- exact commands and expected output tokens.

### C3) Tighten release checklist with infra evidence requirements
**Action:** update `RELEASE_CHECKLIST.md` evidence section to require:
- IaC plan/apply references,
- backup freshness and restore drill recency,
- key rotation rehearsal evidence,
- smoke output + request/correlation IDs for failed checks.

---

## D. Proposed new components/sub-components (for next inventory regeneration)

- **New component:** Infrastructure and IaC contract.
- **New component:** Production operations runbook.
- **New component:** Local dev seed/bootstrap policy.
- **New component:** Architecture diagrams.
- **New component:** UI contract artifacts reference.
- **New sub-component group:** Docs/code drift-normalization rules (route normalization, middleware order mapping, implementation-status traceability).
- **New sub-component group:** Blocked-environment verification evidence protocol.

After these docs are authored, regenerate component inventory/index artifacts so these become first-class component IDs in the from-scratch taxonomy.

---

## E. Execution plan (3 waves)

### Wave 1 — Foundation imports (highest value, low risk)
1. Add infra/IaC contract.
2. Add production operations runbook.
3. Add local bootstrap/seed policy.
4. Add architecture diagrams.

**Exit:** all new docs adopted + cross-linked + no broken references.

### Wave 2 — Drift hardening and canonical alignment
1. Update request pipeline contract to exact runtime order and stage mapping.
2. Normalize UI route pattern representation across OpenAPI/inventory/contracts.
3. Add transition guidance for `src/` vs `code/src/` authority.
4. Update traceability matrix with implementation-status semantics.

**Exit:** no unresolved drift between runtime routes/middleware/docs; known gaps updated.

### Wave 3 — Verification and governance hardening
1. Extend verification strategy for blocked-env evidence protocol.
2. Add automation implementation-status table and ownership/milestones.
3. Tighten release checklist evidence payload.
4. Regenerate component inventory/index and update completion report/gap tracker.

**Exit:** from-scratch docs function as standalone rebuild canon with executable verification and operations evidence requirements.

---

## F. Deliverables for next implementation PR
- New docs: infra/IaC, runbook, local bootstrap policy, architecture diagrams, UI artifacts reference.
- Updated docs: request pipeline contract, verification strategy, release checklist, automation spec, traceability matrix, known gaps tracker, SSOT index.
- Regenerated artifacts: `FROM_SCRATCH_COMPONENT_INVENTORY.md`, `FROM_SCRATCH_COMPONENT_INDEX.md`.
- Evidence: docs automation report + sync check + change impact map.
