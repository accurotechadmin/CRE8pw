# Data Model & Persistence (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Document persistence entities, lifecycle transitions, and schema compatibility strategy.

## 1) Entity inventory template

| Entity | Purpose | Key fields | Relationships | Created by | Updated by |
|---|---|---|---|---|---|
| principals | identity root | _(fill)_ | principal_emails, credentials, token_families | auth services | auth/key lifecycle |
| posts | content object | _(fill)_ | comments, moderation actions | post services | moderation/posts |
| _(expand)_ | | | | | |

## 2) State machine templates

### 2.1 Post lifecycle

- States: draft/published/hidden/locked/archived/deleted (verify exact set).
- Allowed transitions matrix.
- Transition authority (owner/key/system).

### 2.2 Key lifecycle

- States: active/suspended/revoked/expired (verify exact set).
- Transition policy and required confirmations.

## 3) Read/write path mapping

Map each service method to SQL tables and write side effects.

## 4) Migration governance

- Backward compatibility expectations.
- Roll-forward / rollback strategy.
- Smoke validation procedure (`scripts/migrate_smoke.php`).

## 5) Extensibility checklist

- [ ] New table includes ownership/security considerations.
- [ ] New index impact measured.
- [ ] Migration safe for stage/prod promotion.
- [ ] Tests updated for schema assumptions.
