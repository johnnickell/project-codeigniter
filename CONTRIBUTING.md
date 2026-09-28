# Contributing

Read `AGENTS.md`, `ARCHITECTURE.md`, `planning/README.md`, `planning/CONVENTIONS.md`, and the focused local planning rules before proposing a change. Create or update one repository-local ticket, keep work to a vertical slice, update behavior documentation, and run `./bin/build` before requesting review.

For a fresh checkout, use `./bin/up` followed by `./bin/composer install`; PHP and Composer run in the repository
Docker service, so host PHP and Composer versions are not prerequisites. The host planning check requires Python 3
and Git. Keep the runtime running for `./bin/phpunit` and `./bin/build`; neither command installs dependencies.
GitHub Actions performs preparation separately and invokes the same gate. Use `./bin/down` to stop the runtime.
Do not publish tags, packages, templates, or distributions as part of a code change.

Dependency updates and compatibility exploration require deliberate maintenance work. Do not restore support
receipts, lowest/latest certification lanes, tests of gate/verifier scripts, or fake tool output fixtures as
application tests. Preserve real behavior and important package-integration outcomes; see `tests/README.md`.
The retirement decision in T-00007 supersedes the old recurring certification obligation, not its history.
