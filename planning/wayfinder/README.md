# Wayfinder Maps

Wayfinder maps chart an uncertain feature before it becomes an epic, PRD, or implementation ticket. A map is an
index of linked decision tickets, not a second source of decisions. Start with an active map's **Frontier**; when
none is available, offer to chart a new feature.

| Map | Status | Frontier | Scope |
|---|---|---|---|
| [CodeIgniter AccessControl Starter Application](codeigniter-access-control-application-map.md) | Active | [WF-002 — CodeIgniter Local Development Runtime Contract](tickets/WF-002-codeigniter-local-development-runtime-contract.md) | Planning-only map for the complete released AccessControl surface, local Docker runtime, OpenAPI, Mercure, and a portable React SPA. |

Use `_MAP_TEMPLATE.md` and `tickets/_WAYFINDER_TICKET_TEMPLATE.md` for new work. `research/` holds linked
evidence, never a parallel decision record. Archive only through `../../bin/archive-planning` after a map is Closed,
its decisions are Closed, its frontier is empty, and its implementation handoff is linked.
