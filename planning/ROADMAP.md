# Roadmap

## Current priorities

[Land closeout](CONVENTIONS.md#publication-closeout) owns exact live subject validation and eligible local retirement.
The [Board observation](tasks/BOARD.md#current-human-decision) preserves historical integration facts. Earlier PR #12/#16/#17/#19 publication checkpoints below are preserved history; all four are verified
merged/integrated and create no merge request or historical requery. Planning/decomposition priorities remain unchanged.

Planning migration [TASK-00008](tasks/00008-TASK.md) is locally complete; independent review and hosted verification
remain pending. Use the new hierarchy to keep remaining adoption explicit:

1. [TASK-00011](tasks/00011-TASK.md)'s 2026-10-24 adoption-by-default amendment has independent review acceptance
   and QA PASS; [PR #12](https://github.com/johnnickell/project-codeigniter/pull/12) awaits human review/merge,
   with final delivery verification retained in its landing evidence. The maintainer subsequently authorized
   [TASK-00009](tasks/00009-TASK.md) in the main checkout; its locally verified
   [qualification report](wayfinder/research/2026-10-24-latest-stable-fight-baseline.md) recommends Common v1.4.0 /
   AccessControl v0.8.0 and a narrow HttpFoundation 8.1.9 security refresh. TASK-00009 has independent review
   acceptance, QA PASS and is merged in the selected base. The maintainer subsequently accepted the concrete
   migration/security/consumer scope and single-TASK decomposition: [TASK-00014](tasks/00014-TASK.md) now
   implements the exact pair/security refresh with a passing local gate (26 tests / 127 assertions). Candidate A
   has independent Review acceptance and applicable non-visual QA PASS; [PR #17](https://github.com/johnnickell/project-codeigniter/pull/17) is open against `develop` for human review/merge after Land's final remote-head verification. Hosted checks are optional and unrun.
   Separately authorized [TASK-00010](tasks/00010-TASK.md) delivers the
   [engineering proposal](engineering-alignment-proposal.md), not permission to upgrade packages or enforce
   undecided policy. Its local verification, independent review acceptance and applicable QA PASS are recorded in
   the TASK; PR publication and human review/merge remain separate delivery facts.
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

- [TICKET-00008](tickets/00008-TICKET.md#decisions-and-progress): actual package upgrade. The maintainer accepted
  TASK-00009's dated Common 1.4.0 / AccessControl 0.8.0 proposal, narrow HttpFoundation 8.1.9 security refresh and
  bounded consumer scope. [TASK-00014](tasks/00014-TASK.md) now completes the dependency/native-composition/
  verification/documentation slice locally; automatic parent completion closes TICKET-00008. Exactly three package
  entries changed; native factories remain compatible. Candidate A has independent Review acceptance and applicable
  non-visual QA PASS; [PR #17](https://github.com/johnnickell/project-codeigniter/pull/17) is open against `develop` for human review/merge after Land's final remote-head verification. Hosted checks are optional and unrun. Broader engineering adoption remains unfinished.
- [TICKET-00009](tickets/00009-TICKET.md#approved-task-decomposition): approved TASK decomposition is complete.
  [TASK-00015](tasks/00015-TASK.md) delivers passing native PHP coding/architecture checks;
  [TASK-00016](tasks/00016-TASK.md) independently delivers one full-suite run collecting coverage, aiming for
  100% primarily from units with integration contribution; [TASK-00017](tasks/00017-TASK.md), blocked by both,
  strengthens complete read-only local/hosted orchestration. The provider-check inventory assigns applicable
  checks, capability-specific N/A and deferred upstream advisors. TASK-00015 now implements locally passing
  coding checks on the native source (26 tests / 130 assertions), with qualified versions/scan paths/exceptions
  in [PHP standards](agents/php-standards.md). Candidate A has independent Review acceptance and applicable
  non-visual QA PASS; at the administrative-closeout checkpoint, publication and final remote-head verification
  remain pending in the TASK's durable Land receipt. TASK-00016 is the next implementation frontier. Coverage
  and stronger gate safeguards remain unfinished; this requirement
  and EPIC-00002 do not close.
- [TICKET-00010](tickets/00010-TICKET.md#current-delivery-handoff): separately authorized
  [TASK-00013](tasks/00013-TASK.md#current-delivery-status) delivered the bounded runtime-ignore/binding/
  routing-verification slice and closes its parent automatically. Independent Review accepted and applicable QA
  passed the acceptance candidate; [PR #16](https://github.com/johnnickell/project-codeigniter/pull/16) is open
  against `develop` for human review/merge. Hosted checks are optional and unrun. Native selection/resume and
  Herdr child/log qualification were not performed. The original seven planning paths were included with
  TASK-00009 by explicit instruction; implementation authority came later from the user's Build invocation.

The narrowed TICKET-00006/00007 investigations may complete without completing these delivery requirements.
Unfinished child TICKETs keep EPIC-00002 open under unchanged automatic parent completion. TASK-00014 candidate A
has independent Review acceptance and applicable non-visual QA PASS; [PR #17](https://github.com/johnnickell/project-codeigniter/pull/17) is open against `develop` for human review/merge after Land's final remote-head verification. Hosted checks are optional and unrun. Engineering-enforcement TASK decomposition is approved and written under TICKET-00009; use the TASK Board for execution selection.
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
`needs-info`. TASK-00014 subsequently implements the qualified package baseline locally, not all engineering
practices or independent acceptance of that implementation.
