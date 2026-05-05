# P4-UX1A Figma Principal Pages Detailed Specification

## Purpose
Provide a copy-ready, implementation-level UI specification for Figma Make to generate principal-specific key-minting and permission-management prototype pages, expanding `P4-UX1_PRINCIPAL_KEY_MINTING_AND_PERMISSION_UI_BLUEPRINT.md` into explicit form schemas, component contracts, validation rules, state logic, and interaction text.

## Canonical role mapping (MUST use canonical tokens in data fields)
- **Owner tab label** maps to canonical principal classes:
  - `ROOT_ADMIN` (platform scope), or
  - `TENANT_ADMIN` (tenant scope).
- **Primary Author Key Bearer tab label** maps to `IDENTITY_OPERATOR`.
- **Secondary Author Key Bearer tab label** maps to `DELEGATEE` (authoring envelope subset).
- **Use Key Bearer tab label** maps to:
  - `DELEGATEE` for human-use posture,
  - `UTILITY_AGENT` for registered automation posture.

> Figma labels MAY be human-readable, but hidden/internal metadata fields SHOULD preserve canonical tokens for prototype logic and future parity work.

## Global prototype frame structure
Top-level prototype page SHOULD contain:
1. **Header rail**
   - Tenant selector (read-only dropdown in prototype).
   - Principal class token chip (`ROOT_ADMIN`/`TENANT_ADMIN`/`IDENTITY_OPERATOR`/`DELEGATEE`/`UTILITY_AGENT`).
   - Lifecycle chip (`active`, `suspended`, `revoked`, `expired`).
   - Keychain depth indicator.
   - Last PDP reason chip.
2. **Principal tabs**
   - `Owner`
   - `Primary Author Key Bearer`
   - `Secondary Author Key Bearer`
   - `Use Key Bearer`
3. **Sub-nav for each principal tab**
   - `Home`
   - `ID Keypair Minting`
   - `Delegation & Permissions`
   - `Credentials Vault`
   - `Utility Keypair Minting`
4. **Global action footer**
   - `Save Draft`
   - `Run PDP Preflight`
   - `Submit`
   - `Cancel`

## Shared interaction model (all principal pages)
- Form sections SHOULD use stepper blocks with status markers: `Not Started` / `In Progress` / `Complete` / `Blocked`.
- Every permission toggle row MUST render 4 columns:
  1. `Direct Allow`
  2. `Delegated Allow`
  3. `Explicit Deny`
  4. `Effective State` (computed)
- Deny precedence banner MUST appear whenever `Explicit Deny = true` and any allow source is true.
- Preflight summary MUST display PDP gate order exactly:
  1. lifecycle state
  2. credential validity
  3. explicit deny
  4. scope match
  5. permission match
  6. delegation depth
  7. expiry window

## Page-level detailed spec

### A) Principal Home (per principal tab)
#### Layout
- Left column (280 px): identity card, trust tier, lifecycle badge, bound scope.
- Center column (fluid):
  - Authority Summary card.
  - Delegation Health card.
  - Credential Health card.
- Right column (320 px): policy/audit timeline list with reason code badges.

#### Authority Summary card schema
- `principal_token` (enum)
- `intrinsic_capability_count_allow` (int)
- `intrinsic_capability_count_conditional` (int)
- `intrinsic_capability_count_deny` (int)
- `top_denied_capabilities[]` (array<string>)

#### CTA enablement matrix
- `Mint ID Keypair` button enabled for Owner and Primary; disabled for Use; Secondary conditional.
- `Open Delegation Studio` enabled for Owner and Primary; Secondary conditional; Use disabled.
- `Mint Utility Keypair` enabled only if selected principal has >=1 active bound ID keypair.

### B) ID Keypair Minting form
#### Step 1: Subject and Scope
Fields:
- `subject_principal_id` (required, string)
- `subject_principal_class` (required enum)
- `scope_type` (required enum: platform|tenant|resource)
- `scope_id` (required when scope != platform)
Validation:
- Scope ownership mismatch => blocking error toast + inline red helper text.

#### Step 2: Key Material Options
Fields:
- `algorithm_profile` (required enum: ed25519|p256|rsa4096)
- `hardware_backed` (bool)
- `rotation_baseline_days` (int, min 1)
- `key_usage_profile` (enum: interactive|automation|mixed)

#### Step 3: Permission Envelope Baseline
Fields:
- `permissions_allow[]` (token multiselect)
- `permissions_deny[]` (token multiselect)
- `template_id` (optional string)
UI requirements:
- Show `Explicit Deny` control block above allow controls.
- Show warning if user adds token outside principal class baseline.

#### Step 4: Lifecycle Policy
Fields:
- `activation_at_utc` (datetime)
- `expires_at_utc` (datetime, MUST be after activation)
- `forced_rotation_cadence_days` (int)
- `usage_cap_per_day` (int)

#### Step 5: Review and Mint
- PDP preflight row list with pass/fail badges for each gate.
- On success show receipt card with:
  - `keypair_id`
  - `fingerprint`
  - `created_at_utc`
  - `lifecycle_state`
- Mandatory checkbox: `I acknowledge one-time secret handling` before `Finish` enabled.

### C) Delegation & Permissions studio
#### Regions
1. **Delegation Graph Canvas**
   - Nodes: Owner -> Primary -> Secondary -> Use.
   - Edge labels: depth + expiry + scope.
2. **Permission Matrix Table**
   - Rows from canonical token catalog.
   - Column freeze for token name + description.
3. **Envelope Composer Panel**
   - `delegatee_principal_id`
   - `ancestor_chain_ref`
   - `delegation_depth_cap`
   - `delegation_expiry_utc`
   - `scope_intersection_mode`

#### Lifecycle transitions block
Buttons: `Draft`, `Propose`, `Accept`, `Decline`, `Activate`, `Revoke`, `Expire`.
Each transition modal MUST contain:
- `transition_rationale` (required text area)
- `predicted_audit_event_code` (read-only)

#### Route impact preview
- Table columns:
  - `route_id`
  - `method`
  - `path`
  - `required_permission`
  - `new_effective_state`

### D) Credentials Vault
#### Tabs
- `ID Keypairs`
- `Utility Keypairs`
- `Revoked`
- `Expiring Soon`

#### Search/filter controls
- `credential_id`
- `principal_id`
- `scope_id`
- `permission_token`
- `lifecycle_state`

#### Row actions
- `Rotate`
- `Suspend`
- `Revoke`
- `Reactivate` (policy-conditional)
- `Export Attestation`
- `View Provenance`

### E) Utility Keypair Minting (bound)
#### Preconditions card
- Selected active parent ID keypair is required.
- Show `parent_keypair_id`, `parent_fingerprint`, inherited policy constraints.

#### Stepper
1. Service Identity:
   - `service_name`
   - `environment` (dev|staging|prod)
   - `workload_type` (batch|api|worker|agent)
2. Binding Contract:
   - `binding_mode` (strict|soft)
   - `revocation_coupling` (inherit|independent)
3. Operational Permissions:
   - route/permission picker grouped by domain
4. Security Controls:
   - `ip_allowlist[]`
   - `rate_limit_per_minute`
   - `secret_delivery_method` (sealed_file|kms_push|copy_once)
   - `rotate_on_deploy` (bool)
5. Review:
   - effective permission diff and deny precedence summary

## Principal-specific overrides

### Owner
- Full lineage graph visibility.
- Can set tenant-wide boundary caps and explicit denies.
- Can mint Primary Author roots directly.

### Primary Author Key Bearer
- Can mint Secondary and Use descendants within owner envelope.
- Can compose delegation envelopes for subordinate principals.
- Can mint bound Utility keypairs for governed workloads.

### Secondary Author Key Bearer
- Cannot mint Primary principals.
- Secondary->Secondary minting only when nested token/cap present.
- Elevated requests MUST route to amendment request modal.

### Use Key Bearer
- Human use variant focuses on consume/execute surfaces.
- Utility agent variant includes runtime automation permissions and rotation flows.
- No principal-class minting controls shown.

## Component library requirements for Figma Make
- Reusable components:
  - `TokenRow`
  - `GateCheckItem`
  - `LifecycleBadge`
  - `PrincipalPill`
  - `ReasonCodeBadge`
  - `RouteImpactRow`
- Variant states for each component: `default`, `hover`, `active`, `disabled`, `error`, `success`.
- Color semantics:
  - Allow = green
  - Conditional = amber
  - Deny = red
  - Unknown/blocked = gray

## Suggested Figma prototype page naming
- `P4-UX1 / Owner / Home`
- `P4-UX1 / Owner / ID Mint`
- `P4-UX1 / Owner / Delegation`
- `P4-UX1 / Owner / Vault`
- `P4-UX1 / Owner / Utility Mint`
- (repeat same 5 pages for Primary, Secondary, Use)

## Copy blocks for UI helper text
- **Deny precedence helper:** “Explicit deny overrides inherited and direct allows for the same token.”
- **Scope intersection helper:** “Effective grants are reduced to the overlap of actor, envelope, and route scope.”
- **Depth cap helper:** “Delegation hop budget is evaluated before expiry checks and after permission match.”

## Prototype acceptance checklist
- Tabs switch across all 4 principal personas.
- Each persona has all 5 sub-pages.
- Permission matrix renders per-principal effective states.
- PDP gate-order preview renders in canonical sequence.
- ID and Utility mint flows both produce receipt-style confirmation states.
- Vault supports lifecycle action affordances and provenance drawer drilldown.
