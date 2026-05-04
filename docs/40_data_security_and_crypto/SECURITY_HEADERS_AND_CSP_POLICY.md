---
doc_id: CRE8-SEC-HEADERS-CSP
version: 1.0.0
status: normative
owner: Security WG
reviewers:
  - Platform Architecture WG
last_reviewed_utc: 2026-04-30
next_review_due_utc: 2026-05-30
source_seed_refs:
  - seed/CRE8_SURFACES_AND_CLIENT_PARITY_SEED.md
normative_dependencies:
  - docs/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md
  - docs/40_data_security_and_crypto/SECURITY_CONTROLS_SPEC.md
  - docs/80_traceability_decisions_and_program/TRACEABILITY_MATRIX.md
---
# Security Headers and CSP Policy

## Normative requirements
- **CRE8-SECX-REQ-0005**: API responses **MUST** emit `Strict-Transport-Security`, `X-Content-Type-Options`, and `X-Frame-Options` headers.
- **CRE8-SECX-REQ-0006**: Browser-rendered surfaces **MUST** emit a CSP that defaults to `default-src 'self'` and uses nonce-based script exceptions only.
- **CRE8-SECX-REQ-0007**: CSP violation reports **MUST** be routed to an auditable endpoint/event channel.
- **CRE8-SECX-REQ-0025**: The runtime middleware pipeline **MUST** inject security headers before response emission, and this stage **MUST** remain ordered before envelope/error rendering as defined in `REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md` so all success and error responses include required header posture.
- **CRE8-SECX-REQ-0026**: `owner_console` CSP enforcement **MUST** include deterministic deny/error behavior mapping for blocked script sources, and violation outcomes **MUST** resolve to canonical API/system deny families documented in `API_CONTRACT_GUIDE.md` and `ERROR_CODE_CATALOG.md` for parity testing.

## Surface policy matrix
| surface | required_headers | csp_profile |
|---|---|---|
| owner_console | HSTS, XCTO, XFO, Referrer-Policy | strict-ui |
| partner_gateway | HSTS, XCTO | api-minimal |
| public_meta | HSTS, XCTO | none |

## Implementation binding
- `neomerx/cors-psr7` and Slim middleware ordering govern header injection for HTTP responses.

## Change Impact Map
- `reports/change_impact_maps/20260430-0740-P3-S7.4-P3-S7.5-P3-S7.6.md`

## See also
- [Security Controls Spec](./SECURITY_CONTROLS_SPEC.md)
- [Architecture and Surfaces](../10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md)
- [Request Pipeline and Middleware Contract](../10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md)
- [Api Contract Guide](../30_contracts_and_interfaces/API_CONTRACT_GUIDE.md)
- [Error Code Catalog](../30_contracts_and_interfaces/ERROR_CODE_CATALOG.md)
