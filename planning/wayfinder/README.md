# Wayfinder Maps

Maps chart uncertain destinations before EPIC/TICKET/TASK decomposition. A map indexes decision tickets, not a
second store of decisions. Start with its authored Frontier; generated state below comes from the map records.

<!-- planning:maps -->
| Map | Status |
|---|---|
| [codeigniter-access-control-application-map](codeigniter-access-control-application-map.md) | Active |
<!-- /planning:maps -->

## Current frontier and adoption context

The CodeIgniter AccessControl application's unblocked runtime-decision frontier remains
[WF-002](tickets/WF-002-codeigniter-local-development-runtime-contract.md). Planning migration closes no decision.
Its older v0.2.0 package-audit baseline needs explicit reconciliation with the newer 0.4+ adoption target under
[TICKET-00006](../tickets/00006-TICKET.md); do not treat either as already qualified. Repository-wide current
priority and unfinished adoption are visible on the [TASK Board](../tasks/BOARD.md) and [Roadmap](../ROADMAP.md).

Use `_MAP_TEMPLATE.md` and `tickets/_WAYFINDER_TICKET_TEMPLATE.md`; `research/` contains evidence, not parallel
decisions. Archive only by explicit request through `./bin/archive-planning`, after the map/decisions are Closed,
its frontier is empty, and its implementation handoff is linked. [Archived maps](archive/maps/README.md).
