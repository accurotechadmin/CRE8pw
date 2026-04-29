# CRE8 Surfaces and Client Parity Seed

CRE8 exposes distinct operational surfaces: Owner Console UI for owner governance, API Gateway UI for key bearers, and public/bootstrap/auth entry points. Owners can optionally operate with invited multi-owner accounts, single-owner api-only mode, or traditional username/email/password access patterns depending on deployment policy.

CRE8.pw is the reference first-party API client that demonstrates UI/API parity. Third-party clients interact via POST requests using public keys and private-key-backed configuration/authorization flows. Every API action should have a corresponding UI parity path so implementation behavior remains consistent regardless of client channel.

## Dependency anchoring for surface parity
Surface mounts and middleware order SHOULD be explicitly modeled in `slim/slim` route groups; surface-scoped dependency graphs SHOULD be wired in `php-di/php-di`; payload validation SHOULD use `respect/validation`; CORS behavior SHOULD be enforced with `neomerx/cors-psr7`; parity telemetry SHOULD be emitted via `monolog/monolog` channels sharing correlation context.
