# Tracking Task: Key Type Spec Coherence

_Status: adopted_
_Last updated (UTC): 2026-04-22_
_Tracking ID: TASK-KEY-SPEC-002_

## Task type
Specification task

## Objective
Ensure each active key type (`primary_author`, `secondary_author`, `use`, `keychain`) has a robust, well-scoped, and internally coherent specification with explicit lifecycle, permissions, delegation bounds, and validation semantics.

## Required outputs
1. Per-key-type section inventory with ownership and missing-spec gap list.
2. Consolidated normative glossary for key-class semantics.
3. Cross-reference matrix connecting authz rules, data model fields, API route enforcement, and verification suites.
4. Remediation PR sequence proposal for unresolved gaps.

## Exit criteria
- All key classes have explicit normative spec references in SSOT docs.
- No unresolved key-type ambiguity remains in the active risk/task register and release evidence reviews.
