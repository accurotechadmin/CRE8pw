# Instructor Follow-Up Lecture: Extending CRE8 in a Third-Party Product

_Status: teaching-ready_
_Audience: instructors teaching applied platform extension, integration architecture, and product customization_
_Prerequisite: `docs/04_instructional_notes/INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md`_
_Duration options: 120 minutes workshop or 2 x 75-minute sessions_
_Last updated (UTC): 2026-04-22_

---

## 1) Workshop Intent and Framing

### 1.1 Why this follow-up exists
This follow-up moves students from **understanding CRE8** to **actively extending CRE8** as a platform core in a third-party application.

The exercise posture is:
- You are not rewriting CRE8.
- You are building a product on top of CRE8 contracts, policy model, and operations discipline.
- Every extension must remain SSOT-compatible (contracts, policy semantics, traceability, and release evidence).

### 1.2 Scenario narrative (use throughout)
Students operate as a third-party team building **“StudioHub”**, a collaborative creator product that uses CRE8 as its governance and delegated-content engine.

StudioHub needs:
- branded UI paths,
- product-specific content taxonomy,
- additional moderation workflows,
- analytics events for creator engagement,
- custom integration adapters (notifications/webhooks/search indexing),
- policy additions that do not violate delegation invariants.

### 1.3 Outcomes
By the end of this workshop, students can:
1. Identify all high-impact extensibility seams in CRE8.
2. Implement a safe extension plan for each seam.
3. Propose contract and data changes with compatibility discipline.
4. Build release-ready evidence for extension delivery.

---

## 2) Extensibility Map (Teach This First)

Use this as the canonical extension inventory for classroom exercises.

## 2.1 Interface and contract seams
- OpenAPI route additions and examples.
- Envelope-compatible error extension through stable `details.code` catalog updates.
- UI parity expansion (`/ui/*` mapping and runtime contract alignment).

## 2.2 Policy and authorization seams
- New permission verbs under delegation subset constraints.
- Scope model specialization for third-party domain entities.
- Additional owner governance decisions (console-only authority paths).

## 2.3 Data-model seams
- Product-specific metadata entities linked to posts/comments/actors.
- Audit and moderation lineage extension.
- Index additions for new access patterns at scale.

## 2.4 Runtime and middleware seams
- New validation and abuse guards (without order violations).
- Extension-specific rate-limiting profiles.
- Additional correlation fields and telemetry propagation.

## 2.5 Operations and delivery seams
- New observability event families.
- SLO/SLI expansion for extension-specific routes.
- Release gate updates, smoke checks, and rollback strategy.

---

## 3) Workshop Structure (Suggested 120-Min Plan)

1. **15 min** — Platform extension mindset + anti-patterns.
2. **20 min** — Extensibility seam walkthrough (contracts/policy/data/ops).
3. **55 min** — Hands-on labs (five extension tracks).
4. **20 min** — Group architecture review and risk challenge.
5. **10 min** — Evidence-and-release readiness checkpoint.

---

## 4) Active Build Labs: One Lab per Extensible Area

## Lab A — Contract Extensions (API + UI parity)

### Goal
Add a third-party feature route family for StudioHub collections while preserving CRE8 contract standards.

### Example extension set
- `GET /api/collections`
- `POST /api/collections`
- `GET /api/collections/{collectionId}`
- `POST /api/posts/{postId}/collections/{collectionId}`

### Student tasks
1. Update OpenAPI route definitions and response envelopes.
2. Add route inventory entries with auth context and policy notes.
3. Add endpoint examples and error code additions.
4. Add UI parity references for each route.

### Instructor checks
- No envelope shape drift.
- Error detail codes remain stable and explicit.
- Route documentation, examples, and UI parity are all synchronized.

### Discussion prompts
- “What would break if you added route behavior without error catalog updates?”
- “How do you keep client compatibility while introducing new response fields?”

---

## Lab B — Delegation/Policy Extensions

### Goal
Introduce a new delegated permission for collection curation without enabling privilege escalation.

### Example permission additions
- `collection.create`
- `collection.attach_post`
- `collection.manage_visibility`

### Student tasks
1. Extend policy tables with permission semantics and actor constraints.
2. Define scope boundaries (e.g., workspace/project/team scoping).
3. Prove subset/depth/expiry compatibility with existing delegation envelopes.
4. Add acceptance criteria for allow/deny edge cases.

### Instructor checks
- Permission model is table-driven, not handler-specific.
- Use-key mutation restrictions still hold.
- Denial reasons map to canonical failure contracts.

### Discussion prompts
- “What is the minimum permission set needed for non-escalating curation?”
- “Where do developers commonly leak owner-only powers into delegated flows?”

---

## Lab C — Data Model Extensions

### Goal
Add third-party entities that customize CRE8 while preserving auditability and lifecycle semantics.

### Example schema additions
- `collections` (owner-governed container)
- `collection_memberships` (optional delegation-aware contribution model)
- `post_collection_links` (many-to-many linkage)
- Optional: `collection_moderation_actions`

### Student tasks
1. Propose table contracts, keys, states, and retention model.
2. Define compatibility with existing `posts`, `principals`, moderation, and audit trails.
3. Update ERD/data reference artifacts and traceability anchors.
4. Define migration and rollback plan.

### Instructor checks
- Lifecycle fields (`status`, `expires_at`, soft-delete markers) are explicit.
- Foreign key constraints align with principal and content invariants.
- Traceability artifacts are updated in the same change set.

### Discussion prompts
- “Which data rows must be retained for incident reconstruction?”
- “How do indexes change when collection queries dominate feed behavior?”

---

## Lab D — Runtime/Middleware Extensions

### Goal
Inject extension-specific runtime rules without breaking normative middleware ordering.

### Example runtime extension
- Add collection-specific validation guard.
- Add anti-spam throttling profile for collection mutations.
- Extend correlation context with `workspace_id` when present.

### Student tasks
1. Place new checks at correct middleware or handler boundary.
2. Define request/response and failure behavior.
3. Ensure device/auth/policy checks are still evaluated in canonical order.
4. Add tests for negative paths and abuse cases.

### Instructor checks
- Middleware ordering constraints are unchanged unless formally reviewed.
- Extension logic does not bypass canonical authz or envelope mapping.
- Abuse controls are measurable and testable.

### Discussion prompts
- “Should extension validation run before or after policy evaluation, and why?”
- “What telemetry is needed to tune throttling without harming legitimate users?”

---

## Lab E — Observability + Operations Extensions

### Goal
Operationalize the third-party extension so it is release-gated and supportable.

### Example operations additions
- New event families: `collection.created`, `collection.linked_post`, `collection.visibility_changed`.
- SLI additions: collection mutation success rate, p95 resolve latency.
- Smoke checks for collection lifecycle CRUD and policy denials.

### Student tasks
1. Add event catalog entries with required dimensions.
2. Define SLO/SLI targets and alert thresholds.
3. Extend release checklist and production readiness gates.
4. Produce release evidence template output for the extension.

### Instructor checks
- Events include correlation fields and actor context.
- SLOs are measurable and tied to user-facing reliability.
- Release artifacts prove extension behavior, not just happy-path execution.

### Discussion prompts
- “Which extension failures are most dangerous if dashboards are missing?”
- “What smoke check would best detect policy regression after deployment?”

---

## 5) Integration Track: Turning Labs into a Cohesive Product

After Labs A–E, run a synthesis review where each team presents:
1. Product intent for extension feature set.
2. Contract delta summary.
3. Policy safety proof (no escalation).
4. Data integrity + migration approach.
5. Operational readiness and rollback plan.

Instructor challenge questions:
- “Show one place where your extension could drift from SSOT and how you prevent it.”
- “If your new route receives malformed scope, what exact failure contract is returned?”
- “How do you prove your extension is reversible during incident response?”

---

## 6) Anti-Patterns to Highlight Explicitly

1. **Handler-embedded policy drift**
   - Smell: route handlers contain custom authorization branches not represented in policy tables.
2. **Contract-only updates without examples/error alignment**
   - Smell: OpenAPI changed but endpoint examples and error catalog remain stale.
3. **Schema additions without lifecycle and retention strategy**
   - Smell: new table has no status/retention/audit intent.
4. **Observability afterthought**
   - Smell: extension routes ship without event schema and SLO ownership.
5. **Release gate bypass pressure**
   - Smell: “just deploy and observe” replaces production readiness evidence.

---

## 7) Discussion Forum Companion (Async)

Post these prompts in the lecture forum after class:
- “Which extension seam is most fragile under schedule pressure, and what guardrail protects it?”
- “What does ‘platform-compatible customization’ mean in your own architecture words?”
- “Where should third-party product logic stop and CRE8 core governance begin?”
- “How do you detect and remediate extension-driven policy drift over time?”
- “What is your minimum release evidence packet for a new route family?”

Optional peer-review rubric for forum replies:
- Specificity to SSOT artifacts,
- Policy and security reasoning quality,
- Operational realism,
- Backward compatibility awareness.

---

## 8) Evaluation Rubric for Extension Projects

Score each category 0–4:
1. **Contract integrity** (OpenAPI/envelopes/errors/examples parity)
2. **Policy safety** (delegation constraints, no escalation)
3. **Data correctness** (schema integrity, lifecycle semantics, migration discipline)
4. **Runtime correctness** (middleware/order/failure mapping fidelity)
5. **Operational readiness** (events/SLI-SLO/smoke/release evidence)
6. **Traceability completeness** (all canonical docs updated coherently)

Suggested thresholds:
- 21–24: production-ready extension
- 17–20: strong, with targeted hardening required
- 13–16: partial viability, governance gaps present
- <=12: redesign recommended before delivery

---

## 9) Instructor Delivery Assets

## 9.1 Whiteboard templates
- Extensibility seam map (contracts/policy/data/runtime/ops).
- Route-to-policy matrix for one extension family.
- Release evidence checklist with owner assignments.

## 9.2 Slide outline (10 slides)
1. From core platform to third-party product
2. Extension seams and invariants
3. Contract extension workflow
4. Policy extension workflow
5. Data extension workflow
6. Runtime/middleware extension workflow
7. Observability and release readiness
8. Anti-patterns and risk controls
9. Team synthesis presentation format
10. Forum prompts and next-step assignments

## 9.3 Homework options
- Write an extension RFC for a new domain feature.
- Produce full change-impact map across SSOT artifacts.
- Define a rollback playbook for failed extension deployment.

---

## 10) References (Canonical Anchors)

Use these during workshop facilitation and review:
- `docs/04_instructional_notes/INSTRUCTOR_LECTURE_NOTES_BUILDING_CRE8.md`
- `docs/ssot_canon/10_product_and_architecture/ARCHITECTURE_AND_SURFACES.md`
- `docs/ssot_canon/10_product_and_architecture/REQUEST_PIPELINE_AND_MIDDLEWARE_CONTRACT.md`
- `docs/ssot_canon/20_contracts/API_CONTRACT_GUIDE.md`
- `docs/ssot_canon/20_contracts/ROUTE_INVENTORY_REFERENCE.md`
- `docs/ssot_canon/20_contracts/ERROR_CODE_CATALOG.md`
- `docs/ssot_canon/30_data_and_security/DATA_MODEL_SPEC.md`
- `docs/ssot_canon/40_operations_and_quality/OBSERVABILITY_EVENT_CATALOG.md`
- `docs/ssot_canon/40_operations_and_quality/PRODUCTION_READINESS_GATES.md`
- `docs/ssot_canon/50_traceability_and_automation/TRACEABILITY_MATRIX.md`
- `docs/ssot_canon/70_implementation_guidance/MIGRATION_AND_COMPATIBILITY_STRATEGY.md`

When students propose extension behavior, require them to cite which canonical anchor governs that behavior.
