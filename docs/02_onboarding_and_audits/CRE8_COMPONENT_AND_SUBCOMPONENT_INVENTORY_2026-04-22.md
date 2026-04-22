# CRE8 Component and Sub-component Inventory (2026-04-22)

_Status: analysis artifact_
_Date (UTC): 2026-04-22_
_Purpose: exhaustive, SSOT-grounded component inventory for product/architecture/planning onboarding._

---

## 1) System-level component map

### 1.1 Product surfaces
1. **Public/platform surface**
   - Service banner (`/`)
   - Health endpoint (`/health`)
   - JWKS publication (`/.well-known/jwks.json`)
   - UI shell/static fallback (`/ui/{route}`)
2. **Authentication/bootstrap surface**
   - Owner signup (`/console/owners`)
   - Owner login (`/api/auth/login`)
   - Key login (`/api/auth/key-login`)
   - Token refresh (`/api/auth/refresh`)
3. **Gateway surface (`/api/*`)**
   - Feed listing
   - Post create/read/edit/flag
   - Comment list/create
4. **Console owner surface (`/console/api/*`)**
   - Console posts list/create
   - Keychain list/create/member add/remove/resolve
   - Invite creation
   - Key issuance
   - Key lifecycle transitions
   - Post/comment moderation

### 1.2 Runtime architecture layers
1. **Ingress + routing layer**
2. **Middleware pipeline layer**
3. **Policy enforcement layer (authN/authZ/delegation/keychain)**
4. **Domain application/service layer**
5. **Persistence/data model layer**
6. **Observability/audit/event layer**
7. **Operational control layer (health, smoke, startup, readiness)**
8. **Governance/traceability/evidence layer**

---

## 2) Request lifecycle component inventory

### 2.1 Middleware-order components
1. **Request context + correlation**
   - Request ID generation/propagation
   - Correlation plumbed through envelope + events/logs
2. **Security perimeter middleware**
   - Security headers and CSP policy
   - CORS policy enforcement
   - Content-type normalization
3. **Authentication components**
   - Bearer token parsing/validation
   - Session/type/lifecycle checks (owner vs key)
4. **Authorization/delegation components**
   - Permission allow-list evaluator
   - Scope evaluator
   - Delegation envelope validator
   - Device-policy guard where required
5. **Input/rate protection components**
   - Shape/content validation middleware
   - Endpoint sensitivity-aware rate limiting
6. **Handler execution components**
   - Route handler
   - Service orchestration
7. **Response normalization components**
   - Success envelope responder
   - Error mapper + detail-code mapping
   - Envelope metadata injection (`meta.envelope_version`, timestamps)

### 2.2 Failure-path components
1. Unauthorized handling (401)
2. Forbidden/policy denial handling (403)
3. Validation failures (422)
4. Conflict/state violations (409)
5. Not found precision (404)
6. Rate-limit rejection (429)
7. Internal failure handling (5xx with canonical error envelope)

---

## 3) Contract model components

### 3.1 Machine contract artifacts (highest precedence)
1. **OpenAPI contract** (`docs/ssot_canon/openapi/cre8.v1.yaml`)
2. **Success envelope schema** (`success-envelope.schema.json`)
3. **Error envelope schema** (`error-envelope.schema.json`)

### 3.2 Contract governance artifacts
1. API contract guide
2. Route inventory reference
3. Error code catalog
4. Endpoint examples (all routes)
5. UI runtime contract
6. Usage scenarios and permission stories

### 3.3 Envelope sub-components
1. **Success envelope**
   - `data`
   - `meta` (must include `envelope_version`; optional timestamp/extra metadata)
2. **Error envelope**
   - `error.code`
   - `error.message`
   - `error.details` (extensible)
   - `error.request_id` (required)
   - `meta.envelope_version`

### 3.4 API group components (route families)
1. Public/platform routes
2. Auth routes
3. Gateway content routes
4. Console owner governance routes

---

## 4) Identity, authorization, and delegation component inventory

### 4.1 Principal model components
1. **Owner principal**
2. **Key principal** subclasses
   - `primary_author`
   - `secondary_author`
   - `use`
   - `keychain`

### 4.2 AuthN components
1. Credential verification (owner)
2. Credential verification (key)
3. JWT signing/verification
4. Claim validation (issuer/audience/timing/type)
5. Refresh-token family rotation + replay invalidation
6. JWKS publication and overlap handling

### 4.3 AuthZ components
1. Permission vocabulary and allow-list evaluator
2. Scope evaluator
3. Surface-aware authority boundaries (gateway vs console)
4. Status/lifecycle deny paths (revoked/suspended/cancelled)

### 4.4 Delegation components
1. Issuance authority checks
2. Subset-only permission constraint
3. Subset-only scope constraint
4. Maximum depth enforcement
5. Expiry enforcement
6. Lineage preservation requirements
7. Envelope integrity checks

### 4.5 Key lifecycle components
1. Mint authority by actor class
2. Key status transitions
3. Transition authorization checks
4. Cascade/invalidation effects

### 4.6 Keychain policy components
1. Keychain creation governance
2. Membership admission rules
3. No keychain nesting invariant
4. Member class constraints
5. Membership size bounds
6. Effective permission/scope resolution
7. Effective snapshot materialization
8. Resolve endpoint output behavior

---

## 5) Data model component inventory

### 5.1 Identity/auth tables
1. `principals`
2. `principal_emails`
3. `credentials`
4. `token_families`

### 5.2 Delegation/lifecycle tables
1. `delegation_envelopes`
2. key lifecycle-related fields and transitions
3. invite/receipt tracking entities

### 5.3 Keychain tables
1. keychain entity
2. membership mapping table
3. effective snapshot table

### 5.4 Content/moderation tables
1. `posts`
2. post revisions
3. `comments`
4. flags
5. moderation actions

### 5.5 Auditability tables/events
1. auditable policy decisions/events
2. actor and request-correlation capture fields

### 5.6 Data integrity sub-components
1. FK constraints across principal/content entities
2. Uniqueness constraints for membership and identity relations
3. Indexes supporting lifecycle/status/lookup efficiency
4. Transaction boundaries for sensitive lifecycle and issuance operations

---

## 6) Security component inventory

### 6.1 Preventive controls
1. JWT claim + signature verification
2. Delegation envelope bounds enforcement
3. CSRF protections (console write routes)
4. Device-binding guard enforcement (gateway where required)
5. Rate limiting and abuse throttling
6. Security headers and CSP
7. Secret and key-material handling controls

### 6.2 Detective controls
1. Structured event emission per catalog
2. Request-to-event correlation (`request_id`)
3. Redacted logging policy
4. Alerting from SLI/SLO + abuse signals

### 6.3 Verification controls
1. Threat-to-test mapping
2. Abuse-case matrix automation
3. Header/CSP regression tests
4. Replay and forgery negative-path tests
5. Redaction verification checks

### 6.4 Threat model component coverage
1. Replay attacks
2. Delegation escalation
3. CSRF and cross-origin misuse
4. Key tampering and unauthorized lifecycle mutation
5. Flood/resource exhaustion
6. Sensitive data leakage via logs/errors

---

## 7) Operations and quality component inventory

### 7.1 Configuration/startup components
1. Typed environment parsing and validation
2. Profile-aware hardening rules
3. Fail-closed startup assertions
4. Startup evidence output contract

### 7.2 Health/smoke components
1. Health contract and subsystem state model
2. Health smoke command(s)
3. Migration smoke command(s)
4. Startup contract checks

### 7.3 Observability components
1. Event catalog families
2. Structured logs with redaction
3. Trace/correlation propagation
4. Dashboard and alert ownership assignments

### 7.4 Reliability components
1. SLI definitions
2. SLO targets
3. Error budget signaling
4. p95/p99 latency accountability

### 7.5 Quality/test architecture components
1. Unit tests
2. Integration tests
3. Contract tests (OpenAPI + envelope schema conformance)
4. End-to-end tests
5. Abuse/security tests
6. Acceptance matrix coverage

### 7.6 Release-readiness components
1. Production readiness gates
2. Release checklist
3. Evidence package templates
4. Gate approval and signoff records

---

## 8) Governance and program component inventory

### 8.1 SSOT governance components
1. SSOT index and canonical folder taxonomy
2. Document status/ownership matrix
3. Change control classes and remediation rules
4. Documentation template/style constraints

### 8.2 Traceability/automation components
1. Traceability matrix
2. SSOT lint/sync/report automation
3. Change-impact map templates
4. Prototype-to-SSOT delta map

### 8.3 Decision governance components
1. ADR index
2. Decisions log
3. ADR records (001–005 active)
4. Decision record template

### 8.4 Program controls
1. Contribution workflow
2. Definition of Done
3. Risk register
4. Roadmap and milestones
5. Key hierarchy analysis tasks (coherence/master/scale)

---

## 9) Execution-plan component inventory (delivery architecture)

### 9.1 Stage components
1. **Stage 0:** program initialization and delivery operating system
2. **Stage 1:** runtime and platform foundation
3. **Stage 2:** data platform and migration backbone
4. **Stage 3:** identity/authentication/token lifecycle
5. **Stage 4:** authorization/delegation/keychain policy engine
6. **Stage 5:** API surface implementation
7. **Stage 6:** frontend/UI contract parity
8. **Stage 7:** security hardening and abuse closure
9. **Stage 8:** quality engineering and reliability
10. **Stage 9:** operations/release engineering/production readiness
11. **Stage 10:** launch/stabilization/continuous evolution

### 9.2 Universal gate components
1. Gate A — Foundation complete
2. Gate B — Core platform complete
3. Gate C — Product surface complete
4. Gate D — Secure and reliable
5. Gate E — Production ready
6. Gate F — Sustainably operating

### 9.3 Cross-stage non-negotiable components
1. Evidence required for every slice
2. Same-PR SSOT synchronization for contract/security/data/ops changes
3. Risk-register capture for unresolved assumptions
4. Gate blocking on missing evidence/critical defects/SSOT drift
5. Class D emergency-change remediation path

---

## 10) Snapshot reality annotation (important)

### Facts in this repository snapshot (2026-04-22)
1. SSOT/governance/contracts/operations/program artifacts are present and mature.
2. Runtime implementation directories `src/`, `tests/`, `scripts/` are absent.
3. Therefore, this inventory describes the **authoritative target system and delivery architecture**, not a claim of runtime completion.

### Practical interpretation
- Use this inventory as the canonical decomposition model for planning and implementation sequencing.
- For execution claims, require slice-level and gate-level evidence per the execution and readiness artifacts.

