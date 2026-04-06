# CRE8
## Final Consolidated Project Specification and Product Brief

_Status: adopted_
_Last updated (UTC): 2026-04-06_

## 1. Executive Summary

**CRE8.pw** is a unique credentialing, authentication, and authorization platform that developers can use to build any application on top of, in PHP, HTML, CSS, JS, and MySQL/MariaDB.

CRE8 is designed to be a foundational system access solution that gives account Owners total control over user access and granular content-sharing capabilities. It also enables developers to offer systems that do not require everyone to have user accounts in order to access the system, because with just an Author Key or Use Key, a person may access and use the system.

CRE8 is a robust credentialing, authentication, and authorization platform that allows developers the flexibility to offer traditional username/email/password accounts alone, a combination of registered Owner accounts and API-driven system access, or even a standalone API-only engine, using a single Owner account more as a site management account while delegating all system access to API Keys.

CRE8 offers a modular and easily extensible system, so that developers can use as little or as much of the platform as is appropriate for their application, without needing to use the entire system. The system is modular and easily extensible. The code structure is easily extensible, the database migrations are easily extensible, and the concepts are easily extensible.

CRE8 is a future-proof platform built on industry standards and designed to provide a unique, simple, and robust security solution for most small- and medium-sized PHP applications. It is also intended to support secure delegated access, flexible application architecture, and a wide variety of custom PHP-based products.

---

## 2. Technical Foundation

CRE8 is a **Slim 4 + PHP-DI API service** with:

- two authentication “surfaces” — console owner and gateway key,
- envelope-based JSON responses,
- strict middleware policies,
- JWT authentication,
- delegation and key lifecycle management,
- post, comment, and moderation workflows, and
- strong contract and security tests.

The application boots from `public/index.php`, loads environment variables and configuration, builds a DI container, runs boot checks, registers global and per-surface middleware, and mounts routes for:

- authentication,
- content,
- moderation,
- keys,
- health, and
- JWKS.

---

## 3. Product Model and Dual-Surface System

In general, CRE8 offers a **dual-surface UI Console and API Gateway system**.

### 3.1 Owner Surface

- **Owner accounts** are registered via the **UI Console**.
- Those Owner accounts are then used to generate **Primary Author Keys**.

### 3.2 Gateway Surface

Those Primary Author Keys are then used via the **API Gateway**, either through:

- third-party client software,
- local website HTML API interface pages, or
- official developer-made client software.

Those Primary Author Keys are then used to create and manage further access Keys, such as:

- additional Primary Author Keys,
- Secondary Author Keys, and
- Use Keys.

Primary and Secondary Author Keys may create new Posts.

Use Keys may access and make comments attached to Posts that their Keys have permission to access.

---

## 4. Accounts, Keys, and Core Credential Types

A user should be able to use an **Owner Invitation Key** to register an **Owner account**, then use that Owner account to mint a **Primary Author Key**.

Only an **Owner** may mint an **Owner Account Invitation Key**.

CRE8 includes several kinds of Keys, including:

- **Primary Author Keys**,
- **Secondary Author Keys**,
- **Use Keys**,
- **Keychain Keys**, and
- **Owner Account Invitation Keys**.

Each Key may have configurable permissions, and defaults may be overridden at mint time.

---

## 5. Minting Rules and Permission Model

There are configurable permissions to be set at each stage of minting. The following are defaults, but these permissions may be changed per Key:

- A Primary Author Key may mint a Primary Author Key.
- A Primary Author Key may mint a Secondary Author Key.
- A Primary Author Key may mint a Use Key.
- A Secondary Author Key may mint a Use Key.
- A Primary Author Key may create a new Post.
- A Secondary Author Key may create a new Post.
- A Use Key may make Comments on Posts.

When a Primary Author Key mints a new Primary Author Key or Secondary Author Key, it may specify which permissions those Keys have, such as:

- whether those Keys may mint further Author Keys or Use Keys, and
- which permissions they may manage in the Keys they mint.

When a Primary Author Key or Secondary Author Key generates a new Use Key, they may set permissions so that the Use Key may access:

- all of that Author Key’s Posts,
- a specific Post, or
- an Audience of Posts.

Also, comments may be on or off per Use Key.

---

## 6. Posts, Content, Audiences, and Access Control

When a new Post is made, the Author may make the Post:

- private,
- public,
- available to an audience of Keys, or
- available to only one Key.

Primary and Secondary Author Keys may create new Posts.

Use Keys may make comments on Posts if their permissions allow it.

Posts may be edited and deleted by the original Post Author.

Other users may flag Posts for review by Owner/Admin accounts for possible moderation.

Audience-based access is part of the content model. A Use Key may be granted access to:

- all of an Author Key’s Posts,
- a specific Post, or
- an Audience of Posts.

---

## 7. Active Identity, Feed Logic, and Keychains

A User sets an active Key or active Keychain, and that is what their primary Feed and access grants are based on. This means that user access and feed behavior are determined by the currently active credential context.

A **Keychain** is a new Key that is registered as an aggregate permission Key based on the Keys that are added to it.

As a new Use Key or Author Key is added to a Keychain, the system reconfigures its permissions and stores the updated data in the database. The next time that Keychain Key is used, it is as though the person using it is presenting all the Keys attached to it, thereby gaining all the permissions associated with those Keys.

Anybody may mint a Keychain Key, and Keychains may be specified as **public** or **private**.

Keychains are the recommended way to share access to a Key.

Keychains may be rotated, managed, or disabled just like regular Keys.

Users may mint:

- a **personal Keychain Key**, or
- a **public Keychain Key**.

A personal Keychain may only be used by the person who creates it.

A public Keychain may be used by anybody who has a copy of its Key code.

A Keychain becomes an aggregate of all the combined Keys added to the Keychain.

---

## 8. Owner Visibility, Provenance, Lineage, and Administrative Control

An Owner account may view:

- all the Keys they have created,
- the entire lineage of all descendant Keys created, and
- the entire provenance chain of Posts.

Keys may be:

- **suspended** (temporary), or
- **cancelled** (permanent),

by the Owner or by Admin.

Keys may be revoked individually or on a cascading basis, on a case-by-case basis.

---

## 9. Interface Surfaces and Parity HTML Access

### 9.1 Owner HTML UI Interface

There is an **Owner HTML UI interface**, which is the only way to:

- generate Owner-generated Primary Author Keys,
- view the Provenance and Lineage Key Activity graphs, and
- manage Key tree access suspensions.

### 9.2 Primary Author and Secondary Author API Interface

There is a **Primary Author and Secondary Author API Interface**, and each API endpoint has parity HTML UI pages to interact with the API system.

### 9.3 Use Key API Interface

There is a **Use Key API Interface**, and each API endpoint has parity HTML UI pages to interact with the API system.

### 9.4 Full HTML Interface Coverage

There is a full suite of HTML interfaces for every API action, so that some people could use the website interface and never realize they are actually interacting with the API server through the web interface.

---

## 10. Extensibility and Developer Application Model

Each application that is built on top of CRE8 will extend:

- Post types,
- Audience group types,
- perhaps Key types, and
- other parts of the system.

Applications built on top of CRE8 may extend:

- Post types,
- Audience group types,
- Key types, and
- other parts of the system.

It is made easy to extend by simply finding the pattern that the developers wish to copy, then copying and pasting the example patterns given, and then building on top of and further developing the CRE8 building blocks into their own custom applications.

Developers may extend CRE8 by following and reusing the existing patterns in the codebase, copying example patterns, and building custom applications on top of the platform.

Because CRE8 is modular, developers can use only the parts of the platform that are appropriate for their application, rather than adopting the whole system.

Developers can therefore use CRE8 as:

- a full access platform,
- a hybrid Owner account + API Key system, or
- a standalone API-only engine.

---

## 11. First Use Case: XtraType

There is a first use-case system being developed on top of CRE8, called **XtraType**.

XtraType allows users to post annotations to URLs, which include:

- the URL string,
- the date/timestamp,
- user agent metadata,
- any highlighted text from the webpage they were browsing, and
- any comment and/or media the user attaches to their Annotation Post.

---

## 12. Product Positioning and Consolidated Value

CRE8 is a foundational credentialing, authentication, and authorization platform for PHP applications.

It supports:

- Owner accounts,
- API-driven delegated access,
- granular permissions,
- hierarchical key minting,
- audience-based content access,
- key aggregation through Keychains,
- moderation and provenance tracking, and
- parity HTML interfaces for all API actions.

CRE8 gives account Owners total control over user access and granular content-sharing capabilities.

It also gives developers the ability to offer systems that do not require everyone to have a registered user account, because with just an Author Key or Use Key, a person may access and use the system.

It is intended to be robust, simple, modular, extensible, and suitable as a security and access foundation for a wide range of small- and medium-sized applications.

It is a modular, extensible, future-proof platform built on industry standards, designed to support secure delegated access, flexible application architecture, and a wide variety of custom PHP-based products.
