# Security Verification and Abuse Cases (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Expand security verification from high-level controls into explicit abuse-case test requirements and incident-ready verification evidence.

## Abuse-case matrix (minimum required)

| Abuse case | Attack intent | Required control behavior | Required verification evidence |
|---|---|---|---|
| Stolen access token replay | Reuse captured bearer token | Short access TTL + claim validation; access denied post-expiry/lifecycle disable | Security test for token replay timing and lifecycle state changes |
| Refresh token replay | Reuse old refresh token in family | Family rotation and replay invalidation deny second use | Refresh replay test with explicit first/second request assertions |
| Delegation escalation | Mint child with broader perms/scope | Subset-only envelope enforcement + max-depth enforcement | Delegation negative tests (over-scope, over-depth) |
| CSRF on console write | Induce browser write without intent | CSRF middleware rejects invalid/missing token | Console write CSRF failure tests and logs |
| Rate-limit exhaustion | Flood auth/gateway endpoints | Limiter returns `429` with retry metadata | Load-abuse simulation and limiter behavior capture |
| Keychain nesting bypass | Insert keychain into keychain | Membership validation denies nested keychains | Keychain contract/security negative test |
| Device-header bypass | Access gateway route without required device policy | Device policy denies missing/invalid header | Gateway authz tests for missing/invalid `X-Device-Id` |
| Sensitive log leakage | Exfiltrate secrets via logs/errors | Redaction of token/secret/private key fields | Log redaction tests + sampling audit |

## Security test-pack requirements
- Security suite must include both happy-path and abuse-path tests.
- Every abuse-case row requires at least one automated regression test.
- High-severity controls (authn/authz/token lifecycle) require two-sided tests: allow valid + deny invalid.

## Incident-response verification hooks
For each security-significant failure path:
- emitted event family is documented,
- `request_id` is present in envelope + logs,
- runbook triage step is linked.

## Release gate linkage
Production release is blocked if:
- any required abuse-case test fails,
- redaction verification fails,
- replay-protection assertions are missing or stale.

## Related SSOT docs
- `SECURITY_THREAT_MODEL.md`
- `Security_Controls_Spec.md`
- `Verification_Strategy.md`
- `Observability_Event_Catalog.md`
- `Production_Readiness_Gates.md`
