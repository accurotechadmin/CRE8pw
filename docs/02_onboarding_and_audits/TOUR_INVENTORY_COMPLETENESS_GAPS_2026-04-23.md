# TOUR Inventory Completeness Gaps (2026-04-23)

_Status: analysis artifact_
_Date (UTC): 2026-04-23_

## Scope
Gap list for:
- `CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.md`
- `CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.json`

## Required updates for completeness
1. Add missing files currently excluded from the extraction scope:
   - `docs/02_onboarding_and_audits/CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.md`
   - `docs/02_onboarding_and_audits/CRE8_TOURS_CONCEPT_DECISION_COMPONENT_PURPOSE_RELATIONSHIP_INVENTORY_2026-04-23.json`
   - `docs/02_onboarding_and_audits/ARTIFACT_EXPLANATION_2026-04-23_ONBOARDING_INVENTORY_SET.md`
2. Regenerate extraction metadata to align with current repository state:
   - Update `documents_scanned` in markdown and `documents_scanned_count` in JSON.
   - Update generation timestamp and anchor fields if regeneration occurs.
3. Refresh extraction content for `ONBOARDING_ANALYSIS_2026-04-23_STAFF_ENGINEER_WORKING_MODEL.md` because the file was significantly expanded after current TOUR extraction pass.
4. Include root `README.md` in extraction scope if the goal is strict “nothing excluded” repository completeness.
5. Normalize malformed/backtick-broken extracted items (examples in current markdown TOUR output):
   - ``/health` reliability``
   - ``X-Device-Id` malformed``
   - ``X-Device-Id` missing``
   - `Gateway route has JWT `device_id` claim matching `X-Device-Id``
6. De-duplicate low-signal extraction fragments that appear to be table boilerplate (e.g., isolated terms like `Field`, `Module`, `Document family`, `Notes`) unless explicitly desired by inventory policy.
7. Add extraction policy notes (or schema fields) distinguishing:
   - canonical contract terms,
   - analysis-only derived terms,
   - template/boilerplate tokens,
   so downstream users can filter reliably.
8. Add stable source-location granularity to each evidence snippet (start/end line) rather than free-form line mentions only.
9. Add `status`/`superseded_by` metadata for extracted items that originate from historical or superseded records to reduce false-authority risk.
10. Add explicit precedence tier tagging for each source document reference (machine contract vs SSOT canon vs governance vs analysis) to support conflict resolution in downstream tooling.
