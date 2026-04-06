# Release Checklist

_Last updated (UTC): 2026-04-06_

## Pre-release
- [ ] Dependencies resolved and lockfile validated
- [ ] Config and secrets reviewed for target environment
- [ ] Contract + security tests pass
- [ ] Health/migration smokes pass
- [ ] SSOT docs updated and cross-linked

## Go-live
- [ ] Startup logs clean
- [ ] `/health` pass
- [ ] Auth flows (owner/key) smoke-tested
- [ ] Core gateway and console routes smoke-tested
- [ ] Observability events flowing with request IDs

## Post-release
- [ ] Error budget and alert dashboards checked
- [ ] No critical regressions in first hour
- [ ] Release note + known issues published
- [ ] Follow-up tasks captured
