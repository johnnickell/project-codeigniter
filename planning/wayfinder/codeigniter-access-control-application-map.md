# CodeIgniter AccessControl Starter Application

**Label:** `wayfinder:map`
**Status:** Active

> This map is an **index, not a store**. Each material decision lives in exactly one linked ticket under
> `tickets/`; this map only summarizes the linked resolutions and shows the next decision frontier.

## Destination

Chart an implementation-ready, local-development CodeIgniter starter built on the released
`johnnickell/fight-common` v1.2.0 and `johnnickell/fight-access-control` v0.2.0 package contracts. The planned
application composes MySQL, Redis, Nginx, PHP-FPM, PHP-CLI workers, Cron scheduling, private Mercure SSE, every released
AccessControl workflow, OpenAPI documentation, and an editable React SPA under `client/` compiled into
`public/dist/`.

The starter owns CodeIgniter configuration, services, HTTP and Spark entry points, views, and every persistence,
security, runtime, and presentation adapter. It preserves `Domain <- Application <- Adapter` and consumes both
Fight packages only through their public Composer contracts; it never copies package source.

**Done** = every linked decision ticket is closed, the operation matrix accounts for every released public
AccessControl command, query, and service or explicitly classifies it as unsupported, all remaining fog is
resolved or excluded, and the map links to its resulting epic, PRDs, and executable vertical-slice tickets.

## Notes

- This is a decision-only map. It introduces no application API, database schema, environment variable, package
  dependency, runtime behavior, or release claim.
- The Compose topology is certified for local development only. Production deployment and availability are
  separate concerns.
- Initial administration is invitation-led, with an idempotent Spark bootstrap and no public first-user or
  self-registration backdoor.
- Mercure is the selected server-push transport. The SPA remains editable starter source rather than a shared
  runtime package.
- Agents and other machine/operator capabilities must remain fully usable through documented API, CLI, worker,
  or composition seams without mandatory UI screens.
- The unfinished Symfony Wayfinder is reference evidence only. Its eventual completed client may become the
  portable UX baseline for WF-009, but neither is CodeIgniter planning authority.
- WF-001 must audit the requested installable releases themselves. Development branches, aliases, candidate
  commits, and unpublished working trees cannot satisfy that evidence gate.
- Fight AccessControl owns scan-only reusable component schemas; CodeIgniter owns and generates its complete
  OpenAPI document in one pass from the installed schema resources and project-owned HTTP sources.
- Symfony owns the canonical client-facing paths, operation IDs, payload/error/authentication semantics, realtime
  event contract, and editable client source reference; CodeIgniter remains native behind that wire boundary.

## Decisions so far

1. **[Released Package Contract Audit](tickets/WF-001-released-package-contract-audit.md) is open and gated.**
   Inventory and classify the complete released public surface without reaching into package internals.
2. **[CodeIgniter Local Development Runtime Contract](tickets/WF-002-codeigniter-local-development-runtime-contract.md)
   is open.** Define the isolated Docker topology and operator contract independently of the package audit.
3. **[ADR HTTP and OpenAPI Contract](tickets/WF-003-adr-http-openapi-contract.md) is open.** Set the Action,
   Responder, request, validation, error, versioning, and documentation authority.
4. **[MySQL Persistence and Bootstrap Contract](tickets/WF-004-mysql-persistence-bootstrap-contract.md) is open.**
   Set adapter-owned storage, transactions, concurrency, reconciliation, migrations, and initial administration.
5. **[Authentication and Account Security Contract](tickets/WF-005-authentication-account-security-contract.md) is
   open.** Set the JWT, refresh-cookie, browser-defense, throttling, delivery, and lifecycle behavior.
6. **[Principal and Authorization Mapping](tickets/WF-006-principal-authorization-mapping.md) is open.** Map human
   User and machine Agent principals to filters, permissions, roles, and worker-safe authorization.
7. **[Async, Scheduling, and Realtime Contract](tickets/WF-007-async-scheduling-realtime-contract.md) is open.** Set
   queue, failure, schedule, mail, transaction-ordering, Mercure topic, and subscription behavior.
8. **[Complete API and CLI Operation Matrix](tickets/WF-008-complete-api-cli-operation-matrix.md) is open.** Account
   for every released command, query, and service across its supported boundary.
9. **[React SPA Adaptation and Journeys](tickets/WF-009-react-spa-adaptation-journeys.md) is open and externally
   gated.** Adapt the completed Symfony client evidence to portable CodeIgniter-owned frontend seams.
10. **[Implementation Handoff Acceptance Contract](tickets/WF-010-implementation-handoff-acceptance-contract.md) is
    open.** Define the epic, PRDs, vertical slices, documentation, and verification gates.

## Tickets

| Ticket | Type | Mode | Status | Depends On | Gate |
|---|---|---|---|---|---|
| [WF-001 — Released Package Contract Audit](tickets/WF-001-released-package-contract-audit.md) | Research | AFK | **Open** | — | Installable Fight Common 1.2.0 and Fight AccessControl 0.2.0 |
| [WF-002 — CodeIgniter Local Development Runtime Contract](tickets/WF-002-codeigniter-local-development-runtime-contract.md) | Grilling | HITL | **Open** | — | — |
| [WF-003 — ADR HTTP and OpenAPI Contract](tickets/WF-003-adr-http-openapi-contract.md) | Prototype | HITL | **Open** | WF-001 | Symfony canonical wire contract |
| [WF-004 — MySQL Persistence and Bootstrap Contract](tickets/WF-004-mysql-persistence-bootstrap-contract.md) | Prototype | HITL | **Open** | WF-001, WF-002 | — |
| [WF-005 — Authentication and Account Security Contract](tickets/WF-005-authentication-account-security-contract.md) | Grilling | HITL | **Open** | WF-003, WF-004 | Symfony authentication contract |
| [WF-006 — Principal and Authorization Mapping](tickets/WF-006-principal-authorization-mapping.md) | Grilling | HITL | **Open** | WF-001, WF-004, WF-005 | — |
| [WF-007 — Async, Scheduling, and Realtime Contract](tickets/WF-007-async-scheduling-realtime-contract.md) | Grilling | HITL | **Open** | WF-002, WF-004, WF-005, WF-006 | Symfony realtime contract |
| [WF-008 — Complete API and CLI Operation Matrix](tickets/WF-008-complete-api-cli-operation-matrix.md) | Grilling | HITL | **Open** | WF-003, WF-005, WF-006, WF-007 | Symfony operation matrix |
| [WF-009 — React SPA Adaptation and Journeys](tickets/WF-009-react-spa-adaptation-journeys.md) | Prototype | HITL | **Open** | WF-005, WF-008 | Immutable accepted Symfony client reference |
| [WF-010 — Implementation Handoff Acceptance Contract](tickets/WF-010-implementation-handoff-acceptance-contract.md) | Grilling | HITL | **Open** | WF-002 through WF-009 | Human approval of the handoff |

## Blocking relationships

```text
installable package releases ──→ WF-001 ──┬──→ WF-003 ──┐
                                   ├──→ WF-004 ──┼──→ WF-005 ──→ WF-006 ──┐
WF-002 ─────────────────────────────┘      │       │                       │
  └───────────────────────────────────────────────────────────────────────┤
WF-004 + WF-005 + WF-006 ─────────────────→ WF-007 ──────────────────────┤
                                                                          └──→ WF-008 ──┐
completed Symfony AccessControl client ────────────────────────────────────────────────→ WF-009
WF-002 through WF-009 ─────────────────────────────────────────────────────────────────→ WF-010
WF-010 ──→ epic, PRDs, and executable vertical-slice tickets
```

WF-002 is independently takeable. WF-001 remains gated until both requested release tags are installable, and
WF-009 additionally waits for the completed Symfony AccessControl client rather than designing against an
unfinished reference.

## Frontier

[WF-002 — CodeIgniter Local Development Runtime Contract](tickets/WF-002-codeigniter-local-development-runtime-contract.md)
is the one next grillable decision. Run `$aios /grill-with-docs WF-002`.

## Not yet specified (fog)

- Exact released package capabilities, signatures, semantic guarantees, and extension points remain unknown
  until WF-001 audits the installable tags.
- Exact container versions, host ports, health thresholds, volume policy, and parallel-worktree project naming
  remain for WF-002.
- Exact routes, schemas, permission names, pagination defaults, idempotency keys, throttles, and OpenAPI generation
  mechanism remain downstream decisions.
- Exact tables, indexes, lock strategies, transaction boundaries, migration sequence, and managed-policy
  ownership remain downstream decisions.
- Exact JWT claims, keys, refresh reuse, origin/CSRF, delivery, queue retry, task cadence, Mercure topic, and
  subscription rules remain downstream decisions.
- Exact portable client baseline, React libraries, page inventory, accessibility target, asset budgets,
  development-server behavior, and human UAT scripts remain downstream decisions.

## Out of scope

- Runtime or application implementation while this map is being charted.
- Copying or modifying Fight Common or Fight AccessControl source, copying another starter's backend, publishing
  either Fight package, or substituting an unreleased revision for a required release. The reviewed Symfony client
  source copy defined by WF-009 is the explicit exception.
- Production deployment topology, infrastructure-as-code, availability claims, release, publication, or
  production-readiness certification.
- Public self-registration, a first-user HTTP backdoor, or unauthenticated administrator creation.
- A mandatory UI for machine-agent or operator-only capabilities.
- A shared frontend runtime package or cross-project source synchronization mechanism.
- Archiving this map or creating implementation records before the decision set and handoff are complete.
