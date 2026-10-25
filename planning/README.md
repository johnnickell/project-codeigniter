# Planning

Markdown is the committed source of truth for Fight CodeIgniter Starter planning.

- [Conventions](CONVENTIONS.md): EPIC → TICKET → TASK, lifecycle, priority, generation, and archives
- [TASK Board](tasks/BOARD.md): active and executable work, blockers, and human action
- [Roadmap](ROADMAP.md): strategy, EPIC status, and decomposition/closeout frontier
- [EPICs](epics/README.md), [TICKETs](tickets/README.md), [TASKs](tasks/README.md)
- [Adoption EPIC](epics/00002-EPIC.md): completed/approved slices versus unfinished package and engineering adoption
- [Migration map](MIGRATION.md): old PRD/T identities, preserved history, and the reserved legacy T-00005 gap
- [Wayfinder](wayfinder/README.md), [ADRs](adr/README.md), and [focused instructions](agents/issue-tracker.md)
- [Baseline and license notice](SOURCE-NOTICE.md)

Grill an EPIC before decomposing accepted scope into requirement TICKETs and implementation TASKs. Repository
terminology and templates govern external skills; do not treat a TASK as a TICKET. Keep one writable source of
truth: records own state, generated views project it, and historical prose does not override current metadata.

Run `./bin/planning-check --write`, then `./bin/planning-check` after editing records. The canonical build checks
without rewriting views. Archive only on explicit request; scratch remains under ignored `.runs/`.

**Adoption by default is approved; implementation is incomplete.** The 2026-10-24
[TASK-00011 amendment](tasks/00011-TASK.md) preserves CodeIgniter's standard approach and requires the latest
mutually compatible stable Fight packages, not merely the former Common 1.2+/AccessControl 0.4+ floors.
Explicitly authorized [TASK-00009](tasks/00009-TASK.md) now supplies the locally verified
[dated qualification](wayfinder/research/2026-10-24-latest-stable-fight-baseline.md): Common v1.4.0 and
AccessControl v0.8.0 install together; an inherited HttpFoundation advisory needs a narrow 8.1.9 refresh in the
future upgrade. Independent review accepted and applicable QA passed for qualification. The maintainer
subsequently accepted the migration/security/consumer scope and one-TASK decomposition through
[TASK-00014](tasks/00014-TASK.md). It now implements that exact baseline with a passing local gate
(26 tests / 127 assertions); candidate A has independent Review acceptance and applicable non-visual QA PASS,
while [PR #17](https://github.com/johnnickell/project-codeigniter/pull/17) is open against `develop` for human review/merge after Land's final remote-head verification. Hosted checks are optional and unrun.
Separately authorized [TASK-00010](tasks/00010-TASK.md) now delivers the sourced
[engineering alignment proposal](engineering-alignment-proposal.md), using those findings without changing
packages, tools, runtime or gates. Its local verification, independent review acceptance and applicable QA PASS
are recorded in the TASK; PR publication and human review/merge remain separate delivery facts. TASK-00009 is
merged in the selected base.

Package adoption, engineering enforcement and the bounded shared Pi/skill compatibility requirement are tracked in
[TICKET-00008](tickets/00008-TICKET.md), [TICKET-00009](tickets/00009-TICKET.md) and
[TICKET-00010](tickets/00010-TICKET.md). The first closes automatically with locally completed TASK-00014 for the accepted
stable pair and security refresh; the second now has an approved three-TASK decomposition:
[TASK-00015](tasks/00015-TASK.md) for native PHP coding/architecture checks,
[TASK-00016](tasks/00016-TASK.md) for one complete test run collecting coverage, aiming for 100% primarily through
units with integration contribution, and [TASK-00017](tasks/00017-TASK.md) for complete once-only read-only gate
orchestration after both. Its provider-check inventory explicitly assigns applicable checks, N/A and deferred
upstream advisors. TASK-00015 now implements locally passing native coding/architecture checks (26 tests / 130 assertions), with
[qualified tool versions, paths and exceptions](agents/php-standards.md). Independent Review and applicable QA
remain pending; TASK-00016 is next in the executable Board frontier. Coverage and stronger orchestration remain
unfinished. The third is locally implemented through
[TASK-00013](tasks/00013-TASK.md) and the [target binding](agents/shared-workflows.md). Its parent closes
automatically; independent Review accepted and applicable QA passed for the accepted candidate, and
[PR #16](https://github.com/johnnickell/project-codeigniter/pull/16) awaits human review/merge. Hosted checks
are optional and unrun. Source walkthroughs and safe discovery/status checks are labeled separately from
unavailable live native selection/resume and child/log qualification; this is not full Pi capability certification.
Enforcement TASK-00015 is locally implemented; TASK-00016/00017 remain unfinished. Neither decomposition nor
the first coding rollout completes adoption.
Package dependencies changed in TASK-00014, not in these planning operations.
Investigation completion may close its narrowed parent, but cannot close the broader adoption EPIC while these
requirements remain unfinished. Use the
[Roadmap handoffs](ROADMAP.md#current-decomposition-handoffs), not child counts, to select the planning phase.
TASK-00008 retains its historical verification and outstanding independent review.
