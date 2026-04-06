# Authorization and Delegation Spec

_Last updated (UTC): 2026-04-06_

## Principals
- Owner principal: governance/console authority.
- Key principal: gateway content authority.

## Key classes
- `primary_author`
- `secondary_author`
- `use`

## Permission set (v1)
- `posts:read`, `posts:create`, `posts:edit`, `comments:create`, `keys:issue`, `keys:revoke`

## Delegation rules
- Child permissions/scope are subset of parent envelope.
- Max depth = 3.
- Expiry required and enforced.
- Secondary cannot mint primary.
- Use keys cannot mint credentials.

## Lifecycle transitions
- `suspend`: reversible disable
- `cancel`: permanent disable
- `revoke`: trust termination + credential revocation; optional cascade policy

## Scope semantics
- Tokenized scope entries, e.g., `posts:all`, `post:{id}`, future `audience:{id}`
- Effective authorization computed per request from token claims + resource state.
