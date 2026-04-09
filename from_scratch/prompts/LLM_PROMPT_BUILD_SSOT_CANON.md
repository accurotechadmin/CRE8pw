# LLM Prompt: Build SSOT Canon

_Status: adopted_
_Last updated (UTC): 2026-04-08_

## Prompt purpose
Provide an internal prompting contract for agents that author or modify SSOT documents in this folder.

## Required agent behavior
- Prefer from-scratch canon files as primary targets.
- Use legacy SSOT/docs only as source material; normalize into this canon’s naming and structure.
- Do not leave scaffold language in adopted docs.
- Enforce intra-folder reference integrity.
- Always produce developer-actionable outputs (contracts, tables, commands, failure behavior).

## Prompt checklist
1. Identify impacted docs by capability.
2. Update machine artifacts if interface changes.
3. Update acceptance/verification/traceability artifacts.
4. Add or update decision log entry.
5. Update gaps/evidence docs as needed.
