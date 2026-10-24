# TASK Board

## Routing index

Read only current human decisions and active work below; otherwise the first ready TASK.
Use [lightweight routing](../CONVENTIONS.md#lightweight-work-routing) for validation and evidence limits.
[Wayfinder status and frontiers](../wayfinder/README.md) answer the decision-routing question.
Use the [Roadmap](../ROADMAP.md) and current handoffs for planning phases; do not infer full decomposition from closed maps.
Read the referenced current section, not the full historical record. Missing handoff/phase needs owner input.

Use the generated sections for execution priority; records own status, order, parentage, and blockers.
See the [Roadmap Planning Frontier](../ROADMAP.md#planning-frontier) for undecided/decomposition work.

## Current human decision

[TASK-00011](00011-TASK.md)'s adoption-by-default planning amendment has independent review acceptance and QA
PASS; authorized landing is in progress on its main-checkout feature branch. Human PR review/merge follows
publication. [TASK-00009](00009-TASK.md) remains first ready for latest-stable qualification, with separately
authorized execution and checkout choice.
The actual upgrade belongs to [TICKET-00008](../tickets/00008-TICKET.md), pending exact release/migration acceptance.

[TASK-00010](00010-TASK.md) waits on TASK-00009 and specifies the CodeIgniter-adapted engineering contract.
[TICKET-00009](../tickets/00009-TICKET.md) retains concrete contract acceptance and enforcement implementation.
The independent current decomposition handoff is `/skill:to-tasks TICKET-00010` for the approved
[Pi/shared-skill compatibility requirement](../tickets/00010-TICKET.md#decisions-and-progress). No implementation
TASK exists for these new requirements; package/enforcement decomposition awaits the named evidence and decisions.
The [adoption EPIC](../epics/00002-EPIC.md) remains `needs-info`, even when its investigation artifacts complete.

Planning migration is locally complete in [TASK-00008](00008-TASK.md); independent review remains pending.
Neither the completed retirement nor planning migration means packages or all standards are adopted.

The existing application's independent planning frontier remains [WF-002](../wayfinder/tickets/WF-002-codeigniter-local-development-runtime-contract.md).
Its release-audit baseline needs reconciliation under TICKET-00006; no Wayfinder decision was closed here.

<!-- planning:board -->
## Active Work

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| None | — | — | — | — | — | — |

## Ready Frontier

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| 1 | [TASK-00009](00009-TASK.md) | Qualify the latest stable Fight package baseline | [TICKET-00006 — Qualify the latest stable Fight package upgrade](../tickets/00006-TICKET.md) | ready-for-agent | — | — |

## Waiting

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| 2 | [TASK-00010](00010-TASK.md) | Define the CodeIgniter engineering alignment contract | [TICKET-00007 — Specify the CodeIgniter-adapted engineering contract](../tickets/00007-TICKET.md) | ready-for-agent | [TASK-00009](00009-TASK.md) | — |

## Needs Info

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| — | [TASK-00003](00003-TASK.md) | Prepare Fight Common 2.0 Migration | [TICKET-00003 — Qualify a future Fight Common 2.0 migration](../tickets/00003-TICKET.md) | needs-info | — | — |

## Human Action

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| None | — | — | — | — | — | — |

## Needs Triage

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| None | — | — | — | — | — | — |

## Recently Closed

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| 1 | [TASK-00008](00008-TASK.md) | Migrate planning to the EPIC TICKET TASK structure | [TICKET-00005 — Adopt the EPIC TICKET TASK planning structure](../tickets/00005-TICKET.md) | done | — | [PR #9](https://github.com/johnnickell/project-codeigniter/pull/9) |
| — | [TASK-00001](00001-TASK.md) | Establish the Governed CodeIgniter Starter Foundation | [TICKET-00001 — CodeIgniter Starter Product and Walking-Slice Acceptance](../tickets/00001-TICKET.md) | done | — | — |
| — | [TASK-00002](00002-TASK.md) | Adopt the historical Fight Common 1.2 candidate | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00004](00004-TASK.md) | Establish the Complete CodeIgniter Platform Profile | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00006](00006-TASK.md) | Re-certify Rewritten Fight Common Candidate | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00007](00007-TASK.md) | Retire Framework Support Certification | [TICKET-00004 — Retire recurring framework-support certification](../tickets/00004-TICKET.md) | done | — | [PR #9](https://github.com/johnnickell/project-codeigniter/pull/9) |
| — | [TASK-00011](00011-TASK.md) | Amend the CodeIgniter adoption plan | — (standalone chore) | done | — | — |
<!-- /planning:board -->
