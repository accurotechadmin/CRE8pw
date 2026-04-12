# 02 Product Architecture

_Documentary script chunks following the recommended reading order._

## Chapter 5: `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`

In Chapter 5, "CRE8 Product and System Spec" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`. The document frames how this layer operates through Product scope, System capabilities (v1), Core system constraints, Out-of-scope (v1). This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "Deliver a delegated-authorship platform with owner-governed moderation and lifecycle control, exposed through public, gateway, and console surfaces.". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 6: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

In Chapter 6, "Canonical Terminology" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`. The document frames how this layer operates through Principal terms, Security terms, Contract terms. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, this chapter is presented as connective tissue: it translates policy into executable behavior and turns implementation facts into auditable evidence.

## Chapter 7: `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`

In Chapter 7, "Architecture and Surfaces" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`. The document frames how this layer operates through Architectural model, Layering, Boundary rules. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "1. HTTP ingress + middleware pipeline 2. Route handlers (surface-scoped) 3. Domain services (auth, keys, keychains, content, moderation) 4. Persistence layer (transactional data model) 5. Observability + audit emissions". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 8: `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`

In Chapter 8, "Request Pipeline and Middleware Contract" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`. The document frames how this layer operates through Authoritative middleware order, Contract rules, Failure mapping baseline. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "1. Request ID/correlation injection 2. Security headers / CSP policy 3. CORS / content-type normalization 4. Surface-specific authn/authz guards 5. Validation guards 6. Rate limiting / abuse controls 7. Route handler execution 8. Envelope responder + error map". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 9: `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`

In Chapter 9, "Dependency Baseline" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/10_product_and_architecture/DEPENDENCY_BASELINE.md`. The document frames how this layer operates through Baseline dependency families, Dependency governance rules, Runtime expectations, Canonical package baseline (root `composer.json`). This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, this chapter is presented as connective tissue: it translates policy into executable behavior and turns implementation facts into auditable evidence.

