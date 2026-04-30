---
doc_id: CRE8-TRACE-MATRIX
version: 1.2.0
status: normative
owner: Program Traceability WG
reviewers:
  - Docs Governance WG
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-29
source_seed_refs:
  - seed/
  - README.md
normative_dependencies:
  - docs/00_governance/SSOT_INDEX.md
  - docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md
  - docs/00_governance/CHANGE_CONTROL_POLICY.md
  - docs/00_governance/DEFINITION_OF_DONE.md
  - docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md
---

# Traceability Matrix

## Purpose
Define the mandatory requirement-to-verification traceability contract for all normative CRE8 documentation.

## Normative requirements
- **CRE8-TRACE-REQ-0001**: Every normative requirement statement **MUST** be represented by exactly one matrix row keyed by a unique `requirement_id`.
- **CRE8-TRACE-REQ-0002**: Each matrix row **MUST** include, at minimum: `requirement_id`, `source_doc_id`, `source_path`, `verification_hook_id`, `owner`, `status`, and `evidence_location`.
- **CRE8-TRACE-REQ-0003**: `requirement_id` values **MUST** use the pattern `CRE8-<DOMAIN>-REQ-####` where `<DOMAIN>` is uppercase alphanumeric and `####` is zero-padded numeric.
- **CRE8-TRACE-REQ-0004**: Each `verification_hook_id` **MUST** map to one deterministic check (automated script or defined manual procedure) and **MUST NOT** be reused for semantically unrelated checks.
- **CRE8-TRACE-REQ-0005**: Matrix rows for new or changed requirements **MUST** be updated in the same pull request as the originating doc change.
- **CRE8-TRACE-REQ-0006**: A row with `status=normative` **MUST** have a non-empty `evidence_location` that resolves to an existing evidence artifact path or designated evidence template.
- **CRE8-TRACE-REQ-0007**: If automated verification is unavailable, the row **MUST** set `verification_mode=manual` and include `manual_procedure_ref` with reproducible steps.
- **CRE8-TRACE-REQ-0008**: Traceability rows **MUST** reference related ADR IDs and risk IDs when requirement semantics include architectural tradeoffs or security/control impact.
- **CRE8-TRACE-REQ-0009**: Every row with `verification_mode=manual` **MUST** have a matching `hook_id` entry in `reports/session_handoffs/PHASE1_MANUAL_HOOK_BACKLOG.md` including owner, priority, and target automation command/script.

## Required matrix schema (minimum)
| Field | Required | Description |
|---|---|---|
| requirement_id | yes | Canonical requirement ID (`CRE8-<DOMAIN>-REQ-####`). |
| source_doc_id | yes | `doc_id` from source document metadata header. |
| source_path | yes | Repository-relative file path of normative source. |
| source_anchor | no | Heading or section anchor for precise location. |
| verification_hook_id | yes | Hook identifier (e.g., `HOOK-SSOT-LINT-METADATA`). |
| verification_mode | yes | `automated` or `manual`. |
| owner | yes | Team/role accountable for requirement verification. |
| status | yes | `draft`, `provisional-normative`, `normative`, `deprecated`. |
| evidence_location | yes | Repo path to evidence artifact or template. |
| related_adr_ids | no | Comma-separated ADR references (`ADR-###`). |
| related_risk_ids | no | Comma-separated risk IDs (`RISK-###`). |
| last_verified_utc | no | Date of latest successful execution. |

## Baseline matrix (Phase 1 seed rows)
| requirement_id | source_doc_id | source_path | verification_hook_id | verification_mode | owner | status | evidence_location |
|---|---|---|---|---|---|---|---|
| CRE8-GOV-REQ-0005 | CRE8-GOV-SSOT-INDEX | docs/00_governance/SSOT_INDEX.md | HOOK-SSOT-LINT-METADATA | manual | Docs Governance WG | normative | docs/evidence/templates/README.md |
| CRE8-GOV-REQ-0033 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-REVIEW-GATE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0053 | CRE8-GOV-DEFINITION-OF-DONE | docs/00_governance/DEFINITION_OF_DONE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0060 | CRE8-TRACE-ROADMAP-MILESTONES | docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md | HOOK-TRACE-ROADMAP-SCHEMA-AUTO | automated | Program Traceability WG | normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0070 | CRE8-TRACE-SEED-PROMOTION-TRACKER | docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md | HOOK-SEED-PROMOTION-SCHEMA-AUTO | automated | Program Traceability WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0080 | CRE8-TRACE-UNRESOLVED-SEED-GAPS | docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md | HOOK-SEED-GAP-REGISTER-SCHEMA-AUTO | automated | Program Traceability WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0090 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-LINT-METADATA | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0091 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-LINK-INTEGRITY | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0092 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-SYNC-PROMOTED-TRACE | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0093 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-SYNC-PROMOTED-TARGET | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0094 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-REPORT-COVERAGE-COVERAGE | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0095 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-COMMAND-EXIT-SEMANTICS | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0096 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-MANUAL-BACKLOG-LINK | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0097 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-PR-EVIDENCE-REQUIRED | automated | Program Traceability WG | provisional-normative | .github/workflows/ssot_phase_gate.yml |
| CRE8-TRACE-REQ-0098 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-PHASE1-GATE-CI | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0099 | CRE8-TRACE-SSOT-AUTOMATION | docs/80_traceability_decisions_and_program/SSOT_AUTOMATION_AND_LINTING.md | HOOK-SSOT-SYNC-MANUAL-BACKLOG | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-AUTH-REQ-0001 | CRE8-AUTH-DELEGATION-SPEC | docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md | HOOK-CONTRACT-POLICY-ORDER | automated | Identity & Policy WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-AUTH-REQ-0002 | CRE8-AUTH-DELEGATION-SPEC | docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md | HOOK-AUTH-INHERITANCE-BOUNDARY | automated | Identity & Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-AUTH-REQ-0006 | CRE8-AUTH-DELEGATION-SPEC | docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md | HOOK-AUTH-LIFECYCLE-ENFORCEMENT | automated | Identity & Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-AUTH-REQ-0010 | CRE8-AUTH-DECISION-TABLES | docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md | HOOK-CONTRACT-POLICY-ORDER | automated | Identity & Policy WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-AUTH-REQ-0015 | CRE8-AUTH-DECISION-TABLES | docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md | HOOK-AUTH-DECISION-REASON-MAPPING | automated | Identity & Policy WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-CONTRACT-REQ-0001 | CRE8-CONTRACTS-ERROR-CATALOG | docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md | HOOK-CONTRACT-ERROR-DETERMINISM | automated | API Contracts WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-CONTRACT-REQ-0004 | CRE8-CONTRACTS-ERROR-CATALOG | docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md | HOOK-CONTRACT-ERROR-SECRETS-REDACTION | automated | API Contracts WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-CONTRACT-REQ-0010 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0014 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-ERROR-CODE-COVERAGE | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0012 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-COMPAT-DECLARATION | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0020 | CRE8-CONTRACTS-ROUTE-INVENTORY | docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md | HOOK-CONTRACT-ROUTE-UNIQUENESS | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0023 | CRE8-CONTRACTS-ROUTE-INVENTORY | docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md | HOOK-CONTRACT-DEPRECATION-SCHEMA | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0016 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-METADATA-STABILITY | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0017 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-METADATA-STABILITY | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0018 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-ORDER-CURSOR | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0050 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-ORDER-CURSOR | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0051 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-ORDER-CURSOR | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0052 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-DENY-CODE-CATALOG | automated | API Contracts WG | provisional-normative | docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md |
| CRE8-CONTRACT-REQ-0053 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-DENY-CODE-CATALOG | automated | API Contracts WG | provisional-normative | docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md |
| CRE8-CONTRACT-REQ-0054 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-CURSOR-MULTIPAGE-MONOTONIC | automated | API Contracts WG | provisional-normative | docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md |
| CRE8-CONTRACT-REQ-0055 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-CONTRACT-FEED-CURSOR-GRAMMAR | automated | API Contracts WG | provisional-normative | docs/evidence/templates/FEED_CONTRACT_EVIDENCE_TEMPLATE.md |
| CRE8-OPS-REQ-0001 | CRE8-OPS-VERIFICATION-STRATEGY | docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md | HOOK-SSOT-REPORT-COVERAGE-COVERAGE | automated | Operations Quality WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-OPS-REQ-0005 | CRE8-OPS-VERIFICATION-STRATEGY | docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md | HOOK-SSOT-PHASE1-GATE-CI | automated | Operations Quality WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-OPS-REQ-0010 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | automated | Operations Quality WG | provisional-normative | reports/session_handoffs/LATEST_SESSION_HANDOFF.md |
| CRE8-OPS-REQ-0011 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | automated | Operations Quality WG | provisional-normative | reports/session_handoffs/LATEST_SESSION_HANDOFF.md |
| CRE8-OPS-REQ-0012 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | automated | Operations Quality WG | provisional-normative | reports/session_handoffs/LATEST_SESSION_HANDOFF.md |
| CRE8-OPS-REQ-0013 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | automated | Operations Quality WG | provisional-normative | reports/session_handoffs/PHASE2_PROGRESS_BOARD.md |
| CRE8-OPS-REQ-0002 | CRE8-OPS-VERIFICATION-STRATEGY | docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md | HOOK-SSOT-LINT-METADATA | automated | Operations Quality WG | provisional-normative | composer docs:ssot:lint |
| CRE8-OPS-REQ-0003 | CRE8-OPS-VERIFICATION-STRATEGY | docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md | HOOK-REVIEW-GATE-CHECK-AUTO | automated | Operations Quality WG | provisional-normative | composer docs:ssot:review-gate-check |
| CRE8-OPS-REQ-0004 | CRE8-OPS-VERIFICATION-STRATEGY | docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md | HOOK-SSOT-REPORT-COVERAGE-COVERAGE | automated | Operations Quality WG | provisional-normative | composer docs:ssot:report |
| CRE8-OPS-REQ-0006 | CRE8-OPS-VERIFICATION-STRATEGY | docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md | HOOK-REVIEW-GATE-CHECK-AUTO | automated | Operations Quality WG | provisional-normative | composer docs:ssot:review-gate-check |
| CRE8-OPS-REQ-0007 | CRE8-OPS-VERIFICATION-STRATEGY | docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | automated | Operations Quality WG | provisional-normative | composer phase2:acceptance-bundle |
| CRE8-OPS-REQ-0014 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | automated | Operations Quality WG | provisional-normative | .github/workflows/ssot_phase_gate.yml |
| CRE8-OPS-REQ-0015 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA | automated | Operations Quality WG | provisional-normative | docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md |
| CRE8-OPS-REQ-0016 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA | automated | Operations Quality WG | provisional-normative | scripts/docs_ssot_phase2_exceptions_check.php |
| CRE8-OPS-REQ-0020 | CRE8-OPS-PHASE2-EXCEPTIONS-REGISTER | docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md | HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA | automated | Operations Quality WG | provisional-normative | scripts/docs_ssot_phase2_exceptions_check.php |
| CRE8-OPS-REQ-0021 | CRE8-OPS-PHASE2-EXCEPTIONS-REGISTER | docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md | HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA | automated | Operations Quality WG | provisional-normative | reports/session_handoffs/PHASE2_PROGRESS_BOARD.md |
| CRE8-OPS-REQ-0022 | CRE8-OPS-PHASE2-ACCEPTANCE | docs/60_operations_quality_and_release/PHASE2_ACCEPTANCE_CRITERIA.md | HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE | automated | Operations Quality WG | provisional-normative | scripts/phase2_acceptance_bundle.php |
| CRE8-GOV-REQ-0060 | CRE8-GOV-CROSS-LINK-POLICY | docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md | HOOK-SSOT-LINK-INTEGRITY | automated | Docs Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0061 | CRE8-GOV-CROSS-LINK-POLICY | docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md | HOOK-SSOT-LINT-METADATA | automated | Docs Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0062 | CRE8-GOV-CROSS-LINK-POLICY | docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md | HOOK-SSOT-LINK-TOPOLOGY | automated | Docs Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0063 | CRE8-GOV-CROSS-LINK-POLICY | docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md | HOOK-SSOT-ANTI-ORPHAN-CHECK | automated | Docs Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0064 | CRE8-GOV-CROSS-LINK-POLICY | docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md | HOOK-SSOT-LINK-TOPOLOGY | automated | Docs Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0065 | CRE8-GOV-CROSS-LINK-POLICY | docs/00_governance/CROSS_DOCUMENT_LINKING_POLICY.md | HOOK-SSOT-SYNC-PROMOTED-TRACE | automated | Docs Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-ARCH-REQ-0001 | CRE8-ARCH-IDENTITY-FOUNDATIONS | docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md | HOOK-IDENTITY-ID-FIRST-ISSUANCE | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-ARCH-REQ-0002 | CRE8-ARCH-IDENTITY-FOUNDATIONS | docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md | HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0002 | CRE8-CONTRACTS-ERROR-CATALOG | docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md | HOOK-CONTRACT-ERROR-CODE-COVERAGE | automated | API Contracts WG | provisional-normative | composer docs:ssot:error-code-coverage |
| CRE8-CONTRACT-REQ-0003 | CRE8-CONTRACTS-ERROR-CATALOG | docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md | HOOK-AUTH-DECISION-REASON-MAPPING | automated | API Contracts WG | provisional-normative | composer test:contract:auth-reasons |
| CRE8-CONTRACT-REQ-0005 | CRE8-CONTRACTS-ERROR-CATALOG | docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md | HOOK-CONTRACT-ERROR-DETERMINISM | automated | API Contracts WG | provisional-normative | composer test:contract:error |
| CRE8-CONTRACT-REQ-0006 | CRE8-CONTRACTS-ERROR-CATALOG | docs/30_contracts_and_interfaces/ERROR_CODE_CATALOG.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | composer docs:ssot:dod-trace-check |
| CRE8-CONTRACT-REQ-0030 | CRE8-CONTRACTS-UI-RUNTIME | docs/30_contracts_and_interfaces/UI_RUNTIME_CONTRACT.md | HOOK-CONTRACT-SURFACE-PARITY | automated | API Contracts WG | provisional-normative | composer test:contract:surface-parity |
| CRE8-CONTRACT-REQ-0031 | CRE8-CONTRACTS-UI-RUNTIME | docs/30_contracts_and_interfaces/UI_RUNTIME_CONTRACT.md | HOOK-CONTRACT-SURFACE-PARITY | automated | API Contracts WG | provisional-normative | composer test:contract:surface-parity |
| CRE8-CONTRACT-REQ-0032 | CRE8-CONTRACTS-UI-RUNTIME | docs/30_contracts_and_interfaces/UI_RUNTIME_CONTRACT.md | HOOK-CONTRACT-SURFACE-PARITY | automated | API Contracts WG | provisional-normative | composer test:contract:surface-parity |
| CRE8-CONTRACT-REQ-0033 | CRE8-CONTRACTS-UI-RUNTIME | docs/30_contracts_and_interfaces/UI_RUNTIME_CONTRACT.md | HOOK-CONTRACT-ERROR-CODE-COVERAGE | automated | API Contracts WG | provisional-normative | composer docs:ssot:error-code-coverage |
| CRE8-MACHINE-REQ-0012 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0013 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0014 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0015 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0016 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/session_handoffs/PHASE2_PROGRESS_BOARD.md |
| CRE8-MACHINE-REQ-0017 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/session_handoffs/PHASE2_PROGRESS_BOARD.md |
| CRE8-MACHINE-REQ-0018 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/session_handoffs/PHASE2_PROGRESS_BOARD.md |
| CRE8-MACHINE-REQ-0019 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-CONTRACT-ROUTE-INVENTORY-PARITY | automated | API Contracts WG | provisional-normative | reports/session_handoffs/PHASE2_PROGRESS_BOARD.md |
| CRE8-FEED-REQ-0001 | CRE8-FEED-RANKING-ORDERING | docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md | HOOK-CONTRACT-POLICY-ORDER | automated | Product Policy WG | provisional-normative | composer test:contract:feed |
| CRE8-FEED-REQ-0003 | CRE8-FEED-RANKING-ORDERING | docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md | HOOK-CONTRACT-FEED-DENY-CODE-CATALOG | automated | Product Policy WG | provisional-normative | composer test:contract:feed |
| CRE8-FEED-REQ-0004 | CRE8-FEED-RANKING-ORDERING | docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md | HOOK-CONTRACT-FEED-ORDER-CURSOR | automated | Product Policy WG | provisional-normative | composer test:contract:feed |
| CRE8-FEED-REQ-0002 | CRE8-FEED-RANKING-ORDERING | docs/50_content_audience_and_feed/FEED_RANKING_AND_ORDERING_RULES.md | HOOK-CONTRACT-FEED-ORDER-CURSOR | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0017 | CRE8-FEED-INTERACTION-POLICY | docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md | HOOK-FEED-INTERACTION-DENY-MAPPING | automated | Product Policy WG | provisional-normative | composer test:contract:feed |
| CRE8-FEED-REQ-0018 | CRE8-FEED-INTERACTION-POLICY | docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md | HOOK-FEED-INTERACTION-DENY-MAPPING | automated | Product Policy WG | provisional-normative | composer test:contract:feed |
| CRE8-FEED-REQ-0020 | CRE8-FEED-INTERACTION-POLICY | docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md | HOOK-CONTRACT-FEED-METADATA-STABILITY | automated | Product Policy WG | provisional-normative | composer test:contract:feed |
| CRE8-FEED-REQ-0016 | CRE8-FEED-INTERACTION-POLICY | docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md | HOOK-CONTRACT-POLICY-ORDER | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0019 | CRE8-FEED-INTERACTION-POLICY | docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md | HOOK-CONTRACT-ERROR-CODE-COVERAGE | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0021 | CRE8-FEED-INTERACTION-POLICY | docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md | HOOK-FEED-INTERACTION-DENY-MAPPING | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0022 | CRE8-FEED-INTERACTION-POLICY | docs/50_content_audience_and_feed/COMMENTING_AND_INTERACTION_POLICY.md | HOOK-FEED-INTERACTION-DENY-MAPPING | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0006 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-SEC-LIFECYCLE-PROPAGATION | automated | Security Engineering WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-EXT-REQ-0002 | CRE8-EXT-MODULE-SEAMS | docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md | HOOK-EXT-SEAM-COMPATIBILITY | automated | Platform Architecture WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-GOV-REQ-0001 | CRE8-GOV-SSOT-INDEX | docs/00_governance/SSOT_INDEX.md | HOOK-SSOT-LINK-TOPOLOGY | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0002 | CRE8-GOV-SSOT-INDEX | docs/00_governance/SSOT_INDEX.md | HOOK-SSOT-PRECEDENCE-CHECK | manual | Docs Governance WG | normative | docs/evidence/templates/README.md |
| CRE8-GOV-REQ-0003 | CRE8-GOV-SSOT-INDEX | docs/00_governance/SSOT_INDEX.md | HOOK-SEED-PROMOTION-SCHEMA-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0004 | CRE8-GOV-SSOT-INDEX | docs/00_governance/SSOT_INDEX.md | HOOK-SSOT-PRECEDENCE-CHECK | manual | Docs Governance WG | normative | docs/evidence/templates/README.md |
| CRE8-GOV-REQ-0006 | CRE8-GOV-SSOT-INDEX | docs/00_governance/SSOT_INDEX.md | HOOK-SSOT-LINK-INTEGRITY | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0007 | CRE8-GOV-SSOT-INDEX | docs/00_governance/SSOT_INDEX.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0030 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-TRACE-ADR-INDEX-UNIQUE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0031 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-TRACE-ADR-INDEX-UNIQUE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0032 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-TRACE-ADR-INDEX-UNIQUE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0033 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-TRACE-ADR-INDEX-STATUS | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0034 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-TRACE-ADR-INDEX-UNIQUE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0035 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-TRACE-DECISION-ADR-LINK | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0036 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-TRACE-ADR-INDEX-BACKLINK | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0040 | CRE8-TRACE-DECISIONS-LOG | docs/80_traceability_decisions_and_program/DECISIONS_LOG.md | HOOK-TRACE-DECISION-APPENDONLY | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0041 | CRE8-TRACE-DECISIONS-LOG | docs/80_traceability_decisions_and_program/DECISIONS_LOG.md | HOOK-TRACE-DECISION-EVENT-TYPE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0042 | CRE8-TRACE-DECISIONS-LOG | docs/80_traceability_decisions_and_program/DECISIONS_LOG.md | HOOK-TRACE-DECISION-EVENT-TYPE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0043 | CRE8-TRACE-DECISIONS-LOG | docs/80_traceability_decisions_and_program/DECISIONS_LOG.md | HOOK-TRACE-DECISION-ADR-LINK | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0044 | CRE8-TRACE-DECISIONS-LOG | docs/80_traceability_decisions_and_program/DECISIONS_LOG.md | HOOK-TRACE-MATRIX-COVERAGE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0045 | CRE8-TRACE-DECISIONS-LOG | docs/80_traceability_decisions_and_program/DECISIONS_LOG.md | HOOK-TRACE-DECISION-EVENT-TYPE | manual | Architecture Governance WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0050 | CRE8-TRACE-RISK-REGISTER | docs/80_traceability_decisions_and_program/RISK_REGISTER.md | HOOK-TRACE-RISK-LINKAGE | manual | Security WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0051 | CRE8-TRACE-RISK-REGISTER | docs/80_traceability_decisions_and_program/RISK_REGISTER.md | HOOK-TRACE-RISK-SCORE | manual | Security WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0052 | CRE8-TRACE-RISK-REGISTER | docs/80_traceability_decisions_and_program/RISK_REGISTER.md | HOOK-TRACE-RISK-SCORE | manual | Security WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0053 | CRE8-TRACE-RISK-REGISTER | docs/80_traceability_decisions_and_program/RISK_REGISTER.md | HOOK-TRACE-RISK-HIGHCRIT-FIELDS | manual | Security WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0054 | CRE8-TRACE-RISK-REGISTER | docs/80_traceability_decisions_and_program/RISK_REGISTER.md | HOOK-TRACE-RISK-LINKAGE | manual | Security WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-TRACE-REQ-0055 | CRE8-TRACE-RISK-REGISTER | docs/80_traceability_decisions_and_program/RISK_REGISTER.md | HOOK-TRACE-DECISION-APPENDONLY | manual | Security WG | provisional-normative | docs/evidence/templates/README.md |

| CRE8-ACCEPT-REQ-0001 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Architecture Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-ACCEPT-REQ-0006 | CRE8-TRACE-ADR-INDEX | docs/80_traceability_decisions_and_program/ADR_INDEX.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Architecture Governance WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-ARCH-REQ-0003 | CRE8-ARCH-IDENTITY-FOUNDATIONS | docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-ARCH-REQ-0004 | CRE8-ARCH-IDENTITY-FOUNDATIONS | docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-ARCH-REQ-0005 | CRE8-ARCH-IDENTITY-FOUNDATIONS | docs/10_product_and_architecture/ID_UTILITY_KEYPAIR_MODEL_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0011 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0013 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0015 | CRE8-CONTRACTS-API-GUIDE | docs/30_contracts_and_interfaces/API_CONTRACT_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0021 | CRE8-CONTRACTS-ROUTE-INVENTORY | docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0022 | CRE8-CONTRACTS-ROUTE-INVENTORY | docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-CONTRACT-REQ-0024 | CRE8-CONTRACTS-ROUTE-INVENTORY | docs/30_contracts_and_interfaces/ROUTE_INVENTORY_REFERENCE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-EXT-REQ-0001 | CRE8-EXT-MODULE-SEAMS | docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-EXT-REQ-0003 | CRE8-EXT-MODULE-SEAMS | docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-EXT-REQ-0004 | CRE8-EXT-MODULE-SEAMS | docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-EXT-REQ-0005 | CRE8-EXT-MODULE-SEAMS | docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-EXT-REQ-0006 | CRE8-EXT-MODULE-SEAMS | docs/70_extensibility_and_module_patterns/MODULE_BOUNDARIES_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Platform Architecture WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0010 | CRE8-FEED-CONTENT-MODEL | docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0011 | CRE8-FEED-CONTENT-MODEL | docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0012 | CRE8-FEED-CONTENT-MODEL | docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0013 | CRE8-FEED-CONTENT-MODEL | docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0014 | CRE8-FEED-CONTENT-MODEL | docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-FEED-REQ-0015 | CRE8-FEED-CONTENT-MODEL | docs/50_content_audience_and_feed/CONTENT_MODEL_AND_TARGETING_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Product Policy WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0010 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0011 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0012 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0013 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0014 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0015 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0016 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0017 | CRE8-GOV-DOC-TEMPLATE | docs/00_governance/DOCUMENT_TEMPLATE_AND_STYLE_GUIDE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0020 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0021 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0022 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0023 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0024 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0025 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0026 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0027 | CRE8-GOV-DOC-OWNERSHIP | docs/00_governance/DOCUMENT_STATUS_AND_OWNERSHIP.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0030 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0031 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0032 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0034 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0035 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0036 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0037 | CRE8-GOV-CONTRIB-WORKFLOW | docs/00_governance/CONTRIBUTION_WORKFLOW_SSOT.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0040 | CRE8-GOV-CHANGE-CONTROL | docs/00_governance/CHANGE_CONTROL_POLICY.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0041 | CRE8-GOV-CHANGE-CONTROL | docs/00_governance/CHANGE_CONTROL_POLICY.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0042 | CRE8-GOV-CHANGE-CONTROL | docs/00_governance/CHANGE_CONTROL_POLICY.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0043 | CRE8-GOV-CHANGE-CONTROL | docs/00_governance/CHANGE_CONTROL_POLICY.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0044 | CRE8-GOV-CHANGE-CONTROL | docs/00_governance/CHANGE_CONTROL_POLICY.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0045 | CRE8-GOV-CHANGE-CONTROL | docs/00_governance/CHANGE_CONTROL_POLICY.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0046 | CRE8-GOV-CHANGE-CONTROL | docs/00_governance/CHANGE_CONTROL_POLICY.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0050 | CRE8-GOV-DEFINITION-OF-DONE | docs/00_governance/DEFINITION_OF_DONE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0051 | CRE8-GOV-DEFINITION-OF-DONE | docs/00_governance/DEFINITION_OF_DONE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0052 | CRE8-GOV-DEFINITION-OF-DONE | docs/00_governance/DEFINITION_OF_DONE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0054 | CRE8-GOV-DEFINITION-OF-DONE | docs/00_governance/DEFINITION_OF_DONE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0055 | CRE8-GOV-DEFINITION-OF-DONE | docs/00_governance/DEFINITION_OF_DONE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-GOV-REQ-0056 | CRE8-GOV-DEFINITION-OF-DONE | docs/00_governance/DEFINITION_OF_DONE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Docs Governance WG | normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0001 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0002 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0003 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0004 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0005 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0006 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0007 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0008 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0009 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0010 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-MACHINE-REQ-0011 | CRE8-MACHINE-PROSE-OPENAPI-PARITY | docs/31_machine_contracts/PROSE_OPENAPI_PARITY_TABLE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | API Contracts WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-OPS-REQ-0017 | CRE8-OPS-PHASE2-EXCEPTIONS-REGISTER | docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Operations Quality WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-OPS-REQ-0018 | CRE8-OPS-PHASE2-EXCEPTIONS-REGISTER | docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Operations Quality WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-OPS-REQ-0019 | CRE8-OPS-PHASE2-EXCEPTIONS-REGISTER | docs/60_operations_quality_and_release/PHASE2_UNRESOLVED_EXCEPTIONS_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Operations Quality WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0001 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Security Engineering WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0002 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Security Engineering WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0003 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Security Engineering WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0004 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Security Engineering WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0005 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Security Engineering WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0007 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Security Engineering WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-SEC-REQ-0008 | CRE8-SEC-KEY-LIFECYCLE | docs/40_data_security_and_crypto/KEY_LIFECYCLE_AND_CRYPTOGRAPHY_SPEC.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Security Engineering WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0010 | CRE8-TRACE-CHANGE-IMPACT-TEMPLATES | docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0011 | CRE8-TRACE-CHANGE-IMPACT-TEMPLATES | docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0012 | CRE8-TRACE-CHANGE-IMPACT-TEMPLATES | docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0013 | CRE8-TRACE-CHANGE-IMPACT-TEMPLATES | docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0014 | CRE8-TRACE-CHANGE-IMPACT-TEMPLATES | docs/80_traceability_decisions_and_program/CHANGE_IMPACT_MAP_TEMPLATES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0020 | CRE8-TRACE-DECISION-RECORD-TEMPLATE | docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0021 | CRE8-TRACE-DECISION-RECORD-TEMPLATE | docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0022 | CRE8-TRACE-DECISION-RECORD-TEMPLATE | docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0023 | CRE8-TRACE-DECISION-RECORD-TEMPLATE | docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0024 | CRE8-TRACE-DECISION-RECORD-TEMPLATE | docs/80_traceability_decisions_and_program/DECISION_RECORD_TEMPLATE.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0061 | CRE8-TRACE-ROADMAP | docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0062 | CRE8-TRACE-ROADMAP | docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0063 | CRE8-TRACE-ROADMAP | docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0064 | CRE8-TRACE-ROADMAP | docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0065 | CRE8-TRACE-ROADMAP | docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0066 | CRE8-TRACE-ROADMAP | docs/80_traceability_decisions_and_program/ROADMAP_AND_MILESTONES.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0071 | CRE8-TRACE-SEED-PROMOTION-TRACKER | docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0072 | CRE8-TRACE-SEED-PROMOTION-TRACKER | docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0073 | CRE8-TRACE-SEED-PROMOTION-TRACKER | docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0074 | CRE8-TRACE-SEED-PROMOTION-TRACKER | docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0075 | CRE8-TRACE-SEED-PROMOTION-TRACKER | docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0076 | CRE8-TRACE-SEED-PROMOTION-TRACKER | docs/80_traceability_decisions_and_program/SEED_PROMOTION_TRACKER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0081 | CRE8-TRACE-SEED-GAP-REGISTER | docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0082 | CRE8-TRACE-SEED-GAP-REGISTER | docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0083 | CRE8-TRACE-SEED-GAP-REGISTER | docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0084 | CRE8-TRACE-SEED-GAP-REGISTER | docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |
| CRE8-TRACE-REQ-0085 | CRE8-TRACE-SEED-GAP-REGISTER | docs/80_traceability_decisions_and_program/UNRESOLVED_SEED_GAP_REGISTER.md | HOOK-DOD-TRACE-CHECK-AUTO | automated | Program Traceability WG | provisional-normative | reports/ssot/coverage_latest.json |

## Verification hooks
- **HOOK-TRACE-MATRIX-SCHEMA**: Validate required columns and required non-empty values.
- **HOOK-TRACE-ID-FORMAT**: Validate `requirement_id`, ADR ID, and risk ID formats.
- **HOOK-TRACE-EVIDENCE-PATH**: Validate `evidence_location` path exists.
- **HOOK-SSOT-LINK-TOPOLOGY**: Automated validation hook for required vertical/lateral SSOT link topology invariants.
- **HOOK-SSOT-ANTI-ORPHAN-CHECK**: Automated validation hook ensuring no requirement-bearing normative/provisional docs are orphaned from governance/domain entrypoints.
- **HOOK-SSOT-PHASE1-GATE-CI**: Automated CI hook that executes all required `docs:ssot:*` commands as hard-fail checks.
- **HOOK-SSOT-SYNC-MANUAL-BACKLOG**: Automated sync-check hook ensuring every manual-mode matrix hook is represented in `PHASE1_MANUAL_HOOK_BACKLOG.md` with owner, priority, and target command metadata.
- **HOOK-CONTRACT-POLICY-ORDER**: Manual/automated contract test hook for deterministic authorization evaluation order and deny precedence.
- **HOOK-AUTH-INHERITANCE-BOUNDARY**: Manual/automated hook for descendant grant boundary constraints.
- **HOOK-AUTH-LIFECYCLE-ENFORCEMENT**: Manual/automated hook for suspend/revoke/expire enforcement.
- **HOOK-AUTH-DECISION-REASON-MAPPING**: Manual/automated hook for one-to-one mapping from authorization decision reasons to API error codes.
- **HOOK-CONTRACT-ERROR-DETERMINISM**: Manual/automated hook for error envelope stability and deterministic code mapping.
- **HOOK-CONTRACT-ERROR-SECRETS-REDACTION**: Manual/automated hook ensuring secrets are never exposed in error payloads.
- **HOOK-CONTRACT-ROUTE-INVENTORY-PARITY**: Manual/automated hook for route inventory method/path parity with OpenAPI.
- **HOOK-CONTRACT-ERROR-CODE-COVERAGE**: Manual/automated hook verifying route-declared error codes exist in the error catalog.
- **HOOK-CONTRACT-COMPAT-DECLARATION**: Manual/automated hook validating compatibility/migration declaration sections for contract changes.
- **HOOK-CONTRACT-ROUTE-UNIQUENESS**: Manual/automated hook ensuring unique route identifiers and method/path pairs.
- **HOOK-CONTRACT-DEPRECATION-SCHEMA**: Manual/automated hook validating sunset and replacement fields for deprecated routes.
- **HOOK-CONTRACT-FEED-METADATA-STABILITY**: Automated hook validating feed metadata fields/enums and schema-version marker remain contract-stable.
- **HOOK-CONTRACT-FEED-ORDER-CURSOR**: Automated hook validating feed fixture ordering invariants and cursor-to-last-item determinism.
- **HOOK-CONTRACT-FEED-DENY-CODE-CATALOG**: Automated hook validating feed deny examples resolve only to canonical error catalog codes, including lifecycle deny coverage.
- **HOOK-CONTRACT-FEED-CURSOR-MULTIPAGE-MONOTONIC**: Automated hook validating strict cursor monotonic progression across sequential feed page fixtures.
- **HOOK-CONTRACT-FEED-CURSOR-GRAMMAR**: Automated hook validating feed cursor grammar (`pub:<ISO8601 UTC>|<item_id>`) plus executable cross-page cursor linkage checks.
- **HOOK-IDENTITY-ID-FIRST-ISSUANCE**: Automated contract hook (`composer test:contract:identity-issuance`) validating that ID keypair issuance precedes all utility-key issuance.
- **HOOK-IDENTITY-UTILITY-CONTEXT-ISOLATION**: Automated contract hook (`composer test:contract:identity-context`) validating utility-key context isolation and no cross-context reuse.
- **HOOK-CONTRACT-SURFACE-PARITY**: Automated hook validating supported UI capabilities map to canonical API route contracts or approved exceptions via `composer test:contract:surface-parity`.
- **HOOK-FEED-AUTH-ORDER**: Manual/automated hook validating authorized-only feed inclusion and deterministic newest-first ordering semantics.
- **HOOK-FEED-INTERACTION-DENY-MAPPING**: Manual/automated hook validating one-to-one interaction deny-condition to canonical error-code mapping.
- **HOOK-SEC-LIFECYCLE-PROPAGATION**: Manual/automated hook validating immediate revoke/rotate propagation across direct and descendant credentials.
- **HOOK-EXT-SEAM-COMPATIBILITY**: Manual/automated hook validating module seam compatibility, PDP-chain preservation, and envelope stability.
- **HOOK-SSOT-PHASE2-ACCEPTANCE-BUNDLE**: Automated acceptance hook running the full Phase 2 command bundle with hard-fail semantics on first-class SSOT and contract tests.
- **HOOK-SSOT-PHASE2-EXCEPTION-REGISTER-SCHEMA**: Automated hook validating unresolved-exceptions register schema, decision linkage, closed-row progress-board synchronization, and command obligations for open/blocked rows.

## Drift and reconciliation policy
- Prose requirement updates without matrix updates are classified as drift and **MUST** fail definition-of-done review.
- Machine contracts added in `docs/31_machine_contracts/` **SHOULD** be represented as either source rows or verification-linked rows when they enforce normative requirements.

## See also
- [SSOT Index](../00_governance/SSOT_INDEX.md)
- [Change Control Policy](../00_governance/CHANGE_CONTROL_POLICY.md)
- [Definition of Done](../00_governance/DEFINITION_OF_DONE.md)
- [Change Impact Map Templates](./CHANGE_IMPACT_MAP_TEMPLATES.md)
- [ADR Index](./ADR_INDEX.md)
- [Risk Register](./RISK_REGISTER.md)
- [SSOT Automation and Linting](./SSOT_AUTOMATION_AND_LINTING.md)

| CRE8-AUTH-REQ-0003 | CRE8-AUTH-DELEGATION-SPEC | docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md | HOOK-CONTRACT-POLICY-ORDER | automated | Identity & Policy WG | provisional-normative | composer test:contract:auth |
| CRE8-AUTH-REQ-0004 | CRE8-AUTH-DELEGATION-SPEC | docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md | HOOK-AUTH-DECISION-REASON-MAPPING | automated | Identity & Policy WG | provisional-normative | composer test:contract:auth-reasons |
| CRE8-AUTH-REQ-0005 | CRE8-AUTH-DELEGATION-SPEC | docs/20_identity_delegation_and_policy/AUTHORIZATION_AND_DELEGATION_SPEC.md | HOOK-AUTH-INHERITANCE-BOUNDARY | manual | Identity & Policy WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-AUTH-REQ-0011 | CRE8-AUTH-DECISION-TABLES | docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md | HOOK-CONTRACT-POLICY-ORDER | automated | Identity & Policy WG | provisional-normative | composer test:contract:auth |
| CRE8-AUTH-REQ-0012 | CRE8-AUTH-DECISION-TABLES | docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md | HOOK-AUTH-INHERITANCE-BOUNDARY | manual | Identity & Policy WG | provisional-normative | docs/evidence/templates/README.md |
| CRE8-AUTH-REQ-0013 | CRE8-AUTH-DECISION-TABLES | docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md | HOOK-AUTH-DECISION-REASON-MAPPING | automated | Identity & Policy WG | provisional-normative | composer test:contract:auth-reasons |
| CRE8-AUTH-REQ-0014 | CRE8-AUTH-DECISION-TABLES | docs/20_identity_delegation_and_policy/AUTHORIZATION_DECISION_TABLES.md | HOOK-AUTH-DECISION-REASON-MAPPING | automated | Identity & Policy WG | provisional-normative | composer test:contract:auth-reasons |
