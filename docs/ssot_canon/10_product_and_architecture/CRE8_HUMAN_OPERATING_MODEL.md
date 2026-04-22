# CRE8 Human Operating Model

_Status: adopted_
_Last updated (UTC): 2026-04-22_

Canonical terminology: `docs/ssot_canon/10_product_and_architecture/CANONICAL_TERMINOLOGY.md`

## Purpose
Explain CRE8 in human-accessible terms for product owners, implementation leads, and non-specialist contributors while preserving SSOT contract rigor.

## What CRE8 is
CRE8 is a standalone application platform for credentialing, authentication, and authorization with production-grade governance controls. Teams can adopt it as a secure user-management and content-protection core, then customize or extend domain behavior on top.

## Practical adoption profiles
1. **Owner-first profile (simpler rollout)**
   - Use owner registration/login and console governance first.
   - Keep delegated key routes available for internal use or later rollout.
2. **Delegated platform profile (full capability)**
   - Expose gateway routes for key-based API consumers.
   - Operate owner console for key issuance, moderation, lifecycle controls, and invite governance.

## Human actor model
- **Owners** govern policy, key issuance, moderation, lifecycle actions, and invitation flow.
- **Primary/secondary/use keys** perform delegated actions according to bounded envelopes.
- **Keychains** aggregate member permissions under explicit constraints for collaborative access.
- **Non-owner participants** can use key credentials without registering username/email/password, when enabled by deployment policy.

## End-user simplicity promise
CRE8 is designed so most users only need to present valid credentials. The system then deterministically returns permitted content/actions or clear policy-deny outcomes with stable error semantics.

## Why invitation-gated owner bootstrap matters by default
Owner bootstrap defaults to invite-code gating so deployments can keep governance private by default and integrate naturally with approval/payment-gated business flows. Open owner signup is optional and must be enabled explicitly in configuration.

## Related SSOT docs
- `docs/ssot_canon/10_product_and_architecture/CRE8_PRODUCT_AND_SYSTEM_SPEC.md`
- `docs/ssot_canon/20_contracts/AUTHORIZATION_AND_DELEGATION_SPEC.md`
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
- `docs/ssot_canon/40_operations_and_quality/CONFIGURATION_ENVIRONMENT_CONTRACT.md`
- `docs/ssot_canon/70_implementation_guidance/EXTENSIBILITY_PLAYBOOK.md`
