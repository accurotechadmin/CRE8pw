# Observability Event Catalog

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Catalog key structured logs/audit events required for diagnosis and compliance.

## Scope
Startup events, auth lifecycle events, moderation actions, and error events.

## Normative statements
- Critical lifecycle events MUST be logged with request correlation IDs where applicable.
- Sensitive material MUST be redacted in logs.
- Event names SHOULD remain stable for dashboard/alert continuity.

## Interfaces / contracts
| Event | Trigger | Required fields |
|---|---|---|
| `boot.startup_ready` | successful startup | timestamp, app_env, outcome |
| `boot.startup_failed` | startup exception | request_id, error_class, outcome |
| `auth.login_failed` | invalid credentials | request_id, surface, reason |
| `moderation.action_applied` | moderation mutation | actor, target, reason, request_id |

## Failure/rejection semantics
- Missing correlation ID on error/audit events SHOULD fail operational review.
- Unredacted sensitive payloads are security incidents.

## Verification requirements
- Audit emitter contract tests and log sampling during smoke checks.

## Traceability hooks
- Code refs: `public/index.php`, `src/Observability/*`
- Tests refs: `tests/Contract/MonologAuditEmitterContractTest.php`
- Related SSOT docs: `SLO_SLI_SPEC.md`, `RELEASE_CHECKLIST.md`

## Open questions / known gaps
- Full event inventory in source code is still evolving; catalog is high-value starter set only.
