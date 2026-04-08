# Boot and Startup Failure Contract

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Specify deterministic startup sequence and failure envelope semantics.

## Scope
Boot path from dotenv load through app creation and failure response handling.

## Normative statements
- Startup MUST execute env load, config parse, container build, and boot assertions before run.
- Startup failures MUST return `500` with `boot_failed` code and `X-Request-Id`.
- Failures SHOULD emit structured log events with error class/message.

## Interfaces / contracts
- Entry point: `public/index.php`.
- Boot checks: dependency presence, key safety, middleware-order validation.

## Failure/rejection semantics
- Partial startup with unresolved boot check failure MUST not serve requests.
- Missing startup failure correlation ID is contract violation.

## Verification requirements
- Bootstrap contract tests + manual smoke of failing startup scenario.

## Traceability hooks
- Code refs: `public/index.php`, `src/Bootstrap/BootChecks.php`
- Tests refs: `tests/Contract/PublicIndexBootstrapContractTest.php`, `tests/Contract/BootChecksContractTest.php`
- Related SSOT docs: `CONFIGURATION_ENVIRONMENT_CONTRACT.md`, `HEALTH_ENDPOINT_CONTRACT.md`

## Open questions / known gaps
- No scripted chaos boot-failure rehearsal is defined yet.
