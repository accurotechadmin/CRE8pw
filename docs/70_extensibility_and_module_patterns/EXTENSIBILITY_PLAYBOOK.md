---
doc_id: CRE8-EXT-PLAYBOOK
version: 1.0.0
status: normative
owner: Platform Architecture WG
reviewers:
  - Security Engineering WG
  - Program Traceability WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-06-19
source_seed_refs:
  - seed/CRE8_EXTENSIBILITY_AND_MODULE_PATTERN_SEED.md
normative_dependencies:
  - docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md
  - docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md
  - docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---

# Extensibility Playbook

## Purpose
Define the mandatory workflow for adding new CRE8 modules without violating delegation, contract, lifecycle, and traceability invariants.

## Normative requirements
- **CRE8-EXT-REQ-0007**: Every module proposal **MUST** include a seam-compatibility declaration covering PDP chain preservation, envelope compatibility, lifecycle impact, and provenance impact before implementation begins.
- **CRE8-EXT-REQ-0008**: Module service registration **MUST** occur through `php-di/php-di` container bindings with deterministic lifecycle scope (`singleton`/`request`) declared in module docs.
- **CRE8-EXT-REQ-0009**: Module routes **MUST** be bound through `slim/slim` route groups that preserve canonical middleware ordering and **MUST NOT** bypass authorization middleware.
- **CRE8-EXT-REQ-0010**: Any new module API surface **MUST** add or update OpenAPI operations, JSON Schemas, route inventory rows, and prose parity rows in the same patch.
- **CRE8-EXT-REQ-0011**: Each module change **MUST** register or reuse verification hooks and **MUST** add traceability rows for every new requirement in the same change set.
- **CRE8-EXT-REQ-0027**: Extension patches **MUST NOT** weaken canonical identity, delegation, lifecycle, data-classification, or cryptographic controls; any attempted override **MUST** be rejected unless an ADR-approved exception with explicit expiry is present.
- **CRE8-EXT-REQ-0032**: Extension proposals **MUST** include explicit cross-links to route/webhook contract anchors and permission-vocabulary anchors for every changed behavior surface; missing cross-links **MUST** block merge until resolved in prose and traceability artifacts.

## Required extension workflow
| Step | Required artifact | Pass condition |
|---|---|---|
| 1. Proposal | Change-impact map + seam-compatibility declaration | Declares compatibility posture (`compatible`, `additive`, `breaking`) and target hooks. |
| 2. Registration | DI registration spec and route binding plan | Container registrations and middleware order are explicit and deterministic. |
| 3. Contract updates | OpenAPI + schema + route inventory + parity table | All changed routes have synchronized prose/machine artifacts. |
| 4. Verification updates | Hook registration + executable command mapping | New or updated hooks appear in verification + automation docs and run in Composer commands. |
| 5. Traceability closure | Trace matrix rows + evidence links + handoff entry | Every new requirement is trace-linked and evidence path is present. |

## Implementation-binding dependencies
- `php-di/php-di` **MUST** provide deterministic module service registration.
- `slim/slim` **MUST** enforce route group and middleware ordering invariants.
- `slim/psr7` **SHOULD** preserve canonical envelope handling behavior for extension request/response flows.
- `phpunit/phpunit` **MUST** enforce extension seam compatibility checks through automated hooks.

## Verification hooks
| Hook ID | Enforcement |
|---|---|
| `HOOK-EXT-SEAM-COMPATIBILITY` | Validates seam declaration, DI registration, route binding order, PDP-preservation assertions, and non-overridable core-control enforcement. |

Change Impact Map: `reports/change_impact_maps/20260430-1335-P3-S9.10-P3-S10.1.md`.

## See also
- [Module Boundaries and Ownership](./MODULE_BOUNDARIES_AND_OWNERSHIP.md)
- [Integration Provider Pattern](./INTEGRATION_PROVIDER_PATTERN.md)
- [API Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Verification Strategy](../60_operations_quality_and_release/VERIFICATION_STRATEGY.md)
