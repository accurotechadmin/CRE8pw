# Deployment & Operations (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Capture environment promotion workflow, runtime checks, and operational procedures.

## 1) Environment profile template

| Environment | Purpose | Config profile | Key constraints | Promotion source |
|---|---|---|---|---|
| local | developer loop | permissive | dev-only shortcuts | n/a |
| stage | pre-prod verification | strict | production-like policies | local/CI |
| prod | customer-facing | strictest | no wildcard/security exceptions | stage |

## 2) Release checklist template

- [ ] dependency install and lockfile integrity verified.
- [ ] boot checks pass with target env vars.
- [ ] health smoke passes post-deploy.
- [ ] migration smoke/DB checks pass.
- [ ] rollback package and runbook prepared.

## 3) Operational runbooks

### 3.1 Startup failure (`boot_failed`)

- inspect logs + request-id
- validate env + key paths
- validate dependency availability

### 3.2 Secret/key rotation

- rotate key material
- validate JWKS and token verification compatibility
- monitor auth error rates

### 3.3 Rollback procedure

- trigger criteria
- rollback command sequence
- post-rollback validation steps
