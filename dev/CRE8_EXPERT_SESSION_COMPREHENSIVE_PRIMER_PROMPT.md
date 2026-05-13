# CRE8 Expert Session Comprehensive Primer Prompt

Use this prompt as the **first message** in a fresh expert coding LLM session when you need deep repository fluency before implementation work.

---

You are entering the CRE8 repository. Before proposing architecture changes or writing production code, you must become thoroughly acquainted with the CRE8 ethos, SSOT corpus, machine contracts, governance rules, and active continuity records.

## Mission

Read and internalize the complete onboarding sequence defined in:

- `dev/CRE8_ONBOARDING_COMPREHENSIVE_READING_LIST.md`

You must process that list in order, and treat it as mandatory orientation. Keep working notes concise, structured, and reference-driven.

## Required behavior

1. **Read in sequence, phase by phase.**
2. Distinguish clearly between:
   - normative canonical sources (`docs/` + governance precedence),
   - seed ethos/provenance (`seed/`),
   - informational continuity artifacts (`reports/`, `dev/implementation/`) unless explicitly promoted.
3. Build a compact internal map of:
   - system architecture boundaries,
   - identity/delegation/policy semantics,
   - API prose + OpenAPI/schema parity points,
   - security/crypto controls and data model constraints,
   - operations/release gates and verification hooks,
   - extensibility seams and ADR tradeoffs.
4. Preserve and cite requirement IDs, hook IDs, and doc IDs when discussing behavior.
5. When implementing or proposing changes, always cross-check the relevant docs from the reading list and cite them explicitly.
6. Treat contradictions as merge-blocking until reconciled according to governance docs.

## Session startup output (before any coding)

After reading, produce:

1. **Canonical source hierarchy summary** (what is authoritative and why).  
2. **Architecture summary** (major components, flows, constraints, and invariants).  
3. **Policy and contract summary** (authz order, deny precedence, route/contract obligations, envelope/error rules).  
4. **Security + operations summary** (crypto lifecycle, controls, threat/abuse posture, release/verification gates).  
5. **Traceability and evidence summary** (requirement→hook→evidence model, ADR/risk linkage).  
6. **Implementation readiness checklist** for the current task with explicit document references.

Do not start implementation until this startup output is complete.

## Ongoing rule

Throughout the session, refer back to the documents in `dev/CRE8_ONBOARDING_COMPREHENSIVE_READING_LIST.md` whenever making design or code decisions. If a decision touches behavior, ensure proposed changes remain SSOT-consistent and traceability-ready.

