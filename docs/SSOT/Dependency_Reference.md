# Dependency Reference (SSOT)

_Status: adopted_  
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
This document defines the production dependency baseline for CRE8. It is normative for framework/runtime package selection in the next production iteration.

## Core dependency baseline

| Dependency | Role in stack | Must be used for |
|---|---|---|
| `slim/slim` | HTTP kernel, routing, middleware composition | Route grouping, middleware ordering, error handling, and per-surface route mounts |
| `slim/psr7` | PSR-7 request/response primitives and uploaded files | Typed request/response handling and immutable response creation |
| `php-di/php-di` | DI container wiring and service factories | Centralized wiring for repositories/services/middleware; avoid manual global state lookups |
| `firebase/php-jwt` | JWT issuance/verification and JWKS compatibility | Token mint/verify, claim checks (`typ`, `exp`, `iss`, `aud`), and JWKS-oriented key validation |
| `ext-pdo` | Database access via prepared statements/transactions | Prepared statements, transaction scopes for auth+audit writes, and migration-safe DB interactions |
| `ext-sodium` | Argon2id hashing, random bytes, constant-time compare | Password/API-secret hashing (Argon2id), secure random generation, and constant-time comparisons |
| `respect/validation` | Request/schema validation rules | Composable route validators, nested payload schemas, hex32/enum constraints, and unified 422 detail mapping |
| `vlucas/phpdotenv` | Environment loading and startup validation | Layered env bootstrap, required-key checks, typed casting/validation at startup |
| `guzzlehttp/guzzle` | Outbound HTTP/JWKS/webhook integrations | Retry/timeout policy with middleware stack; later-phase external service integration |
| `neomerx/cors-psr7` | CORS policy processing | Origin/method/header policy enforcement without manual header branching |
| `monolog/monolog` | Structured logging and audit channels | Channelized security/audit/app logs, processors for request context, structured incident traces |
| `symfony/rate-limiter` | Rate-limiting policies and bucket enforcement | Bucket policies for auth/gateway/owner traffic with burst control and retry metadata |
| `symfony/cache` | Rate-limiter/cache persistence | Limiter state persistence, key metadata caching, and operational memoization |
| `phpunit/phpunit` | Unit/integration/contract testing | Contract tests, middleware behavior tests, auth lifecycle tests, and regression packs |

## Dependency policy
- Prefer these dependencies over custom replacements for the specified concerns.
- Any change to this baseline requires SSOT updates in: architecture, security, operations, and verification references.
- New dependencies must document: ownership, risk profile, test impact, and rollback strategy.
