# Deprecation and Versioning Policy

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Versioning model
- Contract artifacts follow semantic versioning intent.
- Breaking changes require new major OpenAPI artifact and migration notes.
- Additive fields/behaviors are minor changes if backward compatible.

## Deprecation process
1. Mark deprecated behavior in relevant SSOT docs and route inventory.
2. Publish replacement behavior and migration path.
3. Maintain compatibility window with explicit end date.
4. Remove only after verification and adoption milestones are met.

## Guardrails
- No silent removals.
- Deprecation notices must include operational and client impact.
