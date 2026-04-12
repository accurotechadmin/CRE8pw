# 04 Data Security

_Documentary script chunks following the recommended reading order._

## Chapter 20: `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`

In Chapter 20, "Data Model Spec (Production)" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`. The document frames how this layer operates through Table contracts, principals, principal_emails, credentials. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "This schema-level contract is implemented through `ext-pdo` prepared statements and transactional writes (see `DEPENDENCY_BASELINE.md`).". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 21: `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`

In Chapter 21, "Data Model Reference (SSOT)" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/30_data_and_security/DATA_MODEL_REFERENCE.md`. The document frames how this layer operates through Storage strategy, Core entity groups, Lifecycle invariants, Transaction boundaries (required). This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, this chapter is presented as connective tissue: it translates policy into executable behavior and turns implementation facts into auditable evidence.

## Chapter 22: `docs/ssot_canon/30_data_and_security/ERD.md`

In Chapter 22, "ERD (Text + Mermaid)" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/30_data_and_security/ERD.md`. The document frames how this layer operates through Notes. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "erDiagram PRINCIPALS ||--o{ PRINCIPAL_EMAILS : has PRINCIPALS ||--o{ CREDENTIALS : has PRINCIPALS ||--o{ TOKEN_FAMILIES : owns PRINCIPALS ||--o{ POSTS : authors PRINCIPALS ||--o{ COMMENTS : writes PRINCIPALS ||--o{ DELEGATION_ENVELOPES : issued_or_parent PRINC". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 23: `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`

In Chapter 23, "Security Controls Spec" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/30_data_and_security/SECURITY_CONTROLS_SPEC.md`. The document frames how this layer operates through Control objectives, Trust boundaries, Control baseline, Dependency mapping. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "1. Ensure credential authenticity and bounded token lifetime. 2. Prevent unauthorized mutation/actions via layered claim/policy checks. 3. Preserve operational traceability with redacted structured logs.". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 24: `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md`

In Chapter 24, "Security Threat Model" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/30_data_and_security/SECURITY_THREAT_MODEL.md`. The document frames how this layer operates through Threat scenarios, Mitigations, Dependency linkage. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "1. Stolen bearer token replay. 2. Refresh token replay in family. 3. Delegation escalation via over-scoped child key. 4. CSRF on console write routes. 5. Key file tampering/world-writable private keys. 6. Abuse via request flooding.". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 25: `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md`

In Chapter 25, "Security Headers and CSP Policy (SSOT)" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/30_data_and_security/SECURITY_HEADERS_AND_CSP_POLICY.md`. The document frames how this layer operates through Purpose, Required default security headers, Path-aware CSP contract, Enforcement requirements. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "Define the mandatory HTTP security header baseline and path-aware Content Security Policy behavior for CRE8 surfaces.". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

## Chapter 26: `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`

In Chapter 26, "Security Verification and Abuse Cases (SSOT)" becomes a camera move across one specific CRE8 layer: `docs/ssot_canon/30_data_and_security/SECURITY_VERIFICATION_ABUSE_CASES.md`. The document frames how this layer operates through Purpose, Abuse-case matrix (minimum required), Security test-pack requirements, Incident-response verification hooks. This chapter is treated as a system node that either feeds standards downward into implementation or pulls evidence upward into governance.

The sub-components in this chapter are interpreted as operational actors—owners, interfaces, data shapes, runtime behaviors, and release gates—that must synchronize with adjacent chapters to keep CRE8 coherent end-to-end. When this chapter defines constraints, other chapters inherit them; when it defines outputs, downstream contracts, tests, and evidence artifacts consume them.

Narratively, the document opens with context like: "Expand security verification from high-level controls into explicit abuse-case test requirements and incident-ready verification evidence.". That framing is used as the voice-over baseline for explaining why the chapter exists and what coupling points it introduces into the wider platform story.

