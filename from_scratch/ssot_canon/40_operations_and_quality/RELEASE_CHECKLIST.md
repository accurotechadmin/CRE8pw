# Release Checklist

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Provide concrete pre-release, go-live, and post-release execution checklist.

## Scope
Operational release process for CRE8 backend runtime.

## Normative statements
- Checklist completion MUST be required for production deployment.
- SSOT-impacting changes MUST confirm canon updates are included.
- Post-release review SHOULD capture incidents/noise and feed known gaps.

## Interfaces / contracts
- Pre-release: dependency/config/test/smoke/docs sync.
- Go-live: startup health, auth flow smoke, observability checks.
- Post-release: dashboard/error-budget review and canon updates.

## Failure/rejection semantics
- Unchecked mandatory checklist items MUST block release.
- Missing post-release retrospective entry SHOULD trigger follow-up task.

## Verification requirements
- Checklist artifacts stored with release notes/tickets.

## Traceability hooks
- Code refs: `composer.json`, `public/index.php`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php`
- Related SSOT docs: `PRODUCTION_READINESS_GATES.md`, `OPERATIONAL_SMOKE_CHECK_CONTRACT.md`

## Open questions / known gaps
- Release artifact repository and template location still TBD.
