# Module Boundaries and Ownership

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Core modules
- Auth and token lifecycle
- Authorization/policy evaluation
- Keychain management
- Content (feed/posts/comments/flags)
- Moderation
- Operational/health/diagnostics

## Ownership model
| Module | Primary owner | Secondary owner |
|---|---|---|
| Auth + lifecycle | Security/backend lead | Platform lead |
| Authorization/policy | Security lead | Backend lead |
| Content + moderation | Backend lead | QA lead |
| Operations + observability | Platform/SRE lead | Backend lead |

## Boundary rules
- Cross-module calls must occur through documented service contracts.
- Policy decisions cannot be duplicated ad hoc across handlers.
- Shared invariants belong in centralized policy/validation services.
