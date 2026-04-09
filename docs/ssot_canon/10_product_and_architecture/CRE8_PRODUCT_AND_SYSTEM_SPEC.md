# CRE8 Product and System Spec

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Product scope
Deliver a delegated-authorship platform with owner-governed moderation and lifecycle control, exposed through public, gateway, and console surfaces.

## System capabilities (v1)
- Owner bootstrap and authentication.
- Key authentication and refresh rotation.
- Feed, posts, comments, flags.
- Owner console operations: posts, moderation, key issuance/lifecycle, keychain management, invites.

## Core system constraints
- Envelope response shape is mandatory for API responses.
- Authorization cannot exceed delegation envelope bounds.
- Keychain behavior (membership rules/effective resolution) is production-active in v1.
- Health and smoke contracts are release-gating requirements.

## Out-of-scope (v1)
- Multi-tenant sharding.
- External plugin execution.
- Non-HTTP runtime protocols.
