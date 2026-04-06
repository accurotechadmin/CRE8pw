# CRE8 High-Level Architecture Summary

_Status: adopted_
_Date authored (UTC): 2026-04-06_

## 1) System shape

CRE8 is a single-runtime Slim 4 + PHP-DI application that boots from `public/index.php` and follows a policy-first startup sequence:

1. Load env + normalize key material sources.
2. Build typed runtime config.
3. Build DI container.
4. Run boot assertions.
5. Build Slim app with middleware and routes.

The platform combines backend API surfaces with a static SPA served from `public/ui`, so deployment remains monolithic while preserving API-first contracts.

## 2) Core architectural layers

- **Bootstrap/config layer**
  - `src/Bootstrap/*`, `src/Config/*`.
  - Responsible for runtime assembly and startup safety checks.
- **Transport/policy layer**
  - `src/Http/Middleware/*`.
  - Enforces request identity, headers/CSP, CORS, rate limiting, schema/body checks, CSRF, and auth/policy gates.
- **Route orchestration layer**
  - `src/Http/Routes/RouteRegistrar.php`.
  - Binds public/auth/gateway/console routes and delegates business logic.
- **Domain service layer**
  - `src/Application/*/*Service.php`.
  - Encapsulates auth, key lifecycle, feed, posts/comments/moderation, and health behavior.
- **Security primitives layer**
  - `src/Security/*`.
  - Provides JWT signing/verification, key material safety, API-key hashing, and JWKS output.
- **Observability layer**
  - `src/Observability/*`.
  - Emits structured/redacted audit events with failure fallback behavior.

## 3) Trust surfaces and policy boundaries

CRE8 intentionally separates three trust surfaces:

- **Public** (`/`, `/health`, `/.well-known/jwks.json`, `/ui*`, bootstrap auth routes)
- **Gateway** (`/api/*`) for key-authenticated operational usage
- **Console** (`/console/api/*`) for owner-authenticated governance operations

Surface-aware middleware mapping is a first-class contract in startup and request processing.

## 4) Request lifecycle contract

Every request follows a deterministic middleware sequence before handler execution:

1. Request ID acceptance/generation.
2. Security headers + CSP policy application.
3. CORS preflight/response handling.
4. Global IP rate limiting.
5. Payload schema validation for known routes.
6. JSON body enforcement/parsing for mutating methods.
7. Route surface/family tagging.
8. CSRF enforcement for non-API console writes.
9. Surface middleware (owner/key JWT checks + gateway constraints).
10. Handler/service execution and envelope response.

This produces standardized error envelopes and stable detail codes for client mapping.

## 5) Identity and authorization model

CRE8 is centered on dual auth principal types:

- **Owner principal** (`typ=owner`) for console governance.
- **Key principal** (`typ=key`) for gateway usage.

Key JWTs carry operational claims (`permissions`, `scope`, `key_class`, `comments_enabled`) and lineage claims (`delegation_envelope_id`, `initial_author_key_id`) to support delegated access control.

Delegation is constrained by policy (subset inheritance, depth/expiry bounds, lifecycle controls). The current v1 docs consistently describe a depth cap and explicit lifecycle transitions (`suspend`, `cancel`, `revoke`) with auditability.

## 6) Data and persistence architecture

Persistence is PDO-backed with service-level table bootstrap (`CREATE TABLE IF NOT EXISTS`) to reduce first-run friction.

Major data groups:

- **Principal/auth:** `principals`, `principal_emails`, `credentials`, `token_families`
- **Delegation/lifecycle:** `delegation_envelopes`, `invite_receipts`
- **Content/moderation:** `posts`, `post_revisions`, `post_flags`, `comments`, `moderation_actions`

Operational semantics include refresh-token family rotation/replay checks, post/comment state machines, and key-class behavior (`primary_author`, `secondary_author`, `use`).

## 7) API/UX architecture

The SPA (`public/ui`) is no-build vanilla JS and maps route-by-route to API contracts.

Implemented UI coverage spans:

- auth/bootstrap flows,
- gateway feed/post/comment flows,
- console moderation/key/invite flows.

The UI state model is explicit and standardized (loading/submitting/success and mapped failure states), while backend remains source-of-truth for authorization.

## 8) Security and hardening posture

CRE8 applies layered controls:

- RS256 JWT with strict claim/audience/type validation,
- key material sanity and file-permission checks,
- env/profile hardening rules,
- CORS + CSRF + rate limiting + device-id guardrails,
- use-key mutation restrictions,
- security headers/CSP split for UI vs API,
- structured audit logs with sensitive-field redaction.

Startup fails closed when critical invariants are not met.

## 9) Operations and reliability model

Operations rely on deterministic startup checks, `/health` subsystem probes, structured startup success/failure events, and request-id-centered incident triage.

This gives CRE8 a contract-driven operational posture: invariant validation at boot, policy enforcement at transport, and traceability in runtime telemetry.

## 10) Extensibility model

CRE8 is intentionally extension-oriented through stable seams:

- add new domain service modules and wire in container,
- add routes with explicit surface middleware,
- extend middleware/policy and auth claims,
- rebind observability interfaces (e.g., audit backend),
- preserve envelope + detail-code contracts.

The docs position this as pattern-based extensibility suitable for full-platform use, hybrid owner+key systems, or API-only deployments.

## 11) Architecture in one sentence

CRE8 is a policy-driven, dual-surface PHP monolith where delegated key lineage and JWT-scoped capability claims form the control plane, and content/moderation workflows execute as governed domain services behind deterministic middleware and envelope contracts.
