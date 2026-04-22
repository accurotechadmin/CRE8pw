# Core Identity And Value Proposition

_Status: adopted_
_Last updated (UTC): 2026-04-22_

## Product identity
CRE8 is a policy-governed content platform centered on delegated authorship, owner-governed control, and auditable lifecycle management.

## Primary value propositions
- **Deterministic governance:** owner console controls moderation, keys, and lifecycle transitions.
- **Safe delegation:** strict subset/depth/expiry rules prevent privilege escalation.
- **Operational confidence:** measurable SLOs, release gates, and abuse-case verification.
- **Contract stability:** OpenAPI/envelope standards reduce client drift and integration risk.

## Intended user/actor model
- Owners: governance administrators.
- Keys (primary/secondary/use): delegated execution actors.
- Keychains: aggregation principals for controlled group authority.

## Product promises encoded as engineering constraints
- Never execute out-of-envelope authorization.
- Never ship unverifiable contract changes.
- Never hide failing-path context (request_id + stable error codes).


## Human-accessible utility model
- Developers can start with owner login and governance-only usage, then progressively enable delegated API-key access when ready.
- Non-owner participants can authenticate with key credentials (without local username/email/password registration) when policy permits.
- Invite-gated owner bootstrap keeps private deployments controlled by default; open owner signup is an explicit configuration choice.

## Persona-oriented value
- **Product owner/operator:** private-by-default governance, moderation, and lifecycle control.
- **Integrator/developer:** stable envelopes, deterministic policy decisions, and extension-friendly patterns.
- **Delegated creator/contributor:** controlled key-based access with predictable permissions and scope boundaries.
- **End user/non-technical participant:** credential-first interaction model with clear allowed/denied outcomes.
