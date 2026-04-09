# ADR-005: Release gating via verification + smoke + readiness controls

_Status: adopted_
_Date: 2026-04-09_

## Context
Passing unit tests alone was insufficient to ensure production readiness and operational confidence.

## Decision
Release requires verification suites, operational smoke checks, and readiness gate evidence aligned with SSOT contracts.

## Consequences
- Releases become evidence-driven and auditable.
- Gate failures block release until remediated.

## Verification implications
Release artifacts must include command output, timestamps, and gate status in evidence templates.
