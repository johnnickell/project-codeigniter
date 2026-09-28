# AGENTS.md

Repository-local instructions are canonical. Read `ARCHITECTURE.md`, `planning/README.md`,
`planning/CONVENTIONS.md`, and applicable focused instructions in `planning/agents/` before changing behavior.

## Planning and authority

- Planning uses **EPIC → TICKET → TASK**: destination, requirements, then bounded implementation (normally one PR).
- Grilling writes an EPIC; decomposition is separate. Follow local terminology when using external skills.
- Use `planning/tasks/BOARD.md` for executable work and `planning/ROADMAP.md` for decomposition/closeout decisions.
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

## Work routing

For "What's next?" or an invocation without a task, report the current human decision/question and active TASK
from `planning/tasks/BOARD.md`; otherwise return the first executable TASK in Ready Frontier. If none is executable,
say so and consult the Roadmap Planning Frontier and Wayfinder index. Never choose by numeric ID alone or start
another TASK merely because one is listed. Requirements and open Wayfinder decisions are not implementation authority.

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
