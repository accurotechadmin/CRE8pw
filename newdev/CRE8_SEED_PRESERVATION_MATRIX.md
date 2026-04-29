# CRE8 Seed Preservation Matrix (Legacy Canon -> `/newdev`)

This document records which legacy CRE8 truths are preserved, redesigned, or intentionally dropped in the new seed canon.

## 1) Preserved and re-anchored concepts
- Dual-surface runtime model (public/bootstrap, gateway, console) is preserved and restated with parity constraints.
- PDP/middleware-first authorization remains mandatory.
- Delegation subset/depth/expiry/lifecycle bounds remain mandatory.
- Envelope-first contract and deterministic error semantics remain mandatory.
- Immutable provenance/audit emissions remain mandatory for security-significant operations.
- Keychain aggregation and audience-targeted access behavior are preserved as platform capabilities.

## 2) Mandatory redesign concepts now canonical
- Primary Author, Secondary Author, and Use Keys MUST mint with initial ID Keypairs.
- Utility Keypairs are minted from ID-key lineage for context/service/app/device isolation.
- Identity anchor keys (ID) and externally shared proxy keys (Utility) are now explicit separate classes.
- Delegation/gov specs MUST be interpreted through ID-key lineage and utility-key operational usage.

## 3) Intentionally dropped or constrained legacy assumptions
- Any legacy assumption of non-keypair key issuance for delegated actors is dropped.
- Any handler-local authorization branching pattern is dropped; PDP outcome is authoritative.
- Any surface-crossing auth-context interchangeability assumption is dropped.
- Any extension pattern that bypasses provenance events or deterministic deny semantics is dropped.

## 4) Open follow-up authoring items (next phase)
- Formal permission vocabulary tables and delegation decision matrices for new keypair model terms.
- Canonical lifecycle state machine diagrams for ID and Utility key classes.
- Concrete API route catalog + examples for keypair issuance, rotation, and revocation.
- Data lineage schema for key ancestry, utility context labels, and audit-event joins.
