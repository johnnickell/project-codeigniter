# Roadmap

## Current priorities

Planning migration [TASK-00008](tasks/00008-TASK.md) is locally complete; independent review and hosted verification
remain pending. Use the new hierarchy to keep remaining adoption explicit:

1. [TASK-00009](tasks/00009-TASK.md) has approved qualification scope and is ready, not started. Authorize its
   execution and checkout choice separately, then review the exact stable Common 1.2+/AccessControl 0.4+ evidence
   before creating an upgrade TASK. The [adoption EPIC](epics/00002-EPIC.md) remains `needs-info`. Engineering
   contract proposal [TASK-00010](tasks/00010-TASK.md) has approved scope/creation and waits on TASK-00009's findings;
   execution, policy acceptance and subsequent enforcement TASKs remain separate. No upgrade is authorized.
2. Continue the [AccessControl application Wayfinder](wayfinder/codeigniter-access-control-application-map.md)
   through its own decision authority; WF-002 is still its independent runtime frontier. Reconcile its older
   release baseline before treating WF-001 as evidence for the newer adoption target.
3. Revisit Common 2.0 only after its migration authority exists; [TASK-00003](tasks/00003-TASK.md) remains needs-info.

The maintainer-approved [upstream reconciliation](UPSTREAM-RECONCILIATION.md) preserves `develop`'s dependency
lock and carries its legacy lean-gate proposal into TICKET-00007/TASK-00010. Its unfinished coverage/tooling
requirements are tracked, not marked complete or silently enforced.

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
| None | — | — | — |
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
