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
future upgrade. Independent review/QA and maintainer acceptance of the migration remain outstanding.
[TASK-00010](tasks/00010-TASK.md) is now first ready to specify the adapted engineering contract using those findings.

Actual upgrade, engineering enforcement and shared Pi/skill compatibility remain in
[TICKET-00008](tickets/00008-TICKET.md), [TICKET-00009](tickets/00009-TICKET.md) and
[TICKET-00010](tickets/00010-TICKET.md). The first awaits acceptance of the exact release/migration/security
proposal; the second awaits the concrete engineering contract and its acceptance; the third is decomposed into
approved [TASK-00013](tasks/00013-TASK.md), with implementation still unstarted. No upgrade/enforcement TASK
is executable. Investigation completion may close its narrowed parent, but cannot close the broader adoption
EPIC while these requirements remain unfinished. Use the
[Roadmap handoffs](ROADMAP.md#current-decomposition-handoffs), not child counts, to select the planning phase.
TASK-00008 retains its historical verification and outstanding independent review.
