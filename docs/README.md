# CRE8 Documentation Set

This folder is the canonical documentation home for the CRE8 platform.

## Reading order (recommended)

1. [`inventory_anatomy.md`](./inventory_anatomy.md) ← **first document**
2. [`architecture_overview.md`](./architecture_overview.md)
3. [`request_lifecycle.md`](./request_lifecycle.md)
4. [`api_reference_stub.md`](./api_reference_stub.md)
5. [`data_model_stub.md`](./data_model_stub.md)
6. [`security_model.md`](./security_model.md)
7. [`configuration_reference.md`](./configuration_reference.md)
8. [`frontend_spa_guide.md`](./frontend_spa_guide.md)
9. [`testing_strategy.md`](./testing_strategy.md)
10. [`observability_runbook.md`](./observability_runbook.md)
11. [`deployment_operations.md`](./deployment_operations.md)
12. [`contributing.md`](./contributing.md)
13. [`glossary.md`](./glossary.md)
14. [`roadmap_backlog.md`](./roadmap_backlog.md)

## Existing internal session docs

Operational/session history remains in `docs/dev/`:

- `docs/dev/IMPLEMENTATION_STATUS.md`
- `docs/dev/QA_MATRIX.md`
- `docs/dev/SESSION_LEDGER.md`
- `docs/dev/DECISIONS.md`

## Documentation standards

- Keep endpoint and policy facts synchronized with code and tests.
- Prefer linking to source files instead of duplicating code blocks.
- Add a “Last updated (UTC)” line whenever a document is substantively edited.
- For new subsystems, add a stub page first, then fill details incrementally.
