# CRE8 API Contract and Error Determinism Seed

CRE8 MUST preserve an envelope-first HTTP contract and deterministic error semantics while implementing the new ID-keypair-first model.

## 1) Envelope invariants
- Success responses MUST use a stable success envelope (`data`, `meta`).
- Error responses MUST use a stable error envelope (`error`, `meta`) with correlation-ready request identity.
- Contract changes MUST be versioned; additive evolution is preferred over breaking changes.

## 2) Deterministic deny mapping
- PDP/middleware authorization outcomes MUST map to deterministic HTTP status + error/detail codes.
- Handlers MUST NOT override or remap canonical PDP deny outcomes.
- Equivalent policy violations across surfaces MUST preserve semantically equivalent denial behavior, while respecting surface-specific obligations.

## 3) Protected-surface obligations
- Console governance routes MUST enforce owner-context requirements.
- Gateway key-bearer routes MUST enforce key-context requirements, including proof validation and configured binding obligations.
- Public/bootstrap/auth routes MUST remain isolated from privileged route families.

## 4) Parity and traceability
- Every supported API action MUST have a UI parity path (first-party or owner-facing).
- Contract edits MUST update canonical route/action inventories, examples, and verification artifacts in lockstep.
- Runtime responses and audit/provenance emissions MUST share correlation identifiers to support end-to-end incident reconstruction.
