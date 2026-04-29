# CRE8 Phase 1 Canon Hardening Roadmap (Execution-Ready)

Generated: 2026-04-29 (UTC)

## Mission
Execute Phase 1 with excellence by transforming the current scaffold-heavy SSOT corpus into normative, traceable, owner-assigned, reviewable, and verification-hooked canonical documentation.

Phase 1 outcomes to satisfy:
1. Upgrade scaffold docs into deterministic normative requirements.
2. Establish cross-document links, ownership metadata, and review workflow.
3. Define verification hooks for each major behavioral contract.

---

## 0) Current-state assessment (what must change first)

### Observed maturity profile
- Most `docs/` artifacts are template placeholders with shared prose and minimal domain-specific requirements.
- Seed documents in `seed/` carry the strongest concrete requirements and should be the primary upstream source for first hardening passes.
- `docs/31_machine_contracts/openapi/cre8.v1.yaml` exists as a placeholder and does not yet encode route-level contract behavior.
- Governance and traceability docs exist by filename structure but need normative content, ownership and operational mechanics.

### Immediate implication
Phase 1 should be executed as **structured canon conversion** (seed -> normative docs) with mandatory wiring into traceability, ownership, and verification.

---

## 1) Success criteria (Definition of Excellence)

Phase 1 is only complete when all of the following are true:

1. Every domain doc in `docs/` has deterministic normative statements (MUST/SHOULD/MAY policy) replacing placeholder text.
2. Every hardened doc includes metadata header fields:
   - `doc_id`, `version`, `status`, `owner`, `reviewers`, `last_reviewed_utc`, `next_review_due_utc`, `source_seed_refs`, `normative_dependencies`.
3. Bidirectional links exist between:
   - root `README.md`,
   - `docs/00_governance/SSOT_INDEX.md`,
   - domain docs,
   - traceability matrix,
   - machine contracts, and
   - evidence/verification strategy.
4. A formal review workflow is operational (author -> domain review -> security review when required -> approval -> release).
5. Every major contract area has at least one explicit verification hook definition (lint/test/spec-check/evidence artifact).
6. A minimum viable SSOT automation rule-set is documented (and script placeholders aligned) for lint, link integrity, metadata completeness, and doc-contract sync checks.

---

## 2) Execution model: 10 slices

## Slice 1 — Canon governance bootstrap (Week 1)

### Deliverables
- Harden `docs/00_governance/SSOT_INDEX.md` into authoritative index and precedence matrix.
- Harden `DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md` with required metadata schema and normative language rules.
- Harden `DOCUMENT_STATUS_AND_OWNERSHIP.md` with status taxonomy and ownership assignment protocol.

### Core outputs
- Canon metadata schema (required in every doc).
- Normative language rubric.
- SSOT status lifecycle (`draft`, `provisional-normative`, `normative`, `deprecated`).

### Verification hooks
- `docs:ssot:lint` checks metadata presence and prohibited placeholder phrases.

---

## Slice 2 — Seed-to-canon mapping lock (Week 1)

### Deliverables
- Build explicit mapping table from each seed artifact to corresponding docs domain artifacts.
- Define unresolved-seed-gap register (requirements present in seed but not yet promoted).

### Core outputs
- Promotion tracker with fields: seed requirement ID, target doc ID, normative status, verification hook ID.

### Verification hooks
- `docs:ssot:sync-check` compares mapped seed requirements against promoted doc requirement IDs.

---

## Slice 3 — Cross-document linking architecture (Week 2)

### Deliverables
- Define mandatory “See also” and “Normative dependencies” sections for each doc.
- Establish link topology rules:
  - vertical links (README -> SSOT index -> domain docs),
  - lateral links (domain-to-domain dependencies),
  - trace links (domain requirement -> matrix row -> evidence).

### Core outputs
- Link graph policy with anti-orphan rule.

### Verification hooks
- Link integrity checker in SSOT lint process.

---

## Slice 4 — Ownership + review workflow (Week 2)

### Deliverables
- Harden `CONTRIBUTION_WORKFLOW_SSOT.md`, `CHANGE_CONTROL_POLICY.md`, `DEFINITION_OF_DONE.md`.
- Define review gates by change class:
  - contract-impacting,
  - security-impacting,
  - governance-only,
  - editorial non-normative.

### Core outputs
- RACI-style responsibility matrix.
- Review SLA targets and escalation path.

### Verification hooks
- PR template rule: changed normative docs must include owner + reviewer + impact map references.

---

## Slice 5 — Traceability program hardening (Week 3)

### Deliverables
- Harden:
  - `TRACEABILITY_MATRIX.md`,
  - `CHANGE_IMPACT_MAP_TEMPLATES.md`,
  - `DECISION_RECORD_TEMPLATE.md`,
  - `DECISIONS_LOG.md`,
  - `ADR_INDEX.md`,
  - `RISK_REGISTER.md`,
  - `ROADMAP_AND_MILESTONES.md`.

### Core outputs
- Requirement ID scheme (`CRE8-<domain>-REQ-####`).
- Decision linkage scheme (`ADR-###` + impacted requirement IDs).
- Risk-to-control-to-evidence map.

### Verification hooks
- Traceability linter ensures each new requirement has:
  - verification hook,
  - owning doc,
  - decision/risk linkage where applicable.

---

## Slice 6 — Contract domain hardening (Week 3-4)

### Deliverables
- Prioritize and harden first contract-critical docs:
  - identity/delegation (`20_*`),
  - API and route contracts (`30_*`),
  - error catalog and runtime contract,
  - key lifecycle/crypto and controls (`40_*`).

### Core outputs
- Deterministic permission evaluation order.
- Stable error envelope and deny mapping rules.
- Lifecycle transition constraints and failure semantics.

### Verification hooks
- Contract conformance tests defined in `VERIFICATION_STRATEGY.md` and bound to `test:contract`, `test:security` scripts.

---

## Slice 7 — Machine contract synchronization (Week 4)

### Deliverables
- Elevate OpenAPI and JSON schemas from placeholders to baseline v1 machine contract for core endpoints.
- Define prose-to-machine sync rules.

### Core outputs
- Route inventory parity table (prose route ref <-> OpenAPI path/op).
- Schema registry with ownership metadata.

### Verification hooks
- CI check: no contract PR merges if prose/machine drift is detected.

---

## Slice 8 — Verification strategy and evidence binding (Week 4-5)

### Deliverables
- Harden `docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md` and evidence docs.
- Define evidence artifacts per contract family:
  - auth/delegation,
  - lifecycle,
  - content visibility/feed,
  - error determinism,
  - security abuse cases,
  - ops readiness checks.

### Core outputs
- Verification catalog with `hook_id`, `trigger`, `tool`, `expected_output`, `evidence_location`.

### Verification hooks
- `docs:ssot:report` compiles verification coverage and highlights missing hooks.

---

## Slice 9 — Programmatic quality gates (Week 5)

### Deliverables
- Define minimal hard-fail gates for Phase 1 completion:
  - metadata completeness,
  - link integrity,
  - traceability completeness,
  - machine/prose sync for hardened areas,
  - required reviews satisfied.

### Core outputs
- Phase 1 quality-gate matrix with pass/fail criteria.

### Verification hooks
- CI pipeline step group named `ssot_phase1_gate`.

---

## Slice 10 — Acceptance review + baseline freeze (Week 6)

### Deliverables
- Perform cross-domain canon review.
- Publish final Phase 1 acceptance memo in `reports/` plus updates to roadmap/decision logs.

### Core outputs
- Signed acceptance against success criteria.
- Backlog feed for Phase 2 machine-contract lock-in.

### Verification hooks
- Final readiness checklist with evidence links and unresolved exceptions register.

---

## 3) Required cross-cutting artifacts

1. **Requirement ID Standard** (all normative clauses uniquely addressable).
2. **Doc Metadata Standard** (header schema mandatory).
3. **Traceability Matrix Template v1** (requirement -> verification -> evidence -> owner).
4. **Review Workflow SOP** (branching, approvals, SLAs, risk escalations).
5. **Verification Hook Catalog** (single authoritative registry).
6. **Seed Promotion Ledger** (demonstrates preservation and intentional redesign).

---

## 4) Verification hook coverage map (minimum required)

Each major behavioral contract must define one or more hooks:

- Identity issuance and key hierarchy -> lifecycle and auth contract tests.
- Delegation bounds and PDP determinism -> policy decision table tests.
- API envelopes and error mappings -> contract snapshot tests.
- Security controls/replay/nonce/timestamp -> abuse-case tests.
- Audience and feed authorization semantics -> visibility and ordering tests.
- Revocation/rotation immediacy -> lifecycle propagation tests.
- Surface parity (UI/API) -> route-capability parity checks.
- Observability/provenance requirements -> event catalog completeness checks.

---

## 5) Work breakdown by team lanes

- **Governance lane**: 00 + 80 docs, workflow, ownership, traceability model.
- **Identity/policy lane**: 20 + relevant 10 docs, delegation/PDP formalization.
- **Contract lane**: 30 + 31 machine contracts + error catalog.
- **Security/data lane**: 40 docs (crypto, controls, model).
- **Content lane**: 50 docs (audience/feed/interactions).
- **Operations lane**: 60 docs (verification, release gates, readiness).
- **Extensibility lane**: 70 docs (module boundaries and extension invariants).

Each lane must publish weekly delta reports: hardened docs, unresolved decisions, risk movements, verification coverage deltas.

---

## 6) Cadence and governance rituals

- Weekly canon hardening review (owners + reviewers).
- Weekly risk and decision triage (ADR/log/register updates mandatory).
- Twice-weekly verification hook coverage check.
- End-of-sprint acceptance gate demonstration with evidence pack.

---

## 7) Risks and mitigations

1. **Risk**: placeholder replacement drifts from seed canon intent.
   - **Mitigation**: mandatory seed-promotion ledger and reviewer signoff on preservation map.
2. **Risk**: inconsistent requirement language quality.
   - **Mitigation**: style-guide lint checks and normative clause templates.
3. **Risk**: traceability inflation without enforcement.
   - **Mitigation**: hard CI gate on missing requirement->hook linkages.
4. **Risk**: machine/prose divergence early.
   - **Mitigation**: define sync checks as mandatory before expanding endpoint count.
5. **Risk**: overloaded reviewers slowing throughput.
   - **Mitigation**: lane-specific reviewer pools and SLA/escalation policies.

---

## 8) Phase 1 exit package (required artifacts)

1. Hardened governance docs with metadata, ownership, and workflow rules.
2. Hardened traceability and decision system docs.
3. Hardened high-priority domain docs (identity, contracts, security minimum set).
4. Baseline machine contracts synced to hardened prose for critical paths.
5. Verification strategy + hook catalog + evidence templates operational.
6. CI-configured Phase 1 quality gate definition.
7. Formal Phase 1 acceptance report with unresolved exceptions list.

---

## 9) Recommended immediate next 10 actions (execution kickoff)

1. Author metadata schema and normative language policy in governance docs.
2. Assign owners/reviewers for every docs domain directory.
3. Create requirement ID convention and update templates.
4. Publish seed-to-canon mapping ledger.
5. Harden SSOT index with dependency graph links.
6. Harden traceability matrix template + hook ID pattern.
7. Harden verification strategy with concrete hook catalog format.
8. Select top 12 critical docs for first hardening sprint (00, 20, 30, 40, 60, 80).
9. Draft first ADR for Phase 1 rulebook decisions.
10. Run first “Phase 1 readiness delta” review and publish findings.

This roadmap provides the full set of slices and controls to execute Phase 1 to a high assurance standard, while preserving CRE8’s ID-keypair-first, deterministic, auditable platform direction.
