# Operations Runbook (Production)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Deploy procedure
1. Validate environment profile and secrets.
2. Install dependencies: `composer install --no-dev --prefer-dist --classmap-authoritative`.
3. Run verification pack: `composer test:contract && composer test:security`.
4. Run operational smokes: `composer ops:health-smoke && composer ops:migrate-smoke`.
5. Start service and verify `/health` and `/.well-known/jwks.json`.

## Rollback procedure
1. Repoint traffic to prior release artifact.
2. Restore prior env snapshot if needed.
3. Validate `/health` and critical auth/content paths.
4. Publish incident note and rollback cause.

## Key rotation playbook
1. Generate new RSA keypair.
2. Publish overlapping JWKS entries.
3. Rotate signer to new `kid`.
4. Drain old token TTL window.
5. Retire previous private key material securely.

## Operational checks
- Confirm limiter/cache state backend health.
- Confirm audit/security log channel emission.
- Confirm request IDs are visible in envelope and logs.

## Dependency linkage
Operational procedures assume the baseline in `Dependency_Reference.md` and controls from `Operations_Reference.md`.
