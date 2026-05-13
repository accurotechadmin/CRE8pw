# Cross-Document Consistency Matrix

| concept | product_spec | architecture | data_model | api | ui_ux | implementation | testing | security | operations | status | notes |
|---|---|---|---|---|---|---|---|---|---|---|---|
| Scope lock doctrine (ethos + dependency baseline) | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | aligned | consistent | Startup checks executed and recorded in scope-lock register. |
| Fresh export-root contract (`/fresh`) | aligned | aligned | n/a | n/a | n/a | aligned | aligned | n/a | aligned | consistent | `/fresh/seed-generating-docs` subtree created for deterministic export packaging. |
| Seed-to-implementation coupling (SC-1..SC-6) | aligned | aligned | n/a | aligned | aligned | aligned | aligned | aligned | aligned | consistent | Current session selected slices improve implementation continuity and readiness signaling. |
