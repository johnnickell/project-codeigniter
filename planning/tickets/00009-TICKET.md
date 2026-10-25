---
id: TICKET-00009
epic: EPIC-00002
title: Enforce the CodeIgniter-adapted Agent OS engineering contract
status: in-progress
---

# Enforce the CodeIgniter-adapted Agent OS engineering contract

## Problem statement

An alignment proposal and a passing current gate do not implement ownership enforcement, consistent PHP rules,
meaningful coverage or the proposed static-analysis phases. Adoption must include actual verified changes.

## Solution and boundaries

Adopt shared engineering practices by default and adapt only for demonstrated CodeIgniter/public-package needs.
Consume [TICKET-00007](00007-TICKET.md) / [TASK-00010](../tasks/00010-TASK.md)'s proposal under the maintainer's
accepted direction in [Decisions and progress](#decisions-and-progress). Document narrow, evidenced exceptions
and qualify concrete tool/configuration choices in the implementation scopes. Preserve native `app/`,
configuration/service discovery, routing, controllers/views and Spark. Do not transplant Slim, PostgreSQL, Symfony Console or another application's
composition layout, or introduce speculative wrappers, orchestrators, routes or product features.

Implementation outcomes include direct package ownership and genuine orchestration boundaries, inward dependency
checks where applicable, clear PHP/naming rules, meaningful owned unit/integration/functional evidence and
coverage, and compatible PHPCS/PHPStan/Deptrac/Rector phases in the canonical local/hosted gate. Include the
necessary source/test changes and documentation with each enforceable outcome; do not create configuration-only
slices which leave the existing application failing its new rules.

The maintainer resolved the competing [upstream coverage proposals](../UPSTREAM-RECONCILIATION.md): run the
complete test suite exactly once per canonical gate execution and collect coverage during that run. Aim for
100% coverage of meaningful owned production behavior; unit tests should cover most behavior and integration
tests may contribute. Report suite attribution honestly rather than label combined coverage as unit coverage.
This supersedes exact Unit-only 100% as the selected policy; it does not adopt a separate hard 100% gate only
for Domain/Application. Document the source inventory, justified exclusions and measured gaps. Qualify the
coverage driver and concrete configuration during implementation without adding another test run. Preserve
existing required checks and valuable integration evidence; do not create tests merely to inflate a percentage.

## Use cases

| Use case | Commands | Queries | Events | Expected side effects |
|---|---|---|---|---|
| Contributor changes owned behavior under enforceable, native-compatible standards | N/A: no new business command | Existing application contracts and quality results | N/A: no new business event | Documented standards, tooling configuration and necessary behavior-preserving code/test changes |

## Validation and permissions

Use qualified public packages and compatible tool versions. Dependency/tool preparation stays explicit;
verification must not install, update, autofix or repair the working tree. No product tests of planning/build
mechanisms, configuration wiring or deliberately invalid tool fixtures. Keep receipts/certification retired.
HTTP/authentication/authorization journeys remain with the open Wayfinder owners, not this engineering adoption.

## Acceptance and evidence

- Accepted local rules and review-only concerns are discoverable, with narrow, explained CodeIgniter exceptions.
- Fight Common's shipped PHPCS standard, PHPStan, Deptrac and Rector dry-run checks run nonmutating in the
  canonical gate alongside applicable syntax/existing checks. Inventory Fight Agent OS's existing and planned
  checks from current guidance; include applicable checks and explicitly justify adaptations, exclusions or
  deferrals. Planned checks are requirements inputs, not claims of already implemented provider capabilities.
- Suites protect observable contracts, rejection/failure and relevant effects; replace lost valuable evidence
  before retiring scaffold/tooling-only tests. No invented Domain/Application layers solely for coverage.
- Run the complete test suite exactly once per canonical gate execution, collecting coverage in that same
  invocation. Aim for 100% meaningful owned-behavior coverage, primarily from units with integration contribution
  allowed. Report actual results, source inventory, exclusions, uncovered lines and separate suite attribution;
  no extra unit-only, focused-suite or coverage pass. No measurement means incomplete evidence, not 100%.
- Explicit preparation and identical local/hosted verification entrypoints remain; required hosted policies are
  not weakened. Document warnings, gaps, tool compatibility and migration cost.

## TASKs

<!-- planning:children -->
| ID | Title | Status |
|---|---|---|
| [TASK-00015](../tasks/00015-TASK.md) | Enforce native PHP coding and architecture standards | done |
| [TASK-00016](../tasks/00016-TASK.md) | Collect meaningful coverage in one complete test run | ready-for-agent |
| [TASK-00017](../tasks/00017-TASK.md) | Enforce a complete once-only read-only build locally and in CI | ready-for-agent |
<!-- /planning:children -->

## Decisions and progress

Created by the approved [TASK-00011](../tasks/00011-TASK.md) amendment. This TICKET owns contract acceptance and
implemented enforcement, distinct from TICKET-00007's delivered
[proposal artifact](../engineering-alignment-proposal.md). Before the decision below, coverage policy, native
exceptions, tools and coordination awaited maintainer acceptance. That historical intake is superseded by the
following direction, not evidence of implemented enforcement.

### Maintainer decision — recorded 2026-10-24

The maintainer gave the following direction in the current conversation and explicitly authorized recording it
in the main checkout on a feature branch:

1. **One complete test run with combined coverage.** “Run the complete test suite one time and shoot for 100%
   coverage. Unit tests should cover most everything, but Integration tests can add to the coverage.” Collect
   coverage in that run, preserve separate attribution and report actual gaps. This is a 100% goal for meaningful
   owned behavior, not an approved exact Unit-only requirement or a newly imposed hard percentage gate.
2. **Keep CodeIgniter native.** The maintainer reaffirmed the existing decision against forcing another
   framework's layout onto this project. Native discovery/signatures and narrowly justified exceptions remain.
3. **Adopt the shared checks.** “fight-common PHPCS standards, Deptrac, PHPStan, Rector, and whatever else
   fight-agent-os runs or plans to run.” Decomposition must inventory current and planned provider checks,
   include applicable outcomes and explain anything that does not fit CodeIgniter. Concrete tool versions,
   coverage driver, analysis settings and target compatibility still require implementation evidence; this is
   not blanket acceptance of every exact candidate/version/exception in the earlier proposal.
4. **Build on completed work.** The maintainer requested clarification of coordination, not a new approval
   question. The subsequent explanation was to retain the implemented package baseline under
   [TICKET-00008](00008-TICKET.md) and shared-workflow binding under [TICKET-00010](00010-TICKET.md), without
   redoing either or adding product features. The maintainer then instructed “record it.”

This made the requirement `ready-for-agent` for TASK decomposition, not done or executable implementation.
The decision-recording operation allocated no TASKs; the subsequent approved decomposition is recorded below.
Execution needs separate authority.
At this decision's intake, coverage was unmeasured and analysis tools were unqualified. TASK-00015's current
implementation evidence below now qualifies the coding tools; coverage remains TASK-00016's unfinished outcome.
The unavailable dirty legacy T-00005 evidence remains a limit. Existing local gate results do not prove adoption of absent tools.
This unfinished requirement keeps EPIC-00002 open; parent automation and the separate Wayfinder gates stay unchanged.

### Approved TASK decomposition

The maintainer explicitly approved the three-outcome draft in the current conversation. Live and archived TASK
inventories were checked before allocating TASK-00015 through TASK-00017; reserved TASK-00005 remains untouched.
Each TASK includes necessary configuration, source/tests, documentation and direct verification in a passing
outcome, normally one PR:

1. [TASK-00015](../tasks/00015-TASK.md): enforce native PHP coding and architecture standards, including actual
   tool resolution/scans and necessary behavior-preserving fixes. Its TASK-00014 baseline dependency is already
   complete and remains recorded.
2. [TASK-00016](../tasks/00016-TASK.md): prepare coverage and deliver useful tests/reports from one complete
   suite execution, aiming for 100% with primarily unit coverage and integration contribution. No outstanding
   TASK blocker; it can be developed independently of TASK-00015. Board order prefers the tooling outcome first.
3. [TASK-00017](../tasks/00017-TASK.md): strengthen the complete once-only read-only gate and local/hosted caller
   parity, blocked by TASK-00015 and TASK-00016. Both predecessors must already pass their own canonical build;
   this is not a deferred integration rescue.

Decomposition of this accepted requirement is complete. The maintainer subsequently invoked Build for
TASK-00015 in the main checkout; it delivered locally passing coding checks on its feature branch. Its later
independent Review acceptance and applicable QA PASS are recorded in the current delivery handoff below.
TASK-00016/00017 remain unfinished. Use the TASK Board for execution
selection; do not treat this first implementation as completion of the requirement. No commit, publication
or execution authority is added by approval of this decomposition. The unrelated application Wayfinder remains
Open at WF-002 with its external proxy prerequisite unchanged.

### Existing and planned provider-check inventory

Inspected provider: Fight Agent OS at
[`9ae7681b13c7a4e9ca38218f3576fef838e5973d`](https://github.com/johnnickell/fight-agent-os/tree/9ae7681b13c7a4e9ca38218f3576fef838e5973d).
The inspected files had no local changes. Sources: its `docs/engineering/BUILD.md`, `BACKEND_TESTS.md`,
`STANDARDS.md`, `QUALITY.md`, `scripts/build.php`, and planned assessment requirements
`planning/tickets/00044-TICKET.md` / `00045-TICKET.md`. This is a bounded inventory of the canonical gate and
identified planned engineering assessments, not an audit of every provider capability. Recheck changes at
implementation and explain any additional applicable checks before claiming full alignment.

| Provider check or planned capability | Accepted CodeIgniter disposition / owner |
|---|---|
| Composer version/manifest/lock/platform checks; read-only planning | Retain existing target checks and explicit warning policy; complete phase/availability and no-registry-access behavior in TASK-00017. No dependency updates or audits hidden in acceptance. |
| PHP syntax/namespaces, installed Fight Common PHPCS, PHPStan level-7 intent, Deptrac, Rector dry-run | Implemented and locally passing through TASK-00015 and the canonical gate: actual shipped rules, level 7, native collectors plus unassigned-token rejection, one narrow Rector rule. [Versions, paths, resources and exceptions](../agents/php-standards.md) are qualified; candidate A has independent Review acceptance and applicable non-visual QA PASS. |
| One complete backend run with coverage and separate suite attribution | Implement in TASK-00016; TASK-00017 retains exactly one invocation. Adapt to the maintainer's combined 100% goal, not the provider's hard inner-layer threshold. |
| Source/index/content/mode stability on success/failure; concurrency protection; setup checks and diagnostic logs | Implement in TASK-00017 without copying provider gate source or introducing certification authorities. |
| OpenAPI/public-validation freshness | N/A for this starter: no owned exported metadata/API contract. Revisit with an approved API TASK, not by creating one here. |
| PostgreSQL identity/reset/migration/concurrency phase | Provider-specific, not transplanted. Preserve current safe SQLite transaction integration and native configuration; future persistence requirements belong to the application Wayfinder. |
| Pi presentation tests; frontend lock/runtime, TypeScript, lint/format, Vitest, production build, Storybook, browser/a11y/captures | N/A: the target does not own the provider's Pi extension/frontend/catalog source or browser journey. Shared-skill consumption does not make provider suites local product tests. Revisit if an approved owned capability requires these checks. |
| Planned AI change-quality and PHPUnit-usefulness assessments | Track as deferred upstream shared-workflow capabilities, not an installed target gate. Current review/test-quality criteria still apply. The workflow maintainer revisits integration when the provider ships qualified support; do not duplicate the service, add score gates, claim a pass, or authorize paid calls here. |
| Target governance, public Composer boundary and safe production-profile checks | Preserve target-specific checks in every rollout; they are not replaced by the provider's different application phases. |

### TASK-00015 implementation recheck — 2026-10-25

Rechecked the inventory's current provider sources at clean
[`642ba907f4c2cfbf651ffc2fafb9038f8286085d`](https://github.com/johnnickell/fight-agent-os/tree/642ba907f4c2cfbf651ffc2fafb9038f8286085d):
`BUILD.md`, `BACKEND_TESTS.md`, `STANDARDS.md`, `QUALITY.md`, `scripts/build.php` and TICKET-00044/00045.
The coding phases remain applicable and are now implemented, not only proposed. The provider's finite PHPStan
memory policy is retained as a 512M allowance, with an actual target cold peak of 172.5 MB. Native framework and
public-package boundary checks remain target-specific. Current provider infrastructure/frontend/Pi/PostgreSQL
phases and planned advisors do not change the table's N/A/deferred ownership. No paid advisor call was made;
TICKET-00044/00045 remain planned capabilities, not missing mandatory local tools.

TASK-00015 resolves 23 added dev/transitive packages without changing any of the 80 baseline package entries.
Native shared composition and all existing tests remain, with 26 tests / 130 assertions in the full gate. It adds
no coverage driver or percentage claim. TASK-00016 still owns the single coverage-producing suite execution;
TASK-00017 owns stronger orchestration/nonmutation/concurrency, and depends on both completed implementations.
This TICKET stays unfinished and EPIC-00002 stays `needs-info`. Independent acceptance, hosted checks and delivery
remain separate from TASK-00015's local implementation.

No new framework-support certification, recurring audit lane, deliberately invalid tool fixture, product test of
tooling, or provider suite is authorized. Planned assessments remain explicit deferrals; completion of the three
TASKs will not claim that those unavailable upstream services were delivered.

### Current TASK-00015 delivery handoff — 2026-10-25

Candidate A `377806f486532dd1910ed39a9a2fa98bfb7a91d4`, against reviewed base
`21b8f73420a26dad52c08fa87f09ae6be4119f96`, has independent Review acceptance and applicable non-visual
QA PASS with no findings. At the administrative-closeout checkpoint, publication and final remote-head
verification remain pending in `.runs/tasks/TASK-00015/runs/2026-10-25-land-20261025T105102-0500/receipt.md`.
TASK-00016 and TASK-00017 remain unfinished, so this TICKET stays `in-progress` and EPIC-00002 stays
`needs-info`; use the Board for the next implementation selection.
