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

## ADR-2026-04-05-03: Centralize gateway header policy in API client for all `/api` content workflows

- **Date / Session**: 2026-04-05 (UTC), Session 2
- **Context**:
  - Phase 2 gateway endpoints require both bearer auth and `X-Device-Id`.
  - Duplicating header logic per page risks drift and inconsistent error behavior.
- **Decision**:
  - Extend `apiRequest()` with `authSurface` and `requireDeviceId` options.
  - Generate/persist a stable browser device id in `localStorage` (`cre8_ui_device_id_v1`) and automatically attach it on gateway calls.
- **Consequences**:
  - Feed/post/comments screens share one consistent auth/header behavior.
  - Future gateway write flows can reuse the same call pattern without custom header code.
  - Device id persistence behavior is explicit and testable from a single state utility.


## ADR-2026-04-05-04: Enforce write-entry gating in UI before gateway write submissions

- **Date / Session**: 2026-04-05 (UTC), Session 3
- **Context**:
  - Phase 2 adds write endpoints that can fail with `403` depending on key permissions, key class, comment toggle, and post state.
  - Existing UI had no pre-submit affordance to explain why a write action might be unavailable.
- **Decision**:
  - Add route-level and CTA-level guards for `posts:create`, `posts:edit`, and `comments:create` + `comments_enabled`.
  - For comment creation, prefetch post detail and block form rendering when post state is one of `locked|archived|hidden|deleted`.
  - Keep backend as source-of-truth and still handle envelope `403` reasons centrally for robustness.
- **Consequences**:
  - Users receive earlier, clearer feedback about unavailable write actions.
  - Fewer avoidable failing submissions and tighter alignment with backend policy behavior.
  - Additional coupling to claim names/reason codes, documented here for future maintenance.

## ADR-2026-04-05-05: Reuse centralized owner-auth request handling and confirmation UX for console moderation

- **Date / Session**: 2026-04-05 (UTC), Session 4
- **Context**:
  - Phase 3 introduces four console endpoints that all require owner bearer auth and envelope-consistent error handling.
  - Moderation workflows need explicit confirmation and action/result summaries for safer operator behavior.
- **Decision**:
  - Added `ownerRequest()` helper that wraps `apiRequest()` with `authSurface: 'owner'` and unified 401 session-expiry handling.
  - Implemented post/comment moderation forms with a mandatory confirmation checkbox and live action summary panel before submit.
  - Kept moderation options aligned to the endpoint contract (`hide|lock|archive|delete` for posts, `hide|lock|delete` for comments).
- **Consequences**:
  - Console list/create/moderation flows share consistent auth behavior and fail predictably on expired sessions.
  - Moderation operations become more auditable and less error-prone due to explicit preview + confirm UX.
  - Adds lightweight reusable moderation form logic that can be extended to future lifecycle/dangerous actions in Phase 4.

## ADR-2026-04-05-06: Model key lifecycle and key issuance as safety-first console flows

- **Date / Session**: 2026-04-05 (UTC), Session 5
- **Context**:
  - Phase 4 introduces sensitive operations (`/console/api/keys` and lifecycle transitions) with one-time secrets and disruptive state changes.
  - UI needed to remain consistent with existing moderation confirmation patterns while adding key-specific policy affordances.
- **Decision**:
  - Reused `ownerRequest()` for all new `/console/api/*` key-management calls, with dedicated `mapConsoleError()` handling for known policy/detail code patterns.
  - Added one-time secret reveal UX for issued API keys and avoided storing/re-rendering secrets outside the current route session.
  - Added lifecycle risk copy + mandatory confirmation checkbox, and enforced typed `CONFIRM` for revoke transitions.
- **Consequences**:
  - Console key workflows are safer and aligned with backend constraints without introducing new shared infrastructure abstractions.
  - Operator behavior is guided by clear action summaries before submission.
  - Future enhancement may extract a generalized “dangerous action confirmation” primitive used by moderation and lifecycle views.
