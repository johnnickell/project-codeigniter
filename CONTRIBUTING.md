# Contributing

Read `AGENTS.md`, `ARCHITECTURE.md`, `planning/README.md`, `planning/CONVENTIONS.md`, and the focused local planning rules before proposing a change. Use EPICs for destinations, TICKETs for requirements, and TASKs for independently verifiable implementation.
Create or update the approved TASK, update behavior documentation, and run `./bin/build` before requesting review.
Record status/priority in metadata, then run `./bin/planning-check --write` and `./bin/planning-check`; do not edit
generated Board/index rows. See `planning/tasks/BOARD.md` for execution and `planning/MIGRATION.md` for old IDs.

For a fresh checkout, use `./bin/up` followed by `./bin/composer install`; PHP and Composer run in the repository
Docker service, so host PHP and Composer versions are not prerequisites. The host planning check requires Python 3
and Git. Keep the runtime running for `./bin/phpunit` and `./bin/build`; neither command installs dependencies.
GitHub Actions performs preparation separately and invokes the same gate. Use `./bin/down` to stop the runtime.
Do not publish tags, packages, templates, or distributions as part of a code change.

Dependency updates and compatibility exploration require deliberate maintenance work. Do not restore support
receipts, lowest/latest certification lanes, tests of gate/verifier scripts, or fake tool output fixtures as
application tests. Preserve real behavior and important package-integration outcomes; see `tests/README.md`.
The retirement decision in TASK-00007 supersedes the old recurring certification obligation, not its history.
It does not complete broader dependency or engineering adoption; EPIC-00002 tracks the remaining decisions.
