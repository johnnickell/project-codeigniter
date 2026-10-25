---
id: TICKET-00008
epic: EPIC-00002
title: Upgrade both Fight packages to the qualified latest stable releases
status: done
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

The maintainer accepted Common 1.4.0 / AccessControl 0.8.0, the narrow HttpFoundation 8.1.9 refresh and the
bounded consumer upgrade/verification scope through approval of the single-TASK decomposition. Execution
belongs to [TASK-00014](../tasks/00014-TASK.md), not TASK-00009 or the preceding planning operation. TASK-00014
now records completed implementation and required local verification; independent Review and QA remain pending.
Reject unsatisfied platform constraints, incompatible transaction capabilities and unsupported behavior claims.
Recheck releases before implementation and obtain a decision for material scope changes. Use repository-owned
tooling; safe intercepted transports only, no production credentials or live provider effects.

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
| [TASK-00014](../tasks/00014-TASK.md) | Adopt the qualified stable Fight package baseline | done |
<!-- /planning:children -->

## Decisions and progress

Created by the approved [TASK-00011](../tasks/00011-TASK.md) planning amendment. This TICKET takes the actual
upgrade destination formerly combined with TICKET-00006's investigation scope; no requirement is discarded.
TASK-00009 now supplies the locally verified
[2026-10-24 report](../wayfinder/research/2026-10-24-latest-stable-fight-baseline.md): latest Common v1.4.0 and
AccessControl v0.8.0 install together, with released transaction type fit and bounded migration/verification scope.
The two-package-only copied-lock solve retains inherited HttpFoundation 8.1.6 / CVE-2026-108082; a narrow targeted
8.1.9 refresh resolves that advisory without other package changes. Project dependencies remained unchanged by that investigation.
Independent review accepted and applicable QA passed for the investigation; neither is acceptance of a migration.

The maintainer subsequently approved the one-TASK draft, including the exact pair, narrow security refresh and
consumer scope, and selected the current checkout for recording it. [TASK-00014](../tasks/00014-TASK.md) is the
complete upgrade slice: stable manifest/lock, necessary native composition, meaningful integration/failure-path
verification and documentation in one PR. No evidenced compatibility boundary warrants a split. Its completed
TASK-00009 dependency is preserved. TASK-00014 subsequently rechecked releases on 2026-10-25 and installed the exact stable pair plus HttpFoundation
8.1.9, with exactly three updated package entries and no other dependency drift. Focused tests and the full local
gate pass (26 tests / 127 assertions), with explicit transaction/provider/JSend/StreamId limits in the TASK.
Native service factories need no adaptation. Independent Review, applicable QA and delivery remain outstanding. Broader application journeys and Wayfinder decisions remain separate.

TASK decomposition and accepted-scope local implementation/verification are complete. Automatic parent
completion closes this TICKET with TASK-00014 in the same operation; that does not assert independent acceptance
or delivery. EPIC-00002 remains open while TICKET-00009's engineering enforcement is unfinished.
Planning approval is not execution, independent Review, QA or publication authority.
