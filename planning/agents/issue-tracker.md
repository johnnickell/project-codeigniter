# Local planning authority

EPICs own destinations; TICKETs own requirements; TASKs own bounded implementation, normally one PR. Use
[CONVENTIONS.md](../CONVENTIONS.md) and the adjacent templates rather than another project's terminology.

Every TASK records accepted scope, public-package assumptions, affected CodeIgniter seams, validation/permissions,
verification, documentation impact, and explicit exclusions. Small bugs/chores may be standalone. Do not invent
implementation TASKs for undecided requirements or imply a dependency upgrade from planning-only changes.

Records own status, priority (`order`), parentage, and dependencies. Preserve completed blocker edges; update
records, then run `./bin/planning-check --write` and the read-only check. Generated Boards and indexes are not a
second status authority. Historical evidence remains clearly historical; done does not imply merge or publication.

Use [MIGRATION.md](../MIGRATION.md) to trace former PRD/T identities. The separate legacy T-00005 worktree is
reserved and unmerged; do not import its old certification assumptions or alter that worktree implicitly.
