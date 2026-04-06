# CRE8 UI Endpoint Contract — Executive Decisions and Expansion Plan

_Last updated (UTC): 2026-04-06_

_Status: adopted_
_Date authored (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## 1) Purpose of this document

This document formalizes executive decisions for improving the UI endpoint contract and resolves ambiguity around `ui/endpoints_unified.json`.

It also defines additional backend endpoints that should be exposed via HTML/UI routes to improve functional parity and operator/developer usability.

---

## 2) What `ui/endpoints_unified.json` is

`ui/endpoints_unified.json` is a consolidated contract artifact that combines:

- global envelope and UI state expectations,
- endpoint/page metadata,
- sprint planning groupings,
- a flattened page index used for implementation tracking.

It is not runtime code; it is a source contract/planning object intended to drive UI coverage against backend endpoint behavior.

---

## 3) Executive decisions

### Decision A — Keep a single canonical page shape

**Decision:** Top-level `pages[]` becomes the canonical machine-consumed source. `sprints[].pages[]` is deprecated as a generated projection only.

**Why:** Current dual-shape duplication increases drift risk and validation complexity.

**Consequence:**
- New automation should validate only canonical `pages[]`.
- Sprint grouping may still be retained, but should reference `page_id` only.

### Decision B — Normalize metadata key names

**Decision:** Use `figma_data` consistently in all page entries.

**Why:** Current mixed usage (`figma_data_attributes` in sprint sections vs `figma_data` in canonical pages) is inconsistent.

**Consequence:**
- Any generators/consumers should map legacy `figma_data_attributes` to `figma_data`.
- v2.1 contract should remove the legacy key.

### Decision C — Canonical route-state model for frontend parity

**Decision:** Canonical route states for production parity are:

- `idle`
- `loading`
- `submitting`
- `success`
- `validation_error`
- `forbidden`
- `not_found`
- `server_error`

`validating` and `empty` may be optional local UI substates but are not required parity states in the core contract.

### Decision D — Add provenance and compatibility metadata

**Decision:** Future contract revisions should include:

- `contract_version`
- `generated_from_commit`
- `generated_by`
- `last_validated_utc`
- `compatibility` (breaking/non-breaking notes)

**Why:** make source-of-truth status and downstream compatibility explicit.

### Decision E — Expand HTML/UI endpoint parity beyond the current 18

**Decision:** Add first-class UI coverage for the four backend endpoints currently missing dedicated pages:

1. `GET /`
2. `GET /health`
3. `GET /.well-known/jwks.json`
4. `POST /api/auth/refresh`

**Why:** These endpoints are operationally and developer-significant, and parity UX should include session maintenance and diagnostics paths.

---

## 4) Additional endpoint-to-UI mappings (new)

The following additions follow existing CRE8 UI conventions: explicit states, request-id visibility, envelope-aware messaging, and minimal/no-surprise UX.

### 4.1 Service banner/status

- **New page_id:** `public_status_root_v1`
- **UI route:** `/status`
- **Method:** `GET`
- **Persona:** `operator`, `developer`
- **Purpose:** Quick service reachability/status check from browser UI.
- **API calls:**
  - `GET /`
- **Success UX:**
  - show service banner payload in structured panel,
  - show last checked timestamp,
  - link to deeper health and JWKS pages.
- **Error UX:**
  - `server_error` panel with retry action.

### 4.2 Deep health inspection

- **New page_id:** `public_health_probe_v1`
- **UI route:** `/health`
- **Method:** `GET`
- **Persona:** `operator`
- **Purpose:** Display subsystem probe status (DB/rate limiter/key material/issuer dependency summary).
- **API calls:**
  - `GET /health`
- **Success UX:**
  - subsystem cards with pass/fail indicators,
  - request ID and response timing metadata.
- **Error UX:**
  - map non-2xx to `server_error` with envelope detail display,
  - preserve latest successful probe snapshot until refresh.

### 4.3 JWKS visibility for integrators

- **New page_id:** `public_jwks_view_v1`
- **UI route:** `/jwks`
- **Method:** `GET`
- **Persona:** `developer`, `security_reviewer`
- **Purpose:** Render active JWKS set for token-verification integration checks.
- **API calls:**
  - `GET /.well-known/jwks.json`
- **Success UX:**
  - pretty-print key set,
  - copy-to-clipboard for JSON payload,
  - lightweight notes on `kid`/alg/use fields.
- **Error UX:**
  - envelope-aware fallback panel with retry.

### 4.4 Session refresh control plane

- **New page_id:** `auth_refresh_session_v1`
- **UI route:** `/session/refresh`
- **Method:** `POST` (trigger from page action button)
- **Persona:** `owner_admin`, `key_operator`
- **Purpose:** Explicitly refresh current active session and visualize token lifecycle outcome.
- **API calls:**
  - `POST /api/auth/refresh`
- **Request body:**
  - `refresh_token` (required)
- **Success UX:**
  - rotate stored tokens,
  - show new expiry countdown,
  - return to prior route context.
- **Error UX:**
  - `401`: clear active session + route to corresponding login,
  - `422`: field-level refresh token validation,
  - `forbidden/server_error`: generic retry panel with request ID.

---

## 5) Suggested canonical schema delta (v2.1)

Recommended canonical page fields:

- `page_id`
- `sprint`
- `url`
- `method`
- `persona`
- `purpose`
- `required_fields`
- `api_calls`
- `success_ux`
- `error_ux`
- `figma_data`
- `friendly_ui_description`
- `acceptance_criteria`
- `route_states` (optional override; defaults to canonical state set)

And top-level metadata:

- `spec_version`
- `contract_version`
- `generated_at_utc`
- `generated_from_commit`
- `generated_by`
- `last_validated_utc`
- `global_contracts`
- `pages`
- `index`

---

## 6) Rollout sequence

1. Introduce v2.1 contract writer that emits canonical `pages[]` and index.
2. Keep legacy compatibility reader for `sprints[].pages[]` for one release.
3. Add four new UI routes/pages and wire endpoint calls.
4. Update endpoint inventory and QA matrix to 22 covered interactions.
5. Remove legacy compatibility reader in next breaking contract cycle.

---

## 7) Final determination

- `ui/endpoints_unified.json` is still relevant and should remain.
- It should be treated as a contract asset, then refactored to a stricter canonical shape.
- CRE8 should expose four additional backend endpoints in HTML/UI to complete practical parity for operations and session lifecycle.
