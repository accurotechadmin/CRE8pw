# Security Model (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Capture threats, controls, validation points, and safe extension patterns.

## 1) Threat model worksheet

| Threat category | Example attack | Existing control(s) | Residual risk | Owner |
|---|---|---|---|---|
| Token forgery | invalid signature token reuse | JWT verifier + claim checks | _(fill)_ | security |
| Privilege misuse | over-scoped key mutation | permissions + middleware + service policy | _(fill)_ | platform |
| _(expand)_ | | | | |

## 2) Authentication and session controls

- Owner login and refresh flow
- Key login and refresh flow
- Token family rotation behavior
- Session expiry handling expectations (API + UI)

## 3) Authorization model

- Route surface constraints
- Permission checks
- Delegation scope semantics
- Comments-enabled/write restrictions

## 4) Cryptographic material handling

- PEM source rules (inline/path)
- file-permission safety checks
- rotation strategy template
- JWKS publication expectations

## 5) HTTP and middleware controls

- CORS profile policy
- CSRF policy scope
- Rate-limit policy
- device-id policy
- input validation policy

## 6) Secure extensibility guardrails

When adding new features:

- [ ] Define new threat scenarios.
- [ ] Identify required middleware/policy updates.
- [ ] Add negative security tests first.
- [ ] Update glossary and incident runbook.
