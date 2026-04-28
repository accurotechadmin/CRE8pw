# CRE8 Slice Progress Ledger

_Status: active_
_Last updated (UTC): 2026-04-28_

| Slice ID | Status | Completion date (UTC) | PR/Commit reference | Notes/Evidence links |
|---|---|---|---|---|
| U0-01 | completed | 2026-04-28 | work@2026-04-28-u0-governance-backlog-structure | Governance approval record published; see `ARCHITECTURE_UPGRADE_GOVERNANCE_APPROVAL_RECORD.md` and `SESSION_LOG_2026-04-28_u0-governance-backlog-structure.md` |
| U0-02 | completed | 2026-04-28 | work@2026-04-28-u0-governance-backlog-structure | Epic/backlog structure published; see `ARCHITECTURE_UPGRADE_EPIC_BACKLOG.md` and `SESSION_LOG_2026-04-28_u0-governance-backlog-structure.md` |
| U0-03 | completed | 2026-04-28 | work@2026-04-28-u0-risk-config-ci | Added R-008/R-009/R-010 in `RISK_REGISTER.md`; see session log `SESSION_LOG_2026-04-28_u0-risk-config-ci.md` |
| U0-04 | completed | 2026-04-28 | work@2026-04-28-u0-governance-backlog-structure | Repository structure scaffold created under `src/`, `config/`, `database/`, and `tests/`; see `SESSION_LOG_2026-04-28_u0-governance-backlog-structure.md` |
| U0-05 | completed | 2026-04-28 | work@2026-04-28-u0-risk-config-ci | Added `ARCH_*` feature-flag contract in `CONFIGURATION_ENVIRONMENT_CONTRACT.md`; see session log `SESSION_LOG_2026-04-28_u0-risk-config-ci.md` |
| U0-06 | completed | 2026-04-28 | work@2026-04-28-u0-risk-config-ci | Added baseline CI gate requirements in `VERIFICATION_STRATEGY.md` and contribution workflow; see session log `SESSION_LOG_2026-04-28_u0-risk-config-ci.md` |
| U0-07 | completed | 2026-04-28 | work@2026-04-28-u0-boundary-checklist | Auth-context non-interchangeability smoke contract/evidence requirements synchronized; see `SESSION_LOG_2026-04-28_u0-boundary-checklist.md` |
| U0-08 | completed | 2026-04-28 | work@2026-04-28-u0-boundary-checklist | Architecture-upgrade PR checklist published and linked in workflow/templates; see `SESSION_LOG_2026-04-28_u0-boundary-checklist.md` |
| UA-01 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-primitives-context | Canonical PDP primitive contract synchronized across authorization specs, decision tables, verification strategy, and ADR-006; see `SESSION_LOG_2026-04-28_ua-pdp-primitives-context.md` |
| UA-02 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-primitives-context | Route-action resolver + metadata policy context plumbing adopted in auth and middleware contracts; see `SESSION_LOG_2026-04-28_ua-pdp-primitives-context.md` |
| UA-03 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-primitives-context | Owner-context normalization contract and test obligations adopted; see `SESSION_LOG_2026-04-28_ua-pdp-primitives-context.md` |
| UA-04 | completed | 2026-04-28 | work@2026-04-28-ua-key-context-pdp-owner-rules | Key-context builder contract adopted for gateway claim normalization + fail-closed evaluation; see `SESSION_LOG_2026-04-28_ua-key-context-pdp-owner-rules.md` |
| UA-05 | completed | 2026-04-28 | work@2026-04-28-ua-key-context-pdp-owner-rules | `PdpService` + `RuleRegistry` deterministic invocation contract synchronized across SSOT artifacts; see `SESSION_LOG_2026-04-28_ua-key-context-pdp-owner-rules.md` |
| UA-06 | completed | 2026-04-28 | work@2026-04-28-ua-key-context-pdp-owner-rules | Owner-only console governance rule pack and canonical deny mappings adopted; see `SESSION_LOG_2026-04-28_ua-key-context-pdp-owner-rules.md` |
| UA-07 | completed | 2026-04-28 | work@2026-04-28-ua-gateway-delegation-use-rules | Gateway route-action permission rule pack synchronized across authorization spec, decision tables, verification strategy, and traceability matrix; see `SESSION_LOG_2026-04-28_ua-gateway-delegation-use-rules.md` |
| UA-08 | completed | 2026-04-28 | work@2026-04-28-ua-gateway-delegation-use-rules | Delegation subset/depth/expiry rule family synchronized with deterministic deny mappings and verification obligations; see `SESSION_LOG_2026-04-28_ua-gateway-delegation-use-rules.md` |
| UA-09 | completed | 2026-04-28 | work@2026-04-28-ua-gateway-delegation-use-rules | Use-key mutation restriction rule family synchronized with canonical policy deny detail-codes and traceability coverage; see `SESSION_LOG_2026-04-28_ua-gateway-delegation-use-rules.md` |
| UA-10 | completed | 2026-04-28 | work@2026-04-28-ua-keychain-master-device-rules | Keychain membership invariant PDP rule family synchronized with canonical deny mappings and verification obligations; see `SESSION_LOG_2026-04-28_ua-keychain-master-device-rules.md` |
| UA-11 | completed | 2026-04-28 | work@2026-04-28-ua-keychain-master-device-rules | Master-key SYSADMIN boundary rule family synchronized across authorization, master-key, error-catalog, and traceability artifacts; see `SESSION_LOG_2026-04-28_ua-keychain-master-device-rules.md` |
| UA-12 | completed | 2026-04-28 | work@2026-04-28-ua-keychain-master-device-rules | Device-binding PDP deny outcomes synchronized including missing-claim/mismatch mapping and verification coverage; see `SESSION_LOG_2026-04-28_ua-keychain-master-device-rules.md` |
| UA-13 | completed | 2026-04-28 | work@2026-04-28-ua-policy-config-registry | Policy table externalization contract synchronized for route-action/permission/detail-code maps; see `SESSION_LOG_2026-04-28_ua-policy-config-registry.md` |
| UA-14 | completed | 2026-04-28 | work@2026-04-28-ua-policy-config-registry | Route-action + permissions config integrity and fail-closed startup requirements synchronized; see `SESSION_LOG_2026-04-28_ua-policy-config-registry.md` |
| UA-15 | completed | 2026-04-28 | work@2026-04-28-ua-policy-config-registry | Deterministic rule-pack composition/loading controls synchronized with verification and traceability updates; see `SESSION_LOG_2026-04-28_ua-policy-config-registry.md` |
| UA-16 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-enforcement-routes | Gateway read-route PDP enforcement contract synchronized across authorization, middleware, verification, and traceability artifacts; see `SESSION_LOG_2026-04-28_ua-pdp-enforcement-routes.md` |
| UA-17 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-enforcement-routes | Gateway write-route PDP enforcement contract synchronized with canonical deny short-circuit/detail-code stability requirements; see `SESSION_LOG_2026-04-28_ua-pdp-enforcement-routes.md` |
| UA-18 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-enforcement-routes | Console governance-route PDP enforcement contract synchronized with owner-context and CSRF obligation gating requirements; see `SESSION_LOG_2026-04-28_ua-pdp-enforcement-routes.md` |
| UA-19 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-canonicalization-closure | Removed handler-level ad-hoc authorization from canonical contract model; added explicit no-ad-hoc-auth audit obligations and traceability linkage; see `SESSION_LOG_2026-04-28_ua-pdp-canonicalization-closure.md` |
| UA-20 | completed | 2026-04-28 | work@2026-04-28-ua-pdp-canonicalization-closure | Final SSOT sync package completed across authorization spec/tables, pipeline, error catalog, traceability, and ADR-007/decisions log; see `SESSION_LOG_2026-04-28_ua-pdp-canonicalization-closure.md` |
| UB-01 | not_started |  |  |  |
| UB-02 | not_started |  |  |  |
| UB-03 | not_started |  |  |  |
| UB-04 | not_started |  |  |  |
| UB-05 | not_started |  |  |  |
| UB-06 | not_started |  |  |  |
| UB-07 | not_started |  |  |  |
| UB-08 | not_started |  |  |  |
| UB-09 | not_started |  |  |  |
| UB-10 | not_started |  |  |  |
| UB-11 | not_started |  |  |  |
| UB-12 | not_started |  |  |  |
| UB-13 | not_started |  |  |  |
| UB-14 | not_started |  |  |  |
| UB-15 | not_started |  |  |  |
| UB-16 | not_started |  |  |  |
| UB-17 | not_started |  |  |  |
| UB-18 | not_started |  |  |  |
| UC-01 | not_started |  |  |  |
| UC-02 | not_started |  |  |  |
| UC-03 | not_started |  |  |  |
| UC-04 | not_started |  |  |  |
| UC-05 | not_started |  |  |  |
| UC-06 | not_started |  |  |  |
| UC-07 | not_started |  |  |  |
| UC-08 | not_started |  |  |  |
| UC-09 | not_started |  |  |  |
| UC-10 | not_started |  |  |  |
| UC-11 | not_started |  |  |  |
| UC-12 | not_started |  |  |  |
| UC-13 | not_started |  |  |  |
| UC-14 | not_started |  |  |  |
| UC-15 | not_started |  |  |  |
| UC-16 | not_started |  |  |  |
| UC-17 | not_started |  |  |  |
| UC-18 | not_started |  |  |  |
| UC-19 | not_started |  |  |  |
| UC-20 | not_started |  |  |  |
| UC-21 | not_started |  |  |  |
| UX-01 | not_started |  |  |  |
| UX-02 | not_started |  |  |  |
| SEC-01 | not_started |  |  |  |
| SEC-02 | not_started |  |  |  |
| OPS-01 | not_started |  |  |  |
| OPS-02 | not_started |  |  |  |
| GOV-01 | not_started |  |  |  |
| GOV-02 | not_started |  |  |  |
| ACT-01 | not_started |  |  |  |
| ACT-02 | not_started |  |  |  |
| ACT-03 | not_started |  |  |  |
| ACT-04 | not_started |  |  |  |
| ACT-05 | not_started |  |  |  |
| ACT-06 | not_started |  |  |  |
| ACT-07 | not_started |  |  |  |
