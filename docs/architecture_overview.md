# Architecture Overview (Scaffold)

_Last updated (UTC): 2026-04-05_

## Purpose

Explain major subsystems, boundaries, and data/control flow.

## Sections to complete

- [ ] Context diagram (external actors + system boundaries)
- [ ] Container-level architecture (backend runtime, DB, SPA)
- [ ] Module dependency map (`src/Application`, `src/Http`, `src/Security`, etc.)
- [ ] Trust boundaries and surface segmentation (UI/console/gateway)
- [ ] Key design constraints and non-goals

## Seed notes

- Backend is Slim-based with DI container composition in bootstrap.
- Routing and middleware enforce surface-aware behavior.
