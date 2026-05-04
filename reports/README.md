# `reports/` — Program Records and Session Artifact Workspace

`reports/` is the repository’s operational record area for planning, execution logs, handoffs, session responses, and generated SSOT metrics.

## Normative status

Content in `reports/` is generally **informational/non-normative** unless explicitly promoted through governance-controlled processes documented in `docs/00_governance/`.

## Folder overview

| Path | Purpose |
|---|---|
| `session_handoffs/` | Structured handoff files, progress boards, blockers, and latest-session pointer |
| `session_responses/` | Verbatim final response archives from authoring sessions |
| `session_prompts/` | Stored prompt records and execution prompt variants |
| `ssot/` | Generated SSOT outputs (e.g., coverage JSON) |
| `change_impact_maps/` | Change-impact artifacts for significant contract/spec changes |
| `phase4/` | Historical phase-specific reports and completion artifacts |

## Common top-level artifacts

This folder also includes phase plans, acceptance memos, audits, and repo study reports used for program continuity and governance context.

## Session continuity model

A complete session record usually consists of:

1. `session_handoffs/SESSION_HANDOFF_<UTC>.md`
2. `session_responses/<UTC>_RESPONSE.md`
3. Any updated progress board entries
4. Any generated artifacts referenced by the session

`session_handoffs/LATEST_SESSION_HANDOFF.md` is the quickest way to resume the latest workstream.

## Hygiene expectations

- Keep filenames UTC-sortable (`YYYYMMDD-HHMM`).
- Maintain pairing between handoff and response archives.
- Treat historical session records as append-only.
- Do not commit secrets or production credentials.


## Reference updates

- Master index: `../master_index.md`
- Seed-intro attribute crosswalk (synthesized): `session_responses/20260504-EXPAND_SEED_INTRO_ATTRIBUTE_MAP.md`

## Related references

- Project root orientation: `../README.md`
- Canonical docs index: `../docs/README.md`
- Session response archive details: `session_responses/README.md`
- Verification strategy: `../docs/60_operations_quality_and_release/VERIFICATION_STRATEGY.md`
