# API Contract (SSOT)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## Purpose
This file is the contract entrypoint for CRE8 API behavior in the production SSOT set.

## Canonical contract artifacts
- Human guide: `API_Contract_Guide.md`
- Machine contract: `openapi/cre8.v1.yaml`
- Envelope schemas: `schemas/success-envelope.schema.json`, `schemas/error-envelope.schema.json`
- Endpoint examples: `Endpoint_Examples_All_Routes.md`
- Error mapping: `Error_Code_Catalog.md`

## Contract precedence
1. `openapi/cre8.v1.yaml` + JSON schemas are normative for machine validation.
2. `API_Contract_Guide.md` is normative for implementation interpretation.
3. `Endpoint_Examples_All_Routes.md` is normative for envelope shape and semantics.

## Stability rules
- Every route change must update OpenAPI and affected SSOT docs in the same PR.
- Every new error/detail code must be added to `Error_Code_Catalog.md`.
- Envelope shape remains `data/meta` (success) and `error/meta` (failure) across all surfaces.
