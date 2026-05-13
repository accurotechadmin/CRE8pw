# Cross-Document Consistency Matrix

| concept | product_spec | architecture | data_model | api | ui_ux | implementation | testing | security | operations | status | notes |
|---|---|---|---|---|---|---|---|---|---|---|---|
| Scope lock doctrine (ethos + dependency baseline) | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | consistent | Startup checks executed and recorded in scope-lock register. |
| Fresh export-root contract (`/fresh`) | aligned | aligned | n/a | n/a | n/a | aligned | aligned | n/a | aligned | consistent | `/fresh/seed-generating-docs` subtree created for deterministic export packaging. |
| Seed-to-implementation coupling (SC-1..SC-6) | aligned | aligned | n/a | aligned | aligned | aligned | aligned | aligned | aligned | consistent | Current session selected slices improve implementation continuity and readiness signaling. |

| Startup authority hierarchy (onboarding→SSOT→continuity→milestones) | aligned | aligned | n/a | aligned | n/a | aligned | aligned | aligned | aligned | consistent | Startup sequence artifacts were re-inventoried and mapped in preservation ledger rows CPL-005..CPL-008. |

| Continuity pointer integrity (LATEST -> concrete handoff file) | aligned | aligned | n/a | n/a | n/a | aligned | aligned | aligned | aligned | consistent | Source inventory now explicitly includes concrete latest handoff source (SRC-010) to reduce resume ambiguity. |
| Source inventory QA completeness (M1.5) | aligned | aligned | n/a | aligned | n/a | aligned | aligned | aligned | aligned | consistent | Added SRC-011 and corrected inventory table structure to keep continuity authority chain deterministic. |


| M1.6/M2.6 coverage audit anchors (ethos + dependencies + surfaces) | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | consistent | Added canonical source anchors SRC-012..SRC-014 and preservation rows CPL-011..CPL-013 to support full-corpus audit progression. |
| `/fresh` output contract vs required in-place governance artifact updates | aligned | aligned | n/a | aligned | n/a | aligned | aligned | aligned | aligned | consistent | Conflict CONF-002 resolved by DEC-002: net-new docs under `/fresh`, required continuity/governance artifacts updated in place. |
| Generation determinism (M6 hardening) | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | consistent | `30_llm_generation_instructions.md` now encodes rerun protocol, trace chain, and scope-lock checks for fresh-session reproducibility. |
