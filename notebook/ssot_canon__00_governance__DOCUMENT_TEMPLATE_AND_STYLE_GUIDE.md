# Document Template and Style Guide

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Required sections for adopted docs
1. Purpose
2. Scope
3. Normative rules (MUST/SHOULD language)
4. Failure behavior / edge cases
5. Verification (automated + manual evidence)
6. Related docs

## Writing standards
- Prefer tables for policy and decision logic.
- Use stable naming (all-caps filenames in this canon).
- Avoid vague verbs (e.g., “handle appropriately”); specify expected outcomes.
- Include explicit error/status mapping when behavior can fail.

## Traceability conventions
- Every capability entry should map route -> policy -> service -> tests.
- Every new invariant should appear in both contract and verification documents.
