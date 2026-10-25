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
PASS; [PR #12](https://github.com/johnnickell/project-codeigniter/pull/12) is published for human review/merge.
Final delivery verification is recorded in the TASK's landing evidence. The maintainer subsequently authorized
[TASK-00009](00009-TASK.md) execution through Build in the main checkout. Its locally verified
[qualification report](../wayfinder/research/2026-10-24-latest-stable-fight-baseline.md) recommends Common v1.4.0 /
AccessControl v0.8.0 and a narrow inherited-advisory refresh to HttpFoundation 8.1.9. Independent review accepted
and applicable QA passed; [PR #14](https://github.com/johnnickell/project-codeigniter/pull/14) is merged in the
selected TASK-00010 base. The maintainer subsequently accepted the exact release/migration/security scope and
single-TASK decomposition under [TICKET-00008](../tickets/00008-TICKET.md).
[TASK-00014 — Adopt the qualified stable Fight package baseline](00014-TASK.md) now implements Common 1.4.0 /
AccessControl 0.8.0 and the narrow HttpFoundation 8.1.9 refresh in the authorized current checkout, including
consumer verification and documentation. The local gate passes (26 tests / 127 assertions); candidate A has
independent Review acceptance and applicable non-visual QA PASS. [PR #17](https://github.com/johnnickell/project-codeigniter/pull/17) is open against `develop` for human review/merge after Land's final remote-head verification; hosted checks are optional and unrun. Native factories remain compatible. Automatic parent completion closes TICKET-00008, not the adoption EPIC.

Separately authorized [TASK-00010](00010-TASK.md) delivers the
[CodeIgniter engineering proposal](../engineering-alignment-proposal.md) using TASK-00009's findings; its
completed dependency edge is preserved. Local verification, independent review acceptance and applicable QA PASS
are recorded in the TASK; PR publication and human review/merge remain separate delivery facts. Hosted checks are
optional for this TASK and have not been run.
[TICKET-00009](../tickets/00009-TICKET.md#maintainer-decision--recorded-2026-10-24) now records the maintainer's
accepted engineering direction: one complete suite execution collecting coverage, aiming for 100% meaningful
owned-behavior coverage primarily from units with integration contribution; native CodeIgniter; Fight Common
PHPCS, Deptrac, PHPStan, Rector and applicable existing/planned Agent OS checks. The maintainer approved the
[three-TASK decomposition](../tickets/00009-TICKET.md#approved-task-decomposition):
[TASK-00015](00015-TASK.md) delivers coding/architecture checks, [TASK-00016](00016-TASK.md) delivers single-run
coverage, and [TASK-00017](00017-TASK.md) strengthens the complete read-only gate after both. Implementation
has not started; TASK-00015 is first in Board order and its TASK-00014 prerequisite is complete.
The separately authorized [TASK-00013](00013-TASK.md#current-delivery-status) delivered the
[Pi/shared-skill compatibility requirement](../tickets/00010-TICKET.md#current-delivery-handoff) in the selected
main checkout; automatic parent completion closes TICKET-00010. Independent Review accepted and applicable QA
passed the acceptance candidate. [PR #16](https://github.com/johnnickell/project-codeigniter/pull/16) is open
against `develop` and awaits human review/merge; hosted checks are optional and unrun. None is implied by `done`;
native selection/resume and Herdr child/log qualification remain unperformed. Its original seven planning paths
were included in TASK-00009's commit by explicit instruction before the later Build implementation authority.
Package-upgrade decomposition is complete through TASK-00014. Enforcement decomposition is now complete through
TASK-00015/00016/00017, with the [provider-check inventory](../tickets/00009-TICKET.md#existing-and-planned-provider-check-inventory)
assigning applicable check outcomes, justified N/A and deferred upstream advisors. Planning approval is not
execution authority; unavailable planned advisors are not claimed as delivered.
The [adoption EPIC](../epics/00002-EPIC.md) remains `needs-info`, even when its investigation artifacts complete.

Planning migration is locally complete in [TASK-00008](00008-TASK.md); independent review remains pending.
Neither the completed retirement nor planning migration means packages or all standards are adopted.

The existing application's independent planning frontier remains [WF-002](../wayfinder/tickets/WF-002-codeigniter-local-development-runtime-contract.md).
Its release-audit baseline has a proposed reconciliation in TASK-00009's report, pending the map owner's
acceptance; no Wayfinder decision or external prerequisite was closed here.

<!-- planning:board -->
## Active Work

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| None | — | — | — | — | — | — |

## Ready Frontier

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| 1 | [TASK-00015](00015-TASK.md) | Enforce native PHP coding and architecture standards | [TICKET-00009 — Enforce the CodeIgniter-adapted Agent OS engineering contract](../tickets/00009-TICKET.md) | ready-for-agent | — | — |
| 2 | [TASK-00016](00016-TASK.md) | Collect meaningful coverage in one complete test run | [TICKET-00009 — Enforce the CodeIgniter-adapted Agent OS engineering contract](../tickets/00009-TICKET.md) | ready-for-agent | — | — |

## Waiting

| Order | TASK ID | Title | Parent TICKET | Status | Blocked by | PR |
|---|---|---|---|---|---|---|
| 3 | [TASK-00017](00017-TASK.md) | Enforce a complete once-only read-only build locally and in CI | [TICKET-00009 — Enforce the CodeIgniter-adapted Agent OS engineering contract](../tickets/00009-TICKET.md) | ready-for-agent | [TASK-00015](00015-TASK.md), [TASK-00016](00016-TASK.md) | — |

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
| 1 | [TASK-00009](00009-TASK.md) | Qualify the latest stable Fight package baseline | [TICKET-00006 — Qualify the latest stable Fight package upgrade](../tickets/00006-TICKET.md) | done | — | [PR #14](https://github.com/johnnickell/project-codeigniter/pull/14) |
| 1 | [TASK-00012](00012-TASK.md) | Raise the PHP and NGINX security baseline | — (standalone bug) | done | — | [PR #13](https://github.com/johnnickell/project-codeigniter/pull/13) |
| 1 | [TASK-00014](00014-TASK.md) | Adopt the qualified stable Fight package baseline | [TICKET-00008 — Upgrade both Fight packages to the qualified latest stable releases](../tickets/00008-TICKET.md) | done | — | [PR #17](https://github.com/johnnickell/project-codeigniter/pull/17) |
| 2 | [TASK-00010](00010-TASK.md) | Define the CodeIgniter engineering alignment contract | [TICKET-00007 — Specify the CodeIgniter-adapted engineering contract](../tickets/00007-TICKET.md) | done | — | [PR #15](https://github.com/johnnickell/project-codeigniter/pull/15) |
| 3 | [TASK-00013](00013-TASK.md) | Integrate CodeIgniter's shared Pi workflow binding | [TICKET-00010 — Integrate the shared Pi skills and next-work conventions](../tickets/00010-TICKET.md) | done | — | [PR #16](https://github.com/johnnickell/project-codeigniter/pull/16) |
| — | [TASK-00001](00001-TASK.md) | Establish the Governed CodeIgniter Starter Foundation | [TICKET-00001 — CodeIgniter Starter Product and Walking-Slice Acceptance](../tickets/00001-TICKET.md) | done | — | — |
| — | [TASK-00002](00002-TASK.md) | Adopt the historical Fight Common 1.2 candidate | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00004](00004-TASK.md) | Establish the Complete CodeIgniter Platform Profile | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00006](00006-TASK.md) | Re-certify Rewritten Fight Common Candidate | [TICKET-00002 — Fight Common Version Adoption and Support Evidence](../tickets/00002-TICKET.md) | done | — | — |
| — | [TASK-00007](00007-TASK.md) | Retire Framework Support Certification | [TICKET-00004 — Retire recurring framework-support certification](../tickets/00004-TICKET.md) | done | — | [PR #9](https://github.com/johnnickell/project-codeigniter/pull/9) |
| — | [TASK-00011](00011-TASK.md) | Amend the CodeIgniter adoption plan | — (standalone chore) | done | — | [PR #12](https://github.com/johnnickell/project-codeigniter/pull/12) |
<!-- /planning:board -->
