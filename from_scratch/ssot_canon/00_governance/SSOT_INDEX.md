# Ssot Index

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Purpose
This document is finalized for the from-scratch SSOT canon and defines stable guidance for product, platform, and delivery teams.

## Scope
- Applies to all runtime surfaces under `public/`, `src/`, `code/src/`, and contract assets under `from_scratch/ssot_canon/`.
- Aligns with canonical references in `docs/SSOT/` and test coverage in `tests/` and `code/tests/`.

## Normative content
- Requirements in this document are treated as binding for architecture, contracts, operations, and release controls.
- Any change to normative behavior must be updated in this file and matching machine artifacts in the same pull request.
- Cross references must remain synchronized with route contracts, security controls, and verification strategy documents.

## Implementation references
- Runtime bootstrap and composition: `src/Bootstrap/*`, `code/src/Kernel/Bootstrap/*`.
- HTTP contracts and middleware: `src/Http/*`, `code/src/Modules/*/Interface/*`.
- Security and token flows: `src/Security/*`, `tests/Security/*`, `code/tests/Security/*`.

## Verification
- Contract checks: `composer test:contract` and `code/tests/Contract/*`.
- Security checks: `composer test:security` and `tests/Security/*`.
- Operational checks: `scripts/health_smoke.php`, `scripts/migrate_smoke.php`.

## Change control
- Owner: CRE8 platform maintainers.
- Reviewer set: architecture, security, and operations maintainers.
- Update cadence: every feature release and every material dependency change.

## Canon reading order
1. 00 governance
2. 10 product and architecture
3. 20 contracts
4. 30 data and security
5. 40 operations and quality
6. 50 traceability and automation
7. 60 decisions
8. 70 implementation guidance
9. 80 program management
