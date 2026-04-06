# Local Dev Seed and Bootstrap Policy (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define local-development bootstrap allowances while preserving strict production/staging posture.

## Scope
Applies only to `APP_ENV=local` environments.

## Allowed local-only bootstrap behaviors
- Optional default owner bootstrap seeding for developer convenience.
- Synthetic fixture initialization when explicitly enabled.
- Local-only CORS wildcard allowance when permitted by environment policy.

## Prohibited outside local
The following must be disallowed in `stage|prod`:
- implicit default owner seeding,
- wildcard CORS,
- insecure issuer profiles,
- relaxed key path/permission checks.

## Default owner seed policy
If local owner seeding is implemented:
- it must be explicitly opt-in via environment variable,
- seeded credentials must satisfy minimum password policy,
- seed identity must be deterministic and documented,
- behavior must be no-op when seed already exists.

## Security and hygiene rules
- No real user data in local seeds.
- No plaintext secrets persisted to version control.
- Seed paths must emit clear audit or startup notes for visibility.

## Verification requirements
- contract/security checks for environment-guarded bootstrap behavior,
- explicit test ensuring seed behavior is disabled for non-local environments.

## Related SSOT docs
- `Migration_Seed_Strategy.md`
- `Configuration_Environment_Contract.md`
- `Security_Controls_Spec.md`
- `Verification_Strategy.md`
