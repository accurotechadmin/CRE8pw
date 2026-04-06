# Operations Runbook (Production)

_Last updated (UTC): 2026-04-06_

## Deploy procedure
1. Validate env/profile + secrets.
2. Run `composer install --no-dev --prefer-dist`.
3. Run contract/security tests.
4. Run health/migration smoke scripts.
5. Start service and verify `/health`.

## Rollback procedure
1. Repoint traffic to prior release artifact.
2. Restore prior env snapshot if needed.
3. Validate `/health` and critical auth/content paths.
4. Publish incident note and rollback cause.

## Key rotation playbook
1. Generate new RSA keypair.
2. Publish overlapping JWKS entries.
3. Rotate signer to new `kid`.
4. Monitor verification success rates.
5. Retire old key post grace window.

## Incident classes
- Auth outage
- Key-material failure
- DB availability degradation
- Rate limiter saturation
- UI asset/CSP regression

## Postmortem checklist
- timeline
- blast radius
- root cause
- contributing factors
- corrective actions
- test/doc updates
