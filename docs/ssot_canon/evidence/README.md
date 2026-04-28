# Evidence Package Guide

_Status: adopted_
_Last updated (UTC): 2026-04-22_

## Purpose
Define the evidence minimum required for SSOT-impacting changes.

## Required evidence types
- Command output (tests, smoke, QA checks).
- Contract diff summary (OpenAPI/schema/route or policy tables).
- Operational impact notes (alerts/SLO/readiness implications).
- Risk and rollback considerations.

## Storage convention
Store evidence artifacts in PR descriptions and linked build artifacts using the templates in `templates/`.


## Historical evidence handling
- Historical evidence artifacts must be explicitly labeled `historical_record`.
- Historical artifacts are retained for audit trace and MUST NOT be used for current readiness/status evaluation.
