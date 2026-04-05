# CRE8.pw Documentation Set

This directory is the canonical, long-lived documentation home for the CRE8.pw system.

> Intent: keep docs useful both for **day-1 onboarding** and **deep operational/debug reference**.

_Last updated (UTC): 2026-04-05_

## Documentation architecture

The docs set is organized into four layers:

1. **Orientation** — quick understanding of system shape and vocabulary.
2. **Reference** — precise source-of-truth behavior, contracts, and policies.
3. **Operations** — deployment, runbooks, incident handling, and QA.
4. **Evolution** — roadmap, extensibility guidelines, and contribution standards.

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

## Subfolders

- [`docs/dev/`](./dev/README.md): session-by-session execution artifacts, ADR history, QA logs, and implementation tracking.

## Authoring standards

### Required for final (non-stub) docs

- Include a `Last updated (UTC)` marker.
- Include explicit “Source of truth” links to implementation files and/or tests.
- Distinguish clearly between:
  - **Contracted behavior** (proven in tests),
  - **Current implementation details** (may change),
  - **Future intent** (roadmap or proposal).
- For security/operations claims, include a validation or evidence reference.

### Stub completion rubric

Each scaffolded doc should graduate from `Scaffold` to `Reference` by adding:

1. **Scope statement**: what this doc covers and does not cover.
2. **Canonical data tables**: endpoint matrices, config maps, event dictionaries, etc.
3. **Worked examples**: happy path + failure path.
4. **Extensibility notes**: how to add new features without violating existing contracts.
5. **Verification procedure**: concrete commands/tests to validate the document’s claims.

## Extensibility principle for this docs set

When adding major capability areas (e.g., webhooks, multi-tenant controls, new identity providers),
create a dedicated document and link it from:

- this index,
- `architecture_overview.md` (boundary impact),
- `security_model.md` (threat/control impact), and
- `roadmap_backlog.md` (delivery tracking).
