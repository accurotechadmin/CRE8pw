# Security Threat Model

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Document principal threat scenarios, attack paths, and mitigations for CRE8 surfaces.

## Scope
STRIDE-style threats across auth, gateway, console, data, and operations.

## Normative statements
- Threat model MUST identify highest-risk abuse paths for each surface.
- Mitigations MUST map to concrete controls/tests.
- New high-risk feature work SHOULD include threat model deltas.

## Interfaces / contracts
- Top draft threats: token replay, key misuse escalation, CSRF on console writes, route/middleware misconfiguration, key material leakage.
- Mitigation references to security controls and abuse-case tests.

## Failure/rejection semantics
- Unmitigated critical threat with no accepted exception MUST block release.
- Threat entries without verification mapping are incomplete.

## Verification requirements
- Review threat model per release and after incidents.
- Ensure abuse-case suite includes each critical threat scenario.

## Traceability hooks
- Code refs: `src/Security/*`, `src/Http/Middleware/*`
- Tests refs: `tests/Security/*`
- Related SSOT docs: `SECURITY_CONTROLS_SPEC.md`, `SECURITY_VERIFICATION_ABUSE_CASES.md`

## Open questions / known gaps
- Needs explicit risk ratings and owner assignments per threat.
