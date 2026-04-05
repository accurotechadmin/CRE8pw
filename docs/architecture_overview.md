# Architecture Overview (Scaffold)

_Last updated (UTC): 2026-04-05_
_Status: Scaffold++_

## Purpose

Explain subsystem boundaries, trust zones, runtime composition, and extension seams.

## 1) C4-style structure (to complete)

### 1.1 System context

- Actors: owner operators, delegated key clients, platform maintainers.
- External dependencies: SQL database, environment/secret provisioning, optional logging backends.

### 1.2 Container view

- Browser SPA (`public/ui`)
- PHP API runtime (Slim app + middleware + services)
- Data store (principals, credentials, token families, posts/comments, audit events)

### 1.3 Component view (backend)

- Bootstrap/config
- Middleware pipeline
- Route registration
- Application services
- Security primitives
- Observability

## 2) Trust boundaries and surfaces

- **Public/auth** surface
- **Gateway** surface (key + device constrained)
- **Console** surface (owner constrained)

Document which middleware and policy checks enforce each boundary.

## 3) Design principles (working draft)

- Policy-first runtime configuration.
- Explicit layered middleware over implicit handler checks.
- Uniform API envelope contract.
- Fail-closed posture for security-critical paths.
- Test contracts as behavior lock.

## 4) Extensibility blueprint

### 4.1 Add a new bounded context

Template:

1. Add `src/Application/<Domain>/...Service.php`
2. Register in container.
3. Expose route(s) in registrar.
4. Add middleware/policy constraints.
5. Add contract and security tests.
6. Add docs sections + glossary terms.

### 4.2 Introduce optional plugin integrations

Potential plugin seams:

- alternate `AuditEmitter`
- alternate token signing backend (KMS/HSM adapter)
- external identity bridge

## 5) Diagrams TODO

- [ ] Context diagram
- [ ] Request sequence diagram
- [ ] Service dependency map
- [ ] Trust boundary diagram
