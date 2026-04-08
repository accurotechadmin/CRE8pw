# Dependency Baseline

_Status: draft_
_Last updated (UTC): 2026-04-08_
Canonical terminology: ../10_product_and_architecture/CANONICAL_TERMINOLOGY.md

## Purpose
Record mandatory runtime and test dependencies for CRE8 implementation consistency.

## Scope
Root runtime (`composer.json`) and rebuild scaffold (`code/composer.json`) baselines.

## Normative statements
- Runtime MUST stay on PHP 8.2 and Slim 4 stack unless canon change is approved.
- Security primitives MUST include `firebase/php-jwt` and `ext-sodium`.
- Verification stack MUST include PHPUnit and SSOT automation commands.

## Interfaces / contracts
| Dependency | Purpose | Source |
|---|---|---|
| slim/slim + slim/psr7 | HTTP runtime | root composer |
| php-di/php-di | DI container wiring | root composer |
| firebase/php-jwt | token signing/verification | root composer |
| symfony/rate-limiter + cache | throttling | root composer |
| phpunit/phpunit | tests | root + code composer |

## Failure/rejection semantics
- Dependency upgrades without contract impact review SHOULD be rejected.
- Missing required package in lock/runtime MUST block release.

## Verification requirements
- `composer validate --strict` and platform checks in QA pipeline.
- Dependency-to-contract mapping reviewed per release.

## Traceability hooks
- Code refs: `composer.json`, `code/composer.json`
- Tests refs: `tests/Contract/ComposerScriptsContractTest.php`
- Related SSOT docs: `../40_operations_and_quality/VERIFICATION_STRATEGY.md`, `../30_data_and_security/SECURITY_CONTROLS_SPEC.md`

## Open questions / known gaps
- Root composer lacks SSOT automation commands that exist in `/code` scaffold.
