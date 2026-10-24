---
id: TICKET-00009
epic: EPIC-00002
title: Enforce the CodeIgniter-adapted Agent OS engineering contract
status: needs-info
---

# Enforce the CodeIgniter-adapted Agent OS engineering contract

## Problem statement

An alignment proposal and a passing current gate do not implement ownership enforcement, consistent PHP rules,
meaningful coverage or the proposed static-analysis phases. Adoption must include actual verified changes.

## Solution and boundaries

Adopt shared engineering practices by default and adapt only for demonstrated CodeIgniter/public-package needs.
Consume [TICKET-00007](00007-TICKET.md) / [TASK-00010](../tasks/00010-TASK.md)'s concrete contract and explicitly
resolve its exceptions before implementation. Preserve native `app/`, configuration/service discovery, routing,
controllers/views and Spark. Do not transplant Slim, PostgreSQL, Symfony Console or another application's
composition layout, or introduce speculative wrappers, orchestrators, routes or product features.

Implementation outcomes include direct package ownership and genuine orchestration boundaries, inward dependency
checks where applicable, clear PHP/naming rules, meaningful owned unit/integration/functional evidence and
coverage, and compatible PHPCS/PHPStan/Deptrac/Rector phases in the canonical local/hosted gate. Include the
necessary source/test changes and documentation with each enforceable outcome; do not create configuration-only
slices which leave the existing application failing its new rules.

Retain the [upstream requirements](../UPSTREAM-RECONCILIATION.md), especially exact 100% Unit-only coverage and
coverage metadata, as explicit decision inputs. Adoption by default does not silently resolve the conflict with
Agent OS's all-suite Domain/Application coverage metric. The maintainer must accept the denominator, driver,
threshold, attribution and justified exceptions before enforcement. Preserve existing required checks and
meaningful integration coverage; do not replace them with weaker defaults or meaningless percentage tests.

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
- Applicable syntax, PHPCS, PHPStan, Deptrac and Rector dry-run checks run nonmutating in the canonical gate.
- Suites protect observable contracts, rejection/failure and relevant effects; replace lost valuable evidence
  before retiring scaffold/tooling-only tests. No invented Domain/Application layers solely for coverage.
- Coverage reports actual measured results and exclusions under the explicitly accepted policy; do not count
  integration coverage as unit attribution. Run each applicable suite once per canonical gate execution.
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
implemented enforcement, distinct from TICKET-00007's proposal artifact (not yet delivered). It remains `needs-info` until
TASK-00010 provides compatible versions, coverage choices, exceptions and evidence-based vertical slices.
Package-sensitive work also depends on the qualified baseline and its actual installation under
[TICKET-00008](00008-TICKET.md); a blocked investigation does not satisfy that prerequisite.

After the maintainer accepts the contract, decompose complete enforceable outcomes combining code/tests,
configuration, documentation and checks. Do not allocate speculative implementation TASKs now. This unfinished
requirement keeps EPIC-00002 open when its investigation children complete; parent automation stays unchanged.
