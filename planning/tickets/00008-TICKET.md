---
id: TICKET-00008
epic: EPIC-00002
title: Upgrade both Fight packages to the qualified latest stable releases
status: needs-info
---

# Upgrade both Fight packages to the qualified latest stable releases

## Problem statement

The installed development candidates are not the requested latest stable dependencies. Completing release
qualification alone cannot satisfy the consumer upgrade destination.

## Solution and boundaries

The maintainer approved the latest-stable upgrade destination on 2026-10-24. Consume the exact release and
compatibility findings from [TICKET-00006](00006-TICKET.md) / [TASK-00009](../tasks/00009-TASK.md), then implement
one coherent consumer upgrade: manifest/lock, necessary CodeIgniter composition adaptations, meaningful
integration evidence and documentation. Preserve public package ownership and native `app/`, services, HTTP
and Spark; do not copy package source or conceal incompatible contracts behind aliases.

Latest means published, installable stable releases at the recorded qualification date, not the old 1.2+/0.4+
floors, another consumer's lock, development aliases or unpublished branches. Check the latest stable release
of each package and their mutual/platform constraints. If the latest pair is incompatible, unavailable or needs
an unapproved breaking migration, report exact blockers and obtain a decision rather than silently selecting an
older pair. Recheck release availability before implementation; a material new release requires reconciling the
qualified scope, not an uncontrolled update during final verification.

This requirement excludes new login/persistence/browser journeys, upstream package changes/publication,
recurring certification lanes, provider delivery, runtime deployment and hidden dependency updates in the gate.
A latest-major finding overlapping [TASK-00003](../tasks/00003-TASK.md) must reconcile that existing ownership and
migration evidence before execution; preserve its identity and do not run competing migrations.

## Use cases

| Use case | Commands | Queries | Events | Expected side effects |
|---|---|---|---|---|
| Maintainer upgrades the starter without losing supported consumer behavior | N/A: no new business command | Existing consumer contracts and released public APIs | N/A: no new business event | Stable manifest/lock and verified composition; explicit dependency installation |

## Validation and permissions

Exact versions, migration scope and executable TASK acceptance remain pending qualification. The approved
planning direction is not permission to modify dependencies in TASK-00009 or this planning amendment. Reject
unsatisfied platform constraints, incompatible transaction capabilities and unsupported behavior claims. Use
repository-owned tooling; safe intercepted transports only, no production credentials or live provider effects.

## Acceptance and evidence

- Both package versions/references are stable and correspond to the accepted, dated latest-release findings.
- Manifest, lock and installation agree; candidate aliases/pins are removed where superseded, with no unrelated
  dependency drift. Explain any required transitive/platform changes.
- Affected public contracts, transaction/rollback/shared-connection semantics and consumer outcomes are proven
  at meaningful boundaries. Do not claim AccessControl journeys merely because the package is installed.
- Current local and hosted gate entrypoint parity is preserved; record local results and hosted results separately.
- Document upgrade consequences, exact supported baseline and unresolved limitations. Preserve historical evidence.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| None | — | — |
<!-- /planning:children -->

## Decisions and progress

Created by the approved [TASK-00011](../tasks/00011-TASK.md) planning amendment. This TICKET takes the actual
upgrade destination formerly combined with TICKET-00006's investigation scope; no requirement is discarded.
It remains `needs-info` until TASK-00009 supplies release evidence and the maintainer accepts the concrete
migration. Then use TASK decomposition for a complete upgrade slice, splitting only for evidenced compatibility
boundaries. No implementation TASK or package update is authorized by record creation.

Keeping this unfinished TICKET without children prevents investigation rollup from closing EPIC-00002; automatic
parent completion is not waived. A blocked qualification result leaves this requirement unresolved.
