# Documentation Roadmap & Backlog (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Track maturation of this docs set from scaffolds to authoritative references.

## Milestone plan

| Milestone | Goal | Exit criteria | Target owner |
|---|---|---|---|
| M1 | Architecture + lifecycle completion | diagrams + source links + verification steps | platform |
| M2 | API + data model completion | full endpoint/entity tables + examples | backend |
| M3 | Security + config completion | threat matrix + full env catalog + hardening notes | security/platform |
| M4 | Ops + observability completion | runbooks tested in stage | ops |
| M5 | Contribution + glossary completion | contributor onboarding runnable from docs alone | eng lead |

## Backlog buckets

### B1: Source-cited reference completion

- [ ] Convert each scaffold table into concrete values.
- [ ] Link each behavior statement to tests.
- [ ] Add explicit “known limitations” where applicable.

### B2: Diagramming and navigability

- [ ] Add architecture and sequence diagrams.
- [ ] Add per-doc “quick links” and breadcrumbs.
- [ ] Add index tags for searchability.

### B3: Extensibility playbooks

- [ ] New endpoint family playbook.
- [ ] New auth model/provider playbook.
- [ ] New observability backend playbook.
- [ ] New UI module/page playbook.

## Review cadence

- Weekly: backlog grooming and status updates.
- Per release: verify docs changes match shipped behavior.
- Quarterly: docs debt review and archival cleanup.
