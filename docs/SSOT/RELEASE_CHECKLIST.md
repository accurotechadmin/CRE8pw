# Release Checklist

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Pre-release
- [ ] Dependencies resolved and lockfile validated
- [ ] Config and secrets reviewed for target environment
- [ ] `composer test:contract` and `composer test:security` pass
- [ ] `composer ops:health-smoke` and `composer ops:migrate-smoke` pass
- [ ] SSOT docs updated and cross-linked in same PR

## Go-live
- [ ] Startup logs clean
- [ ] `/health` pass
- [ ] `/.well-known/jwks.json` present and valid
- [ ] Auth flows (owner/key) smoke-tested
- [ ] Core gateway and console routes smoke-tested
- [ ] Observability events flowing with request IDs

## Post-release
- [ ] Error budget and alert dashboards checked
- [ ] 24h incident/noise review complete
- [ ] Any production deltas reflected in SSOT updates
