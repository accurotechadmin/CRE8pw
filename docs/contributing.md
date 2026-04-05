# Contributing Guide

_Last updated (UTC): 2026-04-05_

## Working model for this repository

1. Implement behavior changes in source (`src/*`, `public/ui/*`).
2. Add/adjust tests in `tests/Contract` and/or `tests/Security`.
3. Update docs in `/docs` to match shipped behavior.
4. Run applicable checks (`composer test`, targeted phpunit, lint/syntax checks).

## Code organization expectations

- Backend business behavior belongs in `src/Application/*` services.
- Cross-cutting transport/security behavior belongs in middleware.
- Route handlers should orchestrate, validate quick input constraints, and delegate service logic.
- Envelope and request-id behavior must remain consistent across endpoints.

## Documentation expectations

- Keep docs authoritative and aligned with current code.
- Avoid speculative wording for current behavior.
- Record future work only in roadmap or dev artifacts.
