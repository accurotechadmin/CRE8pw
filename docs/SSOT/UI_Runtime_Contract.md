# UI Runtime Contract (SSOT Appendix)

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## Purpose
Capture implementation-grade SPA runtime conventions that are required to deliver consistent UI/API parity behavior in the no-build UI model.

## Session and device persistence contract
- Session storage key: `cre8_ui_session_v1`
- Device ID storage key: `cre8_ui_device_id_v1`
- Session model includes explicit `activeSurface` and per-surface tokens/context.
- Gateway calls requiring device policy attach persisted device ID in `X-Device-Id`.

## API client behavior contract
- Envelope-aware JSON parsing for all routes.
- Normalized error object containing status/code/message/details/request_id.
- Resolve `request_id` from response header and/or envelope.
- Expose envelope version for diagnostics where available.

## Route-state runtime model
Canonical required states:
- `idle`
- `loading`
- `submitting`
- `success`
- `validation_error`
- `forbidden`
- `not_found`
- `server_error`

Optional substates (implementation convenience):
- `validating`
- `empty`

## Diagnostics UX minimums
- Request inspector or equivalent diagnostics panel must expose:
  - status code,
  - request_id,
  - parsed envelope payload.
- Error-state screens must preserve request_id visibility for support triage.

## Security/UX guardrails
- Owner routes must bind to owner session context.
- Gateway routes must bind to key session context + device header policy.
- UI pre-checks may reduce avoidable forbidden submissions but backend remains source-of-truth.

## Accessibility/runtime baseline
- Keyboard-navigable route transitions.
- Focus management after major state transitions.
- Explicit route-state visibility for async/error flows.

## Related SSOT docs
- `UI_Parity_and_Contract.md`
- `UI_Parity_Contract.md`
- `UI_Contract_Artifacts_Reference.md`
- `Error_Code_Catalog.md`
