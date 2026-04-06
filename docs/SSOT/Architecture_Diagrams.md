# Architecture Diagrams

_Status: adopted_
_Last updated (UTC): 2026-04-06_

Canonical terminology: `Canonical_Terminology_Dictionary.md`

## 1) C4-style Context Diagram
```mermaid
flowchart LR
  User[Owner / Key User] --> UI[/public/ui SPA/]
  Integrator[External Client] --> API[(CRE8 Slim API + PSR-7)]
  UI --> API
  API --> DB[(PDO-backed DB)]
  API --> Keys[(JWT Key Material)]
  API --> Logs[(Structured Audit/Logs)]
```

## 2) Component Diagram
```mermaid
flowchart TB
  Entry[public/index.php] --> Boot[BootChecks + RuntimeConfig + ContainerFactory]
  Boot --> App[Slim AppFactory]
  App --> MW[Global + Surface Middleware]
  MW --> Routes[RouteRegistrar]
  Routes --> Services[Application Services]
  Services --> Security[JWT / KeyMaterial / Hashing]
  Services --> Storage[PDO tables]
  Services --> Obs[AuditEmitter]
```

## 3) Request Sequence (gateway write)
```mermaid
sequenceDiagram
  participant C as Client
  participant M as Middleware Stack
  participant R as Route Handler
  participant S as Domain Service
  participant D as DB
  C->>M: POST /api/posts
  M->>M: request-id, headers, cors, rate-limit, validation, json, routing, key-jwt, device, use-key
  M->>R: dispatch
  R->>S: createPost(...)
  S->>D: insert + policy checks
  D-->>S: persisted row
  S-->>R: result
  R-->>C: envelope response
```

## 4) Token refresh sequence
```mermaid
sequenceDiagram
  participant C as Client
  participant A as Auth Route
  participant T as Token Service
  participant D as token_families
  C->>A: POST /api/auth/refresh
  A->>T: verify refresh token + nonce
  T->>D: rotate family nonce/hash
  D-->>T: updated
  T-->>A: new access+refresh
  A-->>C: 200 envelope
```

## 5) Key lifecycle sequence
```mermaid
sequenceDiagram
  participant O as Owner
  participant API as /console/api/keys/{id}/lifecycle
  participant K as KeyLifecycleService
  participant D as principals/credentials/delegation
  O->>API: POST transition (suspend|cancel|revoke)
  API->>K: apply transition + cascade policy
  K->>D: update states + revocations
  D-->>K: committed
  K-->>API: lifecycle result
  API-->>O: envelope + audit trail id
```
