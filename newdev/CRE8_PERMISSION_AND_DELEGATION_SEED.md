# CRE8 Permission and Delegation Seed

CRE8 permissioning is hierarchical and bounded. Owner-created Primary Author Keys inherit only the envelope granted by the Owner. Primary Author Keys may mint Secondary Author and Use Keys, but may only delegate permissions they were permitted to grant. Secondary Author Keys may mint Use Keys within their bounded subset and may only pass through delegation capabilities explicitly allowed by their ancestor chain.

This lattice must be represented as composable policy modules so developers can add new permission families and account/key classes without rewriting core authorization machinery. PDP/middleware remains authoritative, and every delegation mutation must be provenance-recorded with deterministic allow/deny semantics.
