# Boot and Startup Failure Contract (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Define deterministic startup checks, startup evidence behavior, and failure-envelope semantics so CRE8 fails closed and remains operationally diagnosable.

## Startup sequence contract
1. Load environment + resolve key source references.
2. Build typed runtime config.
3. Build container and resolve core services.
4. Execute boot assertions.
5. Start app and expose routes.

## Mandatory boot assertions
- Core dependency class presence for runtime baseline.
- Container resolvability for token signer/verifier, observability emitter, and DB.
- Key material resolvability and format safety.
- Profile hardening checks (`APP_ENV`, issuer/cors profile restrictions).
- Private key path safety checks in stage/prod.
- Middleware order contract consistency check.

## Startup success behavior
- Emit structured startup-ready event.
- If `BOOT_EVIDENCE_PATH` is configured, write startup evidence JSON including:
  - status,
  - timestamp,
  - environment profile,
  - middleware order,
  - startup latency,
  - key source mode indicators.

## Startup failure behavior
- Return deterministic JSON failure envelope:
  - `error.code = boot_failed`
  - generated `request_id`
  - startup-safe message (no stack trace disclosure)
- Emit structured startup-failed event with failure metadata.
- Include `X-Request-Id` header in startup failure responses.

## Non-negotiable fail-closed rule
If any mandatory boot assertion fails, startup must halt before serving user traffic.

## Related SSOT docs
- `Configuration_Environment_Contract.md`
- `Operations_Reference.md`
- `Security_Controls_Spec.md`
- `Operational_Smoke_Check_Contract.md`
