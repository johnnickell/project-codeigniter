# Roadmap

## Current priorities

Planning migration [TASK-00008](tasks/00008-TASK.md) is locally complete; independent review and hosted verification
remain pending. Use the new hierarchy to keep remaining adoption explicit:

1. [TASK-00011](tasks/00011-TASK.md)'s 2026-10-24 adoption-by-default amendment has independent review acceptance
   and QA PASS; [PR #12](https://github.com/johnnickell/project-codeigniter/pull/12) awaits human review/merge,
   with final delivery verification retained in its landing evidence. The maintainer subsequently authorized
   [TASK-00009](tasks/00009-TASK.md) in the main checkout; its locally verified
   [qualification report](wayfinder/research/2026-10-24-latest-stable-fight-baseline.md) recommends Common v1.4.0 /
   AccessControl v0.8.0 and a narrow HttpFoundation 8.1.9 security refresh. Independent review/QA and concrete
   migration acceptance remain outstanding. [TASK-00010](tasks/00010-TASK.md) is now first ready to specify the
   engineering contract with those findings, not permission to upgrade packages or enforce undecided policy.
2. Continue the [AccessControl application Wayfinder](wayfinder/codeigniter-access-control-application-map.md)
   through its own decision authority; WF-002 is still its independent runtime frontier. Reconcile its older
   release baseline before treating WF-001 as evidence for the newer adoption target.
3. [TASK-00003](tasks/00003-TASK.md) remains `needs-info`. Latest-stable qualification must inspect actual release
   lines; if a newest major overlaps that migration, reconcile its existing owner/artifact requirements rather
   than silently excluding the release or starting competing implementation.

The maintainer-approved [upstream reconciliation](UPSTREAM-RECONCILIATION.md) preserves `develop`'s dependency
lock and carries its legacy lean-gate proposal into TICKET-00007/TASK-00010. Its unfinished coverage/tooling
requirements are tracked, not marked complete or silently enforced.

## Current decomposition handoffs

- [TICKET-00008](tickets/00008-TICKET.md#decisions-and-progress): actual package upgrade. TASK decomposition
  awaits the maintainer's acceptance of TASK-00009's dated v1.4.0/v0.8.0 migration and narrow security-refresh
  proposal; the report is delivered, the project installation is unchanged and adoption remains unfinished.
- [TICKET-00009](tickets/00009-TICKET.md#decisions-and-progress): actual engineering enforcement. TASK
  decomposition awaits TASK-00010's contract, coverage choices, compatible tools and accepted exceptions.
- [TICKET-00010](tickets/00010-TICKET.md#decisions-and-progress): decomposition complete through approved
  [TASK-00013](tasks/00013-TASK.md), the bounded runtime-ignore/binding/routing-verification chore. Implementation
  remains unstarted and requires separate authorization. The seven approved planning paths are included with
  TASK-00009 by explicit instruction, not implemented. Use `/skill:next` for Board-based selection; TASK-00010 is
  now first ready and TASK-00013 remains independent at order 3.

The narrowed TICKET-00006/00007 investigations may complete without completing these delivery requirements.
Unfinished child TICKETs keep EPIC-00002 open under unchanged automatic parent completion. TASK-00013 is now an
executable Board row, but package/enforcement handoffs remain planning prerequisites rather than ready TASKs.
No full adoption decomposition or completion is claimed; the unrelated application Wayfinder stays gated.

## EPIC status

<!-- planning:epics -->
| EPIC ID | Title | Target | Status |
|---|---|---|---|
| [EPIC-00001](epics/00001-EPIC.md) | Maintain the governed CodeIgniter starter and package integration | starter-foundation | needs-info |
| [EPIC-00002](epics/00002-EPIC.md) | Adopt current Fight packages and Agent OS engineering conventions | qualified-codeigniter-adoption | needs-info |
<!-- /planning:epics -->

## Planning Frontier

These are decomposition decisions, not executable TASKs. Use the [TASK Board](tasks/BOARD.md) for
implementation. [Automatic parent completion](CONVENTIONS.md#automatic-parent-completion) closes eligible parents
in the same operation that completes their children.

<!-- planning:frontier -->
### EPICs without TICKETs

| EPIC ID | Title | Status |
|---|---|---|
| None | — | — |

### TICKETs without TASKs

| TICKET ID | Title | Parent EPIC | Status |
|---|---|---|---|
| [TICKET-00008](tickets/00008-TICKET.md) | Upgrade both Fight packages to the qualified latest stable releases | [EPIC-00002](epics/00002-EPIC.md) | needs-info |
| [TICKET-00009](tickets/00009-TICKET.md) | Enforce the CodeIgniter-adapted Agent OS engineering contract | [EPIC-00002](epics/00002-EPIC.md) | needs-info |
<!-- /planning:frontier -->

## Historical outcomes

[TASK-00001](tasks/00001-TASK.md) preserves local/hosted foundation and merged bootstrap evidence.
[TASK-00002](tasks/00002-TASK.md), [TASK-00004](tasks/00004-TASK.md), and [TASK-00006](tasks/00006-TASK.md) preserve
candidate integration and historical certification—not stable 1.2+/0.4+ adoption.

[TASK-00007](tasks/00007-TASK.md) retired recurring receipts, lowest/latest certification, and verifier-only tests
in commit `2699ceb`. Its local gate passed; independent review and hosted verification remain pending. Dependency
installation/updates are explicit preparation/maintenance, not pre-submit tests. No release or publication is claimed.

[TASK-00008](tasks/00008-TASK.md) migrated planning to EPIC → TICKET → TASK and generated views, with a green local
gate. [MIGRATION.md](MIGRATION.md) maps the old surface without archiving or losing history. Broader adoption remains
`needs-info`; neither the current package baseline nor all engineering practices have been adopted.
