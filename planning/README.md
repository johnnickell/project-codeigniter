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

**Planning was the first priority and is now locally migrated—not evidence of completed adoption.** Stable Common
1.2+/AccessControl 0.4+ qualification and remaining engineering alignment are unresolved requirements; no upgrade
TASK is executable. [TASK-00009](tasks/00009-TASK.md) has approved qualification scope and is ready for separately
authorized execution. [TASK-00010](tasks/00010-TASK.md)'s engineering contract proposal scope is approved and waits
on TASK-00009; neither policy acceptance nor enforcement is authorized. TASK-00008 records local verification and
outstanding independent review.
