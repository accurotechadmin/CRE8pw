# CRE8 Product and System Spec

_Status: adopted_
_Last updated (UTC): 2026-04-22_

## Product scope
Deliver a delegated-authorship platform with owner-governed moderation and lifecycle control, exposed through public, gateway, and console surfaces.

## System capabilities (v1)
- Owner bootstrap and authentication.
- Key authentication and refresh rotation.
- Feed, posts, comments, flags.
- Owner console operations: posts, moderation, key issuance/lifecycle, keychain management, invites.


## Deployment and adoption profiles
- **Profile A (owner-first):** operate owner bootstrap/login + console governance routes as the primary user-management model.
- **Profile B (delegated API platform):** expose gateway routes for third-party clients and native UI parity pages using key credentials.
- **Profile C (progressive):** begin as Profile A, then enable Profile B surfaces as integration needs mature.

## Owner bootstrap policy
- Default policy requires a valid invitation code for owner bootstrap requests.
- Deployments may opt into open owner signup via explicit configuration in the environment contract.
- Invite-gated bootstrap is intended for private and payment-gated systems where owner creation must remain controlled.

## Core system constraints
- Envelope response shape is mandatory for API responses.
- Authorization cannot exceed delegation envelope bounds.
- Keychain behavior (membership rules/effective resolution) is production-active in v1.
- Health and smoke contracts are release-gating requirements.

## Out-of-scope (v1)
- Multi-tenant sharding.
- External plugin execution.
- Non-HTTP runtime protocols.
