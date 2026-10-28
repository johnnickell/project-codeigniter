# AGENTS.md

## Work routing

For “What's next?”, `next`, or an unqualified `/ask-matt`, go straight to the [Board](planning/tasks/BOARD.md)
before general project orientation. Read its current human decision and active work; otherwise select the first
executable ready TASK in Board order. Use the [Wayfinder index](planning/wayfinder/README.md) for map status and current frontier pointers.
Follow [lightweight work routing](planning/CONVENTIONS.md#lightweight-work-routing) for validation,
bounded evidence reads and planning handoffs. Historical publication checkpoints do not create current merge
actions or recurring post-merge planning work. Recommend and stop; load execution guidance when work is invoked.
This routing path does not require reading README, architecture, full project context, task history or receiving skills.

## Project guidance

For execution or substantive planning changes, load the applicable guidance below. The read-only routing
path above takes precedence over broad orientation reads; it does not waive engineering or delivery rules.

Repository-local instructions are canonical. Read `ARCHITECTURE.md`, `planning/README.md`,
`planning/CONVENTIONS.md`, and applicable focused instructions in `planning/agents/` before changing behavior.
For PHP, tests, composition or analysis changes, follow [maintained PHP standards](planning/agents/php-standards.md).
For installed shared Pi skills, apply the concise [target workflow binding](planning/agents/shared-workflows.md)
through provider references; resolve resources from actual session metadata/settings, not private paths.

Land owns [publication closeout](planning/CONVENTIONS.md#publication-closeout): independently accepted TASK/
current-doc closure, exact live own-PR/default/head/remote validation and eligible owned local Git/Docker/storage
retirement. Human merge and open-PR remote heads remain separate; no tracked delivery queue or recurring
post-merge bookkeeping. Planning checks stay offline; preserve historical acceptance/publication and reports.

## Planning and authority

- Planning uses **EPIC → TICKET → TASK**: destination, requirements, then bounded implementation (normally one PR).
- Grilling writes an EPIC; decomposition is separate. Follow local terminology when using external skills.
- Use `planning/tasks/BOARD.md` for executable work and `planning/ROADMAP.md` for decomposition decisions.
- Records own status, dependencies, and priority. Boards/indexes/child tables are generated; never hand-edit them.
- Preserve existing IDs, gaps, historical evidence, and completed dependency edges. `planning/MIGRATION.md` maps
  former PRDs/executable T-tickets; legacy TASK-00005 remains reserved for the separate, unmerged worktree.
- A done TASK means accepted-scope implementation and required local verification, not independent review, hosted
  verification, merge, deployment, or completion of its broader EPIC. Record those facts separately.
- Planning alignment does not prove stable package adoption; EPIC-00002 tracks remaining package/engineering work.

## Implementation boundary

Work in independently verifiable vertical TASKs with explicit scope, verification, and documentation impact.
CodeIgniter owns native configuration/discovery, HTTP, Spark, views, and future adapters; preserve `app/` layout.
Fight Common and Fight AccessControl remain public Composer dependencies. Do not copy their source or implement
login, persistence, browser journeys, distribution, or publication transitions without an approved local TASK.

Use repository-owned `./bin/composer`, `./bin/phpunit`, `./bin/up`, `./bin/down`, `./bin/exec`, and `./bin/build`.
Prepare runtime/dependencies explicitly; `./bin/build` is the complete noninteractive local/hosted gate.
Test owned behavior and important integration contracts, not planning/build tools or deliberately invalid tool
fixtures. Validate infrastructure and documentation directly with their owning tools.

## Checkout and isolation

Ask current checkout versus isolated worktree unless already chosen. New branches use
`feature/task-NNNNN-<slug>` from `develop`; never commit directly to `develop` or `main`. Preserve established
branches and unrelated work. Scratch belongs in `.runs/<YYYY-MM-DD>-<slug>/`, isolated worktrees in
`.runs/worktrees/`; both are ignored and must not be staged.

## Completion and pre-submit gate

Record verified acceptance and outstanding review in the TASK; update parent progress and strategic narrative
when affected. Preserve blockers, refresh views with `./bin/planning-check --write`, then run read-only
`./bin/planning-check`, inspect frontiers, and run `git diff --check`.

Always run `./bin/build` before committing or creating a PR. For a long noninteractive run:

```sh
screen -dmS <task>-build /bin/zsh -lc './bin/build > /private/tmp/<task>-build.log 2>&1; print -r -- $? > /private/tmp/<task>-build.exit'
```

Inspect the complete log and require an exit file containing `0`; foreground timeout output is not a build result.
Surface warnings, incomplete checks, and the distinction between local and hosted evidence.

Archive only on explicit request using `./bin/archive-planning`: review its dry run before `--apply`.
Do not archive on completion or hierarchy migration. Publishing, release, deployment, and enrollment remain
separate operations; see `planning/CONVENTIONS.md` for canonical planning and pre-PR rules.

When completing a TASK, apply [Automatic parent completion](planning/CONVENTIONS.md#automatic-parent-completion)
in the same operation; do not leave a separate parent assessment or closeout action for the user.

## Certification retirement

Test owned application behavior and meaningful package integrations. Do not create or restore framework-support
certification files, receipt readers/generators, dependency certification matrices, or tests of those mechanisms.
Validate build, configuration and planning tools directly with their owning commands, outside product suites.
Historical certification notes remain history, not current gates.
