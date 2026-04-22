# Canonical Terminology

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Principal terms
- **Owner principal**: governance authority for console operations.
- **Key principal**: delegated actor for gateway operations.
- **Key class**: `primary_author`, `secondary_author`, `use`, `keychain`.
- **Delegation envelope**: permission/scope/expiry bounds of delegated authority.

## Security terms
- **Lifecycle status**: active/suspended/cancelled/revoked state affecting authz.
- **Token family**: refresh lineage used for replay protection and rotation.
- **Request ID**: correlation identifier required in error and operational flows.

## Contract terms
- **Success envelope**: JSON object with `data` and `meta`.
- **Error envelope**: JSON object with `error` and `meta`.
- **Normative requirement**: MUST-level behavior required for conformance.
