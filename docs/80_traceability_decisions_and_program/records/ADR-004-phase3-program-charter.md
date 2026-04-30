---
doc_id: CRE8-ADR-004
version: 1.0.0
status: accepted
owner: Platform Architecture WG
reviewers:
  - Docs Governance WG
  - Security WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-07-29
source_seed_refs:
  - reports/PHASE3_AUTHORING_PROGRAM_PLAN.md
  - reports/PHASE3_ENTRY_AUDIT_20260430-0356.md
normative_dependencies:
  - reports/PHASE3_AUTHORING_PROGRAM_PLAN.md
  - reports/PHASE3_ENTRY_AUDIT_20260430-0356.md
  - docs/80_traceability_decisions_and_program/records/ADR-003-phase1-freeze-waiver.md
  - docs/80_traceability_decisions_and_program/ADR_INDEX.md
  - docs/80_traceability_decisions_and_program/DECISIONS_LOG.md
  - docs/80_traceability_decisions_and_program/RISK_REGISTER.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# ADR-004: Phase 3 — Canon Completion Program Charter
- Status: accepted
- Date (UTC): 2026-04-30
- Owners: Platform Architecture WG
- Reviewers: Docs Governance WG, Security WG, Program Traceability WG

## Context

The CRE8 SSOT corpus passed Phase 1 freeze (closed by ADR-003) and Phase 2 machine-contract lock-in. The Phase 3 entry-state audit ([`reports/PHASE3_ENTRY_AUDIT_20260430-0356.md`](../../../reports/PHASE3_ENTRY_AUDIT_20260430-0356.md)) recorded the following at audit timestamp:

- 238 normative requirements, 83 traced, **155 untraced** (≈ 65.1% untraced).
- 33 D-grade scaffold-prose documents under `docs/`, plus a captured catalogue of 9 active conflicts spanning auth gate order, schema/example reconciliation, OpenAPI structural defects, hook-ID casing drift, doc-id ↔ filename ↔ matrix mismatches, stale `source_seed_refs`, `composer.json` ↔ scripts drift, CI workflow filename drift, and `dot.env` realistic-secret hygiene.
- Phase 1 / Phase 2 acceptance bundles green; the Phase 3 program plan ([`reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`](../../../reports/PHASE3_AUTHORING_PROGRAM_PLAN.md)) defines 13 milestones (M0..M12) and 69 slices (`P3-S<milestone>.<slice>`) intended to bring the corpus to a state where an implementation team can author `src/` and `tests/` against the SSOT without making invariant decisions.

The previously published `README.md` (§12) consolidates the historical Phase 3 (operational readiness integration) and Phase 4 (scaled domain expansion) into a single **Phase 3 — Canon Completion** program subsumed by this charter. ADR-003 closed the Phase 1 freeze with an explicit residual-breadth waiver and is **not** reusable as a deferral mechanism for Phase 3 work.

A formal program charter is required to bind Phase 3 scope, sequencing, deferral discipline, and acceptance bar to ADR governance so that the program cannot drift across many authoring sessions.

## Decision

ADR-004 ratifies and binds the following.

- **ADR-004-REQ-0001**: The Phase 3 — Canon Completion program defined in [`reports/PHASE3_AUTHORING_PROGRAM_PLAN.md`](../../../reports/PHASE3_AUTHORING_PROGRAM_PLAN.md) **MUST** be the sole authoritative scope plan for Phase 3 authoring work. Any change to Phase 3 scope, sequencing, exit criteria, or definition of done **MUST** be made by amending that plan and recording the amendment via a new DLOG entry referencing this ADR or a successor ADR.
- **ADR-004-REQ-0002**: Phase 3 work **MUST** progress through milestones in dependency order as declared in §5 of the program plan (M0 → everything; M1 → M2..M12; M2 → M3..M12; M3 → M4..M11; M4 → M5, M8, M10; M5 → M6; M6 → M11; M7 → M8, M9, M11; M8 → M9, M10; M9 → M11; M10 → M11; M11 → M12). Slices inside a milestone MAY parallelize where the plan permits, but a slice **MUST NOT** start while any predecessor slice it lists in `Dependencies` is `not_started`, `in_progress`, or `blocked`.
- **ADR-004-REQ-0003**: ADR-003 (Phase 1 freeze closure with residual-breadth waiver) **MUST NOT** be reused as a generic deferral mechanism for Phase 3 work. New Phase 3 deferrals **MUST** be authored as new ADRs that explicitly cite the deferred scope, owner, due date (UTC), and re-entry criteria.
- **ADR-004-REQ-0004**: Every Phase 3 deferral **MUST** specify owner, due date (UTC, `YYYY-MM-DD`), `decision_ref` (an existing ADR ID or a new `DLOG-YYYYMMDD-###` event), evidence path, and re-entry criteria. Items lacking any of these fields **MUST** be rejected at review and **MUST NOT** be merged.
- **ADR-004-REQ-0005**: Every behavioral `MUST` or `SHOULD` introduced or modified by a Phase 3 slice **MUST** cite the Composer dependency that enforces it (e.g., `slim/slim`, `slim/psr7`, `php-di/php-di`, `firebase/php-jwt`, `ext-sodium`, `ext-pdo`, `respect/validation`, `vlucas/phpdotenv`, `guzzlehttp/guzzle`, `neomerx/cors-psr7`, `monolog/monolog`, `symfony/rate-limiter`, `symfony/cache`, `phpunit/phpunit`). If no dependency applies, the doc **MUST** state that explicitly.
- **ADR-004-REQ-0006**: Every requirement-bearing change **MUST** be accompanied by a row in [`docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md`](../TRACEABILITY_MATRIX.md) committed in the same change set (per `CRE8-TRACE-REQ-0005`). New hooks **MUST** be registered in [`docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`](../../60_operations_quality_and_release/VERIFICATION_STRATEGY.md) and (when executable) [`docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md`](../SSOT_AUTOMATION_AND_LINTING.md) in the same change set.
- **ADR-004-REQ-0007**: Every change to a machine artifact (OpenAPI document, JSON Schema, route inventory, parity table) **MUST** be accompanied by a Change Impact Map under `reports/change_impact_maps/<UTC>-<slice-id>.md`, authored from the [`CHANGE_IMPACT_MAP_TEMPLATES.md`](../CHANGE_IMPACT_MAP_TEMPLATES.md).
- **ADR-004-REQ-0008**: The program-wide scaffold opener phrase `"This scaffold file defines the authoritative scope, boundaries, and eventual normative obligations for"` **MUST** be removed from every doc by close of milestone M2. After M2 closes, the scaffold-prose lint introduced by `P3-S2.4` **MUST** block PRs that reintroduce the phrase anywhere in `docs/`, `reports/`, or `seed/`. The lint **MAY** exempt occurrences that appear inside backtick-quoted code spans for the express purpose of self-documenting the lint itself.
- **ADR-004-REQ-0009**: The `composer phase2:acceptance-bundle` command **MUST** stay green throughout Phase 3. Slices **MUST NOT** be merged that regress the bundle. Once `P3-S11.3` lands, `composer phase3:final-acceptance-bundle` **MUST** be the merge-blocking superset and `phase2:acceptance-bundle` **MUST** remain runnable as a strict subset for forward compatibility.
- **ADR-004-REQ-0010**: Each authoring session **MUST** complete and publish a session handoff under `reports/session_handoffs/SESSION_HANDOFF_<UTC>.md`, update `reports/session_handoffs/LATEST_SESSION_HANDOFF.md` to point at it, refresh [`reports/session_handoffs/PHASE3_PROGRESS_BOARD.md`](../../../reports/session_handoffs/PHASE3_PROGRESS_BOARD.md) (authored under slice `P3-S0.3`), and archive the verbatim final response under `reports/session_responses/<UTC>_RESPONSE.md`.
- **ADR-004-REQ-0011**: Phase 3 closure **MUST** require all of: `composer phase3:final-acceptance-bundle` PASS in CI on `main`; `reports/ssot/coverage_latest.json` reports `untraced_requirements: 0` and `manual_only_verification_hooks: 0` (or ≤ 3 with explicit ADR backing per a successor ADR); zero scaffold-prose hits across `docs/`, `reports/`, and `seed/`; every route in [`ROUTE_INVENTORY_REFERENCE.md`](../../30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md) carries full schema + example + parity row + error mapping; every `THREAT-###` row carries at least one mapped control and one abuse case; and the Phase 3 acceptance memo (`reports/PHASE3_ACCEPTANCE_MEMO.md`) is `status=normative` and references this ADR plus the program plan.
- **ADR-004-REQ-0012**: The owners listed in §"Slice ownership table" below **MUST** be the accountable working groups for each milestone. Owners MAY delegate but **MUST NOT** silently transfer accountability without a DLOG entry referencing this ADR.
- **ADR-004-REQ-0013**: Each Phase 3 slice **MUST** record `not_started`, `in_progress`, `partially_complete`, `complete`, or `blocked` status on the progress board. The phrase "100% with residuals" is prohibited; partial completion **MUST** be split into `partially_complete` plus an explicit residuals list with owner, due date, and `decision_ref` for each residual line.
- **ADR-004-REQ-0014**: New requirement IDs introduced under Phase 3 **MUST** follow `CRE8-<DOMAIN>-REQ-####` and **MUST NOT** be renamed once published. New hook IDs **MUST** follow `HOOK-<DOMAIN>-<TOPIC>` (uppercase). Decision events **MUST** use `DLOG-YYYYMMDD-###`. Phase 3 exceptions **MUST** use `P3-EXC-###`.
- **ADR-004-REQ-0015**: Phase 3 **MUST NOT** introduce any external Composer dependency unless the slice authoring it is explicitly named in an amendment to the program plan and approved by Platform Architecture WG and Security WG. The current dependency baseline in `composer.json` (PHP 8.5.5; `slim/slim`, `slim/psr7`, `php-di/php-di`, `firebase/php-jwt`, `ext-sodium`, `ext-pdo`, `respect/validation`, `vlucas/phpdotenv`, `guzzlehttp/guzzle`, `neomerx/cors-psr7`, `monolog/monolog`, `symfony/rate-limiter`, `symfony/cache`, `phpunit/phpunit`) is the binding architectural bedrock for Phase 3 authoring.

## Slice ownership table

The following ownership assignments apply to Phase 3 milestones, derived from `docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md` and §3 of the program plan. Where multiple working groups appear in a row, the leading group is the slice owner; subsequent groups are required reviewers for slices in that milestone.

| Milestone | Slices | Owner WG | Required reviewer WGs |
|---|---|---|---|
| M0 | P3-S0.1..0.4 | Program Traceability WG | Docs Governance WG; Platform Architecture WG |
| M1 | P3-S1.1..1.9 | Platform Architecture WG | Identity & Policy WG; API Contracts WG; Security WG; Operations Quality WG |
| M2 | P3-S2.1..2.5 | Docs Governance WG | Program Traceability WG; Platform Architecture WG |
| M3 | P3-S3.1..3.6 | Platform Architecture WG | Docs Governance WG; Delivery Operations WG |
| M4 | P3-S4.1..4.5 | Identity & Policy WG | Security WG; Docs Governance WG |
| M5 | P3-S5.1..5.5 | API Contracts WG | Delivery Operations WG; Docs Governance WG |
| M6 | P3-S6.1..6.4 | API Contracts WG | Delivery Operations WG; Security WG |
| M7 | P3-S7.1..7.8 | Security WG | Platform Architecture WG; Docs Governance WG |
| M8 | P3-S8.1..8.2 | Product Policy WG | Platform Architecture WG; Security WG |
| M9 | P3-S9.1..9.10 | Operations Quality WG | Delivery Operations WG; Platform Architecture WG |
| M10 | P3-S10.1..10.4 | Platform Architecture WG | Security WG; Docs Governance WG |
| M11 | P3-S11.1..11.5 | Program Traceability WG | Operations Quality WG; Platform Architecture WG |
| M12 | P3-S12.1..12.3 | Program Traceability WG | Docs Governance WG; Platform Architecture WG; Security WG |

## Alternatives considered

- **Option A — keep informal Phase 3 plan**: continue using the program plan in `reports/` as a non-binding planning artifact. Rejected: 13 milestones × 69 slices over many sessions cannot survive without ADR-bound governance; drift risk dominates.
- **Option B — split Phase 3 into many small ADRs**: one ADR per milestone. Rejected as premature: the program-wide invariants (ADR-003 carry-over rule, deferral discipline, lint enforcement, dependency baseline) belong in a single charter; per-milestone ADRs MAY still be authored when a milestone introduces an architectural decision (e.g., the auth gate sequence is captured by a separate ADR-005 under P3-S1.1).
- **Option C — defer charter authoring until tier-1 blockers are resolved**: rejected because the entry audit explicitly recommends this charter as M0 work and several downstream slices reference ADR-004 as their `decision_ref`.

## Consequences

- **Positive**:
  - Phase 3 scope, sequencing, and acceptance bar are bound to ADR governance and cannot drift silently.
  - ADR-003 cannot be reused for Phase 3 deferrals; new ADRs are the only legitimate path to defer scope.
  - Acceptance criteria, dependency baseline, traceability discipline, and verification gates become normative obligations rather than guidance.
- **Negative**:
  - Each cross-domain change now requires a Change Impact Map plus a traceability matrix update plus a hook registration in the same patch, increasing per-PR cost.
  - Authoring sessions must complete and publish handoff plus progress board plus archived response artifacts every run.
- **Neutral**:
  - The `composer.json` baseline already in place under PHP 8.5.5 is unaffected.
  - Existing Phase 1 and Phase 2 hardened content is unaffected.

## Traceability linkage
- Requirement IDs introduced by this ADR: `ADR-004-REQ-0001` .. `ADR-004-REQ-0015`.
- Related risk IDs: `RISK-001`, `RISK-002`, `RISK-010`, `RISK-011`, `RISK-012`, `RISK-013`, `RISK-014` (added under M0 per program plan §4).
- Verification hooks: `HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE` (existing), `HOOK-TRACE-DECISION-ADR-LINK`, `HOOK-TRACE-MATRIX-COVERAGE`, plus the Phase 3-introduced hooks `HOOK-SSOT-DOD-PLACEHOLDER-BLOCK`, `HOOK-SSOT-GLOSSARY-COVERAGE`, `HOOK-CONTRACT-SCHEMA-COVERAGE`, `HOOK-CONTRACT-EXAMPLE-COVERAGE`, `HOOK-OPENAPI-LINT`, `HOOK-DATA-MODEL-COVERAGE`, `HOOK-SEC-THREAT-CONTROL-MATRIX`, `HOOK-OBS-EVENT-CATALOG-COVERAGE`, `HOOK-PERMISSION-VOCAB-RESOLVE`, `HOOK-CAPABILITY-MATRIX-COMPLETE`, `HOOK-DELEGATION-STATE-MACHINE-CONSISTENCY`, `HOOK-RELEASE-CHECKLIST-PRESENT`, `HOOK-SLO-SLI-PRESENT` (registered as deliverables of M11).

## Supersession
- Supersedes: none.
- Superseded by: none.

## See also
- [Phase 3 program plan](../../../reports/PHASE3_AUTHORING_PROGRAM_PLAN.md)
- [Phase 3 entry audit](../../../reports/PHASE3_ENTRY_AUDIT_20260430-0356.md)
- [ADR Index](../ADR_INDEX.md)
- [Decisions Log](../DECISIONS_LOG.md)
- [Risk Register](../RISK_REGISTER.md)
- [Traceability Matrix](../TRACEABILITY_MATRIX.md)
- [ADR-003 Phase 1 Freeze Waiver](./ADR-003-phase1-freeze-waiver.md)
