# CRE8 M4 Detailed Daily Slices (Day 70–90)

_Status: draft implementation planning artifact_
_Last updated (UTC): 2026-04-12_

## Scope
This document expands Milestone M4 (**UI parity hardening + observability/SLO + smoke/rehearsals + release gates and final handoff**) into explicit daily slices and handoff expectations for Days 70–90.

## M4 outcome target
By end of Day 90, CRE8 has:
1. full UI parity with declared backend contract and error-state behavior,
2. observability and SLO/SLI instrumentation with ownership and alert routing,
3. deterministic smoke/rehearsal evidence for health, migration, rollback, and key rotation,
4. readiness-gate A/B/C/D passage with release evidence complete,
5. final production handoff package with traceability and governance closure.

## Daily detailed slices and handoff contract

| Day | Governance slices | Backend/ops slices | Security/reliability slices | Frontend/QA slices | End-of-day done criteria | Handoff artifacts |
|---:|---|---|---|---|---|---|
| 70 | Confirm M4 parity acceptance matrix and reviewer assignments. | Stabilize gateway-facing response contracts for UI parity pass. | Validate that hardened middleware/error behavior remains unchanged from M3 baseline. | Implement/verify gateway UI parity for feed/posts/comments route-state coverage. | Gateway UI parity baseline is established with known gaps tracked. | UI-gateway parity report + gap log. |
| 71 | Confirm console parity acceptance matrix and owner signoff checkpoints. | Stabilize console API behavior for posts/moderation/invites/key ops for parity tests. | Verify CSRF/auth guard behavior is visible and diagnosable in UI flows. | Implement/verify console UI parity for posts/moderation/invites/key actions. | Console parity baseline is established with deterministic UX outcomes. | UI-console parity report + diagnostics captures. |
| 72 | Confirm keychain UX parity requirements and evidence fields. | Stabilize keychain API payloads for list/mutate/resolve use cases. | Re-check keychain policy invariants under UI-driven mutation sequences. | Implement/verify keychain management UI parity (create/add/remove/resolve). | Keychain UI parity is complete for declared v1 workflows. | Keychain UI parity checklist + test output. |
| 73 | Approve full error-UX acceptance criteria mapping table. | Ensure backend detail-code consistency for 401/403/404/422/429/500 paths. | Validate request_id preservation across all error paths. | Implement/verify UI error-state hardening and diagnostics panel completeness. | Error UX contract is complete and support-ready. | Error UX acceptance report + request_id evidence. |
| 74 | Confirm observability event ownership map and escalation contacts. | Finalize event emission coverage for all route families and lifecycle actions. | Validate event redaction and correlation field presence. | Add verification views/tests that correlate UI diagnostics to event traces. | Event coverage is complete and traceable across surfaces. | Event coverage matrix + sample trace bundle. |
| 75 | Confirm SLI metric ownership and dashboard handoff recipients. | Wire/verify metrics for availability, auth latency, feed latency, health reliability, error-budget signals. | Validate metric dimensions include surface/route/status classes as required. | Add QA checks that tie UI-visible failures to metric/trace evidence. | SLI metrics are emitted and verifiably queryable. | Metrics validation report + dashboard snapshots. |
| 76 | Confirm alert thresholds/escalation policy readiness for release. | Configure and validate alert routing tied to SLO/SLI ownership matrix. | Validate high-noise controls and actionable alert payload design. | Execute alert simulation scenarios and verify triage usability. | Alerting is actionable and routed to correct owners. | Alert simulation records + routing proof. |
| 77 | Lock performance hardening targets for pre-release cycle. | Optimize high-impact backend paths for auth/feed p95 targets. | Validate no policy/security regressions introduced by performance tuning. | Run UI-perceived latency checks aligned with backend benchmarks. | Performance tuning closes major p95 gaps with no contract regressions. | Benchmark delta report + regression checks. |
| 78 | Confirm health failure-injection plan and signoff protocol. | Harden `/health` probe behavior and degraded-state reporting details. | Execute dependency failure-injection scenarios (`db`, limiter, key material, http dep). | Verify UI/operator diagnostics remain clear under degraded states. | Health semantics are resilient and diagnosable under fault injection. | Failure-injection report + health contract evidence. |
| 79 | Confirm smoke automation ownership and CI policy integration. | Finalize `ops:health-smoke` command behavior and CI integration. | Validate smoke command fails closed on contract violations. | Add smoke result visibility in QA/release dashboards. | Health smoke automation is deterministic and release-gated. | CI artifact for health smoke + policy checks. |
| 80 | Confirm migration smoke governance and rollback dependencies. | Finalize `ops:migrate-smoke` command behavior and CI integration. | Validate migration smoke catches unsafe schema/seed states. | Add migration smoke status visibility for release checklist reviewers. | Migration smoke automation is deterministic and release-gated. | CI artifact for migrate smoke + verification logs. |
| 81 | Confirm boot evidence retention policy and review owners. | Harden startup evidence generation (`BOOT_EVIDENCE_PATH`) and archival format. | Validate startup-failure envelope safety and request_id consistency. | Add QA checks consuming startup evidence for operational signoff. | Boot evidence is consistently generated and reviewable. | Startup evidence samples + retention checklist. |
| 82 | Confirm key rotation rehearsal script and signoff stakeholders. | Execute key rotation rehearsal including JWKS overlap behavior validation. | Verify token verification continuity during overlap window. | Validate UI/client behavior during and after key rotation event. | Key rotation is operationally proven with no auth breakage. | Rotation rehearsal dossier + JWKS continuity evidence. |
| 83 | Confirm rollback rehearsal scenario matrix and acceptance criteria. | Execute rollback drill for app + data restoration strategy. | Validate security/policy invariants after rollback restore. | Validate UI parity and diagnostics post-rollback state. | Rollback is proven feasible and integrity-preserving. | Rollback rehearsal dossier + restore checks. |
| 84 | Confirm full-suite execution plan for pre-gate quality pass. | Run complete contract/security/abuse/integration suites. | Ensure abuse-case matrix is fully green and current. | Execute frontend parity regression suite and capture diffs. | Full pre-gate quality run is green or bounded with owners/ETAs. | Full-suite execution report + issue ledger. |
| 85 | Confirm acceptance matrix signoff ceremony and reviewer quorum. | Verify backend behavior against route-level acceptance criteria matrix. | Validate auth decision-table and error-catalog conformance remains intact. | Execute manual + automated UAT walkthrough with request_id capture on failures. | Acceptance criteria matrix signoff completed. | Acceptance signoff package + failure triage notes. |
| 86 | Confirm traceability closeout responsibilities by domain owner. | Update traceability matrix to final implementation state for v1 scope. | Verify all security/ops controls map to tests and evidence artifacts. | Validate UI capability mappings are complete and accurate. | Traceability is complete, current, and reviewer-approved. | Traceability final diff + ownership signoffs. |
| 87 | Confirm governance closeout checklist for ADR/risk/gaps updates. | Finalize decision log/ADR updates driven by implementation realities. | Re-score risk register and close/open gaps with explicit owners. | Ensure frontend-related risks and mitigations are explicitly represented. | Governance artifacts reflect final pre-release reality. | ADR/risk/gap closeout bundle. |
| 88 | Confirm release evidence assembly ownership and timelines. | Assemble release checklist + evidence template with all required command outputs. | Validate gate evidence includes security, smoke, rehearsal, and observability proofs. | Validate UI parity evidence is attached and reviewable. | Release evidence package draft is complete for gate review. | Draft release evidence package. |
| 89 | Confirm gate review panel and remediation authority chain. | Execute formal readiness gate A/B/C/D review and remediate any final blockers. | Validate unresolved security/ops blockers are either closed or release-blocking. | Run final UI regression sanity and capture release candidate evidence. | All readiness gates pass or release is correctly blocked with explicit reasons. | Gate review report + remediation closure log. |
| 90 | Conduct final milestone acceptance and operational handoff ceremony. | Tag release candidate baseline and finalize handoff documentation set. | Validate post-handoff ownership and incident escalation paths are active. | Complete final UX/operator walkthrough and support-readiness checklist. | M4 is accepted and CRE8 is fully handed off with operational integrity evidence. | Final handoff dossier (release evidence, runbooks, signoffs). |

## M4 mandatory daily evidence checklist
Every day (70–90) must attach:
1. route/ops/security/frontend verification output for the day’s slice,
2. traceability update (or explicit no-change statement),
3. risk/gap update note (or explicit no-change statement),
4. reviewer acknowledgment.

## M4 release-completion criteria
Release/handoff cannot complete unless all are true:
- UI parity is verified across gateway, console, keychain, and error-state flows,
- SLO/SLI metrics + alerts are active and owner-routed,
- smoke commands and rehearsals (health, migration, key rotation, rollback) are evidenced,
- readiness gates A/B/C/D pass with complete release checklist,
- final handoff dossier is complete and approved.
