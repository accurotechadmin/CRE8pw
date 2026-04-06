# Canonical Terminology Dictionary (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Defines the authoritative vocabulary used across SSOT documents. When wording differs between documents, this dictionary is normative.

## Core terms

| Term | Canonical definition | Notes / constraints |
|---|---|---|
| **surface** | One of the externally visible request domains in CRE8: `public`, `gateway`, `console`. | Surface determines middleware policy, auth expectations, and route mounts. |
| **principal** | A security identity represented by a stable DB record and used for authorization decisions. | v1 principal types: `owner`, `key`. |
| **owner principal** | A principal with governance authority for console operations. | Authenticated with owner JWT (`typ=owner`). |
| **key principal** | A principal used for gateway operations. | Authenticated with key JWT (`typ=key`). |
| **key class** | Behavioral subtype of key principal expressing delegation/usage semantics. | v1 active: `primary_author`, `secondary_author`, `use`; `keychain` is extension-scoped. |
| **delegation envelope** | The constrained permission/scope contract inherited from parent to child key. | Must be subset-only, depth-bounded, and expiry-bounded. |
| **lineage** | Parent-child chain of delegated key issuance over time. | Used for audits, claim checks, and cascading lifecycle actions. |
| **scope** | Resource boundary limiting where granted permissions apply. | May target post sets, audience slices, or policy-defined subsets. |
| **permission** | Allow-listed capability string controlling allowed actions. | Canonical vocabulary defined in Authorization SSOT docs. |
| **envelope (response envelope)** | The API response wrapper used on all surfaces. | Success: `{data, meta}`; Error: `{error, meta}`. |
| **detail code** | Fine-grained machine-readable error reason nested under an envelope-level error code. | Must be registered in `Error_Code_Catalog.md`. |
| **request_id** | Correlation identifier attached to responses and observability events. | Required for incident traceability and support workflows. |
| **boot assertions** | Startup-time safety and dependency validations before app serves traffic. | Failure must produce deterministic boot-failure behavior. |
| **contract artifact** | Machine and human documents that define API behavior and validation semantics. | OpenAPI + schemas are canonical machine artifacts. |

## Usage rules
- SSOT docs should prefer these exact terms over synonyms.
- New domain terms must be added here in the same PR that introduces them.
- Breaking terminology changes require updates to all impacted SSOT docs and examples.

## Related SSOT docs
- `SSOT_INDEX.md`
- `API_Contract.md`
- `Authorization_and_Delegation_Spec.md`
- `Data_Model_Reference.md`
- `Error_Code_Catalog.md`
- `Observability_Event_Catalog.md`
