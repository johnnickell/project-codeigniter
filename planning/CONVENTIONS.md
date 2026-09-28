# Planning Conventions

Individual Markdown records own requirements, status, dependencies, and execution priority. Boards, indexes, and
Roadmap status tables are generated views. Authored strategy and decision narratives remain editable. These local
rules adopt the Fight Agent OS structure; [MIGRATION.md](MIGRATION.md) preserves the old identities and
[SOURCE-NOTICE.md](SOURCE-NOTICE.md) records the inspected baseline and tooling provenance.

## Hierarchy and paths

| Level | Responsibility | Path and displayed ID |
|---|---|---|
| EPIC | Destination, business outcome, and boundaries | `planning/epics/00001-EPIC.md` · `EPIC-00001` |
| TICKET | Related use cases and requirements | `planning/tickets/00001-TICKET.md` · `TICKET-00001` |
| TASK | Bounded implementation, normally one PR | `planning/tasks/00001-TASK.md` · `TASK-00001` |
| SUBTASK | Dependency-ordered assignment owned by a TASK | Ignored `.runs/` material |

Each level has its own five-digit sequence. Preserve numbers and gaps; inspect live and archived records before
allocating an ID. TASK-00005 is reserved for the pre-existing, unmerged legacy T-00005 worktree and must not be
reused or imported without reconciliation. WF decision IDs have their own sequence. A number at one level does
not identify a record at another level.

Every artifact directory keeps a copy-ready `_…_TEMPLATE.md`. Templates are not records and receive no ID. ADRs
remain in `adr/` with `NNNN-description.md` names; focused instructions remain in `agents/`.

Grilling writes an EPIC only. Decompose accepted scope into requirement TICKETs, then implementation TASKs.
Record use cases, commands, queries, events, side effects, validation, permissions, and observable acceptance.
Explain N/A concerns rather than silently omitting them. A planning record is not automatic execution authority.

A TASK normally delivers a complete use case. SUBTASKs may coordinate layers according to dependencies; the parent
TASK retains complete acceptance. Record any deliberately separate SUBTASK PRs and their order. Small bugs/chores
may be standalone TASKs with `kind: bug` or `kind: chore` and an empty `ticket` field. Do not invent an EPIC or
reopen an archived parent for unrelated work.

## Metadata and lifecycle

```yaml
---
id: TASK-00008
ticket: TICKET-00005
kind: chore
title: Migrate planning to the EPIC TICKET TASK structure
status: in-progress
order: 1
blocked_by:
pr:
---
```

TICKETs require an `epic: EPIC-NNNNN` parent. TASKs require `ticket: TICKET-NNNNN`, except standalone bugs/chores.
`blocked_by` holds comma-separated TASK IDs. **Preserve edges after completion**; only unfinished blockers affect
eligibility. `order` is an optional positive priority number, lower first; unranked records follow, with IDs used
only for deterministic tie-breaking. `pr` is an optional full PR URL, not proof of live merge state. `legacy_id`
records migrated provenance and never acts as a second identity or parent key.

| Status | Meaning |
|---|---|
| `needs-triage` | Scope or ownership is unclassified |
| `needs-info` | A decision or required evidence is missing |
| `ready-for-agent` | Decision-complete and executable when dependencies permit |
| `ready-for-human` | Human judgment or external action is next |
| `in-progress` | Implementation or revision is underway |
| `done` | Acceptance and required verification are complete |
| `wontfix` | Intentionally closed without implementation |

Blocking is derived, not a status. Mark a TASK done after accepted-scope implementation and required local
verification; independent review, hosted verification, PR, merge, release, and deployment remain separately
recorded facts. A done planning migration or historical candidate integration does not complete package adoption.

## Generated views and work routing

`tasks/BOARD.md` shows Active Work, Ready Frontier, Waiting, Needs Info, Human Action, Needs Triage, and Recently
Closed. Every section shows Order, TASK ID, Title, Parent TICKET, Status, Blocked by, and PR. Parent and blocker
cells link to records; parent labels include titles. Live and archived indexes are separate.

For an unqualified "What's next?" or `/ask-matt`, report the current human decision/question and active TASK;
otherwise report the first executable TASK in Ready Frontier. Do not start a second TASK merely because its ID
is lower. If no TASK is executable, say so and consult the Roadmap Planning Frontier and Wayfinder index for the
next planning decision. Authored priority belongs in record metadata, not edited generated rows.

`ROADMAP.md` retains strategy and milestone narrative with generated EPIC status and Planning Frontier sections.
The frontier shows non-terminal EPICs without TICKETs, TICKETs without TASKs, and parents whose children are all
terminal and need explicit closeout review. Planning operations are not fabricated executable Board rows.
Live EPICs/TICKETs have generated child tables. Historical completion prose is evidence, not a second status store.

Generated sections use `<!-- planning:NAME -->` and `<!-- /planning:NAME -->`. After source-record edits:

```sh
./bin/planning-check --write
./bin/planning-check
```

The first validates records/links and refreshes marked sections. The second is read-only and rejects stale views,
invalid IDs/parents/statuses, broken links, and dependency cycles. `./bin/build` runs only the read-only check.
Validate tooling directly; do not add product-suite tests of Markdown, wrappers, generated views, or deliberately
invalid planning fixtures. New archive indexes may be empty; their existence does not authorize archiving.

## Wayfinder

Maps chart uncertain destinations. `WF-NNN-description.md` decision tickets under `wayfinder/tickets/` are distinct
from requirement TICKETs and implementation TASKs. Research belongs in `wayfinder/research/`.

Use `_MAP_TEMPLATE.md`: Active/Closed status, destination/done condition, notes, linked decision summaries,
generated decision table, blocking relationships, one Frontier, remaining fog, and exclusions. Decisions use
`_WAYFINDER_TICKET_TEMPLATE.md` with Map, Labels, Mode, Status, and Depends on. Dependency IDs must be visible links
to decision records; use `—` when there are none. The optional local Gate field preserves external evidence conditions.

Generated map tables include all owned decisions, even closed ones, with WF ID, title, type, mode, status,
dependencies, and Gate. Authored decisions/Frontier remain authoritative. A Closed map has no frontier and links
to its implementation handoff. Index state is generated from maps. Do not invent a frontier or close a decision
because the planning hierarchy changed.

## Archive operation — explicit request only

Never archive as a completion or migration side effect. On an explicit archive request, inspect the owning tool's
dry run before applying it; do not move records by hand:

| Operation | Command shape | Destination |
|---|---|---|
| TASKs | `./bin/archive-planning tasks TASK-00001 … [--apply]` | `tasks/archive/` |
| TICKETs | `./bin/archive-planning tickets TICKET-00001 … [--apply]` | `tickets/archive/` |
| EPICs | `./bin/archive-planning epics EPIC-00001 … [--apply]` | `epics/archive/` |
| Wayfinder map | `./bin/archive-planning wayfinder map-name [--apply]` | Existing Wayfinder archive directories |

A TASK must be terminal; TICKETs additionally require all child TASKs terminal, and EPICs all child TICKETs terminal.
A map must be Closed with all decisions Closed, no frontier, and a linked implementation handoff. Moves preserve
records, repair local Markdown links outside ignored dependencies/worktrees, and refresh generated views.
Run read-only planning validation and inspect the changed links afterward. There is no active `specs` command.

## Branches and completion

For new TASK branches, use `feature/task-NNNNN-<slug>` from `develop`; never commit directly to `develop` or `main`.
Preserve established branches rather than renaming or rewriting them retroactively. Choose current checkout or
isolated worktree with the user unless already selected. TASK PR titles use `TASK-NNNNN — <TASK title>`.
Scratch belongs in gitignored `.runs/<YYYY-MM-DD>-<slug>/`; isolated worktrees belong in `.runs/worktrees/`.

Before final commit/PR:

1. Record verified TASK acceptance, warnings/limits, and outstanding independent/hosted review honestly.
2. Update parent requirement/EPIC progress and strategic narrative if affected; do not infer parent completion.
3. Record the PR URL if known and preserve dependency edges.
4. Refresh views with `./bin/planning-check --write`; verify with `./bin/planning-check`.
5. Check the execution/planning frontiers and Wayfinder continuity; no silent scope or approval changes.
6. Run `git diff --check` and the full canonical `./bin/build` before committing or creating a PR.

Publication, release certification, deployment, runtime enrollment, and archive operations remain separate.
