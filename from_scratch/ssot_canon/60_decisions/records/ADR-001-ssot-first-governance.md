# ADR-001: SSOT-first contract governance model

_Status: adopted_
_Date: 2026-04-09_

## Context
Historically, behavioral truth was split across prose docs and implementation assumptions.

## Decision
Machine artifacts (`openapi/cre8.v1.yaml`, envelope schemas) are precedence tier 1, with contract/security docs tier 2.

## Consequences
- Contract changes must be synchronized in one PR across machine + prose artifacts.
- Drift checks become merge-blocking in CI.

## Verification implications
Run docs lint/sync checks and contract tests for every SSOT-impacting PR.
