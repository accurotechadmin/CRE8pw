# Observability & Audit Runbook (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Provide logging/audit diagnostics and incident response steps.

## 1) Signal inventory template

| Signal type | Producer | Schema/location | Retention | Consumer |
|---|---|---|---|---|
| startup logs | `public/index.php` | JSON `boot.startup_*` | _(fill)_ | ops |
| audit events | `AuditEmitter` impl | structured event payload | _(fill)_ | security/ops |
| _(expand)_ | | | | |

## 2) Audit event dictionary template

| Event name | Category | Required fields | Redaction policy | Triggering code path |
|---|---|---|---|---|
| _(fill)_ | | | | |

## 3) Incident playbooks

### 3.1 Authentication failure spike

- Detection triggers
- Immediate checks
- Containment actions
- Follow-up evidence collection

### 3.2 Moderation misuse or abuse

- Correlate request-id + principal + action summary
- Verify authorization path and tokens
- Escalation and postmortem requirements

## 4) Extensibility guidance

- [ ] New feature adds auditable events where policy decisions occur.
- [ ] Sensitive fields reviewed for redaction.
- [ ] Runbook and glossary updated with new event terms.
