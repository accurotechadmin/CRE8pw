# Configuration Environment Contract

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Define required env vars, safety constraints, and profile-specific policy checks.

## Scope
Startup configuration consumed by `public/index.php` and runtime config/boot checks.

## Normative statements
- Required env vars MUST be present for boot.
- Stage/prod profiles MUST enforce stricter issuer/transport safety constraints.
- Relative JWT key paths MAY be normalized to absolute paths at startup.

## Interfaces / contracts
- Required keys include DB, JWT issuer/audiences/keys, CORS, CSRF secret, rate-limit settings, token TTLs.
- Loader path: `loadRuntimeEnv()` + `RuntimeConfig::fromEnv()`.

## Failure/rejection semantics
- Missing required env var MUST result in startup failure.
- Unsafe profile configuration SHOULD be rejected before app run.

## Verification requirements
- Boot checks and runtime config contract tests.
- Environment validation in CI and deployment pipeline.

## Traceability hooks
- Code refs: `public/index.php`, `src/Config/RuntimeConfig.php`, `src/Bootstrap/BootChecks.php`
- Tests refs: `tests/Contract/RuntimeConfigPoliciesContractTest.php`, `tests/Contract/PublicIndexBootstrapContractTest.php`
- Related SSOT docs: `BOOT_AND_STARTUP_FAILURE_CONTRACT.md`, `HEALTH_ENDPOINT_CONTRACT.md`

## Open questions / known gaps
- Formal env var registry artifact (machine-readable) has not been created yet.

## Session progress (2026-04-08)
### Completed in this session
- Kept operations/quality documents structured for executable release governance.
- Preserved sections for verification evidence, startup behavior, health semantics, and release controls.
- Prepared docs for measurable SLO/SLI and acceptance-criteria expansion.
### Remaining to finish this document
- [ ] Set numeric thresholds for SLO/SLI and go/no-go gates.
- [ ] Add concrete smoke commands, expected outputs, and evidence artifact paths.
- [ ] Complete Given/When/Then acceptance criteria per critical route family.

