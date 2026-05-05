# P4-UX1 Principal Key Minting and Permission UI Blueprint

## Purpose
This document describes the mature CRE8 product UI pages for principal-scoped key minting, permission assignment, delegation options, ID keypair receipt, and Utility keypair minting bound to ID keypairs.

## Canonical principal mapping (UI labels -> policy tokens)
- Owner label maps to `ROOT_ADMIN` at platform scope or `TENANT_ADMIN` at tenant scope.
- Primary Author label maps to `IDENTITY_OPERATOR`.
- Secondary Author label maps to `DELEGATEE` unless the actor is a registered automation process.
- Use label maps to `DELEGATEE` for human execution or `UTILITY_AGENT` for registered automation execution.

## Global IA and navigation
The mature experience is a five-surface flow with persistent contextual rails:
1. **Principal Home** (identity + authority posture)
2. **ID Keypair Minting** (authoritative identity credentials)
3. **Delegation & Permission Studio** (envelopes, scope, deny/allow controls)
4. **Issued Credentials Vault** (delivery, acknowledgment, lifecycle operations)
5. **Utility Keypair Minting** (service credentials cryptographically tied to an ID keypair)

A top status bar displays tenant, principal type token, lifecycle state, active keychain depth, and last PDP decision reason for recent actions.

## Page 1: Principal Home
### Layout
- Left rail: principal profile, trust tier, lifecycle badge (`active`, `suspended`, `revoked`, etc.).
- Main column cards:
  - **Authority Summary**: canonical capabilities granted/denied by principal type.
  - **Delegation Health**: active delegates, pending envelopes, expiring grants.
  - **Credential Health**: active ID keypairs, active Utility keypairs, revocation alerts.
- Right rail: audit/event timeline with policy reasons and error-code badges.

### Primary actions
- “Mint ID Keypair” (enabled only for principals with issuance capability).
- “Open Delegation Studio” (enabled for principals with delegation capabilities).
- “Mint Utility Keypair” (enabled only after an active bound ID keypair exists).

## Page 2: ID Keypair Minting
### Stepper flow
1. **Subject and Scope**
   - Select subject principal and scope boundary (platform/tenant/resource).
   - UI validates scope ownership and warns on boundary mismatches.
2. **Key Material Options**
   - Algorithm profile, key strength, hardware-backed option, rotation baseline.
3. **Permission Envelope Baseline**
   - Pre-populated canonical permission set by principal type.
   - Explicit deny toggles surfaced separately above allow toggles.
4. **Lifecycle Policy**
   - Expiry window, activation delay, forced-rotation cadence, usage caps.
5. **Review and Mint**
   - PDP preflight summary rendered in canonical gate order.

### Output/receipt experience
- Success panel includes:
  - `keypair_id`, fingerprint, created-at timestamp, lifecycle state.
  - Download options for sealed package, copy-once secret, and custody transfer QR.
  - “Acknowledge Receipt” checkpoint before leaving page.

## Page 3: Delegation & Permission Studio
### Core regions
- **Delegation Graph Canvas**: Owner -> Primary -> Secondary -> Use lineage graph.
- **Permission Matrix Table**:
  - Rows: canonical permissions.
  - Columns: direct allow, delegated allow, explicit deny, inherited effective state.
- **Envelope Composer**:
  - Select delegatee, ancestor chain, depth cap, scope boundary, expiry, constraints.

### Safety and policy UX
- Gate-order preview panel shows pass/fail for each PDP gate.
- Deny precedence banner explains winning signal when conflicts exist.
- Route-impact preview lists impacted route IDs and required_permission metadata.

### State transitions
- Envelope lifecycle actions: draft -> proposed -> accepted/declined -> active -> expired/revoked.
- Every transition requires rationale note and emits an audit event preview.

## Page 4: Issued Credentials Vault
### Inventory UX
- Tabbed views: ID Keypairs / Utility Keypairs / Revoked / Expiring Soon.
- Search by key ID, principal, scope, route family, permission token.
- Visual badges for lifecycle status and policy-risk flags.

### Actions per credential
- Rotate, revoke, suspend, reactivate (where policy permits).
- Export attestations and signed metadata.
- Open provenance drawer: minting actor, delegation chain ref, decision reason code.

## Page 5: Utility Keypair Minting (bound to ID keypair)
### Preconditions panel
- Requires a selected active ID keypair under caller authority.
- Shows cryptographic binding target fingerprint and policy constraints inherited from ID keypair.

### Minting wizard
1. **Service Identity**: name, environment, workload type.
2. **Binding Contract**: choose parent ID keypair, binding mode, revocation coupling.
3. **Operational Permissions**: route/action scopes for runtime automation.
4. **Security Controls**: IP allowlist, rate ceilings, secret delivery method, rotate-on-deploy option.
5. **Review**: effective permissions after inheritance + explicit denies.

### Post-mint outputs
- Utility keypair credentials shown once with mandatory secure acknowledgment.
- Linked card on parent ID keypair page showing descendant utility credentials.
- “Test Authorization” button runs dry-run PDP checks for selected route/action tuples.

## Principal-specific mature journeys
### Owner (`ROOT_ADMIN` / `TENANT_ADMIN`)
- Can mint top-level ID keypairs and define tenant-wide delegation boundaries.
- Sees full graph and can enforce explicit denies that override lower-level grants.

### Primary Author (`IDENTITY_OPERATOR`)
- Mints subordinate ID keypairs within owner-defined boundaries.
- Creates delegation envelopes for Secondary/Use principals.
- Mints Utility keypairs for approved workloads tied to owned ID keypairs.

### Secondary Author (`DELEGATEE`)
- Receives delegated ID authority and can mint only within delegated scope/depth.
- Can request (not force) elevated permissions via envelope amendment workflow.

### Use (`DELEGATEE` or `UTILITY_AGENT`)
- Human use principals primarily consume already-issued credentials and execute actions.
- Registered utility agents mint/rotate utility credentials only when granted automation rights.

## Cross-page system behaviors in mature state
- Every submit path performs PDP preflight with deterministic deny-reason mapping.
- UI error surfaces show canonical error code, reason class, and remediation hint.
- OpenAPI route metadata parity checker powers route-impact hints in real time.
- Audit timeline unifies lifecycle, delegation, and authz events with correlation IDs.

## Non-functional UX characteristics
- Accessibility: WCAG AA contrast, full keyboard stepper navigation, screen-reader labels.
- Security: one-time secret reveal, anti-copy watermarks, signed export manifests.
- Reliability: optimistic UI only for non-authoritative drafts; authoritative actions wait for persisted confirmation.
- Explainability: each allow/deny cell has “why” popover with policy-source citation.

## Suggested implementation sequencing
1. Deliver Principal Home + ID Keypair Minting MVP with canonical principal mapping and receipt acknowledgment.
2. Add Delegation Studio with envelope lifecycle + deny precedence visualization.
3. Add Credentials Vault lifecycle operations + provenance drawer.
4. Add Utility Minting workflow with binding contract and dry-run PDP testing.
5. Add cross-page parity/audit enhancements and operator-quality dashboards.
