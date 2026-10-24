# Wayfinder Maps

Maps chart uncertain destinations before EPIC/TICKET/TASK decomposition. A map indexes decision tickets, not a
second store of decisions. Start with its authored Frontier; generated state below comes from the map records.

<!-- planning:maps -->
| Map | Status |
|---|---|
| [codeigniter-access-control-application-map](codeigniter-access-control-application-map.md) | Active |
<!-- /planning:maps -->

## Current frontier and adoption context

The CodeIgniter AccessControl application's authored runtime-decision frontier remains
[WF-002](tickets/WF-002-codeigniter-local-development-runtime-contract.md). Its runtime policy checkpoint is
accepted, but it remains Open pending the Fight Agent OS proxy contract (ingress network, hostnames, and TLS
ownership). Worktree-specific runtimes are deferred; no implementation or decision closure is claimed.
The map's older v0.2.0 package-audit baseline needs its owner's acceptance of the
[dated reconciliation proposal](research/2026-10-24-latest-stable-fight-baseline.md) from completed investigation
[TICKET-00006](../tickets/00006-TICKET.md). Common v1.4.0 / AccessControl v0.8.0 installability is qualified in
isolated scratch, not adopted by this project or accepted as the map's new baseline. Actual upgrade remains
[TICKET-00008](../tickets/00008-TICKET.md), including the narrow security-refresh decision. No Wayfinder gate,
status, dependency or frontier changes. Repository-wide current priority and unfinished adoption are visible on
the [TASK Board](../tasks/BOARD.md) and [Roadmap](../ROADMAP.md).

Use `_MAP_TEMPLATE.md` and `tickets/_WAYFINDER_TICKET_TEMPLATE.md`; `research/` contains evidence, not parallel
decisions. Archive only by explicit request through `./bin/archive-planning`, after the map/decisions are Closed,
its frontier is empty, and its implementation handoff is linked. [Archived maps](archive/maps/README.md).
