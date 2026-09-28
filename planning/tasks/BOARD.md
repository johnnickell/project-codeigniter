# TASK Board

Use the generated sections for execution priority; records own status, order, parentage, and blockers.
See the [Roadmap Planning Frontier](../ROADMAP.md#planning-frontier) for undecided/decomposition work.

## Current human decision

[TASK-00009](00009-TASK.md) is the first ready TASK. Its stable-package qualification scope and record creation
are approved; the next human decision is whether to authorize execution and which checkout/worktree to use.
Accept its release/compatibility findings before creating an upgrade TASK. [TASK-00010](00010-TASK.md)'s engineering
contract proposal scope/creation is also approved, but it is waiting on TASK-00009; execution and acceptance of
its future recommendations remain separate. The [adoption EPIC](../epics/00002-EPIC.md) remains `needs-info`.

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
| 1 | [TASK-00009](00009-TASK.md) | Qualify the stable Fight package baseline | [TICKET-00006 — Qualify and adopt the current stable Fight package baseline](../tickets/00006-TICKET.md) | ready-for-agent | — | — |

## Waiting

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| 2 | [TASK-00010](00010-TASK.md) | Define the CodeIgniter engineering alignment contract | [TICKET-00007 — Decide the remaining engineering and quality-gate alignment](../tickets/00007-TICKET.md) | ready-for-agent | [TASK-00009](00009-TASK.md) | — |

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
| 1 | [TASK-00008](00008-TASK.md) | Migrate planning to the EPIC TICKET TASK structure | [TICKET-00005 — Adopt the EPIC TICKET TASK planning structure](../tickets/00005-TICKET.md) | done | — | — |
| — | [TASK-00001](00001-TASK.md) | Establish the Governed CodeIgniter Starter Foundation | [TICKET-00001 — CodeIgniter Starter Product and Walking-Slice Acceptance](../tickets/00001-TICKET.md) | done | — | — |
| — | [TASK-00002](00002-TASK.md) | Adopt the historical Fight Common 1.2 candidate | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00004](00004-TASK.md) | Establish the Complete CodeIgniter Platform Profile | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00006](00006-TASK.md) | Re-certify Rewritten Fight Common Candidate | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00007](00007-TASK.md) | Retire Framework Support Certification | [TICKET-00004 — Retire recurring framework-support certification](../tickets/00004-TICKET.md) | done | — | — |
<!-- /planning:board -->
