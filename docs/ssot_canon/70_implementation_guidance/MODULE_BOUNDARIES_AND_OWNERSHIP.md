# Module Boundaries and Ownership

_Status: adopted_
_Last updated (UTC): 2026-04-28_

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

## Authorization module internal contract
- The authorization module owns the PDP primitives: `Decision`, `DecisionContext`, `Obligation`, and `PolicyRule`.
- Route-action resolution and surface-specific context builders (owner and key) are authorization-module responsibilities and feed all protected-route policy evaluation.
- The authorization module owns `PdpService` and `RuleRegistry`, including deterministic rule-pack ordering and owner-only console governance rule families.
- The authorization module owns policy configuration loaders for `config/policy/route_actions.php`, `config/policy/permissions.php`, and `config/policy/detail_codes.php`, including boot-time integrity validation and immutable runtime snapshots.
- Gateway and console handlers consume authorization outcomes and obligations; they do not construct authorization decisions directly.


## Extension seam ownership map
| Extension seam | Required synchronized artifacts | Primary reviewer |
|---|---|---|
| Route/contract extension | OpenAPI + route inventory + endpoint examples + acceptance matrix | Architecture lead |
| Policy/authorization extension | Auth spec + decision tables + error catalog + abuse cases | Security lead |
| Data-model extension | Data model spec/reference/ERD + migration strategy + traceability matrix | Backend lead |
| UI-runtime extension | UI runtime contract + acceptance matrix + examples | Frontend/QA leads |
