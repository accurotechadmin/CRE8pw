# ADR-010: Activation Governance and Staged PDP Enforcement Cutover

_Status: adopted_
_Last updated (UTC): 2026-04-28_

## Context
Architecture-upgrade implementation slices for PDP/BFF/CQRS are complete in SSOT and traceability. Activation slices require deterministic staged rollout controls that preserve canonical envelope/error/detail-code semantics, non-interchangeable gateway and console auth contexts, and release-blocking mismatch governance.

## Decision
1. PDP activation in staging executes in two mandatory phases:
   - **ACT-01**: all gateway and console read-route families run with PDP comparison telemetry active; mismatch deltas are triaged and resolved before write-route enforcement expansion.
   - **ACT-02**: all gateway write-route and console governance-route families run with PDP enforcement-authoritative routing; release progression requires full contract and security regression pass with zero unresolved policy mismatches.
2. Activation evidence is mandatory and release-blocking:
   - mismatch log artifact with route-action, principal class, canonical expected decision, observed decision, and final disposition;
   - verification output for `composer test:contract` and `composer test:security` under staging activation profile;
   - smoke output for boundary checks and deterministic deny detail-code parity.
3. Gateway and console auth contexts remain strictly non-interchangeable throughout activation phases. Any successful cross-surface replay or token confusion path blocks rollout and triggers immediate rollback.
4. Flag state transitions for activation phases are controlled through the configuration contract and readiness-gate evidence pack. Stage advancement requires explicit owner approval recorded in session logs and progress ledger artifacts.

## Consequences
- Activation is deterministic, auditable, and reversible.
- PDP rollout advances only when canonical decision-table parity is preserved.
- Contract and security suites become explicit go/no-go controls for cutover progression.

## Verification implications
- Verification strategy includes mandatory ACT-01 comparison telemetry and ACT-02 enforcement pass requirements.
- Traceability matrix includes ACT capability rows linking activation controls to contracts, operations, and governance artifacts.
- Production readiness gate evidence must include activation mismatch disposition and rollback-readiness proof.
