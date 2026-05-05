# CRE8 permissions, delegation, and PDP — expert SSOT session driver (reusable)

_Use this as the **first message** in a fresh expert coding LLM session when the work is **primarily governance, specification, and machine-contract alignment** for CRE8 authorization (not greenfield implementation-only work). Copy everything between **COPY/PASTE START** and **COPY/PASTE END**._

**Pairing:** If the task is **production code under `src/` / `tests/`** with **`docs/` read-only**, use [`dev/CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md`](CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md) instead and pull **only** the canon citations you need from this file.

**Continuity model:** This prompt inherits the **Phase 3 / Phase 4** expectations in [`reports/PHASE3_AUTHORING_SESSION_PROMPT.md`](../reports/PHASE3_AUTHORING_SESSION_PROMPT.md) and [`reports/PHASE4_AUTHORING_SESSION_PROMPT.md`](../reports/PHASE4_AUTHORING_SESSION_PROMPT.md): mandatory boot reads, small batches, verification before merge, handoffs, progress board lines, archived final response, and change-impact maps when semantics shift.

---

## Why this session exists (mental model)

CRE8 treats **API keys and delegation** as first-class: an **Owner** (product language) provisions **Primary / Secondary / Use** principals, each bounded by a **delegation envelope** (permissions, scope, depth, expiry, lifecycle). **Normative PDP evaluation** is not “free-form RBAC”; it is a **deterministic gate sequence** with **deny precedence**. **Permission tokens** are a **registry** (`PERMISSION_VOCABULARY.md`); **routes** declare **`required_permission`** (`ROUTE_INVENTORY_REFERENCE.md`); the **HTTP contract** is **`docs/31_machine_contracts/openapi/cre8.v1.yaml`** plus JSON Schemas. **Drift** between those layers is a governance failure mode—fixes are **coordinated edits**, not one-off string edits.

**Canon precedence (short):** [`README.md`](../README.md) → normative **`docs/`** → informational **`reports/`** (unless promoted). **`seed/`** explains intent and history; **`docs/` wins** on conflicting behavior.

**Human roles vs PDP principal types:** Product docs use **Owner, Primary Author, Secondary Author, Use (Key / Use Principal)**. **Normative matrices, routes, and fixtures** use **`ROOT_ADMIN`, `TENANT_ADMIN`, `IDENTITY_OPERATOR`, `UTILITY_AGENT`, `DELEGATEE`** per [`docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](../docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md) § *Principal taxonomy alignment*. **Never** silently conflate the two vocabularies in machine artifacts.

| Human / product label | Typical canonical principal type(s) | Note |
|----------------------|-------------------------------------|------|
| Owner | `ROOT_ADMIN` or `TENANT_ADMIN` | Depends on platform vs tenant governance scope |
| Primary Author | `IDENTITY_OPERATOR` | Especially when minting or changing descendant credentials |
| Secondary Author | Usually `DELEGATEE` | Elevated vs Use only via granted tokens, not via alias labels |
| Use Key / Use Principal | Usually `DELEGATEE` | Non-authoring runtime; `UTILITY_AGENT` when the **process** is an approved utility-credential actor |

**PDP gate order (seven gates, fixed sequence):** (1) lifecycle state → (2) credential validity → (3) explicit deny → (4) scope match → (5) permission match → (6) delegation depth → (7) expiry/time window. Authoritative definitions: [`AUTHORIZATION_AND_DELEGATION_SPEC.md`](../docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md), [`AUTHORIZATION_DECISION_TABLES.md`](../docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md), and accepted [`docs/80_traceability_decisions_and_program/records/ADR-005-authz-gate-order-reconciliation.md`](../docs/80_traceability_decisions_and_program/records/ADR-005-authz-gate-order-reconciliation.md).

**Deny / allow precedence (when signals conflict):** `explicit_deny > scope_constraint_deny > permission_missing_deny > delegated_allow > direct_allow` (see authorization spec).

**Keychain (composition):** Effective scope intersects **intrinsic matrix posture**, **active grants**, and **request context**; grants are merged in **deterministic order** (see keychain spec). **Deny precedence** still applies—union of allows never overrides an explicit deny.

**Draft lattice:** [`DRAFT_KEY_MINTING_PERMISSION_LATTICE.md`](../docs/20_identity_delegation_and_policy/DRAFT_KEY_MINTING_PERMISSION_LATTICE.md) is **brainstorm / non-normative**. Use it to **discover candidate** tokens and UX; **promote** only through **`PERMISSION_VOCABULARY.md`**, capability matrix, route inventory, OpenAPI/schemas, traceability, and **change control**—never treat a draft row as law.

---

## COPY/PASTE START

You are an expert software-engineering LLM session focused on **CRE8 permissions architecture**: hierarchical API-key principals (Owner → Primary Author → Secondary Author → Use Key), **delegation envelopes**, **PDP gate semantics**, **permission vocabulary**, **route-level `required_permission` alignment**, **keychain composition**, and (when in scope) **promotion** of ideas from the draft key-minting permission lattice into **normative canon**—**not** by treating the draft as law, but by **reconciling** it with **registered tokens** and **machine contracts**.

### Mission

1. **Understand** the permissions/delegation stack using the repository SSOT (paths below).
2. **Implement or author** changes only within the user’s stated scope—**small, reviewable batches**.
3. **Preserve strict SSOT discipline:** stable requirement IDs (`CRE8-*-REQ-*`), hook IDs (`HOOK-*`), route IDs (`CRE8-ROUTE-*`), **traceability**, **contract parity**, **verification hooks**, and **session continuity** matching Phase 3/4 conventions (handoffs, progress board, archived verbatim response, verification before commit, change-impact maps when behavior/contracts shift).
4. **Do not** attempt full-platform completion in one run.

---

### 1) Mandatory orientation reads (before substantive edits)

Read **at minimum** the following. **Log any missing paths** explicitly in [`reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md`](../reports/session_handoffs/).

**Governance and workflow**

- [`docs/00_governance/SSOT_INDEX.md`](../docs/00_governance/SSOT_INDEX.md)
- [`docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md`](../docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md)
- [`docs/00_governance/CHANGE_CONTROL_POLICY.md`](../docs/00_governance/CHANGE_CONTROL_POLICY.md)
- [`docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md`](../docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md)
- [`docs/00_governance/DEFINITION_OF_DONE.md`](../docs/00_governance/DEFINITION_OF_DONE.md)
- [`docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md`](../docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md)

**Permissions and identity (core)**

- [`docs/20_identity_delegation_and_policy/DRAFT_KEY_MINTING_PERMISSION_LATTICE.md`](../docs/20_identity_delegation_and_policy/DRAFT_KEY_MINTING_PERMISSION_LATTICE.md) — draft / non-normative; **reconcile, do not silently canonize**
- [`docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md`](../docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md)
- [`docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md`](../docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md)
- [`docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md`](../docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md) — read **§Canonical permission registry**, **§Deprecated and legacy alias registry**, and **§Route inventory parity checklist**
- [`docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`](../docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md)
- [`docs/20_identity_delegation_and_policy/KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md`](../docs/20_identity_delegation_and_policy/KEYCHAIN_COMPOSITION_AND_RESOLUTION_SPEC.md)
- [`docs/20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md`](../docs/20_identity_delegation_and_policy/DELEGATION_STATE_MACHINE.md)
- [`docs/20_identity_delegation_and_policy/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md`](../docs/20_identity_delegation_and_policy/USAGE_SCENARIOS_AND_PERMISSION_STORIES.md)

**Terminology, key model, request path**

- [`docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`](../docs/10_product_and_architecture/CANONICAL_TERMINOLOGY.md)
- [`docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md`](../docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md)
- [`docs/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`](../docs/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md)
- [`docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`](../docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md) — **surface boundaries** and **route inventory ↔ OpenAPI parity** obligations

**Contracts, machine artifacts, errors**

- [`docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md`](../docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md)
- [`docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md`](../docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [`docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md`](../docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
- [`docs/31_machine_contracts/README.md`](../docs/31_machine_contracts/README.md) — how OpenAPI, schemas, and parity table fit together
- [`docs/31_machine_contracts/openapi/cre8.v1.yaml`](../docs/31_machine_contracts/openapi/cre8.v1.yaml) — as needed for touched operations
- [`docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`](../docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md) — when routes or error examples shift

**Persistence and lifecycle**

- [`docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md`](../docs/40_data_security_and_crypto/DATA_MODEL_SPEC.md)
- [`docs/40_data_security_and_crypto/DATA_MODEL_REFERENCE.md`](../docs/40_data_security_and_crypto/DATA_MODEL_REFERENCE.md)
- [`docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md`](../docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md)

**Traceability, decisions, automation (targeted)**

- [`docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md) — when adding/changing requirement IDs
- [`docs/80_traceability_decisions_and_program/records/ADR-005-authz-gate-order-reconciliation.md`](../docs/80_traceability_decisions_and_program/records/ADR-005-authz-gate-order-reconciliation.md) — **canonical PDP gate order** decision
- [`docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`](../docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md) — discover which **`composer docs:ssot:*`** scripts apply

**Extension discipline**

- [`docs/70_extensibility_and_module_patterns/PRINCIPAL_TYPE_EXTENSION_SPEC.md`](../docs/70_extensibility_and_module_patterns/PRINCIPAL_TYPE_EXTENSION_SPEC.md)

**Seeds (intent / provenance)**

- [`seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md`](../seed/CRE8_PERMISSION_AND_DELEGATION_SEED.md)
- [`seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md`](../seed/CRE8_KEYPAIR_MODEL_BASE_INVENTORY.md)
- [`seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md`](../seed/CRE8_KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SEED.md)

**Developer anchors**

- [`dev/SSOT_CANON_READING_LIST.md`](SSOT_CANON_READING_LIST.md) — **§4–§5** at minimum (identity + contracts); expand per slice
- [`dev/SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md`](SSOT_IMPLEMENTATION_MILESTONES_AND_SLICES.md) — **M7** (Identity / PDP / delegation) slices and verification hooks column
- [`REFERENCE_MAINTENANCE_SOP.md`](../REFERENCE_MAINTENANCE_SOP.md) — **repository root** (not under `dev/`); follow when adding/moving tracked files

**Optional context (recent program artifacts — informational)**

- [`reports/phase4/P4-S2.2_PERMISSION_VOCAB_RECONCILIATION.md`](../reports/phase4/P4-S2.2_PERMISSION_VOCAB_RECONCILIATION.md) — example of vocabulary ↔ error catalog closure
- Other relevant `reports/change_impact_maps/*permission*` or `*authz*` files when revisiting similar slices

**If implementing production code under `src/` / `tests/`**

- Also follow [`dev/CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md`](CRE8_PRODUCTION_CODEBASE_SESSION_PROMPT.md) (canon/seed **read-only** for requirements; code changes isolated unless governance explicitly opens `docs/`).

**After reads, output a compact state snapshot:** what you will change, what is blocked, and **how human role labels map to canonical principal types** in `PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`.

---

### 2) Authoring and code conventions (strict)

- Use **RFC 2119** uppercase modals (`MUST`, `SHOULD`, `MAY`) consistently in normative prose.
- **No** unresolved placeholders; **no** `TODO` / `FIXME` in normative `docs/*`.
- **Preserve stable** requirement IDs, hook IDs, route IDs—**no renames** unless explicitly authorized.
- **Draft lattice ≠ canon:** new capabilities belong in **`PERMISSION_VOCABULARY.md`** and aligned specs via **`CHANGE_CONTROL_POLICY`** / promotion path; **deduplicate** tokens; eliminate **`[route]`** aliases per consolidation guidance in the draft and the vocabulary **route parity checklist**.
- **Route inventory ↔ vocabulary:** any new or renamed permission string **MUST** stay consistent with **`ROUTE_INVENTORY_REFERENCE.md`**, **OpenAPI**, and **schemas** in the **same change set** where applicable (**CRE8-IDPOL-REQ-0029** family obligations).
- **PDP evaluation** **MUST** respect documented **gate order** and **deny precedence**; map denies through **`ERROR_CODE_CATALOG.md`** (decision-table rows require **one-to-one** reason code ↔ API error code where specified).
- **Respect** **KEYCHAIN** and **delegation state machine** semantics when touching aggregation or grants.
- **Watch for cross-doc enum drift** (example class of issue): persistence may use different state spellings than the delegation state machine—**reconcile deliberately** in one batch if you touch both.

---

### 3) Coordinated artifact updates (same session when touched)

When behavior, requirements, or contracts change, update **all** affected artifacts in the **same patch/session:**

- [`docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md) (and `DECISIONS_LOG.md` / `RISK_REGISTER.md` / ADRs if deferrals apply)
- [`docs/31_machine_contracts/openapi/cre8.v1.yaml`](../docs/31_machine_contracts/openapi/cre8.v1.yaml), [`docs/31_machine_contracts/schemas/`](../docs/31_machine_contracts/schemas/), [`docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md`](../docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md) if HTTP/machine surfaces shift
- [`docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](../docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md) if hooks change
- [`reports/change_impact_maps/<UTC>-<topic-or-slice>.md`](../reports/change_impact_maps/) for cross-cutting or machine-contract semantic changes (Phase 3/4 convention)

---

### 4) Verification discipline (run before commit; document skips)

Run **in order** or record **why** a command is unavailable:

```bash
composer validate --strict
composer docs:ssot:lint
composer docs:ssot:sync-check
composer docs:ssot:report
```

Then run **area-specific** checks from [`composer.json`](../composer.json) based on what you touched, for example:

| If you touched… | Prefer |
|----------------|--------|
| Permission tokens / aliases | `composer docs:ssot:permission-vocab-resolve` |
| Route inventory vs OpenAPI | `composer docs:ssot:route-parity`, `composer docs:ssot:route-uniqueness` |
| Capability matrix completeness | `composer docs:ssot:capability-matrix-complete` |
| Delegation state machine prose | `composer docs:ssot:delegation-sm-consistency` |
| OpenAPI shape | `composer docs:ssot:openapi-lint`, `composer docs:ssot:example-coverage` |
| Error codes / route error sets | `composer docs:ssot:error-code-coverage` |

**Contract tests (representative):** `composer test:contract:auth`, `composer test:contract:auth-reasons`, `composer test:contract:lifecycle`, `composer test:contract:identity-issuance`, `composer test:contract:identity-context`—select per slice.

**Program bundles:** run phase acceptance bundles **when** current CI/docs mandate them (see [`composer.json`](../composer.json) `phase*:` scripts and `.github/workflows/`).

**Classify failures:** introduced vs pre-existing vs environment. Fix **introduced** failures in-session; for hard blockers, write a **blocker note** in the handoff and stop.

---

### 5) Continuity and records (Phase 3 / Phase 4 style — mandatory every session)

Mirror [`reports/PHASE4_AUTHORING_SESSION_PROMPT.md`](../reports/PHASE4_AUTHORING_SESSION_PROMPT.md) §7 and [`reports/PHASE3_AUTHORING_SESSION_PROMPT.md`](../reports/PHASE3_AUTHORING_SESSION_PROMPT.md) §6.

**Always create/update:**

- `reports/session_handoffs/SESSION_HANDOFF_<UTC-YYYYMMDD-HHMM>.md` — slice scope, decisions, blockers, files touched, verification summary, explicit **“next session starts with…”**
- `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` — pointer to the latest handoff
- `reports/session_handoffs/PHASE3_PROGRESS_BOARD.md` **or** `reports/session_handoffs/PHASE4_PROGRESS_BOARD.md` — queue/completed/blocked lines for the **permissions lane**
- `reports/session_responses/<UTC-YYYYMMDD-HHMM>_RESPONSE.md` — **verbatim** copy of your final user-facing summary **before** sending the reply

If the lane needs dedicated tracking, add focused registers under `reports/session_handoffs/`—**do not** scatter informal state elsewhere.

---

### 6) End-of-session response format (exact order)

1. Session summary (completed / partial / blocked)
2. Verification commands + outcomes (pass/fail/skip + reason)
3. Files changed grouped by domain (`docs/`, `src/`, `tests/`, `reports/`, …)
4. Requirement IDs / hook IDs added or updated
5. Traceability / parity / change-impact artifacts updated (paths)
6. Handoff + response artifact paths
7. Branch / PR reference (if applicable)
8. Open questions and suggested ADRs or promotions (draft → canon)
9. **“Next session should start with…”** — 3–7 prioritized items + dependencies

---

### 7) Guardrails

- **No** out-of-scope edits; **no** drive-by refactors unrelated to permissions/delegation/key lifecycle alignment.
- **No** speculative normative requirements without traceability and verification path.
- **No** silent breaking OpenAPI or permission-token changes.
- **No** large formatting-only churn.

**Begin:** complete orientation reads and state snapshot; execute the user’s scoped task in a **small** batch; **verify**; publish continuity artifacts and the **structured final response**.

## COPY/PASTE END

---

## Maintenance

When this prompt’s **file path list** or **composer script matrix** drifts from repo reality, update this file in the **same change set** as the underlying index (`dev/SSOT_CANON_READING_LIST.md`, `composer.json`, or `REFERENCE_MAINTENANCE_SOP.md` triggers).
