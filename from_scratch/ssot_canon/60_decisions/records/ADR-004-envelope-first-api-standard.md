# ADR-004: Envelope-first API response standard

_Status: adopted_
_Date: 2026-04-09_

## Context
Inconsistent API payload structures increased frontend and observability complexity.

## Decision
All API/console/public JSON responses use canonical success/error envelopes with stable metadata and request correlation.

## Consequences
- Clients can use uniform parsing/error handling.
- Observability and support workflows rely on stable `request_id` and metadata fields.

## Verification implications
Contract tests must validate envelope shape and metadata presence for positive and negative paths.
