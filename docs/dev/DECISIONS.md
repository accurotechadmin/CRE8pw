# Architecture / UX / Integration Decisions

## ADR-2026-04-05-01: Deliver auth-first vertical slice as a no-build static UI under `/public/ui`

- **Date / Session**: 2026-04-05 (UTC), Session 1
- **Context**:
  - Repository currently contains backend API implementation with no browser UI project scaffold.
  - The implementation plan requires Phase 0 foundations before endpoint-complete UI coverage.
  - Need a meaningful, shippable increment that unlocks subsequent endpoint pages quickly.
- **Decision**:
  - Implement a vanilla JavaScript static UI in `public/ui` and route `/ui[/{route:.*}]` to the SPA entrypoint.
  - Include app shell, API client, session persistence, auth forms for owner/key login and owner signup, and response inspector.
- **Consequences**:
  - Fastest path to deliver endpoint-connected UX without introducing a bundler/framework.
  - Future endpoint slices can reuse the same API and session primitives.
  - If scale/complexity grows, migration to a framework may be considered later.

## ADR-2026-04-05-02: Persist per-surface session state in `localStorage` with explicit active surface marker

- **Date / Session**: 2026-04-05 (UTC), Session 1
- **Context**:
  - Playbook requires dual auth surfaces (owner console and key gateway) and shared refresh behavior.
- **Decision**:
  - Store session object shape `{ activeSurface, owner, key }` in `localStorage` key `cre8_ui_session_v1`.
  - Persist expiration metadata (`expiresAtMs`) and key capability fields (`permissions`, `scope`, `commentsEnabled`) for later route guards.
- **Consequences**:
  - Subsequent phases can introduce route and permission guards without redesigning session format.
  - Sensitive token persistence remains a known tradeoff and should be reevaluated during hardening (Phase 5).
