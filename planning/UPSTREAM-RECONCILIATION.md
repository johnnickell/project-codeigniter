# Upstream reconciliation for the adoption PR

## Authority and provenance

After approving TASK-00009/00010 creation, the maintainer requested commit, push and a PR. Publication paused when
`develop` revealed overlapping legacy planning and a changed dependency lock. The maintainer then approved
preserving the upstream dependency update and carrying the quality-gate proposal into TICKET-00007, and explicitly
requested the combined branch/PR. This authorizes integration/publication, not execution of TASK-00009/00010,
policy acceptance, independent review, PR approval or merge into `develop`.

- Original branch base: `131ef163d3d780d87cce037a3c8b226a1928e7e0`.
- Pre-integration feature head: `d33e40f4edbe88e60d428b88696098a0d7151586`.
- Integrated `develop`: `1e09cb8b74dc6a882490abdc586e42b296918a6e` (PR #8).
- Incoming handoff: `91734b84179d37131650a0f51449e155b5a6a350`.
- [Original upstream T-00007](https://github.com/johnnickell/project-codeigniter/blob/91734b84179d37131650a0f51449e155b5a6a350/planning/tickets/00007-TICKET.md)
  was titled **Establish the Lean CodeIgniter Pre-Submit Quality Gate**, parent PRD-00002, status `ready-for-agent`,
  with no blockers. Its source linked Fight Common T-00087 and ADR 0026; those references are provenance, not proof
  of package release availability or current local acceptance.

## Identity collision and requirement disposition

That upstream legacy T-00007 is distinct from this branch's legacy retirement T-00007, created in `2699ceb` and
migrated to [TASK-00007](tasks/00007-TASK.md). Resolve old references by source revision, not number/path alone.
Do not falsely merge their completion claims or allocate an already-used identity. The upstream handoff is retained
as requirement input under [TICKET-00007](tickets/00007-TICKET.md), with decisions owned by
[TASK-00010](tasks/00010-TASK.md) after [TASK-00009](tasks/00009-TASK.md)'s package findings.

| Upstream requirement | Current disposition / owner |
|---|---|
| Common `^1.2`, installed `FightCommon` PHPCS standard, owned scan paths/exclusions | Package qualification under TICKET-00006; standard/version/path decisions under TICKET-00007. Not implemented by reconciliation. |
| One canonical local/hosted gate; retained Unit, Integration, Functional, frontend and browser suites each once; Composer, syntax/formatting, PHPCS, PHPStan, Deptrac and Rector dry-run | Common entrypoint retained. Applicable suites, missing tooling and nonmutating phases remain explicit TASK-00010 decisions; no new journeys are invented. |
| Direct units alone provide exact 100% owned-production statement coverage with `#[CoversClass]`; boundary/journey suites use `#[CoversNothing]` | Preserve as the upstream proposal, not adopted policy. TASK-00010 must decide applicability, denominator, driver, metadata and threshold explicitly; current gate disables coverage. |
| Native CodeIgniter boundary coverage and valuable journeys; framework types in Adapter/composition, Adapter → Application → Domain | Native layout and existing meaningful integration outcomes retained. Precise dependency enforcement remains TASK-00010 scope. |
| Replace monolithic topology and remove stock framework/receipt/profile tests that certify rather than protect owned behavior | Receipt and verifier-only tests removed by TASK-00007. Remaining scaffold/suite structure is not silently removed; disposition belongs to TASK-00010's proposal. |
| Remove candidate validation, lowest/latest lanes, receipt authorities, auxiliary locks/digests, clean production-install inspection and certification journeys from ordinary builds | Certification machinery remains retired. Meaningful integration behavior and direct safe production checks remain, without a separate no-dev installation or live-provider claims. Further distinctions require TASK-00010 decisions. |
| No product tests of build scripts, CI, configuration, coverage tooling, certification fixtures, receipts or docs; hosted CI calls the canonical gate and reports status separately | Preserve existing exclusion and single verification entrypoint. Explicit runtime/locked-dependency preparation is separate from verification. Hosted results remain separately reported. |

The upstream acceptance criteria for all quality checks, exact Unit-only coverage, coverage metadata and retained
native boundaries remain unfulfilled where noted above. They are not lost, marked done, or automatically treated
as executable policy by this migration. Human acceptance of TASK-00010's proposal precedes enforcement TASKs.

## Merge resolutions and dependency state

- Retain EPIC → TICKET → TASK source records and regenerate views. The upstream PRD-00002 reopening described
  new quality-gate scope; that unfinished scope now lives under TICKET-00007/EPIC-00002 rather than reopening the
  historically completed candidate-integration TICKET-00002.
- Keep retirement deletions for the modified receipt, lowest lock and digest. Their upstream bytes remain in Git
  history; no recurring certification obligations are restored.
- Retire the old `specs/00002-PRD.md` and `tickets/BOARD.md` paths, preserving their intent as described above.
  This is migration reconciliation, not an archive operation.
- Preserve `composer.lock` exactly from integrated `develop`, including AccessControl
  `dev-develop@7f55c0adb8fade06d03ec92212111eb6060d48ec` and its Common metadata changes. Common remains
  `dev-develop@fad24ae9fdcf4ac00fa55c59ef7d35f7c7531911`; the manifest is unchanged. This is not stable adoption.
- Install that lock explicitly into the prepared runtime before verification; do not run `composer update`.
  TASK-00009 still must qualify releases, and earlier signature samples remain historical, not new conclusions.

This integration is substantive planning/dependency reconciliation, not a claim that a prior independent review
covers it. No independent accept report exists. The PR is for review; no accepted landing or merge is claimed.
Verification and publication evidence are recorded in TASK-00008's publication follow-up and the PR.
The separate dirty legacy T-00005 worktree, its branch, unrelated containers and historical evidence are preserved.
