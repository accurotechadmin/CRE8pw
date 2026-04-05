# Glossary

_Last updated (UTC): 2026-04-05_

- **Owner**: Console principal authenticated by password and owner JWT (`typ=owner`, console audience).
- **Key principal**: Gateway principal authenticated by API key and key JWT (`typ=key`, gateway audience).
- **Use key**: Restricted key class that cannot create posts or mutate keys.
- **Delegation envelope**: Stored delegation metadata linking permissions, scope, depth, and expiry.
- **Refresh token family**: Rotatable token lineage keyed by family ID with nonce replay protection.
- **Route surface**: Request classification (`public`, `gateway`, `console`) set by routing marker middleware.
- **Route family**: Path-derived sub-classification (e.g., `feed`, `posts`) used in telemetry context.
- **Envelope response**: Standardized JSON success/error payload shape from `EnvelopeResponder`.
- **Detail code**: Stable machine-readable error reason in `error.details`.
- **Audit emitter**: Interface for structured event output with redaction and schema normalization.
- **Keychain listing**: Console view/list of owner-associated key records and delegation metadata.
- **Invite receipt**: Stored record of invite issuance containing hashed invite code and expiry.
