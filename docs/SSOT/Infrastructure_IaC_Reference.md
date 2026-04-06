# Infrastructure and IaC Reference (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define the canonical infrastructure topology, environment separation, and infrastructure-as-code requirements required to run CRE8 reliably in production.

## Canonical deployment topology
- Edge/load-balancer tier terminating TLS.
- Application service tier running CRE8 API runtime.
- Relational database tier for transactional data.
- Cache/limiter state tier for rate-limiter persistence.
- Secrets/key-management tier for JWT signing material and runtime secrets.
- Observability tier for logs/metrics/traces/alerts.

## Environment tiers
- `dev` (local and shared developer environments)
- `ci` (ephemeral validation environments)
- `staging` (production-like rehearsal)
- `prod` (live customer environment)

No cross-tier secret sharing is permitted.

## IaC requirements
- All mutable infrastructure resources must be declared in IaC.
- Environment-specific values are parameterized; no hard-coded secrets in IaC source.
- Changes require plan output review before apply.
- Apply actions must emit audit trail (actor, timestamp, change set).

## Secret and key management requirements
- JWT private keys stored only in approved secret material path/store.
- Key rotation must preserve overlap window per runbook.
- Secret access follows least privilege and environment isolation.
- Emergency key revocation workflow must be documented and rehearsed.

## Backup and disaster recovery baseline
- Daily full DB backup + regular incremental backups.
- Restore drill executed at least quarterly in staging-like environment.
- Recovery point objective (RPO) and recovery time objective (RTO) documented per environment profile.
- Backup artifacts encrypted at rest and access-audited.

## Release and rollback infra controls
- Blue/green or equivalent low-risk deployment strategy preferred.
- Rollback path must include artifact rollback and DB restore decision tree.
- Health gates (`/health`, auth smoke, key routes) required before traffic shift completion.

## Network and surface controls
- Public exposure limited to documented public routes and UI assets.
- Console and gateway protections enforced by middleware and perimeter policy.
- Egress restrictions apply to outbound integration clients.

## Compliance and evidence
Release evidence must include:
- IaC plan/apply records,
- backup freshness evidence,
- restore drill recency,
- alert routing and dashboard ownership verification.

## Related SSOT docs
- `Operations_Reference.md`
- `Operations_Runbook_Production.md`
- `SLO_SLI_SPEC.md`
- `Security_Controls_Spec.md`
- `Migration_Seed_Strategy.md`
