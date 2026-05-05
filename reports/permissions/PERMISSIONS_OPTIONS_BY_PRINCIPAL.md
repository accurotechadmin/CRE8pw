# CRE8 Permissions Options by Human Role Label (Principal-Scoped View)

Source mappings:
- `docs/20_identity_delegation_and_policy/PRINCIPAL_TYPES_AND_CAPABILITY_MATRIX.md`
- `docs/20_identity_delegation_and_policy/PERMISSION_VOCABULARY.md`

## Mapping from human labels to canonical principal types

- `Owner`
  - Platform scope: `ROOT_ADMIN`
  - Tenant scope: `TENANT_ADMIN`
- `Primary Author`
  - `IDENTITY_OPERATOR`
- `Secondary Author`
  - `DELEGATEE`
- `Use Key`
  - `DELEGATEE` by default
  - `UTILITY_AGENT` when executed by a registered utility credential process

## Principal-scoped capability view (nested)

- `Owner` (`ROOT_ADMIN` or `TENANT_ADMIN`)
  - ID keypair
    - `principal.id_keypair.issue` (ALLOW)
    - `principal.id_keypair.rotate` (ALLOW)
    - `principal.id_keypair.revoke` (ALLOW)
  - Utility keypair
    - `principal.utility_keypair.issue` (ALLOW)
    - `principal.utility_keypair.rotate` (ALLOW)
    - `principal.utility_keypair.revoke` (ALLOW)
  - Delegation grants
    - `delegation.grant.create` (ALLOW)
    - `delegation.grant.revoke` (ALLOW)
    - `delegation.grant.inspect` (ALLOW)

- `Primary Author` (`IDENTITY_OPERATOR`)
  - ID keypair
    - `principal.id_keypair.issue` (ALLOW)
    - `principal.id_keypair.rotate` (ALLOW)
    - `principal.id_keypair.revoke` (ALLOW)
  - Utility keypair
    - `principal.utility_keypair.issue` (ALLOW)
    - `principal.utility_keypair.rotate` (ALLOW)
    - `principal.utility_keypair.revoke` (ALLOW)
  - Delegation grants
    - `delegation.grant.create` (ALLOW)
    - `delegation.grant.revoke` (ALLOW)
    - `delegation.grant.inspect` (ALLOW)

- `Secondary Author` (`DELEGATEE`)
  - ID keypair
    - `principal.id_keypair.issue` (DENY)
    - `principal.id_keypair.rotate` (CONDITIONAL)
    - `principal.id_keypair.revoke` (DENY)
  - Utility keypair
    - `principal.utility_keypair.issue` (DENY)
    - `principal.utility_keypair.rotate` (CONDITIONAL)
    - `principal.utility_keypair.revoke` (DENY)
  - Delegation grants
    - `delegation.grant.create` (DENY)
    - `delegation.grant.revoke` (CONDITIONAL)
    - `delegation.grant.inspect` (CONDITIONAL)

- `Use Key`
  - Default execution context (`DELEGATEE`)
    - ID keypair
      - `principal.id_keypair.issue` (DENY)
      - `principal.id_keypair.rotate` (CONDITIONAL)
      - `principal.id_keypair.revoke` (DENY)
    - Utility keypair
      - `principal.utility_keypair.issue` (DENY)
      - `principal.utility_keypair.rotate` (CONDITIONAL)
      - `principal.utility_keypair.revoke` (DENY)
    - Delegation grants
      - `delegation.grant.create` (DENY)
      - `delegation.grant.revoke` (CONDITIONAL)
      - `delegation.grant.inspect` (CONDITIONAL)
  - Registered utility credential process (`UTILITY_AGENT`)
    - ID keypair
      - `principal.id_keypair.issue` (DENY)
      - `principal.id_keypair.rotate` (DENY)
      - `principal.id_keypair.revoke` (DENY)
    - Utility keypair
      - `principal.utility_keypair.issue` (ALLOW)
      - `principal.utility_keypair.rotate` (ALLOW)
      - `principal.utility_keypair.revoke` (DENY)
    - Delegation grants
      - `delegation.grant.create` (DENY)
      - `delegation.grant.revoke` (DENY)
      - `delegation.grant.inspect` (DENY)

## Conditional semantics

- `CONDITIONAL` means the action MAY be allowed only when delegation scope intersection, lifecycle state, and expiry checks pass in PDP evaluation order.
