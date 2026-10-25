---
id: TICKET-00009
epic: EPIC-00002
title: Enforce the CodeIgniter-adapted Agent OS engineering contract
status: ready-for-agent
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
| None | — | — |
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

This makes the requirement `ready-for-agent` for TASK decomposition, not done or executable implementation.
Next: decompose complete enforceable outcomes combining necessary source/tests, tool/runtime configuration,
documentation and checks. No TASKs are allocated by this recording operation; execution needs separate authority.
Coverage remains unmeasured and proposed analysis tools remain unqualified in this target. The unavailable dirty
legacy T-00005 evidence remains a limit. Existing local gate results do not prove adoption of absent tools.
This unfinished requirement keeps EPIC-00002 open; parent automation and the separate Wayfinder gates stay unchanged.
